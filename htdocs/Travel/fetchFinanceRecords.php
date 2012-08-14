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


$sql="SELECT iduser FROM user WHERE idsupervisor='".$iduser."' ; ";

error_log($sql);

	$resultUsers=mysql_query($sql);

	$count=mysql_num_rows($result);
	$_SESSION['supervisorRecordCount']=0;
	$records="";

while($rowUsers = mysql_fetch_array($resultUsers)) {

    $sql="SELECT * FROM $tbl_name WHERE iduser='".$rowUsers['iduser']."' AND (`approval` like 'WIP' OR `approval` like 'On Hold'); ";
	
	error_log($sql);

	$result=mysql_query($sql);

	$count=mysql_num_rows($result);
	$_SESSION['supervisorRecordCount']+=$count;
error_log("---++++----");
	
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
	//error_log("---++++----");
		if($idsupervisorprofile>=$workflowProfile&&$action==1){	
		error_log("test".$sql);
			if($idtravelType==2&&$idStage>=1){
			continue;
			}
				$records.="<tr>
				<td><input type='checkbox' name='supervisorRecordsCheckbox' /></td><td>";
				if($row['approval']=='On Hold'){
				$records.="<img src='images\onhold.gif'  alt='' title='' border='0' /> #".$row['idexpenserecords']."</td>";
				}else{
				$records.="<img src='images\wip.gif'  alt='' title='' border='0' /> #".$row['idexpenserecords']."</td>";
				}
				$records.="<td>".$row['fromdate']."</td>
				<td>".$row['todate']."</td>
				<td>".$row['placefrom']."</td>			
				<td>".$row['placeto']."</td>
				<td>".$row['idtraveltype']."</td>
				<td>".$row['cost']."$</td>
				<td>".$row['reason']."</td>
				<td><a href='#' id='".$row['idexpenserecords']."' class='reasonsDisplay'><img src='images/request_comment.png' alt=' title='' border='0' /></a></td>
				<td><a href='#' class='del'><img src='images/trash.png' alt='' title='' border='0' /></a></td></tr>";
		
		error_log("-".$records."-");
		
		}
	} 
		
   
}


mysql_close();
return $records;

?>