
	
	<div id="dictionary_form_success"></div>
	
	<?php if( isset( $_SESSION["user_login_id"] ) ) { ?>
		<form id="dictionary_form" class="form_data">
			<label for="language"><?php echo Functions::__Translate("Dictionary language") ?></label> <input type="text" id="language" name="language" class="required" > <br />
			<input id="dictionary_button_ok" name="dictionary_button_ok" type="button" class="button_first" value="<?php echo Functions::__Translate("Add dictionary") ?>"><br />
			<input id="dictionary_button_cancel" name="dictionary_button_cancel" type="button" class="button_first" value="<?php echo Functions::__Translate("Cancel") ?>">
		</form>	
	<?php } ?>
