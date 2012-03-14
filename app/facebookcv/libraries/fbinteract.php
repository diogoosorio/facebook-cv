<?php
namespace FacebookCV\Libraries;

use SmallMVC\Configuration;

class FBInteract
{
	private $sdk;
	private $ajax_model;
	private $db_user;
	private $fb_user;
	private $is_admin;
	
	
	/**
	 * Checks if the user is logged in and if it is, checks
	 * for its user ID matches the admin ID.
	 */
	public function __construct()
	{
	
		// Initialize SDK
		$this->config = Configuration::get_instance();
		$this->config->get_config_file('facebook');
		$fb = $this->config->get_item('facebook');
	
		// If no Facebook is set, do no more and thorw an error
		if(!$fb){
			$this->reply(FALSE, array('error' => 'Configurações PHP não estão definidas!'));
		}
	
		// Load the ajax Model
		$this->ajax_model = new \FacebookCV\Models\AjaxModel();
	
		// Set the user
		$this->db_user = $this->ajax_model->get_user();
		$this->db_user = $this->db_user[0];
	
		// Is the current user an admin?
		$this->sdk = new \FacebookCV\Libraries\Facebook(array(
				'appId'		=> $fb['appID'],
				'secret'	=> $fb['appSecret'],
				'cookie'	=> TRUE
		));
		
		// Get the user information
		$user = $this->sdk->getUser();
		$token = $this->sdk->getAccessToken();
	
		// Define if the user is an admin
		if($user == $this->db_user['user_fb_ID']){
			try{
				$user_info = $this->sdk->api('/me?access_token=' . $token);
	
				if($this->db_user['user_fb_ID'] == $user_info['id']){
					$this->is_admin = TRUE;
					$this->fb_user = $user_info;
				}
	
			} catch(\FacebookCV\Libraries\FacebookApiException $e){}
		}
	}
	
	/**
	 * Is the current user an admin?
	 */
	public function is_admin()
	{
		return $this->is_admin;
	}
	
	/**
	 * Return the SDK
	 */
	public function get_sdk()
	{
		return $this->sdk;
	}
}