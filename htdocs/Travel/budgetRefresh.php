<?php
session_start();
include ('budgetMeter.php');
echo $_SESSION['currentBudget'].":".$_SESSION['totalBudget'];
//$smarty->assign('currentBudget',$_SESSION['currentBudget']);
//$smarty->assign('totalBudget',$_SESSION['totalBudget']);


?>