/* <<<<<<<<<<<<<<<<< ---------------- JS SCRIPTS ------------------ >>>>>>>>>>>>>>>>>>>>>>>>>>>> */
$(document).ready(function() {
	
	$(".tab_nav ul li").click(function(){
		var id = this.id;
		showTab(id);
	});
	
	$(".tab_list_wrap div").hide();
	$(".tab_list_wrap div:first").show();
	$(".tab_nav li:first").addClass("current");
});		

function showTab(id)
{
	if( $("#tab_" + id).is(":hidden") )
	{
		$(".tab_nav li").removeClass("current");
		$(".tab_list_wrap div").hide();
		$("#tab_" + id).show();
		//$("#tab_" + id).fadeIn(500);
		$("#"+id).addClass("current");
	} 
	
	return true;
}