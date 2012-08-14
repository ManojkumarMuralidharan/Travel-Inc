<?php

<<<<<<< HEAD

$term = trim(strip_tags($_GET['term']));


session_start();
//log.error('hi');
/*
$host="10.6.50.29"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
*/
include 'DB_details.php';
$db_name="travel"; // Database name
$tbl_name="user"; // Table name
=======
require('C:/Users/TestUser/xampp/htdocs/Travel/lib/Smarty/libs/Smarty.class.php');

$term = trim(strip_tags($_GET['term']));

$smarty = new Smarty();
session_start();
//log.error('hi');
$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="login"; // Table name
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e

//$conn = mysql_connect($host, $mysql_userName, $mysql_password);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

//$q = strtolower($_GET["newSupervisor"]);

<<<<<<< HEAD
$query = mysql_query("select username from $tbl_name where username like '%".$term."%' AND idprofile >1 ");
error_log("select username from $tbl_name where username like '%".$term."%' AND idprofile >1");
=======
$query = mysql_query("select username from login where username like '%".$term."%'");
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
//echo json_encode("success");
//while ($row = mysql_fetch_array($query)) {
//    echo json_encode($row);
//}
//error_log($term , 0);
<<<<<<< HEAD
$row_set='';
=======
$row_set;
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
while($row = mysql_fetch_array($query)) {
  //$cname = $row['username'];
  //  echo json_encode($cname);
	$row['username']=htmlentities(stripslashes($row['username']));
	$row_set[] = $row['username'];
 //	error_log($cname, 0);
	//echo $cname;
}
echo json_encode($row_set);
?>