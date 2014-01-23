<?php  

	//
	//	Copyright (c) 2009 Michal Šimonfy http://virae.org | i@virae.org
	//	NEWSLETTER MODULE | http://virae.org/newsletter_module
	//  Licenced under Creative Commons Attribution-Noncommercial-Share Alike 3.0 
	//  http://creativecommons.org/licenses/by-nc-sa/3.0/
	//	Version: .9 (Feb 29, 2009)
	
	//  Hi! and thanks for downloading my newsletter module, 
	//  please, notice the settings section just a few lines below, 
	//  where you can configure some of module preferences.
	//  [ f.e optional password protection, custom template for e-mails, custom css, ... ]
	
	//  Please feel free to use the plugin for your personal use, or for non-comercial
	//  projects. Please, always keep this header included and if you like this plugin,
	//  feel free to write me an e-mail. Thank you !

	//  Common mistakes: If You get an error "SyntaxError: missing } in XML expression," 
	//  please, set your directory for attachments writable.  
	
?>
<?php
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?><?php

// ============
// = SETTINGS =
// ============

// PASSWORD PROTECTION
	
	$password_protection = false;
	// password
	$password = "root";
	$password_hash = sha1($password);

// E-MAIL
	//your e-mail
	$your_email = "you@domain.com";
	//your e-mail
	$your_name = "user";
	//email check - your address will be added to recipients everytime
	$mailcheck = false;

// DATABASE
	
	$host = "localhost";
	$user = "root";
	$password = "root";
	$database = "newsletter";
	
// ATTACHMENT DIR

	//directory Where To Upload Files - MUST BE SET WRITABLE !!!
	$dir = "attachments/";
	$jquery_src = "http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js";
	
// SESSION

	$session_name = 'newsletter';
	// session timeout in seconds
	$session_timeout = 3600; 

// OPTIONAL E-MAIL TEMPLATE

	// SET THIS TO TRUE IF YOU LIKE TO USE THE TEMPLATE FOR SENT E-MAILS
	$use_template = false;

	// IF SET TO TRUE, EMAIL MESSAGE WILL BE WRAPPED WITH THESE HTML STRINGS

	$template_top = '
	<html>
		<body>
			<img src="http://virae.org/news.jpg" />
			<div style="width:750px;background:url(http://virae.org/background.png);background-color:#9EC303;padding:20px;background-repeat:repeat-x;">
				<h1 style="display:inline;font-size:45px;color:#fff;font-weight:normal;font-family:\'Myriad Pro\';">HI AGAIN</h1>
				<br style="clear:both;" /><br />
				<div style="width:96%;padding:2%;border-top:0px solid #f30;color:#fff;">';
	
	$template_bottom = '
					<br /><br />- - - <br />
					Our company<br />
					e-mail: x@y.com<br /><br />
				</div>
			</div>
		</body>
	</html>';
		

