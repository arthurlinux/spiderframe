<?php
 
 /**
 * Holds {@link Page} class that shows a form to edit a {@link Row}
 * @author Arturo Osorio <arosbar@gmail.com>
 * @author Ismael Cortés <may.estilosfrescos@gmail.com>
 * @copyright Copyright (c) 2010, Ismael Cortés <may.estilosfrescos@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package spiderFrame
 **/
class Template
{
  	/**
   	 * Holds the relative path to the template
     * @var string
     */
  	protected $_template = "";
  	
  	/**
  	 * Holds the relative path to the layout
  	 * @var string
  	 */
  	protected $_layout = "";
  	
  	/**
  	 * Holds the variables to be passed to the template as $Data object
  	 * @var array
  	 */
  	protected $_variables = array();
  	
  	/**
  	 * Script to run on ready script page load
  	 * @var array
  	 */
  	protected $_on_ready  	 = array();
  	
  	/**
  	 * CSS file that belongs to a controller
  	 * @var array
  	 */
  	protected $_css_files = array();
  	
  	/**
  	 * CSS file that belongs to a controller
  	 * @var array
  	 */
  	protected $_jquery_theme = "smoothness";
  	
  	/**
  	 * Js file that belongs to a controller
  	 * @var array
  	 */
  	protected $_js_files = array();
  	
  	protected $_section = "";
  	protected $_app = "";
  	protected $_message = array();
  	
  	public $_container_properties = array();
  	
  	protected $_actions  	 	= array();
  	protected $_html_contents 	= array();
  	protected $_general_actions = array();
  	
  	/**
  	 * Holds the main menu template
  	 * @var string
  	 */
  	protected $_main_menu = "";
  	protected $_secondary_menu = "";
  	
  	protected $page_name = "";
  	
  	/**
     * Holds the rows's configuration structure 
     * Amount fields and rows
     *
     * _rows[i][j] {
     *   + field {}: specific field and properties
     *   + label: The label.
     *   + value: The default value.
     *   + help:  Little text to be show next to the field.
     *   + error_message: If set this message will be show in red below the field.
     *   + type: text, hidden, radio, select, textarea, date
     *   + parameters {}: type specific parameter.
     *   + input_parameters {}: Auto parsed input parameters.
     *   + validation: Function to be applied as validation, the function must get a
     *                 string and return true for success or false for invalid input.
     * }
     * @var array
     **/
  	protected $_rows = array();
  	
	public function __construct($page_name="", $layout="default")
  	{ 
  	  	$this->setPageName($page_name);
  	  	$this->setLayout($layout);
  	  	$this->setSection();
  	  	$this->setApp();
  	  	
  	  	$this->setMainMenu();
  		$this->setSecondaryMenu(); 
  		$this->setTemplate(TO_ROOT . "/core/patterns/templates/Template.tpl.php", true);	
  	}

  	/* ---------------- <<<< Page functions >>>> --------------------------------------------------------------------------------------------------------*/
  	//
  	//
  	/* ---------------- <<<< Page functions >>>> --------------------------------------------------------------------------------------------------------*/
  	
  	public function setSection($section = false)
  	{
  		if(!$section)
  		{
  			$this->_section = $this->getSection();
  		} else {
  			$this->_section = $section;
  		}
  	}
  	
  	public function getSection()
  	{
  	  	$_sections = explode("/",$_SERVER["PHP_SELF"]);
  	  	$_section = $_sections[count($_sections)-1];
  	  	$_section = explode(".", $_section);
  	  	$_section = $_section[0];
  	  	return $_section;
  	}
  	
  	
  	public function setApp($app = false)
  	{
  		if(!$app)
  		{
  			$this->_app = $this->getApp();
  		} else {
  			$this->_app = $app;
  		}
  	}
  	
  	public function getApp()
  	{
  	  	$_app_path = explode("/",$_SERVER["PHP_SELF"]);
  	  	
  	  	return $_app_path[3];
  	}
  	
  	public function getScriptName()
  	{
  	  	return basename($_SERVER["SCRIPT_FILENAME"], ".php");
  	}
	
  	/**
  	 * Sets the template file to be used.
  	 *
  	 * Take for granted that the file is under the relative path "templates/" and
  	 * has a "tpl.php" extension, unless you set $full_path to true
  	 * @param string  	$template The name of the template to be used
  	 * @param bool  	  	$full_path overrides the naming convention and allows you to set any file
  	 * @return void
  	 */
  	 
  	public function setTemplate($template, $full_path = false)
  	{
  		if($full_path)
  		{ 
  			if (file_exists($template)) 
  			{ 
  	  	  	  	$this->_template = $template;
  	  	 	} else {
  	  	 		$this->_template = TO_ROOT . "/apps/subcore/templates/default_template.tpl.php";
  	  	 		$this->setMessage("SORRY_ONE_OF_THE_TEMPLATES_YOU_ARE__LOOKING_FOR_WAS_NOT_FOUND", "failure");
  	  	 	}
  		 } else {
  		 	if(file_exists("templates/{$template}.tpl.php"))
  			{ 
  	  	  	  	$this->_template = "templates/{$template}.tpl.php";
  	  	 	} else {
  	  	 		$this->_template = TO_ROOT . "/core/templates/default_template.tpl.php";
  	  	 		$this->setMessage("SORRY_ONE_OF_THE_TEMPLATES_YOU_ARE__LOOKING_FOR_WAS_NOT_FOUND", "failure");
  	  	 	}
  		 }
  		 return true;
  	}
  	
  	/**
  	 * Sets the layout file to be used.
  	 *
  	 * Take for granted that the file is under the relative path "templates/" and
  	 * has a "tpl.php" extension, unless you set $full_path to true
  	 * @param string  	$layout The name of the layout to be used
  	 * @param bool  	  	$full_path overrides the naming convention and allows you to set any file
  	 * @return void
  	 */
  	public function setLayout($layout, $full_path = false)
  	{
  		if ($full_path == true)
  		{
	  		if ( file_exists($full_path) )
	  		{
	  	  	  	  	$this->_layout = $full_path . $layout . "_layout.tpl.php";
	  	  	}
  		}
  		
  		if ( file_exists(TO_ROOT . "/core/layouts/" . $layout . "_layout.tpl.php") ) {
  	  	  	  	$this->_layout = TO_ROOT . "/core/layouts/" . $layout . "_layout.tpl.php";
  	  	} else {
  	  	 	$this->_layout = TO_ROOT . "/core/layouts/default_layout.tpl.php";
  	  	} 
  	  	
  	  	return true;
  	}
  	
  	public function setMainMenu($menu_name = false)
  	{ 
  		$this->_main_menu = $this->__setMenu($menu_name, "main");
  	}
  	
  	public function setSecondaryMenu($menu_name = false)
  	{ 
  		$this->_secondary_menu = $this->__setMenu($menu_name,"secondary");
  	}
  	
