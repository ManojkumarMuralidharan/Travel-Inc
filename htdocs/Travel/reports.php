<?php

require('C:/Users/TestUser/xampp/htdocs/Travel/lib/Smarty/libs/Smarty.class.php');
$reportType=$_POST["reportType"];
session_start();
$smarty = new Smarty();
//$smarty->display('index.tpl');
$smarty->assign('profile',$_SESSION['profile']);
//$reports=include 'fetchReports.php';
$subordinates=include 'fetchSubordinates.php';
$smarty->assign('subordinates',$subordinates);
echo "<script type=\"text/javascript\">alert('".$_SESSION['profile'].");</script>";
if($reportType=='monthly')
$smarty->display('monthlyReports.tpl');
else if($reportType=='regular')
$smarty->display('regularReports.tpl');
//echo 2;

?>