// CSS

	$css = "
				body {
					font-family: arial, verdana;
					font-size:15px;
					background:url(images/background.png) repeat-x;
				}
				h1 {
					color:#fff;
					font-size:45px;
				}
				h1, h2, h3, h4 {
					font-family:'myriad pro';
					color:#444;
					display:inline;
					font-weight:normal;
				}
				h2 {
					color:#666;
					font-weight:bold;
				}
				h4{
					font-size:small;
				}
				input[type=password],input[type=text],textarea {
					background-color: #f8f8f8;
					border-color: #fff #ddd #ddd #fff;
					border: 1px solid #ccc;
					color:#222;
				}
				input[type=password]:focus,textarea:focus,input[type=text]:focus {
					background-color: #fff;
					border: 1px solid #66CFFF;
				}           
				small{
				  font-size:small;
				  color:#777;
				}
				/* working indicator */
				#processing {
					background-color:#fff;
					border:1px solid #777;
					-moz-border-radius:3px;
					color:#666;
				}
	
				.h2emails {
					color:#7CB4C6;
				}
				.backlink{
					color:#da5050;
					font-size:medium;
					font-weight:bold;
					opacity:.75
				}
				.backlink:hover{opacity:1;}
				.g{
				color:#339900;
				}
				.b{
				color:#0099CC;
				}
				.r{
				color:#CC0000;
				}
				.button{padding:4px 10px 4px 10px;background-color:#FFF;color:#222;-moz-border-radius:5px;}
				.mails {display:none;}
	";

?><?php


// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	
// <!-- =============================== -->
// <!-- = FILE:  AJAX FILE UPLOAD PHP = -->
// <!-- =============================== -->
	
	error_reporting(E_ALL ^ E_NOTICE);
	
	$error = "";
	$msg = "";
	$fileElementName = 'fileToUpload';
	
	// continue if there's file upload posted
	if(!empty($_FILES[$fileElementName]['error']) || !empty($_FILES[$fileElementName]['tmp_name'])) {
	
		if(!empty($_FILES[$fileElementName]['error']))
		{
			switch($_FILES[$fileElementName]['error'])
			{
	
				case '1':
					$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
					break;
				case '2':
					$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
					break;
				case '3':
					$error = 'The uploaded file was only partially uploaded';
					break;
				case '4':
					$error = 'No file was uploaded.';
					break;
	
				case '6':
					$error = 'Missing a temporary folder';
					break;
				case '7':
					$error = 'Failed to write file to disk';
					break;
				case '8':
					$error = 'File upload stopped by extension';
					break;
				case '999':
				default:
					$error = 'No error code avaiable';
			}
		}
		  else if (empty($_FILES['fileToUpload']['tmp_name']) || $_FILES['fileToUpload']['tmp_name'] == 'none')
		{
			$error = 'No file was uploaded..';
		}
		else
		{
	
		  $file=$_FILES['fileToUpload']['name'];
		  $tempfile=$_FILES['fileToUpload']['tmp_name'];
	
		  move_uploaded_file($tempfile, $dir.$file );
	
		  $msg .= " File Name: " . $_FILES['fileToUpload']['name'];
		  $msg .= " File Size: " . @filesize($_FILES['fileToUpload']['tmp_name']);
	
	   }
	
		echo "{";
		echo                "error: '" . $error . "',\n";
		echo                "file: '" . $file . "',\n";
		echo                "msg: '" . $msg . "'\n";
		echo "}";
		
		// stop output here
		exit();
	
	}
?><?php

// <!-- ======================= -->
// <!-- = PASSWORD PROTECTION = -->
// <!-- ======================= -->

if ($password_protection == true) {
	
	session_name($session_name);
	session_start();
	
	// if (isset($_SESSION['last_ts'])) {$_SESSION['last_ts'];}
		
	if (!isset($_SESSION['last_ts']) && !isset($_POST['login'])) {
		
		// LOGIN FORM 
		
		echo '
		<body style="background:url(images/background.png) repeat-x;">
		<div style="position:fixed;top:35%;left:35%;width:50%">
		<form action="index.php" method="post" accept-charset="utf-8">
			<img src="images/logo.png" alt="logo" id="logo" name="logo" align="left" />
			<br /><h1 style="font-family: arial, verdana;font-size:30px;color:#222;margin:0;display:inline;">Newsletter module </h1> <small> pre 0.9</small><br />
			<br /><input type="password" name="login" id="login" style="padding:5px;display:inline;" />
			<input type="submit" style="background-color:#f30;color:#fff;border:0;padding:5px;-moz-border-radius:3px;" value="Login">
		</form>
		</div>
		</body>
		';
		exit(); 

	}

	if ($_POST['login'] && sha1($_POST['login'])==$password_hash) {

		$_SESSION['auth'] = substr(md5(microtime(true).mt_rand()), 0, 16);
		$_SESSION['last_ts'] = time();
		// to destroy the post variable
		header('Location: index.php');
	
	}
	
	if ($_POST['login'] && sha1($_POST['login'])!=$password_hash) {
		header('Location: index.php?info=invalidlogin');    
	}
	
	else if ((time() - $_SESSION['last_ts'] > $session_timeout) || isset($_GET['logout'])) {
		session_destroy();
		header('Location: index.php');
	}
	
	else if ((time() - $_SESSION['last_ts'] < $session_timeout)) {
		$_SESSION['last_ts'] = time();
	}
	
	
}
?><?php
	
	//make connection
	$server = mysql_connect($host, $user, $password);
	$connection = mysql_select_db($database, $server);

	// CUSTOM SQL FUNCTIONS
	function sql_quote($value) {
	if (get_magic_quotes_gpc()) {
		$value = stripslashes($value);
	}
	if (!is_numeric($value)) {
		$value = "'" . mysql_real_escape_string($value) . "'";
	} else {
		if ((string)$value[0] == '0') {
			$value = "'" . mysql_real_escape_string($value) . "'";
	}}
	return $value;
	}
	function sql_lastinsertid() {
		$result = mysql_query("SELECT LAST_INSERT_ID()");
		$row = mysql_fetch_row($result);
		return $row[0];
	}
	function sql_getfield($table, $field, $where_cond = "") {
		$q = "SELECT ".$field." FROM ".$table." ".$where_cond;
		$r = mysql_query($q);
		$row = mysql_fetch_row($r);
		return $row[0];
	}
	
?><?php

// <!-- ========================= -->
// <!-- = FILE: AJAX PROCESSING = -->
// <!-- ========================= -->

	// Setup
	$error='';
	
	// DELETE E-MAILS
	
	if ($_POST['action']=='delmail') {
	
		  $count = 0;
		  $category = $_POST["cat"];
		  $emails = $_POST["emails"];
		  if (!empty($emails)) {
	
			  $email = explode("|",$emails);
			  foreach ($email as $value) {
	
				  if (!empty($value) && sql_getfield('emails','id','WHERE id = '.sql_quote($value))) {
					  $q = "DELETE from emails WHERE id = ".sql_quote($value)." LIMIT 1";
					  mysql_query($q);
					  $count+=1;
				  }
			  }
		  }
		  else {
			$error = 'No emails are selected !';
		  }
	
		  echo "{";
		  echo "error: '" . $error . "',\n";
		  echo "count: '" . $count . "'\n";
		  echo "}";
		  
		  exit();
	
	}
	
	// ***
	
	// DELETE CATEGORY

	if ($_POST['action']=='delcat') {
	
		  $kategorie = $_POST["categories"];
		  if (!empty($kategorie)) {
	
			  $category = explode("|",$kategorie);
			  foreach ($category as $value) {
				  if (!empty($value) && sql_getfield('categories','name','WHERE id = '.sql_quote($value))) {
	
					  $q = "DELETE from categories WHERE id = ".sql_quote($value)." LIMIT 1";
					  mysql_query($q);
	
				  }
			  }
		  }
		  else {
			$error = 'Nie sú označené žiadne kategórie !';
		  }
	
		  echo "{";
		echo "error: '" . $error . "'\n";
		echo "}";
		
		exit();
	
	}
	
	// ***
	
	
	// RENAME CATEGORY
	
	if ($_POST['action']=='rncat') {
	
		  $category = $_POST["category"];
		  $newname = $_POST["newname"];
	
		  if (!empty($category) && !empty($newname) && sql_getfield('categories','name','WHERE id = '.sql_quote($category)) ) {
			  $q = "UPDATE categories SET name = ".sql_quote($newname)." WHERE id = ".sql_quote($category)." LIMIT 1";
			  mysql_query($q);
		  }
		  else {
	
			  $error = 'Chyba pri premenovaní !';
	
		  }
	
		  echo "{";
		  echo "error: '" . $error . "'\n";
		  echo "}";
		  
		  exit();
	
	}
	
	// ***
	
	
	
	// NEW EMAIL
	
	if ($_POST['action']=='newemail') {
	
			$category = $_POST["cat"];
			$emails = $_POST["emails"];
			$append ='';
	
			if (!empty($emails)) {
	
			  $emails = str_replace('"',"",$emails);
			  $emails = str_replace(','," ",$emails);
			  $emails = str_replace(';'," ",$emails);
			  $emails = str_replace('<'," ",$emails);
			  $emails = str_replace('>'," ",$emails);
			  $emails = str_replace("\n"," ",$emails);
			  $emails = str_replace("\t"," ",$emails);
			  $emails = str_replace("\r"," ",$emails);
			  $emails = str_replace("\0"," ",$emails);
			  
			  $email = explode(" ",$emails);
	
			  foreach ($email as $value) {
	
				if (stristr($value,'@') && !sql_getfield('emails','email','WHERE email = '.sql_quote($value).' AND category = '.sql_quote($category))) {
	
				  $q = "INSERT into emails (category,email) VALUES (".sql_quote($category).",".sql_quote($value).")";
				  if (!mysql_query($q)) {
					$error = 'ERR';
				  }
				  else  {
					$id = sql_lastinsertid();
					$append.= '<div><input value="'.$id.'" id="'.$id.'" name="'.$id.'" type="checkbox" /> '.$value.'</div>';
					
				}
			  }
			}
			}
			else {
			  $error = 'Zadajte emailové adresy';
			}
	
		  echo "{";
		  echo              "error: '" . $error . "',\n";
		  echo              "toappend: '" . $append . "'\n";
		  echo "}";
		  
		  exit();
	
	}
	// ***
	
	
	
	// NEW CATEGORY
	
	if ($_POST['action']=='newcategory') {
	
		  $newcat = $_POST["catname"];
		  if (!empty($newcat)) {
	
			$q = "INSERT into categories (name) VALUES (".sql_quote($newcat).")";
			$result = mysql_query($q);
			if (!$result) {
			  $error = 'ERR';
			}
			else {
			  $name = $newcat;
			  $id = sql_lastinsertid();
			}
		  } else {
			$error = "Please, enter the name !";
		  }
	
		  echo "{";
		  echo              "error: '" . $error . "',\n";
		  echo              "name: '" . $name . "',\n";
		  echo              "id: '" . $id . "'\n";
		  echo "}";
		  
		  exit();
	
	}
	// ***
	
	
	// SENDMAIL
	
	if ($_POST['action']=='sendmail') {
		
		if ($use_template == false ) { $template_top = ''; $template_bottom = '';}
	
		  $emails = $_POST['adresses'];
		  $body = $_POST['ebody'];
		  $subject = $_POST['subject'];
		  $message = str_replace("\n","<br />",$body);
	
		  /* ERRORS */
		  if ($message == '') {$error = 'Vyplňte obsah e-mailu !';}
		  if ($subject == '') {$error = 'Vyplňte predmet e-mailu !';}
		  if (empty($emails)) {$error = 'Nebol definovaný žiaden príjemca ! ';}
	
		if (!empty($emails) && empty($error)) {
	
			/* ZAPIS DO ODOSLANÝCH NEWSLETTROV */
	
				$q = "INSERT INTO sent_mails (time, subject, body, attachment) VALUES (
				".sql_quote(time()).",
				".sql_quote($subject).",
				".sql_quote($message).",
				".sql_quote($_POST["attachment"]).")";
				mysql_query($q);
	
			$from = "$your_name <$your_email>";
			
			if (!empty($_POST["attachment"])) {
	
				  $suffix  =strtolower(substr($dir.$_POST["attachment"], -3));
					  switch($suffix) {
						case 'gif': $typ = "image/gif"; break;
						case 'jpg': $typ = "image/jpg"; break;
						case 'peg': $typ = "image/jpeg";break;
						case 'png': $typ = "image/png"; break;
						case 'pdf': $typ = "application/pdf"; break;
						case 'zip': $typ = "application/zip"; break;
					  }
				  
				  $subject = $_POST['subject'];
	
				  $fileatt = $dir.$_POST["attachment"];
				  $fileatttype = $typ;
				  $fileattname = $_POST["attachment"];
	
				  $headers = "From: $from";
	
				  $file = fopen( $fileatt, 'rb' );
				  $data = fread( $file, filesize( $fileatt ) );
				  fclose( $file );
	
				  $semi_rand = md5( time() );
				  $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
	
				  $headers .= "\nMIME-Version: 1.0\n" .
							  "Content-Type: multipart/mixed;\n" .
							  " boundary=\"{$mime_boundary}\"";
	
				  $message = "This is a multi-part message in MIME format.\n\n" .
						  "--{$mime_boundary}\n" .
						  "Content-Type: text/html; charset=\"utf-8\"\n" .
						  "Content-Transfer-Encoding: 7bit\n\n" .
						  $template_top.$message.$template_bottom . "\n\n";
	
				  $data = chunk_split( base64_encode( $data ) );
	
				  $message .= "--{$mime_boundary}\n" .
						   "Content-Type: {$fileatttype};\n" .
						   " name=\"{$fileattname}\"\n" .
						   "Content-Disposition: attachment;\n" .
						   " filename=\"{$fileattname}\"\n" .
						   "Content-Transfer-Encoding: base64\n\n" .
						   $data . "\n\n" .
						   "--{$mime_boundary}--\n";
	
		  }
		  else
		  {
	
				  $subject = $subject." \n";
	
				  /* HEADERS */
	
					$headers = "MIME-Version: 1.0\n";
					$headers .= "Content-Type: text/html; charset=\"utf-8\"\n";
					$headers .= "Content-Transfer-Encoding: 7bit \n";
					$headers .= "From: ".$from." \n";
					$headers .= "Return-Path: ".$from." \n";
					$headers .= "X-Mailer: PHP/" . phpversion();
	
					$message = $template_top.$message.$template_bottom;
	
		  }
	
			if ($_POST['sendto']=='emails') {
		    	$email = explode(',',$emails);
	    	}
	    	else if ($_POST['sendto']=='categories') {
		
	    		$query = "SELECT * from emails WHERE category IN (".$emails.")";
	    		$select = mysql_query($query);
	    		while ($mail_row = mysql_fetch_assoc($select)) {
	    			$email[] = $mail_row['id'];
	    		}
	    	}

			/* ADMIN CHECK */
			if ($mailcheck == true && !in_array($your_email,$email )) {
				$email[] = $your_email;
			}
			
			foreach ($email as $value) {
			  
				mail(sql_getfield('emails','email','WHERE id = '.sql_quote($value)), $subject, $message, $headers);
				$count+=1;
			
			}
	
		  }
	
			  echo "{";
			  echo "error: '" . $error . "',\n";
			  echo "count: '" . $count . "'\n";
			  echo "}";
	
		exit();
			  
	}
	
	// ***
	
