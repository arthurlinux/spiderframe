<?php 
/**
 * Holds the {@link Dictionary} Singleton
 * @author spiderMAy <may.estilosfrescos@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * Provides a Config abstraction in the form of a singleton
 */
class Dictionary
{

  public    $data = array();
  public 	$section = array();
  public 	$sections = array();
  public    $language = "";
  public 	$vars = "";
  
  protected static $_instances = array();
  protected $_filepath = null;
  protected $_loaded = false;
  protected $_language = "";
  
    
   /**
    * Constructor is private so it can't be instantiated
    * @return Dictionary
    */
	public function __construct($language)
  	{
	    $this->language = $language;
	    $this->_language = $language;
		if(file_exists(TO_ROOT . "/core/languages/" . $language . ".dic"))
		{
			$this->_filepath = TO_ROOT . "/core/languages/" . $language . ".dic";
		} else if (file_exists(TO_ROOT . "/languages/" . $language . ".dic")){
			$this->_filepath = TO_ROOT . "/languages/" . $language . ".dic";
  		} else {
			$this->createNewDictionary($language);
			$this->_filepath = TO_ROOT . "/core/languages/" . $language . ".dic";
		}
	           
	    if ( !file_exists( $this->_filepath ) ) 
	    {
	      throw new RuntimeException("Couldn't load dictionary file: " . $this->_filepath);
	    }     
	}
	
  /**
   * Loads the dictionary language from an dic file into an array
   *
   * To override the default just call Dictionary::load($languaje) with your custom
   * languaje.
   * @param string $languaje
   * @return Dictionary
   */
  	public static function getInstance($language)
  	{
	    if ( !isset($_instances[$language]) || !(self::$_instances[$language] instanceof self) )
	    {
	      self::$_instances[$language] = new self($language);
	    }
	    return self::$_instances[$language];
	}
  
	public function translate($str, $section = null)
	{
		if($str)
		{
			if($this->_loaded)
			{
				if(!$section)
				{
					return $this->searchText($str);
				} else {
					return $this->searchTextBySection($str, $section);
				}
			}
		}
		
		return $str;
	}
	
	public function getLine($id)
	{
		return $this->searchTextById($id);
	}
	
	public function getSections()
	{
		if($this->_loaded)
		{
			$i = 1;
			foreach ($this->data AS $section => $values) 
			{
				$this->sections[$i++] = $section;
			}
		}
		
		return $this->sections;
	}
	
	public function getSection($section, $common_section = true)
	{
		if($section)
		{
			if($this->_loaded)
			{
				if($common_section == true)
				{
					$this->section["common"] = $this->data["common"];
				}
				
				$this->section[$section] = $this->data[$section];
			}
		}
		
		return $this->section;
	}
	
	public function setTranslateValue($value, $id)
	{ 
		if($id)
		{
			return $this->setTextById($id, $value);
		} 
		return false;
	}
	
	public function setSystemValue($value, $id)
	{
		if($id)
		{
			return $this->setTextById($id, $value, false);
		}  
		return false;
	}
	
	public function addNewLine($section, $system_value, $translate_value = "")
	{ 
		if($section)
		{
			$section = strtolower($section);
			return $this->addLine($section, $system_value, $translate_value);
		} 
		return false;
	}
	
	public function deleteLine($id)
	{
		if($id)
		{
			if($this->_loaded)
			{
				foreach ($this->data AS $section => $values) 
				{
					foreach ($values AS $value)
					{
						if($value["id"] == $id)
						{
							unset($this->data[$section][$id]);
							return true;
						}	
					}
				}
			}
		}
		return false;
	}
	
  	public function load()
  	{
  		if($this->_loaded == false)
  		{
	  		if ($this->_filepath) 
			{
			   	$rows = array_map(array(self, "splitStrings"), file($this->_filepath));
				if($rows)
				{
					$i = 0;
					foreach($rows AS $row)
				    {
				    	$i++;
				      	$text_id = $row[0];
						        	
						if( strpos($text_id, "__") )
						{ 
							$section = str_replace("[__", "", $text_id);
						    $section = str_replace("]", "", $section); 
						} 
						        	
						if( !strpos($text_id, "__"))
						{
							if($text_id) 
						    {
						    	$this->data[$section][$i]["id"] = $i;
						    	$this->data[$section][$i]["system_value"] = $text_id;
						    	$this->data[$section][$i]["translate_value"] = $row[1];
						    }
						} 
					}
					$this->vars = $this->_language;
					$this->_loaded = true;
					
				} else {
					$this->data = array();
					$this->_loaded = false;
				}
			}
  		}
  	}
  	
