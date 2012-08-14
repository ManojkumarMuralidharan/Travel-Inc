<?php

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

$action=$_POST["action"];
$comments=$_POST["comments"];
$id=$_POST["id"];


error_log($id.$comments.$action, 0);

// To protect MySQL injection (more detail about MySQL injection)
error_log('Before striping slashes '.$comments);
$comments = stripslashes($comments);
error_log('After striping slashes '.$comments);

$id=stripslashes($id);
$action=stripslashes($action);


//$userName = mysql_real_escape_string($userName);
//$supervisorName = mysql_real_escape_string($supervisorName);
//$userType = mysql_real_escape_string($userType);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

$sql="SELECT * FROM $tbl_name WHERE idexpenserecords='".$id."';";
error_log($sql);
$result=mysql_query($sql);
$old_comments=mysql_result($result,0,"comments");
$count=mysql_num_rows($result);
if($count>=1){
$old_comments.=" \nSupervisor: ".$comments;
$sql="UPDATE  ".$db_name.".`".$tbl_name."` SET  `comments` =  'Requestor: ".$old_comments;
$sql.="', `approval`='".$action."' WHERE  `".$tbl_name."`.`idexpenserecords` =  '".$id."' LIMIT 1 ;";
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