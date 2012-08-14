<?php

<<<<<<< HEAD
require('Smarty.class.php');
include 'sendMail.php';
session_start();
/*
$host="10.6.50.26"; // Host name
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
$answer=$_POST["answer"];
$answer=strtolower($answer);

error_log($userName.$answer, 0);

// To protect MySQL injection (more detail about MySQL injection)
$userName = stripslashes($userName);

$answer=stripslashes($answer);

<<<<<<< HEAD
//session_destroy();
=======
session_destroy();
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e

//$userName = mysql_real_escape_string($userName);
//$supervisorName = mysql_real_escape_string($supervisorName);
//$userType = mysql_real_escape_string($userType);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

$sql="SELECT * FROM $tbl_name WHERE username='".$userName."' AND answer ='".$answer."';";
<<<<<<< HEAD
error_log("---+".$sql);
$result=mysql_query($sql);
$count=mysql_num_rows($result);
error_log('---count='.$count);
if($count>=1){
$newPassword=include 'randomPassword.php';
$sql="UPDATE  ".$db_name.".`".$tbl_name."` SET  `password` =  '".$newPassword;
$sql.="' WHERE  `".$tbl_name."`.`username` =  '".$userName."' AND  `".$tbl_name."`.`answer` =  '".$answer."' LIMIT 1 ;";
=======
error_log($sql);
$result=mysql_query($sql);
$count=mysql_num_rows($result);
if($count>=1){
$newPassword=include 'randomPassword.php';
$sql="UPDATE  ".$db_name.".`".$tbl_name."` SET  `password` =  '".$newPassword;
$sql.="' WHERE  `login`.`username` =  '".$userName."' AND  `login`.`answer` =  '".$answer."' LIMIT 1 ;";
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
		$body_pass=$newPassword;
		$to=$userName;
		$subject="";
		sendMessage($to,$body_pass,$subject);
=======
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
		echo "success";
	  }


}else{
	mysql_close();
	echo "wrongAnswer";
}
<<<<<<< HEAD


function sendMessage($to,$body_pass,$subject){

	  //To user
	 // $to="Manojkumar.Muralidharan@itcinfotech.com";
	  //$to=$userName;
	  $subject="Password reset";

	  $body="<div><span>Hi , </br></span></div>";
	  $body.='<div> Your Password has been successfully reset to '.$body_pass.'.Kindly update your password after first Login. </div>';
	$body.='<div style="margin-top:20px">regards,</div>';
	$body.='<div style="margin-top:0px">I2A Travel</div>';
	sendMail($to,$body,$subject);


}

=======
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
?>