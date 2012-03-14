<?php
namespace FacebookCV\Controllers;

use SmallMVC\View;

use FacebookCV\Models\InstallModel;
use FacebookCV\Models\FrontendModel;

/**
 * 
 * Small installation script. Although it wasn't
 * thorougly tested, it should be working without any problem.
 * 
 * This file should be deleted after the installation is complete.
 * 
 * @author diogo
 * @version 0.1
 * @package FacebookCV
 */
class Install extends \SmallMVC\Controller
{
	
	/**
	 * Load the required models and compute
	 * current step.
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Show the install interface.
	 */
	public function index()
	{
		$view = new View();
		$view->load_view('install/index.tpl');
	}
	
	/**
	 * Verification that everything is OK
	 */
	public function verify()
	{
		$data = array();
		
		// Does the db config file exist?
		$this->config->get_config_file('database');
		$conf = $this->config->get_item('database');
		$data['config'] = $conf;
		
		// Can I load a model without triggering an exception?
		try{
			$model 				= new InstallModel();
			$data['db_conn']	= TRUE;
		} catch(\PDOException $e) {
			$data['db_conn']	= FALSE;
		}
		
		// Does the schema exist, or do I need to create it?
		$data['db_schema'] = $data['db_conn'] ? $model->test_schema() : FALSE;
		
		// Are the template folder writable?
		$data['compile_writable']	= is_writable(constant('APPFOLDER') . '/facebookcv/views/compiled/');
		$data['cache_writable']		= is_writable(constant('APPFOLDER') . '/facebookcv/views/cache/');
		$data['uploads_writable']	= is_writable(constant('PUBLICFOLDER') . '/images/uploads/');
		
		
		// Are the FB parameters set?
		$this->config->get_config_file('facebook');
		$data['facebook']	= $this->config->get_item('facebook');
		
		// Is everything OK?
		$data['proceed'] = !in_array(FALSE, $data);
		
		// Load the view
		$view = new View();
		$view->load_view('install/verify.tpl', $data);
	}
	
	
	/**
	 * Inserts the user into the database.
	 */
	public function add_user()
	{
		$model = new InstallModel();
		$data = $this->security->post('data');
		$model->insert_user($data);
	}
} 