<?php

/**
 * Provides a database abstraction of a Row, simplyfing data access and modification
 * Holds the {@link Row} model
 * @package spiderFrame
 * @author Levhita <levhita@gmail.com>
 * @author Ismael Cortés <may.estilosfrescos@gmail.com>
 * @copyright Copyright (c) 2010, Ismael Cortés <may.estilosfrescos@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package spiderFrame
 */
class Row {
  
  protected $table_name   = "";
  protected $id_field     = "";
  protected $id           = 0;
  public    $data         = array();
  public	$package  	  = array();
  protected $loaded       = false;
  protected	$loadedPackage= false;
  protected static $_instances = array(); 
  
  /**
   * Holds the DbConnection
   *
   * @var DbConnection
   */
  protected $DbConnection   = null;
  protected $assert_message = "Class instance isn't loaded";
  protected $full_string    = "<div class=\"{%table_name}\" id=\"{%table_name}{%id}\">\n{%content}\n</div>\n\n";
   
  public function __construct($table_name, $id, DbConnection $DbConnection = null) 
  {
    if ( !isset($DbConnection) ) {
      $DbConnection = DbConnection::getInstance("_root");
    }
    
    if (!is_string($table_name)) {
      throw new InvalidArgumentException("table_name isn't an string");
    }
    
    if (!is_integer($id)) {
      throw new InvalidArgumentException("id isn't an integer");
    }
    
    if (get_class($DbConnection)!== 'DbConnection') {
      throw new InvalidArgumentException("DbConnection isn't a DbConnection");
    }
    
    $this->table_name   = $table_name;
    $this->id           = $id;
    $this->id_field     = $table_name . "_id";
    $this->DbConnection = $DbConnection;
  }
	
  public static function getInstance($table_name, $id, DbConnection $DbConnection = null)
  {
     return self::__getInstance($table_name, $id, $DbConnection);
  }
   
/** Fix this function **/
  public static function getNewInstance($table_name, $id, DbConnection $DbConnection = null)
  {
     $Row = new Row($table_name, (int)$id, $DbConnection);
  	 return $Row ;
  }
  
  private static function __getInstance($table_name, $id, DbConnection $DbConnection = null)
  {
    if ( !isset(self::$_instances[$table_name][$id]) ) 
    {
      $Row = new Row($table_name, (int)$id, $DbConnection);
      self::$_instances[$table_name][$id] = $Row;
    } 
    return self::$_instances[$table_name][$id];
  }
  
  public function setInstance(Row $Row)
  {
  	  self::$_instances[$table_name][$id] = $Row;
  }
 
  public function getStructure() 
  {
    $structure = $this->DbConnection->getAll("DESCRIBE $this->table_name;");
    return $structure;
  }
  
  public function getTableStructure() 
  {
    $fields = $this->DbConnection->getAll("DESCRIBE $this->table_name;");
    foreach ($fields AS $field){
    	$name = $field['Field'];
    	$structure[$name]=$field;
    }
    return $structure;
  }
  
  public function getTableName()
  {
   return $this->table_name;
  }
  
  public function getDbInstanceName()
  {
   return $this->DbConnection->getInstanceName();
  }
  
  
  public function getIdField()
  {
   return $this->id_field;
  }
  
  public function setIdField($field)
  {
    $this->id_field = $field;
  }
  
  public function load()
  { 
    if ( $this->loadData() ) 
    {
    	foreach($this->data AS $field => $value) {
	    	$this->$field = $value;
	    }
	    return true;
    }
    return false;
  }
  	
	public function loadStatusByActive()
  	{ 
  		if($this->isLoaded())
  		{
  			$this->data["status"] = ($this->data["active"] == 1 ) ? "Active" : "Inactive" ;
  		}
  		
    	return false;
  	}
  	
	public function getStatus()
  	{ 
  		if($this->isLoaded())
  		{
  			$active_status = ($this->data["active"] == 1 ) ? "Active" : "Inactive" ;
  			$status = ($this->data["status"]) ? $this->data["status"] : $active_status;
  		}
  		
    	return $status;
  	}
  
  private function loadData()
  { 
    if ( $this->id != 0 ) 
    {
      $sql = "SELECT *
              FROM `{$this->table_name}`
              WHERE `{$this->id_field}` = {$this->id};";
      
      if ( !$this->data = $this->DbConnection->getRow($sql) ) 
      {  
        return false;
      }
      
      $this->loaded = true;
      return true;
    }
    
    return false;
  }
  
	
  public function save()
  {
    if ( !$this->id ) {
      $fields = array_keys($this->data);
      
      $escaped_fields = array();
      foreach($fields AS $field) {
        $escaped_fields[] = "`$field`";
      }
      $fields_string = implode(', ', $escaped_fields);
      
      $values = array_values($this->data);
      $aux = array();
      foreach($values as $value)
      {
        $aux[] = "'" . mysql_escape_string($value) . "'";
      }
      $values = implode(', ', $aux);
      
      $sql = "INSERT INTO
              `{$this->table_name}`($fields_string)
              VALUES($values);";
      if ( !$this->DbConnection->executeQuery($sql) ) {
        return false;
      }
      $this->id = $this->DbConnection->getLastId();
      $this->data[$this->id_field] = $this->id;
    } else {
      $fields_strings = array();
      foreach($this->data as $field => $value)
      {
        $fields_strings[] = "`$field`='" . mysql_escape_string($value) . "'";
      }
      $field_string = implode(', ', $fields_strings);
      
      $sql = "UPDATE `$this->table_name`
              SET $field_string
              WHERE `$this->id_field`=$this->id
              LIMIT 1;";
      if ( !$this->DbConnection->executeQuery($sql) ) {
        return false;
      }
    }
    if ( !$this->loaded ){
      $this->loaded=true;
    }
    return true;
  }
 
  public function inactive()
  {
    $this->data['active'] = '0';
	return $this->save();
  }
  
  public function reactive()
  {
    	$this->data['active'] = '1';
	 	return $this->save();
  }
  
  public function isLoaded()
  {
  	return $this->loaded;
  }
  
  public function delete()
  {
    $sql = "DELETE FROM `$this->table_name`
            WHERE `$this->id_field`=$this->id
            LIMIT 1;";
    if ( !$this->DbConnection->executeQuery($sql) ) {
      return false;
    }
    return true;
  }
  
  public function getId()
  {
  	return $this->id;
  }

  public function assertLoaded()
  {
    if ( !$this->loaded ) {
      throw new RunTimeException($this->assert_message);
    }
    return true;
  }
  
  public function getData()
  {
    return $this->data;
  }

  public function loadLocationData()
  {
  		if($location = Functions::__getLocationByCity($this->data["city_id"]))
  		{
	  		$this->data["city"] = $location["city"];
	  		$this->data["state"] = $location["state"];
	  		$this->data["country"] = $location["country"];
	  		
	  		$this->data["city_id"] = $location["city_id"];
	  		$this->data["state_id"] = $location["state_id"];
	  		$this->data["country_id"] = $location["country_id"];
	  		return true;
  		}
  	return false;
  }
  
  	
}