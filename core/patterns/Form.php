<?php
 
 /**
 * Holds {@link Page} class that shows a form to edit a {@link Row}
 * @author Arturo Osorio <arosbar@gmail.com>
 * @author Ismael Cortés <may.estilosfrescos@gmail.com>
 * @copyright Copyright (c) 2010, Ismael Cortés <may.estilosfrescos@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package spiderFrame
 **/

class Form extends Template
{
	/**
   	 * This is the general Array to info
     * @var ArrayObject _Sturdyrow
     **/
  	private $_Sturdyrow = null;
   								
    /**
     * The match list serialize in a future
     * @var ArrayObject
     **/
	private $_matchList = null;
  									
  	/**
	 * The levels in sturdyrow same in xajax save function
	 * @var array
	 */
	private $_sturdyRowLevels = array();
	
	/**
   	 * Construct a {@link Edit} page
	 * @param string $page_name the page name to be shown
	 * @param string $template by default it uses Edit.tpl.php
	 * @return Edit
	 **/
 	public function __construct($page_name="", $layout="")
  	{
  		parent::setPageName($page_name);
  		parent::setLayout($layout);
	    parent::setSection($template);
	    parent::setApp();
	    
	    parent::setMainMenu();
	  	parent::setSecondaryMenu();
	  	$this->__loadSturdyRowsLevels();
	  	$this->_container_properties = array( "id"=>"eForm", "name"=>"eForm", "class"=>"form_data" );
	  	parent::addCssLink(TO_ROOT . "/apps/subcore/style/forms.css");
	  	parent::setTemplate(TO_ROOT . "/core/patterns/templates/Form.tpl.php", true);
  	}
	
 	
	/**  ****************** Set the Row's properties *******************  **/
  
  	/**
   	 * Chosse to Set the SturdyRow or set set the ObjRow like Objects to be edited 
   	 * @param  Array $objRow the Array or Row to be edited
   	 * @return void
   	 * @author spidermay
     **/
  	public function setRow($Row) 
  	{
  		if(is_array($Row))
	  	{
	  		$this->__setSturdyRow($Row);
	  	} else {
	  		parent::setRow($Row);
  		
  	  		$this->_Sturdyrow = $this->__createSturdyRow($Row);
	    	$this->_matchList = $this->_Sturdyrow; 
	    	return true;
	  	}
  	}
  	
	private function __loadSturdyRowsLevels()
  	{
  		$this->_sturdyRowLevels = array(
  										"Table",
  										"DbConnection",
  										"id",
  										"Fields",
  										"Protect",
  										"Titles",
  										"Validate",
  										"Required",
  										"ChangedField",
  										"ChangedFieldCondition",
  										"AsignValue",
  										"LogicValue",
  										"JoinFields",
  										"TransformField", 
  										"TransformDate", 
  										"IgnoreClean",
  										"Function"
  		);
  	}
		
	
	/**  ****************** SturdyRow Functions *******************  **/
  
	public function setSturdyRowProperty($row, $level, $property, $value="")
	{
		return $this->__setSturdyRowProperty($row, $level, $property, $value);
	}

	/**
	 * Set's the Table property in a row to Sturdyrow
	 * @param string $row the level to row table
	 * @param string $value the name to table
	 * @todo Validar si el sturdyrow tiene Table o el Table es el key-row 
	 */
	public function setSturdyRowTable($row, $value)
	{
		return $this->__setSturdyRowProperty($row, "Table", $value);
	}

	/**
	 * Set's the DbConnection property in a row to Sturdyrow
	 * @param string $row the level to row table
	 * @param string $value the name to instance DbConnection
	 */
	public function setSturdyRowDbConnection($row, $instance="_root")
	{
		return $this->__setSturdyRowProperty($row, "DbConnection", $instance);
	}
	
	/**
	 * Set's the id property in a row to Sturdyrow
	 * @param string $row the level to row table
	 * @param int $value the id for edit
	 */
	public function setSturdyRowId($row, $id)
	{
		return $this->__setSturdyRowProperty($row, "id",(int)$id);
	}
	
	/**
	 * Set's the Fields property in a row to Sturdyrow
	 * @param string $row the level to row table
	 * @param array $fields the array name to fields to be affected in row
	 */
	public function setSturdyRowFields($row, $fields)
	{
		if(is_array($fields))
		{
			return $this->__setSturdyRowProperty($row, "Fields", $fields);
	
		}
	}
	
