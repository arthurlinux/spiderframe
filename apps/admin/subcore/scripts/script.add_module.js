/* <<<<<<<<<<<<<<<<< ---------------- JS SCRIPTS ------------------ >>>>>>>>>>>>>>>>>>>>>>>>>>>> */

$(document).ready(function() {
	var module = $("input[data-id='module']");
	var module_context = $("input[data-id='module_context']");
	var description = $("input[data-id='description']"); 
	
	$("#save").click(function(){
		add_module();
		return false; 
	});
	
	module.keyup(function(e) 
	{
	    if(e.keyCode != 13) 
	    {
	    	module_context.val(this.value);
	    }
	});
	
	$("input[data-id='module'], input[data-id='module_context'], input[data-id='description']").keydown(function(e) {
	    if(e.keyCode == 13) {
	    	add_module();
			return false;
	    }
	});
	
	$("#cancel").click(function(){
		history.back();
	});
});			

function add_module()
{
	var module = $("input[data-id='module']");
	var module_context = $("input[data-id='module_context']");
	var description = $("input[data-id='description']"); 

	if(module.val() == " ")
	{
		var options = {"Ok": function(){ __closeMessage(); $("#" + module.attr("id")).focus(); } };
		__showMessage({"message": "Enter the module. Please try again", "options": options });
		return false; 
	}	
	
	if(module.val() != "")
	{
		var dataForm = $("#eForm").serialize();
		var returnData = __sendRequest({"url": "../subcore/application/save_row.php", "dataForm": dataForm,"type":"POST"});	
		
		if(returnData.success == 1)
		{ 
			var options = {"Add new module": 
							function()
							{ 
								__closeMessage(); 
								__goToPage("../admin/add_module.php");
							},
							"View module":
							function()
							{ 
								__closeMessage(); 
								__goToPage("../admin/module.php?cat_module_id="+returnData.ids.cat_module_id);
							   }	
						   };
			__showMessage({"message": "Module data has been saved correctly", "options": options });
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
		__showMessage({"message": "Enter the module. Please try again"});
	} 
	
}