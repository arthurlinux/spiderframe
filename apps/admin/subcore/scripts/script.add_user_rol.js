$(document).ready(function() { 
	var rol = $("input[data-id='rol']");
	var description = $("input[data-id='description']"); 
	$("#eForm").submit(function(){ return false; });
	
	$("#save").click(function(){
		//$("#eForm").submit();
		add_user_rol();
		return false; 
	});
	
	$("#cancel").click(function(){
		history.back(); 
		//__goToPage("index.php");
	});
	
	rol.keydown(function(e) 
	{  
	    if( e.keyCode == 13 )
	    {
	    	description.focus();
	    } 
	});
	
	
	description.keydown(function(e) 
	{
		if( e.keyCode == 13 )
		{
			if(this.value != "")
			{
				add_user_rol();
			} else {
				this.focus();
			}
		} return false;
	});
 	

	function add_user_rol()
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
				var options = {"View user rol": 
								function()
								{ 
									 __goToPage("../admin/user_rol.php?cat_user_rol_id="+returnData.ids.cat_user_rol_id);
							    },"New user rol":
							    function()
								{ 
									 __goToPage("../admin/add_user_rol.php");
								},"User roles list":
								function()
								{ 
									 __goToPage("../admin/user_roles_list.php");
								}
							  };
				__showMessage({"message": "The user data has been saved correctly", "options": options });
			} else if(returnData.reason == "NOT_HAS_PERMISSION") {
				var options = {"Ok": function(){ __closeMessage(); history.back(); } };
				__showMessage({"message": "You dont have permission", "options": options });
			} else if(returnData.reason == "INVALID_TOKEN") {
				var options = {"Ok": function(){ __closeMessage(); } };
				__showMessage({"message": "Invalid token", "options": options });
			} else if (returnData.success == "0"){
				__showMessage({"message": "System error " + returnData.reason, "options": options });
			} 
		} else {
			return false;
		}
	}
});	
