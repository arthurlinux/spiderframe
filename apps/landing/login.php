<?php define("TO_ROOT", "../..");  require_once TO_ROOT . "/core/includes/main.inc.php";  $Page = new Page("Login", "login", "front");    if($_SESSION["user_login_id"] != "")  {  	$Page->goToPage(TO_ROOT . "/apps/landing/applications.php");  }    $Page->setOnReady("__focus","member");    $Page->addCssLink(TO_ROOT . "/apps/subcore/style/forms.css");  $Page->addJsLink(TO_ROOT . "/apps/subcore/scripts/script.login_tool.js");  $Page->display();