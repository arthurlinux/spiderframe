<?php define("TO_ROOT", "../..");  header("Content-Type: application/json");$returnData = Array();$returnData["row"] = (isset($_GET["row"])) ? $_GET["row"] : false;$returnData["token"] = (isset($_GET["token"])) ? $_GET["token"] : false;$returnData["field"] = (isset($_GET["field"])) ? $_GET["field"] : false;$returnData["value"] = (isset($_GET["value"])) ? $_GET["value"] : false;$returnData["id"] = (isset($_GET["id"]) && $_GET["id"] != false ) ? $_GET["id"] : 0;if($returnData["row"] != false ){	if($returnData["field"] != false )	{		require_once TO_ROOT . "/core/includes/main.inc.php";			$DbConnection = DbConnection::getInstance("_root"); 		$Row = Row::getInstance($returnData["row"], $returnData["id"]);		$Row->data[$returnData["field"]] = $returnData["value"];				if($Row->save())		{			$returnData["id"] = $id;			$returnData["success"] = 1;			$returnData["reason"] = "SAVE_OK";		} else {			$returnData["success"] = 0;			$returnData["reason"] = "NOT_SAVE_ROW";		} // ___________________________________			} else {		$returnData["success"] = 0;		$returnData["reason"] = "NOT_FOUND_FIELD";	}} else {	$returnData["success"] = 0;	$returnData["reason"] = "NOT_FOUND_ROW";}echo json_encode($returnData);