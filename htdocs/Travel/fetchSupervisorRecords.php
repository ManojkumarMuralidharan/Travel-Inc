<?php

/*
$host="10.6.50.29"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
*/
include 'DB_details.php';
//$db_name="travel"; // Database name
$tbl_name="expenserecords"; // Table name

//$recordType=$_GET[
$userName=$_SESSION["username"];

//error_log($userName.$supervisorName.$userType, 0);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");


//Get User Id
$sql="SELECT iduser,idprofile FROM user WHERE username='$userName' ";
$result=mysql_query($sql);
$count=mysql_num_rows($result);
$iduser=mysql_result($result,0,"iduser");
$idsupervisorprofile=mysql_result($result,0,"idprofile");

if($idsupervisorprofile==3){
$sql="SELECT iduser FROM user WHERE iduser!='".$iduser."' ; ";
}else{
$sql="SELECT iduser FROM user WHERE idsupervisor='".$iduser."' ; ";
}
error_log($sql);

	$resultUsers=mysql_query($sql);

	$count=mysql_num_rows($result);
	$_SESSION['supervisorRecordCount']=0;
	$records="";

while($rowUsers = mysql_fetch_array($resultUsers)) {

    $sql="SELECT * FROM $tbl_name WHERE iduser='".$rowUsers['iduser']."' AND (`approval` like 'WIP' OR `approval` like 'On Hold') ORDER BY `idexpenserecords` DESC ; ";
	
	error_log($sql);

	$result=mysql_query($sql);
	$count=mysql_num_rows($result);
	$_SESSION['supervisorRecordCount']+=$count;

	$user_sql="SELECT `firstname` FROM user WHERE iduser='".$rowUsers['iduser']."'";
	$user_result=mysql_query($user_sql);
	$user_name=mysql_result($user_result,0,"firstname");
	$user_name=explode('@', $user_name, 2);
	
	while($row = mysql_fetch_assoc($result))
	{
	
	$sql="SELECT `idtraveltype`,`stage` FROM expenserecords WHERE `idexpenserecords`='".$row['idexpenserecords']."' ;";
	error_log($sql);
	$sub_result=mysql_query($sql);
	$idtravelType=mysql_result($sub_result,0,"idtraveltype");
	$idStage=mysql_result($sub_result,0,"stage");
	
	$sql="SELECT `idprofile`,`action` FROM workflow WHERE `idworkflow` = '".$idtravelType."' AND `stage`='".$idStage."' ;";
	
	error_log("test".$sql);
	$sub_result=mysql_query($sql);
	$workflowProfile=mysql_result($sub_result,0,"idprofile");
	$action=mysql_result($sub_result,0,"action");
	
		if($idsupervisorprofile==$workflowProfile&&$action==1){	
	
				$records.="<tr>
				<td><input type='checkbox' name='supervisorRecordsCheckbox' /></td><td class='requestInformation'>";
				if($row['approval']=='On Hold'){
				$records.="<img src='images\onhold.gif'  alt='' title='' border='0' /> #<span style='text-decoration:underline;' id='".$row['idexpenserecords']."'>".$row['idexpenserecords']."</span></td>";
				}else{
				$records.="<img src='images\wip.gif'  alt='' title='' border='0' /> #<span style='text-decoration:underline;' id='".$row['idexpenserecords']."'>".$row['idexpenserecords']."</span></td>";
				}
				$records.="<td>".$row['fromdate']."</td>
				<td>".$row['todate']."</td>
				<td>".$row['placefrom']."</td>			
				<td>".$row['placeto']."</td>";
			if($row['idtraveltype']==1){
			$records.="<td ".$declinedRecords.">"."Domestic"."</td>";			
			}else if($row['idtraveltype']==2){
			$records.="<td ".$declinedRecords.">"."International"."</td>";
			}else{
			$records.="<td ".$declinedRecords.">"."Unknown"."</td>";
			}
            $records.="<td>$".$row['cost']."</td>
				<td>".$user_name[0]."</td>
				<td><a href='#' id='".$row['idexpenserecords']."' class='reasonsDisplay'><img src='images/request_comment.png' alt=' title='' border='0' /></a></td>
				<td><a href='#' class='del'><img src='images/trash.png' alt='' title='' border='0' /></a></td></tr>";
		}
	} 
		
   
}


mysql_close();
return $records;

?>