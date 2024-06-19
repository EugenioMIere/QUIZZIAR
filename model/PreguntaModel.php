<?php

class PreguntaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getPreguntas($id_usuario){

        $preguntaPreguntada = [];

        while (empty($preguntaPreguntada)) {

            $query = "SELECT * FROM preguntas ORDER BY RAND() LIMIT 1";
            $result = $this->database->query($query);
            $idPregunta = $result[0]['id'];

            $sql = "SELECT pp.pregunta_id, p.usuario_id
                    FROM partidas_preguntas pp
                    LEFT JOIN partidas p ON pp.partida_id = p.id AND p.usuario_id = '$id_usuario'
                    WHERE pp.pregunta_id = '$idPregunta' ";

            if (!$this->database->query($sql)) {
                $preguntaPreguntada = $result;
            }

        }

         return $preguntaPreguntada;

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

        $partida = $this->getUltimaPartidaUsario($usuario_id);


        $correctas = $partida[0]['correctas'];
        $incorrectas = $partida[0]['incorrectas'];
        $id = $partida[0]['id'];
        $estado = 0;


        if ($respuesta== "Correcto"){
            $correctas++;
            $estado = 1;
        } else {
            $incorrectas++;
        }
        $this->setRespuesta_partidas_preguntas($id,$idPregunta,$estado,$idRespuestas );
        $query = "UPDATE `partidas` SET `correctas` = '$correctas',`incorrectas` = '$incorrectas' WHERE id = '$id'";

        $this->database->execute($query);

    }
    public function setPreguntaEnPartida($usuario_id, $idPregunta){

        $partida = $this->getUltimaPartidaUsario($usuario_id);
        $partida_id = $partida[0]['id'];

        $sql = "INSERT INTO partidas_preguntas (pregunta_id, partida_id) VALUES ('$idPregunta','$partida_id')";
        $this->database->execute($sql);
    }
    public function getUltimaPartidaUsario($usuario_id)
    {
        $consulta = "SELECT *
                    FROM partidas
                    WHERE `usuario_id` = '$usuario_id'
                    ORDER BY `id` DESC
                    LIMIT 1";

        return $this->database->query($consulta);
    }

    private function setRespuesta_partidas_preguntas($id_partida,$idPregunta,$estado,$idRespuestas)
    {
        $query = "UPDATE `partidas_preguntas` 
                    SET `respuesta_id` = '$idRespuestas',`correcta` = '$estado' 
                    WHERE partida_id = '$id_partida' AND pregunta_id = '$idPregunta'";

        $this->database->execute($query);
    }

    public function reportarPregunta($id){
        $sql = "INSERT INTO preguntas_reportadas(pregunta_reportada) VALUES ('$id')";
        return $this->database->execute($sql);
    }

}