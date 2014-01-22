<ul>
	<li><a class="first" href="<?php echo TO_ROOT ?>/sections/admin.php"><?= System::__Translate("Admin tools") ?></a></li>
	<?php if($_SESSION["user_login_id"]){ ?>
		<li><a href="<?php echo TO_ROOT ?>/sections/dictionaries.php"><?php echo System::__Translate("Dictionaries") ?></a></li>
		<li><a href="<?php echo TO_ROOT ?>/sections/add_dictionary.php"><?php echo System::__Translate("New dictionary") ?></a></li>
		<li><a href="<?php echo TO_ROOT ?>/sections/add_dictionary_word.php"><?php echo System::__Translate("New paragraph") ?></a></li>
		<?php foreach (System::__getDictionaries() AS $language){ ?>
			<li><a href="<?php echo TO_ROOT ?>/sections/dictionary.php?language=<?php echo $language ?>"><?php echo System::__Translate("Dictionary") . " " . System::__Translate(ucfirst($language)) ?></a></li>
		<?php } ?>
	<?php } ?>
</ul>