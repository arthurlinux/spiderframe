$(document).ready(function() {
	
	var system_value = $("#system_value");
	var translate_value = $("#translate_value"); 
	
	$("#dictionary_button_ok").click(function(){
		add_dictionary_word(system_value, translate_value);
		return false; 
	});
	
	$("#system_value, #translate_value").keydown(function(e) {
	    if(e.keyCode == 13) 
	    {
	    	add_dictionary_word(system_value, translate_value);
			return false;
	    }
	});
	
	$("#dictionaries").change(function() {
		$("#language").val($("#dictionaries option:selected").html());
	});
	
	$("#sections").change(function() {
		$("#section").val($("#sections option:selected").html());
	});
	
	$("#section_x").keyup(function(e) {
		$("#section").val($(this).val());
	});
	
	$("#dictionary_button_cancel").click(function(){
		__goToPage("admin_dictionaries.php");
	});
});			

function add_dictionary_word(system_value, translate_value)
{
	if(system_value.val() == "")
	{
		var options = {"Ok": function(){ __closeMessage(); system_value.focus(); } };
		__showMessage({"message": "Enter the system value. Please try again", "options": options });
		return false; 
	}	
	
	if(translate_value.val() == "")
	{
		var options = {"Ok": function(){ __closeMessage(); translate_value.focus(); } };
		__showMessage({"message": "Enter the translate value. Please try again", "options": options });
		return false; 
	}
	
	if($("#section").val() == "")
	{
		$("#section").val($("#sections option:selected").html());
	}
	
	if(system_value.val() != "" && translate_value.val() != "")
	{
		var dataForm = $("#dictionary_form").serialize();
		var returnData = __sendRequest({"url": "../admin/subcore/application/add_dictionary_word.php", "dataForm": dataForm,"type":"POST"});	
		
		if(returnData.success == 1)
		{ 
			var options = {"Ok": 
							function(){ 
								__goToPage("../admin/admin_dictionaries.php");
								__closeMessage();  
						   	},
						   	"View dictionary":
						   	  function(){
						   		__closeMessage();  
						   		__goToPage("../admin/dictionary.php?language=" + returnData.language);
						   	  }
						   };
			
			__showMessage({"message": "The dictionary data has been saved correctly", "options": options });
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
		__showMessage({"message": "Enter the values. Please try again"});
	} 
}