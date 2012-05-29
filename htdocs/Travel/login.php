<?php

// put full path to Smarty.class.php
require('C:/Users/TestUser/xampp/htdocs/Travel/lib/Smarty/libs/Smarty.class.php');
$smarty = new Smarty();
session_start();
if ((isset($_SESSION['username']) && $_SESSION['username'] != '')) {
header ("Location: home.php");
}

$smarty->display('login.tpl');

?>