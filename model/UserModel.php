<?php

class UserModel
{
    private $db;

    public function __construct($dbConnection)
    {
        $this->db = $dbConnection;
    }

    public function logIn($email, $password)
    {
        $query = $this->db->prepare("SELECT * FROM usuarios WHERE email = ? AND password = ?");
        $query->execute([$email, $password]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserDetails($userId)
    {
        $query = $this->db->prepare("SELECT nombreCompleto, email, fechaDeNacimiento, genero, pais, ciudad, nombreDeUsuario, password FROM usuarios WHERE id = ?");
        $query->execute([$userId]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
