<?php
$subject='Test Mail!!';

$headers = "From: Manoj.Wolfpack@gmail.com";

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
$to='Manoj.wolfpack@gmail.com';
$body='This is my demo email sent using PHP on XAMPP Lite version 1.7.3';
echo $to.$subject.$body;
if (mail($to,$subject,$body))
echo 'Mail sent successfully!';
else
echo 'Mail not sent!';
?>