/**
 * Extended features of jQuery
 */
(function($)
{

	/* EXAMPLE: $.createText({text:value}); */
	$.__createText = function(textNode){
        return $(document.createTextNode(textNode.text));
    };
	
	/* EXAMPLE: $.createDiv({id:'',className:''}); */
	$.__createDiv = function(divOptions){
		// Creamos un div
		var div = $(document.createElement("div"));
		// Le ponemos los atributos debidos
		if(divOptions.id!=null && divOptions.id!="") div.attr("id",divOptions.id);
		if(divOptions.dataRole!=null && divOptions.dataRole!="") div.attr("data-role",divOptions.dataRole);
		if(divOptions.className!=null && divOptions.className!="") div.addClass(divOptions.className);
		if(divOptions.content!=null && divOptions.content!="") div.html(divOptions.content);
		return div;
    };
    
    /* EXAMPLE: $.createUl({id:'',className:'',content:''}); */
	$.__createUl = function(ulOptions){
		
		var ul = $(document.createElement("ul"));
		
		if(ulOptions.id!=null && ulOptions.id!="") ul.attr("id",ulOptions.id);
		if(ulOptions.dataRole!=null && ulOptions.dataRole!="") ul.attr("data-role",ulOptions.dataRole);
		if(ulOptions.className!=null && ulOptions.className!="") ul.addClass(ulOptions.className);
		if(ulOptions.content!=null && ulOptions.content!="") ul.html(ulOptions.content);
		return ul;
    };
	
    /* EXAMPLE: $.createLi({id:"",className:"",content:""}); */
	$.__createLi = function(liOptions){
		
		var li = $(document.createElement("li"));
		
		if(liOptions.id!=null && liOptions.id!="") li.attr("id",liOptions.id);
		if(liOptions.className!=null && liOptions.className!="") li.addClass(liOptions.className);
		if(liOptions.dataTheme!=null && liOptions.dataTheme!="") li.attr("data-theme",liOptions.dataTheme);
		if(liOptions.content!=null && liOptions.content!="") li.html(liOptions.content);
		return li;
    };
    
     /* EXAMPLE: $.createSpan({id:"",className:"",content:""}); */
	$.__createSpan = function(spanOptions){
		
		var span = $(document.createElement("span"));
		
		if(spanOptions.id!=null && liOptions.id!="") span.attr("id",spanOptions.id);
		if(spanOptions.className!=null && spanOptions.className!="") span.addClass(spanOptions.className);
		if(spanOptions.dataRole!=null && spanOptions.dataRole!="") span.attr("data-role",spanOptions.dataRole);
		if(spanOptions.content!=null && spanOptions.content!="") span.html(spanOptions.content);
		return span;
    };
    
	/* EXAMPLE: $.createLink({href:"",target:"",id:"",className:""}); */
	$.__createLink = function(linkOptions){
		// Creamos un div
		var linkObj = $(document.createElement("a"));
		// Le ponemos los atributos debidos
		if(linkOptions.href!=null && linkOptions.href!="") linkObj.attr("href",linkOptions.href);
		if(linkOptions.rel!=null && linkOptions.rel!="") linkObj.attr("rel",linkOptions.rel);
		if(linkOptions.target!=null && linkOptions.target!="") linkObj.attr("target",linkOptions.target);
		if(linkOptions.id!=null && linkOptions.id!="") linkObj.attr("id",linkOptions.id);
		if(linkOptions.className!=null && linkOptions.className!="") linkObj.addClass(linkOptions.className);
		if(linkOptions.content!=null && linkOptions.content!="") linkObj.html(linkOptions.content);
		return linkObj;
    };
    
	$.__createImg = function(imageOptions){
		// Creamos un div
		var imageObj = $(document.createElement("img"));
		// Le ponemos los atributos debidos
		if(imageOptions.src!=null && imageOptions.src!="")				imageObj.attr("src",imageOptions.src);
		if(imageOptions.id!=null && imageOptions.id!="")				imageObj.attr("id",imageOptions.id);
		if(imageOptions.className!=null && imageOptions.className!="")	imageObj.attr("class",imageOptions.className);
		if(imageOptions.rel!=null && imageOptions.rel!="")				imageObj.attr("rel",imageOptions.rel);			
		//if(imageOptions.fancybox!=null && imageOptions.fancybox!='')	imageObj.fancybox(imageOptions.fancybox);
		
		return imageObj;
    };
    
    
    
    
    $.fn.__idelay = function(_time,_function)
    {
        var o = $(this);
        o.queue(function()
        {
           setTimeout(function()
           {
              o.dequeue();
           }, _time);
        });
        
        if(_function !=" " && _function !=undefined){
        	eval(_function);
        }
        
        return this;
    };
    
})(jQuery);