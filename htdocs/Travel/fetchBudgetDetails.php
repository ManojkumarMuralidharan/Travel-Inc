<?php
<<<<<<< HEAD
/*
$host="10.6.50.29"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
*/
include 'DB_details.php';
//$db_name="travel"; // Database name
$tbl_name="peoplesoftdata"; // Table name
=======

$host="localhost"; // Host name
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
//$sql="SELECT  SUM(`cost`) as cost, `psid` FROM `peoplesoftdata` GROUP BY `psid` ; ";
$sql="SELECT `proposedbudget`,`fiscalyear`,`psid` FROM `budget` GROUP BY `psid` ;";
=======
$sql="SELECT  SUM(`cost`) as cost, `psid` FROM `db1`.`peoplesoftdata` GROUP BY `psid` ; ";
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
error_log($sql);

$result=mysql_query($sql);
$count=0;
$count=mysql_num_rows($result);
$_SESSION["budgetUserCount"]=$count;
$records="";
while($row = mysql_fetch_assoc($result))
{
<<<<<<< HEAD
	$sub_sql="SELECT `username`,`iduser` FROM `user` WHERE psid = ".$row['psid'];
	$sub_result=mysql_query($sub_sql);
	$name=mysql_result($sub_result,0,"username");
	$userid=mysql_result($sub_result,0,"iduser");

	
	$propsed_sql="SELECT SUM( `cost` ) as cost FROM  `expenserecords` WHERE idUser =  '".$userid."' AND `approval` = 'approved'";
	$propsed_result=mysql_query($propsed_sql);
	$proposed_cost=mysql_result($propsed_result,0,"cost");
	if(!$proposed_cost){
	$proposed_cost=0;
	}
	
	$actual_sql="SELECT SUM( `cost` ) as cost FROM  `peoplesoftdata` WHERE psid =  '".$row['psid']."'";
	$actual_result=mysql_query($actual_sql);
	$actual_cost=mysql_result($actual_result,0,"cost");
	if(!$actual_cost){
	$actual_cost=0;
	}
	
	$records.="<tr><td style='width: 50px;'><span id='".$row['psid']."'> ".$row['psid']."  </span></td>";
	$records.="<td style='width: 250px;'>".$name."</td>";
	$records.="<td style='width: 250px;'>".$proposed_cost."</td> ";
	$records.="<td style='width: 250px;'>".$actual_cost."</td> ";
	$records.="<td style='width: 250px;'>".$row['fiscalyear']."</td> ";
	$records.="<td><input type='text' value=".$row['proposedbudget']." /><a href='#' ></td>";
	$records.="<td><img class='updateBudget' src='images/update.png' alt='' title='' border='0'></a></td>";
=======


	$records.="<tr><td style='width: 50px;'><span id='".$row['psid']."'> ".$row['psid']."  </span></td>";
	$records.="<td style='width: 250px;'> Name </td>";
	$records.="<td style='width: 250px;'> Proposed Budget </td> ";
	$records.="<td><input type='text' value=".$row['cost']." /><a href='#' ><img class='updateBudget' src='images/update.png' alt='' title='' border='0'></a></td>";
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
	//$records.='<td><a href="#" ><img class="updateBudget" src="images/update.png" alt="" title="" border="0"></a></td>';
//	$records.="<td><a href='#' style='background :url(images/update.png)'></a></td>";
	
	$records.="</tr>";
            
} 
mysql_close();
return $records;

?>