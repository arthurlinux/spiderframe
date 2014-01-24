/* <<<<<<<<<<<<<<<<< ---------------- JS SCRIPTS ------------------ >>>>>>>>>>>>>>>>>>>>>>>>>>>> */
var storage;
var page_name = __getPageName();

try 
{
    if (localStorage.getItem) 
    {
        storage = localStorage;
    }
} catch(e) {
    storage = {};
}

__loadDictionaryInStorage(page_name);

//alert("hola esto es core");
function __showMessage(params) 
{   //alert(__isArray(params));
	if(!__isArray(params))
	{
		temp_params = params;
		params = {"message":"<image id='__loader' src='../../core/style/images/loading_bubble.gif'>", "buttons": false,"level":false};
	}
	
	var options = true;
	var margin_top = document.body.scrollTop - 120;
	var margin_left = document.body.scrollLeft - 150;
	
	if(typeof(params.options)=="undefined" || typeof(params.options)=="null" || params.options == "" || params.options == false || params.options.lenght == 0)
	{
		params.options = {"Ok":function(){ __closeMessage(); } }; 
		options = false;
	}
	
	__addOverlayMessage();
	
	var i = 1;
	for(var x in params.options){
		var btn = $("#__overlayAction_"+i);
		btn.html(__T(x));

		(function(actions){
			btn.unbind("click");
			btn.bind("click", actions);
		})(params.options[x]);

		//btn.attr('click'onClick',buttons[x]);
		//btn.click(function(){eval(buttons[x]);closeMessage();});

		btn.css("display","inline-block");
		i++;
	}
	
	$("#__close").unbind("click"); 
	$("#__close").click(function(){
		__closeMessage();
	});
	
	$("#__overlay").css("margin-top", margin_top+"px");
	$("#__overlay").css("margin-left", margin_left+"px");
	$("#__overlayShadow").css("width", "100%"); 
	
	$("#__overlayContent").html(__T(params.message));
	$("#__overlayAction").show();
	$("#__overlayShadow").show();
	$("#__overlay").show("puff"); 
	
	//effects 'blind','bounce','clip','drop','explode','fold','highlight','pulsate','scale','shake','slide','puff'
	__actionMessageKey(options);
}

/**
 * This function close the message 
 * hidde all divs in the message
 * return void
 */
function __closeMessage()
{	
	$("#__overlayShadow").remove();
	$("#__overlay").remove();
	return true;
}

/**
 * To detect which key has been pressed to execute 
 * the corresponding action in the message
 * return void
 */
function __actionMessageKey(options)
{	
	$("#__overlayAction_1").focus();
	$(document).keydown(function(e) {
	    if(e.keyCode == 27) {
	    	if(options){ 
	    		$("#__overlayAction_1").click();
	    		return false;
	    	} else {
	    		__closeMessage();
	    		return false;
	    	}
	    }
	    /**/
	    if(e.keyCode == 13) {
	    	if(options){ 
	    		$("#__overlayAction_1").click();
	    		return false;
	    	} else {
	    		__closeMessage();
	    		return false;
	    	}
	    } /**/
	});
}

function __showLoader(message,loader) 
{
	message = (message) ? message : "Loading";
	var levelImage = $("#__levelImage");
	var loaderImage = (!loader || loader == "loading" ) ? "<image id='__loader' src='../../core/style/images/loading_bubble.gif'> " : "<image src='../core/styles/images/loading_bar.gif' > " ;
	var levelDirName = levelImage.attr("src").substring(0,levelImage.attr("src").lastIndexOf("/") + 1);
	//levelImage.attr("src",levelDirName + "__loader.png");
	//levelImage.show();
	levelImage.hide();
	$("#close_message").hide();
	$("#__overlayContent").html(loaderImage);
	$("#__overlayContent").append("<br />" + message);
	$("#__overlayAction").hide();
	$("#__overlayShadow").show();
	$("#__overlay").show("fade"); 

	//effects 'blind','bounce','clip','drop','explode','fold','highlight','pulsate','scale','shake','slide','puff'
}

function __closeLoader ()
{	
	$("#__overlayShadow").delay(1000).hide("highlight");
	$("#__overlay").delay(500).hide("explode");
	//$("#__overlayContent").delay(9000).html("");
}

/**
 * This function check to valid e-mail
 * @param $str string to check
 * @return boolean
 * 
 */
function __isValidMail(mail) 
{
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(mail);
}

/**
 * This function redirect to url
 * @param $url string to address
 * @return boolean
 * 
 */
function __goToPage(url) 
{
	
	$("body").fadeOut(10000000000,__go(url));
	
}

function __go(url)
{
	window.location.href = url;
}
/**
 * This function check is valid array
 * @param obj to eval
 * @return boolean
 * 
 */
function __isArray(obj) 
{
	/*
   	if (obj.constructor.toString().indexOf("Array") == -1)
   	{
    	returnData = false;
	} else {
      	returnData = true;
	}
	*/
		returnData = true;
	
	return returnData;
	//return typeof(obj)=='object'&&(obj instanceof Array);
} 

