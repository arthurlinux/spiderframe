<?php  
if($Data->__container_properties)
{ 
	$container_properties = "";
	foreach($Data->__container_properties AS $property => $value)
	{
		$container_properties .= "{$property}=\"{$value}\" ";
	}
}
//Display structure --->>>>> Functions::__displayVariable($Data);
?>

<?php if($Data->__rows) { ?>
		  <table <?php echo $container_properties ?> class="table_view">
			  <?php foreach ($Data->__rows AS $__rows)
			  	  	{ 
			  	  	  foreach ($__rows AS $__row)
					  { 
					  	if(!empty($__row))
					  	{
						  	$row_properties 	= "";
							$href_properties 	= "";
						  	$field_properties 	= "";
							$label_properties 	= "";
							
							$__type 		= $__row["Field"]["Properties"]["type"];
						  	$__name 		= $__row["Field"]["Properties"]["name"];
						  	$__value 		= $__row["Field"]["Properties"]["value"];
						  	$__title_size 	= $__row["Field"]["Properties"]["size"];
						  				
							if($__row["Row"]["Properties"])
							{ 
								foreach($__row["Row"]["Properties"] AS $property => $value)
								{
									$row_properties .= ($property != "Hide") ? "{$property}=\"{$value}\" " : "";
								}
							} 
							
					  		if(!strpos($row_properties, "id"))
					  		{
				  				$row_properties .= "id=\"element_{$Data->__form_properties["id"]}_{$__row["Field"]["Properties"]["name"]}\" ";
				  			}
							
					  		if($__row["Field"]["Properties"])
							{ 
								foreach($__row["Field"]["Properties"] AS $property => $value)
								{
									
									if( ($__type == "textarea" && $property == "value") || ($__type == "select" && $property == "value") || ($__type == "radio" && $property == "value") || ($__type == "title" && $property == "size") )
									{
										
									} else if ($property != "href") {
										$field_properties .= "{$property}=\"{$value}\" ";
									}
									
									if ($property == "href" || $property == "target") {
										$href_properties .= "{$property}=\"{$value}\" ";
									}
									
									if( $__type == "title" && $property == "size")
									{
										$__title_size = $value;	
									}
								} 
							}
						  
						  	if($__row["Label"]["Properties"])
							{ 
								foreach($__row["Label"]["Properties"] AS $property => $value)
								{
									$label_properties .= ($property != "value") ? "{$property}=\"{$value}\" " : "";
								} 
							}
							?>
							<tr <?php echo $row_properties ?> >  
				  				<th <?php echo $label_properties ?> ><?php echo Functions::__Translate($__row["Label"]["Properties"]["value"])?></th>
				  				<td <?php echo $field_properties ?> >
				  					<?php if($href_properties){ ?><a <?php echo $href_properties ?> ><?php } ?>
									<?php echo $__value ?>
									<?php if($href_properties){ ?></a><?php } ?>
				  				</td>
				  			</tr>
					<?php } // If !empty rows ?>
				<?php } // foreach $_rows ?>	  		
			<?php } // foreach $Data->_rows ?>	  	
		
			<?php if(!empty($Data->__actions)) { ?>
				<tr>
					<th><?php echo Functions::__Translate("Actions")?></th>
					<td>
						<ul class="actions">
							<?php foreach($Data->__actions AS $action)
							  	  { 
								      $Action = (object)$action; 
								      ?>
								      <li><a id="<?php echo $Action->id ?>" <?php echo ($Action->class)? "class=\"{$Action->class}\"" : ""; echo ($Action->href)? "href=\"{$Action->href}\"" : ""; ?>><?php echo Functions::__Translate($Action->value) ?></a></li>
							<?php } //end foreach Actions ?>
						</ul>	
					</td>
				</tr>
			<?php } // If actions ?>
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
<?php } // If $Data->_rows ?>