?><?php
// <!-- ======================= -->
// <!-- = FILE: MAIN PHP FILE = -->
// <!-- ======================= -->
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="expires" content="mon, 22 jul 2002 11:12:01 gmt" />
		<title>
			Newsletter module
		</title>
		
		<!-- ================== -->
		<!-- = FILE: CSS FILE = -->
		<!-- ================== -->

	<style type="text/css" media="screen">
	/*<![CDATA[*/
			
			/* HERE GOES YOUR CUSTOM CSS */
			
			<?php echo $css; ?>
	
			/* THIS PART OF CSS SHOULD STAY UNTOUCHED TO PRESERVE ORIGINAL LAYOUT 
			   BUT - FEEL FREE TO CHANGE IT IF YOU KNOW WHAT YOU'RE DOING          */
			
			body {
				cursor:default;
			}

			h1, h2, h3, h4 {
				margin:0;
				padding:0;
			}
			#logo {vertical-align:middle;cursor:pointer;}
			a {
				cursor:pointer;
			}
			a:hover{
				text-decoration:underline;
			}
			input[type=password],input[type=text],textarea {
				padding:3px;
			}
			#categories{
				padding:10px;
			}
			.tiny {
				font-size:xx-small;color:#222;
				text-decoration:none;
				border:none;
			}
			.sign {
				font-size:xx-large;
				vertical-align:absmiddle;
				text-align:center;
				font-size:xx-large;
				display:inline;
				width:20px;
			}
			#processing {
				display:none;
				position:fixed;
				top:45%;
				left:45%;
				padding:10px 20px 10px 20px;
				margin:0 auto;
				text-align:center;
			}
			#filename {
				background:transparent;border:0;
			}
	/*]]>*/
	</style>
	</head>
	<body>
		<!-- = PHP ARRAYS = -->
		<?php
			
				// LOAD DATA INTO ARRAYS
				$result = mysql_query("SELECT * from categories");
				while ($row = mysql_fetch_assoc($result)) {
					
					$emails_result = mysql_query("SELECT * from emails WHERE category = ".$row['id']);
					while ($subrow = mysql_fetch_assoc($emails_result)) {
						
						$row['emails'][] = $subrow;
					
					}
					mysql_free_result($emails_result);
					$categories[] = $row;
				}
				mysql_free_result($result);
				
				$result = mysql_query("SELECT * from sent_mails");
				while ($row = mysql_fetch_assoc($result)) {
				
					$sent[] = $row;
				}
				mysql_free_result($result);
			?><!-- LOADING INDICATOR -->
		<div id="processing">
			<img src="images/ajax-loader.gif" alt="loading" style="vertical-align:middle;margin-right:10px;" /> PROCESSING
		</div>
		<div style="clear:both;margin:0 auto;width:1000px;margin-top:60px;">
			<!-- HEADER / SUBHEADER -->
			<img src="images/logo.png" alt="logo" id="logo" onclick="$('.maincontainers').hide(300);$('#newsletter').show(300)" />
			<h1>
				Newsletter module
			</h1><small onclick="top.location.href='http://virae.org/webdesign'">pre 0.9</small><br />
			<br />
			<div style="position:fixed;bottom:5%;right:3%;">
			<a class="button" id="sent_mails_link" onclick="$('.maincontainers').hide(200);$('#sent_mails').show(200);" name="sent_mails_link">SENT E-MAILS</a>
			<?php if ($password_protection==true): ?>
			 | <a class="button" id="logout" onclick="top.location.href='?logout=true'">LOGOUT</a><br />
			<?php endif ?>
			</div>
			<br />
			<div id="newsletter" class="maincontainers" style="clear:both;">
				<!-- CATEFORIES CONTAINER -->
				<div id="categories_container" style="width:200px;float:left;margin-right:20px;">
					<h2>
						CATEGORIES
					</h2><br />
					<br />
					<div id="categories">
						<?php 
											if (isset($categories) && is_array($categories)) {
											foreach ($categories as $key => $value) {
												
												echo '
												<div id="cat_'.$value['id'].'">
													<input type="checkbox" value="'.$value['id'].'" />
													<h3 style="cursor:pointer;" onclick="adr_show(\'category_'.$value['id'].'\');">
														'.$value['name'].'
													</h3>
												</div>';
																	
											}
											}
											?>
					</div><br />
					<br />
					<br />
					<!-- operations with categories -->
					 <a onclick="$('#newcategory').slideToggle(200)" class="tiny">ADD CATEGORY</a><br />
					<a onclick="delcat();" class="tiny">DELETE SELECTED</a><br />
					<a onclick="rncat();" class="tiny">RENAME CATEGORY</a><br />
					<div id="newcategory" style="text-align:left;display:none;">
						<br />
						<small>Create category with name:</small><br />
						<br />
						<input type="text" maxlength="40" id="newcategoryname" style="width:135px;border:1px solid #222;" /> <a onclick="newcategory()" class="tiny">OK</a><br />
					</div>
				</div><!-- EMAILS CONTAINER -->
				<div id="emails_container" style="float:left;">
					<?php 
										
										if (isset($categories) && is_array($categories)) {  
										foreach ($categories as $key => $value) {
											
										echo '
										<div id="category_'.$value['id'].'" class="mails">
											<h2 class="h2emails">E-MAILS</h2><br />
											
											<div id="category_'.$value['id'].'_emails"><br />
						
												<a style="font-size:small;margin-top:15px;" onclick="selectAll(\'category_'.$value['id'].'\',true);" ><small class="tiny">Select all</small></a> |
												<a style="font-size:small;margin-top:15px;" onclick="selectAll(\'category_'.$value['id'].'\',false);" ><small class="tiny">Select none</small></a><br /><br />';
											
												if (isset($value['emails'])) {
													
													foreach ($value['emails'] as $subkey => $subvalue) {

														// EMAILS ARE PROTECTED BY ROT13 ENCRYPTION
														
														echo '
															<div><input type="checkbox" name="'.$subvalue['id'].'" value="'.$subvalue['id'].'" />
															<script type="text/javascript">
															<!--
																document.write("'.str_rot13($subvalue['email']).'".replace(/[a-zA-Z]/g, function(c){return String.fromCharCode((c<="Z"?90:122)>=(c=c.charCodeAt(0)+13)?c:c-26);})); 
															-->
															</script>
															<br /></div>';
													}
												}
												else {
													
													echo '<span id="no_mails_'.$value['id'].'">No emails</span><br />';
													
												}
											
												echo '
											
											</div>
											
											<br />___<br /><br />
											
										<!-- operations with emails -->
											
											<a onclick="$(\'#new_emails_'.$value['id'].'\').slideToggle(200)" class="tiny"><font class="sign g">&bull;</font> ADD E-MAILS</a>&nbsp;&nbsp;
											<a onclick="delmail(\''.$value['id'].'\');" class="tiny"><font class="sign r">-</font> DELTE SELECTED</a>&nbsp;&nbsp;
																
											<div id="new_emails_'.$value['id'].'" align="left" style="display:none;padding:15px;">
												enter e-mails to add:<br /><br />
												<textarea id="to_add_'.$value['id'].'" cols="30" rows="4" style="font-size:small;border:1px solid #222;"></textarea>&nbsp;&nbsp;
												<a class="tiny" onclick="add_mails(\''.$value['id'].'\')">OK</a><br />
											</div>
											
										</div>';
										}
									}                        
								?>
				</div>
				<div style="float:right;">
					<img src="images/send.gif" onclick="$('#newsletter').hide(350);$('#mailform').show(350);serializeSelection();" alt="next" style="cursor:pointer;" />
				</div>
			</div><!-- NEXT PAGE - E-MAIL FORM -->
			<div id="mailform" class="maincontainers" style="display:none;float:left;">
				<h2>
					WRITE YOUR MESSAGE
				</h2>
				<div>
					<div style="float:left;padding:20px;border:1px dotted #ddd;">
						<br />
						<h3>
							SUBJECT
						</h3><br />
						<br />
						<input type="text" id="subject" style="width:400px;" /><br />
						<br />
						<h3>
							MESSAGE
						</h3><br />
						<br />
						<textarea id="emailbody" name="emailbody" cols="40" onfocus="if (this.value=='Write your message here ...') this.value='';" rows="8" style="width:400px;">Write your message here ...</textarea><br />
						<br />
						<input type="file" name="fileToUpload" id="fileToUpload" onchange="return ajaxFileUpload();" /> <input type="text" readonly="readonly" id="filename" style="color:#83B440;font-weight:bold;" value="" /><br />
						<br />
					</div>
					<div style="float:right;width:500px;text-align:center;padding-top:120px;">
						<a class="backlink"><img onclick="sendmail();" src="images/go.png" alt="send!" /></a><br />
						<br />
						<span id="info_msg" class="tiny"></span>
					</div>
				</div><br style="clear:both" />
				<br />
				<a class="backlink" onclick="$('#newsletter').show(350);$('#mailform').hide(350)"><img src="images/back.gif" alt="go back" /></a>
			</div>
			<div id="sent_mails" class="maincontainers" style="display:none;float:left;">
				<h2>
					SENT E-MAILS
				</h2>
				<div>
					<div style="float:left;padding:20px;border:0px dotted #ddd;">
						<?php 
										
										foreach ($sent as $key => $value) {
											echo '<h3>'.$value['subject'].'</h3><br />';
											echo '<small>'.$value['body'].'</small><br />';
											echo '<small style="color:#ccc;">'.date('d.m.Y',$value['time']).'</small>';
											if(isset($value['attachment'])) {
												
												echo '&nbsp;&nbsp;<a style="color:#f30;text-decoration:none;" href="'.$dir.$value['attachment'].'" target="_blank"><small style="color:#f30;text-decoration:none;">'.$value['attachment'].'</small><br /></a>';
												
											}
											echo '<br /><br />';
										}
										
										?>
					</div>
				</div><br style="clear:both" />
				<br />
				<a class="backlink" onclick="$('.maincontainers').hide();$('#sent_mails_link').show(50);$('#newsletter').show(350);$('#mailform').hide(350)"><img src="images/back.gif" alt="go back" /></a>
			</div>
		</div><!-- JQUERY -->
		<p>
			
			<script type="text/javascript" src="<?php echo $jquery_src; ?>"></script>  
		

	<!-- =========================== -->
	<!-- = FILE: AJAXFILEUPLOAD.JS = -->
	<!-- =========================== -->

			
			<script type="text/javascript" charset="utf-8">
