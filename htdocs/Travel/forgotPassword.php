<?php

// put full path to Smarty.class.php
<<<<<<< HEAD
require('Smarty.class.php');
=======
require('C:/Users/TestUser/xampp/htdocs/Travel/lib/Smarty/libs/Smarty.class.php');
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
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
<<<<<<< HEAD
session_destroy();
=======

>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e


?>