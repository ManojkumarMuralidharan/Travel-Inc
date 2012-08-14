<?php
<<<<<<< HEAD
/*
$host="10.6.50.29"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
*/
include 'DB_details.php';
//$db_name="travel"; // Database name
$tbl_name="expenserecords"; // Table name
=======

$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="entry"; // Table name
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e

//$recordType=$_GET[
$id=$_POST["id"];
$type=$_POST["type"];
//error_log($userName.$supervisorName.$userType, 0);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

if($type=='comments')
<<<<<<< HEAD
$sql="SELECT comments FROM $tbl_name WHERE idexpenserecords='".$id."';  ";
else if($type=='reason')
$sql="SELECT reason FROM $tbl_name WHERE idexpenserecords='".$id."';  ";
=======
$sql="SELECT comments FROM $tbl_name WHERE id='".$id."';  ";
else if($type=='reason')
$sql="SELECT reason FROM $tbl_name WHERE id='".$id."';  ";
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e

error_log($sql);

$records="";


$result=mysql_query($sql);
$count=mysql_num_rows($result);
		if($count==1){
		if($type=='comments')
		$records=mysql_result($result,0,"comments");
		else if($type=='reason')
		$records=mysql_result($result,0,"reason");
		
		mysql_close();
		echo $records;
		}else{
		mysql_close();
		echo "fail";
		}
		
?>