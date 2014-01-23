$(document).ready(function() {
	$("#save").click(function(){
		add_company();
		return false; 
	});
	
	$("#cancel").click(function(){
		history.back();
	});
});			


function add_company()
{
	$(".__required[type=text]").each( function(id_x, element) {	
		var name = $(element).attr("data-id");
		
		if( $(element).val().length == 0 ) 
		{
			$(element).addClass("error_input");
			var message = ("The data field " + name + " is invalid data. Chek please");
			var options = {"Ok":
							function()
							{ 
								$(element).focus();
								__closeMessage();
							} 
						};
	        				
	      		__showMessage({"message": message, "options": options});
	      		return false; 
	    } 
		
		if($(element).val().length != 0 && $(element).hasClass("error_input")) 
		{
	    		$(element).removeClass("error_input");
	    		return false;
	    }
	});
	
	if($(".error_input").size() == 0)
	{ 
		var dataForm = $("#eForm").serialize();
		var returnData = __sendRequest({"url": "../subcore/application/save_row.php", "dataForm": dataForm,"type":"POST"});	
		
		if(returnData.success == 1)
		{ 
			var options = {"View company": 
							function()
							{ 
								 __goToPage("../fiscal/company.php?cat_client_id="+returnData.ids.cat_cpmpany_id);
						    },"New company":
						    function()
							{ 
								 __goToPage("../fiscal/add_company.php");
							},"Company list":
							function()
							{ 
								 __goToPage("../fiscal/list_company.php");
							}
						  };
			__showMessage({"message": "The client data has been saved correctly", "options": options });
		} else if(returnData.success == "0") {
			__showMessage({"message": "System error " + returnData.reason, "options": options });
		} 
	}
}