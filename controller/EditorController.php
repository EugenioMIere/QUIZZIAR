<?php

class EditorController
{

    private $model;
    private $presenter;

    public function __construct ($model, $presenter){
        $this->model = $model;
        $this->presenter = $presenter;
    }


    public function home()
    {
        $this->presenter->render("view/editorView.mustache");
    }

    public function getAllPreguntas(){
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

                $data = [
                    'pregunta' => $pregunta,
                    'respuestas' => $respuestas
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

    }

    public function agregarPregunta(){

    }


}