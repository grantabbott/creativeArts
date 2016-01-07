<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Classes\Helper;
use File;
use App\Http\Requests\InstallRequest;

Class InstallController extends Controller{

	public function index(){
		return view('install.index');
	}

	public function store(InstallRequest $request){
		$url = "http://verify.wmlab.in/index.php?envato_username=".$request->input('envato_username')."&purchase_code=".$request->input('purchase_code')."&product=".config('constants.ITEM_CODE');
		if(!file_get_contents($url))
			return redirect()->back()->withInput()->withErrors("We can't verify you as our customer.");

		if (!is_writable('../config/database.php'))
			return redirect()->back()->withInput()->withErrors('database.php file is not writable.');
		else{
			$link = @mysqli_connect($request->input('hostname'), $request->input('mysql_username'), $request->input('mysql_password'));
			
			if (!$link)
				return redirect()->back()->withInput()->withErrors('Connection could not be established.');
			else{
					mysqli_select_db($link,$request->input('mysql_database'));
					
					if (!is_file('../database/database.sql'))
						return redirect()->back()->withInput()->withErrors('Database file not found.');
					else{
							$templine = '';
							$lines = file('../database/database.sql');
							foreach ($lines as $line)
							{
								if (substr($line, 0, 2) == '--' || $line == '')
									continue;
								$templine .= $line;
								if (substr(trim($line), -1, 1) == ';')
								{
									mysqli_query($link,$templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
									$templine = '';
								}	
							}
							
							$username = $request->input('username');
							$password = bcrypt($request->input('password'));
							$email = $request->input('email');
							
							mysqli_query($link, "insert into roles(name,display_name) values('admin','Admin'),('user','User'),('staff','Staff') ");
							mysqli_query($link, "insert into departments(department_name) values('Support')");
							mysqli_query($link, "insert into users(email,username,password,confirmed) values('$email','$username','$password','1') ");
							mysqli_query($link, "insert into profile(user_id,department_id) values('1','1') ");	
							mysqli_query($link, "insert into role_user(user_id,role_id) values('1','1') ");

							$db_file = file_get_contents('../config/database.php');
							$db_file = str_replace('%hostname%', $request->input('hostname'), $db_file);
							$db_file = str_replace('%mysql_username%', $request->input('mysql_username'), $db_file);
							$db_file = str_replace('%mysql_password%', $request->input('mysql_password'), $db_file);
							$db_file = str_replace('%mysql_database%', $request->input('mysql_database'), $db_file);
							
							file_put_contents('../config/database.php', $db_file);

							$config = Helper::getConfiguration();
							$config['installation_path'] = '0';
							$filename = base_path().config('paths.CONFIG_PATH');
							File::put($filename,var_export($config, true));
							File::prepend($filename,'<?php return ');
							File::append($filename, ';');
							
							return redirect('/')->withSuccess('Installed successfully.');
						}
					}
						
				}
			}

}
?>