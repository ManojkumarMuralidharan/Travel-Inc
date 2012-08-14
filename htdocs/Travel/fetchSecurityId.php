<?php
/*
$host="10.6.50.29"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password*/
include 'DB_details.php';
//$db_name="travel"; // Database name
$tbl_name="user"; // Table name



//$recordType=$_GET[
$userName=$_SESSION["username"];

$supervisor=$_SESSION["supervisor"];
//error_log($userName.$supervisorName.$userType, 0);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

$sql="SELECT * FROM $tbl_name WHERE username='".$userName."' ; ";
error_log($sql);

$result=mysql_query($sql);
$count=mysql_num_rows($result);
if($count>=1){
			$sql="SELECT idsecurityquestion FROM $tbl_name WHERE username='".$userName."' ";
								$result=mysql_query($sql);
								$count=mysql_num_rows($result);
								if($count==1){
									$securityid=mysql_result($result,0,"idsecurityquestion");
									//echo $profile;
									$_SESSION['securityId']=$securityid;
									$result=mysql_query($sql);
									mysql_close();
									//echo "success";
								}else{
									mysql_close();
									//`profile` field error
									echo "error_fetchSecurityId";
								}
}else{
	mysql_close();
	echo "fail";
}

?>