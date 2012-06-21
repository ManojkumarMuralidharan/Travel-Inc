<?php


$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="entry"; // Table name

//$recordType=$_GET[
$id=$_GET["id"];

//error_log($userName.$supervisorName.$userType, 0);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

$sql="SELECT * FROM $tbl_name WHERE `id`='".$id."';  ";
error_log($sql);

$result=mysql_query($sql);

$count=mysql_num_rows($result);

$records=array();

while($row = mysql_fetch_assoc($result))
{
error_log( 'Testing'.$row['id'].$row['datefrom'].$row['dateto'].$row['placefrom'].$row['placeto'].$row['traveltype'].$row['cost'].$row['reason']);

        $records['id']=$row['id'];
		$row['datefrom']=str_replace('-','/',$row['datefrom']);
		$records['datefrom']=$row['datefrom'];
		$row['dateto']=str_replace('-','/',$row['dateto']);
        $records['dateto']=$row['dateto'];
        $records['placefrom']=$row['placefrom'];
        $records['placeto']=$row['placeto'];
        $records['traveltype']=$row['traveltype'];
        $records['cost']=$row['cost'];
        $records['reason']=$row['reason'];
		$records['purpose']=$row['purpose'];
      
} 
mysql_close();

error_log(json_encode($records));
//error_log(print json_encode($records1));

echo json_encode($records);

?>