<?php
if($Data->__container_properties)
{ 
	$container_properties = "";
	foreach($Data->__container_properties AS $property => $value)
	{
		$container_properties .= "{$property}=\"{$value}\" ";
	}
}
//Display structure --->>>>>  Functions::__displayVariable($Data->__matchList);
?>

<form <?php echo $container_properties ?>>
	<div class="<?php echo ($Data->__showHideMatch == false) ? "__hide" : "" ?>">
		<textarea id="match_list" name="match_list"><?php echo ($Data->__showHideMatch == false) ? serialize($Data->__matchList) : Functions::__displayVariable($Data->__matchList); ?></textarea>
	</div>
	
	<?php if($Data->__rows) 
		  { 
		  	  foreach ($Data->__rows AS $__rows)
		  	  { 
		  	  	  foreach ($__rows AS $__row)
				  { 
				  	if(!empty($__row))
				  	{
					  	$row_properties 	= "";
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
									
								} else {
									$field_properties .= "{$property}=\"{$value}\" ";
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
			  			
			  			<div <?php echo $row_properties ?> >  
			  			
			  				<?php if($__row["Label"]["Properties"]["value"]){ ?>
			  					<label <?php echo $label_properties ?>><?php echo Functions::__Translate($__row["Label"]["Properties"]["value"])?></label>
			  				<?php } ?>
			  			
			  				<?php switch ($__type){ 
			  					default:
			  					 	?>
			  						<input <?php echo $field_properties ?> />
			  					<?php break; ?>
			  					
					          	<?php case "hr": ?>
					          		<hr  <?php echo $field_properties ?> />
					          	<?php break; ?>
					          	
					          	<?php case "link": ?>
					          		<a  <?php echo $field_properties ?>><?php echo $__value?></a>
					          	<?php break; ?>
					          	
					          	<?php case "title": ?>
					          		<?php echo "<{$__title_size} {$field_properties}> {$__value}</{$__title_size}>" ?>
					          	<?php break; ?>
					          	
					          	<?php case "message": ?>
					          		<span  <?php echo $field_properties ?>><?php echo $__value?></span>
					          	<?php break; ?>
					          	
					          	<?php case "textarea": ?>
			  						<textarea <?php echo $field_properties ?>><?php echo $__value?></textarea>
					          	<?php break; ?>
					          	
					            <?php case "select": 
								          $field_properties = str_replace("size", "title", $field_properties);
								          $field_properties = str_replace("readonly", "disabled", $field_properties);
			  							  $field_properties = str_replace("type=\"select\"", "", $field_properties);
								          $field_properties = str_replace("value=\"{$__value}\"", "", $field_properties);
								          ?>
										  <select <?php echo $field_properties ?> ><option><?php echo Functions::__Translate("Select one") ?></option></select>
								          <?php           
								          //echo createComboBox($__row["Field"]["Items"],$__value, $field_properties);
								          break;
								          
								      case "radio":
								          echo Functions::__createRadioButton($__row["Field"]["Items"], $__value, $field_properties);
								          break; 
								          
								      case "elementFree": 
					          				echo $__value;
					          				break;?>
					          				
			  			<?php } // switch ?>
			  			</div>
				<?php } // If empty rows ?>
			<?php } // foreach $_rows ?>	  		
		<?php } // foreach $Data->_rows ?>	  	
	<?php } // If $Data->_rows ?>
	
	<!-- ----------- Actions ------------->
	<?php if(!empty($Data->__actions)) { ?>
			<div class="actions" >
				<?php foreach($Data->__actions AS $__action)
				  	  {
					      	$Action = (object)$__action; ?>
							<input type="button" id="<?php echo $Action->id; ?>" name="<?php echo $Action->name; ?>" name="eForm_button<?php echo $Action->class; ?>" value="<?php echo Functions::__Translate($Action->value) ?>"><br />
				<?php } //end foreach Actions ?>
			</div>
	<?php } // If actions ?>
</form>