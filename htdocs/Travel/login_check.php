<?php
/*$host="10.6.50.29"; // Host name
//$host="localhost";
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
*/
include 'DB_details.php';
//$db_name="travel"; // Database name
$tbl_name="user"; // Table name
session_start();

// Connect to server and select database.
mysql_connect("$host", "$mysql_userName", "$mysql_password")or
die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");

// username and password sent from form
$userName=$_POST['userName'];
$password=$_POST['password'];

// To protect MySQL injection (more detail about MySQL injection)
$userName = stripslashes($userName);
$password = stripslashes($password);
//echo "CheckPoint1";

$myusername = mysql_real_escape_string($userName);
$mypassword = mysql_real_escape_string($password);

$sql="SELECT * FROM $tbl_name WHERE username='$myusername' and 
password='$mypassword'";
$result=mysql_query($sql);

$count=mysql_num_rows($result);

if($count==1){
				$_SESSION['username']=$myusername;
				$sql="SELECT idsupervisor FROM $tbl_name WHERE username='".$myusername."' and password='".$mypassword."';";
				$result=mysql_query($sql);
				
				$count=mysql_num_rows($result);
				if($count==1){
					$sql="SELECT username FROM $tbl_name WHERE iduser='".mysql_result($result,0,"idsupervisor")."' ;";
					$result=mysql_query($sql);
					$supervisor=mysql_result($result,0,"username");
					$_SESSION['supervisor']=$supervisor;
					
					$_SESSION['reportCount']=0;
					$sql="SELECT active FROM $tbl_name WHERE username='".$myusername."' and 
					password='".$mypassword."';";
					$result=mysql_query($sql);
					$count=mysql_num_rows($result);
						if($count==1){
							$active=mysql_result($result,0,"active");
							//echo $active;
							//echo $result;
							if($active>=1){
								$sql="SELECT iduser,psid,idprofile,idsecurityquestion FROM $tbl_name WHERE username='".$myusername."' and 
								password='".$mypassword."';";
								$result=mysql_query($sql);
								$count=mysql_num_rows($result);
								if($count==1){
									$securityid=mysql_result($result,0,"idsecurityquestion");
									$idprofile=mysql_result($result,0,"idprofile");
									$psid=mysql_result($result,0,"psid");
									$userid=mysql_result($result,0,"iduser");
									$sql="SELECT profilename FROM profile WHERE idprofile='".$idprofile."' ;";
									error_log("++sql=".$sql);
									$result=mysql_query($sql);
									
									$profile=mysql_result($result,0,"profilename");
									//echo $profile;
									error_log("profile=".$profile);
									$_SESSION['profile']=$profile;
									$_SESSION['profile']=$profile;
									$_SESSION['iduser']=$userid;
									$_SESSION['psid']=$psid;
									$_SESSION['loginCount'] = 0; 
									$result=mysql_query($sql);
									
									
									
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
									error_log($total_sql);	
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
									
									mysql_close();
									
									
									
									echo "success";
								}else{
									mysql_close();
									//`profile` field error
									echo "error";
								}
							}else if($active<=0){
								mysql_close();
								echo "inactive";
							}
						}else{
								mysql_close();
								//`active` field error
								echo "error";
							}
				}else{
					mysql_close();
				    //`supervisor` field error
					echo "error";	
				}

}
else {
		$_SESSION['username'] = '';
		//header("Location:login.php");
		mysql_close();
		echo "fail";
}
?>