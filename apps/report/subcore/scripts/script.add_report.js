/* <<<<<<<<<<<<<<<<< ---------------- JS SCRIPTS ------------------ >>>>>>>>>>>>>>>>>>>>>>>>>>>> */

$(document).ready(function() {
	var title = $("input[data-id='title']");
	var report = $("input[data-id='report']");
	
	
	$("#save").click(function(){
		add_report();
		return false; 
	});
	
	$("#cancel").click(function(){
		history.back();
	});
});			

function add_report()
{
	var title = $("input[data-id='title']");
	var report = $("input[data-id='report']");

	if(title.val() == " ")
	{
		var options = {"Ok": function(){ __closeMessage(); $("#" + title.attr("id")).focus(); } };
		__showMessage({"message": "Enter the title. Please try again", "options": options });
		return false; 
	}	
	
	if(title.val() != "")
	{
		var dataForm = $("#eForm").serialize();
		var returnData = __sendRequest({"url": "../subcore/application/save_row.php", "dataForm": dataForm,"type":"POST"});	
		
		if(returnData.success == 1)
		{ 
			var options = {"Add new report": 
							function()
							{ 
								__closeMessage(); 
								__goToPage("../report/add_report.php");
							},
							"View report":
							function()
							{ 
								__closeMessage(); 
								__goToPage("../report/report.php?report_id="+returnData.ids.report_id);
							   }	
						   };
			__showMessage({"message": "Report data has been saved correctly", "options": options });
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
		__showMessage({"message": "Enter the Report. Please try again"});
	} 
	
}