  	private function __setMenu($menu_name, $level)
  	{ 
  		$application_menu_name 	= TO_ROOT. "/apps/" . $this->_app . "/subcore/navs/" . $menu_name . "_" . $level . "_menu.tpl.php";
  	  	$section_section_name 	= TO_ROOT. "/apps/" . $this->_app . "/subcore/navs/" . $this->_section . "_" . $level . "_menu.tpl.php";
  	  	$application_app_name 	= TO_ROOT. "/apps/" . $this->_app . "/subcore/navs/" . $this->_app . "_" . $level . "_menu.tpl.php";
  	  	$application_default_app= TO_ROOT. "/apps/" . $this->_app . "/subcore/navs/default_" . $this->_app . "_" . $level . "_menu.tpl.php";
  	  	$subcore_menu_name 		= TO_ROOT. "/core/navs/" . $menu_name . "_" . $level . "_menu.tpl.php";
  	  	$subcore_app_name 	 	= TO_ROOT. "/core/navs/" . $this->_app . "_" . $level . "_menu.tpl.php";
  	  	$default_nav  		 	= TO_ROOT. "/core/navs/default_" . $level . "_menu.tpl.php";
  	  		
  	  	ob_start(); 
  	  		
  	  	if( file_exists($application_menu_name) ) 
  	  	{ 
	  		include $application_menu_name;
	  	} else if( file_exists($section_section_name) ) { 
	  		include $section_section_name;
	  	} else if( file_exists($application_app_name) ) { 
  	  		include $application_app_name;
	  	} else if( file_exists($application_default_app) ) { 
	  		include $application_default_app;
	  	} else if( file_exists($subcore_menu_name) ) { 
	  		include $subcore_menu_name;
	  	} else if( file_exists($subcore_app_name) ) { 
	  		include $subcore_app_name;
	  	} else if( file_exists($default_nav) ) { 
	  		include $default_nav;
	  	}
	  	  	
	  	$__menu = ob_get_contents();
	  	ob_end_clean();
	
		if(!$__menu)
		{
			return false;
		}
		
  	  	return $__menu;
  	}
  	
  	public function assign($variable, $value)
  	{
  	  	$this->_variables[$variable] = $value;
  	}
  	
  	/**
  	 * Sets the page name depending of the layout it might be translated
  	 * @param string $page_name
  	 * @return void
  	 */
  	public function setPageName($page_name) {
  	  	$this->assign("__page_name", $page_name);
  	  	$this->page_name = $page_name;
  	}
  	
 	/**
  	 * Sets the page title depending of the layout it might be translated
  	 * @param string $page_title
  	 * @return void
  	 */
  	public function setPageTitle($page_title = true) 
  	{
  		if($page_title == true)
  		{
  			$page_title = $this->page_name;
  		}
  		
  	  	$this->assign("__page_title", $page_title);
  	}
  	
  	/** 
  	 * Sets the javascript code to be run when the pase document ready loading
  	 * 
  	 * @param string $function javascript
  	 * @param string $function parameters
  	 * @return void
  	 */  	 
  	public function setOnReady()
  	{
  		$__args = func_get_args();
  	  	$__function = array_shift($__args);
  	 
	$this->_on_ready[][$__function] = ($__args) ? $__args=str_replace("}'", "}",(str_replace("'{", "{", "'" . implode("','",$__args) . "'"))) : "";
  	}
  	
	/** 
  	 * Sets message for page
  	 * 
  	 * @param string $message
  	 * @param string $level 'info', 'success', 'failure', 'atention'
  	 * @return void
  	 */  	 
  	public function setMessage($message, $level = "info")
  	{
  		$this->_message["level"] = $level;
  		$this->_message["message"] = $message;
  	}
  	
  	/** 
  	 * Sets file link css
  	 * 
  	 * @param string $full_path
  	 * @return void
  	 */  	 
  	public function addCssLink($full_path, $media="screen")
  	{
  		$__array = explode(".", $full_path); 
  		//$__file = $__array[1];
		$__extension = strtolower(end($__array));
		if($__extension == "css"){
	  	  		$this->_css_files[]= array("file" => $full_path, "media" => $media);
		}
  	}
  	
  	/**
  	 * Sets the jQuery theme UI
  	 * @param string $jquery_theme
  	 * @return void
  	 */
  	public function setJQueryTheme($jquery_theme) 
  	{
  	  	$this->_jquery_theme = $jquery_theme;
  	}
  	
  	/** 
  	 * Sets file link javascript
  	 * 
  	 * @param string $full_path
  	 * @return void
  	 */  	 
  	public function addJsLink($full_path)
  	{ 
  		$__array = explode(".", $full_path); 
		$__extension = strtolower(end($__array));
		
		if($__extension == "js"){
  	  		$this->_js_files[]=$full_path;
		}
  	}
  	
	public function setTable(Table $Table) {
    	$this->_html_contents[]["Tables"][] = $Table;
 	}
  
  	public function setForm(Form $Form){
    	$this->_html_contents[]["Forms"][] = $Form;
  	}
  
 	public function setDetail(Detail $Detail){
    	$this->_html_contents[]["Details"][] = $Detail;
  	}
  	
	public function setTab(Tabs $Tabs){
    	$this->_html_contents[]["Tabs"][] = $Tabs;
  	}
  	
	public function setGalery(Galery $Galery){
    	$this->_html_contents[]["Galery"][] = $Galery;
  	}
  
  	/**
  	 * Jumps to the given url, sending a message.
  	 * @param string $url 
  	 * @param string $message
  	 * @param string $level might be: info, warning, error, success 
  	 * @return false
  	 */
  	public function goToPage($url = "index.php", $message = "", $level="info") 
  	{
  	  	if ( $message ) {
  	  	  	$this->setMessage($message, $level);
  	  	}
  	  	header("location: " . $url);
  	  	die();
  	}
  	
  	/**
  	 * Run the Template in the cleanest enviroment posible
  	 * @param unknown_type $template
  	 * @param unknown_type $data
  	 * @return unknown_type
  	 */
  	protected static function runTemplate($template, $data) 
  	{
  	  	$Data = (object)$data; /// @todo Backwards Compatibility Remove Before Release
  	  	extract($data);
  	 
  	  	ob_start();
  	  	include $template;
  	  	$_content = ob_get_contents();
  	  	ob_end_clean();
  	  	
  	  	return $_content;
  	} 
  	
