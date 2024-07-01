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

    public function getCantidadPartidas($idUsuario){
        $sql = "SELECT COUNT(DISTINCT id) FROM partidas WHERE usuario_id = '$idUsuario'";
        return $this->database->execute($sql);
    }

    public function getInfoJuego($idUsuario){
        $sql = "SELECT SUM(p.correctas) as correctas, SUM(p.incorrectas) as incorrectas, COUNT(DISTINCT p.id) as cantidad
                FROM partidas p JOIN usuario u 
                ON p.usuario_id = u.id";
        return $this->database->execute($sql);
    }

    public function getNivelJugador($idUsuario){
        $sql = "SELECT p.usuario_id, COUNT(DISTINCT p.id) AS partidas_jugadas,
       SUM(CASE WHEN pp.correcta = 1 THEN 1 ELSE 0 END) AS total_correctas,
        COUNT(pp.pregunta_id) AS total_preguntas,
        CASE 
        WHEN COUNT(DISTINCT p.id) = 0 THEN 0
        ELSE SUM(CASE WHEN pp.correcta = 1 THEN 1 ELSE 0 END) * 1.0 / COUNT(DISTINCT p.id)
        END AS promedio_correctas_por_partida,
        CASE 
        WHEN COUNT(DISTINCT p.id) = 0 THEN 0
        ELSE COUNT(pp.pregunta_id) * 1.0 / COUNT(DISTINCT p.id)
        END AS promedio_preguntas_por_partida
        FROM partidas p INNER JOIN partidas_preguntas pp ON pp.partida_id = p.id
        WHERE p.usuario_id = '$idUsuario'";

        return $this->database->query($sql);
    }

    public function getEdad($idUsuario){
        $sql = "SELECT TIMESTAMPDIFF(YEAR, fechaDeNacimiento, CURDATE()) AS edad FROM usuario WHERE id = '$idUsuario'";
        return $this->database->execute($sql);
    }

}
