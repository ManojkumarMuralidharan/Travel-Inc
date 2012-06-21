 <?php 
 session_start();
  header("Location:home.php");
 $target = "xls/"; 
 $target = $target . basename( $_FILES['file']['name']) ; 
 $ok=1; 
 
 
 
 
 
 //Here we check that $ok was not set to 0 by an error 
 if ($ok==0) 
 { 
 Echo "Sorry your file was not uploaded"; 
 } 
 
 //If everything is ok we try to upload it 
 else 
 { 
 if(move_uploaded_file($_FILES['file']['tmp_name'], $target)) 
 { 
 $_SESSION['filename']=basename( $_FILES['file']['name']);
 echo "The file ". basename( $_FILES['file']['name']). " has been uploaded"; 
 include 'uploadExcel.php';

 } 
 else 
 { 
 echo "Sorry, there was a problem uploading your file."; 
 } 
 } 
 ?> 