<?php define("TO_ROOT", "../../../..");  header("Content-Type: application/json");require_once TO_ROOT . "/core/includes/main.inc.php";$returnData = Array();$row = ( isset( $_POST["row"] ) ) ? $_POST["row"] : false;  	$row = ( !$row && isset( $_GET["row"] ) ) ? $_GET["row"] : $row;  $value = ( isset( $_POST["value"] ) ) ? $_POST["value"] : false;  	$value = ( !$value && isset( $_GET["value"] ) ) ? $_GET["value"] : $value;$value = ( $value == false ) ? "0" : "1" ;  $module = ( isset( $_POST["module"] ) ) ? $_POST["module"] : false;  	$module = ( !$module && isset( $_GET["module"] ) ) ? $_GET["module"] : $module; $user_login_id = ( isset( $_POST["user_login_id"] ) ) ? $_POST["user_login_id"] : false;  	$user_login_id = ( !$user_login_id && isset( $_GET["user_login_id"] ) ) ? $_GET["user_login_id"] : $user_login_id;  	$token = ( isset( $_POST["token"] ) ) ? $_POST["token"] : false;  	$token = ( !$token && isset( $_GET["token"] ) ) ? $_GET["token"] : $token;  	$token = ( !$token && isset( $_SESSION["token"] ) ) ? $_SESSION["token"] : $token;  	if($token){	if(Functions::__hasPermissionByToken("user", "add_permission", $token))	{		if($user_login_id)		{			$DbConnection = DbConnection::getInstance("_root"); 						$sql= "SELECT cat_module_id FROM cat_module WHERE module='{$module}'";			$module_id = $DbConnection->getValue($sql);							if($module_id)			{					$sql= "SELECT cat_module_permission_id FROM cat_module_permission WHERE cat_module_id = '{$module_id}'";				$collection_cat_module_permission_id = $DbConnection->getColumn($sql);								if($collection_cat_module_permission_id)				{					foreach ($collection_cat_module_permission_id AS $cat_module_permission_id)					{						$sql= "SELECT user_permission_id FROM user_permission WHERE user_login_id = '{$user_login_id}' AND cat_module_permission_id='{$cat_module_permission_id}'";						$user_permission_id = $DbConnection->getValue($sql);												$UserPermission = (!$user_permission_id) ?  Row::getNewInstance("user_permission", 0) : Row::getInstance("user_permission", $user_permission_id);						$UserPermission->data["active"] = $value;						$UserPermission->data["user_login_id"] = $user_login_id;						$UserPermission->data["cat_module_permission_id"] = $cat_module_permission_id;												if($UserPermission->save())						{							$user_permission_id = ($user_permission_id != 0) ? $user_permission_id : $DbConnection->getLastId();							$returnData["user_permission_id"] = $user_permission_id;							$returnData["reason"] = "SAVE_USER_PERMISSION_OK";							$returnData["success"] = 1;						} else {							$returnData["success"] = "0";							$returnData["reason"] = "DONT_SAVE_USER_PERMISSION";						} // ___________________________________					}				} else {					$returnData["success"] = "0";					$returnData["reason"] = "NOT_PERMISSION_COLLECTION_FOUND";				}			} else {				$returnData["success"] = "0";				$returnData["reason"] = "NOT_MODULE_FOUND";			}		} else {			$returnData["success"] = "0";			$returnData["reason"] = "NOT_USER_LOGIN_ID";		}	} else {		$returnData["success"] = "0";		$returnData["reason"] = "NOT_HAS_PERMISSION";	}} else {	$returnData["success"] = "0";	$returnData["reason"] = "INVALID_TOKEN";}echo json_encode($returnData);