/* <<<<<<<<<<<<<<<<< ---------------- JS SCRIPTS ------------------ >>>>>>>>>>>>>>>>>>>>>>>>>>>> */

$(document).ready(function() {
	
	var permission = $("input[data-id='permission']");
	var permission_text = permission.val().toLowerCase().replace(/\s/g,'_');
	
	var permission_context = $("input[data-id='permission_context']");
	var description = $("input[data-id='description']"); 
	
	$("#save").click(function(){
		add_permission();
		return false; 
	});
	
	permission.keyup(function(e) {
	    if(e.keyCode != 13) 
	    {
	    	permission_context.val(this.value);
	    }
	});
	
	$("input[data-id='permission'], input[data-id='permission_context'], input[data-id='description']").keydown(function(e) {
	    if(e.keyCode == 13) 
	    {
	    	add_permission();
			return false;
	    }
	});
	
	$("#cancel").click(function(){
		history.back();
	});
});			

function add_permission()
{
	var permission = $("input[data-id='permission']");
	var permission_text = permission.val().toLowerCase().replace(/\s/g,'_');
	
	var permission_context = $("input[data-id='permission_context']");
	var permission_context_text = permission_context.val().split('_').join(' ');
		permission_context_text = permission_context_text.charAt(0).toUpperCase() + permission_context_text.slice(1);
			
	var description = $("input[data-id='description']"); 
	
	if(permission.val() == " ")
	{
		permission.val("");
	}	
	
	if(permission.val() != "")
	{
		permission.val(permission_text);
		permission_context.val(permission_context_text);
		
		var dataForm = $("#eForm").serialize();
		var returnData = __sendRequest({"url": "../subcore/application/save_row.php", "dataForm": dataForm,"type":"POST"});	
		
		if(returnData.success == 1)
		{
			var options = {"Add new permission": 
							function(){ 
										__closeMessage(); 
										__goToPage("../admin/add_module_permission.php?cat_module_id=" + returnData.ids.cat_module_id);
									   },
							"View permission":
							function(){ 
								__closeMessage();  
								__goToPage("../admin/module_permission.php?cat_module_permission_id="+returnData.ids.cat_module_permission_id); 
							   }	
						   };
			__showMessage({"message": "Permission data has been saved correctly", "options": options });
		} else if(returnData.reason == "INVALID_TOKEN") {
			var options = {"Ok": function(){ __closeMessage(); } };
			__showMessage({"message": "Invalid token", "options": options });
		} else if(returnData.reason == "NOT_HAS_PERMISSION") {
			var options = {"Ok": function(){ __closeMessage(); history.back(); } };
			__showMessage({"message": "You dont have permission", "options": options });
		} else if(returnData.success == "0") {
			__showMessage({"message": "System error " + returnData.reason, "options": options });
		} 
		
	} else {
		var options = {"Ok": function(){ __closeMessage(); permission.focus(); } };
		__showMessage({"message": "Enter the permission. Please try again", "options": options });
		return false; 
	} 
}