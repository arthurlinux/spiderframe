<?php define("TO_ROOT", "../../..");  header("Content-Type: application/json");$returnData = Array();$returnData["row"] = (isset($_GET["row"])) ? $_GET["row"] : false;$returnData["dataForm"] = (isset($_POST["dataForm"])) ? $_POST["dataForm"] : false;$returnData["id"] = (isset($_GET["id"]) && $_GET["id"] != false ) ? $_GET["id"] : 0;if($returnData["row"] != false ){	if($returnData["dataForm"] != false )	{		require_once TO_ROOT . "/core/includes/main.inc.php";			$DbConnection = DbConnection::getInstance("_root"); 		$Row = Row::getInstance($returnData["row"], $returnData["id"]);		$Row->data[$returnData["field"]] = $returnData["value"];					$dataForm = explode("|",$returnData["dataForm"]);		foreach ($dataForm AS $field_value)		{			$values = explode("=",$field_value);			$field = $values[0]; $value = $values[1];			$returnData[$field] = $value ;			$Row->data[$field] = $value;		}				if($Row->save())		{			$returnData["success"] = 1;			$returnData["id"] = $DbConnection->getLastId();			$returnData["reason"] = "SAVE_OK";		} else {			$returnData["success"] = 0;			$returnData["reason"] = "NOT_SAVE_ROW";		} // ___________________________________			} else {		$returnData["success"] = 0;		$returnData["reason"] = "NOT_FOUND_VALUES";	}} else {	$returnData["success"] = 0;	$returnData["reason"] = "NOT_FOUND_ROW";}echo json_encode($returnData);