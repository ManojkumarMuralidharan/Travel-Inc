<?php
session_start();

if (!(isset($_SESSION['username']) && $_SESSION['username'] != '')) {
header ("Location: login.php");
}
if (!isset($_SESSION['supervisor'])){
header ("Location: login.php");
}
if (!isset($_SESSION['loginCount'])){
header ("Location: login.php");
}
if (!isset($_SESSION['profile'])){
header ("Location: login.php");
}


// put full path to Smarty.class.php
require('Smarty.class.php');
//use pear
//require 'DB.php';
$smarty = new Smarty();
$pieces = explode("@", $_SESSION['username']);

//$smarty->assign('securityQuestionId',$_SESSION['securityId']);
include('fetchSecurityId.php');
include('budgetMeter.php');
$smarty->assign('currentBudget',$_SESSION['currentBudget']);
$smarty->assign('totalBudget',$_SESSION['totalBudget']);

$smarty->assign('reportUserName',$_SESSION['username']);
$smarty->assign('securityQuestionId',$_SESSION['securityId']);
if($_SESSION['loginCount'] ==0){
$smarty->assign('welcomeContent', "<script>  if(justLogged==1){ var contentText=$('#titleUserName').text();	 var text=contentText.split(',',2); Notifier.info(text[0]); justLogged=0; } </script>");
$_SESSION['loginCount'] = $_SESSION['loginCount'] + 1 ; 
}else{
$smarty->assign('welcomeContent',' ');
}
$userRecordsContent=include 'fetchUserRecords.php';
$smarty->assign('userRecordContent',$userRecordsContent);
$smarty->assign('userRecordCount',$_SESSION['userRecordCount']);
$smarty->assign('profile',$_SESSION['profile']);
$profile=$_SESSION['profile'];
if($profile=='supervisor'){
$supervisorRecordsContent=include 'fetchSupervisorRecords.php';
$smarty->assign('supervisorRecordContent',$supervisorRecordsContent);
$smarty->assign('supervisorRecordCount',$_SESSION['supervisorRecordCount']);

}else if($profile=='finance'||$profile=='hr'){
$supervisorRecordsContent=include 'fetchFinanceRecords.php';
$smarty->assign('supervisorRecordContent',$supervisorRecordsContent);
$smarty->assign('supervisorRecordCount',$_SESSION['supervisorRecordCount']);
}else if($profile=='president'){
$supervisorRecordsContent=include 'fetchPresidentRecords.php';
$smarty->assign('supervisorRecordContent',$supervisorRecordsContent);
$smarty->assign('supervisorRecordCount',$_SESSION['supervisorRecordCount']);
}

$smarty->assign('userName',$pieces[0]);
//$smarty->assign('',);

//** un-comment the following line to show the debug console
//$smarty->debugging = true;
$smarty->display('index.tpl');


?>