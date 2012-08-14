<?php

<<<<<<< HEAD
require('Smarty.class.php');
session_start();
include 'sendMail.php';
/*
$host="10.6.50.29"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
*/
include 'DB_details.php';
//$db_name="travel"; // Database name
$tbl_name="user"; // Table name
=======
require('C:/Users/TestUser/xampp/htdocs/Travel/lib/Smarty/libs/Smarty.class.php');
session_start();

$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="login"; // Table name
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e

$userName=$_SESSION['username'];
$supervisor=$_SESSION['supervisor'];
$currentPassword=$_POST["currentPassword"];
$newPassword=$_POST["newPassword"];

<<<<<<< HEAD
mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");
=======

>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
error_log($userName.$supervisor.$newPassword.$currentPassword, 0);

// To protect MySQL injection (more detail about MySQL injection)
$userName = stripslashes($userName);

$currentPassword=stripslashes($currentPassword);

$newPassword=stripslashes($newPassword);


//$userName = mysql_real_escape_string($userName);
//$supervisorName = mysql_real_escape_string($supervisorName);
//$userType = mysql_real_escape_string($userType);

<<<<<<< HEAD


=======
mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e

$sql="SELECT * FROM $tbl_name WHERE username='".$userName."' and password ='".$currentPassword."';";
error_log($sql);
$result=mysql_query($sql);
$count=mysql_num_rows($result);
if($count>=1){
$sql="UPDATE  ".$db_name.".`".$tbl_name."` SET  `password` =  '".$newPassword;
<<<<<<< HEAD
$sql.="' WHERE  `user`.`username` =  '".$userName."' AND  `user`.`password` =  '".$currentPassword;
$sql.="' LIMIT 1 ;";
=======
$sql.="' WHERE  `login`.`username` =  '".$userName."' AND  `login`.`password` =  '".$currentPassword;
$sql.="' AND  `login`.`supervisor` = '".$supervisor."' LIMIT 1 ;";
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
error_log($sql);
	if (!mysql_query($sql))
	  {
	  die('Error: ' . mysql_error());
	  mysql_close();
	  echo "fail";
	  }else{
		mysql_close();
<<<<<<< HEAD
		sendMessage($userName,'','Password Changed');
=======
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
		echo "success";
	  }


}else{
	mysql_close();
	echo "wrongPassword";
}
<<<<<<< HEAD

function sendMessage($to,$body,$subject){

	  //To user
	  //$to="Manojkumar.Muralidharan@itcinfotech.com";
	  //$to=$userName;
	  $subject="Password Changed";

	  $body="<div><span>Hi , </br></span></div>";
	  $body.='<div> Your Password has been successfully changed.</div>';
	$body.='<div style="margin-top:20px">regards,</div>';
	$body.='<div style="margin-top:0px">I2A Travel</div>';
	
	 // $body=" Your travel request for ".$requestTravelSource." to ".$requestTravelDestination." has been successfully submitted and the request Id is ".$idexpenseworkflow;
	  sendMail($to,$body,$subject);


}
=======
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
?>