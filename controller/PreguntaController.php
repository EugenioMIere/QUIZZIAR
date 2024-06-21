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
        $preguntas = $this->model->getPreguntas($_SESSION['id']);
        $opciones = $this->model->getOpciones($preguntas[0]['id']);
        $visibilidad = "hidden";
        $this->registrarPreguntaEnPartida($preguntas[0]['id']);

        $nivel = $this->model->getNivelDeJugador($_SESSION['id']);

        $this->presenter->render("view/preguntasView.mustache", ["visibilidad" => $visibilidad,"opciones" => $opciones,"preguntas" => $preguntas,"nivel" => $nivel]);
    }

    private function registrarPreguntaEnPartida($idPregunta)
    {
        $id_usuario = $_SESSION['id'];
        $this->model->setPreguntaEnPartida($id_usuario, $idPregunta);

    }
    public function validarPregunta(){
        if (isset($_POST["respuesta"]) && $_GET["idPregunta"]){

            $idRespuestas = $_POST["respuesta"];
            $idPregunta = $_GET["idPregunta"];
            $respuestaCorrecta = $this->getRespuestaCorrecta($idRespuestas);
            $estadoBoton = "disabled";

            if ($respuestaCorrecta){
                $result = "Correcto";
                $claseRespuesta = "respuesta-correcta";
            } else {
                $result = "Falso";
                $claseRespuesta = "respuesta-incorrecta";
            }

            $preguntas = $this->model->getPreguntaEspecifica($idPregunta);
            $opciones = $this->model->getOpciones($idPregunta);
            $this->model->setRespuestaPartida($_SESSION['id'], $result,$idPregunta,$idRespuestas);

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

    public function reportarPregunta(){
        $id = $_GET['idPregunta'];
        $result = $this->model->reportarPregunta($id);

        if ($result){
            $mensaje = "La pregunta fue reportada";
            $this->presenter->render("view/preguntasView.mustache", ["mensaje" => $mensaje]);
        } else {
            $error = "Hubo un error al reportar la pregunta";
            $this->presenter->render("view/preguntasView.mustache", ["error" => $error]);
        }
    }
}