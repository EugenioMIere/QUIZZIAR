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
        $this->presenter->render("view/preguntasView.mustache", ["preguntas" => $preguntas]);
    }
    public function validarPregunta(){
        if (isset($_POST["respuesta"])){
            $respuesta = $_POST["respuesta"];
            $id = $_GET["idPregunta"];
            $respuestaCorrecta = $this->getRespuestaCorrecta($id);

            if ($respuestaCorrecta==$respuesta ){
                $respuestaCorrecta = "Correcto";
                $this->presenter->render("view/preguntasView.mustache", ["respuestaCorrecta" => $respuestaCorrecta]);
                exit();
            }else  {
                $this->presenter->render("view/preguntasView.mustache", ["respuestaCorrecta" => $respuestaCorrecta]);
            }

        }


    }

    private function getRespuestaCorrecta($id){

        return $this->model->getRespuesta($id);
    }

}