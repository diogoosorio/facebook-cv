<?php
namespace SmallMVC;

/**
 * 
 * Base class for all controllers. It basically loads all the
 * framework components and defines some common methods for all
 * the controllers
 * 
 * @author diogo
 * @version 0.1
 * @package SmallMVC
 *
 */
class Controller
{
	
	protected $config;
	protected $loader;
	protected $router;
	
	
	public function __construct()
	{
		$this->config = \SmallMVC\Configuration::get_instance();
		$this->loader = new \SmallMVC\Loader;
		$this->router = \SmallMVC\Router::get_instance();
		$this->autoload();
		
		\SmallMVC\View::$template_dir = strtolower(constant('APPFOLDER') . '/' . $this->config->get_item('template_root'));
	}
	
	
	/**
	 * 
	 * Creates an instance of every class defined on the autoload
	 * class and sets the instance as a controller property.
	 */
	private function autoload()
	{
		$autoload	= $this->config->get_item('autoload');
		$core		= $autoload['core'];
		
		if(!empty($core)){
			foreach($core as $class){
				$path = "\\SmallMVC\\" . $class;
				$this->{$class} = new $path;
			}
		}
	}
}