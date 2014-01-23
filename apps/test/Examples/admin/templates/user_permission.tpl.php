	<!-- 
	<label class="label_button"><?php //echo Functions::__Translate("Add permissions module")?></label>
	<?php //echo Functions::__createComboBox($modules, "2", "id='add_module_select' name='add_module_select'") ?> 
	<input type="button" id="add_module_button_ok" value="<?php //echo Functions::__Translate("Add module")?>" />
	<br />
	
	<label class="label_button"><?php //echo Functions::__Translate("Delete permissions module")?></label>
	<?php //echo Functions::__createComboBox($user_modules, "", "id='delete_module_select' name='delete_module_select'") ?> 
	<input type="button" id="delete_module_button_ok" value="<?php //echo Functions::__Translate("Delete module")?>" />
	<br />
	 -->
	
	
<?php if($Login->data["permission"]) 
	  {  
	  	foreach ($Login->data["permission"] AS $values )
		{ ?>
			<fieldset>
				<legend><?php echo Functions::__Translate(ucfirst(str_replace("_", " ", $values["module"]))) ?></legend>
				<input type="checkbox" class="all_permission" id="user_permission-<?php echo $values["module"] . "-" . $Login->data["user_login_id"] ?>" name="all_permission-<?php echo $values["module"] ?>" />
				<?php echo Functions::__Translate("Select")?> / <?php echo Functions::__Translate("Unselect all")?>
		
				<ul>
					<?php foreach ($values AS $key => $value) 
					  	  { 
					  		$active = ($value) ? "1" : "0" ;
							if($key != "module")
							{ ?>
				  				<li class="<?php echo $class_row . " " . $inactive_item ?>" id="container-user_permission-<?php echo $Row->user_permission_id ?>">
									<input type="checkbox" class="add_permission <?php echo $values["module"] ?>" <?php if( $value == "1" ) { ?> checked="checked" <?php } ?> id="user_permission-<?php echo $values["module"] . "-" . $key . "-" . $active . "-" . $Login->data["user_login_id"] ?>" name="user_permission-<?php echo $values["module"] . "-" . $key ?>" />
									<label id="label-<?php echo $values["module"] . "-" . $key ?>" for="user_permission-<?php echo $values["module"] . "-" . $key . "-" . $active . "-" . $Login->data["user_login_id"] ?>"> <?php echo  Functions::__Translate(ucfirst(str_replace("_", " ", $key)) ) ?></label>
								</li>
						<?php } ?>
					<?php } ?>
				</ul>
			</fieldset> <br/>
	<?php } //end principal foreach $__rows ?>
<?php } //end principal if ?>
	