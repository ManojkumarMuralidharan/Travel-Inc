<?php
session_start();
$reportType=$_GET["reportType"];
$smarty = new Smarty();
$smarty->assign('reportCount',$_SESSION['reportCount']);
if($reportType=='monthly'){
echo $smarty->display('monthlyReports.tpl');
}else($reportType=='regular'){
echo $smarty->display('regularReports.tpl');
}

?>