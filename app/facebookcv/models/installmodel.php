<?php 
namespace FacebookCV\Models;

use FacebookCV\Libraries\FBInteract;
use SmallMVC\Model;

class InstallModel extends Model 
{
	private $fb_interact;
	
	/* 
	 * Tests if the db schema is present.
	 */
	public function test_schema()
	{
		$sql = "SELECT * FROM user LIMIT 1";
		
		try {
			$res = $this->query($sql);
			return TRUE;
		} catch(\PDOException $e) {
			return $this->create_schema();
		}
	}
	
	
	/**
	 * Creates the DB schema
	 */
	public function create_schema()
	{
		$sql = 'CREATE TABLE IF NOT EXISTS `static` (
			  `st_ID` int(11) NOT NULL AUTO_INCREMENT,
			  `st_name` varchar(255) COLLATE utf8_bin NOT NULL,
			  `st_text` text COLLATE utf8_bin NOT NULL,
			  PRIMARY KEY (`st_ID`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1;
			
			CREATE TABLE IF NOT EXISTS `timeline` (
			  `tl_ID` int(11) NOT NULL AUTO_INCREMENT,
			  `tl_type` enum(\'work\',\'education\',\'portfolio\') COLLATE utf8_bin NOT NULL,
			  `tl_url` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			  `tl_thumb` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			  `tl_title` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			  `tl_date` date DEFAULT NULL,
			  `tl_end_date` date DEFAULT NULL,
			  `tl_main_desc` text COLLATE utf8_bin NOT NULL,
			  `tl_inner_desc` text COLLATE utf8_bin NOT NULL,
			  PRIMARY KEY (`tl_ID`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;
			
			CREATE TABLE IF NOT EXISTS `user` (
			  `user_email` varchar(255) COLLATE utf8_bin NOT NULL,
			  `user_name` varchar(255) COLLATE utf8_bin NOT NULL,
			  `user_website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			  `user_fb_ID` bigint(20) unsigned NOT NULL,
			  `user_fb_session` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			  `user_linkedin` varchar(255) COLLATE utf8_bin NOT NULL,
			  `user_page_title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT \'My Facebook\',
			  `user_last_access` datetime DEFAULT NULL,
			  `user_analytics` text COLLATE utf8_bin,
			  `user_highlight_work` varchar(255) COLLATE utf8_bin NOT NULL,
			  `user_highlight_school` varchar(255) COLLATE utf8_bin NOT NULL,
			  `user_highlight_pashion` varchar(255) COLLATE utf8_bin NOT NULL,
			  `user_highlight_location` varchar(255) COLLATE utf8_bin NOT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;			
		';
		
		return $this->query($sql);
	}
	
	
	/**
	 * Adds the user information to the DB.
	 */
	public function insert_user($data)
	{
		// Truncate the table, just to be sure
		$sql = "TRUNCATE TABLE user";
		$this->query($sql);
		
		// Get the basic user info
		$insert['id'] 		= isset($data['id']) ? $data['id'] : '';
		$insert['name']		= isset($data['name']) ? $data['name'] : '';
		$insert['email']	= isset($data['email']) ? $data['email'] : '';
		
		// Insert it to the database
		$sql = "INSERT INTO `user` (`user_email`, `user_name`, `user_fb_ID`) VALUES (:email, :name, :id)";
		$this->query($sql, $insert);
		
		// Instantiate FB Interact class
		$this->fb_interact = new FBInteract();
		
		// Parse the work (ugly)
		if(isset($data['work']) && is_array($data['work']) && count($data['work']) > 0){
			$this->parse_work($data['work']);
		}
		
		// Parse education (ugly)
		if(isset($data['education']) && is_array($data['education']) && count($data['education']) > 0){
			$this->parse_education($data['education']);
		}
	}
	
	
	/**
	 * Parse the work information retrieved from Facebook
	 * 
	 * @param array $data 
	 */
	private function parse_work($data)
	{
		// This could\should be optimized on the Model class
		$sql = "INSERT INTO timeline (tl_type, tl_date, tl_end_date, tl_title, tl_main_desc, tl_url, tl_thumb) VALUES ('work', :start, :end, :title, :inner, :url, :thumb)";
		
		// Iterate through the work history
		foreach($data as $work){
			
			// Try to retrieve the employer image / info
			$employer = $this->fetch_employer_info($work['employer']);
			
			// Prepare query
			$insert[':start']		= isset($work['start_date']) ? date('Y-m-d', strtotime($work['start_date'])) : date('Y-m-d');
			$insert[':end']			= isset($work['end_date']) ? date('Y-m-d', strtotime($work['end_date'])) : date('Y-m-d');
			$insert[':title']		= $work['employer']['name'];
			$insert[':url']			= isset($employer['url']) ? $employer['url'] : '';
			$insert[':inner']		= isset($employer['description']) ? $employer['description'] : '';
			$insert[':thumb']		= isset($employer['image']) ? $employer['image'] : 'default-work.jpg';
			
			$this->query($sql, $insert);
		}
	}
	
	
	/**
	 * 
	 * Fetches the employer information from the FB API
	 * 
	 * @param array $employer
	 */
	private function fetch_employer_info($employer){
		
		// If no ID is given, I can't do nothing!
		if(!isset($employer['id'])) return FALSE;
		
		// Get the SDK
		$sdk = $this->fb_interact->get_sdk();
		
		// Query for the ID
		$result = $sdk->api('/' . $employer['id']);
		
		$return = array();
		
		// Get what I can from the reply
		if(isset($result['company_overview'])){
			$return['description'] = $result['company_overview'];
		}
		
		if(isset($result['link'])){
			$return['url']	= $result['link'];
		}
		
		if(isset($result['picture'])){
			$result['image'] = $this->fetch_image($result['picture']);
		}
		
		return $return;
	}
	
	/**
	 * Fetches an image from a remote URL using cURL. This should
	 * be moved to a library...
	 * 
	 * @param string $url
	 */
	private function fetch_image($url)
	{
		// Define where it will be placed
		$file = substr($url, strrpos($url, '/'), strlen($url));
		$path = constant('PUBLICFOLDER') . '/images/uploads/' . $file;

		if(!file_exists($file)){
			
			// Retrieve the image
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
			$data = curl_exec($ch);
			curl_close($ch);
			
			// Write it to the file system
			$fp = fopen($path, 'w');
			
			if($fp){
				fwrite($fp, $data);
				fclose($fp);
			}
			
			return $file;
		}	
		
		return FALSE;
	}
	
	
	/**
	 * Parses the education information retrieved from Facebook
	 * 
	 * @param array $data
	 */
	private function parse_education($data)
	{
		// Query for insertion
		$sql = "INSERT INTO timeline (tl_type, tl_url, tl_thumb, tl_date, tl_title) VALUES ('education', :url, :thumb, :date, :title)";
		
		// Go
		foreach($data as $education){
			
			// Fetch its info
			$sdk  	= $this->fb_interact->get_sdk();
			$school = $sdk->api('/' . $education['school']['id']); 
			
			// Prepare the query
			$insert[':url'] 	= isset($school['website']) ? $school['website'] : 'http://www.facebook.com/' . $education['school']['id'];
			$insert[':thumb']	= isset($school['picture']) ? $this->fetch_image($school['picture']) : 'default-education	.jpg';
			$insert[':date']	= isset($education['year'][0]) ? date('Y-m-d', strtotime($education['year']['name'])) : NULL;
			$insert[':title']	= $education['school']['name'];
			
			$this->query($sql, $insert);
		}
	}
}