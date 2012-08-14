<?php

require('Smarty.class.php');
$pageType=$_POST["page"];
$smarty = new Smarty();
session_start();
$smarty->assign('profile',$_SESSION['profile']);
include('fetchSecurityId.php');
$smarty->assign('securityQuestionId',$_SESSION['securityId']);
error_log('\n'.$pageType.'----');
<<<<<<< HEAD
include('budgetMeter.php');
=======
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
if($pageType=="home"){
$userRecordsContent=include 'fetchUserRecords.php';
$smarty->assign('userRecordContent',$userRecordsContent);
$smarty->assign('userRecordCount',$_SESSION['userRecordCount']);
$smarty->assign('profile',$_SESSION['profile']);
$smarty->assign('welcomeContent',' ');
$profile=$_SESSION['profile'];
if($profile=='supervisor'||$profile=='finance'||$profile=='hr'){
$supervisorRecordsContent=include 'fetchSupervisorRecords.php';
$smarty->assign('supervisorRecordContent',$supervisorRecordsContent);
$smarty->assign('supervisorRecordCount',$_SESSION['supervisorRecordCount']);

}
<<<<<<< HEAD
if($profile=='president'){
$supervisorRecordsContent=include 'fetchPresidentRecords.php';
$smarty->assign('supervisorRecordContent',$supervisorRecordsContent);
$smarty->assign('supervisorRecordCount',$_SESSION['supervisorRecordCount']);
}
=======
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
$smarty->display('home.tpl');
}else if($pageType=="reports"){
$smarty->assign('reportCount',$_SESSION['reportCount']);
$subordinates=include 'fetchSubordinates.php';
$smarty->assign('subordinates',$subordinates);
$smarty->display('reports.tpl');
}else if($pageType=="settings"){
$securityQuestions=include 'fetchSecurityQuestions.php';
$smarty->assign('securityQuestions',$securityQuestions);
$smarty->display('settings.tpl');
}else if($pageType=="uploadExcel"){
error_log('comes in');
$smarty->display('uploadExcel.tpl');
}else if($pageType=="budget"){
$budgetDetails=include 'fetchBudgetDetails.php';
$smarty->assign('budgetDetails',$budgetDetails);
$smarty->assign('budgetUserCount',$_SESSION['budgetUserCount']);
$smarty->display('budget.tpl');
<<<<<<< HEAD
}else if($pageType=="contactus"){
$smarty->display('contactus.tpl');
}else if($pageType=="help"){
$smarty->display('help.tpl');
=======
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
}

?>