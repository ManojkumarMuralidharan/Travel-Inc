<?php

require('Smarty.class.php');
$reportType=$_POST["reportType"];
session_start();

$smarty = new Smarty();
//$smarty->display('index.tpl');

$smarty->assign('reportCount',$_SESSION['reportCount']);
$smarty->assign('profile',$_SESSION['profile']);
//$reports=include 'fetchReports.php';
$subordinates=include 'fetchSubordinates.php';
$smarty->assign('subordinates',$subordinates);

if($reportType=='monthly')
$smarty->display('monthlyReports.tpl');
else if($reportType=='regular')
$smarty->display('regularReports.tpl');


?>