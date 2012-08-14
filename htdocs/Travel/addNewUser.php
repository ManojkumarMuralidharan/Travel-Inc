<?php

require('Smarty.class.php');
include 'sendMail.php';
session_start();
/*
$host="10.6.50.29"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
*/
include 'DB_details.php';
//$db_name="travel"; // Database name
$tbl_name="user"; // Table name

$supervisor_userName=$_SESSION['username'];

$userName=$_POST["userName"];
$supervisorName=$_POST["supervisor"];
$userType=$_POST["userType"];
$psid=$_POST["psid"];
$firstName=$_POST["firstName"];
$lastName=$_POST["lastName"];
$password=include 'randomPassword.php';
error_log($userName.$supervisorName.$userType, 0);

// To protect MySQL injection (more detail about MySQL injection)
$userName = stripslashes($userName);

$supervisorName=stripslashes($supervisorName);

$userType=stripslashes($userType);


//$userName = mysql_real_escape_string($userName);
//$supervisorName = mysql_real_escape_string($supervisorName);
//$userType = mysql_real_escape_string($userType);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

$sql="SELECT * FROM $tbl_name WHERE username='".$userName."' ;";
$result=mysql_query($sql);
$count=mysql_num_rows($result);
if($count>=1){
echo "userexists";
}else{

			$sql="SELECT * FROM $tbl_name WHERE username='".$supervisorName."' ;";
			$result=mysql_query($sql);
			$count=mysql_num_rows($result);
				if($count<=0){
					echo "supervisorError";
					exit;
				}else{
					while($row = mysql_fetch_assoc($result))
					{
					 if($row['idprofile']<2){
						echo "supervisorError";
						exit;
					 }
					} 
				}

	$sql="SELECT MAX(`iduser`) as nextId FROM user";
	$result=mysql_query($sql);	
	$iduser=mysql_result($result,0,"nextId")+1;
				
	$sql="SELECT iduser FROM user WHERE username='$supervisorName' ";
	$result=mysql_query($sql);
	$count=mysql_num_rows($result);
	$supervisorId=mysql_result($result,0,"iduser");
	
	
	if($userType=='user'){
	$idProfile=1;
	}else if($userType=='supervisor'){
	$idProfile=2;
	}
	
	$sql="INSERT INTO `user` (`iduser`, `username`, `firstname`, `lastname`, `password`, `idsupervisor`, `idsecurityquestion`, `idprofile`, `active`, `answer`, `psid`) VALUES ('".$iduser."','".$userName."',  '".$firstName."', '".$lastName."', '".$password."',  '".$supervisorId."',  '1',  '".$idProfile."','1','ITC','".$psid."');";
	
	//$sql="INSERT INTO login VALUES (value1, value2, value3,...);"

	if (!mysql_query($sql))
	  {
	  die('Error: ' . mysql_error());
	  mysql_close();
	  echo "fail";
	  }else{
		//mysql_close();
		
	  $to=$supervisor_userName;
		
	  $subject="New User created";

	  $body="<div><span>Hi , </br></span></div>";
	  $body.="<div><span>A new user( PSID:".$psid."    User Name : ".$userName." ) has been successfully created.</span></div></br><div style='height:20px'></div>";
		$body.='<div style="margin-top:20px">regards,</div>';
		$body.='<div style="margin-top:0px">I2A Travel</div>';
	
	  sendMail($to,$body,$subject);
	  
	  
	  $to=$userName;
	  $body="<div><span>Hi , </br></span></div>";
	  $body.="<div><span>Your account ( PSID:".$psid." ) has been successfully added to Travel+ system. Your UserID is ".$userName.". Your password is  ".$password.". Kindly change password after first login. </span></div></br><div style='height:20px'></div>";
	  $body.='<div style="margin-top:20px">regards,</div>';
	  $body.='<div style="margin-top:0px">I2A Travel</div>';
	
	  sendMail($to,$body,$subject);
		
		//echo "success";
	  }
	  

	  $sql="INSERT INTO `budget` (`iduser`, `proposedbudget`, `fiscalyear`, `psid`) VALUES ('".$iduser."','24000',  '2012-2013','".$psid."');";
	 error_log($sql);
	if (!mysql_query($sql))
	  {
	  die('Error: ' . mysql_error());
	  mysql_close();
	  echo "fail";
	  }else{
		mysql_close();
		echo "success";
	 }
		
	  
	  
}
?>