    public function loadMainVariables()
  	{  
  		$this->assign("__rows",	$this->_rows);
	    $this->assign("__actions", $this->_actions);
	    $this->assign("__message", $this->_message);
  	  	$this->assign("__section", $this->_section);
  	  	$this->assign("__on_ready", $this->_on_ready);
  	  	$this->assign("__js_files", $this->_js_files);
  	  	$this->assign("__css_files", $this->_css_files);
  	  	$this->assign("__main_menu", $this->_main_menu);
  	  	$this->assign("__jquery_theme", $this->_jquery_theme);
  	  	$this->assign("__html_contents", $this->_html_contents);
  	  	$this->assign("__secondary_menu", $this->_secondary_menu);
  	  	$this->assign("__general_actions", $this->_general_actions);
	    $this->assign("__container_properties",	$this->_container_properties);
  	  	
  		return true;
  	}
  	
  	/**
  	 * Shows the given template
  	 *
  	 * Converts the $variables array into $Data object and sets any message that may
  	 * be in the $Data and finally calls the given template
  	 * @return void
  	 */
  	public function display()
  	{
  	  	$this->loadMainVariables(); 
  	  	$_content = self::runTemplate($this->_template, $this->_variables);
  	  	
  	  	$Data = (object)$this->_variables;
  	  	extract($this->_variables);
  	  	
  	  	include $this->_layout;
  	}
  	
	/**
   	 * Shows the given template
  	 *
  	 * Converts the $variables array into $Data object and sets any message that may
  	 * be in the $_SESSION and finally calls the given template
  	 * @return void
   	 */
  	public function getHTML()
  	{
    	$this->loadMainVariables(); 
    	
    	$Data = (object)$this->_variables;
    	extract($this->_variables);
    
    	ob_start();
    	include $this->_template;
    	return ob_get_clean();
  	}
  	/* ---------------- <<<< Page functions >>>> --------------------------------------------------------------------------------------------------------*/
  	//
  	//
  	/* ---------------- <<<< Page functions >>>> --------------------------------------------------------------------------------------------------------*/

  	
  	
  	
  	
  	
  	
	/* ---------------- <<<< Page Row functions >>>> ----------------------------------------------------------------------------------------------------*/
  	//
  	//
  	/* ---------------- <<<< Page Row functions >>>> ----------------------------------------------------------------------------------------------------*/
  		
  	
	/**
   	 * Set gives an unique id to the html's form markup
     * @param string $form_id
     * @return void
     **/
	 public function setContainerId($form_id)
	 {
	    return $this->setContainerProperty("id", $form_id);
	 }
  
  	/**
   	 * Set name form markup
  	 * @param string $name
  	 * @return void
  	 **/
  	public function setContainerName($name)
  	{
    	return $this->setContainerProperty("name", $name);
  	}
  
  	/**
     * Set 'Action' for Form
     * @param string $target
     * @return void
     **/
  	public function setContainerTarget($target)
  	{
    	return $this->setContainerProperty("target", $target);
  	}
  
  	/**
   	 * Set class names form markup
     * @param string $className
     * @return void
     **/
  	public function setContainerClass($className)
  	{
    	return $this->setContainerProperty("class", $className);
  	}
  
  	/**
   	 * Set class names form markup
  	 * @param string $className
   	 * @return void
  	 **/
 	public function setContainerProperty($property, $value)
  	{ 
  		$this->_container_properties[$property] = $value;
  		return true;
  	}
  
  	/**
   	 * Unsets the form properties
     *
     * @param $property string the property name 
     * @return bool true on success false otherwise
     **/
  	public function unsetContainerProperty($property)
   	{
  		return $this->_container_properties[$property] = "";
  	}
  	
  	/**
   	 * Chosse to Set the SturdyRow or set set the ObjRow like Objects to be edited 
   	 * @param  Array $objRow the Array or Row to be edited
   	 * @return void
   	 * @author spidermay
     **/
  	public function setRow($Row) 
  	{
  		if(!is_array($Row))
	  	{
	  		return $this->__setRow($Row);
	  	}
  	}
  	
	/**
   	 * Sets the given field's property value
     * @param string $field name the field
     * @param string $property
     * @param mixed $value
     * @return bool true on success false otherwise
     **/
  	public function setFieldProperty($field, $property, $value) 
    {
	  	return $this->__setProperty($field, "Field", "Properties", $property, $value);
  	}
  	
  	/**
     * Set the id for specific field in row
     * @param string $field the name of the field
     * @param string $name_id the name of the apply
     * @param string $field_id 
     * @return void
     **/
  	public function setFieldId($field, $name_id, $field_id) 
  	{
  		return $this->__setPropertyId($field, "Field", "Properties", $name_id, $field_id);
  	}
  
	/**
     * Sets the given field's property value
     * @param string $field
     * @param mixed $value
     * @return bool true on success false otherwise
     **/
  	public function setFieldValue($field, $value)
  	{
  		return $this->__setProperty($field, "Field", "Properties", "value", $value);
  	}
  	
  	/**
   	 * Sets the field's property items, transform field input to select or radio
     * @param string $field
     * @param array $items $key => $value
     * @return bool true on success false otherwise
     **/
  	public function setFieldItems($field, $items, $type=false)
  	{
		if ( count($items) <= 3 ) 
		{
			$this->__setProperty($field, "Field", "Properties", "type", "radio");
		} else {
		   	$this->__setProperty($field, "Field", "Properties", "type", "select");
		}
		
		if($type)
		{
			$this->__setProperty($field, "Field", "Properties", "type", $type);
		}
		
		$this->__unsetProperty($field, "Field", "Properties", "maxlength", "");
		$this->__setProperty($field, "Field", "Items", $items); 
		return true;
  	}
  
  	/**
   	 * Set the name class for this field in row to be apply format
   	 * @param string $field the name of the field
     * @param string $className the name of the class
     * @return void
     **/
  	public function setFieldClass($field, $className) 
  	{
  		return $this->__setProperty($field, "Field", "Properties", "class", $className);
  	} 
  	
  	/**
   	 * Add class for this field in row to be apply format
   	 * @param string $field the name of the field
     * @param string $className the name of the class
     * @return void
     **/
  	public function addFieldClass($field, $className) 
  	{
  		$data = $this->__getPositionRow($field);
		
	  	if($data)
	  	{
	  		if($data["values"]["Field"]["Properties"]["type"] == "text")
	  		{
	  			$_new_class = $className . " ". $data["values"]["Field"]["Properties"]["class"];
		    	return $this->__setProperty($field, "Field", "Properties", "class", $_new_class);
	  		}
		}
	  	return false;
  	} 
  	
	/**
     * Disable Field
     *
     * @param string $field the name of the field to disabled
     * @return bool true on success false otherwise
     **/
  	public function disableField($field)
  	{
  		return $this->__setProperty($field, "Field", "Properties", "readonly", "readonly");
  	}
  	
	/**
   	 * Sets the given field's repeat
     * @param string $field name the field
     * @param string $position after or before
     * @return bool true on success false otherwise
     **/
  	public function repeatField($field, $position="after") 
  	{
  		return $this->__repeatRow($field, $position);	
  	}
  	
