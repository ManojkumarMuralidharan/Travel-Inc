<?php

<<<<<<< HEAD
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
$tbl_name="expenserecords"; // Table name
=======
require('C:/Users/TestUser/xampp/htdocs/Travel/lib/Smarty/libs/Smarty.class.php');
session_start();

$host="10.6.50.26"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
$db_name="db1"; // Database name
$tbl_name="entry"; // Table name
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e

$id_post=$_POST["id"];
$action=$_POST["action"];
$userName=$_SESSION['username'];
$supervisor=$_SESSION['username'];

<<<<<<< HEAD
mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");


//Get User Id
//$sql="SELECT idUser FROM  `expenserecords` WHERE idexpenserecords='$id_post'";
$sql="SELECT iduser,idprofile FROM user WHERE username='$userName' ";
$result=mysql_query($sql);
$count=mysql_num_rows($result);
$iduser=mysql_result($result,0,"iduser");
$idprofile=mysql_result($result,0,"idprofile");

if($idprofile==3){

include 'presidentActionOnRequest.php';
exit;

}

=======



mysql_connect($host, $mysql_userName, $mysql_password)or
die("cannot connect");
mysql_select_db($db_name)or die("cannot select DB");
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
//error_log($id_post);
//$id_array= explode(",", $id_post);

