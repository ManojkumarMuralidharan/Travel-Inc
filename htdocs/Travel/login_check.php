<?php
$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="login"; // Table name

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
echo "CheckPoint1";

$myusername = mysql_real_escape_string($userName);
$mypassword = mysql_real_escape_string($password);

$sql="SELECT * FROM $tbl_name WHERE username='$myusername' and 
password='$mypassword'";
$result=mysql_query($sql);

$count=mysql_num_rows($result);

if($count==1){
session_register("myusername");
session_register("mypassword");
header("location:home.php");
}
else {
echo "Wrong Username or Password";
}
?>