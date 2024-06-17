<?php

class PreguntaController
{

    private $model;
    private $presenter;

    public function __construct($model, $presenter)
    {
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function getPregunta()
    {
        $preguntas = $this->model->getPreguntas();
        $opciones = $this->model->getOpciones($preguntas[0]['id']);
        $visibilidad = "hidden";
        /*$this->registrarPartida($preguntas[0]['id']);*/

        $this->presenter->render("view/preguntasView.mustache", ["visibilidad" => $visibilidad,"opciones" => $opciones,"preguntas" => $preguntas]);
    }

    /*private function registrarPartida($idPregunta)
    {
        $id_usuario = $_SESSION['id'];
        $this->model->registrarPartida($id_usuario, $idPregunta);

    }*/
    public function validarPregunta(){
        if (isset($_POST["respuesta"]) && $_GET["idPregunta"]){

            $idRespuestas = $_POST["respuesta"];
            $preguntaIdRespuestas = $_GET["idPregunta"];
            $respuestaCorrecta = $this->getRespuestaCorrecta($idRespuestas);
            $estadoBoton = "disabled";

            if ($respuestaCorrecta){
                $result = "Correcto";
                $claseRespuesta = "respuesta-correcta";
            } else {
                $result = "Falso";
                $claseRespuesta = "respuesta-incorrecta";
            }

            $preguntas = $this->model->getPreguntaEspecifica($preguntaIdRespuestas);
            $opciones = $this->model->getOpciones($preguntaIdRespuestas);
            $this->model->setRespuestaPartida($_SESSION['id'], $result);
            $this->presenter->render("view/preguntasView.mustache", [
                "result" => $result,
                "opciones" => $opciones,
                "preguntas" => $preguntas,
                "estadoBoton" => $estadoBoton,
                "claseRespuesta" => $claseRespuesta
            ]);
        }
    }


    private function getRespuestaCorrecta($id){

        return $this->model->getRespuesta($id);
    }

}