foreach ($id_post as $id) {
<<<<<<< HEAD


	/*$sql="SELECT `idprofile` from user where iduser = (SELECT `idactionuser` FROM expenseworkflow WHERE `idexpenserecords` =  '".$id."' AND `stage` = ( SELECT MAX(`stage`) FROM expenseworkflow WHERE `idexpenserecords` =  '".$id."' ) ) ;";
	$result=mysql_query($sql);
	$previous_actioner_profile=mysql_result($result,0,"idprofile");
	*/
	$sql="SELECT idtraveltype,stage,idUser,placefrom,placeto,fromdate,todate,cost FROM  $tbl_name WHERE  `idexpenserecords` = '".$id."' ;";
	error_log('-'.$sql);

	$result=mysql_query($sql);
	
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
	
	$sql="SELECT idprofile FROM  workflow WHERE  `idworkflow` = '".$idtraveltype."' AND `stage` = '".$stage."' ;";
	$result=mysql_query($sql);
	$request_profile=mysql_result($result,0,"idprofile");
	if($idprofile>=$request_profile){
		
				error_log('-'.$sql);
				if($action=='On Hold'){
				$onHold_sql="UPDATE  ".$db_name.".`".$tbl_name."` ";
				$onHold_sql.="SET `approval`='".$action."' WHERE  `".$tbl_name."`.`idexpenserecords` =  '".$id."' LIMIT 1 ;";
				error_log($onHold_sql);
					if (!mysql_query($onHold_sql))
					{
						die('Error: ' . mysql_error());
						mysql_close();
						echo "fail";
					}else{
						mysql_close();
					//	echo "success";
					}
					//To User
					  sendMessage($id,$userName,$user_iduser,$placefrom,$placeto,$fromdate,$todate,$idtraveltype,$cost,'onhold');
  					  //To Supervisor
					  sendMessage($id,$user_iduser,$user_iduser,$placefrom,$placeto,$fromdate,$todate,$idtraveltype,$cost,'onhold');


				break;
				}
				if($action=='Declined'){
				// Decline the request
					$sql_approve="UPDATE $tbl_name SET `approval` = 'declined' , `stage` = '6' WHERE  `".$tbl_name."`.`idexpenserecords` ='".$id."' LIMIT 1 ;";
					error_log('--'.$sql_approve);
					
					if (!mysql_query($sql_approve))
					  {
							die('Error: ' . mysql_error());
							echo "fail";
							exit;
					  }else{
							//echo "success";
					  }
					  //To User
					  sendMessage($id,$userName,$user_iduser,$placefrom,$placeto,$fromdate,$todate,$idtraveltype,$cost,'denied');
  					  //To Supervisor
					  sendMessage($id,$user_iduser,$user_iduser,$placefrom,$placeto,$fromdate,$todate,$idtraveltype,$cost,'denied');

					  break;
				
				}else{
				
				do{
				$sql="SELECT * FROM  workflow WHERE  `idworkflow` = '".$idtraveltype."' AND `stage` = '".($stage+1)."' ;";
				$result=mysql_query($sql);
				$row = mysql_fetch_assoc($result);
				error_log('---'.$sql.'--'.$row['idprofile'].$row['action'].'---');
				$count=mysql_num_rows($result);
				if($row['idprofile']==6){
					
					// Approve the request
					$sql_approve="UPDATE $tbl_name SET `approval` = 'approved' , `stage` = '".($stage+1)."' WHERE  `".$tbl_name."`.`idexpenserecords` ='".$id."' LIMIT 1 ;";
					error_log('--'.$sql_approve);
					
					if (!mysql_query($sql_approve))
					  {
							die('Error: ' . mysql_error());
							echo "fail";
							exit;
					  }else{

   					  //To User
					  sendMessage($id,$userName,$user_iduser,$placefrom,$placeto,$fromdate,$todate,$idtraveltype,$cost,'approved');
  					  //To Supervisor
					  sendMessage($id,$user_iduser,$user_iduser,$placefrom,$placeto,$fromdate,$todate,$idtraveltype,$cost,'approved');

							//echo "success";
					  }
					 
					  break;
					
				}else{
					if($row['action']==1){
							// Move request to next stage 
							$sql_update="UPDATE $tbl_name SET `stage` = '".($stage+1)."' WHERE  `".$tbl_name."`.`idexpenserecords` ='".$id."' LIMIT 1 ;";
							error_log('--'.$sql_update);
							if (!mysql_query($sql_update))
							{
								die('Error: ' . mysql_error());
								echo "fail";
								exit;
							}else{
							//sendMessage($id,$userName,$user_iduser,$placefrom,$placefrom,$fromdate,$todate,$idtraveltype,$cost,'processed');
						
						//To User
						sendMessage($id,$userName,$user_iduser,$placefrom,$placeto,$fromdate,$todate,$idtraveltype,$cost,'processed');
						//To Supervisor
						sendMessage($id,$user_iduser,$user_iduser,$placefrom,$placeto,$fromdate,$todate,$idtraveltype,$cost,'processed');
					  
							
							
								//echo "success";
							}
					
					}
					//break;
				
				}
					//check mail 
					if($row['mail']==1){
					
					}
					
					//Insert into workflow table
					$sql_idworkflow="SELECT Max(`idexpenseworkflow`) as nextID FROM expenseworkflow";
					$result_idworkflow=mysql_query($sql_idworkflow);
					//if($result){
					$count_idworkflow=mysql_num_rows($result_idworkflow);
					if($count_idworkflow>=1){
						$idexpenseworkflow=mysql_result($result_idworkflow,0,"nextID")+1;
					}else{
						$idexpenseworkflow=1;
					}

					$sql_idworkflow="INSERT INTO expenseworkflow(`idexpenseworkflow` ,`idworkflow` ,`stage` ,`idactionuser` ,`action` ,`idexpenserecords` ,`comments`) VALUES ('".$idexpenseworkflow."','".$idtraveltype."',".($stage+1).",'".$iduser."','supervisor approved request','".$id."','Approved');";


					error_log($sql_idworkflow);

					if (!mysql_query($sql_idworkflow))
					{
						die('Error: ' . mysql_error());
						echo "fail";
						exit;
					}else{
						//echo "success";
					}
					
					
				$stage++;
				}while($row['idprofile']!=6&&$row['action']!=1);
				
				}
		
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
		}else if($action=='onhold'){
		 $body.=" put OnHold";
		 $subject.=" put OnHold";
		}
	  $body.="</span></div></br><div style='height:20px'></div>";
	  $body.='<div><table id="mt" class="rounded-corner"  style="font-size:11px;margin:0px;width:635px;text-align: left;border-collapse: collapse;">
		<thead style="padding: 8px;font-weight: normal;font-size: 13px;color: #039;background: #60c8f2;text-align:center;">
    	<tr>
            <th scope="col" class="rounded-company" style="border-top-left-radius: 10px 10px;width:26px; background: #60c8f2;">Start Date</th>
            <th scope="col" class="rounded">End Date</th>
            <th scope="col" class="rounded">Origin</th>
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
=======
		
	$sql="SELECT * FROM  $tbl_name WHERE  `id` = '".$id."' AND  `supervisor` LIKE  '".$supervisor."' ;";
	error_log('-'.$sql);

	$result=mysql_query($sql);
	$count=mysql_num_rows($result);
	if($count>=1){
		error_log('-'.$sql);

	$sql="UPDATE $tbl_name SET  `approval` = '".$action."'  WHERE  `".$tbl_name."`.`id` ='".$id."' LIMIT 1 ;";

	error_log('--'.$sql);
		//$sql="INSERT INTO ".$db_name.".`".$tbl_name."` (`username` ,`password` ,`supervisor` ,`active` ,`profile`)VALUES ('".$userName."',  '".$password."',  '".$supervisorName."',  '1',  '".$userType."');";
		//$sql="INSERT INTO login VALUES (value1, value2, value3,...);"

		if (!mysql_query($sql))
		  {
		  die('Error: ' . mysql_error());
		  echo "fail";
		  exit;
		  }else{
			//echo "success";
		  }
	}else{

		echo "fail";
		exit;

	}
}

echo "success";
>>>>>>> e9b52fa88c01bcaeb3dc9e837ad804574c19146e
?>