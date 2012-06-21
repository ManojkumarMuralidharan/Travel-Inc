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
$newId=$_POST["securityQuestionId"];
$newAnswer=$_POST["answer"];
$newAnswer=strtolower($newAnswer);

error_log($userName.$supervisor.$newId.$newAnswer, 0);

// To protect MySQL injection (more detail about MySQL injection)
$userName = stripslashes($userName);

$newId=stripslashes($newId);

$newAnswer=stripslashes($newAnswer);


//$userName = mysql_real_escape_string($userName);
//$supervisorName = mysql_real_escape_string($supervisorName);
//$userType = mysql_real_escape_string($userType);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

$sql="SELECT * FROM $tbl_name WHERE username='".$userName."' and supervisor ='".$supervisor."';";
error_log($sql);
$result=mysql_query($sql);
$count=mysql_num_rows($result);
if($count>=1){
$sql="UPDATE  ".$db_name.".`".$tbl_name."` SET  `securityid` =  '".$newId;
$sql.="' , `answer`= '".$newAnswer."' WHERE  `login`.`username` =  '".$userName."' AND  `login`.`supervisor` =  '".$supervisor;
$sql.="' LIMIT 1 ;";
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
	echo "fail";
}
?>