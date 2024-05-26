<?php

class LoginModel
{
    private $database;

    public function __construct($database){
        $this->database = $database;
    }

    public function logIn($email, $password){
        $sql = "SELECT * from usuario WHERE email = '$email' && password = '$password'";
        return $this->database->query($sql);
    }

}