<div id="front_actions">
	<a href="<?php echo TO_ROOT ?>/apps/admin/admin_users.php"><?php echo Functions::__Translate("Users")?></a>
	<a href="<?php echo TO_ROOT ?>/apps/fiscal/admin_client.php"><?php echo Functions::__Translate("Client")?></a>
	
	<?php foreach ($Apps AS $app){ ?>
			<a href="<?php echo TO_ROOT ?>/apps/<?php echo $app ?>/"><?php echo Functions::__Translate(ucfirst($app))?></a>
	<?php } ?>
	
</div>