<form id="dictionary_word" class="form_data">
	<table class="table_list" >
		<tr class="table_header">
			<th colspan="3"><?php echo System::__Translate("Edit paragraph") ?> - <?php echo System::__Translate("Dictionary") . "  " . $language ?> </th>
		</tr>
		
		<tr class="table_titles">
			<th><?php echo System::__Translate("Section") ?> </th>
			<th><?php echo System::__Translate("System value") ?> </th>
			<th><?php echo System::__Translate("Translate value") ?> </th>
		</tr>
		
		<tr class="even_row">
			<td class="center">
				<?php echo $line["section"] ?>
			</td>
			<td>
				<textarea name="system_value" id="system_value" ><?php echo $line["system_value"] ?></textarea>
			</td>
			<td>
				<textarea name="translate_value" id="translate_value" ><?php echo $line["translate_value"] ?></textarea>
			</td>
		</tr>
		
		<tr class="even_row">
			<td colspan="3" class="center">
				<input type="button" class="__forms" id="dictionary_button_cancel" name="dictionary_button_cancel" value="<?php echo System::__Translate("Cancel")?>">
				<input type="button" class="__forms" id="dictionary_button_ok" name="dictionary_button_ok" value="<?php echo System::__Translate("Save")?>">
				<input type="hidden" id="id" name="id" value="<?php echo $line["id"] ?>"><br />
				<input type="hidden" id="task" name="task" value="edit"><br />
				<input type="hidden" id="language" name="language" value="<?php echo $language ?>">
			</td>
		</tr>
	</table>
</form>