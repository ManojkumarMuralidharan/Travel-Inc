<?php

$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="securityquestions"; // Table name

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


	$records.="<option value='".$row['securityId']."' onClick=''>".$row['questions']."</option>";
            
} 
mysql_close();
return $records;

?>