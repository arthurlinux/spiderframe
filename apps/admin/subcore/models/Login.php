<?php 

/**
 * Class Login Extend of Row, simplyfing data access and modification
 * Holds the {@link Login} model
 * @package spiderFrame
 * @author Ismael Cortés <may.estilosfrescos@gmail.com>
 * @copyright Copyright (c) 2010, Ismael Cortés <may.estilosfrescos@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package spiderFrame
 */
class Login extends Row
{
  	public $user_id = 0;
	public $start_today = ""; //mktime("0","0","0", date("m"), date("d"), date("Y")); 
  	public $end_today = ""; //mktime("23","59","59", date("m"), date("d"), date("Y")); 
    private static $table = "user_login";
  
  	public function __construct($user_login_id, DbConnection $DbConnection = null)
  	{
  		parent::__construct(self::$table, (int)$user_login_id, $DbConnection);
  	}
  
  	public static function getInstance($user_login_id, DbConnection $DbConnection = null)
  	{
  		if( !isset(parent::$_instances[self::$table][$user_login_id]) ) 
    	{
     		$Row = new Login((int)$user_login_id, $DbConnection);
      		parent::$_instances[self::$table][$user_login_id] = $Row;
    	} 
    	return parent::$_instances[self::$table][$user_login_id];
  	}
  
  	public function load()
  	{
  		parent::load();
  		$this->loadUserID();
  	}
  
  	public function loadSession()
  	{
    	$_SESSION["nick"] 			= $this->data["nick"];
		$_SESSION["mail"] 			= $this->data["mail"];
		$_SESSION["active"] 		= $this->data["active"];
		$_SESSION["user_login_id"] 	= $this->data["user_login_id"];
		$_SESSION["token"] 			= md5("spiderToken" . mktime(0,0,0, date("m"), date("d"), date("Y"))) . "|" . $this->id . "|" . md5($this->data["mail"] . mktime(0,0,0, date("m"), date("d"), date("Y"))) . "|" . $this->data["password"];
    	return true;
  	}
  
  	public function validatePassword($password)
  	{
    	$this->assertLoaded();
    
    	if( md5($password) !== $this->data["password"] ) 
    	{
      		return false;
   		}
    
    	return true;
  	}
  
  	public function assertUniqueMail ($mail)
  	{
    	$sql = "SELECT mail FROM user_login WHERE mail='{$mail}' LIMIT 1";
    	
    	if($this->DbConnection->getValue($sql)) 
    	{
      		return false;
    	}
    	
    	return true;
  	}
  
  	public function isActive()
  	{
    	return ( $this->data["active"] == "1" ) ? true : false;
  	}
  
  	public function createSecret ($type_x = false, $long = 3)
  	{
  		$type_x = ($type_x == false) ? trim($this->data["nick"]) : mt_rand(2,$long);
  		return Functions::__createSecret("user_login", "secret", $type_x, 10, $this->DbConnection);  	
  	}
  
  	public function loadProfile()
  	{
  		$this->load();
  		/**
  		$this->loadStatus();
  		$this->loadUserData();
  		$this->loadCatUserId();
  		$this->loadCatMemberId();
  		$this->loadAccountData();
  		$this->loadUserPhoneData();
  		$this->loadPictureProfile();
  		$this->loadUserAddressData();
  		/** */
  		return true;
  	}
  
	public function loadUserID()
  	{
    	if($this->user_id = $this->getUserID()) 
    	{
      		return true;
    	}
    	
    	return false;
  	}
  	
	public function getUserID()
  	{
    	$sql = "SELECT user_id FROM user WHERE user_login_id='{$this->id}' LIMIT 1";
    	
    	if($user_id = $this->DbConnection->getValue($sql)) 
    	{
      		return $user_id;
    	}
    	
    	return false;
  	}
  	
	public function getAddressID()
  	{
    	$sql = "SELECT user_address_id FROM user_address WHERE user_id='{$this->user_id}' LIMIT 1";
    	
    	if($user_address_id = $this->DbConnection->getValue($sql)) 
    	{
      		return $user_address_id;
    	}
    	
    	return false;
  	}
  	
	public function getUserAccountID()
  	{
    	$sql = "SELECT user_account_id FROM user_account WHERE user_id='{$this->user_id}' LIMIT 1";
    	
    	if($user_account_id = $this->DbConnection->getValue($sql)) 
    	{
      		return $user_account_id;
    	}
    	
    	return false;
  	}
  	