/**
 * This function runs a file and loads it into a designated container
 * @param $url string
 * @param $container string
 * @param $func array string
 * @return void
 */
function __getFileJSON(urlFile)
{
	fileContent = $.ajax({
		url: urlFile,
		async:false
	}).responseText;
	var returnData = JSON.parse(fileContent);
	return returnData;
}

/**
 * This function runs a file and get result
 * @param $url string
 * @param $container string
 * @param $func array string
 * @return void
 */
function __getFileExecute(params)
{
	var url = (params.url != "" ) ? params.url : "" ;
	var dataForm = (params.dataForm != "" ) ? params.dataForm : false;
	var method = (params.type == "GET" || params.type == "get" ) ? "GET" : "POST";
	
	fileContent = $.ajax({
		url: url,
		type: method,
		data: dataForm,
		async:false
	}).responseText;
	return fileContent;
}

function __sendRequest (params)
{
	var returnData = false;
	var url = (params.url != "" ) ? params.url : "#" ;
	var async = (params.async == true ) ? true : false;
	var loader = (params.loader == true ) ? true : false;
	var crossDomain = (params.crossDomain == true ) ? true : false;
	var timeout = (params.timeout >= 1000 ) ? params.timeout : 50000;
	var dataForm = (params.dataForm != "" ) ? params.dataForm : false;
	var dataType = (params.dataType != "" ) ? params.dataType : "json";
	var method = (params.type == "GET" || params.type == "get" ) ? "GET" : "POST";
	var message_loader = (params.message_loader) ? params.message_loader : "Loading";
		//dataForm = (method == "POST")? dataForm : "dataForm="+dataForm;
	
	fileContent = $.ajax({
		url: url,
		type: method,
		async: async,
		timeout: timeout,
		dataType: dataType,
		crossDomain: crossDomain,
		data: dataForm,
		beforeSend:function(){ 
						if(loader == true){
							__showLoader(message_loader); 
						}
		},
		success:function(jsonData) {
						if(loader == true){
							__closeLoader();
						}
		}
	}).responseText;
	
	var returnData = JSON.parse(fileContent);
	return returnData;	
}

function __getUrlGet(getParam)
{
 	var href = $(location).attr("href");
 	var n = href.lastIndexOf("?");
	var hash = (href.lastIndexOf("#") > 1 ) ? href.lastIndexOf("#") : href.length ;	
	var sURLVars = href.substring(n+1,hash);
	var sURLGet = sURLVars.split("&");	
   
    for (var i = 0; i < sURLVars.length; i++)
    {
        var sParameterName = sURLGet[i].split("=");
        if (sParameterName[0] == getParam)
        {
            return sParameterName[1];
        }
    }
}

function __getPageName()
{
	var href = $(location).attr("href");
 	var slash = href.lastIndexOf("/");
 	var dot = href.indexOf(".");
 	var page = href.substring(slash+1, dot);
 	return page;
}

function __getFormatNumber(params)
{  
	var number = (params.number) ? params.number : 0 ;
	var symbol = (params.symbol) ? params.symbol : "$" ;
	var format = (params.format) ? params.format : false ;
		
	switch (format){
       	case false: 
         	return number;
       	break;
       	case "english": 
       		return  (symbol) ? symbol + "" + __numberFormat(number,2) : __numberFormat(number,2);
       	break;
       	
       	case "english_without_thousands_separator": 
       	 	return  ($symbol) ? symbol + " " + __numberFormat($number, 2, '.', '') : __numberFormat(number, 2, '.', '');
       	break;	   
	   	case "french": 
         	return __numberFormat(number, 2, ',', ' ');
		break;
		
	}
}

