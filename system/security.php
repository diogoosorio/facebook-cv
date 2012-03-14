<?php
namespace SmallMVC;

/**
 * 
 * This class handles all the basic input security filters. It
 * strips out any information submitted via PUT\POST from XSS threats.
 *   
 * @author diogo
 * @version 0.1
 * @package SmallMVC
 * @todo
 * An anti-CSRF verification would be nice. :)
 */
class Security{
	
	private $post;
	private $put;
	private $csrf_enabled = TRUE;
	
	/**
	 * 
	 * Sanitizes all the inputs and unsets the global
	 * variables.
	 */
	public function __construct()
	{		
		
		// Get PUT and POST information
		$this->put		= $_SERVER['REQUEST_METHOD'] == 'PUT' ? parse_str(file_get_contents('php://input'), $this->put) : Array();
		$this->post 	= $_POST;
		
		// Unset the global variables
		unset($_POST, $_GET);
		
		// Sanitize the input
		$this->sanitize_global();
	}
	
	/**
	 * 
	 * Disables the CSRF protection system.
	 */
	public function disable_csrf()
	{
		$this->csrf_enabled = FALSE;
	}
	
	/**
	 * 
	 * Santizes the POST and PUT parameters.
	 */
	private function sanitize_global()
	{
		if(!empty($this->post)) $this->post = self::clear_xss($this->post);
		if(!empty($this->put))	$this->put  = self::clear_xss($this->put);
	}
	
	/**
	 * 
	 * Filters the input for XSS threats.
	 * 
	 * @param mixed $input		Either a string or an array.
	 * @return mixed			A sanitized string or array.
	 */
	public static function clear_xss($input)
	{
		// Recursive function, in case we're facing an array as
		// input
		if(is_array($input)){
			foreach($input as $key => &$val){
				$val = self::clear_xss($val);
			}
		} else {
			// Some common tags/properties that should be allowed
			$allowed_tags = array('img', 'span', 'p', 'br', 'a');
			$allowed_prop = array('class', 'style', 'title', 'href');
			
			// Filter the input
			$filter = new \SmallMVC\Ext\InputFilter($allowed_tags, $allowed_prop);
			$input  = $filter->process($input);
		}
		
		return $input;
	}
	
	/**
	 * 
	 * This method should be used to retrieve POST parameters.
	 * 
	 * @param string $key
	 * @return mixed			The submitted value or FALSE if not set.
	 */
	public function post($key)
	{
		return isset($this->post[$key]) ? $this->post[$key] : FALSE;
	}
	
	/**
	 * 
	 * Retrieves PUT parameters.
	 * 
	 * @param string $key
	 * @return mixed			The inputted value or FALSE if not set
	 */
	public function put($key)
	{
		return isset($this->put[$key]) ? $this->put[$key] : FALSE;
	}
}