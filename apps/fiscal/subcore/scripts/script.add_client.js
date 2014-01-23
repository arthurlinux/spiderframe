/* <<<<<<<<<<<<<<<<< ---------------- JS SCRIPTS ------------------ >>>>>>>>>>>>>>>>>>>>>>>>>>>> */

$(document).ready(function() {
	var client = $("input[data-id='client']");
	var phone = $("input[data-id='phone']");
	var mail = $("input[data-id='mail']");

	var state_id = $("[data-id='state_id']"); 
	var city_id = $("[data-id='city_id']"); 
	var street = $("input[data-id='street']");
	var number = $("input[data-id='number']");
	var colony = $("input[data-id='colony']");
	var postal_zip = $("input[data-id='postal_zip']");
	var place = $("input[data-id='place']");
	var interior = $("input[data-id='interior']");
	var address_detail = $("input[data-id='address_detail']");
	var address_cross = $("input[data-id='address_cross']");

	
	$("#save").click(function(){
		add_client();
		return false; 
	});
	
	$("#cancel").click(function(){
		history.back();
	});

	state_id.keydown(function(e) 
	{
		if( e.keyCode == 13 )
		{
			city_id.focus();
		}
	});
	
	city_id.keydown(function(e) 
	{
		if( e.keyCode == 13 )
		{
			street.focus();
		}
	});
	
	street.keydown(function(e) 
	{
		if( e.keyCode == 13 )
		{
			if(this.value != "")
			{
				number.focus();
			} else {
				this.focus();
			}
		}
	});
	
	number.keydown(function(e) 
	{
		if( e.keyCode == 13 )
		{
			if(this.value != "")
			{
				colony.focus();
			} else {
				this.focus();
			}
		}
	});
	
	colony.keydown(function(e) 
	{
		if( e.keyCode == 13 )
		{
			if(this.value != "")
			{
				postal_zip.focus();
			} else {
				this.focus();
			}
		}
	});

	postal_zip.keydown(function(e) 
	{
		if( e.keyCode == 13 )
		{
			if(this.value != "")
			{
				place.focus();
			} else {
				this.focus();
			}
		}
	});

	place.keydown(function(e) 
	{
		if( e.keyCode == 13 )
		{
			if(this.value != "")
			{
				interior.focus();
			} else {
				this.focus();
			}
		}
	});
	
	interior.keydown(function(e) 
	{
		if( e.keyCode == 13 )
		{
			if(this.value != "")
			{
				address_detail.focus();
			} else {
				this.focus();
			}
		}
	});
	
	address_detail.keydown(function(e) 
	{
		if( e.keyCode == 13 )
		{
			if(this.value != "")
			{
				address_cross.focus();
			} else {
				this.focus();
			}
		}
	});

	address_cross.keydown(function(e) 
	{
		if( e.keyCode == 13 )
		{
			if(this.value != "")
			{
				add_user();
			} else {
				this.focus();
			}
		}
	});	
});			

function add_client()
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
				var options = {"View Client": 
								function()
								{ 
									 __goToPage("../fiscal/client.php?cat_client_id="+returnData.ids.cat_client_id);
							    },"New Client":
							    function()
								{ 
									 __goToPage("../fiscal/add_client.php");
								},"Client list":
								function()
								{ 
									 __goToPage("../fiscal/list_client.php");
								}
							  };
				__showMessage({"message": "The client data has been saved correctly", "options": options });
			} else if(returnData.success == "0") {
				__showMessage({"message": "System error " + returnData.reason, "options": options });
			} 
		}
	
}