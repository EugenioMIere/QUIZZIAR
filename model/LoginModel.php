<?php

class LoginModel
{
    private $database;

    public function __construct($database){
        $this->database = $database;
    }

    public function logIn($email, $password){

        $passwordEncriptada = md5($password);

        $sql = "SELECT * from usuario WHERE email = '$email' AND password = '$passwordEncriptada' AND estado = 'activo'";
        return $this->database->query($sql);

    }
    public function getUserDetails($userId)
    {
        $sql = "SELECT * from usuario WHERE id = '$userId'";
        return $this->database->query($sql);
    }


}