	/**
	 * Set's the Fields to be Protect property in a row to Sturdyrow
	 * @param string $row the level to row table
	 * @param array $fields the array field => security to be protect in row: md5, sha1, etc
	 */
	public function setSturdyRowProtect($row, $fields)
	{
		if(is_array($fields))
		{
			return $this->__setSturdyRowProperty($row, "Protect", $fields);
	
		}
	}
	
	/**
	 * Set's the Transform Fields date in a row to Sturdyrow
	 * @param string $row the level to row table
	 * @param array $fields the array field => validate type in to field
	 * 
	 */
	public function setSturdyRowTransformDate($row, $fields, $original_format_date = "d/m/Y")
	{ 
		if(is_array($fields))
		{ 
			return $this->__setSturdyRowProperty($row, "TransformDate", $fields);
		} else {
			return $this->__setSturdyRowProperty($row, "TransformDate", array($fields));
		}
	}
	
	/**
	 * Set's the Titles in Fields property in a row to Sturdyrow
	 * @param string $row the level to row table
	 * @param array $titles the array key => value to title in field to be affected in row
	 */
	public function setSturdyRowTitles($row, $titles)
	{
		if(is_array($titles))
		{
			return $this->__setSturdyRowProperty($row, "Titles", $titles);
	
		}
	}
	
	/**
	 * Set's the Validate Fields property in a row to Sturdyrow
	 * validate types: empty, number, mail, compareWith, - Select one
	 * @param string $row the level to row table
	 * @param array $fields the array field => validate type in to field
	 * 
	 */
	public function setSturdyRowValidate($row, $fields)
	{
		if(is_array($fields))
		{
			return $this->__setSturdyRowProperty($row, "Validate", $fields);
	
		}
	}
	
	
	/**
	 * Set's the Required Fields property in a row to Sturdyrow
	 * @param string $row the level to row table
	 * @param array $fields the array name to fields for required 
	 */
	public function setSturdyRowRequired($row, $fields)
	{
		if(is_array($fields))
		{
			return $this->__setSturdyRowProperty($row, "Required", $fields);
	
		}
	}
	
	/**
	 * Set's the Changed Fields property in a row to Sturdyrow
	 * @param string $row the level to row table
	 * @param array $fields the array field => changed field 
	 */
	public function setSturdyRowChangedField($row, $fields)
	{
		if(is_array($fields))
		{
			return $this->__setSturdyRowProperty($row, "ChangedField", $fields);
	
		}
	}
	
	/**
	 * Set's the Changed Fields whith condition first field is clean 
	 * property in a row to Sturdyrow
	 * @param string $row the level to row table
	 * @param array $fields the array field => changed field 
	 */
	public function setSturdyRowChangedFieldCondition($row, $fields)
	{
		if(is_array($fields))
		{
			return $this->__setSturdyRowProperty($row, "ChangedFieldCondition", $fields);
	
		}
	}
	
	/**
	 * Set's the Asign values in Fields property in a row to Sturdyrow
	 * @param string $row the level to row table
	 * @param array $fields the array field => value to be affected in row
	 */
	public function setSturdyRowAsignValue($row, $fields)
	{
		if(is_array($fields))
		{
			return $this->__setSturdyRowProperty($row, "AsignValue", $fields);
	
		}
	}
	
	
	/**
	 * Set's the Asign id values in row, property in id row to Sturdyrow
	 * @param string $row the level to row table
	 * @param array $fields the array field => value, values: first, before_id, case numeric, x field name
	 */
	public function setSturdyRowConditionIds($row, $fields)
	{
		if(is_array($fields))
		{
			return $this->__setSturdyRowProperty($row, "ConditionIds", $fields);
	
		}
	}
	
	/**
	 * Set's the Logic value in fields, property in row to Sturdyrow
	 * transforn true in 1 and false in 0 or back
	 * @param string $row the level to row table
	 * @param array $fields the array field => value
	 */
	public function setSturdyRowLogicValue($row, $fields)
	{
		if(is_array($fields))
		{
			return $this->__setSturdyRowProperty($row, "LogicValue", $fields);
	
		}
	}
	
	/**
	 * Set's the fields to be Join in one field, property in row to Sturdyrow
	 * @param string $row the level to row table
	 * @param array $fields the array field => values fields to be join
	 */
	public function setSturdyRowJoinFields($row, $fields)
	{
		if(is_array($fields))
		{
			return $this->__setSturdyRowProperty($row, "JoinFields", $fields);
	
		}
	}
	