<!--
//<![CDATA[
		
		jQuery.extend({
		
			createUploadIframe: function(id, uri)
			{
					//create frame
					var frameId = 'jUploadFrame' + id;
					
					if(window.ActiveXObject) {
						var io = document.createElement('<iframe id="' + frameId + '" name="' + frameId + '" />');
						if(typeof uri== 'boolean'){
							io.src = 'javascript:false';
						}
						else if(typeof uri== 'string'){
							io.src = uri;
						}
					}
					else {
						var io = document.createElement('iframe');
						io.id = frameId;
						io.name = frameId;
					}
					io.style.position = 'absolute';
					io.style.top = '-1000px';
					io.style.left = '-1000px';
		
					document.body.appendChild(io);
		
					return io           
			},
			createUploadForm: function(id, fileElementId)
			{
				//create form   
				var formId = 'jUploadForm' + id;
				var fileId = 'jUploadFile' + id;
				var form = $('<form  action="" method="POST" name="' + formId + '" id="' + formId + '" enctype="multipart/form-data"><\/form>'); 
				var oldElement = $('#' + fileElementId);
				var newElement = $(oldElement).clone();
				$(oldElement).attr('id', fileId);
				$(oldElement).before(newElement);
				$(oldElement).appendTo(form);
				//set attributes
				$(form).css('position', 'absolute');
				$(form).css('top', '-1200px');
				$(form).css('left', '-1200px');
				$(form).appendTo('body');       
				return form;
			},
		
			ajaxFileUpload: function(s) {
				// TODO introduce global settings, allowing the client to modify them for all requests, not only timeout        
				s = jQuery.extend({}, jQuery.ajaxSettings, s);
				var id = new Date().getTime()        
				var form = jQuery.createUploadForm(id, s.fileElementId);
				var io = jQuery.createUploadIframe(id, s.secureuri);
				var frameId = 'jUploadFrame' + id;
				var formId = 'jUploadForm' + id;        
				// Watch for a new set of requests
				if ( s.global && ! jQuery.active++ )
				{
					jQuery.event.trigger( "ajaxStart" );
				}            
				var requestDone = false;
				// Create the request object
				var xml = {}   
				if ( s.global )
					jQuery.event.trigger("ajaxSend", [xml, s]);
				// Wait for a response to come back
				var uploadCallback = function(isTimeout)
				{           
					var io = document.getElementById(frameId);
					try 
					{               
						if(io.contentWindow)
						{
							 xml.responseText = io.contentWindow.document.body?io.contentWindow.document.body.innerHTML:null;
							 xml.responseXML = io.contentWindow.document.XMLDocument?io.contentWindow.document.XMLDocument:io.contentWindow.document;
							 
						}else if(io.contentDocument)
						{
							 xml.responseText = io.contentDocument.document.body?io.contentDocument.document.body.innerHTML:null;
							xml.responseXML = io.contentDocument.document.XMLDocument?io.contentDocument.document.XMLDocument:io.contentDocument.document;
						}                       
					}catch(e)
					{
						jQuery.handleError(s, xml, null, e);
					}
					if ( xml || isTimeout == "timeout") 
					{               
						requestDone = true;
						var status;
						try {
							status = isTimeout != "timeout" ? "success" : "error";
							// Make sure that the request was successful or notmodified
							if ( status != "error" )
							{
								// process the data (runs the xml through httpData regardless of callback)
								var data = jQuery.uploadHttpData( xml, s.dataType );    
								// If a local callback was specified, fire it and pass it the data
								if ( s.success )
									s.success( data, status );
			
								// Fire the global callback
								if( s.global )
									jQuery.event.trigger( "ajaxSuccess", [xml, s] );
							} else
								jQuery.handleError(s, xml, status);
						} catch(e) 
						{
							status = "error";
							jQuery.handleError(s, xml, status, e);
						}
		
						// The request was completed
						if( s.global )
							jQuery.event.trigger( "ajaxComplete", [xml, s] );
		
						// Handle the global AJAX counter
						if ( s.global && ! -jQuery.active )
						
							jQuery.event.trigger( "ajaxStop" );
		
						// Process result
						if ( s.complete )
							s.complete(xml, status);
		
						jQuery(io).unbind()
		
						setTimeout(function()
											{   try 
												{
													$(io).remove();
													$(form).remove();   
													
												} catch(e) 
												{
													jQuery.handleError(s, xml, null, e);
												}                                   
		
											}, 100)
		
						xml = null
		
					}
				}
				// Timeout checker
				if ( s.timeout > 0 ) 
				{
					setTimeout(function(){
						// Check to see if the request is still happening
						if( !requestDone ) uploadCallback( "timeout" );
					}, s.timeout);
				}
				try 
				{
				   // var io = $('#' + frameId);
					var form = $('#' + formId);
					$(form).attr('action', s.url);
					$(form).attr('method', 'POST');
					$(form).attr('target', frameId);
					if(form.encoding)
					{
						form.encoding = 'multipart/form-data';              
					}
					else
					{               
						form.enctype = 'multipart/form-data';
					}           
					$(form).submit();
		
				} catch(e) 
				{           
					jQuery.handleError(s, xml, null, e);
				}
				if(window.attachEvent){
					document.getElementById(frameId).attachEvent('onload', uploadCallback);
				}
				else{
					document.getElementById(frameId).addEventListener('load', uploadCallback, false);
				}       
				return {abort: function () {}}; 
		
			},
		
			uploadHttpData: function( r, type ) {
				var data = !type;
				data = type == "xml" || data ? r.responseXML : r.responseText;
				// If the type is "script", eval it in global context
				if ( type == "script" )
					jQuery.globalEval( data );
				// Get the JavaScript object, if JSON is used.
				if ( type == "json" )
					eval( "data = " + data );
				// evaluate scripts within html
				if ( type == "html" )
					jQuery("<div>").html(data).evalScripts();
					//alert($('param', data).each(function(){alert($(this).attr('value'));}));
				return data;
			}
		});
		
		function ajaxFileUpload()
		{
			//starting setting some animation when the ajax starts and completes

			// IMPORTANT DOM REFERENCE VALUE //

			$("#processing")
			.ajaxStart(function(){
				$(this).show();
			})
			.ajaxComplete(function(){
				$(this).hide();
			});
		
			$.ajaxFileUpload
			(
				{

			// !!!!!!!!!!!!!!!!//
			// IMPORTANT VALUE //
			// !!!!!!!!!!!!!!!!//

					url:'index.php',
					secureuri:false,
					fileElementId:'fileToUpload',
					dataType: 'json',
					success: function (data, status)
					{
						if(typeof(data.error) != 'undefined')
						{
							if(data.error != '')
							{
								alert(data.error);
							}else
							{
		
								$('#filename').val(data.file);
		
							}
						}
					},
					error: function (data, status, e)
					{
						alert(e);
					}
				}
			)
		return false;
		}       
