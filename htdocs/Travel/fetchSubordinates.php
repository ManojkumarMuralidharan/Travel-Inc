<?php
/*
$host="10.6.50.29"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
*/
include 'DB_details.php';
//$db_name="travel"; // Database name
$tbl_name="user"; // Table name

//$recordType=$_GET[
$userName=$_SESSION["username"];

//error_log($userName.$supervisorName.$userType, 0);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

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

$result=mysql_query($sql);

$count=mysql_num_rows($result);

$records="<option value='".$userName."' onClick='reportUserName=$(this).text();'>".$userName."</option>";
while($row = mysql_fetch_assoc($result))
{

	
	$records.="<option value='".$row['username']."' onClick='reportUserName=$(this).text();'>".$row['username']."</option>";
            
} 
mysql_close();
return $records;

?>