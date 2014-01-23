<?php if($Dictionary->data) { ?>
	<?php foreach ($Dictionary->data AS $section => $values) { $class_row = "odd_row"?>
			<table id="dictionary" class="table_list">
				<tr class="table_header">
					<th colspan="3"><?php echo Functions::__Translate("Page section") . ": " . ucfirst(str_replace("_", " ", $section)) ?> </th>
				</tr>
				
				<tr class="table_titles">
					<th><?php echo Functions::__Translate("System value") ?></th>
					<th><?php echo Functions::__Translate("Translate value") ?></th>
					<th><?php echo Functions::__Translate("Actions") ?></th>
				</tr>
				
				<?php foreach ($values AS $value) 
					  {
					  	$class_row = ($class_row == "" || $class_row == "odd_row") ? "even_row" : "odd_row" ;
						?>
					<tr id="line-<?php echo $value["id"] ?>" class="<?php echo $class_row ?>" valign="top"> 
						<td id="system_line-<?php echo $value["id"] ?>" class="right"><?php echo $value["system_value"] ?> = </td>
						<td class="left" id="translate_line-<?php echo $value["id"] ?>"> <?php echo $value["translate_value"]  ?></td> 
						<td class="active_actions" style="width:170px;">
							<a href="<?php echo TO_ROOT ?>/apps/admin/edit_dictionary_word.php?language=<?php echo $language ?>&id=<?php echo $value["id"] ?>"><?php echo Functions::__Translate("Edit") ?></a>
							<a class="action_delete_word" id="<?php echo $Dictionary->language ?>-<?php echo $value["id"] ?>"><?php echo Functions::__Translate("Delete") ?></a>
						</td> 
					</tr> 
				<?php } ?>
				
				<tr class="<?php echo ($class_row == "odd_row") ? "even_row" : "odd_row" ?> active_actions"> 
					<td colspan="3" align="right"><a href="<?php echo TO_ROOT ?>/apps/admin/add_dictionary_word.php?language=<?php echo $language ?>&section=<?php echo $section?>"><?php echo Functions::__Translate("Add new paragraph in this section") ?></a></td>
				</tr> 
					
		<?php } ?>
	</table> 		
<?php } else { ?>
	<h2><?php echo Functions::__Translate("The dictionary is not loaded") ?></h2>
<?php } ?>

<?php //echo Functions::__Translate("Fire","common") ?>