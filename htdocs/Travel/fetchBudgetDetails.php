<?php

$host="localhost"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="login"; // Table name

//$recordType=$_GET[
$userName=$_SESSION["username"];

//error_log($userName.$supervisorName.$userType, 0);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

$sql="SELECT  SUM(`cost`) as cost, `psid` FROM `db1`.`peoplesoftdata` GROUP BY `psid` ; ";
error_log($sql);

$result=mysql_query($sql);
$count=0;
$count=mysql_num_rows($result);
$_SESSION["budgetUserCount"]=$count;
$records="";
while($row = mysql_fetch_assoc($result))
{


	$records.="<tr><td style='width: 50px;'><span id='".$row['psid']."'> ".$row['psid']."  </span></td>";
	$records.="<td style='width: 250px;'> Name </td>";
	$records.="<td style='width: 250px;'> Proposed Budget </td> ";
	$records.="<td><input type='text' value=".$row['cost']." /><a href='#' ><img class='updateBudget' src='images/update.png' alt='' title='' border='0'></a></td>";
	//$records.='<td><a href="#" ><img class="updateBudget" src="images/update.png" alt="" title="" border="0"></a></td>';
//	$records.="<td><a href='#' style='background :url(images/update.png)'></a></td>";
	
	$records.="</tr>";
            
} 
mysql_close();
return $records;

?>