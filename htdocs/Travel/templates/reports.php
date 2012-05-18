<?php
$reportType=$_GET["reportType"];
$smarty = new Smarty();

if($reportType=='monthly'){
echo $smarty->display('monthlyReports.tpl');
}else($reportType=='regular'){
echo $smarty->display('regularReports.tpl');
}

?>