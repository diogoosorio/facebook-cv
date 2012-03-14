<?php
namespace SmallMVC;

/**
 * 
 * The configuration class stores all the configurations
 * loaded from the file system. This class implements
 * a singleton pattern, so it should only be loaded once and
 * it keeps track of what was already loaded.
 * 
 * @author diogo
 * @version 0.1
 *
 */

class Configuration 
{
	private $path;
	private $config = Array();
	private $loaded = Array();
	
	private static $instance;
	
	/**
	 * 
	 * By default retrieves the config.php file and stores
	 * its contents as a class property
	 */
	private function __construct()
	{
		$this->path = constant('APPFOLDER') . '/config/';
		$this->get_config_file('config');
	}
	
	
	/**
	 * 
	 * Includes a configuration file.
	 * 
	 * @param string $name		The configuration file name. It's convetioned that configuration
	 * 							files should reside under the app/config/ folder.
	 */
	public function get_config_file($name)
	{
		$name = strtolower($name) . '.php';
		
		if(!in_array($name, $this->loaded)){
			$this->loaded[] = $name;
			
			if(file_exists($this->path . $name)){
				include $this->path . $name;
				$this->config = array_merge($this->config, $config);
			}
		}
	}
	
	
	/**
	 * 
	 * Returns a configuration item if it's set.
	 * 
	 * @param string $name		The configuration item name
	 * @return mixed			The configuration item value of FALSE if not set
	 */
	public function get_item($name){
		return isset($this->config[$name]) ? $this->config[$name] : FALSE;
	}
	
	
	/**
	 * 
	 * Sets a configuration item value.
	 * 
	 * @param string $name		The configuration item name
	 * @param mixed $value		The configuration item value
	 */
	public function set_item($name, $value){
		$this->config[$name] = $value;
	}
	
	
	/**
	 * 
	 * Singleton pattern returns the single instance of
	 * the class that should be initialized by the application.
	 */
	public static function get_instance()
	{
		if(!isset(self::$instance)){
			self::$instance = new \SmallMVC\Configuration();
		}
		
		return self::$instance;
	}
}