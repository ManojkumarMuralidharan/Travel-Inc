<?php
include 'DB_details.php';
//$db_name="travel"; // Database name
$tbl_name="user"; // Table name
//session_start();

// Connect to server and select database.
mysql_connect("$host", "$mysql_userName", "$mysql_password")or
die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");


$userid=$_SESSION['iduser'];
$psid=$_SESSION['psid'];

									
									$propsed_sql="SELECT SUM( `cost` ) as cost FROM  `expenserecords` WHERE idUser =  '".$userid."' AND `approval` = 'approved'";
									$propsed_result=mysql_query($propsed_sql);
									$proposed_cost=mysql_result($propsed_result,0,"cost");
									if(!$proposed_cost){
									$proposed_cost=0;
									$currentBudget=0;
									}else{
									$currentBudget=$proposed_cost;
									}
	
									/*$actual_sql="SELECT SUM( `cost` ) as cost FROM  `peoplesoftdata` WHERE psid =  '".$row['psid']."'";
									$actual_result=mysql_query($actual_sql);
									$actual_cost=mysql_result($actual_result,0,"cost");
									if(!$actual_cost){
									$actual_cost=0;
									}*/
									
									$total_sql="SELECT `proposedbudget` FROM `budget` WHERE `psid` =".$psid." ;";
									//error_log($sql);	
									$total_result=mysql_query($total_sql);
									$total_cost=mysql_result($total_result,0,"proposedbudget");
									if(!$total_cost){
									$total_cost=0;
									$totalBudget=0;
									}else{
									$totalBudget=$total_cost;
									}
									
									$_SESSION['totalBudget']=$totalBudget;
									
									$_SESSION['currentBudget']=$currentBudget;
									


?>