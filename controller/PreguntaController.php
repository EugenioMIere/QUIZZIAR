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

        $this->presenter->render("view/preguntasView.mustache", [
            "visibilidad" => $visibilidad,
            "opciones" => $opciones,
            "preguntas" => $preguntas
        ]);
    }

    private function registrarPreguntaEnPartida($idPregunta)
    {
        $id_usuario = $_SESSION['id'];
        $this->model->setPreguntaEnPartida($id_usuario, $idPregunta);
    }

    public function validarPregunta()
    {
        if (isset($_POST["respuesta"]) && isset($_GET["idPregunta"])) {
            $idRespuestas = $_POST["respuesta"];
            $idPregunta = $_GET["idPregunta"];
            $userId = $_SESSION['id'];
            $noCheat = $this->model->verificarTiempoRespuesta($userId);
            $respuestaCorrecta = $this->getRespuestaCorrecta($idRespuestas);
            $estadoBoton = "disabled";

            if ($noCheat) {
                if ($respuestaCorrecta) {
                    $result = "Correcto";
                    $claseRespuesta = "respuesta-correcta";
                    $this->model->guardarRespuesta($userId, $idRespuestas, 1, $_SESSION['partidaId']);
                } else {
                    $result = "Falso";
                    $claseRespuesta = "respuesta-incorrecta";
                    $this->model->guardarRespuesta($userId, $idRespuestas, 0, $_SESSION['partidaId']);

                    $partida = $this->model->getPartida();
                }
            } else {
                $this->model->terminarPorTrampa();
                $this->presenter->render("view/perdisteView.mustache", [
                "titulo" => "Partida Perdida",
                "subtitulo" => "Perdiste la partida por hacer trampa"
                ]);
                return;
            }

            $preguntas = $this->model->getPreguntaEspecifica($idPregunta);
            $opciones = $this->model->getOpciones($idPregunta);

            $this->presenter->render("view/preguntasView.mustache", [
            "result" => $result,
            "opciones" => $opciones,
            "preguntas" => $preguntas,
            "estadoBoton" => $estadoBoton,
            "claseRespuesta" => $claseRespuesta
            ]);
        }
    }

    private function getRespuestaCorrecta($id)
    {
        return $this->model->getRespuesta($id);
    }
}
