<?php
include '../RESTUtils.php';
include 'db_authentication.php';


$utils = new RestUtils();
$db_auth= new DB_Authentication();
$utils->processRequest($_SERVER,$_GET,$_POST);
//echo '.<span>'.$utils->data['username'].'.</span>';
$userName=$utils->data['username'];
$password=$utils->data['password'];
$return_val= $db_auth->check_user($userName,$password);
$json=$db_auth->fetchUserRecords($userName);
$json=$db_auth->fetchSupervisorRecords($userName);
echo $return_val;
echo $json;



?>