<?php

require('C:/Users/TestUser/xampp/htdocs/Travel/lib/Smarty/libs/Smarty.class.php');
session_start();

$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="entry"; // Table name

$id_post=$_POST["id"];
$action=$_POST["action"];
$userName=$_SESSION['username'];
$supervisor=$_SESSION['username'];




mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");
//error_log($id_post);
//$id_array= explode(",", $id_post);

foreach ($id_post as $id) {
		
	$sql="SELECT * FROM  $tbl_name WHERE  `id` = '".$id."' AND  `supervisor` LIKE  '".$supervisor."' ;";
	error_log('-'.$sql);

	$result=mysql_query($sql);
	$count=mysql_num_rows($result);
	if($count>=1){
		error_log('-'.$sql);

	$sql="UPDATE $tbl_name SET  `approval` = '".$action."'  WHERE  `".$tbl_name."`.`id` ='".$id."' LIMIT 1 ;";

	error_log('--'.$sql);
		//$sql="INSERT INTO ".$db_name.".`".$tbl_name."` (`username` ,`password` ,`supervisor` ,`active` ,`profile`)VALUES ('".$userName."',  '".$password."',  '".$supervisorName."',  '1',  '".$userType."');";
		//$sql="INSERT INTO login VALUES (value1, value2, value3,...);"

		if (!mysql_query($sql))
		  {
		  die('Error: ' . mysql_error());
		  echo "fail";
		  exit;
		  }else{
			//echo "success";
		  }
	}else{

		echo "fail";
		exit;

	}
}

echo "success";
?>