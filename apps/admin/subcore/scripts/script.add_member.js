$(document).ready(function() { 
	var mail = $("input[data-id='mail']");
	var password = $("input[data-id='password']"); 
	var password_confirm = $("input[data-id='password_confirm']");
	var user_login_id = $("input[data-id='user_login_id']").val();
	
	var names = $("input[data-id='names']");
	var lastname = $("input[data-id='lastname']");
	var mother_name = $("input[data-id='mother_name']");
	var birthday = $("input[data-id='birthday']");
	var rfc = $("input[data-id='rfc']");
	
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
	
	var user_sponsor_id = $("input[data-id='user_sponsor_id']");
	
	var availableTags = new Array();
	
	$("#save").click(function(){
		//$("#eForm").submit();
		add_user();
		return false; 
	});
	
	$("#cancel").click(function(){
		history.back(); 
		//__goToPage("index.php");
	});
	
	mail.keydown(function(e) 
	{
	    if( e.keyCode == 13 )
	    {
	    	password.focus();
	    }
	});
	
	password.keydown(function(e) 
	{
	    if( e.keyCode == 13 )
	    {
	    	if(this.value != "")
	    	{
	    		password_confirm.focus();
	    	} else {
	    		this.focus();
	    	}
	    }
	});
	
	password_confirm.keydown(function(e) 
	{
	   if( e.keyCode == 13 )
	   {
		   if(this.value == password.val())
		   {
			   names.focus();
		   } else {
			   this.focus();
		   }
	   }
	});
	
	/** *
	names.keydown(function(e) 
	{
		if( e.keyCode == 13 )
		{
			lastname.focus();
		}
	});
	
	lastname.keydown(function(e) 
	{
		if( e.keyCode == 13 )
		{
			mother_name.focus();
		}
	});
	
	mother_name.keydown(function(e) 
	{
		if( e.keyCode == 13 )
		{
			rfc.focus();
		}
	});	
	
	rfc.keydown(function(e) 
	{
		if( e.keyCode == 13 )
		{
			birthday.focus();
		}
	});	
	/** */
	
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
	
	names.blur( function () {
		rfc.val(rfc_generator());
 	});
 	
 	lastname.blur( function () {
 		rfc.val(rfc_generator());
 	});
 	
 	mother_name.blur( function () {
 		rfc.val(rfc_generator());
 	});
 	
 	birthday.change( function () {
 		rfc.val(rfc_generator());
 	});
 	
 	rfc.focus( function () {
 		rfc.val(rfc_generator());
 	});

 	/** */
 	user_sponsor_id.keyup( function () {
 		var value = this.value;
 		
 		if(parseInt(value) >= 1 )
 		{
 			
 		} else {
 			availableTags = $.setAutoComplete();
 		}
 	});
 	/** */
 	
 	user_sponsor_id.autocomplete({"source":availableTags});
 	
 	function rfc_generator()
	{
		var _rfc = "";
	 	var _name = (names.val()) ? names.val() : "--";
	 	var _lastname = (lastname.val()) ? lastname.val() : "--";
	 	var _mothername = (mother_name.val()) ? mother_name.val() : "--";
	 	var _date = birthday.val(); 
	 	 	_date = _date.split("/")
	 	var day = _date[0];
	 	var year = _date[2];
	 	var month = _date[1];
	 	
	 	_rfc = _lastname[0] + _lastname[1] + _mothername[0] + _name[0] + " " + year[2] + year[3] + month + day;
	 	//_rfc = _rfc.toUpperCase();
	 	
	 	return _rfc;
	}	

	function add_user()
	{
		if(!__isValidMail(mail.val()))
		{
			var options = {"Ok": function(){ __closeMessage(); mail.focus(); } };
			__showMessage({"message": "The e-mail is incorrect. Please try again", "options": options });
			return false; 
		}
		
		if(!user_login_id)
		{
			if(password.val() == "")
			{
				var options = {"Ok": function(){ __closeMessage(); password.focus(); } };
				__showMessage({"message": "Enter the password. Please try again", "options": options });
				return false; 
			}	
		}
		if(password.val() != password_confirm.val())
		{
			var options = {"Ok": function(){ __closeMessage(); password_confirm.val(""); password.focus(); } };
			__showMessage({"message": "The passwords its not same. Please try again", "options": options });
			return false; 
		}	
		
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
			var returnData = __sendRequest({"url": "../../core/application/save_row.php", "dataForm": dataForm,"type":"POST"});	
			
			if(returnData.success == 1)
			{ 
				var options = {"View profile": 
								function()
								{ 
									 __goToPage("../admin/profile.php?user_login_id="+returnData.ids.user_login_id);
							    },"New member":
							    function()
								{ 
									 __goToPage("../admin/add_member.php");
								},"Member list":
								function()
								{ 
									 __goToPage("../admin/member_list.php");
								}
							  };
				__showMessage({"message": "The user data has been saved correctly", "options": options });
			} else if(returnData.reason == "NOT_PASSWORD") {
				var options = {"Ok": function(){ __closeMessage(); password.val(""); password_confirm.val(""); password.focus(); } };
				__showMessage({"message": "The password is invalid. Please try again", "options": options });
			} else if(returnData.reason == "PASSWORD_NOT_MATCH") {
				var options = {"Ok": function(){ __closeMessage(); password.val(""); password_confirm.val(""); password.focus(); } };
				__showMessage({"message": "The passwords not match. Please try again", "options": options });
			} else if(returnData.reason == "EMAIL_NOT_UNIQUE") {
				var options = {"Ok": function(){ __closeMessage(); mail.val(""); mail.focus(); } };
				__showMessage({"message": "This e-mail exist in the system. Please try again", "options": options });
			} else if(returnData.success == "0") {
				__showMessage({"message": "System error " + returnData.reason, "options": options });
			} 
		}
	}
});	
