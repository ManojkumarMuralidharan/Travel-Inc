<?php

// put full path to Smarty.class.php
require('Smarty.class.php');
$smarty = new Smarty();
session_start();
//
//include('fetchSecurityId.php');
//$smarty->assign('securityQuestionId',$_SESSION['securityId']);
//$smarty->assign('profile',$_SESSION['profile']);
//$smarty->assign('userName','Ned');

//** un-comment the following line to show the debug console
//$smarty->debugging = true;
$smarty->display('forgotPassword.tpl');
session_destroy();


?>