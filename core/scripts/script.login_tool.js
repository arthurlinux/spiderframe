/* <<<<<<<<<<<<<<<<< ---------------- JS SCRIPTS ------------------ >>>>>>>>>>>>>>>>>>>>>>>>>>>> */

/* <<<<<<<<<<<<<<<<< ---------------- GLOBAL VARIABLES ------------ >>>>>>>>>>>>>>>>>>>>>>>>>>>> */
/**
 * This variables are globals in js 
 */
 
/* <<<<<<<<<<<<<<<<< ---------------- FUNCTIONS ------------------- >>>>>>>>>>>>>>>>>>>>>>>>>>>> */

/**
 * This function show the message
 * show all divs in the message and content
 * return void
 */

$(document).ready(function() {
	
	var id = $("#member");
	var password = $("#password"); 
	
	$("#login_button_ok").click(function(){
		login(id, password);
		return false; 
	});
	
	$("#member").keydown(function(e) {
	    if(e.keyCode == 13) 
	    {
	    	$("#password").focus();
			return false;
	    }
	});
	
	$("#member").keyup(function(e) {
	    if(e.keyCode == 13) 
	    {
	    	$("#password").focus();	
	    	return false;
	    }
	});
	
	$("#password").keydown(function(e) {
	    if(e.keyCode == 13) {
	    	login(id, password);
			return false;
	    }
	});
	
	$("#login_button_cancel").click(function(){
		history.back();
	});
});			


function login(id, password)
{
	if(id.val() == "")
	{
		var options = {"Ok": function(){ __closeMessage(); id.focus(); } };
		__showMessage({"message": "Enter your id. Please try again", "options": options});
		return false; 
	}	
	
	if(password.val() == "")
	{
		var options = {"Ok": function(){ __closeMessage(); password.focus(); } };
		__showMessage({"message": "Enter the password. Please try again", "options": options });
		return false; 
	}	
	
	if(id.val() != "")
	{ 
		var dataForm = "id="+id.val()+"&password="+password.val();
		var dataLogin = __sendRequest({"url": "../../core/application/login_tool.php", "dataForm": dataForm,"type":"GET"});	
		
		if(dataLogin.success == "1") {
			$("body").fadeOut(10000000, __goToPage("../landing/applications.php", 580));
		} else if(dataLogin.reason == "INACTIVE") {
			var options = {"Ok": function(){ __closeMessage(); } };
			__showMessage({"message": "Sorry. This user is inactive. Please contact your sponsor", "options": options });
		} else if(dataLogin.reason == "PASSWORD_NOT_MATCH") {
			var options = {"Ok": function(){ __closeMessage(); password.val(""); password.focus(); } };
			__showMessage({"message": "The password is incorrect. Please try again", "options": options });
		} else if(dataLogin.success == "0") {
			var options = {"Ok": function(){ __closeMessage(); password.val(""); password.focus(); } };
			__showMessage({"message": "Sorry something is wrong with your data. Please try again or contact your sponsor", "options": options });
		}
		
	} else {
		__showMessage({"message": "Enter your id. Please try again"});
	}

}