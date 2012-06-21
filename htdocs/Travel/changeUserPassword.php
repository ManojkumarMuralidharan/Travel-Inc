<?php

require('C:/Users/TestUser/xampp/htdocs/Travel/lib/Smarty/libs/Smarty.class.php');
session_start();

$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="login"; // Table name

$userName=$_SESSION['username'];
$supervisor=$_SESSION['supervisor'];
$currentPassword=$_POST["currentPassword"];
$newPassword=$_POST["newPassword"];


error_log($userName.$supervisor.$newPassword.$currentPassword, 0);

// To protect MySQL injection (more detail about MySQL injection)
$userName = stripslashes($userName);

$currentPassword=stripslashes($currentPassword);

$newPassword=stripslashes($newPassword);


//$userName = mysql_real_escape_string($userName);
//$supervisorName = mysql_real_escape_string($supervisorName);
//$userType = mysql_real_escape_string($userType);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

$sql="SELECT * FROM $tbl_name WHERE username='".$userName."' and password ='".$currentPassword."';";
error_log($sql);
$result=mysql_query($sql);
$count=mysql_num_rows($result);
if($count>=1){
$sql="UPDATE  ".$db_name.".`".$tbl_name."` SET  `password` =  '".$newPassword;
$sql.="' WHERE  `login`.`username` =  '".$userName."' AND  `login`.`password` =  '".$currentPassword;
$sql.="' AND  `login`.`supervisor` = '".$supervisor."' LIMIT 1 ;";
error_log($sql);
	if (!mysql_query($sql))
	  {
	  die('Error: ' . mysql_error());
	  mysql_close();
	  echo "fail";
	  }else{
		mysql_close();
		echo "success";
	  }


}else{
	mysql_close();
	echo "wrongPassword";
}
?>