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
    public function setRespuestaPartida($usuario_id,$respuesta,$idPregunta,$idRespuestas){
        $consulta = "SELECT *
                    FROM partidas
                    WHERE `usuario_id` = '$usuario_id'
                    ORDER BY `id` DESC
                    LIMIT 1";

        $puntos = $this->database->query($consulta);
        ;

        $correctas = $puntos[0]['correctas'];
        $incorrectas = $puntos[0]['incorrectas'];
        $id = $puntos[0]['id'];
        $estado = 0;


        if ($respuesta== "Correcto"){
            $correctas++;
            $estado = 1;
        } else {
            $incorrectas++;
            $estado = 0;
        }
        $this->setRespuesta_partidas_preguntas($id,$idPregunta,$estado,$idRespuestas );
        $query = "UPDATE `partidas` SET `correctas` = '$correctas',`incorrectas` = '$incorrectas' WHERE id = '$id'";

        $this->database->execute($query);

    }

    public function setPreguntaEnPartida($usuario_id, $idPregunta){
        $consulta = "SELECT *
                    FROM partidas
                    WHERE `usuario_id` = '$usuario_id'
                    ORDER BY `id` DESC
                    LIMIT 1";

        $partida = $this->database->query($consulta);

        /*$incorrectas = $partida[0]['usuario_id'];*/
        $partida_id = $partida[0]['id'];

        $sql = "INSERT INTO partidas_preguntas (pregunta_id, partida_id) VALUES ('$idPregunta','$partida_id')";
        $this->database->execute($sql);
    }

    private function setRespuesta_partidas_preguntas($id_partida,$idPregunta,$estado,$idRespuestas)
    {
        $query = "UPDATE `partidas_preguntas` 
                    SET `respuesta_id` = '$idRespuestas',`correcta` = '$estado' 
                    WHERE partida_id = '$id_partida' AND pregunta_id = '$idPregunta'";

        $this->database->execute($query);
    }

//    public function reportarPregunta($id){
//        $sql = "INSERT INTO preguntas_reportadas(pregunta_reportada) VALUES ('$id')";
//        return $this->database->execute($sql);
//    }

}