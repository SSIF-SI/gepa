<?php
// COSTANTI
require_once ('define.php');

// Firelog
//require_once (FRAMEWORK_CLASS_PATH . "Firelogger.class.php");

// Settings
ini_set ( 'magic_quotes_gpc', 0 );
date_default_timezone_set ( 'Europe/Rome' );

// Start Session
session_start ();

// DEBUG
ini_set ( 'display_errors', 1 );
error_reporting ( E_ALL ^ E_DEPRECATED ^ E_NOTICE );

ini_set ( 'session.gc_probability', 0 );
ini_set ( "soap.wsdl_cache_enabled", "0" );

// AUTOLOADER
require_once (FRAMEWORK_CLASS_PATH . "Utils.class.php");
spl_autoload_register ( array (
		'Utils',
		'IncludeClass' 
) );

if (isset ( $_GET ['logout'] )) {
	Session::getInstance ()->destroy ();
	Common::redirect();
}

/*
// LOGIN

require_once ("Auth.php");
$auth = new Auth ( HTTP_ROOT );
if (isset ( $_GET ['logout'] )) {
	Session::getInstance ()->destroy ();
	$auth->logout ();
}
*/
// Session::getInstance()->destroy();
//Session::getInstance ()->set ( AUTH_USER, $auth->getUser ( 'email' ) );
//Session::getInstance ()->set ( AUTH_USER, "claudio.montani@isti.cnr.it" );
// Session::getInstance ()->set ( AUTH_USER, "lucio.lelii@isti.cnr.it" );
//Session::getInstance ()->set ( AUTH_USER, "gestorePacchi@isti.cnr.it" );

// URI caching
TurnBack::setLastHttpReferer ();

// Trimming SCRIPT NAME
$self = explode ( "/", $_SERVER ['PHP_SELF'] );
$_SERVER ['SCRIPT_NAME'] = $self [count ( $self ) - 1];

$Application = new Application();

if(!Session::getInstance ()->exists(AUTH_USER)){
	require(BUSINESS_PATH."operatore.php");
	die();
}


$operatore = Personale::getInstance()->getPersonabyEmail(Session::getInstance()->get(AUTH_USER));
$operatore = Personale::getInstance()->getNominativo($operatore[Personale::ID_PERSONA]);
$operatore = "Operatore: <strong><em>$operatore</em></strong> <a href='?logout' class='btn btn-danger'>Log Out</a>";
//finfo("TurnBack Tree: %o",Session::getInstance()->get('turnbacktree'));