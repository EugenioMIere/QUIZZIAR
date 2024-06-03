<?php

class UserModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function logIn($email, $password)
    {
        $query = $this->db->prepare("SELECT * FROM usuarios WHERE email = ? AND password = ?");
        $query->execute([$email, $password]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserDetails($userId)
    {
        $sql = "SELECT * from usuario WHERE id = '$userId'";
        return $this->database->query($sql);
    }

    public function getUserDetailsLobby($userId)
    {
        $sql = "SELECT nombreCompleto from usuario WHERE id = '$userId'";

        return $this->database->query($sql);
    }
    public function getNombreDeUsuarioYFotoDePerfil($userId){
        $sql ="SELECT nombreDeUsuario, fotoDePerfil FROM usuario WHERE id = '$userId'";

        return $this->database->query($sql);
    }
}