	 /**
	 * Set's the fields to be correct time in one field, property in row to Sturdyrow
	 * @param string $row the level to row table
	 * @param array $field the field => $value to check
	 */
	public function setSturdyRowTransformField($row, $values)
	{
		if(is_array($values))
		{
			return $this->__setSturdyRowProperty($row, "TransformField", $values);
	
		}
	}
	
	/**
	 * Set's the fields to be Join in one field, property in row to Sturdyrow
	 * @param string $row the level to row table
	 * @param string $message the message in alert
	 */
	public function setSturdyRowMessage($row, $message)
	{
		return $this->__setSturdyRowProperty($row, "Message", $message);
	}
	
	/**
	 * Set's the fields to be Join in one field, property in row to Sturdyrow
	 * @param string $row the level to row table
	 * @param mixed $function the function
	 * @param string $value the value in function
	 */
	public function setSturdyRowFunction($row, $field, $function, $values="", $in_Functions = true)
	{
		if($in_Functions == true)
		{
			$functions[$field]["Functions"][$function] = $values;
		} else {
			$functions[$field][$function] = $values;
		}
		
		return $this->__setSturdyRowProperty($row, "Function", $functions);
	}
	
	/**
	 * Set's the Ignore field values in Fields property in a row to Sturdyrow
	 * @param string $row the level to row table
	 * @param array $fields the array field => value to be affected in row
	 */
	public function setSturdyRowIgnoreClean($row, $fields)
	{ 
		if(is_array($fields))
		{
			return $this->__setSturdyRowProperty($row, "IgnoreClean", $fields);
		} else {
			return $this->__setSturdyRowProperty($row, "IgnoreClean",array($fields));
		}
	}
	
	/**
	 * Unset's the property in row to Sturdyrow
	 * @param string $row is the principal row to stop for modify
	 * @param string $level is a level to array 
	 * @param mixed $property is value for to level or property for next down level 
	 * @param mixed $value in case to property is level this value is a value for property
	 */
	public function unsetSturdyRowProperty($row, $level, $property="", $value="")
	{
		return $this->__unsetSturdyRowProperty($row, $level, $property, $value);
	}
	
	/*
	 * @todo este es un parche provisional, se requiere arregalar los 2 __setSturdyRowProperty urgente
	 */
	private function __setSturdyRowPropertyByPosition($row, $level, $property, $value="")
	{
		$position = $this->__getPositionSturdyRow($row);
		$this->_Sturdyrow[$position["position"]][$level] = $property;
	}
	
	/**
	 * 
	 * Set to private properties in sturdyRow the table is a principal flag
	 * to identify and level is a list for to choose
	 * @param string $row is the principal row to stop for modify
	 * @param string $level is a level to array choose:'Table','DbConnection','id',
	 * 												 'Fields','Protect','Titles','Validate',
	 * 												 'Required','ChangedField','AsignValue',
	 * 												 'ConditionIds','LogicValue','JoinFields',
	 * 												 'Message','Function'
	 * @param mixed $property is value for to level or property for next down level 
	 * @param mixed $value in case to property is level this value is a value for property
	 */
	private function __setSturdyRowProperty($row, $level, $property, $value="")
	{
		$__authorized = false;
		$levels = $this->_sturdyRowLevels;
		
		if(in_array($level, $levels) )
		{	
			foreach($this->_Sturdyrow AS $__key => $__rows)
			{ 
				foreach($__rows AS $_level => $__property)
				{ 
					$__Table = $__rows["Table"];
					$__authorized = ( $row == $__Table ) ? true: false;
						
					if(is_array($property))
					{   
						if($__authorized)
						{ 	
							$this->_Sturdyrow[$__key][$level] = $property;
							$__authorized = false; 
						}	
					} else {
						if($__authorized)
						{ 	
							if($value)
							{ 
								$this->_Sturdyrow[$__key][$level][$property] = $value;
							} else { 
								$this->_Sturdyrow[$__key][$level] = $property ;
							} 
							$__authorized = false; 
						}	
					} // if is array property and else 
				}// End foreach $__row AS $_level => $__property
			} // End Principal foreach $this->_Sturdyrow
		} // if level = Actions and LevelAction exist or level diferent to Actions
		
		$this->_matchList = $this->_Sturdyrow;
		return true;
	}
	
