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

        /*$preguntas = $this->database->query($sql)->fetchAll(PDO::FETCH_ASSOC);*/
        return $this->database->query($sql);
    }
    public function eliminarPregunta($id){

        $sql = "DELETE FROM respuestas WHERE pregunta_id = '$id'";
        $this->database->execute($sql);

        $sql = "DELETE FROM preguntas where id = '$id'";
        $this->database->execute($sql);

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

}