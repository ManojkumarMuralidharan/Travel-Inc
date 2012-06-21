<?php
   
$username='manojkumar.muralidharan';
$password='login';
$data = array("HTTP_AUTH_USER" => 'manojkumar.muralidharan', "HTTP_AUTH_PASSWORD" => 'login@123' );                                                                    
$data_string = json_encode($data);     
//echo $data_string; 
$ch = curl_init('http://192.168.14.11/mail/index.php/api/login/authenticate/');
//"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
$userAgent="Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.52 Safari/536.5";
$timeout = 30;
//echo $_SERVER['HTTP_USER_AGENT'];
//$userAgent = $_SERVER['HTTP_USER_AGENT'];

//echo var_dump($data_string);
$ch = curl_init('http://192.168.14.11/mail/index.php/api/login/authenticate/?Username=manojkumar.muralidharan&Password=login');                                                                      
                                                                    
//curl_setopt($ch, CURLOPT_POST, 1);                                                            
//curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);        
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLINFO_HEADER_OUT, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);     
//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . base64_encode($username. ":" . $password)));                                                     
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD,base64_encode($username. ":" . $password));
//curl_easy_setopt($ch,CURLOPT_USERNAME,'manojkumar.muralidharan');
//curl_easy_setopt($ch,CURLOPT_PASSWORD,'login');
curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
//curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-type: application/json', 'HTTP_AUTH_USER: manojkumar.muralidharan','HTTP_AUTH_PASSWORD: login'));
	
$response = curl_exec($ch);    
	if (curl_errno($ch)) {
		echo curl_error($ch);
	} else {
	$retcode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		echo $retcode;
		echo $response;
	}                                                                   
//curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
//    'Content-Type: application/json',                                                                                
//    'Content-Length: ' . strlen($data_string))                                                                       
//);                                                                                                                   
 
 //curl_setopt($ch, CURLOPT_URL, "http://192.168.14.11/mail/index.php/api/login/authenticate/");
//curl_setopt($ch, CURLOPT_HEADER, 0);

/*
$post_data = "manojkumar.muralidharan@itcinfotech.com:login@123";         
$url="";
$options=array();
    $defaults = array( 
        CURLOPT_POST => 0, 
        CURLOPT_HEADER => 1, 
        CURLOPT_FRESH_CONNECT => 1, 
        CURLOPT_RETURNTRANSFER => 1, 
        CURLOPT_FORBID_REUSE => 1, 
        CURLOPT_TIMEOUT => 4, 
		CURLOPT_HTTPAUTH => CURLAUTH_ANY,
		CURLOPT_USERPWD=>$username.':'.$password,
        CURLOPT_POSTFIELDS => $post_data,
		CURLOPT_URL => "http://192.168.14.11/mail/index.php/api/login/authenticate/"
    ); 

    $ch = curl_init(); 
    curl_setopt_array($ch, ($options + $defaults)); 
 // curl_setopt($ch,CURLOPT_POST,false);
  // curl_setopt($ch,CURLOPT_FRESH_CONNECT,1);
  // curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
//   curl_setopt($ch,CURLOPT_HTTPAUTH,CURLAUTH_BASIC);
  //curl_setopt($ch, CURLOPT_HTTPHEADER,array('AUTHENTICATION:','BASIC manojkumar.muralidharan@itcinfotech.com:Password: login@123'));  
 //  curl_setopt($ch,CURLOPT_URL,"http://192.168.14.11/mail/index.php/api/login/authenticate/");
 //  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 // curl_setopt($ch, CURLOPT_USERPWD, "manojkumar.muralidharan:login@123");
	//  curl_setopt($ch,CURLOPT_USERPWD,$username.':'.$password); 
	  //curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	//  echo "$username:$password";
	   
	//  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
	 // curl_setopt($ch, CURLOPT_URL, "http://192.168.14.11/mail/index.php/api/login/authenticate/");
    if( ! $result = curl_exec($ch)) 
    { 
		echo '</br>----------'.curl_error($ch).'-----------------</br>';
        trigger_error(curl_error($ch)); 
    } 
	echo curl_getinfo($ch,CURLINFO_EFFECTIVE_URL);
	$status = curl_getinfo($ch);
    curl_close($ch); 
	echo 'this'+$result;
    //return $result; 


echo var_dump($status);
// grab URL and pass it to the browser
//curl_exec($ch);
//$result = curl_exec($ch);
//echo var_dump($ch);

echo ($result);
//echo 'this'+$result;
*/

?>