	/**
   	 * Sets the field as hidden
     *
     * Commonly used with the row id.
     * To really delete the field from the Form use {@link deleteField}.
     * @param string $fields the name of the field to hide or array name to fields to hide
     * @return bool true on success false otherwise
     **/
  	public function hideField($fields)
   	{
  		if(is_array($fields))
  		{
  			foreach($fields AS $field)
  			{
  				$this->__setProperty($field, "Row", "Properties", "class", "__hide");
  				$this->__setProperty($field, "Field", "Properties", "type", "hidden");
  			}
  		} else {
  			$this->__setProperty($fields, "Row", "Properties", "class", "__hide");
  			$this->__setProperty($fields, "Field", "Properties", "type", "hidden");	
  		}
  		//$this->__setProperty($field, "Row", "Properties", "style", "display:'none'");
  		return true;
  	}
  	
	/**
     * Sets the field as show after hidden 
     *
     * @param $field string the field name in row
     * @return bool true on success false otherwise
     **/
  	public function showField($field, $field_type="text")
  	{
  		$this->__unsetProperty($field, "Row", "Properties", "class", "__hide");
	  	$this->__unsetProperty($field, "Field", "Properties", "class", "__hide");
	  	$this->__setProperty($field, "Field", "Properties", "type", $field_type);
	  	return true;
  	}
  	
	/**
   	 * Sets the given field's property value
     * @param string $field name the field
     * @param string $href
     * @param bool $replace_id
     * @return bool true on success false otherwise
     **/
  	public function setLinkedField($field, $href, $replace_id = true) 
    {
    	$href = (!$replace_id) ? $href : $this->__linkedHrefById($href);
    	return $this->__setProperty($field, "Field", "Properties", "href", $href);
  	}
  	
	/**
     * Sets required fields in form 
     *
     * array $fields string the field name in row
     * @return bool true on success false otherwise
     **/
  	public function setFieldRequired($fields, $required_class = "__required")
  	{
  		if(is_array($fields))
  		{
	  		foreach($fields AS $field)
	  		{
	  			$this->addFieldClass($field, $required_class);
	  			$this->addRowClass($field, $required_class);
	  		}
  		} else if(strtolower($fields) == "all"){
  			foreach($this->_rows AS $__rows)
		    {
			  	foreach($__rows AS $__row)
		    	{ 
		    		$this->addFieldClass($__row["Row"]["Row"], $required_class);
		    		$this->addRowClass($__row["Row"]["Row"], $required_class);
			    }
	    	} 
  		} else {
  			$this->addRowClass($fields, $required_class);
  			$this->addFieldClass($fields, $required_class);
  		}
  		
  		return true;
  	}
  	
	/**
     * Unsets required fields in form 
     *
     * array $fields string the field name in row
     * @return bool true on success false otherwise
     **/
  	public function unsetFieldRequired($fields, $required_class = "__required")
  	{
  		if(is_array($fields))
  		{
	  		foreach($fields AS $field)
	  		{
	  			$this->unsetFieldProperty($field, "class", $required_class);
	  			$this->unsetRowProperty($field, "class", $required_class);
	  		}
  		} else if(strtolower($fields) == "all"){
  			foreach($this->_rows AS $__rows)
		    {
			  	foreach($__rows AS $__row)
		    	{ 
		    		$this->unsetFieldProperty($__row["Row"]["Row"], "class", $required_class);
	  				$this->unsetRowProperty($__row["Row"]["Row"], "class", $required_class);
			    }
	    	} 
  		} else {
  			$this->unsetFieldProperty($fields, "class", $required_class);
	  		$this->unsetRowProperty($fields, "class", $required_class);
  		}
  		
  		return true;
  	}
  	
    /**
     * Unsets the field property 
     *
     * @param $field string the field name in row
     * @param $property string the property name to unset
     * @param $value string the property value optional
     * @return bool true on success false otherwise
     **/
  	public function unsetFieldProperty($field, $property, $value="")
  	{
  		return $this->__unsetProperty($field, "Field", "Properties", $property, $value);
  	}
  	
  	
  	
  	
  	//@todo hacer función para traer valores en condicion
	/** *
  	public function setFieldCondition($table, $field = "active", $compare = "1", $success = "Active", $failure = "Inactive")
  	{
  		$finished = false;                       // we're not finished yet (we just started)
		while ( ! $finished )
		{                  // while not finished
		  $rn = rand();                          // random number
		  $outfile = $finaldir.'/'.$rn.'.gif';   // output file name
		  if ( ! file_exists($outfile) ):        // if file DOES NOT exist...
		    $finished = true;                    // ...we are finished
		  endif;
		}
		   
  		return $this->__setProperty($field, "Field", "Properties", "value", $value);
  	}
  	/** */
	
	/**
	 * Deletes a field from the form
	 *
	 * If you only wish to hide a field use {@link hideField}
	 * @param string $field the name of the field to be deleted
	 * @return void
	 */
	public function deleteField($field) 
	{
	 	return $this->__usetRow($field);
	}
	
	
  	
  	
	/**
	 * Sets the given label's property label
	 * @param string $field
	 * @param mixed $label
	 * @return bool true on success false otherwise
	 **/
	public function setLabel($field, $label)
	{
		return $this->__setProperty($field, "Label", "Properties", "value", $label);
	}
	
	/**
	 * Sets the given label's property label
	 * @param string $field
	 * @param mixed $label
	 * @return bool true on success false otherwise
	 **/
	public function setLabelValue($field, $label)
	{
		return $this->__setProperty($field, "Label", "Properties", "value", $label);
	}
	
	/**
	 * Sets the given label's property 
	 * @param string $field
	 * @param mixed $property
	 * @param mixed $value
	 * @return bool true on success false otherwise
	 */
	public function setLabelProperty($field, $property, $value)
	{
		return $this->__setProperty($field, "Label", "Properties", $property, $value);
	}
	
	/**
	 * Sets the given label's property 
	 * @param string $field
	 * @param mixed $className
	 * @return bool true on success false otherwise
	 */
	public function setLabelClass($field, $className)
	{
		return $this->__setProperty($field, "Label", "Properties", "class", $className);
	}
	
	/**
	 * Sets the field as hidden
	 *
	 * Commonly used with the row id.
	 * To really delete the field from the Form use {@link deleteField}.
	 * @param string $field the name of the field to hide
	 * @return bool true on success false otherwise
	 */
	public function hideLabel($field)
	{
		return $this->__setProperty($field, "Label", "Properties", "class", "__hide");
		//$this->__setProperty($field, "Label", "Properties", "style", "display:'none'");
	}
	
	/**
	 * Sets the label as show after hidden 
	 *
	 * @param $field string the field name in row
	 * @return bool true on success false otherwise
	 */
	public function showLabel($field)
	{
		$this->__unsetProperty($field, "Label", "Properties", "class", "__hide");
		$this->__unsetProperty($field, "Row", "Properties", "class", "__hide");
		return true;
	}
	
