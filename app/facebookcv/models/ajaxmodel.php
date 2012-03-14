<?php
namespace FacebookCV\Models;

class AjaxModel extends \SmallMVC\Model
{
	/* 
	 * Get the user information.
	 * 
	 * @return array
	 */
	public function get_user()
	{
		$sql = "SELECT * FROM user LIMIT 1";
		return $this->query($sql);
	}
	
	
	/**
	 * 
	 * Deletes a entry from the timeline
	 * 
	 * @param int $id		The timeline entry ID
	 */
	public function delete_timeline($id)
	{
		$sql 			= "DELETE FROM timeline WHERE tl_ID = :id";
		$params[':id']	= $id;
		return $this->query($sql, $params);
	}
	
	
	/**
	 * Edits the user table.
	 */
	public function edit_user($insert)
	{
		$sql  = "UPDATE user SET user_email = :email, user_name = :name, user_website = :website, user_linkedin = :linkedin, 
				user_page_title = :title, user_highlight_work = :work, user_highlight_school = :school, user_highlight_pashion = :pashion, 
				user_highlight_location = :location";
		
		
		return $this->query($sql, $insert);
	}
}