<?php
if($Data->__container_properties)
{ 
	$container_properties = "";
	foreach($Data->__container_properties AS $property => $value)
	{
		$container_properties .= "{$property}=\"{$value}\" ";
	}
}
//Display structure --->>>>> Functions::__displayVariable($Data->__rows);
?>

<table id="module_list" class="table_list">
	<?php if($Data->__rows) { ?>
		<?php if($Data->__rows["Table"]["Properties"]["title"]){ ?>
			<tr class="table_header">
				<th colspan="<?php echo count($Data->__rows["Columns"]) ?>">
					<?php echo Functions::__Translate($Data->__rows["Table"]["Properties"]["title"]) ?>
				</th>
			</tr>
		<?php } ?>
		
		<?php if($Data->__rows["Columns"]) { ?>
			<tr>
				<?php foreach($Data->__rows["Columns"] AS $row => $value){ ?>
		  			<th><?php echo Functions::__Translate($value["Properties"]["value"]) ?></th>
				<?php } ?>
			</tr>
		<?php } ?>
		
		<?php if($Data->__rows["Rows"]) { ?>
			<?php foreach($Data->__rows["Rows"] AS $row => $values){ ?>
				<tr>
					<?php 
					foreach($values AS $key => $value)
					{ 
						$row_properties = ""; 
						if($key == "actions")
						{
							$row_properties	= "class=\"active_actions\"";
						}
						
						if($value["Row"]["Properties"])
						{
						 	foreach ($value["Row"]["Properties"] AS $row_property => $row_property_value)
							{
								$row_properties .= ($row_property == "value") ? "" : "{$row_property}=\"{$row_property_value}\" ";
							}
						} ?>
						<td <?php echo $row_properties ?> >
							<?php 
							if($key == "actions")
							{ 
								foreach($value AS $action => $action_values)
								{ 
									$action_properties = "";
									foreach ($action_values["Properties"] AS $action_property => $action_property_value)
									{
										$action_properties .= ($action_property == "value") ? "" : "{$action_property}=\"{$action_property_value}\" ";
									} ?>
									<a <?php echo $action_properties ?> ><?php echo Functions::__Translate($action_values["Properties"]["value"]) ?></a>
								
							<?php } 
							
							} else { 
								
								if($value["Href"]["Properties"]["href"])
								{ 
									$href_properties = "";
									foreach($value["Href"]["Properties"] AS $property => $property_value)
									{
										$href_properties .= "{$property}=\"{$property_value}\" ";
									} ?>
									<a <?php echo $href_properties ?> >
							<?php } ?>
								
								<?php echo Functions::__Translate($value["Row"]["Properties"]["value"]) ?>
								
								<?php if($value["Row"]["Properties"]["href"]){ ?></a><?php } ?>
							<?php } ?>
						</td>
					<?php } ?>
				</tr>
			<?php } ?>
		<?php } ?>
	<?php } else { ?>
		<tr>
			<th><?php echo Functions::__Translate("Empty result")?></th>
		</tr>
	<?php } // If $Data->_rows ?>
</table>
	
	
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