	/**
	 * Unsets the label property 
	 *
	 * @param $field string the field name in row
	 * @param $property string the property name to unset
	 * @param $value string the property value optional
	 * @return bool true on success false otherwise
	 */
	public function unsetLabelProperty($field, $property, $value="")
	{
		return $this->__unsetProperty($field, "Label", "Properties", $property, $value);
	}
  	
  	
	
	/**
   	 * Inserts an splitter Title (with optional content) at the given position.
     * @param string $title The field after the separator will be created
     * @param string $target The content that will be inside the splitter
     * @param string $name The splitter title name
     * @param string $position 'after' or 'before', Default: 'after'
     * @return bool true on success false otherwise
     **/
  	public function insertTitle($title, $target, $position="before", $size="h1", $name="")
  	{
  		$name = ($name) ? $name : $target;
  		
    	$field_data= array( "Field"=>array("Properties"=>array(
					 									"value"=>$title,
														"type"=>"title",
	    												"name"=>"{$name}_Title",
	    												"id"=>"{$name}_Title",
    													"size"=>$size,
														),
										),
						);
    	return $this->__insertRow("{$name}_Title", $field_data, $target, $position);
  	}
  
    /**
     * Set the title's properties on field
     * @param string $field to start nested list
     * @param string $property
     * @param mixed $value
     * @return bool true on success false otherwise
     */
  	public function setTitleProperty($field, $property, $value)
  	{
  		return $this->__setProperty($field, "Field", "Properties", $property, $value);
  	}
  
  	/**
  	 * Set the class property title 
  	 * @param string $field to start nested list
  	 * @param string $className
  	 * @return bool true on success false otherwise
  	 **/
  	public function setTitleClass($field, $className)
  	{
  		return $this->__setProperty($field, "Field", "Properties", "class", $className);
  	}
	
	
	
	/**
	 * Sets the given rows's property 
	 * @param string $field
	 * @param mixed $property
	 * @param mixed $value
	 * @return bool true on success false otherwise
	 */
	public function setRowProperty($field, $property, $value)
	{
		return $this->__setProperty($field, "Row", "Properties", $property, $value);
	}
	
	/**
	 * Sets the given rows's property 
	 * @param string $field
	 * @param mixed $className
	 * @return bool true on success false otherwise
	 */
	public function setRowClass($field, $className)
	{
		$this->__setProperty($field, "Row", "Properties", "class", $className);
		$this->__setProperty($field, "Field", "Properties", "class", $className);
		return true;
	}
	
	/**
   	 * Add class for this row to be apply format
   	 * @param string $field the name of the field
     * @param string $className the name of the class
     * @return void
     **/
  	public function addRowClass($field, $className) 
  	{
  		$data = $this->__getPositionRow($field);
	
	  	if($data)
	  	{
	  		if($data["values"]["Field"]["Properties"]["type"] == "text")
	  		{
	  			$_new_class = $className . " ". $data["values"]["Row"]["Properties"]["class"];
		    	return $this->__setProperty($field, "Row", "Properties", "class", $_new_class);
	  		}
		}
	  	return false;
  	} 
  	
	/**
	 * Disabled the row as hidden row function call
	 *
	 * Commonly used with the row id.
	 * To really delete the field from the Form use {@link deleteField}.
	 * @param string $field the name of the field to hide
	 * @return bool true on success false otherwise
	 */
	public function disableRow($field)
	{
		return $this->hideRow($field);
	}
	
	/**
	 * Sets the row as hidden
	 *
	 * Commonly used with the row id.
	 * To really delete the field from the Form use {@link deleteField}.
	 * @param string $field the name of the field to hide
	 * @return bool true on success false otherwise
	 */
	public function hideRow($field)
	{
		$this->__setProperty($field, "Row", "Properties", "class", "__hide");
		$this->__setProperty($field, "Field", "Properties", "type", "hidden");
		$this->__setProperty($field, "Field", "Properties", "readonly", "readonly");
		//$this->__setProperty($field, "Row", "Properties", "style", "display:'none'");
		return true;
	}
	
	/**
	 * Sets the row as hidden false
	 *
	 * @param $field string the field name in row
	 * @param $field_type string optional type for field 
	 * @return bool true on success false otherwise
	 */
	public function showRow($field, $field_type="text")
	{
		$this->__unsetProperty($field, "Row", "Properties", "class", "__hide");
		$this->__setProperty($field, "Field", "Properties", "type", $field_type);
		//$this->__setProperty($field, "Row", "Properties", "style", "display:''");
		return true;
	}
	
	/**
	 * Unsets the field property 
	 *
	 * @param $field string the field name in row
	 * @param $property string the property name to unset
	 * @param $value string the property value optional
	 * @return bool true on success false otherwise
	 */
	public function unsetRowProperty($field, $property, $value="")
	{
		return $this->__unsetProperty($field, "Row", "Properties", $property, $value);
	}
  	
  	
  	
  	
	/**
	 * Add an action to the end & start of the Form, commonly used to add a
	 * "Delete" link
	 *
	 * @param string $action The action that will be called after clicking (url)
	 * @param string $title The text to show and will be added to the url title as well
	 * @param string $params The field to add into de URL
	 * @param string $value The value that such field should take usally 0 for new elements
	 * @param string $iconThe optional icon that could go with the text
	 * @return void
	 */
	public function addAction($value, $href = "", $replace_id = true, $action_data = false)
	{ 
		$action = $this->__prepareActionData($value, $href, $replace_id, $action_data);
		return  $this->__addAction($action);
	}
  	
	public function addActiveAction($id, $replace_id = true)
	{ 
		$action = $this->__prepareActiveActionData($id, $replace_id);
		return  $this->__addAction($action);
	}
	
	public function addGeneralAction($value, $href = "", $replace_id = true, $action_data = false)
	{ 
		$new_href = (!$replace_id) ? $href : $this->__linkedHrefById($href);
		
		$action["value"]= ( (is_array($action_data) ) && ( !empty($action_data["value"]) ))	? $action_data["value"]: $value;
		$action["href"] = ( (is_array($action_data) ) && ( !empty($action_data["href"]) ))	? $action_data["href"]: $new_href;
		$action["class"]= ( (is_array($action_data) ) && ( !empty($action_data["class"]) ))	? $action_data["class"]: "";
		$action["id"] 	= ( (is_array($action_data) ) && ( !empty($action_data["id"]) ))	? $action_data["id"]: strtolower(str_replace(" ", "_", $value));
		
		return  $this->__addAction($action, "general_actions");
	}
	
