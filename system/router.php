<?php
namespace SmallMVC;

/**
 * 
 * Class that handles all the routing on the application. Remember that
 * everything should be conventioned - your application structure must
 * comply with the following example:
 * 
 * app/
 * 	config/
 * 		config.php
 * 		database.php
 * 		(...)
 * 	myApp/
 * 		controllers/
 * 
 * All the other folders may be set in any way you like. The system file
 * path to a class should match its namespace. So imagining that I wanted
 * to store all my models under app/myApp/models, I'd call:
 * 
 * $model = new \myApp\Models\mymodel();
 * 
 * See the Loader class for further details.
 * 
 * 
 * @author diogo
 * @version 1.0
 * 
 * @todo
 * BIG TODO - currently the framework only supports one application
 * (one "main" namespace). This should urgently be revised, as the 
 * usefullness for the namespaces is severely restricted... 
 *
 */
Class Router
{
	
	protected static $app_folder;
	protected static $sys_folder;
	protected static $public_folder;
	
	private $controller;
	private $method;
	private $parameters;
	private $url;
	private $request_type;
	private $config;
	
	protected static $instance;
	
	
	/**
	 * 
	 * Gets the instance of the configuration class and
	 * sets the basic properties for the class.
	 */
	private function __construct()
	{
		
		// Initialize the configuration
		$this->config = \SmallMVC\Configuration::get_instance();
		self::$app_folder = constant('APPFOLDER');
		self::$sys_folder = constant('SYSTEMFOLDER');
		self::$public_folder = constant('PUBLICFOLDER');
	}
	
	
	/**
	 * 
	 * Gets the HTTP request type (GET, POST, PUT, DELETE)
	 * 
	 * @return String		The request type.
	 */
	public function get_request_type()
	{
		return $this->request_type;
	}
	
	
	/**
	 * 
	 * Determins what controller / method should be called
	 * and delegates the responsibility to it.
	 * 
	 * @TODO
	 * Handle the 404 erros nicelly.
	 */
	public function route()
	{
		$rest					= array('PUT', 'DELETE', 'POST', 'GET');
		$url 					= $this->set_url();
		$this->request_type		= in_array($_SERVER['REQUEST_METHOD'], $rest) ? $_SERVER['REQUEST_METHOD'] : FALSE;
		
		$this->break_url();
		$namespace	= $this->config->get_item('default_namespace');
		$controller	= "\\" . $namespace . "\\Controllers\\" . $this->controller;
		
		if(class_exists($controller)){
			$object		= new $controller($this);
			
			// Does this class implement the REST interface?
			if($this->request_type && $object instanceof \SmallMVC\Restfull){
				
				// If so, call the REST method
				call_user_func(array($object, strtolower($this->request_type)), $this->parameters);
				
			} else {
				
				// The usual method call
				call_user_func(array($object, strtolower($this->method)), $this->parameters);
				
			}
			
		} else {
			// Load 404 view
			header('HTTP/1.0 404 Not Found');
			die("The resource isn't here!");
		}
	}
	
	
	/**
	 * 
	 * Determins the controller, method and parameters to be called
	 * by the router.
	 */
	private function break_url()
	{		
		$url = $this->url;
		
		// Remove all GET information
		if(FALSE !== ($no_get = strstr($url, '?', TRUE))){
			$url = $no_get;
		}
		
		// Remove all the unnecessary info from the URL
		$url		= rtrim(str_replace($this->config->get_item('base_url'), '', $url), '/');
		$url		= str_replace('index.php/', '', $url);
		
		
		// Get all the URL chunks
		$chunks		= strlen($url) > 0 ? explode('/', $url) : FALSE;
		
		// Set the controller
		$default_controller = $this->config->get_item('default_controller');
		$this->controller = $chunks ? $chunks[0] : $default_controller;
		$this->controller = strtolower($this->controller);
		
		// Set the method
		$this->method = $chunks && count($chunks) > 1 ? $chunks[1] : 'index';
		
		// Set the parameters
		if($chunks AND count($chunks) > 2){
			$parameters = array_slice($chunks, 2);
			
			for($i = 0; $i < count($parameters); $i = $i + 2){
				$this->parameters[$parameters[$i]] = $parameters[$i + 1];
			}
		}
	}
	
	
	/**
	 * 
	 * Determins the request URL
	 * 
	 * @return string			The full URL
	 */
	private function set_url()
	{
		$url		= '';
		$ssl 		= (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on');
		
		// Get the protocol
		$protocol	= strtolower($_SERVER['SERVER_PROTOCOL']);
		$protocol	= substr($protocol, 0, strpos($protocol, "/"));
		if($ssl) $protocol .= 's';
		
		// Get the request PORT
		$port		= $_SERVER['SERVER_PORT'] == '80' ? '' : ':' . $_SERVER['SERVER_PORT'];
		
		// Set the current URL
		$this->url = $protocol . '://' . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
		
		return $this->url;
	}
	
	/**
	 * 
	 * Returns the current URI information.
	 * 
	 * @return array			An array containing the current controller, method and parameters
	 */
	public function get_uri_information()
	{
		return array($this->url, $this->controller, $this->method, $this->parameters);
	}
	
	
	/**
	 * 
	 * Redirects the user to a certain location. Must be called
	 * before any output has been sent to the browser.
	 * 
	 * @param string $to				Relative URL to the application path.
	 * @param string $header			HTTP header reply sent before redirecting.
	 */
	public function redirect($to, $header = FALSE)
	{	
		// Set header information if it was passed			
		if($header) header($header);
		
		// Redirect to the new location
		$to = trim($to, '/');
		$base_url = rtrim($this->config->get_item('base_url'), '/');
		header('Location: ' . $base_url . '/index.php/' . $to);
	}
	
	
	/**
	 * Singleton pattern. Returns the only instance
	 * of the Router that should live in the application.
	 * 
	 * @return \SmallMVC\Router
	 */
	public static function get_instance()
	{
		if(!isset(self::$instance)){
			self::$instance = new Router();
		}
		
		return self::$instance;
	}
}