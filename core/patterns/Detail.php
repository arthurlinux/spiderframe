<?php
 
 /**
 * Holds {@link Page} class that shows a form to edit a {@link Row}
 * @author Arturo Osorio <arosbar@gmail.com>
 * @author Ismael Cortés <may.estilosfrescos@gmail.com>
 * @copyright Copyright (c) 2010, Ismael Cortés <may.estilosfrescos@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package spiderFrame
 **/

class Detail extends Template
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
	  	parent::addCssLink(TO_ROOT . "/apps/subcore/style/tables.css");
	  	parent::setTemplate(TO_ROOT . "/core/patterns/templates/Detail.tpl.php", true);
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
  		parent::setRow($Row);
  	}
  	
/**  ****************** Display Functions *******************  **/
	
	/** 
	 * Display the selected template with the given data and customization
   	 * @return void
     **/
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
	    //parent::getHTML();
  	}
}