<?php

require('C:/Users/TestUser/xampp/htdocs/Travel/lib/Smarty/libs/Smarty.class.php');
session_start();

$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="login"; // Table name

$userName=$_POST["userName"];
$supervisorName=$_POST["supervisor"];
$userType=$_POST["userType"];
$password=include 'randomPassword.php';
error_log($userName.$supervisorName.$userType, 0);

// To protect MySQL injection (more detail about MySQL injection)
$userName = stripslashes($userName);

$supervisorName=stripslashes($supervisorName);

$userType=stripslashes($userType);


//$userName = mysql_real_escape_string($userName);
//$supervisorName = mysql_real_escape_string($supervisorName);
//$userType = mysql_real_escape_string($userType);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

$sql="SELECT * FROM $tbl_name WHERE username='".$userName."' ;";
$result=mysql_query($sql);
$count=mysql_num_rows($result);
if($count>=1){
echo "userexists";
}else{

			$sql="SELECT * FROM $tbl_name WHERE username='".$supervisorName."' ;";
			$result=mysql_query($sql);
			$count=mysql_num_rows($result);
				if($count<=0){
					echo "supervisorError";
					exit;
				}else{
					while($row = mysql_fetch_assoc($result))
					{
					 if($row['profile']!='supervisor'){
						echo "supervisorError";
						exit;
					 }
					} 
				}

	$sql="INSERT INTO ".$db_name.".`".$tbl_name."` (`username` ,`password` ,`supervisor` ,`active` ,`profile`)VALUES (
	'".$userName."',  '".$password."',  '".$supervisorName."',  '1',  '".$userType."');";
	//$sql="INSERT INTO login VALUES (value1, value2, value3,...);"

	if (!mysql_query($sql))
	  {
	  die('Error: ' . mysql_error());
	  mysql_close();
	  echo "fail";
	  }else{
		mysql_close();
		echo "success";
	  }
}
?>