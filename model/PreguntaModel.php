<?php

class PreguntaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getPreguntas(){

         $query = "SELECT * FROM preguntas ORDER BY RAND() LIMIT 1";

        /*$result = $this->database->query($query);
        return $result[0]['pregunta'];*/
         return $this->database->query($query);

    }

    public function getPreguntaEspecifica($id){

        $query = "SELECT * FROM preguntas WHERE id = '$id'";
        /*$result = $this->database->query($query);
        return $result[0]['pregunta'];*/
        return $this->database->query($query);
    }

    public function getOpciones($condicion){

        $query = "SELECT * FROM respuestas WHERE pregunta_id = '$condicion'";
        /*$result = $this->database->query($query);
        return $result[0]['pregunta'];*/
        return $this->database->query($query);
    }

    public function getRespuesta($id){
        $query = "SELECT * FROM respuestas WHERE id = '$id'";
        $result = $this->database->query($query);

        if ($result[0]['es_correcta'] == 1){
            return true;
        }
        return false;
    }

}