	/**
	 * 
	 * Set to private properties in sturdyRow the table is a principal flag
	 * to identify and level is a list for to choose
	 * @param string $row is the principal row to stop for modify
	 * @param string $level is a level to array choose
	 * @param mixed $property is value for to level or property for next down level 
	 * @param mixed $value in case to property is level this value is a value for property
	 */
	private function __unsetSturdyRowProperty($row, $level, $property="", $value="")
	{
		$__authorized = false;
		$_levels = $this->_sturdyRowLevels;
		
		if(in_array($level, $_levels) )
		{	
			$_myProperty = (is_array($property) ) ? array_keys($property) : $property;
			$_myProperty = (is_array($property) ) ? $_myProperty[0] : $property;
			
			foreach($this->_Sturdyrow AS $__rows => $__row)
				{
					foreach($__row AS $_level => $__property)
					{
						if( $_level == $level )
						{ 
							$__authorized = ( ($row == $__rows) || ($row == $this->_Sturdyrow[$__rows]["Table"]) ) ? true: false;
							if(is_array($property))
							{
								if($__authorized)
								{ 
									unset($this->_Sturdyrow[$__rows][$level][$property]);
									$__authorized = false;
								}
							} else if($property !=""){
								if($__authorized)
								{ 
									if($value)
									{
										unset($this->_Sturdyrow[$__rows][$level][$property][$value]);
									} else { 
										unset($this->_Sturdyrow[$__rows][$level][$property]);
									} 
									$__authorized = false;
								}
							} else { 
								if($__authorized)
								{ 
									unset($this->_Sturdyrow[$__rows][$level]);
									$__authorized = false;
								}
							}// if is array property and else
						} // if found level
					} // End foreach $__row AS $_level => $__property
				} // End Principal foreach $this->_Sturdyrow
		 	} // if level = Actions and LevelAction exist or level diferent to Actions
		$this->_matchList = $this->_Sturdyrow;
		return true;
	}
		
	/**
	 * Create the strucutre same SturdyRow, 
	 * is a principal array for to save and construct objects 
	 * thath array for values and fields in object Row
	 * @param Row $Row
	 */
	private function __createSturdyRow(Row $Row) 
	{
		$i = 0; 
		$_field_id = $Row->getIdField();
		
		$_data = ($Row->data) ? $Row->data : $Row->getStructure();
		foreach($_data AS $_field => $_value)
		{ 
			(is_array($_value)) ? $_field = $_value["Field"]: $_field;
			
			if( ($_field != $_field_id) && ($_field != "active"))
			{ 
				$_fields[] = $_field; 
				$_title = str_replace("_id", " ", $_field);
				$_title = str_replace("_", " ", $_title);
				$_titles[] = ucwords($_title); 
			}
			
			if($_field == "password")
			{
				$_protect[] = array($_field=>"md5"); 
			}
		}
		
		if($this->_Sturdyrow)
		{
			foreach($this->_Sturdyrow AS $__rows => $__row)
			{
				$Sturdyrow[] = $__row;
				$i++;
			}
		}
		
		$Sturdyrow[count($this->_Sturdyrow)] =array("Table"=>$Row->getTableName(),
													"DbConnection"=>$Row->getDbInstanceName(),
													"Name"=>$i,
													"id"=>(int)$Row->getId(),
													"Fields" => $_fields,
													"Protect" => $_protect,
													//"Titles" => $_titles,
													);
		return $Sturdyrow;
	}
		