function __numberFormat(number, decimal, decimal_separator , thousand_separator)
{ 
    number=parseFloat(number);
    
    if(isNaN(number))
    {
        return "";
    }
    
	decimal = (decimal) ? decimal : 2 ; 
	number = number.toFixed(decimal) + '';
    x = number.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) 
    {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function __addOverlayMessage()
{	
	var src = "../../core/style/images/close.png";
	
	var overlayShadow 	= $.__createDiv({"id":"__overlayShadow", "className":"__overlayShadow"});
	var close 			= $.__createImg ({"id":"__close", "className":"__close", "src": src});
	var message 		= $.__createDiv ({"id":"__overlay", "className":"__overlay"});
	var messageClear 	= $.__createDiv ({"id":"__overlayClear"});
	var messageContent	= $.__createDiv ({"id":"__overlayContent"});
	var messageAction 	= $.__createUl ({"id":"__overlayAction", "className":"__overlayAction"});
	var messageAction_1 = $.__createLi ({"id":"__overlayAction_1","content":"Yes"});
	var messageAction_2 = $.__createLi ({"id":"__overlayAction_2","content":"No"});
	var messageAction_3 = $.__createLi ({"id":"__overlayAction_3","content":"Cancel"});
	
	messageAction.append(messageAction_1, messageAction_2, messageAction_3);
	message.append(messageClear,messageContent,messageAction);
	
	$("body").append(overlayShadow,message);/* **/
}

/****** -------------  Tranlate functions ------------- **********/
/**
 * __loadDictionaryInStorage function
 * @param page string is the page section to load for tranlate
 * @returns storage.dictionary load dictionary section and common in localStorage
 */
function __loadDictionaryInStorage(page)
{
	var i 			= 0;
	var dictionary 	= false;
	
	if(!dictionary)
	{
		dictionary =  __sendRequest ({"url":"../../core/application/get_dictionary.php","dataForm":"page="+page});
	}
	//alert(JSON.stringify(dictionary));
	return storage.dictionary = JSON.stringify(dictionary);
}

function __T(word)
{
	return __translate(word);
}

function __t(word)
{
	return __translate(word);
}

function __Translate(word)
{
	return __translate(word);
}

function __translate(word)
{
	if(word)
	{
		var	index_word = word.replace(/\s/g,"_");
			index_word = index_word.replace(/\./g,'');
			index_word = index_word.replace(/\-/g,'_');
		var local_dictionary = JSON.parse(storage.dictionary);
		var local_word = eval("local_dictionary."+index_word);
			word = (local_word != undefined) ? local_word : word;
	}
	
	return word;
}

function __focus(id)
{ 
	if(id == "first")
	{
		$("input:text:visible:first").focus();
	} else {
		$("#" + id).focus();
	}
	
	return true;
}

function __setCitiesOnSelect(state_id, city_id)
{ 
	$("#" + state_id).change(function(){
		
		var select_state_id = $(this).find("option:selected").val();
		var dataForm = "state_id=" + select_state_id;
		var cities = __sendRequest({"url":"../../core/application/get_cities.php", "dataForm": dataForm, "type": "GET"});
		
		$("#" + city_id + " option").each(function() {
		   $(this).remove();
		});
		
		if(cities.data)
		{
			__createOptionForComboBox(city_id, cities.data);
		}
		
	});
	
	return true;
}

function __createComboBox(id, items, selected, parameters)
{
	var select = "<select>\n" + items + "</select>\n";
   
	$("#" + id_select_box).html(select);
    return select;
}

function __createOptionForComboBox(id, items, selected)
{	
	var options = new Array();
	$.each(items, function(option_id, option) 
	{ 
		var this_selected = (selected == option_id) ? "selected='selected'" : "" ;
		options[option_id] = "<option id='" + option_id + "' value='" + option_id + "'" + this_selected + ">" + option + "</option>";
	});
		
	$("#" + id).append(options);
		
	return true;
}

function __saveRow(params)
{
	var url = (params.url) ? params.url : "../../core/application/save_row.php";
 	url = url+"?id="+params.id+"&row="+params.row;
	//alert(url);
	return __sendRequest ({"url":url, "dataForm":params.dataForm,"message_loader":params.message_loader,"loader":params.loader});
 }
 
function __saveField(params)
{
	var id = (params.id) ? params.id : false;
	var row = (params.row) ? params.row : false;
	var value = (params.value) ? params.value : "0" ;
 	var token = (params.token) ? params.token : false;
	var field = (params.field) ? params.field : "active";
 	var url = (params.url) ? params.url : "../../core/application/save_field.php";
 	//alert("hola");
	return __getFileJSON(url+"?token="+token+"&id="+id+"&row="+row+"&field="+field+"&value="+value);
 }
 
 
function __activeAction (className) 
{ 
	
	className = (className) ? className : "active_action" ; 
	
	$("."+className).bind("click",function() { 
		var element = $(this); 
		var attr_id = element.attr("id");
		 	attr_id = attr_id.split("-");
		var row  	= attr_id[0];
		var field  	= attr_id[1];
		var id 		= attr_id[2];
		var value 	= attr_id[3];
		var inverse	= (value == 1) ? 0 : 1;
		var inverse_value = (value == 1) ? "Active" : "Inactive" ; 
		var new_id	= attr_id[0] + "-" + attr_id[1] + "-" + id + "-" + inverse; 
		var html 	= inverse_value;
		var parent_id =  "container-" + attr_id[0] + "-" + id;
		var new_class = (value == 1) ? "" : "inactive_item";
		var old_class = (value == 0) ? "" : "inactive_item";
		 //alert("row "+row+" id "+id+" field "+field+" value "+value+" " +element.attr("id"));
		var options = {"Ok": 
						function(){
							$("#"+ element.attr("id")).html(html);
							$("#"+ element.attr("id")).attr("id", new_id);
							$("#"+ parent_id).removeClass(old_class);
							$("#"+ parent_id).addClass(new_class);
							
							__saveField({"row":row,"id":id,"field":field,"value":inverse});
							__closeMessage();
						},
						"Cancel":
						function(){
							__closeMessage();
						}
					 };
		__showMessage({"message":"Are you sure to " + inverse_value, "options":options}); /** */
	}); 
}

  