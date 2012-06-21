<?php

require('C:/Users/TestUser/xampp/htdocs/Travel/lib/Smarty/libs/Smarty.class.php');
session_start();

$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="entry"; // Table name

$requestTravelType=$_POST["travelType"];
$requestTravelSource=$_POST["source"];
$requestTravelDestination=$_POST["destination"];
$requestTravelFromDate=$_POST["fromDate"];
$requestTravelToDate=$_POST["ToDate"];
$requestTravelPurpose=$_POST["purpose"];
$requestTravelCost=$_POST["cost"];
$requestTravelComments=$_POST["comments"];

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

//$requestTravelType=mysql_real_escape_string($requestTravelType);
//$requestTravelSource=mysql_real_escape_string($requestTravelSource);
//$requestTravelDestination=mysql_real_escape_string($requestTravelDestination);
//$requestTravelFromDate=mysql_real_escape_string($requestTravelFromDate);
//$requestTravelToDate=mysql_real_escape_string($requestTravelToDate);
//$requestTravelPurpose=mysql_real_escape_string($requestTravelPurpose);
//$requestTravelCost=mysql_real_escape_string($requestTravelCost);
//$requestTravelComments=mysql_real_escape_string($requestTravelComments);
//error_log('\nAfter \n'.$requestTravelType.','.$requestTravelSource.",".$requestTravelDestination.",".$requestTravelFromDate.",".$requestTravelToDate.",".$requestTravelPurpose.",".$requestTravelCost.",".$requestTravelComments, 0);

$supervisor=$_SESSION['supervisor'];


//$requestTravelToDate=str_replace("/","-",$requestTravelToDate);
//$requestTravelFromDate=str_replace("/","-",$requestTravelFromDate);

$sql="SELECT * FROM  $tbl_name WHERE  `username` LIKE  '".$userName."' AND `supervisor` LIKE  '".$supervisor."' AND `datefrom` LIKE  '".$requestTravelFromDate."' AND `dateto` LIKE  '".$requestTravelToDate."' AND `placefrom` LIKE  '".$requestTravelSource."' AND `placeto` LIKE  '".$requestTravelDestination."' AND `purpose` LIKE '".$requestTravelPurpose."' AND `cost` LIKE '".$requestTravelCost."'  AND `traveltype` LIKE '".$requestTravelType."' AND `approval` LIKE 'WIP';";
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
$result=mysql_query($sql);
$count=mysql_num_rows($result);
if($count>=1){
echo "recordexists";
}else{

$fromDate=date("Y-m-d",strtotime($requestTravelFromDate));
$toDate=date("Y-m-d",strtotime($requestTravelToDate));
$requestTravelFromDate=date("Y-m-d",strtotime($requestTravelFromDate));
$requestTravelToDate=date("Y-m-d",strtotime($requestTravelToDate));

$sql="INSERT INTO ".$db_name.".".$tbl_name." (`username`, `supervisor`, `datefrom`, `dateto`,`placefrom`, `placeto`, `purpose`, `cost`, `approval`, `traveltype`, `reason`,`fromdate`,`todate` ) VALUES('".$userName."', '".$supervisor."', '".$requestTravelFromDate."', '" 
.$requestTravelToDate."','".$requestTravelSource."','".$requestTravelDestination."','".$requestTravelPurpose."', '".$requestTravelCost."', 'WIP','".$requestTravelType."', '".$requestTravelComments."','".$fromDate."','".$toDate."');";
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
}

?>