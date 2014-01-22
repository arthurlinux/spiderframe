<?php define("TO_ROOT", "../../..");  
header("Content-Type: application/json");

$returnData = Array();
$returnData["match_list"] = (isset($_GET["match_list"])) ? $_GET["match_list"] : false;
$returnData["match_list"] = ($returnData["match_list"] == false) ? $_POST["match_list"] : $returnData["match_list"] ;

$match_list = unserialize(stripslashes($returnData["match_list"]));

if($match_list)
{   
	require_once TO_ROOT . "/core/includes/main.inc.php";
	foreach($match_list AS $__row => $__level)
	{
		$data = array();
		$id = $__level["id"];
		$name = $__level["Name"];
		$instance_db_connection = $__level["DbConnection"];
		$table_name = (is_numeric($__row)) ? $__level["Table"] : $__row;
			
		/* ---------------- <<<< Construct array data >>>> ------------------------*/
		foreach ($__level["Fields"] AS $field)
		{ 
			$name_field = $field . "_" . $id . "_" . $name;
			$data[$field] = (isset($_POST[$name_field])) ? $_POST[$name_field] : $_GET[$name_field];
		}
		/* ---------------- <<<< End Construct array data >>>> --------------------*/
		
		/* ---------------- <<<< Logic value to fields >>>> -----------------------*/
		if($__level["LogicValue"])
		{
			foreach ($__level["LogicValue"] AS $field => $value)
			{
				if(isset($_POST[$field . "_" . $id . "_" . $name]))
		        {  
		        	$data[$field] = $value;
		        } else if ( isset($_GET[$field . "_" . $id . "_" . $name]) ){  
		        	$data[$field] = $value;
		        } 
			}
		} /* -------------- <<<< End Asign value to field >>>> -------------------*/
		
		/* ---------------- <<<< Protect value >>>> ------------------------------*/
		if($__level["Protect"])
		{
			foreach ($__level["Protect"] AS $field => $value)
			{ 
			    if(isset($_POST[$field . "_" . $id . "_" . $name]))
		        {  
		        	$data[$field] = $value($_POST[$field . "_" . $id . "_" . $name]);
		        } else if ( isset($_GET[$field . "_" . $id . "_" . $name]) ){  
		        	$data[$field] = $value($_GET[$field . "_" . $id . "_" . $name]);
		        } 
			}
		} /* ------------ <<<< End Protect value >>>> ---------------------------*/ 
		
		/* ---------------- <<<< Ignore Clean >>>> ------------------------------*/
		if($__level["IgnoreClean"])
		{ 
			foreach ($__level["IgnoreClean"] AS $field)
			{ 
				if($data[$field] == "")
				{
					unset($data[$field]);
				}
				if(isset($_POST[$field . "_" . $id . "_" . $name]) && ($_POST[$field . "_" . $id . "_" . $name] == "") )
		        {  
		        	unset($data[$field]);
		        } else if ( isset($_GET[$field . "_" . $id . "_" . $name]) && ($_GET[$field . "_" . $id . "_" . $name] == "") ){  
		        	unset($data[$field]);
		        } 
			}
		} /* -------------- <<<< End IgnoreClean >>>> --------------------------*/
		
		/* ---------------- <<<< Change date >>>> ------------------------------*/
		if($__level["TransformDate"])
		{ 
			foreach ($__level["TransformDate"] AS $field)
			{
				if(strpos($data[$field], "/"))
				{ 
					$delimiter = "/"; 
				} else if(strpos($data[$field], "-")) { 
					$delimiter = "-"; 
				} else if(strpos($data[$field], " ")) { 
					$delimiter = " "; 
				}
				 
				$date = explode($delimiter, $data[$field]); 
				$new_date = mktime(date("H"), date("i"), date("s"), $date[1], $date[0], $date[2]); 
				$data[$field] = $new_date;
			}
		} /* -------------- <<<< End Change date >>>> --------------------------*/
		
		/* ---------------- <<<< Asign value to fields >>>> --------------------*/
		if($__level["AsignValue"])
		{
			foreach ($__level["AsignValue"] AS $field => $value)
			{
				$case_id = $value;
				$value = ( strpos($value, "_id") && ($value != "last_id") ) ? "case_id" : $value ;
			
				if(count($returnData["ids"]) >= 1)
			    {
				   	foreach($returnData["ids"] AS $_key => $_value)
				   	{ 
				   		$first = (!$first) ? $_value : $first;
				    }

				    $last = (!$last) ? $_value : $last;
		    	}
		    			
				switch ($value)
		    	{
			    	case "first":
			        	$data[$field] = $first;
			        break;
			        
			        case "last_id":
			          	$data[$field] = $last;
			        break;
			        
			        case "case_id":
			        	$data[$field] = $returnData["ids"][$case_id];
			        break;
			        
			        case ((int)$value > 0):
			        	$data[$field] = $value;
			        break;
			        
			        case (string)$value !="":
			        	$data[$field] = $__level["AsignValue"][$field];
			        break;
		       	}
			}
		} /* -------------- <<<< End Asign value to field >>>> -----------------*/
		
		/* -------------- <<<< Join Fields >>>> ---------------------------------*/
		if($__level["JoinFields"])
		{
			$value = "";
			
			foreach ($__level["JoinFields"]["values"] AS $field)
			{
				$glue = is_array($__level["JoinFields"]["glue"] && !empty($__level["JoinFields"]["glue"])) ? $__level["JoinFields"]["glue"][$field] : " ";
			    $value .= (isset($_POST[$name_field])) ? $_POST[$field . "_" . $id . "_" . $name] : $_GET[$field . "_" . $id . "_" . $name];
			}
			
			$data[$__level["JoinFields"]["field"]] = $value;
		} /* -------------- <<<< End Changed field >>>> -------------------------*/ 
		
		/* ---------------- <<<< Changed field >>>> ----------------------------*/
		if($__level["ChangedField"])
		{ 
			foreach ($__level["ChangedField"] AS $field => $value)
			{   
				if(isset($_POST[$field . "_" . $id . "_" . $name]))
		        {  
		        	$data[$field] = $_POST[$value . "_" . $id . "_" . $name];
		        } else if ( isset($_GET[$field . "_" . $id . "_" . $name]) ){  
		        	$data[$field] = $_GET[$value . "_" . $id . "_" . $name];
		        } 
			}
		} /* -------------- <<<< End Changed field >>>> ------------------------*/
		
		/* ---------------- <<<< Changed field condition >>>> ------------------*/
		if($__level["ChangedFieldCondition"])
		{ 
			foreach ($__level["ChangedFieldCondition"] AS $field => $value)
			{   
				if(isset($_POST[$field . "_" . $id . "_" . $name]) && ($_POST[$field . "_" . $id . "_" . $name] == "") )
		        {  
		        	$data[$field] = $_POST[$value . "_" . $id . "_" . $name];
		        } else if ( isset($_GET[$field . "_" . $id . "_" . $name]) && ($_GET[$field . "_" . $id . "_" . $name] == "") ){  
		        	$data[$field] = $_GET[$value . "_" . $id . "_" . $name];
		        } 
			}
		} /* -------------- <<<< End Changed field >>>> ------------------------*/
		
		/* ---------------- <<<< Changed field condition >>>> ------------------*/
		if($__level["Function"])
		{ 
			foreach ($__level["Function"] AS $field => $_values)
			{   
				foreach($_values AS $key => $values)
				{
					foreach($values AS $function => $values)
					{
						if($values)
						{
							$function_values = str_replace(" ", "", str_replace(",", '", "', $values));
							$function_values = '"' . $function_values . '"';
						}
						
						if($key == "Functions")
						{
							$data[$field] = eval("return Functions::" . $function . "(" . $function_values . ");");
						} else {
							$data[$field] = eval("return {$function}({$function_values});");
						}
					}
				}
			}
			
		} /* -------------- <<<< End Changed field >>>> ------------------------*/
		
		
		/* ---------------- <<<< Assert insert Data Base >>>> ------------------*/
		$success = Functions::__saveRow($table_name, $id, $data, $instance_db_connection);
		
		if($success["success"])
		{
			$returnData["success"] = "1";
			$returnData["reason"] = "SAVE_ROW_OK";
			$returnData["ids"][$table_name . "_id"] = $success["id"];
			
			$returnData["Data"][$table_name] = $data;
			$returnData["Data"][$table_name]["id"] = $returnData["ids"][$table_name];
		} else {  
			$returnData["success"] = "0";
			$returnData["last_row"] = $table_name;
			$returnData["reason"] = ($success["success"]) ? $success["success"] : "NOT_SAVE_ROW" ;
		}  /* ---------------- <<<< End Assert insert Data Base >>>> --------------*/
		
		/* ---------------- <<<< Load ID's >>>> --------------------------------*/
		if($data)
		{ 
			foreach ($data AS $key => $value)
			{   
				if(strpos($key, "_id"))
		        {  
		        	$returnData["ids"][$key] = $value;
		        } 
			}
		} /* ---------------- <<<< End Load ID's >>>> --------------------------*/
		
	} 
	
	unset($returnData["match_list"] );
	
} else {
	$returnData["success"] = "0";
	$returnData["reason"] = "NOT_MATCH_LIST";
}

/** *
echo "<pre>";
print_r($returnData);
echo "</pre>";
/** */

/** *
echo "<pre>";
print_r($match_list);
echo "</pre>";
/** */

echo json_encode($returnData);