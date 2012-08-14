<?php

// put full path to Smarty.class.php
require('Smarty.class.php');
$smarty = new Smarty();
session_start();
if ((isset($_SESSION['username'])&&isset($_SESSION['profile']) && $_SESSION['username'] != '')) {
header ("Location: home.php");
}

$smarty->display('login.tpl');

?>