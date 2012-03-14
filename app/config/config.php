<?php
/**
 * -----------------------------------------------------------
 * AUTOLOAD SYSTEM CLASSES
 * -----------------------------------------------------------
 * What system classes should be explicitly loaded automatically?
 */
$config['autoload']['core'] = array('security');


/*
 * -----------------------------------------------------------
 * BASE URL
 * -----------------------------------------------------------
 * The application base URL
 */
$config['base_url']	= 'http://localhost/cv/trunk/';


/*
* -----------------------------------------------------------
* DEFAULT CONTROLLER
* -----------------------------------------------------------
* What controller should be loaded by default?
*/
$config['default_controller'] = 'Frontend';


/*
* -----------------------------------------------------------
* TEMPLATE FOLDER
* -----------------------------------------------------------
* What's the relative path to the root of your template folder?
*/
$config['template_root'] = 'FacebookCV/views/';

/*
* -----------------------------------------------------------
* DEFAULT NAMESPACE
* -----------------------------------------------------------
* The default namespace where your controllers, models and 
* libraries reside.
*/
$config['default_namespace'] = 'FacebookCV';

/*
* -----------------------------------------------------------
* DEFAULT EMAIL
* -----------------------------------------------------------
* The default email address through which the messages should
* be sent.
*/
$config['default_email']	= 'me@diogoosorio.com';
