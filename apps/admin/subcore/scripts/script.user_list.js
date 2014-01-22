function search(user_type)
{	
	if(user_type == "member")
	{ 
		$("#search_user").keyup(function(e) {
			if(e.keyCode == 13)
			{
				var search_type = $("input[name=search_type]:checked").attr("id");
				search_members($(this).val(),search_type); 
			}
		});
		
		$("input[name=search_type]").click(function(e) {
			if($("#search_user").val())
			{
				search_members($("#search_user").val(), $(this).attr("id"));
			}
		});
		
	} else { 
		$("#search_user").keyup(function(e) {
			if(e.keyCode == 13)
			{ 
				var search_type = $("input[name=search_type]:checked").attr("id");
				search_users($(this).val(),search_type); 
			}
		});
		
		$("input[name=search_type]").click(function(e) {
			if($("#search_user").val())
			{
				search_users($("#search_user").val(), $(this).attr("id"));
			}
		});
	}
	
	$("#paginate_select").change(function(){
		var id = $(this).children(":selected").attr("id");
		__goToPage(id);
	});
}

function search_users(to_search, search_type)
{
	var dataForm = "to_search=" + to_search + "&search_type=" + search_type + "&user_rol=user" + "&search_user_options=false" ;
	var dataSearch = __getFileExecute({"url": "../../apps/admin/search_user_list.php", "dataForm": dataForm,"type":"GET"});
		
	$("#users").html(dataSearch);
	//$("#users").html($("#users").html().replace(to_search,"<span class='important_red'>" + to_search + "</span>"));
}

function search_members(to_search, search_type)
{
	var dataForm = "to_search=" + to_search + "&search_type=" + search_type + "&search_user_options=false" ;
	var dataSearch = __getFileExecute({"url": "../apps/search_member_list.php", "dataForm": dataForm,"type":"GET"});
		
	$("#users").html(dataSearch);
	//$("#users").html($("#users").html().replace(to_search,"<span class='important_red'>" + to_search + "</span>"));
}