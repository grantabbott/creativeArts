<?php
namespace App\Http\Controllers;
use Entrust;
use Config;
use Activity;
use Auth;
use File;
use Mail;
use App\Classes\Helper;
use Illuminate\Http\Request;
use App\Http\Requests\TemplateRequest;
use App\Http\Requests\NewTemplateRequest;
use Illuminate\Http\Response;

Class TemplateController extends Controller{

	public function index(){
		$templates = Helper::getTemplate();

		foreach($templates as $key => $template){
			$filename = base_path().'/config/template/'.DOMAIN.'/'.$key;
			if(!File::exists($filename))
				File::put($filename,'');
			$content = File::get($filename);

			if($key == 'forgot_password'){
				$content = File::get(base_path().'/resources/views/emails/password.blade.php');
				$content = str_replace('{!! url(\'password/reset/\'.$token) !!}','[LINK]',$content);
				$content = str_replace('{!! $user->name !!}','[NAME]',$content);
				$content = str_replace('{!! $user->email !!}','[EMAIL]',$content);
				$content = str_replace('{!! $user->username !!}','[USERNAME]',$content);
			}
			$template_content[$key] = $content;
		}

		return view('template.index',compact('templates','template_content'));
	}

	public function copyTemplate(Request $request){
		$path = base_path().'/config/template/'.config('config.domain').'/'.$request->input('name');
		$content = '';
		if(File::exists($path))
			$content = File::get($path);

		$type = $request->input('type');
		$id = $request->input('id');

		if($type == 'ticket'){
			$ticket = \App\Ticket::find($id);
			if($ticket){
				$content = Helper::templateContent($content,$ticket);
				$title_content = Helper::templateContent(config('template.'.$request->input('name').'.title'),$ticket);
			}
		}

		$response = ['data' => $content, 'title_data' => $title_content, 'status' => 'success']; 
        return response()->json($response, 200, array('Access-Controll-Allow-Origin' => '*'));
	}

	public function create(){
		return view('template.create');
	}

	public function store(NewTemplateRequest $request){
		$template_subject = Helper::createSlug($request->input('template_subject'));
		$templates = Helper::getTemplate();
		if(array_key_exists($template_subject, $templates))
			return redirect()->back()->withErrors('This template already exists.');

		if($request->input('category') == 'user')
			$fields = 'CURRENT_DATE_TIME,CURRENT_DATE,NAME,USERNAME,EMAIL';
		elseif($request->input('category') == 'ticket')
			$fields = 'CURRENT_DATE_TIME, CURRENT_DATE, TICKET_NO, DEPARTMENT, TICKET_SUBJECT, TICKET_STATUS, TICKET_PRIORITY, TICKET_TYPE, USERNAME, NAME, EMAIL, RESPONSE_TIME, RESOLUTION_TIME';
		else
			$fields = '';

		$templates[$template_subject] = array(
				'title' => Helper::toWord($template_subject),
				'fields' => $fields,
				'category' => $request->input('category'),
				);
		$filename = base_path().'/config/template.php';
		File::put($filename,var_export($templates, true));
		File::prepend($filename,'<?php return ');
		File::append($filename, ';');

		return redirect()->back()->withSuccess('Template added.');
	}
	
	public function update(Request $request, $key){

		if(!Entrust::can('manage_template'))
			return redirect('/dashboard')->withErrors(config('constants.NA'));

        if(!Helper::getMode())
            return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));

		$templates = Helper::getTemplate();
		$templates[$key]['title'] = $request->input('template_subject');
		$filename = base_path().'/config/template/'.DOMAIN.'/'.$key;
		File::put($filename,$request->input('template_description'));

		if($key == 'forgot_password'){
			$content = $request->input('template_description');
			$filename = base_path().'/resources/views/emails/password.blade.php';
			$content = str_replace('[LINK]','{!! url(\'password/reset/\'.$token) !!}',$content);
			$content = str_replace('[NAME]','{!! $user->name !!}',$content);
			$content = str_replace('[EMAIL]','{!! $user->email !!}',$content);
			$content = str_replace('[USERNAME]','{!! $user->username !!}',$content);
			File::put($filename,$content);
		}

		$filename = base_path().'/config/template.php';
		File::put($filename,var_export($templates, true));
		File::prepend($filename,'<?php return ');
		File::append($filename, ';');

		$activity = 'Template updated';
		Activity::log($activity);
		return redirect('/template')->withSuccess(config('constants.UPDATED'));
	}

	public function destroy($key){
        if(!Helper::getMode())
            return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));

		if(!Entrust::can('manage_template'))
			return redirect('/dashboard')->withErrors(config('constants.NA'));

		$templates = Helper::getTemplate();

		if(!array_key_exists($key, $templates))
			return redirect()->back()->withErrors(config('constants.NA'));

		if($templates[$key]['category'] == 'system')
			return redirect()->back()->withErrors('This template cannot be deleted.');

		unset($templates[$key]);
		$filename = base_path().'/config/template/'.DOMAIN.'/'.$key;
		if(File::exists($filename))
		File::delete($filename);
	
		$filename = base_path().'/config/template.php';
		File::put($filename,var_export($templates, true));
		File::prepend($filename,'<?php return ');
		File::append($filename, ';');

    	return redirect()->back()->withSuccess(config('constants.DELETED'));
	}

	public function welcomeEmail($user_id,$token){

    if(!Entrust::can('send_welcome_email'))
      return redirect('/dashboard')->withErrors(config('constants.NA'));

    if(!Helper::verifyCsrf($token))
      return redirect('/dashboard')->withErrors(config('constants.CSRF'));

    $user = \App\User::find($user_id);

	$filename = base_path().'/config/template/'.DOMAIN.'/welcome_mail';
    $content = File::get($filename);

    if(!$user)
      return redirect()->back()->withErrors(config('constants.INVALID_LINK'));
    
    $content = str_replace('[NAME]',$user->name,$content);
    $content = str_replace('[EMAIL]',$user->email,$content);
    $content = str_replace('[USERNAME]',$user->username,$content);

    Mail::send('template.mail', compact('content'), function($message) use ($user){
        $message->to($user->email)->subject('Welcome');
    });

    return redirect()->back()->withSuccess('Mail send successfully.');
  }
}
?>