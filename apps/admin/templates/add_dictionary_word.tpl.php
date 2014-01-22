<form id="dictionary_form" class="form_data">
	<table class="table_list" >
		<tr class="table_header">
			<th colspan="3"><?php echo Functions::__Translate("Add paragraph") ?> - <?php echo Functions::__Translate("Dictionary") . "  " . $language ?> </th>
		</tr>
		
		<tr class="table_titles">
			<th><?php echo Functions::__Translate("Meta values") ?> </th>
			<th><?php echo Functions::__Translate("System value") ?> </th>
			<th><?php echo Functions::__Translate("Translate value") ?> </th>
		</tr>
		
		<tr class="even_row">
			<td class="center">
				<?php echo Functions::__Translate("Section")?> 
				<?php if($section)
					  {
					  	echo ucfirst(str_replace("_", " ", $section));
					  } else { ?>
						<select id="sections" name="sections"></select> 
						<br/><br/>
						
					    <?php echo Functions::__Translate("Language")?> 
						<select id="dictionaries" name="dictionaries"></select> 
						<br/><br/>
						
						<?php echo Functions::__Translate("New section") ?><br/>
						<input type="text" id="section_x" name="section_x" />
						 
				<?php } ?>
			</td>
			<td>
				<textarea name="system_value" id="system_value" ><?php echo ($system_value) ? $system_value : "" ?></textarea>
			</td>
			<td>
				<textarea name="translate_value" id="translate_value" ><?php echo ($translate_value) ? $translate_value : "" ?></textarea>
			</td>
		</tr>
		
		<tr class="even_row">
			<td colspan="3" class="center">
				<input type="button" id="dictionary_button_cancel" name="dictionary_button_cancel" value="<?php echo Functions::__Translate("Cancel")?>">
				<input type="button" id="dictionary_button_ok" name="dictionary_button_ok" value="<?php echo Functions::__Translate("Save")?>">
				<input type="hidden" id="task" name="task" value="<?php echo ($id) ? "edit" : "add" ?>"><br />
				<input type="hidden" id="section" name="section" value="<?php echo $section ?>"><br />
				<input type="hidden" id="language" name="language" value="<?php echo $language ?>"><br />
				<?php if($id){ ?><input type="hidden" id="id" name="id" value="<?php echo $id ?>"><?php } ?>
			</td>
		</tr>
	</table>
</form>