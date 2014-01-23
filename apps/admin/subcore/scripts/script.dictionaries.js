$(document).ready(function() {
	
	$(".action_delete").click(function(){
		confirm_delete_dictionary(this.id);
		return false; 
	});
	
	$(".action_delete_word").click(function(){
		confirm_delete_dictionary_word(this.id);
		return false; 
	});
	
});			

function confirm_delete_dictionary(language)
{ 
	if(language == "")
	{
		var options = {"Ok": function(){ __closeMessage(); } };
		__showMessage({"message": "Dictionary language incorrect. Please try again", "options": options });
		return false; 
	}	
	
	if(language != "")
	{ 
		var options = {"Ok": 
			function(){ 
				__closeMessage();  
				delete_dictionary(language); 
			}, "Cancel":
				function(){
				__closeMessage();  
			}
		};
		__showMessage({"message": "Are you sure to delete this dictionary", "options": options });
		return false; 
	} else {
		__showMessage({"message": "Error unknow. Please try again"});
	} 
}

function confirm_delete_dictionary_word(id)
{ 
	if(id != "")
	{ 
		var options = {"Ok": 
			function(){ 
				__closeMessage();  
				delete_dictionary_word(id); 
			}, "Cancel":
				function(){
				__closeMessage();  
			}
		};
		__showMessage({"message": "Are you sure to delete this line", "options": options });
		return false; 
	} else {
		__showMessage({"message": "Error unknow. Please try again"});
	} 
}

function delete_dictionary(language)
{
	var dataForm = "language=" + language;
	var returnData = __sendRequest({"url": "../../core/application/delete_dictionary.php", "dataForm": dataForm,"type":"POST"});	
	
	if(returnData.success == 1)
	{ 
		var options = {"Ok": function(){ 
								__closeMessage();  
								__goToPage("../admin/dictionaries_list.php", 580) } };
								__showMessage({"message": "The dictionary has been delete", "options": options });
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
}

function delete_dictionary_word(attr_id)
{
	attr_id 		= attr_id.split("-");
 	var language  	= attr_id[0];
 	var id  		= attr_id[1];

	var dataForm = "language=" + language + "&id=" + id;
	var returnData = __sendRequest({"url": "../../core/application/delete_dictionary_word.php", "dataForm": dataForm,"type":"POST"});	
	
	if(returnData.success == 1)
	{ 
		var options = {"Ok": function(){ 
							__closeMessage();  
							location.reload()
							} 
					  };
		__showMessage({"message": "The dictionary has been delete", "options": options });
		return false; 
	} else if(returnData.reason == "INVALID_TOKEN") {
		var options = {"Ok": function(){ __closeMessage(); } };
		__showMessage({"message": "Invalid token", "options": options });
	} else if(returnData.reason == "NOT_HAS_PERMISSION") {
		var options = {"Ok": function(){ __closeMessage(); } };
		__showMessage({"message": "You dont have permission", "options": options });
	} else if(returnData.success == "0") {
		__showMessage({"message": "System error " + returnData.reason, "options": options });
	}
}