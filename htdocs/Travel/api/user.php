<?php

class User{
private $username;
private $password;

public function getUsername($username){
$this->username=$username;
}

public function setUsername(){
return $this->username;
}

public function getPassword($password){
$this->password=$password;
}

public function setPassword(){
return $this->password;
}

}



?>