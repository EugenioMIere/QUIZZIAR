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

    public function registrarPartida($userId){
        $query = "INSERT INTO `partidas` (`usuario_id`) VALUES ('$userId')";
        $this->database->execute($query);
    }

    public function sugerirPregunta($preg){
        $query = "INSERT INTO preguntas_sugeridas(pregunta) VALUES ('$preg')";
        return $this->database->execute($query);
    }

    public function editarNombreComp($nc, $id){
        $query = "UPDATE usuario SET nombreCompleto = '$nc' WHERE id = '$id'";
        $this->database->execute($query);
    }

    public function editarEmail($e, $id){
        $query = "UPDATE usuario SET email = '$e' WHERE id = '$id'";
        $this->database->execute($query);
    }

    public function editarPais($pais, $id){
        $query = "UPDATE usuario SET pais = '$pais' WHERE id = '$id'";
        $this->database->execute($query);
    }

    public function editarCiudad($c, $id){
        $query = "UPDATE usuario SET ciudad = '$c' WHERE id = '$id'";
        $this->database->execute($query);
    }

    public function editarNombreUsuario($nu, $id){
        $query = "UPDATE usuario SET nombreDeUsuario = '$nu' WHERE id = '$id'";
        $this->database->execute($query);
    }

    public function editarGenero($g, $id){
        $query = "UPDATE usuario SET genero = '$g' WHERE id = '$id'";
        $this->database->execute($query);
    }

    public function editarFoto($f, $id){
        $query = "UPDATE usuario SET fotoDePerfil = '$f' WHERE id = '$id'";
        $this->database->execute($query);
    }

    public function agregarRed($id, $red, $content){
        $sql = "INSERT INTO redes(usuario_id, $red) VALUES ('$id', '$content')";
        $this->database->execute($sql);
    }
    public function getRedesSociales($id){
        $query = "SELECT * FROM redes WHERE usuario_id = '$id'";
        return $this->database->execute($query);
    }

    public function obtenerMisPartidas($idUsuario){
        $sql = "SELECT * FROM partidas WHERE usuario_id = '$idUsuario'";
        return $this->database->execute($sql);
    }

}
