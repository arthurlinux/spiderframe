<?php

/**
  * Database Connection abstraction
  * Provides extremely useful functions for data retrieval, and other database affairs.
  * @package spiderFrame
  * 
  * @author Argel Arias <levhita@gmail.com>
  * @package ThaFrame
  * @copyright Copyright (c) 2007, Argel Arias <levhita@gmail.com>
  * @license http://opensource.org/licenses/gpl-license.php GNU Public License
  */
class DbConnection {
  
  protected static $_instances = array();
  
  protected $db_connection  = null;
  protected $db_host     = "";
  protected $db_user     = "";
  protected $db_password = "";
  protected $db_name     = "";
  protected $errors      = array();
  protected $db_instance = "";
  
  protected function __construct($db_host, $db_user, $db_password, $db_name,$db_instance)
  {
    $this->db_host     = $db_host;
    $this->db_user     = $db_user;
    $this->db_password = $db_password;
    $this->db_name     = $db_name;
    $this->db_instance = $db_instance; 
  }
  
  /**
   * Gets an instance of the the DbConnection
   * 
   * @param string $db_host
   * @param string $db_user
   * @param string $db_password
   * @param string $db_name
   * @return DbConnection
   */
  public static function getInstance($db_instance,$db_host="", $db_user="", $db_password="", $db_name="") 
  {
  	if(empty($db_host) && !isset(self::$_instances[$db_instance])) 
  	{
  	  $Config       = new Config("db_config",true);
      $db_host      = $Config->__DbConecction["db_host".$db_instance];
      $db_user      = $Config->__DbConecction["db_user".$db_instance];
      $db_password  = $Config->__DbConecction["db_password".$db_instance];
      $db_name      = $Config->__DbConecction["db_name".$db_instance];    
    }
   
    if ( !isset(self::$_instances[$db_instance]) ) {
      $DbConnection = new DbConnection($db_host, $db_user, $db_password, $db_name,$db_instance);
      $DbConnection->connect();
      $DbConnection->executeQuery("SET CHARACTER SET 'utf8'");
      self::$_instances[$db_instance]=$DbConnection;
    } 
    return self::$_instances[$db_instance];
  }
  
  public function connect()
  {
    if ( !$this->db_connection = @mysql_connect($this->db_host, $this->db_user, $this->db_password) ) {
      throw new RunTimeException("Couldn't connect to the database server");
    }
    if ( !@mysql_select_db($this->db_name, $this->db_connection) ) {
      throw new RunTimeException("Couldn't connect to the given database");
    }
  }
  
  public function getAll($sql)
  {
    if ( !$results = @mysql_query($sql, $this->db_connection) ) {
      echo "$sql";
      throw new RunTimeException("Couldn't execute query: ". mysql_error($this->db_connection) );
    }
    
    $count = 0;
    $rows  = array();
    while ( $row = mysql_fetch_assoc($results) ) {
      $rows[] = $row;
      $count++;
    }
    return ($count)?$rows:false;
  }
  
  public function getColumn($sql)
  {
    if ( !$results = @mysql_query($sql, $this->db_connection) ) {
      throw new RunTimeException("Couldn't execute query: ". mysql_error($this->db_connection) );
    }
    
    $count = 0;
    $rows  = array();
    while ( $row = mysql_fetch_array($results) ) {
      $rows[] = $row[0];
      $count++;
    }
    return ($count)?$rows:false;
  }
  
  public function getPair($sql)
  {
    if ( !$results = @mysql_query($sql, $this->db_connection) ) {
      throw new RunTimeException("Couldn't execute query: ". mysql_error($this->db_connection) );
    }
    
    $count = 0;
    $rows  = array();
    while ( $row = mysql_fetch_array($results) ) {
      $rows[$row[0]] = $row[1];
      $count++;
    }
    return ($count)?$rows:false;
  }
  
  public function getIndexed($sql)
  {
    if ( !$results = @mysql_query($sql, $this->db_connection) ) {
      throw new RunTimeException("Couldn't execute query: ". mysql_error($this->db_connection) );
    }
    
    $count = 0;
    $rows  = array();
    while ( $row = mysql_fetch_array($results) ) {
      $key=$row[0];
      $no_fields = count($row)/2;
      for($i=0;$i<$no_fields;$i++) {
        unset($row[$i]);  
      }
      $rows[$key] = $row;
      $count++;
    }
    return ($count)?$rows:false;
  }
  
  public function getRow($sql)
  {
    if ( !$results = @mysql_query($sql, $this->db_connection) ) {
      throw new RunTimeException("Couldn't execute query: ". mysql_error($this->db_connection) );
    }
    
    if ( $row = mysql_fetch_assoc($results) ) {
      return $row;
    }
    return false;
  }
  
  public function getValue($sql)
  {
    if ( !$results = @mysql_query($sql, $this->db_connection) ) {
      throw new RunTimeException("Couldn't execute query: ". mysql_error($this->db_connection) );
    }
    
    if ( $row = mysql_fetch_array($results) ) {
      return $row[0];
    }
    return false;
  }
  
  public function executeQuery($sql)
  {
    if ( !@mysql_query($sql, $this->db_connection) ) {
      $this->errors[] = mysql_error($this->db_connection);
      return false;
    }
    return true;
  }
  
  public function getErrors()
  {
    return $this->errors;
  }
  
  public function displayErrors()
  {
    echo "<pre>";
    print_r($this->errors);
    echo "</pre>";
  }
  
  public function getErrorsString()
  {
    $string="";
    foreach($this->errors AS $error){
      $string .= "$error\n";
    }
    return $string;
  }
  
  public function getLastId()
  {
    return mysql_insert_id($this->db_connection);
  }
  
  public function getCount($sql)
  {
    if ( !$results = @mysql_query($sql, $this->db_connection) ) {
      throw new RunTimeException("Couldn't execute query: ". mysql_error($this->db_connection) );
    }
    
    $count = 0;
    while ( $row = mysql_fetch_array($results) ) {
      $count++;
    }
    return $count;
  }
  
   public function getSum($sql)
  {
    if ( !$results = @mysql_query($sql, $this->db_connection) ) {
      throw new RunTimeException("Couldn't execute query: ". mysql_error($this->db_connection) );
    }
    
    $count = 0;
    while ( $row = mysql_fetch_array($results) ) {
      $count = $count + $row[0];
    }
    return $count;
  }
  
  public function getKeyRows($sql)
  {
    if ( !$results = @mysql_query($sql, $this->db_connection) ) {
      throw new RunTimeException("Couldn't execute query: ". mysql_error($this->db_connection) );
    }
    
    $count = 0;
    $rows  = array();
    while ( $row = mysql_fetch_array($results) ) {
      $rows[$row[0]] = $row;
      $count++;
    }
    return ($count)?$rows:false;
  }
  
  public function getMysqlConnection() {
    return $this->db_connection;
  }
  
  public function getInstanceName() 
  {
  	return $this->db_instance;
  }
  
  public function executeClean() {
  	/*
  	if($this->dbClean())
    {
    	return true;
    }
    */
  }
  
  private function dbClean() {
    return $this->executeQuery("DROP DATABASE `{$this->db_name}`");
  }
}