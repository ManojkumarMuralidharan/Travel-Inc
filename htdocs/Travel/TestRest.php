<?php
require_once 'Zend\Rest\Client.php';

$username='manojkumar.muralidharan';
$password='login';
$name='manojkumar.muralidharan';
// 
$_POST["HTTP_AUTH_USER"]=$username ;
$_POST["HTTP_AUTH_PASS"]= $password;

$serverURI = "http://192.168.14.11/";

$client = new Zend_Rest_Client( $serverURI );
//$client->_helper->layout()->disableLayout();

//$client->_helper->viewRenderer->setNoRender(true);

//$frontController = Zend_Controller_Front::getInstance();
//$frontController->setParam(‘noViewRenderer’, true);

Zend_Rest_Client::getHttpClient()->setAuth( $username,$password);
$method = "/mail/index.php/api/login/authenticate/" ;
echo $method;
$result = $client->post($method );
//Result should contain XML Object
print_r( array('status' => (string)$result->status, 'response' => (string)$result->response->message) );
echo $result;

/*$method = "/mail/index.php/api/domain/check/name/" . $name;
$result = $client->get( $method );
//Result should contain XML Object
print_r( array('status' => (string)$result->status, 'response' => (string)$result->response->message) );
*/

?>