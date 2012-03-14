<?php
namespace SmallMVC;

session_start();

/**
 * Front-end file for the whole application. Serves as a 
 * base configuration file, where all the low level configs
 * are defined.
 * 
 * @author Diogo Osório
 * @version 0.1
 * @package smallmvc
 */


/**
 * -----------------------------------------------------------
 * APPLICATION FOLDER
 * -----------------------------------------------------------
 * Defines where your application resides. 
 */
define('APPFOLDER', 'app');


/**
 * -----------------------------------------------------------
 * SYSTEM FOLDER
 * -----------------------------------------------------------
 * Defines where the core files are located
 */
define('SYSTEMFOLDER', 'system');


/**
 * -----------------------------------------------------------
 * PUBLIC FOLDER
 * -----------------------------------------------------------
 * Defines where your public files are located (js, images, css)
 */
define('PUBLICFOLDER', 'public');

// Get the loader
require_once 'system/loader.php';
$loader = new \SmallMVC\Loader;

// Delegate any further responsability to the router
$router = \SmallMVC\Router::get_instance();
$router->route();