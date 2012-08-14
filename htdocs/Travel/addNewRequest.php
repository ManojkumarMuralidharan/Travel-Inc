<?php

require('Smarty.class.php');
include 'sendMail.php';
session_start();
/*
$host="10.6.50.29"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password*/

include 'DB_details.php';

//$db_name="travel"; // Database name
$tbl_name="expenserecords"; // Table name

$requestTravelType=$_POST["travelType"];
if($requestTravelType=='Domestic'){
$requestTravelType='Local';
}
$requestTravelSource=$_POST["source"];
$requestTravelDestination=$_POST["destination"];
$requestTravelFromDate=$_POST["fromDate"];
$requestTravelToDate=$_POST["ToDate"];
$requestTravelPurpose=$_POST["purpose"];
$requestTravelCost=$_POST["cost"];
$requestTravelComments=$_POST["comments"];

$userName=$_SESSION['username'];

mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");

error_log('\n Before \n'.$userName.",".$requestTravelType.','.$requestTravelSource.",".$requestTravelDestination.",".$requestTravelFromDate.",".$requestTravelToDate.",".$requestTravelPurpose.",".$requestTravelCost.",".$requestTravelComments, 0);

// To protect MySQL injection (more detail about MySQL injection)

$requestTravelType=stripslashes($requestTravelType);
$requestTravelSource=stripslashes($requestTravelSource);
$requestTravelDestination=stripslashes($requestTravelDestination);
$requestTravelFromDate=stripslashes($requestTravelFromDate);
$requestTravelToDate=stripslashes($requestTravelToDate);
$requestTravelPurpose=stripslashes($requestTravelPurpose);
$requestTravelCost=stripslashes($requestTravelCost);
$requestTravelComments=stripslashes($requestTravelComments);

$requestTravelType=mysql_real_escape_string($requestTravelType);
$requestTravelSource=mysql_real_escape_string($requestTravelSource);
$requestTravelDestination=mysql_real_escape_string($requestTravelDestination);
$requestTravelFromDate=mysql_real_escape_string($requestTravelFromDate);
$requestTravelToDate=mysql_real_escape_string($requestTravelToDate);
$requestTravelPurpose=mysql_real_escape_string($requestTravelPurpose);
$requestTravelCost=mysql_real_escape_string($requestTravelCost);
$requestTravelComments=mysql_real_escape_string($requestTravelComments);
//error_log('\nAfter \n'.$requestTravelType.','.$requestTravelSource.",".$requestTravelDestination.",".$requestTravelFromDate.",".$requestTravelToDate.",".$requestTravelPurpose.",".$requestTravelCost.",".$requestTravelComments, 0);

$supervisor=$_SESSION['supervisor'];


//$requestTravelToDate=str_replace("/","-",$requestTravelToDate);
//$requestTravelFromDate=str_replace("/","-",$requestTravelFromDate);

//Get User Id
$sql="SELECT iduser FROM user WHERE username='$userName' ";
$result=mysql_query($sql);
$count=mysql_num_rows($result);
$iduser=mysql_result($result,0,"iduser");


//Get TravelType Id
$sql="SELECT idtraveltype FROM traveltype WHERE `type`='$requestTravelType' ;";
$result=mysql_query($sql);
$traveltypeId=mysql_result($result,0,"idtraveltype");

//Get Workflow Id
$sql="SELECT idworkflow FROM workflow WHERE workflowname='$requestTravelType' AND `stage` = 0 ";
$result=mysql_query($sql);
$workflowId=mysql_result($result,0,"idworkflow");


//Check for Duplicate Record
$sql="SELECT * FROM  $tbl_name WHERE  `iduser` LIKE  '".$iduser."' AND `fromdate` LIKE  '".$requestTravelFromDate."' AND `todate` LIKE  '".$requestTravelToDate."' AND `placefrom` LIKE  '".$requestTravelSource."' AND `placeto` LIKE  '".$requestTravelDestination."' AND `comments` LIKE '".$requestTravelPurpose."' AND `cost` LIKE '".$requestTravelCost."'  AND `idtraveltype` LIKE '".$traveltypeId."' AND `approval` LIKE 'WIP' AND `stage` = 0 ;";

