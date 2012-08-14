<?php
/*
$host="10.6.50.29"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
*/
include 'DB_details.php';
//$db_name="travel"; // Database name
$tbl_name="peoplesoftdata"; // Table name

//$recordType=$_GET[
$userName=$_SESSION["userName"];

$psid=$_POST["psid"];
$budget=$_POST["budget"];

//error_log($userName.$supervisorName.$userType, 0);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

//$sql="SELECT  SUM(`cost`) as cost, `psid` FROM `peoplesoftdata` GROUP BY `psid` ; ";
$sql="UPDATE `budget` SET `proposedbudget`= ".$budget ." WHERE `psid` = ".$psid." LIMIT 1 ;";
error_log($sql);


if (!mysql_query($sql))
	  {
	  die('Error: ' . mysql_error());
	  echo "fail";
	  }else{
		echo "success";
	  }



mysql_close();
//return $records;

?>