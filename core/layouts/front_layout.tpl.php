<?php header("Content-Type: text/html; charset=utf-8"); ?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
 	<head>
    	<title>.:: <?php echo PROJECT . " - " . $Data->__page_name; ?> ::.</title>
	
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
	    <meta name="description" content="" />
	  		
		<link rel="shortcut icon" 	type="image/x-gif" href="<?php echo TO_ROOT ?>/core/style/images/favicon.png" />
		<link rel="stylesheet" 		type="text/css" media="screen" charset="utf-8" href="<?php echo TO_ROOT ?>/core/style/front.css" />
		<link rel="stylesheet" 		type="text/css" media="screen" charset="utf-8" href="<?php echo TO_ROOT ?>/core/style/overlay.css" />
		<link rel="stylesheet" 		type="text/css" media="screen" charset="utf-8" href="<?php echo TO_ROOT ?>/core/style/jquery.ui/<?php echo $__jquery_theme ?>/jquery-ui.css" />
		
		<!-- //////////  Externals CSS ////////////////////-->  
		<?php if($__css_files){
		    	  foreach($__css_files AS $__css_file ){ ?>
		          	<link rel="stylesheet" type="text/css" charset="utf-8" href="<?php echo $__css_file["file"] ?>" media="<?php echo $__css_file["media"] ?>" />
			<?php } ?>
		<?php } ?>
			
		<script src="<?php echo TO_ROOT ?>/core/jquery/jquery.jquery.js"			type="text/javascript"></script>
		<script src="<?php echo TO_ROOT ?>/core/jquery/jquery.ui.js"				type="text/javascript"></script>
		<script src="<?php echo TO_ROOT ?>/core/scripts/script.core.js" 	type="text/javascript"></script>
		<script src="<?php echo TO_ROOT ?>/core/scripts/script.extend.js" 	type="text/javascript"></script>
		<script src="<?php echo TO_ROOT ?>/core/scripts/script.essentials.js" 	type="text/javascript"></script>
	
		 <!-- //////////  Scripts ////////////////////-->  
		 <!--@todo: find a way to include both functions.js locally -->
		 <?php if($__js_files){
		   	 	  foreach($__js_files AS $__js_file ){ ?>
		        	<script src="<?php echo "$__js_file" ?>" type="text/javascript"></script>
			<?php } ?>
		<?php } ?>
			
		<?php if($__on_ready){?>
			<script type="text/javascript">
				$(document).ready(function() {
		    		<?php foreach($__on_ready AS $__functions => $__function)
		    		{
		    			foreach($__function AS $function => $args)
		    			{
		           			echo $function . "({$args});\n";
						} 
		    		}
					?>
		    	});
		    </script>
		<?php } ?>
	</head>
  
  	<body >
		<div id="page_wrap"> 
			<div id="header"></div>
			<div id="content">
				<div id="info"> 
					<div id="info_logo"></div>
					<div id="info_content"><?php echo Functions::__Translate($Data->__page_name); ?></div>
					<div id="info_date"><?php echo Functions::__getFormatDate($date,"with_time")?></div>
					<div id="secondary_nav">
						<?php if ($_SESSION["user_login_id"]) { ?>
							<a id="link_login" href="<?php echo TO_ROOT ?>/core/application/logout.php"><?php echo Functions::__Translate("Logout") ?></a>
						<?php } else { ?>
							<a href="<?php echo TO_ROOT ?>/apps/landing/forgot_password.php"><?php echo Functions::__Translate("Forgot your password?") ?></a>
						<?php } ?>
					</div>
					<div id="info_message" class="<?php echo $Data->__message["level"]?>">
						<?php echo Functions::__Translate($Data->__message["message"]) ?>
					</div>
				</div>

				<div id="sub_content">
					<?php /* This is actually very important but you know, sometimes important
						   * things are ignored because they are small. */ 
						   echo $_content
					?>	
				</div>
			</div>
		</div>
  	</body>
</html>