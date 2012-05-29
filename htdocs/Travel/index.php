<?php

// put full path to Smarty.class.php
require('C:/Users/TestUser/xampp/htdocs/Travel/lib/Smarty/libs/Smarty.class.php');
$smarty = new Smarty();
session_start();
if ((isset($_SESSION['username']) && $_SESSION['username'] != '')) {
include('fetchSecurityId.php');
$smarty->assign('securityQuestionId',$_SESSION['securityId']);
header ("Location: home.php");
}
//$smarty->assign('profile',$_SESSION['profile']);
//$smarty->assign('userName','Ned');

//** un-comment the following line to show the debug console
//$smarty->debugging = true;
$smarty->display('login.tpl');



?>