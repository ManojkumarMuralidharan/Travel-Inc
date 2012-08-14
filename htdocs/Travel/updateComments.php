<?php

<<<<<<< HEAD
require('Smarty.class.php');
session_start();
/*
$host="10.6.50.26"; // Host name
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

$action=$_POST["action"];
$comments=$_POST["comments"];
$id=$_POST["id"];


error_log($id.$comments.$action, 0);

// To protect MySQL injection (more detail about MySQL injection)
<<<<<<< HEAD
error_log('Before striping slashes '.$comments);
$comments = stripslashes($comments);
error_log('After striping slashes '.$comments);
=======
$comments = stripslashes($comments);
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e

$id=stripslashes($id);
$action=stripslashes($action);


//$userName = mysql_real_escape_string($userName);
//$supervisorName = mysql_real_escape_string($supervisorName);
//$userType = mysql_real_escape_string($userType);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

<<<<<<< HEAD
$sql="SELECT * FROM $tbl_name WHERE idexpenserecords='".$id."';";
error_log($sql);
$result=mysql_query($sql);
$old_comments=mysql_result($result,0,"comments");
$count=mysql_num_rows($result);
if($count>=1){
$old_comments.=" \nSupervisor: ".$comments;
$sql="UPDATE  ".$db_name.".`".$tbl_name."` SET  `comments` =  'Requestor: ".$old_comments;
$sql.="', `approval`='".$action."' WHERE  `".$tbl_name."`.`idexpenserecords` =  '".$id."' LIMIT 1 ;";
=======
$sql="SELECT * FROM $tbl_name WHERE id='".$id."';";
error_log($sql);
$result=mysql_query($sql);
$count=mysql_num_rows($result);
if($count>=1){
$sql="UPDATE  ".$db_name.".`".$tbl_name."` SET  `comments` =  '".$comments;
$sql.="', `approval`='".$action."' WHERE  `".$tbl_name."`.`id` =  '".$id."' LIMIT 1 ;";
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
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