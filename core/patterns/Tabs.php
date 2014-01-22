<?php
 
 /**
 * Holds {@link Page} class that shows a form to edit a {@link Row}
 * @author Arturo Osorio <arosbar@gmail.com>
 * @author Ismael Cortés <may.estilosfrescos@gmail.com>
 * @copyright Copyright (c) 2010, Ismael Cortés <may.estilosfrescos@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package spiderFrame
 **/

class Tabs extends Template
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
	  	parent::addCssLink(TO_ROOT . "/apps/subcore/style/tabs.css");
	  	parent::addCssLink(TO_ROOT . "/apps/subcore/style/tables.css");
	  	parent::addJsLink(TO_ROOT . "/apps/subcore/scripts/script.tabs.js");
	  	parent::setTemplate(TO_ROOT . "/core/patterns/templates/Tabs.tpl.php", true);
  	}
	
 	
	/**  ****************** Set the Row's properties *******************  **/
  
  	/**
   	 * Chosse to Set the SturdyRow or set set the ObjRow like Objects to be edited 
   	 * @param  Array $objRow the Array or Row to be edited
   	 * @return void
   	 * @author spidermay
     **/
  	public function setRow(Row $Row) 
  	{
  		$this->setTabs($Row);
  	}
  	
  	public function setTabs(Row $Row)
  	{
  		return $this->__setTabs($Row);
  	}
	
  	public function joinTabs($tab_id, $tab_name)
  	{
  		return $this->__joinTabs($tab_id, $tab_name);
  	}
  	
	public function setPositionRowInTab($tab_id, $tab_name)
  	{
  		return $this->__setPositionRowInTab($tab_id, $tab_name);
  	}
  	
	public function getTabList()
  	{
  		if($this->_rows["Tabs"])
  		{
  			foreach($this->_rows["Tabs"] AS $tab_id => $values)
  			{
  				if(!$tabs_list[$values["id"]])
  				{
  					$tabs_list[$values["id"]] = $tab_id ;
  				}
  			}
  		}
  		return $tabs_list;
  	}
  	
	public function addAction($tab_id, $value, $href = "", $replace_id = true, $action_data = false)
  	{
  		return $this->addTabAction($tab_id, $value, $href, $replace_id, $action_data);
  	}
  	
	public function addActiveAction($tab_id, $id, $replace_id = true)
  	{
  		$action = parent::__prepareActiveActionData($id, $replace_id);
  		$tab_id = $this->__getTabId($tab_id);
  		$this->_actions[$tab_id][] = $action;
		return true;
  	}
  	
	public function addTabAction($tab_id, $value, $href = "", $replace_id = true, $action_data = false)
  	{
  		$action = parent::__prepareActionData($value, $href, $replace_id, $action_data);
		$tab_id = $this->__getTabId($tab_id);
  		$this->_actions[$tab_id][] = $action;
  		return true;
  	}
  	
  	private function __getTabId($tab_id) 
  	{
	  	if(!is_numeric($tab_id))
	  	{
	  		$tabs = $this->getTabList();
	  		foreach ($tabs AS $id => $tab_name)
	  		{
	  			$tab_id = ($tab_name == $tab_id) ? $id : $tab_id;
	  		}
	  	}
	  	return $tab_id;
  	}
  	
	private function __setTabs(Row $Row)
  	{
  		$tab_name = $Row->getTableName();
  		$tab_id = count($this->_rows["Tabs"]) +1;
  		
  		$this->_rows["Tabs"][$tab_name]["id"] = $tab_id;
  		$this->_rows["Tabs"][$tab_name]["name"] = str_replace(" ", "_", strtolower($tab_name));
  		$this->_rows["Tabs"][$tab_name]["Label"]["Properties"]["value"] = str_replace("_", " ", ucfirst($tab_name));
  		parent::setRow($Row);
  	}
  	
	public function setTabLabel($tab_name, $label)
  	{
  		if(is_numeric($tab_name))
  		{
  			$tabs = $this->getTabList();
  			$tab_name = $tabs[$tab_name];
  		}
  		
  		return $this->__setTabProperty(str_replace(" ", "_", strtolower($tab_name)), "Label", "Properties", "value", $label);
  	}
  	
	private function __setTabProperty($tab_name, $level, $attribute, $property, $value = "")
  	{
  		if(is_array($property))
		{ 
			$this->_rows["Tabs"][$tab_name][ucwords($level)][ucwords($attribute)] = $property;	
		} else { 
			$this->_rows["Tabs"][$tab_name][ucwords($level)][ucwords($attribute)][$property] = $value;
		}

		return true;	
  	}	
  	
	private function __setPositionRowInTab($tab_id, $tab_name)
  	{
  		$this->_rows["Tabs"][str_replace(" ", "_", strtolower($tab_name))]["id"] = $tab_id;
  	}
  	
  	private function __joinTabs($tab_id, $tab_name)
  	{
  		if(strpos($tab_name, ","))
  		{
  			$tabs = explode(",", $tab_name);
  		} else {
  			$tabs[] = $tab_name;
  		}
  		
  		if($tabs)
  		{
  			foreach($tabs AS $tab)
  			{
  				$this->_rows["Tabs"][str_replace(" ", "_", strtolower($tab))]["id"] = $tab_id;
  				$this->_rows["Tabs"][str_replace(" ", "_", strtolower($tab))]["Label"]["Properties"]["value"] = str_replace("_", " ", ucfirst($tab));
  			}	
  		}
  	}
  	
	private function __loadTabList()
  	{
  		$this->_rows["Tabs"]["list"] = $this->getTabList();
  		return true;
  	}
  	
  	
  	
  	
  	
  	
  	
/**  ****************** Display Functions *******************  **/
	
	/** 
	 * Display the selected template with the given data and customization
   	 * @return void
     **/
  	public function display() 
	{
		$this->__loadTabList();
		parent::display(); 
	}
	
	public function getHTML()
  	{
  		$this->__loadTabList();
  		$this->loadMainVariables(); 
    	
    	$Data = (object)$this->_variables;
    	extract($this->_variables);
    
    	ob_start();
    	include $this->_template;
    	return ob_get_clean();
	    //parent::getHTML();
  	}
}