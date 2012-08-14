<?php
//'From' e-mail is configured in sendmail.ini
//$subject='Hi There!!';
//$from="Manoj.wolfpack@gmail.com";
//$to='Manojkumar.Muralidharan@itcinfotech.com';
//$body='This is my demo email sent using PHP on XAMPP Lite version 1.7.3?';




function sendMail($to,$msg_body,$subject){
$body="<html><head>";
$body.="<style>
.rounded-corner
{
margin:0px;
width:635px;
text-align: left;
border-collapse: collapse;
}
.rounded-corner thead th.rounded-company
{
width:26px;
background: #60c8f2 url('../images/left.jpg') left top no-repeat;
}
.rounded-corner thead th.rounded-q4
{
background: #60c8f2 url('../images/right.jpg') right top no-repeat;
}
.rounded-corner th
{
padding: 8px;
font-weight: normal;
font-size: 13px;
color: #039;
background: #60c8f2;
}
.rounded-corner td
{
padding: 8px;
background: #ecf8fd;
border-top: 1px solid #fff;
color: #669;
}

.rounded-corner td declined
{
	padding: 8px !important;
	background: #FC3D3D !important;
	border-top: 1px solid #fff !important;
	color: #609 !important;
	 
}

.rounded-corner tfoot td.rounded-foot-left
{
background: #ecf8fd url('../images/botleft.jpg') left bottom no-repeat;
}
.rounded-corner tfoot td.rounded-foot-right
{
background: #ecf8fd url('../images/botright.jpg') right bottom no-repeat;
}
.rounded-corner tbody tr:hover td
{
background: #d2e7f0;
}



</style></head><body>";
// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
//$headers .= 'To: <'.$to.'>'. "\r\n";
$headers .= 'From: <I2A.Travel@itcinfotech.com>' . "\r\n";

$body.=$msg_body;
$body.="</body></html>";
//error_log($body);
//
if (mail($to,$subject,$body,$headers)){
//if (true){
//echo 'success';
error_log('Mail sent successfully!');
}
else{
//echo 'fail';
error_log('Mail not sent!');
}
}
?>