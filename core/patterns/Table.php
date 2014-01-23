<?php
 
 /**
 * Holds {@link Page} class that shows a form to edit a {@link Row}
 * @author Arturo Osorio <arosbar@gmail.com>
 * @author Ismael Cortés <may.estilosfrescos@gmail.com>
 * @copyright Copyright (c) 2010, Ismael Cortés <may.estilosfrescos@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package spiderFrame
 **/

class Table extends Template
{
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
	  	$this->_container_properties = array( "id"=>"table_view", "class"=>"table_view" );
	  	parent::addCssLink(TO_ROOT . "/core/style/tables.css");
	  	parent::setTemplate(TO_ROOT . "/core/patterns/templates/Table.tpl.php", true);
  	}
	
 	/**
   	 * Chosse to Set the SturdyRow or set set the ObjRow like Objects to be edited 
   	 * @param  Array $objRow the Array or Row to be edited
   	 * @return void
   	 * @author spidermay
     **/
  	public function setRow($Row, DbConnection $DbConnection = null) 
  	{
  		return false;
  		//parent::setRow($Row);
  	}
  	
	/**
  	 * Shows the given template
  	 *
  	 * Converts the $variables array into $Data object and sets any message that may
  	 * be in the $_SESSION and finally calls the given template
  	 * @return void
  	 */
  	public function display()
  	{
  		parent::display();
  	}
  	
	public function getHTML()
  	{
  		$this->loadMainVariables(); 
    	
    	$Data = (object)$this->_variables;
    	extract($this->_variables);
    
    	ob_start();
    	include $this->_template;
    	return ob_get_clean();
  	}
  	
	public function setTableTitle($title)
  	{
  		return $this->__setTableProperty("title", $title);
  	}
  	
	public function setTableRows($rows)
  	{ 
  		return $this->setRows($rows);
  	}
  	
	public function setRows($rows)
  	{ 
  		if(is_array($rows))
  		{ 
  	  		return $this->__setRows($rows);
  		}
  		return false;
  	}
  	
  	public function setTableRow($row, $row_data)
  	{ 
  		return $this->__setTableRow($row, $row_data);
  	}
  	
  	public function setColumnProperty($column, $property, $value)
  	{
  		 return $this->__setColumnProperty($column, "Column", "Properties", $property, $value);
  	}
  	
	public function setRowProperty($column, $property, $value)
  	{
  		 return $this->__setColumnProperty($column, "Row", "Properties", $property, $value);
  	}
  	
	public function setColumnPropertyLink($column, $href, $replace_id = true)
  	{
  		return $this->setLinkedColumn($column, $href, $replace_id);
  	}
  	
	public function setLinkedColumn($column, $href, $replace_id = true)
  	{
  		if($replace_id)
  		{
  			return $this->__setlinkedColum($column, $href);
  		}
  		
  		if(strpos($href, "http"))
		{
			$this->__setColumnProperty($column, "Href", "Properties", "href", $href);
			$this->__setColumnProperty($column, "Href", "Properties", "target", "_blank");
		}
				
  		
  	}
  	
  	
	public function setConditionColumnValue($column, $value, $success, $failure = false)
  	{
  		return $this->__setConditionColumnValue($column, $value, $success, $failure);
  	}
  	
	public function moveColumn($column, $target= "", $position = "after")
  	{
  		return $this->__moveColumn($column, $target, $position);
  	}
  	
	public function moveColumnToStart($column)
  	{
  		return $this->__moveColumn($column, "", "first");
  	}
  	
	public function moveColumnToEnd($column)
  	{
  		return $this->__moveColumn($column, "", "end");
  	}
  	
	public function moveColumnAfter($column, $target)
  	{
  		return $this->__moveColumn($column, $target, "after");
  	}
  	
	public function moveColumnBefore($column, $target)
  	{
  		return $this->__moveColumn($column, $target, "before");
  	}
	
  	
  	public function addAction($action_name, $href = false, $target = false, $replace_id = true)
  	{
  		return $this->__addAction($action_name, $href, $target, $replace_id);
  	}
  	
	public function setRowsByQuery($sql, DbConnection $DbConnection = null) 
	{
		return $this->__setRowsByQuery($sql, $DbConnection);
	}
	
	
	
	
	
	
	
	private function __setRowsByQuery($sql, DbConnection $DbConnection = null) 
	{
		$DbConnection = ($DbConnection == null) ? DbConnection::getInstance("_root") : $DbConnection ;
	 	if($rows = $DbConnection->getAll($sql))
	 	{
	 		return $this->__setRows($rows);
	 	}
	 	return false;
	}
  	
	private function __addAction($action_name, $href = false, $target = false, $replace_id = true)
  	{
  		if($this->_rows["Rows"])
  		{
  			$action_level = str_replace(" ", "_", strtolower($action_name));
  			foreach($this->_rows["Rows"] AS $__row => $__values)
			{	
				$new_href = $this->__getLinkedStringByRow($__row, $href);
			 	$active_values = $this->__getActiveValues($__row);
			 	$action_id = $active_values["id"];
			 	if(!$href)
			 	{
			 		$action_name = $active_values["inverse_status"];
			 	}
			 	
				foreach($__values AS $__key => $__value)
				{ 
					$keys = array_keys($this->_rows["Rows"][$__row]);
			 		$target = ($target) ? $target : $keys[count($keys) -1];
				  	
					if(key_exists("actions", $this->_rows["Columns"]))
		  			{ 
		  				$this->__setCellProperty($__row, "actions", $action_level, "Properties", "id", $action_id);
		  				$this->__setCellProperty($__row, "actions", $action_level, "Properties", "value", ucfirst(str_replace("_", " ", $action_name)));
		  				
		  				if($href)
		  				{
		  					$this->__setCellProperty($__row, "actions", $action_level, "Properties", "href", $new_href);
		  				}
		  			} else {
		  				$row_data[$action_level]["Properties"]["id"] = $action_id;
  						$row_data[$action_level]["Properties"]["value"] = ucfirst(str_replace("_", " ", $action_name));
		  				
		  				if($href)
		  				{
		  					$row_data[$action_level]["Properties"]["href"] = $new_href;
		  				}
		  				
		  				$this->__insertColumn($__row, "actions", $row_data, $target, "after");
		  			}
				}
			}
  		}		
		$this->__resetColumns();
		return true;
  	}
  	
  	private function __getActiveValues($row_id)
  	{
  		if($row_values = $this->__getRowValues($row_id))
  		{
  			foreach($row_values AS $key => $values)
			{
				if(!$id)
				{
					if(strpos($key, "_id"))
					{
						$id = $key;
						$id_value = $values["Row"]["Properties"]["value"];
						$table = str_replace("_id", "", $key);		
					}
				}
				
				if($active == "")
				{	
					if($key == "active")
					{   
						$active = $values["Row"]["Properties"]["value"];		
					}
				}
			}
	  	}
  		
		$active_values["field_id"] = $id;
		$active_values["table"]  = $table;
	  	$active_values["active"] = $active;
	  	$active_values["value"] = $id_value;
		$active_values["status"] = ($active == 1) ? "Active" : "Inactive" ;
		$active_values["inverse_status"] = ($active == 1) ? "Inactive" : "Active";
		$active_values["id"] = $table . "-active-" . $id_value . "-" . $active;
		
  		return $active_values;
  	}
  	
	private function __getLinkedStringId($row_id, $field = "active")
  	{
  		if($row_values = $this->__getRowValues($row_id))
  		{
  			foreach($row_values AS $key => $values)
			{
				if(!$id)
				{
					if(strpos($key, "_id"))
					{
						$id = $key;
						$id_value = $values["Row"]["Properties"]["value"];
						$table = str_replace("_id", "", $key);		
					}
				}
				
				if($search_value == "")
				{	
					if($key == $field)
					{   
						$search_value = $values["Row"]["Properties"]["value"];		
					}
				}
			}
	  	}
  		
		$linked_string = $table . "-" . $field . "-" . $id_value . "-" . $search_value;
  		return $linked_string;
  	}
  	
  	private function __setRows($rows)
  	{
  		if($rows)
  		{
  			$i = 0;
	  		foreach($rows AS $row => $values)
	  		{
	  			foreach($values AS $key => $value)
	  			{
	  				$this->_rows["Rows"][$row][$key]["Row"]["Properties"]["value"] = $value;
	  				$this->_rows["Rows"][$row][$key]["Column"]["Properties"]["value"] = ucfirst(str_replace("_", " ", $key));
	  				$this->_rows["Rows"][$row][$key]["Row"]["Properties"]["class"] = "left";
	  				
	  				if( strpos($key, "active") )
	  				{
	  					$this->_rows["Rows"][$row][$key]["Row"]["Properties"]["type"] = "hide";
	  				}
	  			}
	  		}
	  		$this->__resetColumns();
  		}
  	}
  	
	private function __moveColumn($column_name, $target = "", $position = "after")
  	{
  		if($this->_rows["Rows"])
  		{
  			foreach($this->_rows["Rows"] AS $__row => $__values)
			{	
		  		foreach($__values AS $__key => $__value)
		  		{ 
		  			if($column_name == $__key)
			  		{ 
			  			$position = (empty($position)) ? "after" : $position;
			  			if($position == "first" || $position == "start" || $position == "last" || $position == "end")
			  			{
			  				$keys = array_keys($this->_rows["Rows"][$__row]);
			  				$position = ($position == "first" || $position == "start") ? 0 : count($keys) -1;
			  				
			  				$target = $keys[$position];
			  				$position = ($position >= 1) ? "after" : "before" ; 
			  			}
			  			
  			  			$this->__insertColumn($__row, $column_name, $__value, $target, $position);
			  		}
		  		}
			}
  			
			$this->__resetColumns(); 
			return true;
  		}
  		return false;
  	}
  	
	private function __insertColumn($row_id, $column_name, $column_data, $target = "", $position = "after")
  	{
  		$success = false;
	    $new_rows = array();
	  	
	    if($target)
	    {
	    	foreach($this->_rows["Rows"] AS $__row => $__values)
		  	{	
		  		if($__row == $row_id)
		  		{ 
		  			foreach($__values AS $__key => $__value)
		  			{	
		  				if($position == "after")
			  			{	
			  				$new_rows[$__key] = $this->_rows["Rows"][$row_id][$__key];
			  			}
			  			 
			  			if($__key == $target )
				  		{   
				  			$new_rows[$column_name] = $column_data;
				  			$success = true;
				  		}
				  		
			  			if($position == "before")
			  			{
			  				$new_rows[$__key] = $this->_rows["Rows"][$row_id][$__key];
			  			} 
		  			}	
		  		}
	  		}
	  		
	    } else { 
	  		foreach($this->_rows["Rows"] AS $__row => $__values)
		  	{	
		  		if($__row == $row_id)
		  		{
			  		foreach($__values AS $__key => $__value)
			  		{
			  			$new_rows = $this->_rows["Rows"][$row_id];
			  		} 
		  		
					$new_rows[$column_name] = $column_data; 
					$success = true;
		  		}
	  		}
	  		
	    }
  		
  		$this->_rows["Rows"][$row_id] = $new_rows;
  		return $success;
  	}
  	
	public function __insertRow($row_name, $row_data, $target = "", $position = "after")
  	{
  		
  		return $success;
  	}
  	
  	
	private function __setlinkedColum($column, $href)
	{
		if($this->_rows["Rows"])
  		{
  			foreach($this->_rows["Rows"] AS $__row => $__values)
	  		{
	  			foreach($__values AS $__key => $__value)
	  			{
	  				if($column == $__key)
	  				{  
	  					$new_href = $this->__getLinkedStringByRow($__row, $href);
	  					$this->_rows["Rows"][$__row][$__key]["Href"]["Properties"]["href"] = $new_href;
	  					
						if(strpos($new_href, "http"))
						{
							$this->_rows["Rows"][$__row][$__key]["Href"]["Properties"]["target"] = "_blank";
						}
	  				}
	  			}
	  		}
  		}
	}
	
	private function __resetColumns()
  	{
  		$this->_rows["Columns"] = $this->__getKeys($this->_rows["Rows"]); 
  		return true;
  	}
  	
	private function __getKeys($rows)
  	{
  		if(is_array($rows))
  		{
  			foreach($rows AS $key => $value)
  			{
  				foreach($value AS $_key => $_value)
  				{
  					$row_keys[$_key]["Properties"]["value"] = ucfirst(str_replace("_", " ", $_key));
  				}
  			}
  		}
  		return $row_keys;
  	}
  	
	private function __setColumnProperty($column, $level, $attribute, $property, $value)
  	{
  		if($this->_rows["Rows"])
  		{ 
  			foreach($this->_rows["Rows"] AS $__row => $__values)
	  		{
	  			foreach($__values AS $__key => $__value)
	  			{ 
	  				if($column == $__key)
	  				{  
	  					$this->_rows["Rows"][$__row][$__key][$level][$attribute][$property] = $value;
	  					$this->_rows["Columns"][$__key][$attribute][$property] = $value;
	  				}
	  			}
	  		}
  		}
  	}
  	
  	private function __setConditionColumnValue($column, $value, $success, $failure = false)
  	{
  		if($this->_rows["Rows"])
  		{ 
  			foreach($this->_rows["Rows"] AS $__row => $__values)
	  		{
			  	foreach($__values AS $__key => $__value)
			  	{ 
			  		if($column == $__key)
			  		{  
		  				$this->_rows["Rows"][$__row][$__key]["Row"]["Properties"]["value"] = ($this->_rows["Rows"][$__row][$__key]["Row"]["Properties"]["value"] == $value) ? $success : $failure;
		  			}
			  	}
	  		}
	  		return true;
  		}
  		return false;
  	}
  	
	private function __setCellProperty($row_id, $column, $level, $attribute, $property, $value)
  	{
  		if($__values = $this->__getRowValues($row_id))
  		{
		  	foreach($__values AS $__key => $__value)
		  	{ 
		  		if($column == $__key)
		  		{  
		  			$this->_rows["Rows"][$row_id][$__key][$level][$attribute][$property] = $value;
		  			return true;
		  		}
		  	}	
  		}
  		return false;
  	}
  	
	private function __setTableProperty($property, $value)
  	{
  		return $this->_rows["Table"]["Properties"][$property] = $value;
  	}
  	
	private function __getLinkedStringByRow($row_id, $href)
	{
		if($__values = $this->__getRowValues($row_id))
  		{
  			$glue = "";
		  	$params = "";
			$href_collection = parent::__getArrayParamsByHref($href);
		  					
		  	if($href_collection["params"])
			{
				foreach($href_collection["params"] AS $key => $value)
				{ 	
					$id = $__values[$key]["Row"]["Properties"]["value"];
					$id = ($id) ? $id : $value ;
									
					$params = $params . $glue . $key . "=" . $id; 
					$glue = "&";
				}
								 
				$new_href = $href_collection["href"] . "?" . $params;
								
		  	} else {
				$new_href = $href;
			}	
			return $new_href;
		}
		return false;
	}
  	
	private function __getRowValues($row_id)
	{
		if($this->_rows["Rows"])
  		{
  			foreach($this->_rows["Rows"] AS $__row => $__values)
	  		{
	  			if($__row == $row_id)
	  			{
		  			return $__values;
	  			}
	  		}
  		}
  		
		return false;
	}
}