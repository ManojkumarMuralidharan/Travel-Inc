<?php

/*
$host="10.6.50.29"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password*/
include 'DB_details.php';
//$db_name="travel"; // Database name
$tbl_name="expenserecords"; // Table name

//$recordType=$_GET[
$id=$_GET["id"];

//error_log($userName.$supervisorName.$userType, 0);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

$sql="SELECT * FROM $tbl_name WHERE `idexpenserecords`='".$id."';  ";
error_log($sql);

$result=mysql_query($sql);

$count=mysql_num_rows($result);

$records=array();

while($row = mysql_fetch_assoc($result))
{
error_log( 'Testing'.$row['idexpenserecords'].$row['fromdate'].$row['todate'].$row['placefrom'].$row['placeto'].$row['idtraveltype'].$row['cost'].$row['comments']);

        $records['id']=$row['idexpenserecords'];
		$row['fromdate']=str_replace('-','/',$row['fromdate']);
		$records['datefrom']=$row['fromdate'];
		$row['todate']=str_replace('-','/',$row['todate']);
        $records['dateto']=$row['todate'];
        $records['placefrom']=$row['placefrom'];
        $records['placeto']=$row['placeto'];
		if($row['idtraveltype']=='1'){
		$records['traveltype']='Local';
		}else{
		$records['traveltype']='International';
		}
       // $records['traveltype']=$row['idtraveltype'];
        $records['cost']=$row['cost'];
        $records['reason']=$row['comments'];
		$records['purpose']=$row['comments'];
      
} 
mysql_close();

error_log(json_encode($records));
//error_log(print json_encode($records1));

echo json_encode($records);

?>