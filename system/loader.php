<?php
namespace SmallMVC;

/**
 * 
 * This class sets the rules for loading all the classes
 * and configuration files used by application.
 * 
 * @author diogo
 * @package SmallMVC
 * @version 0.1
 *
 */
class Loader
{
	
	/**
	 * 
	 * Will hold the last loaded file by the 
	 * class.
	 * 
	 * @var string
	 */
	private $last_loaded_file;
	
	/**
	 * 
	 * Define the autoload function for every class
	 */
	public function __construct()
	{
		spl_autoload_register(array($this, 'load'));
	}
	
	/**
	 * 
	 * Main method of the class, defines the rules for loading
	 * classes. The namespace for the class to be loaded must
	 * match its path on the file system.
	 * 
	 * Ex. \MyApp\Controllers\Controller => app/myapp/controllers/controller.php
	 * 
	 * @param string $class_name		The class name
	 * @param boolean $strict			If true requires the file. If false, includes it
	 */
	private function load($class_name, $strict = FALSE)
	{
		// Find if the class has a namespace attached
		$has_namespace = (bool) strpos($class_name, '\\');
		$class_name = trim($class_name, '\\');
		
		if(!$has_namespace){
			
			// No namespace, set it to the system folder
			$path = constant('SYSTEMFOLDER') . '/' . strtolower($class_name) . '.php';
						
		} else {
			
			// Check if the namespace is the system namespace
			if(self::has_system_namespace($class_name) !== 0){
				
				// Load from the system folder
				$chunks = explode('\\', $class_name);
				unset($chunks[0]);
				$path = implode('/', $chunks);
				$path = constant('SYSTEMFOLDER') . '/' . strtolower($path) . '.php';
				
			} else {
				
				// Load from the app folder
				$path = constant('APPFOLDER') . '/' . strtolower(str_replace('\\', '/', $class_name)) . '.php';
				
			}
		}
		
		
		if(file_exists($path)){
			// Require or include?
			if($strict){
				require_once $path;
			} else {
				include_once $path;
			}
			
			$this->last_loaded_file = $path;
		}
	}
	
	/**
	 * 
	 * Checks if the given class name contains the system namespace.
	 * 
	 * @param string $class_name		The class name
	 */
	private static function has_system_namespace($class_name){
		return preg_match("/smallmvc/", strtolower($class_name));
	}
	
	
	/**
	 * 
	 * Returns the last loaded file
	 * 
	 * @return string
	 */
	public function get_last_loaded_file()
	{
		return isset($this->last_loaded_file) ? $this->last_loaded_file : FALSE;
	}
}