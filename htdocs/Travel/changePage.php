<?php

require('C:/Users/TestUser/xampp/htdocs/Travel/lib/Smarty/libs/Smarty.class.php');
$pageType=$_POST["page"];
$smarty = new Smarty();
session_start();
$smarty->assign('profile',$_SESSION['profile']);
include('fetchSecurityId.php');
$smarty->assign('securityQuestionId',$_SESSION['securityId']);
if($pageType=="home"){
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
$smarty->display('home.tpl');
}
else if($pageType=="reports"){
$subordinates=include 'fetchSubordinates.php';
$smarty->assign('subordinates',$subordinates);
$smarty->display('reports.tpl');
}
else if($pageType="settings"){
$securityQuestions=include 'fetchSecurityQuestions.php';
$smarty->assign('securityQuestions',$securityQuestions);
$smarty->display('settings.tpl');
}

?>