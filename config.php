<?php
/**
 * File: config.php
 *
 * @copyright 2018 Vanilla
 * @author Vanilla Team
 * @version 0.1
 * @package Hackathon
 *
 */

// Main
$CHARSET 			= 'utf-8';

// Main roots
$HTTP_HOST     		= getenv( 'HTTP_HOST' );
$DOCUMENT_ROOT 		= rtrim( getenv( 'DOCUMENT_ROOT' ), '/\\' );

// Engine root
$SUB_FOLDER 		= '';

// Http paths
$CLASS_HTTP_PATH	= $SUB_FOLDER . '/class';
$TEMPLATE_HTTP_PATH	= $SUB_FOLDER . '/template';
$STATIC_HTTP_PATH	= $SUB_FOLDER . '/static';

// Static http roots
$CSS_STATIC_HTTP_PATH	= $STATIC_HTTP_PATH . '/css';
$HTML_STATIC_HTTP_PATH	= $STATIC_HTTP_PATH . '/html';
$IMG_STATIC_HTTP_PATH	= $STATIC_HTTP_PATH . '/img';
$JS_STATIC_HTTP_PATH	= $STATIC_HTTP_PATH . '/js';
$PHP_STATIC_HTTP_PATH	= $STATIC_HTTP_PATH . '/php';

// Other roots
$CLASS_FOLDER		= $DOCUMENT_ROOT . $CLASS_HTTP_PATH;
$TEMPLATE_FOLDER	= $DOCUMENT_ROOT . $TEMPLATE_HTTP_PATH;
$STATIC_FOLDER		= $DOCUMENT_ROOT . $STATIC_HTTP_PATH;

// Static roots
$CSS_STATIC_FOLDER	= $STATIC_FOLDER . '/css';
$HTML_STATIC_FOLDER	= $STATIC_FOLDER . '/html';
$IMG_STATIC_FOLDER	= $STATIC_FOLDER . '/img';
$JS_STATIC_FOLDER	= $STATIC_FOLDER . '/js';
$PHP_STATIC_FOLDER	= $STATIC_FOLDER . '/php';

// Error reporting params
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

// Log console
require_once $CLASS_FOLDER . '/Console.php';
$CONSOLE = new Console();
set_error_handler( array($CONSOLE, 'php_log') );

// Mobile
if ( isset($_COOKIE['isMobile']) ) {
	$IS_MOBILE = $_COOKIE['isMobile'];
}
else {
	include_once $CLASS_FOLDER . '/MobileDetect.php';
	$MOBILE_DETECT = new MobileDetect();
	$IS_MOBILE = $MOBILE_DETECT->isMobile();
	setcookie(
		'isMobile',
		$IS_MOBILE ? 1 : 0,
		time() + 30*24*60*60,
		'/'
	);
	unset($MOBILE_DETECT);
}

// Includes
include_once $CLASS_FOLDER . '/Router.php';
include_once $CLASS_FOLDER . '/DB.php';

// DB
$DB_HOST 		= 'localhost';
$DB_USERNAME 	= 'hackathon-18';
$DB_PASSWORD 	= 'Vanilla';
$DB_NAME 		= 'hackathon-18';
$DB = new DB($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// Session
session_start();

?>