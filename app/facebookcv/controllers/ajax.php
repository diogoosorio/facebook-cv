<?php
namespace FacebookCV\Controllers;

use SmallMVC\View;

use FacebookCV\Models\AjaxModel;

use FacebookCV\Libraries\FBInteract;

/**
 * This class handles all the AJAX interactions
 * of the application.
 * 
 * @author diogo
 * @version 0.1
 * @package FacebookCV
 */
class Ajax extends \SmallMVC\Controller
{
	private $logged = FALSE;
	private $model;
	
	/**
	 * Defines if the user is logged.
	 */
	public function __construct()
	{
		parent::__construct();
		$fb = new FBInteract();
		$this->logged = $fb->is_admin();
		$this->model  = new AjaxModel();
	}
	
	/**
	 * Returns the user information
	 */
	public function get_user()
	{
		$user = $this->model->get_user();
		$user = $user[0];
		$this->reply(TRUE, $user);
	}
	
	
	/**
	 * Deletes an entry of the timeline
	 */
	public function delete_timeline(){
		$result = false;
		
		if($this->logged){
			if($id = $this->security->post('id')){
				$this->model->delete_timeline($id);
				$result = true;
			}
		}
		
		$this->reply($result);
	}
	
	
	/**
	 * 
	 * A standard way to reply to an AJAX request.
	 * 
	 * @param boolean $status			Was the request action successfull?
	 * @param array $data				What data should be given back?
	 */
	private function reply($status, $data = '')
	{
		echo json_encode(array('result' => (boolean) $status, 'data' => $data));
		exit();
	}
	
	
	/**
	 * 
	 * Gets the user edit view.
	 */
	public function edit_user(){
		if($this->logged){
			if(!$this->security->post('user_email')){
				$data['user'] = $this->model->get_user();
				$data['user'] = $data['user'][0];
				
				$view = new View();
				$view->load_view('edit_user.tpl', $data);
			} else {
				$insert[':email'] 		= $this->security->post('user_email');
				$insert[':name']		= $this->security->post('user_name');
				$insert[':website']		= $this->security->post('user_website');
				$insert[':linkedin']	= $this->security->post('user_linkedin');
				$insert[':title']		= $this->security->post('user_page_title');
				$insert[':work']		= $this->security->post('user_highlight_work');
				$insert[':school']		= $this->security->post('user_highlight_school');
				$insert[':pashion']		= $this->security->post('user_highlight_pashion');
				$insert[':location']	= $this->security->post('user_highlight_location');
				
				$this->reply($this->model->edit_user($insert));
			}
		}
	}
	
	
	/**
	 * 
	 * Adds or edits a timeline entry
	 * 
	 * @param int $id			If editing, this should be the timeline ID
	 */
	public function edit_timeline($id = FALSE)
	{
		if($this->security->post('tl_title')){
			$edit[':type']			= $this->security->post('tl_type');
			$edit[':url']			= $this->security->post('tl_url');
			$edit[':thumb']			= $this->security->post('tl_thumb');
			$edit[':title']			= $this->security->post('tl_title');
			$edit[':date']			= $this->security->post('tl_date');
			$edit[':end_date']		= $this->security->post('tl_end_date');
			$edit[':desc']			= $this->security->post('tl_desc');
			$edit[':inner_desc']	= $this->security->post('tl_inner_desc');
		}
		
		$view 			= new View();
		$data['types']	= array('work', 'education', 'portfolio');
		
		if($id){	// We're editing something
			if($this->security->post('tl_title')){	// Information posted, lets update the entry
				$this->model->edit_timeline($id, $edit);
			} else {
				$data['action'] = 'editTimeline';
				$data['entry']	= $this->model->get_timeline($id);
				$view->load_view('timeline_form.tpl', $data);
			}
		} else {
			if($this->security->post('tl_title')){
				$id = $this->model->insert_timeline($edit);
				$data['entry']	= $this->model->get_timeline($id);
				$view->load_view('timeline.tpl', $data);
			} else {
				$data['action'] = 'addTimeline';
				$view->load_view('timeline_form.tpl', $data);
			}
		}
	}
	
	
	/**
	 * Load the contact form view.
	 */
	public function get_contact_form()
	{
		$data['message'] = $this->security->post('message');
		$view = new View();
		$view->load_view('message.tpl', $data);
	}
	
	
	/**
	 * Submit the contact form.
	 */
	public function submit_contact()
	{
		$name	= $this->security->post('name');
		$email	= $this->security->post('email');
		$tel	= $this->security->post('telephone');
		$mess	= $this->security->post('message');
		$from	= $this->config->get_item('default_email');
		
		
		if($name && $email && $tel && $mess){
			$user	= $this->model->get_user();
			$user	= $user[0];
			$to		= $user['user_email'];
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/plain; charset=utf-8' . "\r\n";
			$headers .= 'From: ' . $from . "\r\n";
			
			$message = "Nome: {$name}\nEmail: {$email}\nTelefone:{$tel}\nMensagem:\n{$mess}";
			mail($to, 'Novo contacto CV', $message, $headers);
			
			$this->reply(TRUE);
		} else {
			$this->reply(FALSE);
		}
	}
}