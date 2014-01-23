<ul>
	<li><a href="<?php echo TO_ROOT ?>/apps/landing/applications.php"><?php echo Functions::__Translate("Home") ?></a></li>
  	<li>
    	<a><?php echo Functions::__Translate("Applications") ?></a>
    	<ul>
	      <?php 
			if($Apps = Functions::__getApps())
			{	
				foreach ($Apps AS $app)
				{ 
					?>
					<li><a href="<?php echo TO_ROOT ?>/apps/<?php echo $app ?>/"><?php echo Functions::__Translate(ucfirst($app))?></a></li>
					<?php 
					}
			} ?>
		</ul>
	</li>
	<?php if( isset($_SESSION["user_login_id"]) ) { ?>
		<li><a href="<?php echo TO_ROOT ?>/apps/admin/profile.php?user_login_id=<?php echo $_SESSION["user_login_id"] ?>">
		<?php echo ($_SESSION["sex"] == "man" ) ? Functions::__Translate("Welcome") : Functions::__Translate("Wellcome") ; ?> <?php echo $_SESSION["names"] ?></a>
		</li>
		<li><a id="link_logout" href="<?php echo TO_ROOT ?>/core/application/logout.php"><?php echo Functions::__Translate("Logout") ?></a></li> 
		
	<?php } else { ?>
		<li><a id="link_login" href="<?php echo TO_ROOT ?>/apps/landing/login.php"><?php echo Functions::__Translate("Login") ?></a></li> 
		<li><a href="<?php echo TO_ROOT ?>/apps/landing/forgot_password.php"><?php echo Functions::__Translate("Forgot your password?") ?></a></li>
	<?php } ?>
</ul>