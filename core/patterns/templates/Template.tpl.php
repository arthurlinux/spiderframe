<?php
	//Display structure --->>>>>  Functions::__displayVariable($Data);

  	if($Data->__html_contents)
  	{
    	foreach($Data->__html_contents AS $key => $value)
    	{
    		foreach($value AS $_key => $_value )
    		{
    			foreach($_value AS $__key => $__value )
    			{
    				//echo $_key ;
    				echo $__value->getHTML();
    			}
    		}
    	}
  	}
?>

<?php if($Data->__general_actions){ ?>
	<ul class="general_actions">
		<?php foreach($Data->__general_actions AS $general_action )
			  { 
			  	$Action = (object)$general_action; 
			  	?>
				<li><a id="<?php echo $Action->id ?>" <?php echo ($Action->class)? "class=\"{$Action->class}\"" : ""; echo ($Action->href)? "href=\"{$Action->href}\"" : ""; ?>><?php echo Functions::__Translate($Action->value) ?></a></li>
		<?php  } ?>		
	</ul>  	
<?php  } ?>