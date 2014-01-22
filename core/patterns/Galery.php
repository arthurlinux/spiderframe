<?php
 
 /**
 * Holds {@link Page} class that shows a form to edit a {@link Row}
 * @author Arturo Osorio <arosbar@gmail.com>
 * @author Ismael Cortés <may.estilosfrescos@gmail.com>
 * @copyright Copyright (c) 2010, Ismael Cortés <may.estilosfrescos@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package spiderFrame
 **/

class Galery extends Template
{
	private $_view = "list";
	
	public function __construct($page_name="", $layout="")
  	{
  		parent::setPageName($page_name);
  		parent::setLayout($layout);
	    parent::setSection($template);
	    parent::setApp();
	    
	    parent::setMainMenu();
	  	parent::setSecondaryMenu();
	  	parent::addCssLink(TO_ROOT . "/apps/subcore/style/galery.css");
	  	parent::addCssLink(TO_ROOT . "/apps/subcore/style/jquery.ui/fancybox/jquery-fancybox.css");
	  	
	  	parent::addJsLink(TO_ROOT . "/core/jquery/jquery.fancybox.js");
	  	
	  	parent::setOnReady("$('.fancybox').fancybox()");
	  	parent::setTemplate(TO_ROOT . "/core/patterns/templates/Galery.tpl.php", true);
  	}
	
 	/**
   	 * Chosse to Set the SturdyRow or set set the ObjRow like Objects to be edited 
   	 * @param  Array $objRow the Array or Row to be edited
   	 * @return void
   	 * @author spidermay
     **/
  	public function setRow($Row) 
  	{
  		return false;
  		//parent::setRow($Row);
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

  	public static function setRowsByQuery($sql, DbConnection $DbConnection = null) 
	{
		$DbConnection = ($DbConnection == null) ? DbConnection::getInstance("_root") : $DbConnection ;
	  	return $this->__setRowsByQuery($sql);
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
	  				($key == "image_id")? $image_id = $value : false;
	  				$this->_rows[$row][$key]["Properties"]["value"] = $value;
	  				$this->_rows[$row][$key]["Properties"]["hide"] = true;
	  				
	  				switch ($key)
	  				{
	  					case "image":
	  						$this->_rows[$row][$key]["Properties"]["href_type"] = "hidden";
	  						$this->_rows[$row][$key]["Properties"]["href"] = "/apps/admin/image.php?image_id=" . $image_id;
	  						break;
	  						
	  					case "title":
	  						$this->_rows[$row][$key]["Properties"]["hide"] = false;
	  						$this->_rows[$row][$key]["Properties"]["class"] = "title";
	  						break;
	  					case "detail":
	  						$this->_rows[$row][$key]["Properties"]["hide"] = false;
	  						$this->_rows[$row][$key]["Properties"]["class"] = "detail";
	  						break;
	  				}
	  			}
	  		}
  		}
  	}
  	
  	public static function __setRowsByQuery($sql, DbConnection $DbConnection = null) 
	{
		$DbConnection = ($DbConnection == null) ? DbConnection::getInstance("_root") : $DbConnection ;
	  	return ($sql) ? $DbConnection->getAll($sql) : false;
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
  		$this->assign("__view", $this->_view);
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
}