	protected function __prepareActionData($value, $href = "", $replace_id = true, $action_data = false)
	{
		$new_href = (!$replace_id) ? $href : $this->__linkedHrefById($href);
		$new_id = ($id) ? $id : strtolower(str_replace(" ", "_", $value));
		
		$action["id"] 	= ( (is_array($action_data) ) && ( !empty($action_data["id"]) ))	? $action_data["id"]: $new_id;
		$action["value"]= ( (is_array($action_data) ) && ( !empty($action_data["value"]) ))	? $action_data["value"]: $value;
		$action["href"] = ( (is_array($action_data) ) && ( !empty($action_data["href"]) ))	? $action_data["href"]: $new_href;
		$action["class"]= ( (is_array($action_data) ) && ( !empty($action_data["class"]) ))	? $action_data["class"]: "";
		
		return $action;
	}
	
	protected function __prepareActiveActionData($id, $replace_id = true)
	{
		$params = explode("-", $id);
		$data = $this->__getPositionRow($params[2]);
		$table = $data["values"]["Row"]["Table"];
		$id_value = $data["values"]["Field"]["Properties"]["value"] ;
		$data = $this->__getPositionRow("active");
		
		for($i=0; $i>=count($this->_rows); $i++)
		{ 
			if(($table == $data["values"]["Row"]["Table"]))
			{
				$table = $data["values"]["Row"]["Table"];
			} else {
				$data = $this->__getPositionRow("active", $i);
			}
		}
		
		$value = ($data["values"]["Field"]["Properties"]["value"] == "1") ? "Inactive" : "Active" ;
		$active = $data["values"]["Field"]["Properties"]["value"];
		
		$action["value"] = $value;
		$action["class"] = "active_action";
		$action["id"] = $params[0] . "-" . $params[1] . "-" . $id_value . "-" . $active;
		
		return $action;
	}
	
	private function __addAction($action_data, $type = "actions")
	{
		if($type == "actions")
		{
			$this->_actions[] = $action_data;
			return true;
		} else if($type == "general_actions"){
			$this->_general_actions[] = $action_data;
			return true;
		}
		
		return false;
	}
	
	private function __linkedHrefById($href)
	{
		$glue = "";
		$href_collection = $this->__getArrayParamsByHref($href);
		
		if($href_collection["params"])
		{
			foreach($href_collection["params"] AS $key => $value)
			{ 	
				$data = $this->__getPositionRow($value);
				$id = ($data["values"]["Field"]["Properties"]["value"]) ? $data["values"]["Field"]["Properties"]["value"] : $value ;
				$params = $params . $glue . $key . "=" . $id; 
				$glue = "&";
			}
			
			$new_href = $href_collection["href"] . "?" . $params;
		}
		return $new_href;
	}
	
	protected function __getArrayParamsByHref($href)
	{
		$href = explode("?", $href);
		$params = $href[1];
		$params = explode("&", $params);
		
		if($params)
		{	
			foreach($params AS $param )
			{
				$_params = explode("=", $param);
				$id_collection[$_params[0]] = $_params[1];
			}
		}
		
		$success["href"] = $href[0];
		$success["params"] = $id_collection;
		
		return $success;
	}
	
	/**
	 * Moves the given field after another field
	 * @param string $field The field to move
	 * @param string $after_field The field after the $field will be located
	 * @return bool true on success and false otherwise
	 */
	public function moveAfter($field, $after_field)
	{
		return $this->__moveRow($field, $after_field);
	}
	
	/**
	 * Moves the given field before another field
	 * @param string $field The field to move
	 * @param string $after_field The field after the $field will be located
	 * @return bool true on success and false otherwise
	 */
	public function moveBefore($field, $before_field)
	{
		return $this->__moveRow($field, $before_field, "before");
	}
	
	/**
	 * Moves the given field to the start of the form
	 * @param string $field the field to be moved
	 * @return bool true in success and false otherwise
	 */
	public function moveToStart($field)
	{
		return $this->__moveRow($field, "", "start");
	}
	
	/**
	 * Moves the given field to the end of the form
	 * @param string $field the field to be moved
	 * @return bool true in success and false otherwise
	 */
	public function moveToEnd($field)
	{
		return $this->__moveRow($field, "", "");
	}
	
	
	
	
	/**
	 * 
	 * Sets the show or hide macth list section
	 * @param bool $show true show macth list section, else hide macth list section
	 */
	public function setShowMathch($show=true)
	{
		$this->_showHideMatch = ($show) ? "": "__hide";
		return true;
	}
	
	/**
	 * Insert a Field after or before the given target
	 * @param string $field_name How will be named the field
	 * @param array $field_data a complete field array
	 * @param string $target The name of the field after or before we'll
	 * insert the new field.
	 * @param string $position 'after' or 'before', Default: 'after'
	 * @return bool true on success false otherwise
	 */
	public function insertField($field_name, $value = "", $target="", $position="after", $field_data="")
	{
		if( ($field_data == "") || (!is_array($field_data)) )
		{
			$field_data = array(
								"Field"=>array("Properties"=>array(
					 									"type"=>"text",
														"value"=>$value,
														"name"=>( (is_array($field_data)) && (empty($field_data["Label"]["Properties"]["value"]) )) ? $field_data["Field"]["Properties"]["name"]: $field_name,
														"id"=>$field_name . "_0",
														"data-id"=> $field_name,
														),
												),
								 "Label"=>array("Properties"=>array(
														"name"=>( (is_array($field_data)) && (empty($field_data["Label"]["Properties"]["value"]) )) ? $field_data["Field"]["Properties"]["name"]: $field_name,
								 						"value"=>ucfirst(str_replace("_", " ", ( (is_array($field_data)) && (empty($field_data["Label"]["Properties"]["value"]) )) ? $field_data["Field"]["Properties"]["name"]: $field_name ))
														)
												),
					);
		}
		
	if( empty($field_data["Field"]["Properties"]["name"]) )
	{
	 		$field_data["Field"]["Properties"]["name"] = $field_name;
	}	
	 
	if( empty($field_data["Field"]["Properties"]["data-id"]) )
	{
	 		$field_data["Field"]["Properties"]["data-id"] = $field_name;
	}	
	
	if( empty($field_data["Field"]["Properties"]["id"]) )
	{
	 		$field_data["Field"]["Properties"]["id"] = $field_name . "_0";
	}
	
	if( (is_array($field_data)) && (empty($field_data["Label"]["Properties"]["value"])) )
	{
			$field_data = array("Label"=>array("Properties"=>array(
								 						"value"=>$field_name,
														)
												),
					);
		}
		
		return $this->__insertRow($field_name, $field_data, $target, $position);
	}
	
	
  	
