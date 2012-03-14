<?php
namespace SmallMVC;

/**
 * 
 * A very simple wrapper to the PHP's PDO native class. It slightly
 * simplifies the overhead of creating statements and executing queries
 * and provides a couple of helper "utilities" (like retrieving the last
 * inserted ID).
 * 
 * @author diogo
 * @version 0.1
 *
 * @todo
 * This class need to be extended. At this point I'm leaning thorwards an
 * Active Record pattern implementation, but the integration of an ORM
 * is also viable.
 */

class Model
{
	protected static $db_conn;
	private $num_rows;
	private $inserted_id;
	private $last_query;
	private $last_params;
	
	/**
	 * If the a connection to the database wasn't set, 
	 * tries to establish it.
	 * 
	 * @param string $db_name		The array key under which the db configuration for
	 * 								the current model is set.
	 *	
	 * @throws PDOException
	 * @todo 						Support Driver Options
	 */
	public function __construct($db_name = 'default')
	{
		// If the DB connection isn't set, establish one
		if(!isset(self::$db_conn)){
			
			// Get the database configuration
			$config		= \SmallMVC\Configuration::get_instance();
			$config->get_config_file('database');
			$database	= $config->get_item('database');
			
			// If all the parameters are set, connect to the database
			$db = $config->get_item('database');
			$db = $db[$db_name];
			
			// Connect to the DB
			if(isset($db['dsn'])){
				if(isset($db['user'], $db['password'])){
					self::$db_conn = new \PDO($db['dsn'], $db['user'], $db['password'], array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
				} else {
					self::$db_conn = new \PDO($db['dsn'], array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
				}
			}
		}
	}
	
	
	/**
	 * 
	 * Preforms a query using a prepared statement.
	 * 
	 * @param string $sql				The SQL command to be executed
	 * @param array $parameters			A key => val array that matches the parameters set in the SQL
	 * 									statement
	 * 
	 * @param array $driver_options		PDO driver options for the prepared statements
	 * @throws PDOException
	 */
	public function query($sql, &$parameters = FALSE, $driver_options = FALSE)
	{
		// Get the type of query
		$type 		= substr($sql, 0, strpos($sql, ' '));
		
		// Create the statement
		$stmt = $driver_options ? self::$db_conn->prepare($sql, $driver_options) : self::$db_conn->prepare($sql);
		
		// Bind the provided parameters
		if($parameters){
			foreach($parameters as $key => $val){
				$stmt->bindValue($key, $val);
			}
		}
		
		// Execute the query
		if($stmt->execute()){
			
			if(!strcmp(strtolower($type), 'select')){
				
				// If its a SELECT statement return the retrieved data as an array
				$data = $stmt->fetchAll();
				$this->num_rows = count($data);
				if($this->num_rows == 0) $data = FALSE;
				
			} elseif(!strcmp(strtolower($type), 'insert')){
				
				// If its an INSERT statement, define the inserted ID
				// WARNING: This may note give back the expected result on a concurrent app
				$this->inserted_id = self::$db_conn->lastInsertId();
				$data = TRUE;
				
			} else {
				$data = TRUE;
			}
			
		} else {
			throw new \PDOException("Couldn't execute the query.");
			$data = FALSE;
		}
		
		// Set for debugging
		$this->last_query  = $sql;
		$this->last_params = $parameters;
		 
		return $data;
	}
	
	
	/**
	 * 
	 * Return the number of rows return by the last SELECT query.
	 * 
	 * @return int
	 */
	private function num_rows()
	{
		return isset($this->num_rows) ? $this->num_rows : FALSE;
	}
	
	
	/**
	 * 
	 * Returns the last inserted ID by this object.
	 * 
	 * @return int
	 */
	private function last_insert_id()
	{
		return $this->inserted_id;
	}
	
	
	/**
	 * 
	 * Returns an array containing the last query and corresponding
	 * parameters.
	 * 
	 * @return array
	 */
	private function last_query()
	{
		return array($this->last_query, $this->last_params);
	}
}