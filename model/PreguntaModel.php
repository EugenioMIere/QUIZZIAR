<?php

class PreguntaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getPreguntas(){

         $query = "SELECT * FROM preguntas ORDER BY id ASC LIMIT 1";
         return $this->database->query($query);
    }

    public function getRespuesta($id){
        $query = "SELECT * FROM preguntas WHERE id = '$id'";
        $result = $this->database->query($query);
        return $result[0]['respuesta'];
    }

}