<?php

include 'DB_details.php';
//$db_name="travel"; // Database name
$tbl_name="expenserecords"; // Table name
require('Smarty.class.php');
include 'sendMail.php';
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
error_log($_SESSION['profile'].'-'.$_POST['reportUserName']);
	if($profile=='user'){
		$reportUserName=$_SESSION['username'];
	}else {
		$reportUserName=$_POST['reportUserName'];
	}
//error_log($userName.$supervisorName.$userType, 0);

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");


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
}

$sql.=" ;";

error_log($sql);


$result=mysql_query($sql);

$count=mysql_num_rows($result);

$_SESSION['reportCount']=$count;
$records='<table id="regularReports" class="rounded-corner"  style="font-size:11px;margin:0px;width:635px;text-align: left;border-collapse: collapse;">
		<thead style="padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #60c8f2;text-align:center;">
    	<tr>
            <th scope="col" class="rounded-company" style="border-top-left-radius: 10px 10px;width:26px; background: #60c8f2;">ID</th>
            <th scope="col" class="rounded">Start Date</th>
			<th scope="col" class="rounded">End Date</th>
            <th scope="col" class="rounded">Source</th>
			<th scope="col" class="rounded">Destination</th>
			<th scope="col" class="rounded">TravelType</th>
			<th scope="col" class="rounded-q4" style="background: #60c8f2;border-top-right-radius: 10px 10px;width:26px;">Cost</th>
        </tr>
        </thead>
		<tfoot>
    	<tr>
        	<td colspan="6" class="rounded-foot-left" style="background: #ecf8fd;border-bottom-left-radius: 10px 10px;"><em></em></td>
        	<td class="rounded-foot-right" style="background: #ecf8fd;border-bottom-right-radius: 10px 10px;">&nbsp;</td>

        </tr>
		</tfoot>
    <tbody style="text-align:center">';
//if($type=='excelReport'){
//$rows=array();
//}
$i=0;
//$declinedRecords="<table>";
while($row = mysql_fetch_assoc($result))
{

if($row['approval']=='declined'){

$declinedRecords=" class='declined' style='background:#FA5050;color:#FFFFFF'";
}else if($row['approval']=='Approved'){
$declinedRecords="style='background:#BEF781;color:#000000'";
}
else{
$declinedRecords="";
}
			
			$records.="<tr style='text-align:center;padding: 8px;background: #ecf8fd;border-top: 1px solid #fff;color: #669;'> <td ".$declinedRecords.">";
			if($row['approval']=='On Hold'){
			$records.="#".$row['idexpenserecords']."</td>";
			}else if($row['approval']=='WIP'){
			$records.="#".$row['idexpenserecords']."</td>";
			}else if($row['approval']=='declined'){
			$records.="#".$row['idexpenserecords']."</td>";
			}else{
			$records.="#".$row['idexpenserecords']."</td>";
			}
            $records.="<td ".$declinedRecords.">".$row['fromdate']."</td>
            <td ".$declinedRecords.">".$row['todate']."</td>
			<td ".$declinedRecords.">".$row['placefrom']."</td>			
			<td ".$declinedRecords.">".$row['placeto']."</td>
			<td ".$declinedRecords.">".$row['idtraveltype']."</td>
            <td ".$declinedRecords.">".$row['cost']."$</td>
        
            </tr>";

} 
$records.="</tbody></table>";
//if($type=='excelReport'){
//echo $rows;
//}else
//$records;
	  
$to="Manojkumar.Muralidharan@itcinfotech.com";
	 // $to="sayali.jawdekar@itcinfotech.com";
	  //$to=$userName;
	  $subject="Reports exported";
	  $body="<div><span>Hi , </br></span></div>";
	  $body.="<div><span> The following are the reports made by ".$reportUserName." between ".$fromDate." and ".$toDate."</span></div><div>";
	  $body.=$records."</div>";
	  $body.='<div style="margin-top:20px">regards,</div>';
	  $body.='<div style="margin-top:0px">I2A Travel</div>';
	  sendMail($to,$body,$subject);
	  
?>