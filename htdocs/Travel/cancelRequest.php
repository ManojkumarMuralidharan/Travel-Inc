<?php

require('Smarty.class.php');
session_start();

/*
$host="10.6.50.29"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
*/
include 'sendMail.php';
include 'DB_details.php';
//$db_name="travel"; // Database name
$tbl_name="expenserecords"; // Table name

$id_post=$_POST["id"];

$userName=$_SESSION['username'];
$supervisor=$_SESSION['supervisor'];

//echo $supervisor;

// To protect MySQL injection (more detail about MySQL injection)

//$id=stripslashes($id);


//$id=mysql_real_escape_string($id);
//error_log('\nAfter \n'.$requestTravelType.','.$requestTravelSource.",".$requestTravelDestination.",".$requestTravelFromDate.",".$requestTravelToDate.",".$requestTravelPurpose.",".$requestTravelCost.",".$requestTravelComments, 0);





mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");
//error_log($id_post);
//$id_array= explode(",", $id_post);


//Get User Id
$sql="SELECT iduser FROM user WHERE username='$userName' ";
$result=mysql_query($sql);
$count=mysql_num_rows($result);
$iduser=mysql_result($result,0,"iduser");

//error_log(print_r($id_post));

foreach ($id_post as $id) {
	
	$sql="SELECT * FROM  $tbl_name WHERE  `idexpenserecords` = '".$id."' AND `iduser` =  '".$iduser."' ;";
	error_log($sql);

	$result=mysql_query($sql);
	$count=mysql_num_rows($result);
	$idtraveltype=mysql_result($result,0,"idtraveltype");
	$stage=mysql_result($result,0,"stage");
	$user=mysql_result($result,0,"idUser");
	$placefrom=mysql_result($result,0,"placefrom");
	$placeto=mysql_result($result,0,"placeto");
	$fromdate=mysql_result($result,0,"fromdate");
	$todate=mysql_result($result,0,"todate");
	$cost=mysql_result($result,0,"cost");
	
	$user_sql="SELECT username FROM user WHERE iduser='$user' ";
	$user_result=mysql_query($user_sql);
	$user_iduser=mysql_result($user_result,0,"username");
	
	if($count>=1){
	$sql="UPDATE ".$db_name.".".$tbl_name." SET `approval`='cancelled' WHERE  `".$tbl_name."`.`idexpenserecords` ='".$id."' LIMIT 1 ;";

	error_log($sql);
		//$sql="INSERT INTO ".$db_name.".`".$tbl_name."` (`username` ,`password` ,`supervisor` ,`active` ,`profile`)VALUES ('".$userName."',  '".$password."',  '".$supervisorName."',  '1',  '".$userType."');";
		//$sql="INSERT INTO login VALUES (value1, value2, value3,...);"

		if (!mysql_query($sql))
		  {
		  die('Error: ' . mysql_error());
		  echo "fail";
		  exit;
		  }else{
		  sendMessage($id,$userName,$user_iduser,$placefrom,$placefrom,$fromdate,$todate,$idtraveltype,$cost,'Cancelled');
			//echo "success";
		  }
	}else{

		echo "fail";
		exit;

	}
}

echo "success";
function sendMessage($id,$userName,$user_iduser,$placefrom,$placeto,$fromdate,$todate,$idtraveltype,$cost,$action){
$requestTravelType="";
if($idtraveltype=='1'){
$requestTravelType.="Local";
}else{
$requestTravelType.="International";
}
	  //To user
	  $to="Manojkumar.Muralidharan@itcinfotech.com";
	  //$to=$userName;
	  $subject="Request";

	  $body="<div><span>Hi , </br></span></div>";
	  $body.="<div><span>The travel request( ID:".$id." ) has been";
	  if($action=='denied'){
		 $body.=" denied ";
		 $subject.=" Denied";
		}else if($action=='approved'){
		$body.=" approved ";
		$subject.=" Approved";
		}else if($action=='processed'){
		 $body.=" processed ";
		 $subject.=" Processed";
		}else if($action=='Cancelled'){
		 $body.=" cancelled ";
		 $subject.=" cancelled";
		}
	  $body.="</span></div></br><div style='height:20px'></div>";
	  $body.='<div><table id="mt" class="rounded-corner"  style="font-size:11px;margin:0px;width:635px;text-align: left;border-collapse: collapse;">
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
            <td>'.$fromdate.'</td>
            <td>'.$todate.'</td>
			<td>'.$placefrom.'</td>			
			<td>'.$placeto.'</td>
			<td>'.$requestTravelType.'</td>
            <td>'.$cost.'$</td>
            </tr>
    </tbody>
	</table></div>';
	$body.='<div style="margin-top:20px">regards,</div>';
	$body.='<div style="margin-top:0px">I2A Travel</div>';
	
	 // $body=" Your travel request for ".$requestTravelSource." to ".$requestTravelDestination." has been successfully submitted and the request Id is ".$idexpenseworkflow;
	  sendMail($to,$body,$subject);


}
?>