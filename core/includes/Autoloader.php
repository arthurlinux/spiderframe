<?php

/**
 * Include files based on the Instance's ClassName being created
 * Gets {@link Includes} from core/includes/
 * Gets {@link Includes} from core/functions/
 * Gets {@link Patterns} from core/patterns/
 * Gets {@link Config} from core/config/
 * Gets {@link Models} from core/models/
 * Gets {@link Subcore} from apps/subcore/models
 * Gets {@link Apps Models} from apps/{$app}/subcore/models/
 * Gets {@link Apps Functions} from apps/{$app}/subcore/functions/
 */

class Autoloader 
{
	public static function autoload($class_name)
  	{
	    $path = TO_ROOT . "/apps";
		$file_name = $class_name . ".php";
	    $hidden_files = array(".", "..", ".DS_Store");
		$apps = self::getAppFolders($path, $hidden_files);
		
	    $general_paths = array(
				        TO_ROOT . "/core/includes/",  
				        TO_ROOT . "/core/functions/",
				        TO_ROOT . "/core/patterns/",
				        TO_ROOT . "/core/config/",
				        TO_ROOT . "/core/models/",
				        TO_ROOT . "/apps/admin/models/"
	    );
	  	
		if($apps)
		{
		    foreach ($apps AS $app)
			{
				$app_paths[] = TO_ROOT . "/apps/" . $app . "/subcore/models/";
				$app_paths[] = TO_ROOT . "/apps/" . $app . "/subcore/functions/";
			}
		}
		
		$paths = array_merge($general_paths, $app_paths);
		
		foreach($paths AS $path) 
	    { 
	    	$file = $path . $file_name;
				
		    if( file_exists($file) ) 
		    {  	
		      	include_once $file;
		        return true;
		    } 
		}
		
	    return false;
  	}
  		
	/**
	 * Configure autoloading 
	 * This is designed to play nicely with other autoloaders.
	 */
	public static function registerAutoload()
	{
	    spl_autoload_register( array ("Autoloader", "autoload")  );
	}
	
	private function getAppFolders($path, $hidden_files) 
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
}