<?php define("TO_ROOT", "../../../..");  
header("Content-Type: application/json");
require_once TO_ROOT . "/core/includes/main.inc.php";

$returnData = Array();
	
$user_id = ( isset( $_POST["user_id"] ) ) ? $_POST["user_id"] : false;  	
$user_id = ( !$user_id && isset( $_GET["user_id"] ) ) ? $_GET["user_id"] : $user_id; 

$active = ( isset( $_POST["active"] ) ) ? $_POST["active"] : false;  	
$active = ( !$active && isset( $_GET["active"] ) ) ? $_GET["active"] : $active; 

$cat_user_rol_id = ( isset( $_POST["cat_user_rol_id"] ) ) ? $_POST["cat_user_rol_id"] : false;  	
$cat_user_rol_id = ( !$cat_user_rol_id && isset( $_GET["cat_user_rol_id"] ) ) ? $_GET["cat_user_rol_id"] : $cat_user_rol_id; 

$cat_user_x_rol_id = ( isset( $_POST["cat_user_x_rol_id"] ) ) ? $_POST["cat_user_x_rol_id"] : false;  	
$cat_user_x_rol_id = ( !$cat_user_x_rol_id && isset( $_GET["cat_user_x_rol_id"] ) ) ? $_GET["cat_user_x_rol_id"] : $cat_user_x_rol_id; 

$token = ( isset( $_POST["token"] ) ) ? $_POST["token"] : false;  	
$token = ( !$token && isset( $_GET["token"] ) ) ? $_GET["token"] : $token;  
$token = ( !$token && isset( $_SESSION["token"] ) ) ? $_SESSION["token"] : $token;
$returnData["test"] = "$cat_user_x_rol_id - $cat_user_rol_id - $user_id - $active";
if($token)
{ 
	if(Functions::__hasPermissionByToken("user", "edit_rol", $token))
	{ 
		if($user_id)
		{
			$DbConnection = DbConnection::getInstance("_root"); 
				
			$UserRol = ($cat_user_x_rol_id == "0") ?  Row::getNewInstance("cat_user_x_rol", $cat_user_x_rol_id) : Row::getInstance("cat_user_x_rol", $cat_user_x_rol_id);
			$UserRol->data["cat_user_rol_id"] = $cat_user_rol_id;
			$UserRol->data["user_id"] = $user_id;
			$UserRol->data["active"] = $active;
					
			if($UserRol->save())
			{
				$cat_user_x_rol_id = ($cat_user_x_rol_id != 0) ? $cat_user_x_rol_id : $DbConnection->getLastId();
				$returnData["cat_user_x_rol_id"] = $cat_user_x_rol_id;
				$returnData["reason"] = "SAVE_OK";
				$returnData["success"] = "1";
			} else {
				$returnData["success"] = "0";
				$returnData["reason"] = "DONT_SAVE";
			} // ___________________________________
			
		} else {
			$returnData["success"] = "0";
			$returnData["reason"] = "NOT_USER_ID";
		}
	} else {
		$returnData["success"] = "0";
		$returnData["reason"] = "NOT_HAS_PERMISSION";
	} 
} else {
	$returnData["success"] = "0";
	$returnData["reason"] = "INVALID_TOKEN";
}

echo json_encode($returnData);