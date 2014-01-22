/* <<<<<<<<<<<<<<<<< ---------------- JS SCRIPTS ------------------ >>>>>>>>>>>>>>>>>>>>>>>>>>>> */

$(document).ready(function() {
	
	show_clock();
	active_links();
	active_shortcuts();
	
});			

function active_shortcuts()
{
	$(window).keydown(function(e){
		var keyboard = (document.all) ? e.keyCode : e.which; 
	    if(e.altKey)
	    {
	    	switch (keyboard)
	    	{
	    	
	    		case 65: //Alt + m  - Member list
    			__goToPage("../sections/add_member.php");	
    			break;
    			
	    		case 68: //Alt + d  - Checker tool
	    			__goToPage("../sections/add_assistance.php");	
	    			break;
	    		
	    		case 70: //Alt + f  - Farebox
	    			__goToPage("../sections/farebox.php");	
	    			break;
	    		
	    		case 72: //Alt + h  - Admin
	    			__goToPage("../sections/admin.php");	
	    			break;
	    			
	    		case 73: //Alt + i  - Home
	    			__goToPage("../sections/index.php");	
	    			break;
	    			
	    		case 77: //Alt + m  - Member list
	    			__goToPage("../sections/member_list.php");	
	    			break;
	    			
	    		
	    			
	    		case 81: //Alt + q  - Logout
	    			__goToPage("../sections/logout.php");	
	    			break;
	    			
	    		case 83: //Alt + s  - Shorcuts
	    			__goToPage("../sections/shortcut_list.php");	
	    			break;
	    			
	    		case 85: //Alt + u  - User list
	    			__goToPage("../sections/user_list.php");	
	    			break;
	    			
	    	}
	    }
		
		/** *
		a = 65 | b = 66 | c = 67 | d = 68
		e = 69 | f = 70 | g = 71 | h = 72
		i = 73 | j = 74 | k = 75 | l = 76
		m = 77 | n = 78 | ñ = 186 | o = 79
		p = 80 | q = 81 | r = 82 | s = 83
		t = 84 | u = 85 | v = 86 | w = 87
		x = 88 | y = 89 | z = 90

		0 = 48 | 1 = 49 | 2 = 50 | 3 = 51
		4 = 52 | 5 = 53 | 6 = 54 | 7 = 55
		8 = 56 | 9 = 57 | 
		/** */
	});
	return true;
}

function show_clock()
{
	var digital_date= new Date();
	var hours 		= digital_date.getHours();
	var minutes 	= digital_date.getMinutes();
	var seconds 	= digital_date.getSeconds();
	var dn = "AM";
	
	if ( hours > 12)
	{
		dn = "PM";
		hours = hours - 12;
	}
	
	if (hours == 0){ hours = 12; }
	if (minutes<=9){ minutes = "0" + minutes; }
	if (seconds<=9){ seconds = "0" + seconds; }
		
	$("#info_date").html(hours + ":" + minutes + ":" + seconds + " " + dn);

	setTimeout("show_clock()",1000);
}
	
function active_links()
{
	var href_link = false;
	var link_name = false;
	var current_link = false;
	var sections_link = false;
	
	var href = $(location).attr("href");
	var sections = href.lastIndexOf("/");
	var page_name = href.substring(sections-9);
	
	if($("#sidebar li a").length)
	{
		$("#sidebar li a").each(function() {
			href_link = $(this).attr("href");
			sections_link = href_link.lastIndexOf("/");
			link_name = href_link.substring(sections_link-9);
			
			if(link_name == page_name)
			{
				$(this).parent().addClass("current");
			}
		});
		
		if(!$("#sidebar li").hasClass("current"))
		{
			$("#sidebar li:first-child").addClass("current");
		}
		
		$("#sidebar li a").bind("click",function(){
			$("#sidebar li").removeClass("current");
			$(this).parent().addClass("current");
			__goToPage($(this).attr("href"));
			return false; 
		});
	}
	
	if($("#header").length)
	{
		$("#header").bind("click",function(){
			__goToPage("../landing/applications.php");
		});
	}
	
	if($("#sidebar_logo").length)
	{
		$("#sidebar_logo").bind("click",function(){
			__goToPage("../landing/applications.php");
		});
	}
}