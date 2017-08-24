<?php
error_reporting(1);
ini_set('display_errors',1);
$protocol="http";
//
//if($_SERVER["SERVER_NAME"] == "eurocomputer.fr") {
// $uri = $_SERVER['REQUEST_URI'];
// header($_SERVER['SERVER_PROTOCOL']." 301 Moved Permanently");
// header("Location: ".$protocol."://www.eurocomputer.fr".$uri);
// exit();
//}elseif($_SERVER['HTTPS']!="on"){
//  $uri = $_SERVER['REQUEST_URI'];
//  header($_SERVER['SERVER_PROTOCOL']." 301 Moved Permanently");
//  header("Location: ".$protocol."://www.eurocomputer.fr".$uri);
//  exit();
//}
// UTC
date_default_timezone_set('Europe/Paris');


defined('PROJECT')
|| define('PROJECT','http://192.168.1.16');



// define root path
defined('ROOT_PATH')
	|| define('ROOT_PATH', __DIR__);

// define path to application directory
defined('APPLICATION_PATH')
	|| define('APPLICATION_PATH', __DIR__ . '/application');

// define path to addons
defined('ADDONS_PATH')
	|| define('ADDONS_PATH', __DIR__ . '/addons');

// Define application environment
defined('APPLICATION_ENV')
	|| define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
// set include path
set_include_path(realpath(APPLICATION_PATH . '/../library')
	. PATH_SEPARATOR . get_include_path()
	. PATH_SEPARATOR . APPLICATION_PATH . '/layouts/scripts'
	. PATH_SEPARATOR . APPLICATION_PATH . '/public/ckeditor');

require_once 'Zend/Config/Ini.php';
require_once 'Zend/Application.php';
require_once 'Zend/Session.php';
require_once 'Zend/Session.php';

// session start
Zend_Session::start();

// themes/plugins/upload paths
define('THEMES_PATH', PROJECT .'/public/themes/');
define('THEMES_ADMIN_PATH', THEMES_PATH . 'admin/');
define('THEMES_DEFAULT_PATH', THEMES_PATH . 'default/');
define('PLUGINS_PATH', ROOT_PATH . '/public/plugins/');
define('UPLOAD_PATH', ROOT_PATH . '/public/upload/');
define('TEMPLATES_PATH', THEMES_PATH . 'templates/');

// themes/plugins/upload urls
define('BASE_URL',PROJECT );
define('THEMES_URL', BASE_URL . '/themes/');
define('THEMES_ADMIN_URL', THEMES_URL . 'admin/');
define('THEMES_DEFAULT_URL', THEMES_URL . 'default/');
define('THEMES_COMINGSOON_URL', THEMES_URL . 'comingsoon/');
define('PLUGINS_URL', BASE_URL . '/plugins/');
define('UPLOAD_URL', BASE_URL . '/upload/');
define('TEMPLATES_URL', THEMES_URL . 'templates/');

//javascript - css - images
define('URL_DEFAULT_CSS', THEMES_DEFAULT_URL . 'css/');
define('URL_DEFAULT_JS', $protocol."://js.eurocomputer.fr/");
define('URL_DEFAULT_IMG',$protocol."://img.eurocomputer.fr/");
// ckeditor
define('CKEDITOR_PATH', ROOT_PATH . '/public/ckeditor/');
define('CKEDITOR_URL', BASE_URL . '/ckeditor/');

//SMTP
define('SMTP', 'smtp.blueline.mg');

// need when scan translations in php files
global $dirs_to_translate;
$dirs_to_translate = array();

// translate lang id && locale default initialization
//$sess = new Zend_Session_Namespace();	
//$sess->translate_lang_id = (!empty($sess->translate_lang_id)) ? $sess->translate_lang_id : 1;
//$sess->locale = (!empty($sess->locale)) ? $sess->locale : 'fr';

// test if we are in admin
$module_admin = false;
if(substr($_SERVER['REQUEST_URI'], 0,6)=='/admin'){
	$module_admin = true;
}

// get language from url
if (preg_match('/\/([a-z]{2})([\/].*)/', $_SERVER['REQUEST_URI'],$matches) && !$module_admin){ //if locale is found in request
    $lang = $matches[1]; //obtain locale
}else{
	$lang = 'fr';
}