error_log($sql);




$result=mysql_query($sql);

$count=mysql_num_rows($result);
if($count>=1){
echo "recordexists";
}else{

$fromDate=date("Y-m-d",strtotime($requestTravelFromDate));
$toDate=date("Y-m-d",strtotime($requestTravelToDate));
$requestTravelFromDate=date("Y-m-d",strtotime($requestTravelFromDate));
$requestTravelToDate=date("Y-m-d",strtotime($requestTravelToDate));

$sql="SELECT MAX(`idexpenserecords`) as `expenseId` FROM expenserecords ;";
$result=mysql_query($sql);
$expenseId=0;
if($result){
$expenseId=mysql_result($result,0,"expenseId")+1;
}
$sql="INSERT INTO ".$tbl_name."(`idexpenserecords`,`idUser`, `fromdate`, `todate`, `placefrom`, `placeto`, `reason`, `approval`, `idtraveltype`, `cost`, `comments`, `stage`) VALUES ('".$expenseId."','".$iduser."','".$requestTravelFromDate."','".$requestTravelToDate."','".$requestTravelSource."','".$requestTravelDestination."','','WIP','".$traveltypeId."','".$requestTravelCost."','".$requestTravelComments."','0');";


error_log($sql);

	if (!mysql_query($sql))
	  {
	  die('Error: ' . mysql_error());
	  echo "fail";
	  exit;
	  }else{
	//	echo "success";
	  }

$sql_idworkflow="SELECT Max(`idexpenseworkflow`) as nextID FROM expenseworkflow";
$result=mysql_query($sql_idworkflow);
//if($result){
$count=mysql_num_rows($result);
if($count>=1){
$idexpenseworkflow=mysql_result($result,0,"nextID")+1;
}else{
$idexpenseworkflow=1;
}


$sql="SELECT idprofile FROM user WHERE username='$userName' ";
$result=mysql_query($sql);
$count=mysql_num_rows($result);
$idprofile=mysql_result($result,0,"idprofile");

$sql="INSERT INTO expenseworkflow(`idexpenseworkflow` ,`idworkflow` ,`stage` ,`idactionuser` ,`action` ,`idexpenserecords` ,`comments`) VALUES ('".$idexpenseworkflow."','".$traveltypeId."','0','".$iduser."','submitted request','".$expenseId."','".$requestTravelComments."');";


//check action


//check mail


	error_log($sql);

	if (!mysql_query($sql))
	  {
	  die('Error: ' . mysql_error());
	  echo "fail";
	  }else{
	  
	  //To user
	  //$to="Manojkumar.Muralidharan@itcinfotech.com";
	  $to=$userName;
	  
	  $subject="Request submitted";

	  $body="<div><span>Hi , </br></span></div>";
	  $body.="<div><span>A travel request( ID:".$expenseId." ) for ".$requestTravelSource." to ".$requestTravelDestination." has been successfully submitted </span></div></br><div style='height:20px'></div>";
	  $body.='<div><table id="mt" class="rounded-corner" summary="2007 Major IT Companies Profit" style="font-size:11px;margin:0px;width:635px;text-align: left;border-collapse: collapse;">
		<thead style="padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #60c8f2;text-align:center;">
    	<tr>
            <th scope="col" class="rounded-company" style="border-top-left-radius: 10px 10px;width:26px; background: #60c8f2;">Start Date</th>
            <th scope="col" class="rounded">End Date</th>
            <th scope="col" class="rounded">Source</th>
			<th scope="col" class="rounded">Destination</th>
			<th scope="col" class="rounded">TravelType</th>
			<th scope="col" class="rounded-q4" style="background: #60c8f2;border-top-right-radius: 10px 10px;width:26px;">Cost</th>
        </tr>
        </thead>
		<tfoot>
    	<tr>
        	<td colspan="5" class="rounded-foot-left" style="background: #ecf8fd;border-bottom-left-radius: 10px 10px;"><em></em></td>
        	<td class="rounded-foot-right" style="background: #ecf8fd;border-bottom-right-radius: 10px 10px;">&nbsp;</td>

        </tr>
		</tfoot>
    <tbody id="">
        
    	<tr style="text-align:center;padding: 8px;background: #ecf8fd;border-top: 1px solid #fff;color: #669;">
            <td>'.$requestTravelFromDate.'</td>
            <td>'.$requestTravelToDate.'</td>
			<td>'.$requestTravelSource.'</td>			
			<td>'.$requestTravelDestination.'</td>
			<td>'.$requestTravelType.'</td>
            <td>'.$requestTravelCost.'$</td>
            </tr>
    </tbody>
	</table></div>';
	$body.='<div style="margin-top:20px">regards,</div>';
	$body.='<div style="margin-top:0px">I2A Travel</div>';
	
	 // $body=" Your travel request for ".$requestTravelSource." to ".$requestTravelDestination." has been successfully submitted and the request Id is ".$idexpenseworkflow;
	  sendMail($to,$body,$subject);
	  
	  
	  
	  //To Supervisor
	 //  $to="Manojkumar.Muralidharan@itcinfotech.com";
	 // $to="sayali.jawdekar@itcinfotech.com";
	  $to=$_SESSION['supervisor'];
	  $subject="New Request submitted";
	  
	  $body="<div><span>Hi , </br></span></div>";
	  $body.="<div><span>A travel request( ID:".$expenseId." ) for ".$requestTravelSource." to ".$requestTravelDestination." has been submitted by $userName</span></div></br><div style='height:20px'></div>";
	  $body.='<div><table id="mt" class="rounded-corner" summary="2007 Major IT Companies Profit"
		style="font-size:12px;margin:0px;width:635px;text-align: left;border-collapse: collapse;">
		<thead style="padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #60c8f2;text-align:center;">
    	<tr>
            <th scope="col" class="rounded-company" style="border-top-left-radius: 10px 10px;width:26px; background: #60c8f2;">Start Date</th>
            <th scope="col" class="rounded">End Date</th>
            <th scope="col" class="rounded">Source</th>
			<th scope="col" class="rounded">Destination</th>
			<th scope="col" class="rounded">TravelType</th>
			<th scope="col" class="rounded-q4" style="background: #60c8f2;border-top-right-radius: 10px 10px;width:26px;">Cost</th>
        </tr>
        </thead>
        <tfoot>
    	<tr>
        	<td colspan="5" class="rounded-foot-left" style="background: #ecf8fd;border-bottom-left-radius: 10px 10px;"><em></em></td>
        	<td class="rounded-foot-right" style="background: #ecf8fd;border-bottom-right-radius: 10px 10px;">&nbsp;</td>

        </tr>
		</tfoot>
    <tbody id="userRecordBody">
        
    	<tr style="text-align:center;padding: 8px;background: #ecf8fd;border-top: 1px solid #fff;color: #669;">
			<td>'.$requestTravelFromDate.'</td>
            <td>'.$requestTravelToDate.'</td>
			<td>'.$requestTravelSource.'</td>			
			<td>'.$requestTravelDestination.'</td>
			<td>'.$requestTravelType.'</td>
            <td>'.$requestTravelCost.'$</td>
            </tr>
    </tbody>
	</table></div>';
	$body.='<div style="margin-top:20px">regards,</div>';
	$body.='<div style="margin-top:0px">I2A Travel</div>';
	  sendMail($to,$body,$subject);
	  
	  
		echo "success";
	  }
}

?>