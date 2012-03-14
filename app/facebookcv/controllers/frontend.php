<?php
namespace FacebookCV\Controllers;

/**
 * 
 * Front-end class for the application. Tests if the application
 * is installed and if it is, loads the CV. 
 * 
 * @author diogo
 * @version 0.1
 * @package FacebookCV
 */
use FacebookCV\Libraries\FBInteract;

use SmallMVC\View;

class Frontend extends \SmallMVC\Controller
{
	/**
	 * 
	 * An instance of the FrontendModel class
	 * 
	 * @var FrontendModel
	 */
	protected $model;
	
	/**
	 * 
	 * Loads the frontend model and tests if the 
	 * app is installed.
	 */
	public function __construct()
	{
		parent::__construct();
		
		// Check if the application is installed
		if(!$this->is_installed()){
			$this->router->redirect('install/index');
		}
	}
	
	/**
	 * Checks if the application is installed.
	 * 
	 * @returns boolean
	 */
	private function is_installed()
	{
		try{
			$this->model = new \FacebookCV\Models\FrontendModel();
			$user = $this->model->get_user();
			return $user;
		} catch(\PDOException $e){
			return FALSE;
		}
	}
	
	
	/**
	 * Loads the main interface.
	 */
	public function index()
	{
		
		$data['timeline']		= $this->model->get_timeline_all();
		$data['portfolio']		= $this->model->get_timeline_all('portfolio');
		$data['static']			= $this->model->get_static_pages();
		$data['years']			= $this->model->get_years();

		// Obtain user information
		$data['user']			= $this->model->get_user();
		$data['user']			= $data['user'][0];
		
		// Is the user the admin?
		$fb						= new FBInteract();
		$data['admin']			= $fb->is_admin();
		
		$view = new View();
		$view->load_view('index.tpl', $data);
	}
	
	
	/**
	 * Logs the user in via Facebook
	 */
	public function login()
	{
		// Is the user the admin?
		$fb		= new FBInteract();
		$sdk	= $fb->get_sdk();
		
		if(!$fb->is_admin()){
			
			// Get the URL and Login URL
			$url	= $this->config->get_item('base_url');
			$lUrl	= $sdk->getLoginUrl(array('redirect_uri' => $url));
			
			// Redirect the user
			header('Location: ' . $lUrl);
		}
	}
}