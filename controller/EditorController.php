<?php

class EditorController
{

    private $model;
    private $presenter;

    public function __construct ($model, $presenter){
        $this->model = $model;
        $this->presenter = $presenter;
    }
    public function home(){
       $preguntas = $this->model->getAllPreguntas();

        $this->presenter->render("view/editorView.mustache", ["preguntas" => $preguntas]);

    }
    public function eliminarPregunta(){
        $mensaje = "";

        if (isset($_POST['id'])){
            $id = $_POST['id'];
            $resultado = $this->model->eliminarPregunta($id);

            if ($resultado){
                $mensaje = "La pregunta ha sido eliminada exitosamente";
            } else {
                $mensaje = "Hubo un error al intentar eliminar la pregunta";
            }
        } else {
            $mensaje = "No se recibió el ID de la pregunta para eliminar";
        }

        $this->presenter->render("view/editorView.mustache", ["mensaje" => $mensaje]);
    }

    public function editarPregunta(){
        if (isset($_POST['idPreguntaAEditar'])){
            $idPreguntaAEditar = $_POST['idPreguntaAEditar'];

            // Llamo al modelo para obtener todos los datos de la pregunta
            $pregunta = $this->model->getPreguntaPorId($idPreguntaAEditar);

            if ($pregunta){
                // Llamo al modelo para obtener todas las rtas
                $respuestas = $this->model->getRespuestasPorIdPregunta($idPreguntaAEditar);

                // Preparar las respuestas
                $dataRespuestas = [
                    'correcta' => '',
                    'falsa1' => '',
                    'falsa2' => '',
                    'falsa3' => ''
                ];

                $falsas = 0;
                foreach ($respuestas as $respuesta) {
                    if ($respuesta['es_correcta']) {
                        $dataRespuestas['correcta'] = $respuesta['respuesta'];
                    } else {
                        $dataRespuestas['falsa' . ++$falsas] = $respuesta['respuesta'];
                    }
                }

                $data = [
                    'pregunta' => $pregunta,
                    'respuestas' => $dataRespuestas,
                    'nPregunta' => $idPreguntaAEditar
                ];

                $this->presenter->render("view/editarPreguntaView.mustache", $data);
            } else {
                $error = "La pregunta no existe o no se pudo cargar";
                $this->presenter->render("view/editorView.mustache", ["error" => $error]);
            }
        } else {
            $error = "No se recibió el ID de la pregunta para editar";
            $this->presenter->render("view/editorView.mustache", ["error" => $error]);
        }

    }

    public function guardarEdicionPregunta(){
        $id = $_POST['idPregunta'];
        $pregunta = $_POST['pregunta'];
        $idCategoria = $_POST['categoria'];

        /*$respuestas = [
            'respuestaCorrecta' => $_POST['respuestaCorrecta'],
            'respuestaFalsa1' => $_POST['respuestaFalsa1'],
            'respuestaFalsa2' => $_POST['respuestaFalsa2'],
            'respuestaFalsa3' => $_POST['respuestaFalsa3']
        ];*/
        $respuestas = [
            '0' => isset($_POST['respuestaCorrecta']) ? $_POST['respuestaCorrecta'] : '',
            '1' => isset($_POST['respuestaFalsa1']) ? $_POST['respuestaFalsa1'] : '',
            '2' => isset($_POST['respuestaFalsa2']) ? $_POST['respuestaFalsa2'] : '',
            '3' => isset($_POST['respuestaFalsa3']) ? $_POST['respuestaFalsa3'] : ''
        ];

        $this->model->editarPregunta($id, $pregunta, $idCategoria);
        $this->model->editarRespuestas($id, $respuestas);

    }

    public function agregarPregunta(){

    }


}