// translate lang id && locale default initialization
$sess = new Zend_Session_Namespace();	
switch ($lang) {
	case 'fr':
			$sess->translate_lang_id = 1;
		break;

	case 'en':
			$sess->translate_lang_id = 2;
		break;
	case 'po':
			$sess->translate_lang_id = 3;
		break;
	default:
		# code...
		break;
}
$sess->locale = $lang;

// db prefix
define('TABLE_PREFIX', 'ec_');

class Application
{

	public static $env;
	public static $params = array(); 
	public static $db;
	public static $siteconfig = array();

	public static function bootstrap($resource = null)
	{
		include_once 'Zend/Loader/Autoloader.php';
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace('Genius_');
		$application = new Zend_Application(self::_getEnv(), self::_getConfig(), self::_setDbTranslationSiteConfig(), self::_setParams(), self::_setCKEditor());
		return $application->getBootstrap()->bootstrap($resource);
	}

	public static function run()
	{
		self::bootstrap()->run();
	}

	private static function _getEnv()
	{
		return self::$env ? : APPLICATION_ENV;
	}

	private static function _getConfig()
	{
		$env = self::_getEnv();
		$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', $env, true);
		return $config->toArray();
	}

	private static function _setDbTranslationSiteConfig()
	{ 
	
		$env = self::_getEnv();
		$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', $env, true);
		mysqli_connect($config->db->params->host, $config->db->params->username, $config->db->params->password,$config->db->params->dbname);
		// save db configs on registry
 	 	$db = Zend_Db::factory($config->db);
 	 	Zend_Db_Table::setDefaultAdapter($db);
 	 	Zend_Registry::set('db', $db);

 	 	// save db globaly
 	 	global $db;
 	 	$db = Zend_Registry::get('db');	
 	 	$db->query('SET NAMES UTF8');
 	 	self::$db = $db;

 	 	// zend translation
 	 	$data = array(
 	 		'dbAdapter'    => $db
 	 		,'tableName'   => TABLE_PREFIX.'translations_multilingual'
 	 		,'localeField' => 'language_abbreviation'
 	 		,'keyField'    => 'key'
 	 		,'valueField'  => 'value'
 	 	);

 	 	$options = array();

 	 	try{ 
 	 		$translate = new Zend_Translate('Langs_Translate_Adapter_Db', $data, 'fr', $options);
 	 		$translate->addTranslation($data, 'en', $options);

 	 		$sess = new Zend_Session_Namespace();
 	 		$locale = (!empty($sess->locale)) ? $sess->locale : 'fr';
			if ($locale != "fr" && $locale != "en") {
				$locale = "fr";
				define('DEFAULT_LANG_ABBR', "fr");
				define('DEFAULT_LANG_ID', 1); 		   		
			}else{
				define('DEFAULT_LANG_ABBR', $sess->locale);
				define('DEFAULT_LANG_ID', $sess->translate_lang_id);
			}
 		 	$translate->setLocale($locale);
 		 
 		    // Set this Translation as global translation for the view helper
 		    Zend_Registry::set('Zend_Translate', $translate);

 	 	} catch(Zend_Translate_Exception $zte){ 
 	 		echo '<h1>'. $zte->getMessage() . '</h1>' . PHP_EOL;		 
 	 	}

 	 	// save site config globaly
 	 	global $siteconfig;
 	 	$siteconfig = $db->fetchRow("SELECT * FROM ".TABLE_PREFIX."configs WHERE id=1", array(), Zend_Db::FETCH_OBJ);
 	 	self::$siteconfig = $siteconfig;

 	 	// save languages globally
			
	}

	private static function _setParams()
	{ 
		$env = self::_getEnv();
		$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', $env, true);

		// save params configs on registry
		// Zend_Registry::set('params', $config->params->toArray());
		Zend_Registry::set('params', $config->params); 	 	

		// save params globaly
		global $params;
		$params = Zend_Registry::get('params');
		self::$params = $params;		 	 
	}

	private static function _setCKEditor()
	{ 
		require_once 'ckeditor/ckeditor.php';
		global $CKEditor;
		$CKEditor = new CKEditor(); 
	}

}
