<?php define("TO_ROOT", "../..");  require_once TO_ROOT . "/core/includes/main.inc.php";    $Page = new Page("Admin", "admin_user_roles");    /* ---------------- <<<< Assert User Permissions >>>> ---------------------------------------------------------------------*/  /** *  if(!System::__assertLoginType($_SESSION["login_type"]) && !System::__hasPermission("user_roles", "view_roles"))  {  	System::__sessionDestroy();  	$Page->setOnReady("__showMessage","{'message':'Sorry you dont have permission','options':{'OK':function(){__goToPage('index.php')}}}");  	$Page->goToPage();  }  /* ---------------- <<<< End Assert User Permissions >>>> ----------------------------------------------------------------*/      /* ---------------- <<<< Set Menus >>>> --------------------------------------------------------------------------------*/  $Page->setSecondaryMenu("admin_user_roles");  /* ---------------- <<<< End Set Menus >>>> ----------------------------------------------------------------------------*/      $Page->display();