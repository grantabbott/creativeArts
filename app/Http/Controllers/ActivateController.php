<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\ResendActivationRequest;
use Auth;
use Config;
use Mail;
use App\User;

Class ActivateController extends Controller{

	public function activate($token = null){

		if(!Auth::check())
			$user = User::where('confirmation_code','=',$token)->first();
		else
			$user = Auth::user();

		if(!$user)
			return redirect('/')->withErrors('That was not a valid URL.');

		if($user->confirmed == 1)
			return redirect('/')->withErrors('Your account is already activated.');

		if($user->confirmation_code != $token)
			return redirect()->back()->withErrors('This is not a valid activation code.');

		$user->confirmed = 1;
		$user->save();

		return redirect('/')->withSuccess('Your account has been activated.');
	}

	public function resendActivation(){

		if(Auth::check() && Auth::user()->confirmed == 1)
			return redirect('/dashboard')->withErrors('Your account is already activated.');
		
		$assets = ['hide_sidebar'];
		return view('auth.resend_activation',compact('assets'));
	}

	public function doResendActivation(ResendActivationRequest $request){

		if(Auth::check())
			$user = Auth::user();
		else
			$user = User::where('email','=',$request->input('email'))->first();

		if(!$user)
			return redirect()->back()->withErrors('This email id is never registered with us.');

		if($user->confirmed == 1)
			return redirect('/')->withErrors('Your account is already activated.');

		$confirmation_code = $user->confirmation_code;
        if (empty($confirmation_code))
        {
            $key = config('app.key');
            $confirmation_code = hash_hmac('sha256', str_random(40), $key);
            $user->confirmation_code = $confirmation_code;
            $user->save();
        }

        Mail::send('emails.activate', ['token' => $confirmation_code, 'name' => $user->name], function($message) use ($user){
            $message->to($user->getEmailForPasswordReset(), $user->name)
                    ->subject('Activate your account');
        });

		return redirect()->back()->withSuccess('Activation email sent to your registered mail id.');
	}
}