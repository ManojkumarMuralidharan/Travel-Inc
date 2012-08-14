<?php
class DB_Authentication{

private $host; // Host name
private $mysql_userName; // Mysql username
private $mysql_password; // Mysql password
private $db_name; // Database name
private $tbl_name; // Table name

public function initialize_db_vars(){
$this->host="10.6.50.26"; // Host name
$this->mysql_userName="Manoj"; // Mysql username
$this->mysql_password="ITC"; // Mysql password
$this->db_name="db1"; // Database name
$this->tbl_name="login"; // Table name
}

public function check_user($userName,$password){

$this->initialize_db_vars();
	// Connect to server and select database.
mysql_connect("$this->host", "$this->mysql_userName", "$this->mysql_password")or
die("cannot connect");
mysql_select_db("$this->db_name")or die("cannot select DB");

// username and password sent from form
//$userName=$_POST['userName'];
//$password=$_POST['password'];

// To protect MySQL injection (more detail about MySQL injection)
$userName = stripslashes($userName);
$password = stripslashes($password);

$this->myusername = mysql_real_escape_string($userName);
$this->mypassword = mysql_real_escape_string($password);

$sql="SELECT * FROM `$this->db_name`.`$this->tbl_name` WHERE username='$this->myusername' and 
password='$this->mypassword'";
$result=mysql_query($sql);



$count=mysql_num_rows($result);

if($count==1){

				$_SESSION['username']=$this->myusername;
				$sql="SELECT supervisor FROM '$this->db_name'.'$this->tbl_name' WHERE username='".$this->myusername."' and password='".$this->mypassword."';";
				$count=mysql_num_rows($result);
				if($count==1){
					$supervisor=mysql_result($result,0,"supervisor");
					$_SESSION['supervisor']=$supervisor;
					$_SESSION['reportCount']=0;
					$sql="SELECT active FROM $this->tbl_name WHERE username='".$this->myusername."' and 
					password='".$this->mypassword."';";
					$result=mysql_query($sql);
					$count=mysql_num_rows($result);
						if($count==1){
							$active=mysql_result($result,0,"active");
							//echo $active;
							//echo $result;
							if($active>=1){
								$sql="SELECT profile,securityid FROM $this->tbl_name WHERE username='".$this->myusername."' and 
								password='".$this->mypassword."';";
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
									return 1;
								}else{
									mysql_close();
									//`profile` field error
									return -4;
								}
							}else if($active<=0){
								mysql_close();
								return 2;
							}
						}else{
								mysql_close();
								//`active` field error
								return -3;
							}
				}else{
					mysql_close();
				    //`supervisor` field error
					return -2;
				}
		}
		else {
				$_SESSION['username'] = '';
				//header("Location:login.php");
				mysql_close();
				return -1;
		}




}


public function fetchUserRecords($userName){


mysql_connect("$this->host", "$this->mysql_userName", "$this->mysql_password")or
die("cannot connect");
mysql_select_db("$this->db_name")or die("cannot select DB");

$sql="SELECT * FROM `$this->db_name`.`entry` WHERE username='".$userName."' AND (`approval` like 'WIP' OR `approval` like 'On Hold' OR `approval` like 'Declined');  ";
echo $sql;

$result=mysql_query($sql);

$count=mysql_num_rows($result);
//$_SESSION['userRecordCount']=$count;

$records=array();
$row_count=0;
$declinedRecords="";
$row_class="";
while($row = mysql_fetch_assoc($result))
{
	$records[$row_count++]= array( 'id'=> $row['id'] , 'fromdate'=> $row['fromdate'] , 'todate'=> $row['todate'],'placefrom'=> $row['placefrom'], 'placeto'=> $row['placeto'], 'traveltype'=> $row['traveltype'],'cost'=> $row['cost'], 'purpose'=> $row['purpose'],'approval'=> $row['approval']);
} 
mysql_close();
return json_encode($records);

}

public function fetchSupervisorRecords($userName){


mysql_connect("$this->host", "$this->mysql_userName", "$this->mysql_password")or
die("cannot connect");
mysql_select_db("$this->db_name")or die("cannot select DB");

$sql="SELECT * FROM `$this->db_name`.`entry` WHERE supervisor='".$userName."' AND (`approval` like 'WIP' OR `approval` like 'On Hold'); ";
echo $sql;

$result=mysql_query($sql);

$count=mysql_num_rows($result);
//$_SESSION['supervisorRecordCount']=$count;

$records=array();
$row_count=0;
$declinedRecords="";
$row_class="";
while($row = mysql_fetch_assoc($result))
{
	$records[$row_count++]= array( 'id'=> $row['id'] , 'fromdate'=> $row['fromdate'] , 'todate'=> $row['todate'],'placefrom'=> $row['placefrom'], 'placeto'=> $row['placeto'], 'traveltype'=> $row['traveltype'],'cost'=> $row['cost'], 'purpose'=> $row['purpose'],'approval'=> $row['approval']);
} 
mysql_close();
return json_encode($records);

}





}

?>