//]]>
-->
</script>

	<!-- ============= -->
	<!-- = FUNCTIONS = -->
	<!-- ============= -->
	
			<script type="text/javascript">
<!--
//<![CDATA[	

	var emails = new Array() ;
	var adresses = new Array() ;
	var sendto = '';

	// display e-mails of selected category
	function adr_show(adr_id) {
		$('.mails').hide();
		$('#emails_container :checkbox').attr('checked','');
		$('#'+adr_id).fadeIn(500);
	}
	
	// toggle checkboxes
	function selectAll(id,state) {
		$( "#" + id + "_emails :checkbox").attr('checked', state);
	}
	
	// serialize selected emails
	function serializeSelection() {
		
		var categories = new Array() ;
		$( "#categories_container :checkbox:checked").each(function(){
			categories.push($(this).val());
		});
		
		if (categories.length < 1) {
		
			$( "#emails_container :checkbox:checked").each(function(){
					emails.push($(this).val());
			});
			
			if (emails.length > 0) {
				$('#info_msg').text('Email will be sent to '+(emails.length)+' selected emails');
				adresses = emails.join(",");
				sendto = 'emails';
			}
			else {
				$('#info_msg').text('No recipients are selected !');
				sendto = '';
			}
		
		}
		else {
			$('#info_msg').text('Email will be sent to '+(categories.length)+' selected categories');
			sendto = 'categories';
			adresses = categories.join(",");
		}
	}
	
	/* //////////////////////////////////////  ADD EMAILS */
	function add_mails(id) {
	
		// load new e-mails as string
		var newmails = $('#to_add_'+id).val();
	
		if (newmails) {
		
			$('#processing').fadeIn(500);
			
			$.post("index.php", {
				action: 'newemail', cat: id, emails: newmails }, function(response){
				// alert(response);
				var response = eval('(' + response + ')');
				// error
				if (response.error != '') {alert(response.error);}
				// else append new e-mails
				else {
					  
					$("#category_"+id+"_emails").append(response.toappend);    
					$('#new_emails_'+id).slideToggle();
					$('#no_mails_'+id).hide();
					$('#to_add_'+id).val('');
					
				}
			});
			
			$('#processing').fadeOut(800);
		}
		else {
			alert('Please write e-mails to add.');
		}
	}
	// ***
	
	/* ////////////////////////////////////// DELETE EMAILS */
	function delmail(id) {
		var emails_to_del = "", count = 0, word;
		
		// load checked emails to string separated by | and count them
		$( "#category_" + id + " :checkbox:checked").each(function() {
			emails_to_del+=$(this).val()+"|";
			count+=1;
		});
	
		// CHECK IF ANY MAILS ARE SELECTED AND CONSTRUT THE QUESTION
		if (count == 0) { alert('No emails are selected'); return false;}
		if (count == 1) { word = 'selected e-mail ?'; count = ''}
		if (count > 1) { word = 'selected e-mails ?';}
	
		if (confirm('Do your really want to remove '+count+' '+word) ) {
	
			// show processing dialog
			$('#processing').fadeIn(500);
	
			$.post("index.php", {
				action: 'delmail', cat: id, emails: emails_to_del }, function(response){
				var response = eval('(' + response + ')');
				// error
				if (response.error != '') {alert(response.error);}
				// else remove checked e-mails
				else {
					$( "#category_" + id + "_emails :checkbox:checked").parent().each(function(){
						$(this).remove();
					})
				}

			$('#processing').fadeOut(500);
	
			});
		}
	}
	// ***
	
	/* //////////////////////////////////////  CREATE CATEGORY */
	function newcategory() {
		if ($("#newcategoryname").val()!='') {
		$.post("index.php", {
			action: 'newcategory', catname: $("#newcategoryname").val() }, function(response){
				var response = eval('(' + response + ')');
				// error
				if (response.error != '') {alert(response.error);}
				// else reload page
				else { window.location.reload(); }
			});
		}
		else {
			alert ('Please select a name !');
		}
		}
	// ***
	
	/* ////////////////////////////////////// RENAME CATEGORIES */
	function rncat() {
	
		var cat_to_rn = "", count = 0;
	
		$("#categories :checkbox:checked").each(function() {
			cat_to_rn+=$(this).val();
			count+=1;
		});
	
		if (count >= 2 ) {alert('Select one category only !'); return false;}
		if (count == 0 ) {alert('Select desired category !'); return false;}
		var newname = prompt('Zadajte nové meno:');
		
		if (newname) {
	
			$.post("index.php", {
				action: 'rncat', category: cat_to_rn, newname: newname }, function(response){
					var response = eval('(' + response + ')');
					// error
					if (response.error != '') {alert(response.error);}
					// else reload page
					else {history.go(0);}
			});
		}
	}
	// ***
	
	/* ////////////////////////////////////// DELETE CATEGORIES */
	function delcat() {
	
		var catz_to_del = "", count = 0, word;
	
		$("#categories :checkbox:checked").each(function() {
			catz_to_del+=$(this).val()+"|";
			count+=1;
		});
	
		// construct a question
		if (count == 0) { alert('Select desired category');return false;}
		if (count == 1) { word = 'selected category ?'; count = ''}
		if (count > 1 ) { word = 'selected categories ?';}
	
		if (confirm('Do you really want to delete '+word) ) {
	
			$.post("index.php", {
	
				action: 'delcat', categories: catz_to_del }, function(response){
				var response = eval('(' + response + ')');
				// error
				if (response.error != '') {alert(response.error);}
				// if no errors, remove checked categories
				else {
					$( "#categories :checkbox:checked").parent().each(function(){$(this).remove();})
				}
			});
		}
	}
	// ***
	
	/* ////////////////////////////////////// DELETE CATEGORIES */
	function sendmail() {
	  $('#processing').fadeIn(500);
	  $.post("index.php", {
			  action: 'sendmail', sendto: sendto, attachment: $('#filename').val(), subject: $('#subject').val(), ebody: $('#emailbody').val(), adresses: adresses }, function(response){

				var response = eval('(' + response + ')');
				if (response.error != '') {alert(response.error);}
				else {
				  var previoushtml = $('#processing').html();
				  //$('#processing').html('<span>Mails sent: '+response.count+'<\/span>');
				}
			  }
		);
	  setTimeout("$('#processing').fadeOut(1000)",2500);
	}   
	// ***
	
	// DOC READY
	$(document).ready(function() {
		// hide processing div
			$('#processing').hide();
		// hide all e-mail divs
			$('.mails').hide();
		// show the first div
			$('#category_<?php echo $categories[0]['id'];?>').show();
	});
//]]>
-->
</script><!-- CLOSE DB CONNECTION -->
			<?php mysql_close($server); ?>
		</p>
	</body>
</html>
