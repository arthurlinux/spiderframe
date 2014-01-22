<?php

class Page extends Template
{
	public function __construct($page_name="", $template="", $layout="default", $fullPath="")
	{ 
		parent::__construct($page_name, $layout);
		$this->setTemplate($template, $fullPath);
	}
	
	public function display()
	{
 		$this->assign("__message", $this->_message);
		$this->assign("__section", $this->_section);
		$this->assign("__on_ready", $this->_on_ready);
		$this->assign("__js_files", $this->_js_files);
		$this->assign("__css_files", $this->_css_files);
		$this->assign("__main_menu", $this->_main_menu);
		$this->assign("__jquery_theme", $this->_jquery_theme);
		$this->assign("__secondary_menu", $this->_secondary_menu);
		
		$_content = parent::runTemplate($this->_template, $this->_variables);
		
		$Data = (object)$this->_variables;
		extract($this->_variables);
		
		include $this->_layout;
	}
}