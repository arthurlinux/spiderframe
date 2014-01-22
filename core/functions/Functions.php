<?php  
  
if( !defined('TO_ROOT') ) { define('TO_ROOT', '..'); }
  
  /**
 * Provides a General Functions
 * Holds the {@link Functions} class
 * @author Arturo Osorio <arosbar@gmail.com>
 * @author Ismael Cortés <may.estilosfrescos@gmail.com>
 * @copyright Copyright (c) 2010, Ismael Cortés <may.estilosfrescos@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package spiderFrame
 */

class Functions 
{
	private static $lang 			= null;
	private static $dictionary 		= null;
	private static $dictionary_file = null;
    private static $dictionaries	= null;
    
    public static function __test()
    {
    	return "hello world";
    }
    
	public static function __displayVariable($variable)
  	{
  		echo "<pre>";
  		print_r($variable);
  		echo "</pre>";
  	}

	public function __saveRow($table_name, $id, $data, $instance_db_connection)
	{
		$DbConnection = DbConnection::getInstance($instance_db_connection); 
		$Row = ($id >= 1) ? Row::getInstance($table_name, $id, $DbConnection) : Row::getNewInstance($table_name, $id, $DbConnection) ;
		
		if($data)
		{
			foreach($data AS $key => $value)
			{
				$Row->data[$key] = $value;
			}
			
			$returnData["data"] = $data;
			$returnData["table"] = $table_name;
			$returnData["success"] = $Row->save();
			$returnData["instance_db_connection"] = $instance_db_connection;
			$returnData["id"] = ($id >= 1) ? $id : $DbConnection->getLastId();
			
			return $returnData;
		}
	}
  	
	/* <<<<<<<<< -----  Create Secret  ------->>>>>>>>>>>*/
  	public static function __createSecret($table, $field, $type_x="", $long=15, $case_sensitive = false, DbConnection $DbConnection = null)
  	{
  		$DbConnection = ($DbConnection == null) ? DbConnection::getInstance("_root") : $DbConnection ;
  		
	  	$possible = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_";
	 	$done = false ;
		$random=mt_rand(2, $long);

		do {
			/** Crear codigo **/
			for ($i=0;$i<$long;$i++)
			{
				$char = substr($possible, mt_rand(0, 63), 1);
			  	$code .= $char;
			  	if(strlen($code)==$random)
			  	{
			  		$code .=$type_x;
			  	}
			}
			
			$code = ($case_sensitive) ? strtolower($code) : $code ;
			/** Checa duplicados **/
			$sql = "SELECT $field FROM $table WHERE $field='".$code."' LIMIT 1";
			if (!$DbConnection->getValue($sql)) 
			{
			  $done = true;
			}
			
		} while ( !$done );
		 /** Done!! **/
		 return trim($code);
	}
	
	public function __getStartTime() 
	{ 
        list($usec, $sec) = explode(" ",microtime()); 

        return ((float)$usec + (float)$sec); 
  	} 
  
	public static function __diference_time($start_time, $end_time)
	{
	    $start_hour	  = substr($start_time, 0, 2);
	    $start_minute = substr($start_time, 3, 2);
	    $start_second = substr($start_time, 6, 2);
	 
	    $end_hour 	= substr($end_time,0,2);
	    $end_minute	= substr($end_time,3,2);
	    $end_second	= substr($end_time,6,2);
	 
	    $start 	= ( ( ($start_hour * 60) * 60) + ($start_minute * 60) + $start_second );
	    $end 	= ( ( ($end_hour * 60) * 60) + ($end_minute * 60) + $end_second);
	 
	    $difference = $end - $start;
	 	
	    $difference_hour = floor($difference / 3600);
	    $difference_minute = floor( ($difference - ($difference_hour * 3600) ) /60);
	    $difference_second = $difference - ($difference_minute * 60) - ($difference_hour * 3600);
	    //return $difference_minute;
	    //return date("H:i:s",mktime($difference_hour,$difference_minute));
    	return date("H:i:s", mktime($difference_hour, $difference_minute, $difference_second) );
	}
	
	
	public static function __T($str, $section = false, $language = LANGUAGE) 
	{	
		return self::__Translate($str, $section, $language);
	}
	
	public static function __Translate($str, $section = false, $language=LANGUAGE) 
	{	
		$Dictionary = Dictionary::getInstance($language);
		$Dictionary->load();
		return $Dictionary->translate($str, $section);
    }
    
