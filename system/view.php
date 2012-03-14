<?php
namespace SmallMVC;

/**
 * 
 * Base class for loading a view. It utilizes the Smarty template engine
 * to render any view.
 * 
 * Be aware that the folder that will hold the template files should be already
 * structured and with the correct permissions:
 * 
 * -appviews
 * 	--templates (r)
 * 	--compiled (r+w)
 * 	--config (r)
 * 	--cache (r+w)
 * 
 * 
 * @author diogo
 * @version 0.1
 * @package SmallMVC
 */

class View{
	
	protected static $smarty;
	public static $template_dir;
	
	/**
	 * If the smarty property hasn't been set yet, load
	 * the smarty class and configure the created instance.
	 */
	public function __construct()
	{
		if(!isset(self::$smarty)){
			// Include Smarty
			require_once constant('SYSTEMFOLDER') . '/ext/smarty/smarty.php';
			self::$smarty = new \Smarty();
			
			// Define base path for smarty
			self::$smarty->setTemplateDir(self::$template_dir . 'templates');
			self::$smarty->setCompileDir(self::$template_dir . 'compiled');
			self::$smarty->setConfigDir(self::$template_dir . 'config');
			self::$smarty->setCacheDir(self::$template_dir . 'cache');
			
			// Define some basic variables for smarty
			$config = \SmallMVC\Configuration::get_instance();
			self::$smarty->assign('base_url', $config->get_item('base_url'));
			self::$smarty->assign('public_url', $config->get_item('base_url') . constant('PUBLICFOLDER') . '/');
		}		
	}

	
	/**
	 * 
	 * Loads a view.
	 * 
	 * @param string $name				The file name relative to the smarty template dir
	 * @param array $params				An array of parameters to be passed to the view
	 */
	public function load_view($name, $params = FALSE)
	{
		if($params){
			if(is_array($params)){
				foreach($params as $key => $val){
					self::$smarty->assign($key, $val);
				}
			}
		}
				
		self::$smarty->display($name);
	}
	
}