	/**
     * Copy row, copy and paste in the psotion after o before
     * @param string $field name the field in row to copy
     * @param string $position after or before
     * @return bool true on success false otherwise
     **/
  	private function __copyRow($field, $position="after") 
    {
	  	return $this->__repeatRow($field, $position);	
  	}
	
	
	/**
     * Repeat row, copy and paste in the psotion after o before
     * @param string $field name the field in row
     * @param string $position after or before
     * @return bool true on success false otherwise
     **/
  	private function __repeatRow($field, $position="after") 
    {
	  	$data = $this->__getPositionRow($field);
	
	  	if($data)
	  	{
		    $_new_field = $data["values"];
		    $_new_field["Row"]["Row"] = "repeat_" . $_new_field["Row"]["Row"];
		    $_new_field["Field"]["Properties"]["name"] = "repeat_" . $_new_field["Field"]["Properties"]["name"];
		    $_new_field["Field"]["Properties"]["id"] = "repeat_" . $_new_field["Field"]["Properties"]["id"];
		    $_new_field["Field"]["Properties"]["title"] = "Repeat " . $_new_field["Field"]["Properties"]["name"];
		    
		    $_new_field["Label"]["Properties"]["value"] = "Repeat " . $_new_field["Label"]["Properties"]["value"];
			$_new_field["Label"]["Properties"]["for"] = $_new_field["Field"]["Properties"]["id"];
		
			$this->_rows[][] = $_new_field;
			$this->__moveRow($_new_field["Row"]["Row"], $field, $position);
		  	return true;
	  	}
	  	return false;	
  	}
  
  	/**
   	 * Moves the given field before or after another field
	 * @param string $field The field to move
     * @param string $after_field The field after the $field will be located
     * @param string $position after or before
     * @return bool true on success and false otherwise
     **/
	private function __moveRow($first_field, $second_field, $position="after")
    {
	  	$data = $this->__getPositionRow($first_field); 
	  	if($position == "start" || $position == "first")
	  	{
	  		$second_field = $this->_rows[0][0]["Row"]["Row"];
	  		$position = "before";
	  	}
	  	
	  	if( !empty($data) )
	  	{
	  		unset($this->_rows[$data["position_i"]][$data["position_j"]]);
	  		return $this->__insertRow($first_field, $data["values"], $second_field, $position);
	  	}
	  	return false;
	}
  
  	/**
     * Insert a Field after or before the given target this function is private
     * @param string $field_name How will be named the field
     * @param array $field_data a complete field array
     * @param string $target The name of the field after or before we'll
     *                       insert the new field.
     * @param string $position 'after' or 'before', Default: 'after'
     * @return bool true on success false otherwise
     **/
  	private function __insertRow($field_name, $field_data, $target="", $position="after")
   	{
    	$j = 0;
	    $success = false;
	    $new_rows = array();
	    $new_values = array();
	  	
	    $new_values = $field_data;
	    $new_values["Row"]["Row"] = $field_name;
	    
	    if($target)
	    {
		    $i=0;
		    foreach($this->_rows AS $__rows)
		    {
			  	$j=0;
			  	$l=0;
		    	foreach($__rows AS $__row)
		    	{
		    		$new_rows[$i][$l] = $this->_rows[$i][$j];
		    		if($__row["Row"]["Row"] == $target )
			  		{  
			  			$l = $j+1;
				  		if($position == "after")
				  		{
				  			$new_rows[$i][$l]= $new_values;
				  		} else if($position == "before"){
				  			$new_rows[$i][$l-1] = $new_values;
				  			$new_rows[$i][$l]= $this->_rows[$i][$j];
				  		}
				  		$success = true;		
			  		}
			  		$j++;
			  		$l++;
			    }
			    $i++;
		    }
		    
		    if($success)
		    {
		    	$this->_rows = $new_rows;
		    } else {
		    	$this->_rows[][] = $new_values;
		    }
		    
	    } else {
	    	$this->_rows[][] = $new_values;
			$success = true;
	    } //print_r($new_rows);
	    return $success;
  	}
	
  
	/**
     * Sets the given row's property value in private performance
     * @param string $row row or field to be afected
     * @param string $key space to be afected
     * @param string $property set property
     * @param mixed $value value for property
     * @return void
     **/
  	protected function __setProperty($row, $level, $key, $property, $value="") 
  	{
		$i=0;
		$succes = false;
	    foreach($this->_rows AS $__rows)
	    {
		  	$j=0;
	    	foreach($__rows AS $__row)
	    	{ 
	    		if($__row["Row"]["Row"] == $row ) 
		  		{ 
		  			if(is_array($property))
		  			{ 
		  				$this->_rows[$i][$j][ucwords($level)][ucwords($key)] = $property;		
		  			} else { 
		  				$this->_rows[$i][$j][ucwords($level)][ucwords($key)][$property] = $value;
		  			}
		  			
		  			$succes = true;
		  		}
		  		$j++;
		    }
		    $i++;
	    } 
	    return $succes;
	}
	
	/**
     * Unsets the given rows's properties
     * @param string $row row or field to be afected
     * @param string $key space to be afected
     * @param string $property set property
     * @param mixed $value value for property
     * @return void
     **/
	protected function __unsetProperty($row,$level,$key,$property,$value) 
   	{
	    $i=0;
	    $succes = false;
	    foreach($this->_rows AS $__rows)
	    {
		  	$j=0;
	    	foreach($__rows AS $__row)
	    	{
	    		if($__row["Row"]["Row"] == $row )
		  		{
		  			if($value)
		  			{
			  			$__value = $this->_rows[$i][$j][ucwords($level)][ucwords($key)][$property];
			  			
			  			if($value !="" && (strpos($__value, $value) !== false ) )
			  			{
			  				$__value = str_replace($value, " ", $__value);
			  			}
		  			}
		  			
		  			$this->_rows[$i][$j][ucwords($level)][ucwords($key)][$property] = $__value;
		  			
		  			if(!$value)
		  			{
			  			unset($this->_rows[$i][$j][ucwords($level)][ucwords($key)][$property]);	
		  			}
		  			
		  			$succes = true;	  			
		  		}
		  		$j++;
		    }
		    $i++;
	    } //print_r($this->_rows);
	    return $succes;
  	}
  	
  	/**
     * Deletes a field from the form
     *
     * If you only wish to hide a field use {@link hideField}
     * @param string $field the name of the field to be deleted
     * @return void
     **/
  	protected function __unsetRow($row) 
  	{
	   	$i=0;
	   	$succes = false;
	    foreach($this->_rows AS $__rows)
	    {
		  	$j=0;
	    	foreach($__rows AS $__row)
	    	{
	    		if($__row["Row"]["Row"] == $row )
		  		{
		  			unset( $this->_rows[$i][$j] );
		  			$succes = true;  			
		  		}
		  		$j++;
		    }
		    $i++;
	    } //print_r($this->_rows);
	    return $succes;
  	}
  
