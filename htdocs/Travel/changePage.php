<?php

require('C:/Users/TestUser/xampp/htdocs/Travel/lib/Smarty/libs/Smarty.class.php');
$pageType=$_POST["page"];
$smarty = new Smarty();
if($pageType=="home"){
$smarty->display('home.tpl');
}
else if($pageType=="reports"){
$smarty->display('reports.tpl');
}

?>