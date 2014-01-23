/* <<<<<<<<<<<<<<<<< ---------------- JS SCRIPTS ------------------ >>>>>>>>>>>>>>>>>>>>>>>>>>>> */

$(document).ready(function(){
	
	check_for_all();
	
	$(".add_permission").on("click", function(){ 
		var id		= $(this).attr("id");
		var checked = $(this).prop("checked");
		var title	= (checked == false) ? "delete" : "add" ;
		var inverse_checked = (checked == true) ? false : true ;
		
		var options = {"Ok": function(){
								set_permission(id,checked)
								__closeMessage(); 
							 },
					   "Cancel": function(){
						       $("#"+ id).prop("checked",inverse_checked); 
						   		__closeMessage();
					   	 	 }
					  }; 
		
		__showMessage({"message": "Are you sure " + title + " this permission", "options": options});
	});  
	
	$(".all_permission").on("click", function(){ 
		var id		= $(this).attr("id");
		var checked = $(this).prop("checked");
		var title	= (checked == false) ? "delete" : "add" ;
		var inverse_checked = (checked == true) ? false : true ;
		
		var options = {"Ok": function(){
								set_permission_by_module(id,checked)
								__closeMessage(); 
							 },
					   "Cancel": function(){
						       $("#"+ id).prop("checked",inverse_checked); 
						   		__closeMessage();
					   	 	 }
					  }; 
		
		__showMessage({"message": "Are you sure " + title + " this module permission", "options": options});
	});
	
	/** *
	$("#add_module_button_ok").click(function(){
		alert($("#add_module_select option:selected").html());
		//set_permission_by_module();
	});
	
	$("#delete_module_button_ok").click(function(){
		//set_permission_by_module();
	});
	/** */
	
});			

function set_permission(id,checked)
{
	var attr_id 	= id.split("-"); 
	var row  		= attr_id[0]; 
	var module 		= attr_id[1]; 
	var permission 	= attr_id[2];
	var value 		= attr_id[3];
	var who_id 		= attr_id[4]; 
	var inverse_value = (value == "1") ? "0" : "1" ;
	var new_id		= row + "-" + module + "-" + permission + "-" + inverse_value + "-" + who_id; 
	var inverse_checked = (checked == true) ? false : true ;
	var dataForm = "&user_login_id="+who_id+"&row="+row+"&permission="+permission+"&module="+module+"&value="+value;
	
	$("#" + id).prop("checked",checked);
	$("#" + id).attr("id",new_id);
	$("#label-" + module + "-" + permission).attr("for",new_id);
	
	if(inverse_value == "0") 
	{
		$("#" + row + "-" + module + "-"+ who_id).prop("checked",false);
	}
	
	check_for_all();
	
	var returnData = __sendRequest({"url": "../admin/subcore/application/edit_user_permission.php", "dataForm": dataForm,"type":"GET"});
	/** */
	if(returnData.reason == "INVALID_TOKEN") {
		var options = {"Ok": function(){ __closeMessage(); } };
		__showMessage({"message": "Invalid token", "options": options });
	} else if(returnData.reason == "NOT_HAS_PERMISSION") {
		var options = {"Ok": function(){ __closeMessage(); history.back(); } };
		__showMessage({"message": "You dont have permission", "options": options });
	} else if(returnData.success == "0") {
		var options = {"Ok": function(){ __closeMessage(); history.back(); } };
		__showMessage({"message": "System response " + returnData.success, "options": options });
	} /** */
}

function set_permission_by_module(id,checked)
{ 
	var attr_id 	= id.split("-"); 
	var row  		= attr_id[0];
	var module 		= attr_id[1]; 
	var who_id 		= attr_id[2]; 
	var value 		= (checked == true) ? "1" : "0" ;
	var dataForm = "&user_login_id="+who_id+"&row="+row+"&module="+module+"&value="+value;
	
	$("." + module).prop("checked",checked);
	$("." + module).each(function(id_x,element){
		var this_id 		= $(element).attr("id");
		var this_attr_id 	= this_id.split("-"); 
		var new_id			= this_attr_id[0] + "-" + this_attr_id[1] + "-" + this_attr_id[2] + "-" + value + "-" + this_attr_id[4]; 
		
		$(element).attr("id",new_id);
		$("#label-" + module + "-" + this_attr_id[2]).attr("for",new_id);
	});
	
	var returnData = __sendRequest({"url": "../admin/subcore/application/edit_user_permission_by_module.php", "dataForm": dataForm,"type":"GET"});
	
	if(returnData.reason == "NOT_HAS_PERMISSION") 
	{
		var options = {"Ok": function(){ __closeMessage(); history.back(); } };
		__showMessage({"message": "You dont have permission", "options": options });
	} else if(returnData.reason == "INVALID_TOKEN") {
		var options = {"Ok": function(){ __closeMessage(); } };
		__showMessage({"message": "Invalid token", "options": options });
	}
}

function check_for_all()
{
	$(".all_permission").each(function(_id, element){ 
		var i 		= 0;
		var id 		= $(element).attr("id")
		var attr_id = id.split("-"); 
		var module 	= attr_id[1]; 
		var module_checked = $("."+ module).size();
		
		$("."+ module).each(function(__id, _element){ 
			i = ($(_element).prop("checked") == true) ? i + 1 : i ;
		});
		
		if(i == module_checked)
		{
			$(element).prop("checked",true);
		}
	});
}