	public static function __getDictionaries() 
	{
	  	$library_path = TO_ROOT . "/core/languages";
		$library = opendir($library_path); 
		$dictionaries = array();
		
		while ($dictionary = readdir($library))
		{
				$i++;
				$fileExtension = explode ('.', $dictionary);
				if($fileExtension[0] && $fileExtension[1] == "dic")
				{
					$dictionaries[$i] = $fileExtension[0]; 
				} 
		}
		
		closedir($library); 
		return $dictionaries;	  
  	}
    
	public static function __getDictionary($page_section = false, $language = LANGUAGE) 
	{
		if(!isset(self::$dictionary_file ))
		{
			self::$dictionary_file = TO_ROOT . "/core/languages/" . $language . ".dic";
        }
        
        if(!$page_section) 
		{
			$page_section = "common";
		}
		
		if (file_exists(self::$dictionary_file)) 
		{
			if(!isset(self::$dictionary[$language]))
			{
	            if (file_exists(self::$dictionary_file)) 
	            {
	            	$rows = array_map(array(self, "__splitStrings"), file(self::$dictionary_file));
		            if($rows)
					{
						foreach($rows AS $row)
				        {
				        	$text_id = str_replace(" ", "_", $row[0]);
				        	$text_id = str_replace(".", "", $text_id);
				        	$text_id = str_replace("-", "_", $text_id);
				        	
				        	if( strpos($text_id, "__") )
				        	{ 
				        		$section = str_replace("[__", "", $text_id);
				        		$section = str_replace("]", "", $section); 
				        	} 
				        	
				        	if( !strpos($text_id, "__") && ("[__" . $section . "]" == "[__" . $page_section . "]" || "[__" . $section . "]" == "[__common]") )
				        	{
				        		if($text_id) 
				        		{
				        			self::$dictionary[$language][$text_id] = $row[1];
				        		}
				        	} 
				        }
				         return self::$dictionary[$language];
					} else {
						$returnData["success"] = "0";
						$returnData["file"] = self::$dictionary_file;
						$returnData["reason"] = "DICTIONARYISEMPTY";
						return $returnData;
					}
	            } else {
					$returnData["success"] = "0";
					$returnData["file"] = self::$dictionary_file;
					$returnData["reason"] = "DICTIONARYNOTEXIST";
				}
	        } else {
	        	return self::$dictionary[$language];
	        }
		}
	}
	
	public static function __splitStrings($str, $parser = "=>") 
	{
        if($str !== "" && $str !== " " && $str !== "\n")
        {
        	return explode($parser,trim($str));
        }
       return false;
    }
    
	/* <<<<<<<<< -----  Logout  ------->>>>>>>>>>>*/
  	public static function __sessionDestroy()
	{
		$_SESSION = array();
		unset($_SESSION);
		session_destroy();
	    session_start();  
		return true;
	}
	
	/**
	 * Returns date and to convert for a date format
	 * @return varchar date
	 */
	public static function __getFormatDate($date, $format = false, $style = "d-m-Y")
	{
		$style = ($style) ? $style : "d-m-Y" ;
		switch ($format)
	  	{
	  		default:
	  			$new_date = ($date) ? date($style, $date) : date($style, mktime());
	  			break;
	  			
	  		case "time":
	  			$new_date =  ($date) ? date("H:i:s", $date) : date("H:i:s", mktime());
	  			break;
	  		
			case "with_time":
	  			$new_date =  ($date) ? date($style . " H:i:s", $date) : date($style . " H:i:s", mktime());
	  			break;
			
	  		case "short":
				$new_date["d"] =  date("d", $date);
				$new_date["m"] =  date("m", $date);
				$new_date["y"] =  date("Y", $date);
				
				break;
	  	}
	    return $new_date;
	}
	
	public static function __getNext($table, $anchor, &$next, &$previous, DbConnection $DbConnection = null)
  	{
  		$DbConnection = ($DbConnection == null) ? DbConnection::getInstance("_root") : $DbConnection ;
  		
		$sql = "SELECT {$table}_id FROM {$table} ORDER BY {$table}_id DESC";
		if($last_id = $DbConnection->getValue($sql))
		{
  			$next = ($anchor == $last_id) ? 1 : $anchor + 1;
  			$previous = ($anchor == 1) ? $last_id : $anchor - 1;
  			return true;
		}
		return false;
  	}
	