	private function searchText($str)
	{
		if($str)
		{
			if($this->_loaded)
			{
				foreach ($this->data AS $section => $values) 
				{
					foreach ($values AS $values) 
					{
						if(trim($str) == trim($values["system_value"]))
						{
							return ($values["translate_value"]) ? $values["translate_value"] : $str;
						}
					}
				} 
			}
		}
		return $str;
	}
	
	private function searchTextById($id)
	{
		if($id)
		{
			if($this->_loaded)
			{
				foreach ($this->data AS $section => $values) 
				{
					foreach ($values AS $value)
					{
						if($value["id"] == $id)
						{
							$value["section"] = $section;
							return $value;
						}	
					}
				}
			}
		}
		return false;
	}
	
	private function searchTextBySection($str, $section)
	{
		if($section)
		{
			if($str)
			{
				if($this->_loaded)
				{
					if($this->data[$section]){
						foreach ($this->data[$section] AS $values) 
						{
							if(trim($str) == trim($values["system_value"]))
							{
								return $values["translate_value"];
							}
						} 
					}
				}
			}
		}
		return $str;
	}
	
	private function setTextById($id, $text, $translate_value = true)
	{
		if($id)
		{
			if($this->_loaded)
			{
				foreach ($this->data AS $section => $values) 
				{
					foreach ($values AS $value)
					{
						if($value["id"] == $id)
						{
							$key = ($translate_value) ? "translate_value" : "system_value" ;
							if($text)
							{
								$this->data[$section][$id][$key] = $text;
							}
							return true;
						}	
					}
				}
			}
		}
		return false;
	}
	
	private function addLine($section, $system_value, $translate_value = "")
	{ 
		$section = ($section) ? $section : "common" ;
		if($this->_loaded)
		{
			if($system_value)
			{
				$this->data[$section][] = array("system_value" => $system_value, "translate_value" => $translate_value);
				return true;
			}
		}
		return false;
	}
	
  	private function prepareDataToSave()
  	{
  		$first = true;
  		if($this->data)
  		{
  			foreach ($this->data AS $section => $values)
  			{
  				$jump = (!$first) ? "\n" : "";
  				$data.= $jump . "[__" . $section . "]\n";
  				foreach ($values AS $value)
  				{
  					$data.= $value["system_value"] . "=>" . $value["translate_value"] . "\n";
  				}
  				$first = false;
  			}
  		}
  		return $data;
  	}
  	
	private function splitStrings($str, $parser = "=>") 
	{
        if($str !== "" && $str !== " " && $str !== "\n")
        {
        	return explode($parser,trim($str));
        }
       return false;
    }
    
	public function save()
  	{
	   	$data = $this->prepareDataToSave();
  		$openFile 	= fopen( $this->_filepath, "w");
				
	    if(fwrite($openFile, $data))
	    {
	    	fclose($openFile);
	    	return true;
	    }	
	    
	    fclose($openFile);
	  	return false;
  	}
  	

	private function createNewDictionary($language)
	{
		$library_path = TO_ROOT . "/core/languages";
		$library = opendir($library_path); 
		$dictionaries = array();
		
		while ($dictionary = readdir($library))
		{
				$fileExtension = explode ('.', $dictionary);
				if($fileExtension[0] && $fileExtension[1] == "dic")
				{
					if($fileExtension[0] == $language)
					{
						$reason = "FILEEXIST";
						return false;
					} 
				}		
		}
		
		closedir($library); 
		
  		if(copy(TO_ROOT."/core/languages/system.dic", TO_ROOT."/core/languages/".$language.".dic"))
  		{
			$reason = "CREATED";
			return true;
		} else { 
			$reason = "NOT_CREATED"; 
			return false;
		}
	}
	
	public function deleteDictionary($language)
	{
		if($language != "system")
		{
			if(unlink($this->_filepath))
			{
				return true;
			}
		}
		return false;
	}
	
}
