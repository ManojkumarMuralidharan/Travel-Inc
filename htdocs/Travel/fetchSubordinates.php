<?php
<<<<<<< HEAD
/*
$host="10.6.50.29"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
*/
include 'DB_details.php';
//$db_name="travel"; // Database name
$tbl_name="user"; // Table name
=======

$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="login"; // Table name
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e

//$recordType=$_GET[
$userName=$_SESSION["username"];

//error_log($userName.$supervisorName.$userType, 0);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

<<<<<<< HEAD
//Get User Id
$sql="SELECT iduser,idprofile FROM user WHERE username='$userName' ";
$result=mysql_query($sql);
$count=mysql_num_rows($result);
$iduser=mysql_result($result,0,"iduser");
$idprofile=mysql_result($result,0,"idprofile");
if($idprofile!=3){
$sql="SELECT username FROM $tbl_name WHERE idsupervisor='".$iduser."' ; ";
//error_log($sql);
}else{
$sql="SELECT username FROM $tbl_name WHERE username!='".$userName."' ; ";
}
=======
$sql="SELECT username FROM $tbl_name WHERE supervisor='".$userName."' ; ";
//error_log($sql);
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e

$result=mysql_query($sql);

$count=mysql_num_rows($result);

<<<<<<< HEAD
$records="<option value='".$userName."' onClick='reportUserName=$(this).text();'>".$userName."</option>";
while($row = mysql_fetch_assoc($result))
{

	
	$records.="<option value='".$row['username']."' onClick='reportUserName=$(this).text();'>".$row['username']."</option>";
=======
$records="";
while($row = mysql_fetch_assoc($result))
{


	$records.="<option value='".$row['username']."' onClick='reportUserName=$(this).text();alert(reportUserName);'>".$row['username']."</option>";
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
            
} 
mysql_close();
return $records;

?>