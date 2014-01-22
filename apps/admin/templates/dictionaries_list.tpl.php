<?php if($dictionaries = Functions::__getDictionaries()){ ?>	
	<?php foreach ($dictionaries AS $language){ ?>
		<table class="table_view">
			<tr>
				<th><?php echo Functions::__Translate("Dictionary")?></th>
				<td>
					<a href="<?php echo TO_ROOT ?>/apps/admin/dictionary.php?language=<?php echo $language ?>">
					<?php echo Functions::__Translate(ucfirst($language)) ?>
					</a>
				</td>
			</tr>
				
			<tr>
				<th><?php echo Functions::__Translate("Sections")?></th>
				<td>
					<ul>
					<?php $Dictionary = Dictionary::getInstance($language);
						  $Dictionary->load();
						  $sections = $Dictionary->getSections();
						  if($sections)
						  {
						  	foreach ($sections AS $section)
						  	{
						  		echo "<li>" . str_replace("_", " ", ucfirst($section)) . "</li>";
						  	}
						  }
					?>
					</ul>
				</td>
			</tr>
			
			<tr>
				<th><?php echo Functions::__Translate("Actions")?></th>
				<td>
					<ul class="actions">
						<li><a href="<?php echo TO_ROOT ?>/apps/admin/add_dictionary_word.php?language=<?php echo $language ?>"><?php echo Functions::__Translate("Add new paragraph on") . " " . Functions::__Translate($language) ?></a></li>
						<li><a id="<?php echo $language ?>" class="action_delete" href=""><?php echo Functions::__Translate("Delete dictionary") . " " . Functions::__Translate($language) ?></a></li>
					</ul>
				</td>
			</tr>	
		</table>	
	<?php } ?>
<?php } ?>