	public static function __getFolders($path, $hidden_files) 
	{
		$folders = array();
	  	$library = opendir($path);
			
		while ($folder = readdir($library))
		{
		  	if(!is_file($folder))
		  	{
		  		if($folder != in_array($folder, $hidden_files) )
		  		{
		  			$folders[] = $folder;
		  		}
		  	}
		}
		
		closedir($library); 
		return $folders;	  
  	}

	public static function __createRadioButton($items, $selected, $extra_parameters='')
  	{ 
	  	$i=1;
	    foreach ( $items AS $key => $value )
	    { 
	    	$output.= "<input ";
	      	if ( $key==$selected || $i == 1) 
	      	{
	        	$output .=" checked=\"checked\" ";
	      	}
	      	 
	      	$i++;
	      	$output.=" value='{$key}' $extra_parameters /> " . self::__Translate(ucwords($value)) . " ";
	    }
	    return $output;
  	}
  	
	public static function __getApps() 
	{
		$apps_path = TO_ROOT . "/apps";
		$hidden_files = array(".", "..", ".DS_Store", "subcore", "landing");
			
		return self::__getFolders($apps_path, $hidden_files);	  
  	}
  	
  	/**
  	 * Get all Countries on Array Pair
  	 * @param enum 1 or 0 $active
  	 * @param DbConnection $DbConnection
  	 */
	public static function __getCountries($active = "1", DbConnection $DbConnection = null) 
	{
	  	$DbConnection = ($DbConnection == null) ? DbConnection::getInstance("_world") : $DbConnection ;
	  	$sql = "SELECT country_id, country FROM country WHERE active = '{$active}' ";
	  	
	  	return $DbConnection->getPair($sql);
	}
	  
	/**
  	 * Get all States by country_id on Array Pair
  	 * @param integer $country_id is the country id for states
  	 * @param enum 1 or 0 $active
  	 * @param DbConnection $DbConnection
  	 */
	public static function __getStates($country_id = "2", $active = "1", DbConnection $DbConnection = null) 
	{
	  	$DbConnection = ($DbConnection == null) ? DbConnection::getInstance("_world") : $DbConnection ;
	  	$sql = "SELECT state_id, state FROM state WHERE country_id = '{$country_id}' AND active = '{$active}' ";
	  	
	  	return $DbConnection->getPair($sql);
	}
	  
	/**
  	 * Get all cities by state_id on Array Pair
  	 * @param integer $state_id is the state id for cities
  	 * @param enum 1 or 0 $active
  	 * @param DbConnection $DbConnection
  	 */
	public static function __getCities($state_id = "23", $active = "1", DbConnection $DbConnection = null) 
	{
		$DbConnection = ($DbConnection == null) ? DbConnection::getInstance("_world") : $DbConnection ;
	  	$sql = "SELECT city_id, city FROM city WHERE state_id = '{$state_id}' AND active = '{$active}' ";
	  	
	  	return $DbConnection->getPair($sql);
	}
  	
	public static function __getLocationByCity($city_id, DbConnection $DbConnection = null) 
	{
		$DbConnection = ($DbConnection == null) ? DbConnection::getInstance("_world") : $DbConnection ;
	  	$sql = "SELECT 
	  				city.city,
	  				city.city_id,
	  				state.state, 
	  				state.state_id, 
	  				country.country, 
	  				country.country_id
	  			FROM 
	  				country, state, city 
	  			WHERE 
	  				state.country_id = country.country_id
	  			AND
	  				city.state_id = state.state_id 
	  			AND
	  				city.city_id = '{$city_id}' ";
	  	
	  	return $DbConnection->getRow($sql);
	}
	
	public static function __getCatUserRolID($rol, DbConnection $DbConnection = null) 
	{
		$DbConnection = ($DbConnection == null) ? DbConnection::getInstance("_root") : $DbConnection ;
  	
  		$rol = ucfirst($rol);
    	$sql = "SELECT cat_user_rol_id FROM cat_user_rol WHERE rol = '{$rol}' LIMIT 1";
    	
    	if($cat_user_rol_id = $DbConnection->getValue($sql)) 
    	{
      		return $cat_user_rol_id;
    	}
    	
    	return false;
  	}
  	
