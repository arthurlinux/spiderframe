/* <<<<<<<<<<<<<<<<< ---------------- JS SCRIPTS ------------------ >>>>>>>>>>>>>>>>>>>>>>>>>>>> */

$(document).ready(function(){
	$(".set_rol").on("click", function(){ 
		var id		= $(this).attr("id");
		var checked = $(this).prop("checked");
		var inverse_checked = (checked == true) ? false : true ;
		
		var options = {"Ok": function(){
								set_rol(id, checked)
								__closeMessage(); 
							 },
					   "Cancel": function(){
						       $("#"+ id).prop("checked",inverse_checked); 
						   		__closeMessage();
					   	 	 }
					  }; 
		__showMessage({"message": "Are you sure to do this action", "options": options});
	});
});			

function set_rol(id, checked)
{
	var attr_id 			= id.split("-"); 
	var row  				= attr_id[0]; 
	var cat_user_x_rol_id 	= attr_id[1];
	var cat_user_rol_id		= attr_id[2]
	var user_id 			= attr_id[3]; 
	var active 				= attr_id[4];
	var inverse_active 		= (active == "1") ? "0" : "1" ;
	var inverse_checked 	= (checked == true) ? false : true ;
	var new_id				= row + "-" + cat_user_x_rol_id + "-" + cat_user_rol_id + "-" + user_id + "-" + inverse_active; 
	
	var dataForm = "cat_user_x_rol_id=" + cat_user_x_rol_id + "&cat_user_rol_id=" + cat_user_rol_id + "&user_id=" + user_id + "&active=" + inverse_active;
	
	$("#" + id).prop("checked",checked);
	
	if(inverse_active == "0") 
	{
		$("#" + id).prop("checked",checked);
	}
	
	$("#" + id).attr("id", new_id);
	
	var returnData = __sendRequest({"url": "../admin/subcore/application/set_rol.php", "dataForm": dataForm,"type":"GET"});
	
	
	if(returnData.reason == "INVALID_TOKEN") 
	{
		var options = {"Ok": function(){ __closeMessage(); } };
		__showMessage({"message": "Invalid token", "options": options });
	} else if(returnData.reason == "NOT_HAS_PERMISSION") {
		var options = {"Ok": function(){ __closeMessage(); history.back(); } };
		__showMessage({"message": "You dont have permission", "options": options });
	} else if(returnData.success == "0") {
		var options = {"Ok": function(){ __closeMessage(); } };
		__showMessage({"message": "System response " + returnData.reason, "options": options });
	}/**/
}
