<?php
namespace FacebookCV\Models;

class FrontendModel extends \SmallMVC\Model
{
	/**
	 * Gets the user information
	 */
	public function get_user()
	{
		$sql = "SELECT * FROM user LIMIT 1";
		return $this->query($sql);
	}
	
	
	/**
	 * Get all timeline events of a certain kind
	 * 
	 * @param string $type				The even type to be fetched.
	 * @return array
	 */
	public function get_timeline_all($type = FALSE)
	{
		if($type){
			$sql 	= "SELECT * FROM timeline WHERE tl_type = :type ORDER BY tl_date DESC";
			$param	= array(':type' => $type);
			return $this->query($sql, $param);
		} else {
			$sql = "SELECT * FROM timeline ORDER BY tl_date DESC";
			return $this->query($sql);
		}
	}
	
	
	/**
	 * Gets all the static pages
	 * 
	 * @return array
	 */
	public function get_static_pages()
	{
		$sql = "SELECT * FROM static";
		return $this->query($sql);
	}
	
	
	public function get_years()
	{
		$sql = "SELECT DISTINCT YEAR(tl_date) FROM timeline WHERE tl_date IS NOT NULL ORDER BY tl_date DESC";
		return $this->query($sql);
	}
}