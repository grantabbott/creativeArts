<?php
namespace App\Http\Controllers;
use DB;
use File;
use Config;
use Entrust;
use App\TicketType;
use App\Department;
use App\BusinessHour;
use App\ServiceTime;
use App\Classes\Helper;
use Illuminate\Http\Request;
use App\Http\Requests\ConfigurationTimeRequest;
use App\Role;
use Validator;

Class ConfigController extends Controller{

	public function index(){
        $ticket_types = TicketType::all();
        $departments = Department::all();
        $business_hours = BusinessHour::all();
        $service_times = ServiceTime::all();
        $languages = Helper::getAllLanguages();
		$config = Helper::getConfiguration();
		$mail_config = Helper::getMail();
		$services = Helper::getServices();
		$next_ticket_no = \App\Ticket::max('ticket_no');
		$next_ticket_no = isset($next_ticket_no) ? $next_ticket_no + 1 : 1;
        $assets = ['datetimepicker','mail_config'];

        $week_days = config('list.week');
        $time_unit = config('list.time_unit');
        $priority = config('list.priority');
        $time_type = config('list.time_type');

        $roles = DB::table('roles')->get();
        $permissions = DB::table('permissions')->orderBy('category')->get();
        
        $permission_role = DB::table('permission_role')
        	->select(DB::raw('CONCAT(role_id,"-",permission_id) AS detail,id'))
        	->lists('detail','id');
        $data = [
        	'languages' => $languages,
        	'config' => $config,
        	'mail_config' => $mail_config,
        	'services' => $services,
        	'roles' => $roles,
        	'permissions' => $permissions,
        	'permission_role' => $permission_role,
        	'assets' => $assets,
        	'ticket_types' => $ticket_types,
        	'departments' => $departments,
        	'week_days' => $week_days,
        	'business_hours' => $business_hours,
        	'service_times' => $service_times,
        	'time_unit' => $time_unit,
        	'priority' => $priority,
        	'time_type' => $time_type,
        	'next_ticket_no' => $next_ticket_no,
        	'category' => null
        	];

		return view('configuration.index',$data);
	}

	public function socialLoginStore(Request $request){

		if(!Helper::getMode())
			return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));
		
		$validation = Validator::make($request->all(),[
				'facebook_client_id' => 'required_if:facebook,1',
				'facebook_client_secret' => 'required_if:facebook,1',
				'facebook_redirect' => 'required_if:facebook,1',
				'google_client_id' => 'required_if:google,1',
				'google_client_secret' => 'required_if:google,1',
				'google_redirect' => 'required_if:google,1',
				'twitter_client_id' => 'required_if:twitter,1',
				'twitter_client_secret' => 'required_if:twitter,1',
				'twitter_redirect' => 'required_if:twitter,1',
				'github_client_id' => 'required_if:github,1',
				'github_client_secret' => 'required_if:github,1',
				'github_redirect' => 'required_if:github,1'
				]);

		if($validation->fails()){
			return redirect()->back()->withInput()->withErrors($validation->messages());
		}

		$services = Helper::getServices();
		if($request->input('facebook')){
			$services['facebook']['client_id'] = $request->input('facebook_client_id');
			$services['facebook']['client_secret'] = $request->input('facebook_client_secret');
			$services['facebook']['redirect'] = $request->input('facebook_redirect');
		}
		if($request->input('google')){
			$services['google']['client_id'] = $request->input('google_client_id');
			$services['google']['client_secret'] = $request->input('google_client_secret');
			$services['google']['redirect'] = $request->input('google_redirect');
		}
		if($request->input('twitter')){
			$services['twitter']['client_id'] = $request->input('twitter_client_id');
			$services['twitter']['client_secret'] = $request->input('twitter_client_secret');
			$services['twitter']['redirect'] = $request->input('twitter_redirect');
		}
		if($request->input('github')){
			$services['github']['client_id'] = $request->input('github_client_id');
			$services['github']['client_secret'] = $request->input('github_client_secret');
			$services['github']['redirect'] = $request->input('github_redirect');
		}
		$filename = base_path().config('paths.SERVICE_PATH');
		File::put($filename,var_export($services, true));
		File::prepend($filename,'<?php return ');
		File::append($filename, ';');

		$config = Helper::getConfiguration();
		$config['facebook_login'] = ($request->input('facebook')) ? : '';
		$config['google_login'] = ($request->input('google')) ? : '';
		$config['twitter_login'] = ($request->input('twitter')) ? : '';
		$config['github_login'] = ($request->input('github')) ? : '';

		$filename = base_path().config('paths.CONFIG_PATH');
		File::put($filename,var_export($config, true));
		File::prepend($filename,'<?php return ');
		File::append($filename, ';');

		return redirect('/configuration#'.$request->input('config_type'))->withSuccess(config('constants.SAVED'));	
	}

	public function mailStore(Request $request){

		if(!Helper::getMode())
			return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));
		
		$validation = Validator::make($request->all(),[
				'from_address' => 'required|email',
				'from_name' => 'required'
				]);

		if($validation->fails()){
			return redirect()->back()->withInput()->withErrors($validation->messages());
		}
		
		$mail_config = Helper::getMail();
		$services = Helper::getServices();

		$config_type = $request->input('config_type');

		$mail_config['driver'] = $request->input('driver');
		$mail_config['from']['address'] = $request->input('from_address');
		$mail_config['from']['name'] = $request->input('from_name');

		if($request->input('driver') == 'smtp'){	
			$mail_config['host'] = $request->input('host');
			$mail_config['port'] = $request->input('port');
			$mail_config['username'] = $request->input('username');
			$mail_config['password'] = $request->input('password');
		}
		elseif($request->input('driver') == 'mandrill'){
			$services['mandrill']['secret'] = $request->input('mandrill_secret');
			$filename = base_path().config('paths.SERVICE_PATH');
			File::put($filename,var_export($services, true));
			File::prepend($filename,'<?php return ');
			File::append($filename, ';');
		}
		elseif($request->input('driver') == 'mailgun'){
			$services['mailgun']['secret'] = $request->input('mailgun_secret');
			$services['mailgun']['domain'] = $request->input('mailgun_domain');
			$filename = base_path().config('paths.SERVICE_PATH');
			File::put($filename,var_export($services, true));
			File::prepend($filename,'<?php return ');
			File::append($filename, ';');
		}
		$mail_config['encryption'] = 'tls';
		$mail_config['sendmail'] = '/usr/sbin/sendmail -bs';
		$mail_config['pretend'] = false;

		$filename = base_path().config('paths.MAIL_PATH');
		File::put($filename,var_export($mail_config, true));
		File::prepend($filename,'<?php return ');
		File::append($filename, ';');

		return redirect('/configuration#'.$config_type)->withSuccess(config('constants.SAVED'));			

	}
	
	public function savePermission(Request $request){

		if(!Helper::getMode())
			return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));
		
		$input = $request->all();
		$permissions = array_get($input, 'permission');

		if(!Entrust::hasRole('admin'))
			return redirect('/dashboard')->withErrors(config('constants.NA'));

		DB::table('permission_role')->truncate();

		if($permissions != '')
		foreach($permissions as $r_key => $permission){
			foreach($permission as $p_key => $per){
				$values[] = $p_key;
			}
			$role = Role::find($r_key);
			if(count($values))
			$role->attachPermissions($values);
			unset($values);
		}

		return redirect('/configuration#permission')->withSuccess(config('constants.UPDATED'));
	}

	public function store(Request $request){
		if(!Helper::getMode())
			return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));
		
		$config = Helper::getConfiguration();

		$config_type = $request->input('config_type');
		$input = $request->all();
		foreach($input as $key => $value){
			if($key != '_token' && $key != 'config_type')
			$config[$key] = $value;
		}

		if($request->input('next_ticket_no')){
			$max_ticket_no = \App\Ticket::max('ticket_no');
			if(isset($max_ticket_no) && $request->input('next_ticket_no') < $max_ticket_no)
				return redirect()->back()->withErrors('Next ticket number cannot be less than existing ticket number.');
		}


		$filename = base_path().config('paths.CONFIG_PATH');
		File::put($filename,var_export($config, true));
		File::prepend($filename,'<?php return ');
		File::append($filename, ';');

		return redirect('/configuration#'.$config_type)->withSuccess(config('constants.SAVED'));			
	}
}
?>