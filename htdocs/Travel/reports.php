<?php

require('C:/Users/TestUser/xampp/htdocs/Travel/lib/Smarty/libs/Smarty.class.php');
$reportType=$_POST["reportType"];
$smarty = new Smarty();
//$smarty->display('index.tpl');
if($reportType=='monthly')
$smarty->display('monthlyReports.tpl');
else if($reportType=='regular')
$smarty->display('regularReports.tpl');
//echo 2;

?>