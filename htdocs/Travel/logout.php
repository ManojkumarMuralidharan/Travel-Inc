<?php
session_start();
session_destroy();
// put full path to Smarty.class.php
require('C:/Users/TestUser/xampp/htdocs/Travel/lib/Smarty/libs/Smarty.class.php');
$smarty = new Smarty();

//$smarty->assign('userName','Ned');

//** un-comment the following line to show the debug console
//$smarty->debugging = true;
$smarty->display('login.tpl');
echo "<script type=\"text/javascript\">window.location.href='login.php';</script>";


?>