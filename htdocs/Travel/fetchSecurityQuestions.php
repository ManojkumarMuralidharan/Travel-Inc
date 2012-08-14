<?php
/*
$host="10.6.50.29"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
*/
include 'DB_details.php';
//$db_name="travel"; // Database name
$tbl_name="securityquestion"; // Table name

//error_log($userName.$supervisorName.$userType, 0);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

$sql="SELECT * FROM $tbl_name  ; ";
//error_log($sql);

$result=mysql_query($sql);

$count=mysql_num_rows($result);

$records="";
while($row = mysql_fetch_assoc($result))
{


	$records.="<option value='".$row['idsecurityquestion']."' onClick=''>".$row['securityquestion']."</option>";
            
} 
mysql_close();
return $records;

?>