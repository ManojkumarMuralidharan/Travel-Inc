<?php

<<<<<<< HEAD
require('Smarty.class.php');
session_start();
/*
$host="10.6.50.29"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
*/
include 'DB_details.php';
//$db_name="travel"; // Database name
$tbl_name="expenserecords"; // Table name
=======
require('C:/Users/TestUser/xampp/htdocs/Travel/lib/Smarty/libs/Smarty.class.php');
session_start();

$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="entry"; // Table name
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e

$requestTravelType=$_POST["travelType"];
$requestTravelSource=$_POST["source"];
$requestTravelDestination=$_POST["destination"];
$requestTravelFromDate=$_POST["fromDate"];
$requestTravelToDate=$_POST["ToDate"];
$requestTravelPurpose=$_POST["purpose"];
$requestTravelCost=$_POST["cost"];
$requestTravelComments=$_POST["reason"];
$id=$_POST["id"];

<<<<<<< HEAD

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

=======
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
$userName=$_SESSION['username'];

error_log('\n Before \n'.$userName.",".$requestTravelType.','.$requestTravelSource.",".$requestTravelDestination.",".$requestTravelFromDate.",".$requestTravelToDate.",".$requestTravelPurpose.",".$requestTravelCost.",".$requestTravelComments, 0);

// To protect MySQL injection (more detail about MySQL injection)

$requestTravelType=stripslashes($requestTravelType);
$requestTravelSource=stripslashes($requestTravelSource);
$requestTravelDestination=stripslashes($requestTravelDestination);
$requestTravelFromDate=stripslashes($requestTravelFromDate);
$requestTravelToDate=stripslashes($requestTravelToDate);
$requestTravelPurpose=stripslashes($requestTravelPurpose);
$requestTravelCost=stripslashes($requestTravelCost);
$requestTravelComments=stripslashes($requestTravelComments);
$id=stripslashes($id);


$requestTravelType=mysql_real_escape_string($requestTravelType);
$requestTravelSource=mysql_real_escape_string($requestTravelSource);
$requestTravelDestination=mysql_real_escape_string($requestTravelDestination);
$requestTravelFromDate=mysql_real_escape_string($requestTravelFromDate);
$requestTravelToDate=mysql_real_escape_string($requestTravelToDate);
$requestTravelPurpose=mysql_real_escape_string($requestTravelPurpose);
$requestTravelCost=mysql_real_escape_string($requestTravelCost);
$requestTravelComments=mysql_real_escape_string($requestTravelComments);
$id=mysql_real_escape_string($id);
//error_log('\nAfter \n'.$requestTravelType.','.$requestTravelSource.",".$requestTravelDestination.",".$requestTravelFromDate.",".$requestTravelToDate.",".$requestTravelPurpose.",".$requestTravelCost.",".$requestTravelComments, 0);

$supervisor=$_SESSION['supervisor'];


$fromDate=date("Y-m-d",strtotime($requestTravelFromDate));
$toDate=date("Y-m-d",strtotime($requestTravelToDate));
$requestTravelFromDate=date("Y-m-d",strtotime($requestTravelFromDate));
$requestTravelToDate=date("Y-m-d",strtotime($requestTravelToDate));

//$requestTravelToDate=str_replace("/","-",$requestTravelToDate);
//$requestTravelFromDate=str_replace("/","-",$requestTravelFromDate);

<<<<<<< HEAD
//Get User Id
$sql="SELECT iduser FROM user WHERE username='$userName' ";
$result=mysql_query($sql);
$count=mysql_num_rows($result);
$iduser=mysql_result($result,0,"iduser");

$sql="SELECT * FROM  $tbl_name WHERE  `idexpenserecords` like '".$id."' AND `iduser` LIKE  '".$iduser."' AND (`approval` LIKE 'WIP' OR `approval` LIKE 'On Hold');";
error_log($sql);



=======
$sql="SELECT * FROM  $tbl_name WHERE  `id` like '".$id."' AND `username` LIKE  '".$userName."' AND `supervisor` LIKE  '".$supervisor."' AND `approval` LIKE 'WIP';";
error_log($sql);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

/*$sql="SELECT name FROM $tbl_name WHERE username='".$userName."' AND ";
$result=mysql_query($sql);
$count=mysql_num_rows($result);
if($count>=1){
echo "recordexists";
}*/

//$sql="SELECT * FROM $tbl_name WHERE username='".$userName."' AND ";
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
$result=mysql_query($sql);
$count=mysql_num_rows($result);
if($count>=1){
$sql="UPDATE ".$db_name.".".$tbl_name;
<<<<<<< HEAD
$sql.=" SET `fromdate` =  '".$requestTravelFromDate."', ";
$sql.=" `todate` =  '".$requestTravelToDate."', ";
$sql.=" `placefrom` =  '".$requestTravelSource."', ";
$sql.=" `placeto` =  '".$requestTravelDestination."', ";
$sql.=" `reason` =  '".$requestTravelPurpose."', ";
$sql.=" `cost` =  '".$requestTravelCost."', ";
if($requestTravelType=='international'){
$sql.=" `idtraveltype` =  '2', ";	
}else{
$sql.=" `idtraveltype` =  '1', ";
}
$sql.=" `comments` =  '".$requestTravelComments."' WHERE  `idexpenserecords` ='".$id."' LIMIT 1 ;";
=======
$sql.=" SET `datefrom` =  '".$requestTravelFromDate."', ";
$sql.=" `dateto` =  '".$requestTravelToDate."', ";
$sql.=" `placefrom` =  '".$requestTravelSource."', ";
$sql.=" `placeto` =  '".$requestTravelDestination."', ";
$sql.=" `purpose` =  '".$requestTravelPurpose."', ";
$sql.=" `cost` =  '".$requestTravelCost."', ";
$sql.=" `comments` =  '".$requestTravelComments."', ";
$sql.=" `fromdate` =  '".$fromDate."', ";
$sql.=" `todate` =  '".$toDate."', ";
$sql.=" `reason` =  '".$requestTravelComments."'  WHERE  `entry`.`id` ='".$id."' LIMIT 1 ;";
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e

error_log($sql);
	//$sql="INSERT INTO ".$db_name.".`".$tbl_name."` (`username` ,`password` ,`supervisor` ,`active` ,`profile`)VALUES ('".$userName."',  '".$password."',  '".$supervisorName."',  '1',  '".$userType."');";
	//$sql="INSERT INTO login VALUES (value1, value2, value3,...);"

	if (!mysql_query($sql))
	  {
	  die('Error: ' . mysql_error());
	  echo "fail";
	  }else{
		echo "success";
	  }
}else{

	echo "fail";

}

?>