<?php

namespace App\Http\Middleware;

use Closure;
use File;
use Config;
use Auth;
use Session;
use App;
use DB;
use App\Message;

class WMLabMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $domain = 'index';
        define("DOMAIN",$domain);
        view()->share('domain',$domain);

        Config::set('services',config('service_configuration.'.DOMAIN));
        Config::set('mail',config('mail_configuration.'.DOMAIN));
        Config::set('twilio',config('twilio_configuration.'.DOMAIN));
        Config::set('config',config('configuration.'.DOMAIN));
        Config::set('page',config('page_configuration.'.DOMAIN));
        Config::set('paths.CONFIG_PATH','/config/configuration/'.$domain.'.php');
        Config::set('paths.MAIL_PATH','/config/mail_configuration/'.$domain.'.php');
        Config::set('paths.SERVICE_PATH','/config/service_configuration/'.$domain.'.php');
        Config::set('paths.PAGE_PATH','/config/page_configuration/'.$domain.'.php');
        Config::set('app.debug',config('configuration.'.$domain.'.error_display'));

        if (!File::exists(base_path().config('paths.CONFIG_PATH')))
            abort(399,config('paths.CONFIG_PATH').' file not found !!');
        if (!File::exists(base_path().'/config/constants.php'))
            abort(399,'config/constants.php file not found !!');
        if (!File::exists(base_path().'/config/paths.php'))
            abort(399,'config/paths.php file not found !!');
        if (!File::exists(base_path().config('paths.LANG_PATH')))
            abort(399,config('paths.LANG_PATH').' file not found !!');
        if (!File::exists(base_path().config('paths.LANGUAGE_PATH')))
            abort(399,config('paths.LANGUAGE_PATH').' file not found !!');
        if (!File::exists(base_path().config('paths.TIMEZONE_PATH')))
            abort(399,config('paths.TIMEZONE_PATH').' file not found !!');
        if (!File::exists(base_path().config('paths.COUNTRY_PATH')))
            abort(399,config('paths.COUNTRY_PATH').' file not found !!');
        if (!File::exists(base_path().config('paths.MAIL_PATH')))
            abort(399,config('paths.MAIL_PATH').' file not found !!');
        if (!File::exists(base_path().config('paths.TEMPLATE_PATH')))
            abort(399,config('paths.TEMPLATE_PATH').' file not found !!');
        if (!File::exists(base_path().config('paths.SERVICE_PATH')))
            abort(399,config('paths.SERVICE_PATH').' file not found !!');
        if (!File::exists(base_path().config('paths.PAGE_PATH')))
            abort(399,config('paths.PAGE_PATH').' file not found !!');

        $languages = File::getRequire(base_path().config('paths.LANG_PATH'));
        $timezones = File::getRequire(base_path().config('paths.TIMEZONE_PATH'));
        $countries = File::getRequire(base_path().config('paths.COUNTRY_PATH'));
    
        $token = csrf_token();
        $custom_field_values = array();
        $page_title = '';

        if(config('database.connections.mysql.database') != '%mysql_database%'){
            $pages = \App\Page::wherePublished(1)->where('sign_in_only','=',0)->get();
            view()->share('pages',$pages);
        }

        $default_timezone = config('configuration.'.$domain.'.timezone_id') ? $timezones[config('configuration.'.$domain.'.timezone_id')] : $timezones['266'];
        date_default_timezone_set($default_timezone);
        $share = [
            'token' => $token, 
            'timezones' => $timezones,
            'countries' => $countries,
            'languages' => $languages,
            'custom_field_values' => $custom_field_values,
            'page_title' => $page_title,
            'default_timezone' => $default_timezone
            ];
        view()->share($share);

        $direction = '';
        if (Auth::check())
        {
            $default_language = (config('configuration.'.$domain.'.default_language') != '') ? config('configuration.'.$domain.'.default_language') : 'en' ;

            $header_inbox_count = Message::where('to_user_id','=',Auth::user()->id)
                ->where('read','=',0)
                ->count();

            $header_inbox = Message::where('to_user_id','=',Auth::user()->id)
                ->join('users','users.id','=','messages.from_user_id')
                ->where('read','=',0)
                ->select(DB::raw('name,users.id as user_id,messages.created_at as time,messages.id,messages.subject'))
                ->take(5)
                ->get();

            $data = [
                'default_timezone' => $default_timezone,
                'header_inbox' => $header_inbox,
                'header_inbox_count' => $header_inbox_count,
                'default_language' => $default_language
                ];
            $language = Session::get('language',$default_language);
            App::setLocale($language);

            view()->share($data);
            $direction = config('configuration.'.$domain.'.direction');
        }
        view()->share('direction',$direction);
        $assets = array();
        view()->share('assets',$assets);


        $response = $next($request);

        return $response;
    }
}
