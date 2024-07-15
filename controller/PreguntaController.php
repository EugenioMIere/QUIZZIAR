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


        if (!isset($_SESSION['contadorDePreguntas'])) {// Verificar si se ha alcanzado el límite de preguntas

            $_SESSION['contadorDePreguntas'] = 0;

        } else {// Incrementar el contador de preguntas

            $_SESSION['contadorDePreguntas']++;
        }

        if ($_SESSION['contadorDePreguntas'] >= 10) {

            unset($_SESSION['contadorDePreguntas']);
            header('Location:/user/redirigirAEstadisticasDePartida');
            exit();

        } else {

            if (!empty($_SESSION['current_question_id'])) {// Verificar si hay una pregunta en la sesion y usarla

                $tiempoRestante = $this->tiemporRestante();
                $preguntas = $this->model->getPreguntaEspecifica($_SESSION['current_question_id']);

            } else {// Si no hay ninguna, obtenerla:

                $tiempoRestante = $this->tiempoIncial();
                $preguntas = $this->model->getPreguntas($_SESSION['id']);
                $_SESSION['current_question_id'] = $preguntas[0]['id'];

            }

            $opciones = $this->model->getOpciones($preguntas[0]['id']);
            $visibilidad = "hidden";
            $this->registrarPreguntaEnPartida($preguntas[0]['id']);

            $nivel = $this->model->getNivelDeJugador($_SESSION['id']);
            $categoria = $preguntas[0]['categoria_id'];


            $this->presenter->render("view/preguntasView.mustache", [
                "usuario" => $_SESSION['usuario'],
                "visibilidad" => $visibilidad,
                "opciones" => $opciones,
                "preguntas" => $preguntas,
                "nivel" => $nivel,
                "categoria" => $categoria,
                "tiempoRestante" => $tiempoRestante
            ]);
        }
    }


    private function registrarPreguntaEnPartida($idPregunta)
    {
        $id_usuario = $_SESSION['id'];
        $this->model->setPreguntaEnPartida($id_usuario, $idPregunta);
    }

    public function validarPregunta(){

        $tiempo = $this->tiemporRestante();

        if ($tiempo > 0){
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

                // Borro de la variable session la pregunta actual para setearla nuevamente en el validarPregunta();
                unset($_SESSION['current_question_id']);

                $this->presenter->render("view/preguntasView.mustache", [
                    "result" => $result,
                    "opciones" => $opciones,
                    "preguntas" => $preguntas,
                    "estadoBoton" => $estadoBoton,
                    "claseRespuesta" => $claseRespuesta,
                    "visibilidadTiempo" => "hidden",
                    "categoria" => $preguntas[0]['categoria_id']

                ]);
            }

        }else{
            unset($_SESSION['current_question_id'],$_SESSION["temporizador-comienzo"]);
            header('Location:/user/redirigirAPerdiste');
            exit();
        }
    }
    private function tiemporRestante(){

        $tiempoRestante = 0;

        if (10-(time()-$_SESSION["temporizador-comienzo"])>0){
            $tiempoRestante = 10-(time()-$_SESSION["temporizador-comienzo"]);
        }
        return $tiempoRestante;
    }
    private function tiempoIncial(){

        unset($_SESSION['temporizador-comienzo']);
        $_SESSION["temporizador-comienzo"] = time();
        return 10;

    }

    private function getRespuestaCorrecta($id){
        return $this->model->getRespuesta($id);
    }

    public function reportarPregunta(){
        $id = $_POST['questionId'];

        $result = $this->model->reportarPregunta($id);

        if ($result){/*que al reportar pregunta vacie el id de pregunta en session*/


            unset($_SESSION['current_question_id']);
            $mensaje = "La pregunta fue reportada";
            $this->presenter->render("view/preguntasView.mustache", ["mensaje" => $mensaje,"visibilidadReportar" => "hidden"]);

        } else {
            $error = "Hubo un error al reportar la pregunta";
            $this->presenter->render("view/preguntasView.mustache", ["error" => $error]);
        }
    }


}
