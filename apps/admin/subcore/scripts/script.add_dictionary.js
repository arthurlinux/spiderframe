$(document).ready(function() {
	
	$("#dictionary_button_ok").click(function(){
		add_dictionary();
		return false; 
	});
	
	$("#language").keydown(function(e) {
	    if(e.keyCode == 13) 
	    {
	    	add_dictionary();
			return false;
	    }
	});
	
	$("#dictionary_button_cancel").click(function(){
		__goToPage("admin_dictionaries.php");
	});
});			

function add_dictionary()
{
	var language = $("#language");
		
	if(language.val() == "")
	{
		var options = {"Ok": function(){ __closeMessage(); language.focus(); } };
		__showMessage({"message": "Enter the dictionary language. Please try again", "options": options });
		return false; 
	}	
	
	if(language.val() != "")
	{
		var dataForm = $("#dictionary_form").serialize();
		var returnData = __sendRequest({"url": "../admin/subcore/application/add_dictionary.php", "dataForm": dataForm,"type":"POST"});	
		
		if(returnData.success == 1)
		{ 
			var options = {"Ok": function(){ 
							__closeMessage();  
							__goToPage("../admin/dictionary.php?language=" + returnData.language) } };
			__showMessage({"message": "The dictionary has been created", "options": options });
			return false; 
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
		__showMessage({"message": "Enter the language. Please try again"});
	} 
}