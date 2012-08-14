<?php
<<<<<<< HEAD
/*
$host="10.6.50.29"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
*/
require('Smarty.class.php');
include 'DB_details.php';
//$db_name="travel"; // Database name
$tbl_name="expenserecords"; // Table name
=======

$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="entry"; // Table name
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
session_start();
header("Content-Type: text/plain");
//$recordType=$_GET[
$userName=$_SESSION['username'];
//$type='jhy';
$type=$_POST['reportType'];

$fromDate=$_POST['fromDate'];
$toDate=$_POST['toDate'];

$fromDate=date("Y-m-d",strtotime($fromDate));
$toDate=date("Y-m-d",strtotime($toDate));


$travelType=$_POST['travelType'];

$profile=$_SESSION['profile'];
$reportUserName='';
<<<<<<< HEAD
error_log($_SESSION['profile'].'-'.$_POST['reportUserName']);
	if($profile=='user'){
		$reportUserName=$_SESSION['username'];
	}else {
		$reportUserName=$_POST['reportUserName'];
=======
	if($profile=='supervisor'){
		$reportUserName=$_POST['reportUserName'];
	}else if($profile=='user'){
		$reportUserName=$_SESSION['username'];
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
	}
//error_log($userName.$supervisorName.$userType, 0);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

<<<<<<< HEAD

//Get User Id
$sql="SELECT `iduser` FROM user WHERE username='$reportUserName' ";
error_log($sql);
$result=mysql_query($sql);
$count=mysql_num_rows($result);
$iduser=mysql_result($result,0,"iduser");

//Get TravelType Id
if($travelType!='both'){
$sql="SELECT idtraveltype FROM traveltype WHERE `type`='$travelType' ;";
$result=mysql_query($sql);
$traveltypeId=mysql_result($result,0,"idtraveltype");
}


$sql="SELECT * FROM $tbl_name WHERE idUser='".$iduser."' AND (`approval` like 'WIP' OR `approval` like 'On Hold' OR `approval` like 'Approved' OR `approval` like 'Declined')  ";

if($fromDate!=''&&$toDate!=''){
if($travelType!='both'){

$sql.=' AND `fromdate` BETWEEN "'.$fromDate.'" AND "'.$toDate.'" AND `idtraveltype` = '.$traveltypeId ;

}else
$sql.=' AND `fromdate` BETWEEN "'.$fromDate.'" AND "'.$toDate.'" AND (`idtraveltype` = 1 OR `idtraveltype` = 2) ';
=======
$sql="SELECT * FROM $tbl_name WHERE username='".$reportUserName."' AND (`approval` like 'WIP' OR `approval` like 'On Hold' OR `approval` like 'Approved' OR `approval` like 'Declined')  ";

if($fromDate!=''&&$toDate!=''){
if($travelType!='both')
$sql.=' AND `fromdate` BETWEEN "'.$fromDate.'" AND "'.$toDate.'" AND `traveltype` like "'.$travelType.'" ';
else
$sql.=' AND `fromdate` BETWEEN "'.$fromDate.'" AND "'.$toDate.'" AND (`traveltype` like "local" OR `traveltype` like "international") ';
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
}

$sql.=" ;";

error_log($sql);


$result=mysql_query($sql);

$count=mysql_num_rows($result);

$_SESSION['reportCount']=$count;
<<<<<<< HEAD
$smarty = new Smarty();
$smarty->assign('reportCount',$count);
=======
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
$records="";
//if($type=='excelReport'){
//$rows=array();
//}
$i=0;
while($row = mysql_fetch_assoc($result))
{

<<<<<<< HEAD
if($row['approval']=='declined'){
=======
if($row['approval']=='Declined'){
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e

$declinedRecords=" class='declined' style='background:#FA5050;color:#FFFFFF'";
}else if($row['approval']=='Approved'){
$declinedRecords="style='background:#BEF781;color:#000000'";
}
else{
$declinedRecords="";
}
			
			$records.="<tr> <td ".$declinedRecords.">";
			if($row['approval']=='On Hold'){
<<<<<<< HEAD
			$records.="<img src='images\onhold.gif'  alt='' title='' border='0' /> #".$row['idexpenserecords']."</td>";
			}else if($row['approval']=='WIP'){
			$records.="<img src='images\wip.gif'  alt='' title='' border='0' /> #".$row['idexpenserecords']."</td>";
			}else if($row['approval']=='declined'){
			$records.="<img src='images\denied.gif'  alt='' title='' border='0' /> #".$row['idexpenserecords']."</td>";
			}else{
			$records.="<img src='images\approved.png'  alt='' title='' border='0' /> #".$row['idexpenserecords']."</td>";
			}
            $records.="<td ".$declinedRecords.">".$row['fromdate']."</td>
            <td ".$declinedRecords.">".$row['todate']."</td>
			<td ".$declinedRecords.">".$row['placefrom']."</td>			
			<td ".$declinedRecords.">".$row['placeto']."</td>";
			if($row['idtraveltype']==1){
			$records.="<td ".$declinedRecords.">"."Domestic"."</td>";			
			}else if($row['idtraveltype']==2){
			$records.="<td ".$declinedRecords.">"."International"."</td>";
			}else{
			$records.="<td ".$declinedRecords.">"."Unknown"."</td>";
			}
            $records.="<td ".$declinedRecords.">$".$row['cost']."</td>
            <td ".$declinedRecords.">".$row['comments']."</td>
            <td ".$declinedRecords."><a href='#' id='".$row['idexpenserecords']."' class='reportCommentsDisplay'><img src='images/request_comment.png' alt=' title='' border='0' /></a></td>
            </tr>";

} 
$records.='<tr style="display:none;"><td colspan="8" style="width:835px;display:none" class="rounded-foot-left"><span id="reportCountHidden">Your have '.$count.' results</span></td></tr>';
=======
			$records.="<img src='images\onhold.gif'  alt='' title='' border='0' /> #".$row['id']."</td>";
			}else if($row['approval']=='WIP'){
			$records.="<img src='images\wip.gif'  alt='' title='' border='0' /> #".$row['id']."</td>";
			}else if($row['approval']=='Declined'){
			$records.="<img src='images\denied.gif'  alt='' title='' border='0' /> #".$row['id']."</td>";
			}else{
			$records.="<img src='images\approved.png'  alt='' title='' border='0' /> #".$row['id']."</td>";
			}
            $records.="<td ".$declinedRecords.">".$row['datefrom']."</td>
            <td ".$declinedRecords.">".$row['dateto']."</td>
			<td ".$declinedRecords.">".$row['placefrom']."</td>			
			<td ".$declinedRecords.">".$row['placeto']."</td>
			<td ".$declinedRecords.">".$row['traveltype']."</td>
            <td ".$declinedRecords.">".$row['cost']."$</td>
            <td ".$declinedRecords.">".$row['comments']."</td>
            <td ".$declinedRecords."><a href='#' id='".$row['id']."' class='reportCommentsDisplay'><img src='images/request_comment.png' alt=' title='' border='0' /></a></td>
            </tr>";

} 
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
//if($type=='excelReport'){
//echo $rows;
//}else
echo $records;

?>