	/**
	 * Set the SturdyRow like Objects to be edited
	 * @paramArray $Sturdyrow the Array like Row to be edited
	 * @return void
	 * @author spidermay
	 */
	private function __setSturdyRow($Sturdyrow)
	{
		$this->_Sturdyrow = $Sturdyrow;
		
		$i=0;
		/** Parse table structure into template friendly data **/
		foreach($this->_Sturdyrow AS $_rows => $_row)
		{	
			$id = $this->_Sturdyrow[$_rows]["id"];
			$this->_Sturdyrow[$_rows]["Name"] = $i;
			$Table = ( is_numeric($_rows) ) ? $_row["Table"] : $_rows;
			$DbConnection = DbConnection::getInstance($this->_Sturdyrow[$_rows]["DbConnection"]);
			
			$Row = new Row($Table,(int)$id, $DbConnection);
				$Row->load();
				
				$j=0;
				$Structure = $Row->getTableStructure();
				// ---------------- <<<< Construct fields structure >>>> ------------------------
				if($_row["Fields"])
				{
					/*
					if( is_array($_row["Required"]) && in_array($_field, $_row["Required"]) ) 
					{
							$this->_required_fields = true;
							$this->_rows[$i][$j]["Row"]["Requireds"][$_field] = $_field;
						}*/
							
						foreach ($_row["Fields"] AS $_field )
						{ 
							preg_match("/^([a-z]*)(?:\((.*)\))?\s?(.*)$/", $Structure[$_field]["Type"], $_type);
							$this->_rows[$i][$j]["Row"]["Row"] = $_field;
						 	$this->_rows[$i][$j]["Field"] = $this->__setField($_type);
					 		$this->_rows[$i][$j]["Field"]["Properties"]["id"] = $_field ."_" . $id;
						 	$this->_rows[$i][$j]["Field"]["Properties"]["data-id"] = $_field;
						 	$this->_rows[$i][$j]["Field"]["Properties"]["name"] = $_field . "_" . $id . "_" . $i;
						 	
						 	$label = ($_row["Titles"][$_field])?($_row["Titles"][$_field]):ucwords(str_replace("_id", "", $_field));
							$this->_rows[$i][$j]["Label"]["Properties"]["value"] = ( $_row["Titles"][$_field] ) ? $_row["Titles"][$_field] : str_replace("_", " ", $label);
						 	$this->_rows[$i][$j]["Label"]["Properties"]["for"] = $_field ."_" . $id;
						 	
						 	$_value = ( isset($Row->data[$_field]) ) ? htmlspecialchars($Row->data[$_field]): htmlspecialchars($Structure[$_field]["Default"]) ;
						 	$this->_rows[$i][$j]["Field"]["Properties"]["value"] = $_value ;
						 	
							if($_field == "password" || isset($_row["Protect"][$_field]) )
							{ 
								$this->_rows[$i][$j]["Field"]["Properties"]["value"] = "";
								$this->_rows[$i][$j]["Field"]["Properties"]["type"] = "password";
							}
						 
							if( strpos($name, "date") !== false || strpos($name, "birthday") !== false )  
							{ 
								$this->_rows[$i][$j]["Field"]["Properties"]["class"] = "__date";
								$this->_rows[$i][$j]["Field"]["Properties"]["readonly"] = "readonly";
								$this->_rows[$i][$j]["Field"]["Properties"]["value"] = ($_value) ? date("d/m/Y", $_value): date("d/m/Y");
							}
							
							if( (strpos($name, "active") !== false) || (strpos($name, "delete") !== false) || (strpos($name, "secret") !== false) || (strpos($name, "_id") !== false)) 
							{ 
								$this->_rows[$i][$j]["Row"]["Properties"]["class"] = "__hide";
								$this->_rows[$i][$j]["Field"]["Properties"]["type"] = "hidden";
							}
							$j++;
					} // ---------------- <<<< Foreach Fields
				} // ---------------- <<<< End Construct fields structure >>>> ------------------------
				$i++;
		} //print_r($this->_rows); // ---------------- <<<< Foreach SturdyRow
		
		$this->_matchList = $this->_Sturdyrow;
	}
	
	/**
   	 * 
     * This function returns the value or the position of a row based sturdyrow of the same group
     * @param string $row the row to find 
     * @param integer $position the reference row  
     * @param bool $value return value, returns string if is true, returns position if false 
     * @return Ambigous <number, string> | boolean
     **/
  	private function __getPositionSturdyRow($row)
  	{
	  	$_Row=array();
	  	$i=0;
	  	foreach($this->_Sturdyrow AS $rows)
	    {  
	   		if($rows["Table"] == $row )
			{
				$_Row["position"] = $i;
				return $_Row;
			}
			$i++;
	    }
	}
	
/**  ****************** Display Functions *******************  **/
	
	/** 
	 * Display the selected template with the given data and customization
   	 * @return void
     **/
  	public function display() 
	{
		$this->assign("__matchList", $this->_matchList);
		$this->assign("__showHideMatch", $this->_showHideMatch);
	    parent::display(); 
	}
	
	public function getHTML()
  	{
  		$this->assign("__matchList", $this->_matchList);
		$this->assign("__showHideMatch", $this->_showHideMatch);
	    $this->loadMainVariables(); 
    	
    	$Data = (object)$this->_variables;
    	extract($this->_variables);
    
    	ob_start();
    	include $this->_template;
    	return ob_get_clean();
	    //parent::getHTML();
  	}
}