	public function getUserPartnerID()
  	{
    	$sql = "SELECT user_partner_id FROM user_partner WHERE user_id='{$this->user_id}' LIMIT 1";
    	
    	if($user_partner_id = $this->DbConnection->getValue($sql)) 
    	{
      		return $user_partner_id;
    	}
    	
    	return false;
  	}
  	
	public function getUserRolID($rol)
  	{
  		$rol = ucfirst($rol);
    	$sql = "SELECT 
    				cat_user_x_rol_id 
    			FROM 
    				cat_user_x_rol, cat_user_rol 
    			WHERE 
    				cat_user_x_rol.cat_user_rol_id = cat_user_rol.cat_user_rol_id
    			AND
    				cat_user_rol.rol = '{$rol}'
    			AND
    				cat_user_x_rol.user_id='{$this->user_id}' 
    			LIMIT 1";
    	
    	if($user_rol_id = $this->DbConnection->getValue($sql)) 
    	{
      		return $user_rol_id;
    	}
    	
    	return false;
  	}
  	
	public function getUserModules()
  	{
  		$sql = "SELECT 
  					cat_module.cat_module_id, cat_module.module, cat_module.description
  				FROM 
  					cat_module, cat_module_permission, user_permission 
  				WHERE 
  					cat_module_permission.cat_module_id = cat_module.cat_module_id
  				AND
  					user_permission.cat_module_permission_id = cat_module_permission.cat_module_permission_id
  				AND 
  					user_permission.user_login_id='{$this->id}' 
  		  		";
  	
  		return $this->DbConnection->getPair($sql);
  	}
  
	public function loadUserData()
  	{
  		$sql = "SELECT * FROM user WHERE user_login_id = '{$this->id}'";
  		$user_data = $this->DbConnection->getRow($sql);
  	
  		if($user_data)
  		{
  			foreach ($user_data AS $key => $value)
  			{
  				$this->data[$key] = $value;
  			}
  			return true;
  		}
  		return false;
  	}
  	
	public function loadPermissionData()
  	{
  		$sql = "SELECT 
  					user_permission.user_permission_id, user_permission.active,
  					cat_module.cat_module_id, cat_module.module, cat_module.description, 
  					cat_module_permission.cat_module_permission_id, cat_module_permission.permission
  				FROM 
  					cat_module, cat_module_permission
  					
  					LEFT JOIN 
  						user_permission
  					ON 
  						user_permission.cat_module_permission_id = cat_module_permission.cat_module_permission_id
  					AND 
  						user_permission.user_login_id='{$this->id}' 
  				WHERE 
  					cat_module_permission.cat_module_id = cat_module.cat_module_id
  		  		";
  				
  		$data = $this->DbConnection->getAll($sql);
  	
  		if($data)
  		{
  			foreach ($data AS $values)
  			{ 
  				$this->data["permission"][$values["module"]]["module"] = $values["module"];
	  			$this->data["permission"][$values["module"]][$values["permission"]] = $values["active"];
	  		}
  			return true;
  		}
  		return false;
  	}
	
	public function loadRolesData()
  	{
  		$sql = "SELECT 
  					cat_user_rol.cat_user_rol_id, cat_user_rol.rol,
  					cat_user_x_rol.cat_user_x_rol_id, cat_user_x_rol.active
  				FROM 
  					cat_user_rol, cat_user_x_rol
  				WHERE 
  					cat_user_x_rol.cat_user_rol_id = cat_user_rol.cat_user_rol_id
  				AND
  					cat_user_x_rol.user_id = '{$this->user_id}' 
  		  		";
  				
  		$data = $this->DbConnection->getAll($sql);
  		
  		if($data)
  		{ 
  			foreach ($data AS $key => $values)
  			{ 
  				$this->data["roles"][$values["cat_user_rol_id"]]["rol"] = $values["rol"];
	  			$this->data["roles"][$values["cat_user_rol_id"]]["active"] = $values["active"];
	  			$this->data["roles"][$values["cat_user_rol_id"]]["cat_user_rol_id"] = $values["cat_user_rol_id"];
	  			$this->data["roles"][$values["cat_user_rol_id"]]["cat_user_x_rol_id"] = $values["cat_user_x_rol_id"];
	  		} 
  			return true; 
  		}
  		return false;
  	}
  	
}
