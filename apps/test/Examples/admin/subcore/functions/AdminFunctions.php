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

class AdminFunctions extends Functions
{
    public static function __getUserList(DbConnection $DbConnection = null) 
	{
		$DbConnection = ($DbConnection == null) ? DbConnection::getInstance("_root") : $DbConnection ;
		
	  	$sql = "SELECT 
			 		user_login.mail, 
			 		user_login.active, 
			 		user_login.user_login_id, 
			 		user_login.user_login_date, 
			 		user.names, 
			 		user.lastname, 
			 		CONCAT_WS(' ', user.names, user.lastname, user.mother_name) AS complete_name
				FROM 
					user_login, user, cat_user_rol, cat_user_x_rol 
				WHERE 
					cat_user_x_rol.user_id = user.user_id
				AND
					cat_user_x_rol.cat_user_rol_id = cat_user_rol.cat_user_rol_id
				AND
					cat_user_rol.rol = 'User' OR cat_user_rol.rol = 'user'
				AND
					user.user_login_id = user_login.user_login_id
				GROUP BY user_login.user_login_id
					";
	  	
	  	return $DbConnection->getAll($sql);
	}
	
	public static function __getUserRolesList($active = "", DbConnection $DbConnection = null) 
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
	  	
		$sql = "SELECT cat_user_rol_id, rol, description, active FROM cat_user_rol WHERE {$active_condition} ";
	  	return $DbConnection->getAll($sql);
	}
	
	public static function __getModuleList($active = "", DbConnection $DbConnection = null) 
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
	  	
  		$sql = "SELECT 
		 		cat_module.module, 
		 		cat_module.active, 
		 		cat_module.description,
		 		cat_module.cat_module_id,
		 		cat_module.module_context
			FROM 
				cat_module 
			WHERE 
  				{$active_condition}   
			";
  		
	  	return $DbConnection->getAll($sql);
	}
	
	public static function __getCatModule($active = "", DbConnection $DbConnection = null) 
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
	  	
  		$sql = "SELECT cat_module_id, module FROM  cat_module  WHERE  {$active_condition} ";
  		return $DbConnection->getPair($sql);
	}
	
	public static function __getModulePermissionList($active = "", DbConnection $DbConnection = null) 
	{
		$DbConnection = ($DbConnection == null) ? DbConnection::getInstance("_root") : $DbConnection ;
	  		
  		$sql = "SELECT 
		 		cat_module.module, 
		 		cat_module.active, 
		 		cat_module.description,
		 		cat_module.cat_module_id,
		 		cat_module.module_context,
		 		cat_module_permission.permission,
		 		cat_module_permission.permission_context,
		 		cat_module_permission.description,
		 		cat_module_permission.cat_module_permission_id,
		 		cat_module_permission.active
			FROM 
				cat_module, cat_module_permission 
			WHERE 
  				cat_module_permission.cat_module_id = cat_module.cat_module_id 
  			ORDER BY cat_module.cat_module_id";
  		
	  	return $DbConnection->getAll($sql);
	}
	
	public static function __getModuleById($cat_module_id, DbConnection $DbConnection = null) 
	{
		$DbConnection = ($DbConnection == null) ? DbConnection::getInstance("_root") : $DbConnection ;
	  	
  		$sql = "SELECT cat_module_id, module, module_context, description, active FROM  cat_module  WHERE  cat_module_id = '{$cat_module_id}' ";
  		return $DbConnection->getRow($sql);
	}	
	
	public static function __getModuleByPermissionId($cat_module_permission_id, DbConnection $DbConnection = null) 
	{
		$DbConnection = ($DbConnection == null) ? DbConnection::getInstance("_root") : $DbConnection ;
	  	
  		$sql = "SELECT 
  					cat_module.cat_module_id, 
  					cat_module.module, 
  					cat_module.module_context, 
  					cat_module.description, 
  					cat_module.active 
  				FROM  
  					cat_module, cat_module_permission  
  				WHERE  
  					cat_module.cat_module_id = cat_module_permission.cat_module_id
  				AND
  					cat_module_permission.cat_module_permission_id = '{$cat_module_permission_id}' 
  				ORDER BY 
  					cat_module.cat_module_id ";
  		return $DbConnection->getRow($sql);
	}	
	 
}