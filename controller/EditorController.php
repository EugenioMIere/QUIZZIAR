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
        $error = "";

        if (isset($_POST['idPreguntaAEliminar'])){
            $id = $_POST['idPreguntaAEliminar'];
            $resultado = $this->model->eliminarPregunta($id);

            if ($resultado){
                $mensaje = "La pregunta ha sido eliminada exitosamente";
            } else {
                $error = "Hubo un error al intentar eliminar la pregunta";
            }
        } else {
            $error = "No se recibió el ID de la pregunta para eliminar";
        }

        $this->presenter->render("view/editorView.mustache", ["mensaje" => $mensaje, "error" => $error]);
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

        $respuestas = [
            '0' => isset($_POST['respuestaCorrecta']) ? $_POST['respuestaCorrecta'] : '',
            '1' => isset($_POST['respuestaFalsa1']) ? $_POST['respuestaFalsa1'] : '',
            '2' => isset($_POST['respuestaFalsa2']) ? $_POST['respuestaFalsa2'] : '',
            '3' => isset($_POST['respuestaFalsa3']) ? $_POST['respuestaFalsa3'] : ''
        ];

        $this->model->editarPregunta($id, $pregunta, $idCategoria);
        $this->model->editarRespuestas($id, $respuestas);

        $mensaje = "La pregunta ha sido editada correctamente";
            $this->presenter->render("view/editorView.mustache", ["mensaje" => $mensaje]);

    }
    public function verPreguntasReportadas(){
        $reportadas = $this->model->getAllReportadas();

        $this->presenter->render("view/preguntasReportadasView.mustache", ["reportadas" => $reportadas]);
    }

    public function verPreguntasSugeridas(){
        $sugeridas = $this->model->getAllSugeridas();

        $this->presenter->render("view/preguntasSugeridasView.mustache", ["sugeridas" => $sugeridas]);
    }

    public function quitarDeSugeridas(){
        $idPregunta = $_POST['idPregunta'];

        $mensaje = "";
        $error = "";

        if ($this->model->quitarSugerida($idPregunta)){
            $mensaje = "La pregunta sugerida ha sido borrada";
        } else {
            $error = "Lo siento. No hemos podido borrar la pregunta sugerida. Intenta nuevamente más tarde";
        }


        $this->presenter->render("view/preguntasSugeridasView.mustache", ["mensaje" => $mensaje, "error" => $error]);
    }

    public function quitarDeReportadas(){
        $idPregunta = $_POST['idPregunta'];

        $mensaje = "";
        $error = "";

        if ($this->model->quitarReportada($idPregunta)){
            $mensaje = "La pregunta ha sido borrada de 'Reportadas' exitosamente";
        } else {
            $error = "Lo siento. No hemos podido borrar la pregunta reportada. Intenta nuevamente más tarde";
        }

        $this->presenter->render("view/preguntasReportadasView.mustache", ["mensaje" => $mensaje, "error" => $error]);
    }

    public function irACrearPregunta(){
        $this->presenter->render("view/crearPreguntaView.mustache");
    }
    public function crearPregunta(){
        $pregunta = $_POST['pregunta'];
        $categoria = $_POST['categoria'];

        $respuestasI = [
            '0' => isset($_POST['respuestaCorrectaI']) ? $_POST['respuestaCorrectaI'] : '',
            '1' => isset($_POST['respuestaFalsa1I']) ? $_POST['respuestaFalsa1I'] : '',
            '2' => isset($_POST['respuestaFalsa2I']) ? $_POST['respuestaFalsa2I'] : '',
            '3' => isset($_POST['respuestaFalsa3I']) ? $_POST['respuestaFalsa3I'] : ''
        ];

        $this->model->crearPregunta($pregunta, $categoria);
        $id = $this->model->lastInsertId();
        $this->model->crearRespuestas($id, $respuestasI);

        $mensaje = "La pregunta ha sido creada con éxito";

        $this->presenter->render("view/crearPreguntaView.mustache", ["mensaje" => $mensaje]);
    }


}