<?php

//require('Smarty.class.php');
//session_start();
/*
$host="10.6.50.29"; // Host name
$mysql_userName="Manoj"; // Mysql username
$mysql_password="ITC"; // Mysql password
*/
include 'DB_details.php';

//$db_name="travel"; // Database name
$tbl_name="expenserecords"; // Table name

$id_post=$_POST["id"];
$action=$_POST["action"];
$userName=$_SESSION['username'];
$supervisor=$_SESSION['username'];

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

$hr_sql="SELECT email FROM profile WHERE idprofile='4' ";
$hr_result=mysql_query($hr_sql);
$email_hr=mysql_result($hr_result,0,"email");

//error_log($id_post);
//$id_array= explode(",", $id_post);

foreach ($id_post as $id) {


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
	
	$user_sql="SELECT username,idsupervisor FROM user WHERE iduser='$user' ";
	$user_result=mysql_query($user_sql);
	$user_iduser=mysql_result($user_result,0,"username");
	$id_supervisor=mysql_result($user_result,0,"idsupervisor");
	

	
	
	$supervisor_sql="SELECT username FROM user WHERE iduser='$id_supervisor' ";
	$supervisor_result=mysql_query($supervisor_sql);
	$supervisor_mail=mysql_result($supervisor_result,0,"username");
	
	$sql="SELECT idprofile FROM  workflow WHERE  `idworkflow` = '".$idtraveltype."' AND `stage` = '".$stage."' ;";
	$result=mysql_query($sql);
	$request_profile=mysql_result($result,0,"idprofile");
	if($idprofile>=$request_profile){
		
				error_log('-'.$sql);
				if($action=='Declined'){
				$new_stage='';
				if($idtraveltype=='1'){
				$new_stage='4';
				}else if($idtraveltype=='2'){
				$new_stage='6';
				}else{
				$new_stage='-1';
				}
				// Decline the request
					$sql_approve="UPDATE $tbl_name SET `approval` = 'declined' , `stage` = '".$new_stage."' WHERE  `".$tbl_name."`.`idexpenserecords` ='".$id."' LIMIT 1 ;";
					error_log('--'.$sql_approve);
					
					if (!mysql_query($sql_approve))
					  {
							die('Error: ' . mysql_error());
							echo "fail";
							exit;
					  }else{
							echo "success";
					  }
					  
					  //To President
					    sendMessage($id,$userName,$user_iduser,$placefrom,$placefrom,$fromdate,$todate,$idtraveltype,$cost,'denied');
					 // To Supervisor
					     sendMessage($id,$supervisor_mail,$user_iduser,$placefrom,$placefrom,$fromdate,$todate,$idtraveltype,$cost,'denied');
					 // To User
						sendMessage($id,$user_iduser,$user_iduser,$placefrom,$placefrom,$fromdate,$todate,$idtraveltype,$cost,'denied');
					  break;
				
				}else if($action=='On Hold'){

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
					
					  //To President
					  sendMessage($id,$userName,$user_iduser,$placefrom,$placeto,$fromdate,$todate,$idtraveltype,$cost,'onhold');
  					  //To User
					  sendMessage($id,$user_iduser,$user_iduser,$placefrom,$placeto,$fromdate,$todate,$idtraveltype,$cost,'onhold');

								
				}else{
				do{
				$sql="SELECT * FROM  workflow WHERE  `idworkflow` = '".$idtraveltype."' AND `stage` = '".($stage+1)."' ;";
				$result=mysql_query($sql);
				$row = mysql_fetch_assoc($result);
				error_log('---'.$sql.'--'.$row['idprofile'].$row['action'].'---');
				$count=mysql_num_rows($result);
				error_log('--'.'1');
				if($row['idprofile']==6){
				error_log('--'.'2');	
					// Approve the request
					$sql_approve="UPDATE $tbl_name SET `approval` = 'approved' , `stage` = '".($stage+1)."' WHERE  `".$tbl_name."`.`idexpenserecords` ='".$id."' LIMIT 1 ;";
					error_log('--'.$sql_approve);
					
					if (!mysql_query($sql_approve))
					  {
							die('Error: ' . mysql_error());
							echo "fail";
							exit;
					  }else{
					  //sendMessage($id,$userName,$user_iduser,$placefrom,$placefrom,$fromdate,$todate,$idtraveltype,$cost,'approved');
					  
						//To President
					    sendMessage($id,$userName,$user_iduser,$placefrom,$placefrom,$fromdate,$todate,$idtraveltype,$cost,'approved');
					 
						// To Supervisor
					    sendMessage($id,$supervisor_mail,$user_iduser,$placefrom,$placefrom,$fromdate,$todate,$idtraveltype,$cost,'approved');
					 
						// To User
						sendMessage($id,$user_iduser,$user_iduser,$placefrom,$placefrom,$fromdate,$todate,$idtraveltype,$cost,'approved');
						
						// To HR
						sendMessage($id,$email_hr,$user_iduser,$placefrom,$placefrom,$fromdate,$todate,$idtraveltype,$cost,'approved');
	
	
						
							//echo "success";
					  }
					  
					//  break;
					
				}else{
				error_log('--'.'3');
					//if($row['action']==1){
							// Move request to next stage 
							$sql_update="UPDATE $tbl_name SET `stage` = '".($stage+1)."' WHERE  `".$tbl_name."`.`idexpenserecords` ='".$id."' LIMIT 1 ;";
							error_log('--'.$sql_update);
							if (!mysql_query($sql_update))
							{
								die('Error: ' . mysql_error());
								echo "fail";
								exit;
							}	
							else{
							
							
					  //To President
					    sendMessage($id,$userName,$user_iduser,$placefrom,$placefrom,$fromdate,$todate,$idtraveltype,$cost,'processed');
					 // To Supervisor
					       sendMessage($id,$supervisor_mail,$user_iduser,$placefrom,$placefrom,$fromdate,$todate,$idtraveltype,$cost,'processed');				 
					 // To User
						sendMessage($id,$user_iduser,$user_iduser,$placefrom,$placefrom,$fromdate,$todate,$idtraveltype,$cost,'processed');
						
								echo "success";
							}
					
				//	}
					//break;
				
				}
				error_log('--'.'4');
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

					$sql_idworkflow="INSERT INTO expenseworkflow(`idexpenseworkflow` ,`idworkflow` ,`stage` ,`idactionuser` ,`action` ,`idexpenserecords` ,`comments`) VALUES ('".$idexpenseworkflow."','".$idtraveltype."',".($stage+1).",'".$iduser."','president approved request','".$id."','Approved');";


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
				}while($row['idprofile']!=6);
				}
				
				
	}
	
	
}

echo "success";
/*
*/
?>