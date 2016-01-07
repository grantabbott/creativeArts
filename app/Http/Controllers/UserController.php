<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserProfileRequest;
use App\Http\Requests\UsernameRequest;
use App\Classes\Helper;
use App\User;
use App\Department;
use App\Role;
use Entrust;
use Auth;
use Config;
use Image;
use Activity;
use File;
use Mail;
use DB;

class UserController extends Controller
{
  protected $form = 'user-form';

  public function index(User $user, $type = null){
    
        if(!Entrust::can('manage_user'))
            return redirect('/dashboard')->withErrors(config('constants.NA'));

          $query = $user->with('roles');

          if($type != null)
          $query->whereHas('roles',function($qry) use($type){
              $qry->where('name','=',$type);
          });

          $users = $query->get();

        $col_data=array();
        $col_heads = array(
                trans('messages.Option'),
                trans('messages.Name'),
                trans('messages.Username'),
                trans('messages.Email'),
                trans('messages.Department'),
                trans('messages.Role'));

        $col_heads = Helper::putCustomHeads($this->form, $col_heads);
        $col_ids = Helper::getCustomColId($this->form);
        $values = Helper::fetchCustomValues($this->form);

        $token = csrf_token();
        foreach ($users as $user){
            foreach($user->roles as $role)
              $role_name = $role->display_name;
            $cols = array(
                    '<div class="btn-group btn-group-xs">'.
                    '<a href="/user/'.$user->id.'" class="btn btn-default btn-xs" data-toggle="tooltip" title="View"> <i class="fa fa-share"></i></a> '.
                    '<a href="/user/welcomeEmail/'.$user->id.'/'.$token.'" class="btn btn-default btn-xs" data-toggle="tooltip" title="Send Welcome Email"> <i class="fa fa-envelope"></i></a>'.
                    '<a href="/user/'.$user->id.'/edit" class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit"> <i class="fa fa-edit"></i></a> '.
                    delete_form(['user.destroy',$user->id]).
                    '</div>',
                    $user->name,
                    $user->username,
                    $user->email,
                    ($user->Profile->department_id != null) ? $user->Profile->Department->department_name : '',
                    $role_name
                    );  
              $id = $user->id;

              foreach($col_ids as $col_id)
              array_push($cols,isset($values[$id][$col_id]) ? $values[$id][$col_id] : '');
              $col_data[] = $cols;  
            }

        Helper::writeResult($col_data);

        return view('user.index',compact('col_heads'));
  }

  public function setUsername(UsernameRequest $request){
      $user = Auth::user();

      if(isset($user->username))
        return redirect()->back()->withErrors('You already have a username.');
      
      $user->username = $request->input('username');
      $user->save();

      return redirect()->back()->withSuccess(config('constants.SAVED'));
  }

  public function show(User $user){

      if(!Entrust::hasRole('admin'))
        $user = User::whereId(Auth::user()->id)->first();

      if(!$user)
        return redirect('/')->withErrors(config('constants.NA'));

      $custom_field_values = Helper::getCustomFieldValues($this->form,$user->id);
      $assets = ['hide_sidebar'];
      $profile = $user->Profile;
      $custom_field_values = Helper::getCustomFieldValues($this->form,$user->id);
      return view('user.show',compact('custom_field_values','user','profile','assets','custom_field_values'));
  }

  public function edit(User $user){
      if(!Entrust::can('edit_user'))
          return redirect('/dashboard')->withErrors(config('constants.NA'));

      if(!Helper::getMode())
          return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));

      foreach($user->roles as $role)
        $role_id = $role->id;

      $departments = Department::lists('department_name','id')->all();
      $roles = Role::lists('display_name','id')->all();
      $custom_field_values = Helper::getCustomFieldValues($this->form,$user->id);

      return view('user.edit',compact('user','departments','roles','role_id','custom_field_values'));
  }

  public function profileUpdate(UserProfileRequest $request, $id){

        if(Entrust::hasRole('admin'))
          $user = User::find($id);
        else
          $user = User::find(Auth::user()->id);

        if(!$user)
            return redirect('user')->withErrors(config('constants.INVALID_LINK'));

        if(!Helper::getMode())
            return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));

        Activity::log('Profile updated');
        $profile = $user->Profile ?: new Profile;
        $photo = $profile->photo;
        $data = $request->all();
        $profile->fill($data);

        if ($request->hasFile('photo') && $request->input('remove_photo') != 1) {
            $filename = $request->file('photo')->getClientOriginalName();
            $extension = $request->file('photo')->getClientOriginalExtension();
            $filename = uniqid();
            $file = $request->file('photo')->move('uploads/user/', $filename.".".$extension);
            $img = Image::make('uploads/user/'.$filename.".".$extension);
            $img->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save('uploads/user/'.$filename.".".$extension);
            $profile->photo = $filename.".".$extension;
        } elseif($request->input('remove_photo') == 1){
            File::delete('uploads/user/'.$profile->photo);
            $profile->photo = null;
        }
        else
        $profile->photo = $photo;

        Helper::updateCustomField($this->form,$user->id, $data);

        $user->profile()->save($profile);

        return redirect('/user/'.$id)->withSuccess(config('constants.SAVED'));
  }

  public function update(UserRequest $request, User $user){
      if(!Entrust::can('edit_user'))
          return redirect('/dashboard')->withErrors(config('constants.NA'));

        if(!Helper::getMode())
            return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));

        $profile = $user->Profile;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $profile->department_id = $request->input('department_id') ? : null;
        $roles[] = $request->input('role_id');
        $user->roles()->sync($roles);
        $user->save();
        $profile->save();

        Helper::updateCustomField($this->form,$user->id, $request->all());
      
        return redirect()->back()->withSuccess(config('constants.SAVED'));
  }

  public function changePassword(){
      $assets = ['hide_sidebar'];
      return view('auth.change_password',compact('assets'));
  }

  
  public function doChangePassword(Request $request)
  {
    if(!Helper::getMode())
        return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));

    $this->validate($request, [
            'old_password' => 'required|valid_password',
            'new_password' => 'required|confirmed|different:old_password|min:4',
            'new_password_confirmation' => 'required|different:old_password|same:new_password'
        ]);
        $credentials = $request->only(
                'new_password', 'new_password_confirmation'
        );

        $user = Auth::user();
        
        $user->password = bcrypt($credentials['new_password']);
        $user->save();
        return redirect('change_password')->withSuccess('Password has been changed.');    
  }

  public function doChangeUserPassword(Request $request, $id)
  {
    $user = User::find($id);
        
    if(!Helper::getMode())
        return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));

    if(!Entrust::can('reset_user_password'))
          return redirect('/dashboard')->withErrors(config('constants.NA'));

    $this->validate($request, [
            'new_password' => 'required|confirmed|min:4',
            'new_password_confirmation' => 'required|same:new_password'
        ]);
        $credentials = $request->only(
                'new_password', 'new_password_confirmation'
        );

        $user->password = bcrypt($credentials['new_password']);
        $user->save();
        return redirect()->back()->withSuccess('Password has been changed.');    
  }

  public function destroy(User $user){
    
        if(!Entrust::can('delete_user'))
          return redirect('/dashboard')->withErrors(config('constants.NA'));

        if(!Helper::getMode())
            return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));

        if($user->id == Auth::user()->id)
            return redirect('/user')->withErrors('You cannot delete yourself. ');

        Helper::deleteCustomField($this->form, $user->id);
        $user->delete();
        return redirect('/user')->withSuccess(config('constants.DELETED'));
  }
}