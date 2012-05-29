<?php
session_start();
if (!(isset($_SESSION['username']) && $_SESSION['username'] != '')) {
header ("Location: login.php");
}
// put full path to Smarty.class.php
require('C:/Users/TestUser/xampp/htdocs/Travel/lib/Smarty/libs/Smarty.class.php');
//use pear
require 'DB.php';
$smarty = new Smarty();
$pieces = explode("@", $_SESSION['username']);

//$smarty->assign('securityQuestionId',$_SESSION['securityId']);
include('fetchSecurityId.php');
$smarty->assign('securityQuestionId',$_SESSION['securityId']);

$userRecordsContent=include 'fetchUserRecords.php';
$smarty->assign('userRecordContent',$userRecordsContent);
$smarty->assign('userRecordCount',$_SESSION['userRecordCount']);
$smarty->assign('profile',$_SESSION['profile']);
$profile=$_SESSION['profile'];
if($profile=='supervisor'){
$supervisorRecordsContent=include 'fetchSupervisorRecords.php';
$smarty->assign('supervisorRecordContent',$supervisorRecordsContent);
$smarty->assign('supervisorRecordCount',$_SESSION['supervisorRecordCount']);

}

$smarty->assign('userName',$pieces[0]);
//$smarty->assign('',);

//** un-comment the following line to show the debug console
//$smarty->debugging = true;
$smarty->display('index.tpl');


?>