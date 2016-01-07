<?php

namespace App\Http\Controllers\Auth;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Role;
use File;
use App\Department;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserRegisterRequest;
use Entrust;
use App\Profile;
use App\Classes\Helper;
use Auth;
use Config;
use Mail;
use Activity;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['getLogout','getRegister','postRegister']]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'username' => 'required|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function getUserRegister(){
        $assets = ['hide_sidebar'];
        return view('auth.register',compact('assets'));
    }

    public function getRegister()
    {
        if(!Entrust::can('create_user'))
            return redirect('/dashboard')->withErrors(config('constants.NA'));

        $departments = Department::lists('department_name','id')->all();
        
        if(Entrust::hasRole('admin'))
            $roles = Role::lists('name','id')->all();
        else
            $roles = Role::where('name','!=','admin')->lists('name','id')->all();

        return view('user.create',compact('departments','roles'));
    }

    public function postRegister(RegisterRequest $request, User $user){
        
        if(!Entrust::can('create_user'))
            return redirect('/dashboard')->withErrors(config('constants.NA'));

        $user->fill($request->all());
        $user->password = bcrypt($request->input('password'));

        $key = config('app.key');
        $user->confirmation_code = hash_hmac('sha256', str_random(40), $key);
        $user->confirmed = 1;
        $user->save();

        $profile = new Profile;
        $profile->user()->associate($user);
        $profile->department_id = ($request->input('department_id')) ? : null;
        $profile->save();
        $user->attachRole($request->input('role_id'));
        Helper::storeCustomField('user-form',$user->id, $request->all());

        $path = base_path().'/config/template/'.config('config.domain').'/new_user';
        $content = '';
        if(File::exists($path))
        $content = File::get($path);
        $content = Helper::templateContent($content,'user',$user);
        $content = str_replace('[PASSWORD]',$request->input('password'),$content);
        if($content != '' && $request->input('send_mail')){
            $title = Helper::templateContent(config('template.new_user.title'),'user',$user);
            Mail::send('template.mail', compact('content'), function($message) use ($user,$title){
                $message->to($user->email)->subject($title);
            });
        }

        $activity = Auth::user()->name.' created a User ('.$user->name.')';
        Activity::log($activity);
        return redirect()->back()->withSuccess('User created successfully. ');
    }

    public function postUserRegister(UserRegisterRequest $request, User $user){
        
        $user->fill($request->all());
        $user->password = bcrypt($request->input('password'));

        $key = config('app.key');
        $confirmation_code = hash_hmac('sha256', str_random(40), $key);
        $user->confirmation_code = $confirmation_code;
        $user->save();
        Mail::send('emails.activate', ['token' => $confirmation_code, 'name' => $user->name], function($message) use ($user){
            $message->to($user->getEmailForPasswordReset(), $user->name)
                    ->subject('Activate your account');
        });

        $profile = new Profile;
        $profile->user()->associate($user);
        $profile->save();

        $role = Role::where('name','=','user')->first();
        if($role)
        $user->attachRole($role->id);
        return redirect('/')->withSuccess('User registered successfully.');
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    
    public function handleProviderCallback($provider)
    {

        $user_detail = Socialite::driver($provider)->user();

        $data = [
            'email' => $user_detail->getEmail()
        ];

        Auth::login(User::firstOrCreate($data));

        $user = Auth::user();
        $user->name = ($user->name) ? : $user_detail->getName();
        $user->username = ($user->username) ? : null;
        $user->confirmed = 1;
        $user->provider = $provider;
        $user->save();

        $profile = $user->Profile ?: new Profile;
        $profile->user()->associate($user);
        $profile->save();

        if(!count($user->roles)){
            $role = Role::where('name','=','user')->first();
            if($role)
            $user->attachRole($role->id);
        }

        return redirect($this->redirectPath());
    }
    
    protected $username = 'username';
    protected $redirectPath = '/';
    protected $loginPath = '/';
}
