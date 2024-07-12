<?php

class EditorModel
{
    private $database;
    public function __construct ($database){
        $this->database = $database;
    }
    public function getAllPreguntas(){
       $sql = "SELECT p.id, p.pregunta, c.nombre AS categoria
       FROM preguntas p
       JOIN categoria c ON p.categoria_id = c.id";

        return $this->database->execute($sql);
    }
    public function eliminarPregunta($id){

        $sql = "DELETE FROM respuestas WHERE pregunta_id = '$id'";
        $this->database->execute($sql);

        $sql = "DELETE FROM partidas_preguntas WHERE pregunta_id = '$id'";
        $this->database->execute($sql);

        $sql = "DELETE FROM preguntas_reportadas WHERE pregunta_reportada = '$id'";
        $this->database->execute($sql);

        $sql = "DELETE FROM preguntas where id = '$id'";
        return $this->database->execute($sql);

    }

    public function getPreguntaPorId($id){
        $sql = "SELECT * FROM preguntas WHERE id = '$id'";

        $preg = $this->database->query($sql);

        return $preg;
    }

    public function getRespuestasPorIdPregunta($id){
        $sql = "SELECT * FROM respuestas WHERE pregunta_id = '$id'";

        $rtas = $this->database->query($sql);

        return $rtas;
    }

    public function editarPregunta($id, $pregunta, $idCategoria){
        $sql = "UPDATE `preguntas` SET pregunta = '$pregunta', categoria_id = '$idCategoria' WHERE id = '$id'";
        $this->database->execute($sql);
    }

    public function editarRespuestas($idPregunta, $respuestas){
        // Elimino todas las respuestas de la pregunta
        $sql = "DELETE from `respuestas` WHERE pregunta_id = '$idPregunta'";
        $this->database->execute($sql);

        foreach ($respuestas as $index => $respuesta) {
            if( $index == 0 ) $correcta = 1;
            else $correcta = 0;
            $sqlRespuesta = "INSERT INTO respuestas(pregunta_id, respuesta, es_correcta) VALUES ('$idPregunta','$respuesta','$correcta')";
            $this->database->execute($sqlRespuesta);
        }


    }

    public function getAllReportadas(){
        $sql = "SELECT p.id, p.pregunta, c.nombre FROM preguntas p JOIN categoria c ON c.id = p.categoria_id WHERE p.estado = 'reportada'";
        return $this->database->execute($sql);
    }

    public function getAllSugeridas(){
        $sql = "SELECT * FROM preguntas_sugeridas";
        return $this->database->execute($sql);
    }

    public function quitarSugerida($id){
        $sql = "DELETE FROM preguntas_sugeridas WHERE id = '$id'";
        return $this->database->execute($sql);
    }

    public function quitarReportada($id){
        $sql = "UPDATE preguntas SET estado = 'activa' WHERE id = '$id' AND estado = 'reportada'";
        return $this->database->execute($sql);
    }

    public function crearPregunta($pregunta, $categoria){
        $sql = "INSERT INTO preguntas(pregunta, categoria_id) VALUES ('$pregunta', '$categoria')";
        return $this->database->execute($sql);
    }

    public function crearRespuestas($id, $respuestas){

        $sql = "INSERT INTO respuestas(pregunta_id, respuesta, es_correcta) VALUES (?, ?, ?)";

        $stmt = $this->database->prepare($sql); // Prepare the statement

        foreach ($respuestas as $index => $respuesta) {
            $correcta = ($index == 0) ? 1 : 0;
            $stmt->bind_param("isi", $id, $respuesta, $correcta);
            $stmt->execute();
        }

        $stmt->close();
    }

    public function lastInsertId(){
        $sql = "SELECT MAX(id) FROM preguntas";
        return $this->database->query($sql);
    }
    public function getUserDetails($userId)
    {
        $sql = "SELECT * from usuario WHERE id = '$userId'";
        return $this->database->query($sql);
    }

}