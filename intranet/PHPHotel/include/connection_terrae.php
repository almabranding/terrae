<?php
/**
* @project ApPHP Hotel Site
* @copyright (c) 2012 ApPHP
* @author ApPHP <info@apphp.com>
* @license http://www.gnu.org/licenses/
*/

@session_start();
define('APPHP_EXEC', 'access allowed');
require_once(dirname(__FILE__).'/../../config.php');
require_once(dirname(__FILE__).'/base.inc.php');
//------------------------------------------------------------------------------
require_once(dirname(__FILE__).'/shared.inc.php');
require_once(dirname(__FILE__).'/settings.inc.php');
require_once(dirname(__FILE__).'/functions.database.inc.php');
require_once(dirname(__FILE__).'/functions.common.inc.php');
require_once(dirname(__FILE__).'/functions.html.inc.php');
require_once(dirname(__FILE__).'/functions.validation.inc.php');

define('APPHP_BASE', get_base_url());

// setup connection
//------------------------------------------------------------------------------
$database_connection = @mysql_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD) or die(((SITE_MODE == 'development') ? mysql_error() : 'Fatal Error: Please check database connection parameters!'));
@mysql_select_db(DATABASE_NAME, $database_connection) or die(((SITE_MODE == 'development') ? mysql_error() : 'Fatal Error: Please check your database exists!'));
// set collation
set_collation();
// set group_concat max length
set_group_concat_max_length();
/// set sql_mode to empty if you have Mixing of GROUP columns SQL issue
///set_sql_mode();

// autoloading classes
//------------------------------------------------------------------------------


if(defined('APPHP_CONNECT') && APPHP_CONNECT == 'direct'){	
	include_once(dirname(__FILE__).'/messages.inc.php');
	
	// Set time zone
	//------------------------------------------------------------------------------
	@date_default_timezone_set(TIME_ZONE);
	
	$objSession  = new Session();
	$objLogin    = new Login();
	$objSettings = new Settings();
	Modules::Init();
	ModulesSettings::Init();
	
}else{
	// set timezone
	//------------------------------------------------------------------------------
	Settings::SetTimeZone();
	
	// create main objects
	//------------------------------------------------------------------------------
	$objSession 		= new Session();
	$objLogin 			= new Login();
	$objSettings 		= new Settings();
	$objSiteDescription = new SiteDescription();
	Modules::Init();
	ModulesSettings::Init();
	Application::Init();
	Languages::Init();
	
	// force SSL mode if defined
	//------------------------------------------------------------------------------
	$ssl_mode = $objSettings->GetParameter('ssl_mode');
	$ssl_enabled = false; 
	if($ssl_mode == '1'){
		$ssl_enabled = true; 
	}else if($ssl_mode == '2' && $objLogin->IsLoggedInAsAdmin()){
		$ssl_enabled = true; 
	}else if($ssl_mode == '3' && $objLogin->IsLoggedInAsCustomer()){
		$ssl_enabled = true; 
	}
	if($ssl_enabled && (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off')){
		header('location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		exit;
	}
	
	// include files for administrator use only
	//------------------------------------------------------------------------------
	if($objLogin->IsLoggedInAsAdmin()){
		include_once(dirname(__FILE__).'/functions.admin.inc.php');
	}
	
	// include language file
	//------------------------------------------------------------------------------
	if(!defined('APPHP_LANG_INCLUDED')){
		if(get_os_name() == 'windows'){
			$lang_file_path = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']).'include\messages.'.Application::Get('lang').'.inc.php';
		}else{
			$lang_file_path = 'include/messages.'.Application::Get('lang').'.inc.php';
		}
		if(file_exists($lang_file_path)){
			include_once($lang_file_path);
		}else if(file_exists(dirname(__FILE__).'/include/messages.inc.php')){
			include_once(dirname(__FILE__).'/include/messages.inc.php');
		}
	}	
}

// *** call handler if exists
// -----------------------------------------------------------------------------
if((Application::Get('page') != '') && file_exists(dirname(__FILE__).'/page/handlers/handler_'.Application::Get('page').'.php')){
	include_once(dirname(__FILE__).'/page/handlers/handler_'.Application::Get('page').'.php');
}else if((Application::Get('customer') != '') && file_exists(dirname(__FILE__).'/customer/handlers/handler_'.Application::Get('customer').'.php')){
	if(Modules::IsModuleInstalled('customers')){	
		include_once(dirname(__FILE__).'/customer/handlers/handler_'.Application::Get('customer').'.php');
	}
}else if((Application::Get('admin') != '') && file_exists(dirname(__FILE__).'/admin/handlers/handler_'.Application::Get('admin').'.php')){
	include_once(dirname(__FILE__).'/admin/handlers/handler_'.Application::Get('admin').'.php');
}else if((Application::Get('admin') == 'export') && file_exists(dirname(__FILE__).'/admin/downloads/export.php')){
	include_once(dirname(__FILE__).'/admin/downloads/export.php');
}

// *** get site content
// -----------------------------------------------------------------------------
if(!preg_match('/booking_notify_/i', Application::Get('page'))){	
	$cachefile = '';
	if($objSettings->GetParameter('caching_allowed') && !$objLogin->IsLoggedIn()){
		$c_page        = Application::Get('page');
		$c_page_id     = Application::Get('page_id');
		$c_system_page = Application::Get('system_page');
		$c_album_code  = Application::Get('album_code');
		$c_news_id     = Application::Get('news_id');
		$c_customer    = Application::Get('customer');
		$c_admin       = Application::Get('admin');

		if(($c_page == '' && $c_customer == '' && $c_admin == '') || 
		   ($c_page == 'pages' && $c_page_id != '') || 
		   ($c_page == 'news' && $c_news_id != '') ||
		   ($c_page == 'gallery' && $c_album_code != '')
		   )
		{	
			$cachefile = md5($c_page.'-'.
							 $c_page_id.'-'.
							 $c_system_page.'-'.
							 $c_album_code.'-'.
							 $c_news_id.'-'.
							 Application::Get('lang').'-'.
							 Application::Get('currency_code')).'.cch';	
			if($c_page == 'news' && $c_news_id != ''){
				if(!News::CacheAllowed($c_news_id)) $cachefile = '';
			}else{
				$objTempPage = new Pages((($c_system_page != '') ? $c_system_page : $c_page_id));
				if(!$objTempPage->CacheAllowed()) $cachefile = '';			
			}			
			if(start_caching($cachefile)) exit;
		}
	}
	require_once(dirname(__FILE__).'/templates/'.Application::Get('template').'/default.php');
	if($objSettings->GetParameter('caching_allowed') && !$objLogin->IsLoggedIn()) finish_caching($cachefile);
}

Application::DrawPreview();

echo "\n".'<!-- This page was generated by ApPHP Hotel Site v'.CURRENT_VERSION.' -->';
?>