	/**
   	 * 
     * This function returns the value or the position of a row based on another row of the same group
     * @param string $row the row to find 
     * @param integer $position the reference row  
     * @param bool $value return value, returns string if is true, returns position if false 
     * @return Ambigous <number, string> | boolean
     **/
  	protected function __getPositionRow($row, $id = false)
  	{
	  	$i=0;
	  	$data = array();
	  	foreach($this->_rows AS $__rows)
	    { 
	    	$j=0;
	    	foreach ($__rows AS $__row)
	    	{
	    		if($id)
	    		{
		    		if( ($__row["Row"]["Row"] == $row) && ($i > $id) )
				  	{
				  		$data["position_i"] = $i;
				  		$data["position_j"] = $j;
						$data["values"] =  $__row;
						return $data;
				  	}
	    		} else {
			    	if($__row["Row"]["Row"] == $row )
				  	{
				  		$data["position_i"] = $i;
				  		$data["position_j"] = $j;
						$data["values"] =  $__row;
						return $data;
				  	}
	    		}
	    		
			    $j++; 
	    	}
	    	$i++; 
	    }
	}
	
	/**
	 * Set the Row Object to be edited
	 *
	 * @param  Row $Sturdyrow the Row to be edited
	 * @return void
	 **/
  	private function __setRow(Row $Row) 
  	{ 
  	  	$i = count($this->_rows);
	    if($this->_rows[$i] = $this->__getRowsByRow($Row))
	    {
	    	return true;
	    }
	    return false;
  	}
  	
  	
	/**
	 * Set the Row Object to be edited
	 *
	 * @param  Row $Sturdyrow the Row to be edited
	 * @return void
	 **/
  	private function __getRowsByRow(Row $Row) 
  	{ 
  	  	$j = 0 ; 
  	  	$i = ($i) ? $i : count($this->_rows);
	    $rows = array();
	    $Structure = $Row->getTableStructure();
	    if($Structure)
	    {
	    	$Table = $Row->getTableName();
	    	$rows[$j]["Metadata"]["Table"] = $Table;
		    $rows[$j]["Metadata"]["Package"] = array_keys($Structure);
	    	foreach($Structure AS $field)
		    {
		    	$name = $field["Field"];
		    	preg_match("/^([a-z]*)(?:\((.*)\))?\s?(.*)$/", $field["Type"], $_type);
		      	$id = $Row->getId();
		    	$rows[$j]["Row"]["Row"] = $name;
		    	$rows[$j]["Row"]["Table"] = $Row->getTableName();
		    	$rows[$j]["Field"] = $this->__setField($_type);
		      	$rows[$j]["Field"]["Properties"]["id"] = $name . "_" . $id;
		      	$rows[$j]["Field"]["Properties"]["data-id"] = $name;
				$rows[$j]["Field"]["Properties"]["name"] = $name . "_" . $id . "_" . $i;
				
		      	$label = ucwords(str_replace("_id", "", $name));
				$rows[$j]["Label"]["Properties"]["value"] =  str_replace("_", " ", $label);
				$rows[$j]["Label"]["Properties"]["for"] = $name . "_" . $id;
				
				$_value = ( isset($Row->data[$name]) ) ? htmlspecialchars($Row->data[$name]): htmlspecialchars($Structure[$name]["Default"]) ;
				$rows[$j]["Field"]["Properties"]["value"] = $_value ;
				
				if($name == "password")
				{ 
					$rows[$j]["Field"]["Properties"]["value"] = "";
					$rows[$j]["Field"]["Properties"]["type"] = "password";
				}     	
			
		    	if( strpos($name, "date") !== false || strpos($name, "birthday") !== false )  
				{ 
					$rows[$j]["Field"]["Properties"]["class"] = "__date";
					$rows[$j]["Field"]["Properties"]["readonly"] = "readonly";
					$rows[$j]["Field"]["Properties"]["value"] = ($_value) ? date("d/m/Y", $_value): date("d/m/Y");
				}
				
		    	if( (strpos($name, "active") !== false) || (strpos($name, "delete") !== false) || (strpos($name, "secret") !== false) || (strpos($name, "_id") !== false)) 
				{ 
					$rows[$j]["Row"]["Properties"]["class"] = "__hide";
					$rows[$j]["Field"]["Properties"]["type"] = "hidden";
				}
				$j++; 
		    }
	    }
	    return $rows;
  	}
  	
	/**
	 * This private function extract type information from field.
	 * @param $_type array field properties
	 * @return $aux array set values
	 * @property $_type[0] The whole string. ie: int(11) unsigned
	 * @property $_type[1] The type ie: int
	 * @property $_type[2] The type parameters ie: 11
	 * @property $_type[3] Extra ie: unsigned
	 **/
  	protected function __setField($_type)
  	{ 
	  	$aux = array();
	  	switch($_type[1])
	  	{
			case "char":
			case "varchar":
				if ( $_type[2] <= 100 ) {
					$aux["Properties"]["type"] = "text";
				    $aux["Properties"]["maxlength"] = $_type[2];
				    $aux["Properties"]["size"] = round( $_type[2]*.35 );
				} else {
				    $aux["Properties"]["cols"] = "60";
				    $aux["Properties"]["rows"] = "6";	
				    $aux["Properties"]["type"] = "textarea";		            
				}
				break;
				
			case "text":
				$aux["Properties"]["cols"] = "60";
				$aux["Properties"]["rows"] = "6";
				$aux["Properties"]["type"] = "textarea";
				break;
				
			case "int":
		        $aux["Properties"]["type"] = "text";
	          	$aux["Properties"]["maxlength"] = $_type[2];
	          	break;
	          	
	        case "date":
	          	$aux["Properties"]["type"] = "date";
	          	$aux["Properties"]["Default"] = date("d/m/Y");
	          	$aux["Properties"]["class"] = "__date";
	          	$aux["Properties"]["maxlength"] = 10;
	          	$aux["Properties"]["readonly"] = "readonly"; 
	          	break;
	        
	        case "set":
	        case "enum":  
	        	if ($_type[2] == "'0','1'") {
		        	$items = array("1"=> "Yes", "0"=> "No");
		        } else {
		            /** Retrive and parse Options **/
		            $items = array();
		            $params  = explode("','", $_type[2]);
		            $params[0] = substr($params[0], 1); //remove the first quote
		            $params[count($params)-1] = substr($params[count($params)-1], 0, -1);//remove the second quote
		            $items = array_combine($params, $params);//creates a createCombox compatible array
		        }
		        
		        $aux["Properties"]["type"] = "select";
		        
		        if ( count($items) <= 3 ) {
		            $aux["Properties"]["type"] = "radio";
		        }
		        
		        $aux["Items"] = $items;
		        break;
	      }	
	      return $aux;
  	}
  	/* ---------------- <<<< Page Row functions >>>> ----------------------------------------------------------------------------------------------------*/
  	//
  	//
  	/* ---------------- <<<< Page Row functions >>>> ----------------------------------------------------------------------------------------------------*/
  	
}