	public static function __getCatModule($active = "1", DbConnection $DbConnection = null) 
	{
		$DbConnection = ($DbConnection == null) ? DbConnection::getInstance("_root") : $DbConnection ;
	  	switch($active)
	  	{
	  		case "0":
	  			$active_condition = "active = '0'";
	  			break;
	  		
	  		case "1":
	  			$active_condition = "active = '1'";
	  			break;
	  			
	  		case "":
	  		case "all":
	  			$active_condition = "active <> ''";
	  			break;
	  			
	  	}
	  	
		$sql = "SELECT cat_module_id, module FROM cat_module WHERE {$active_condition} ";
	  	
	  	return $DbConnection->getPair($sql);
	}
	
	public static function __getCatUserRoles($active = "1", DbConnection $DbConnection = null) 
	{
		$DbConnection = ($DbConnection == null) ? DbConnection::getInstance("_root") : $DbConnection ;
	  	switch($active)
	  	{
	  		case "0":
	  			$active_condition = "active = '0'";
	  			break;
	  		
	  		case "1":
	  			$active_condition = "active = '1'";
	  			break;
	  			
	  		case "":
	  		case "all":
	  			$active_condition = "active <> ''";
	  			break;
	  			
	  	}
	  	
		$sql = "SELECT cat_user_rol_id, rol FROM cat_user_rol WHERE {$active_condition} ";
	  	
	  	return $DbConnection->getPair($sql);
	}
	
	public static function __hasPermission($module, $permission, $user_login_id = false, DbConnection $DbConnection = null)
  	{
  		$DbConnection = ($DbConnection == null) ? DbConnection::getInstance("_root") : $DbConnection ;
  		$user_login_id = ($user_login_id) ? $user_login_id : $_SESSION['user_login_id'];
  		
  		$sql= "SELECT 
  					user_permission.user_permission_id 
  			   FROM 
  			   		cat_module, cat_module_permission, user_permission 
  			   WHERE 
  			   		cat_module_permission.cat_module_id = cat_module.cat_module_id
  			   AND
  			   		user_permission.cat_module_permission_id = cat_module_permission.cat_module_permission_id
  			   AND
  			   		cat_module.module = '{$module}' 
  			   AND
  			   		cat_module_permission.permission = '{$permission}' 
  			   AND 
  			   		user_permission.user_login_id='{$user_login_id}' 
  			   AND 
  			   		user_permission.active = '1' ";
  		
		return ($DbConnection->getValue($sql)) ? true : false;
  	}
  	
	public static function __hasPermissionByToken($module, $permission, $token, DbConnection $DbConnection = null)
  	{
  		$DbConnection = ($DbConnection == null) ? DbConnection::getInstance("_root") : $DbConnection ;
  		$user_login_id = self::__getUserLoginIdByToken($token);
  		
  		if($user_login_id)
  		{
  		 	$sql= "SELECT mail, password FROM user_login WHERE user_login.user_login_id = '{$user_login_id}' ";
  		 	$user = $DbConnection->getRow($sql);
  		 	$user_token = md5("spiderToken" . mktime(0,0,0, date("m"), date("d"), date("Y"))) . "|" . $user_login_id. "|" . md5($user["mail"] . mktime(0,0,0, date("m"), date("d"), date("Y"))) . "|" . $user["password"];
  		}
  		
  		if($user_token == $token)
  		{
  			return self::__hasPermission($module, $permission, $user_login_id, $DbConnection);
  		}
  		
		return false;
  	}
  	
	public static function __getUserLoginIdByToken($token)
  	{
  		$values = explode("|", $token);
  		$user_login_id = ($values[1] != "") ? $values[1] : false;
  		
  		return $user_login_id;
  	}
  	
	public static function __getImageGaleryList($type, $active = "1", DbConnection $DbConnection = null) 
	{
		$DbConnection = ($DbConnection == null) ? DbConnection::getInstance("_root") : $DbConnection ;
	  	switch($active)
	  	{
	  		case "0":
	  			$active_condition = "AND image.active = '0'";
	  			break;
	  		
	  		case "1":
	  			$active_condition = "AND image.active = '1'";
	  			break;
	  			
	  		case "":
	  		case "all":
	  			$active_condition = "AND image.active <> ''";
	  			break;
	  			
	  	}
	  	
		$sql = "SELECT 
					image_id, title, image, detail, date 
				FROM 
					image, cat_image 
				WHERE 
					image.cat_image_id = cat_image.cat_image_id
				AND 
					cat_image.type = '{$type}' 
				{$active_condition} ";
	  	
	  	return $DbConnection->getAll($sql);
	}
}