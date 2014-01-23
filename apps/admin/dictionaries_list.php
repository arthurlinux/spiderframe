<?php define("TO_ROOT", "../..");  
  
  require_once TO_ROOT . "/core/includes/main.inc.php";

  $Page = new Page("Dictionaries", "dictionaries_list");

  /* ---------------- <<<< Assert User Permissions >>>> ---------------------------------------------------------------------*/
  /** *
  if(!System::__assertLoginType($_SESSION["login_type"]) && !System::__hasPermission("user", "add_user"))
  {
  	System::__sessionDestroy();
  	$Page->setOnReady("__showMessage","{'message':'Sorry you dont have permission','options':{'OK':function(){__goToPage('index.php')}}}");
  	$Page->goToPage();
  }
  /* ---------------- <<<< End Assert User Permissions >>>> ----------------------------------------------------------------*/
  
  /* ---------------- <<<< Set Menus >>>> --------------------------------------------------------------------------------*/
  $Page->setSecondaryMenu("admin_dictionaries");
  /* ---------------- <<<< End Set Menus >>>> ----------------------------------------------------------------------------*/
  
  
  /* ---------------- <<<< Configure CSS Theme >>>> ----------------------------------------------------------------------*/
  $Page->addCssLink(TO_ROOT . "/core/style/tables.css");
  /* ---------------- <<<< End Configure CSS Theme >>>> ------------------------------------------------------------------*/
  
  
  /* ---------------- <<<< Configure JS Scripts >>>> ---------------------------------------------------------------------*/
  $Page->addJsLink(TO_ROOT . "/apps/admin/subcore/scripts/script.dictionaries.js");
  /* ---------------- <<<< End Configure JS Scripts >>>> -----------------------------------------------------------------*/
  
  
  $Page->display();