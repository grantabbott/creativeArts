<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/** Always accessible **/
get('/', 'DashboardController@home');
get('/pages/{slug}','PageController@view');
get('/documentation',function(){
	return view('documentation.index');
});
get('/business-hour','PageController@showBusinessHour');
get('/terms-and-conditions','PageController@showTermsAndConditions');

/** Before login **/
Route::group(['middleware' => 'guest'], function () {

	if(config('config.enable_registration'))
	get('/register', 'Auth\AuthController@getUserRegister');

	post('/user/register', 'Auth\AuthController@postUserRegister');
	get('/login', 'Auth\AuthController@getLogin');
	post('/login', 'Auth\AuthController@postLogin');
	get('/password/email', 'Auth\PasswordController@getEmail');
	post('/password/email', 'Auth\PasswordController@postEmail');
	get('/password/reset/{token}', 'Auth\PasswordController@getReset');
	post('/password/reset', 'Auth\PasswordController@postReset');

	if(config('config.installation_path'))
	resource('/install', 'InstallController',['only' => ['index', 'store']]);
	
	Route::get('/social/login/redirect/{provider}', ['uses' => 'Auth\AuthController@redirectToProvider', 'as' => 'social.login'])
		->where('provider', 'facebook|twitter|google|github');
	Route::get('/social/login/{provider}', 'Auth\AuthController@handleProviderCallback')
		->where('provider', 'facebook|twitter|google|github');

});

if(config('config.email_activation') == '1'){
	get('/resend_activation','ActivateController@resendActivation');
	post('/resend_activation','ActivateController@doResendActivation');
	get('/activate/{token}','ActivateController@activate');
}

/** After login **/
get('/logout', ['uses' => 'Auth\AuthController@getLogout', 'middleware' => 'auth']);

/** After login & Activation**/
Route::group(['middleware' => ['auth','activate']], function () {
	get('/dashboard','DashboardController@index');
	post('/dashboard',array('as' => 'dashboard.index', 'uses' => 'DashboardController@index'));

	resource('/language', 'LanguageController'); 
	get('/setLanguage/{locale}','LanguageController@setLanguage');
	post('/language/addWords',array('as'=>'language.addWords','uses'=>'LanguageController@addWords'));
	patch('/language/updateTranslation/{id}', ['as' => 'language.updateTranslation','uses' => 'LanguageController@updateTranslation']);

	Route::model('department','\App\Department');
	resource('/department', 'DepartmentController'); 
	
	Route::model('holiday','\App\Holiday');
	resource('/holiday', 'HolidayController'); 

	Route::model('page','\App\Page');
	resource('/page', 'PageController'); 
	get('/default_page','PageController@defaultPage');
	post('/default_page',array('as' => 'defaultPage','uses' => 'PageController@saveDefaultPage'));

	Route::model('comment','\App\Comment');
	resource('comment', 'CommentController',['only' => ['store','destroy']]); 
	Route::model('note','\App\Note');
	resource('note', 'NoteController',['only' => ['store','update']]); 
	Route::model('attachment','\App\Attachment');
	resource('attachment', 'AttachmentController',['only' => ['store','destroy']]); 

	get('/user/create', 'Auth\AuthController@getRegister');
	post('/auth/register', 'Auth\AuthController@postRegister');
	Route::model('user','\App\User');
	Route::resource('/user', 'UserController',['except' => ['create', 'store']]);
	get('/user/list/{type}','UserController@index');
	patch('/users/profile/{id}', ['as' => 'user.profileUpdate', 'uses' => 'UserController@profileUpdate']);
	post('/setUsername',['as' => 'user.setUsername','uses' => 'UserController@setUsername']);

	get('/message/compose', 'MessageController@compose'); 
	post('/message', ['as' => 'message.store', 'uses' => 'MessageController@store']);
	get('/message/sent','MessageController@sent'); 
	get('/message','MessageController@inbox'); 
	get('/message/view/{id}/{token}', array('as' => 'message.view', 'uses' => 'MessageController@view'));
	get('/message/{id}/delete/{token}', array('as' => 'message.delete', 'uses' => 'MessageController@delete'));
	post('/dropzone/uploadFiles', 'DashboardController@uploadFiles'); 

	Route::model('todo','\App\Todo');
	resource('/todo', 'TodoController'); 

	Route::model('annoucement','\App\Annoucement');
	resource('/annoucement', 'AnnoucementController'); 

	Route::model('custom_field','\App\CustomField');
	resource('/custom_field', 'CustomFieldController'); 
	
	Route::model('ticket_type','\App\TicketType');
	resource('/ticket_type', 'TicketTypeController'); 
	
	Route::model('business_hour','\App\BusinessHour');
	resource('/business_hour', 'BusinessHourController'); 
	
	Route::model('service_time','\App\ServiceTime');
	resource('/service_time', 'ServiceTimeController'); 
	
	Route::model('ticket','\App\Ticket');
	resource('/ticket', 'TicketController'); 
	post('/filter-ticket',['as' => 'ticket.index','uses' => 'TicketController@index']);
	get('/view-ticket/{id}','TicketController@view');
	get('/create-ticket','TicketController@createTicket');
	patch('/ticket-send-response/{id}', ['as' => 'ticket.response','uses' => 'TicketController@response']);
	
	Route::model('role','\App\Role');
	resource('/role', 'RoleController'); 
	post('/save-permission',array('as' => 'configuration.save_permission','uses' => 'ConfigController@savePermission'));

	get('/configuration', 'ConfigController@index'); 
	post('/configuration', array('as' => 'configuration.store','uses' => 'ConfigController@store')); 
	post('/mail-store', array('as' => 'configuration.mailStore','uses' => 'ConfigController@mailStore')); 
	post('/social-login-store', array('as' => 'configuration.socialLoginStore','uses' => 'ConfigController@socialLoginStore')); 
	
	resource('template', 'TemplateController'); 
	post('/temp',array('as' => 'copyTemplate','uses' => 'TemplateController@copyTemplate'));
	Route::delete('template/{key}',array('uses' => 'TemplateController@destroy', 'as' => 'template.destroy'));
	
	get('/change_password', 'UserController@changePassword');
	post('/change_password',array('as'=>'change_password','uses' =>'UserController@doChangePassword'));
	patch('/change_user_password/{id}',array('as'=>'change_user_password','uses' =>'UserController@doChangeUserPassword'));
});
