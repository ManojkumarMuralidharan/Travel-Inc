<?php
$host="10.6.50.26"; // Host name
//$host="localhost";
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="login"; // Table name
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
				$sql="SELECT supervisor FROM $tbl_name WHERE username='".$myusername."' and password='".$mypassword."';";
				$count=mysql_num_rows($result);
				if($count==1){
					$supervisor=mysql_result($result,0,"supervisor");
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
								$sql="SELECT profile,securityid FROM $tbl_name WHERE username='".$myusername."' and 
								password='".$mypassword."';";
								$result=mysql_query($sql);
								$count=mysql_num_rows($result);
								if($count==1){
									$profile=mysql_result($result,0,"profile");
									$securityid=mysql_result($result,0,"securityid");
									//echo $profile;
									$_SESSION['profile']=$profile;
									$_SESSION['securityId']=$securityid;
									
									$result=mysql_query($sql);
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




//session_register("myusername");
//session_register("mypassword");
//header("location:home.php");
//echo "success";
}
else {
		$_SESSION['username'] = '';
		//header("Location:login.php");
		mysql_close();
		echo "fail";
}
?>