<?php

class UserController
{
    private $model;
    private $presenter;

    public function __construct($model, $presenter){
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function home(){
        $idUsuario = $_SESSION['id'];
        $usuario = $this->model->getUserDetails($idUsuario);
        $this->presenter->render("view/miPerfilView.mustache", ["usuario" => $usuario]);
    }

    public function header(){
        $idUsuario = $_SESSION['id'];
        $usuario = $this->model->getUserDetails($idUsuario);
        $this->presenter->render("view/template/header.mustache", ["usuario" => $usuario]);
    }

    public function redirigirNuevaPartida()
    {
        $userId = $_SESSION['id'];
        $this->model->registrarPartida($userId);
        $this->presenter->render("view/jugarPartidaInicio.mustache");
    }


    public function redirigirDatosUsuario()
    {
        $this->presenter->render("view/miPerfilView.mustache");
    }

    public function redirigirRanking()
    {
        $this->presenter->render("view/verRankingView.mustache");
    }

    public function redirigirAMisPartidas(){
        $this->presenter->render("view/misPartidasView.mustache");
    }

    public function irASugerirPreguntas(){
        $this->presenter->render("view/sugerirPreguntaView.mustache");
    }

    public function sugerirPregunta(){
        if (isset($_POST['preguntaSugerida'])){
            $result = $this->model->sugerirPregunta($_POST['preguntaSugerida']);

            if ($result){
                $success= "La pregunta sugerida se ha enviado correctamente";
                $this->presenter->render("view/sugerirPreguntaView.mustache", ["success" => $success]);
            }

        } else {
            $error = "No se ha enviado ninguna pregunta. Intente nuevamente";
            $this->presenter->render("view/sugerirPreguntaView.mustache", ["error" => $error]);
        }
    }

    public function editarPerfil(){
        $idUser = $_SESSION['id'];
        $usuario = $this->model->getUserDetails($idUser);
        $this->presenter->render("view/editarPerfilView.mustache", ["usuario" => $usuario]);
    }

    public function guardarEdicionPerfil(){
        $idUsuario = $_SESSION['id'];

        $fields = [
            'nombreCompleto' => 'editarNombreComp',
            'email' => 'editarEmail',
            'pais' => 'editarPais',
            'ciudad' => 'editarCiudad',
            'nombreDeUsuario' => 'editarNombreUsuario',
            'genero' => 'editarGenero',
        ];

        if (!empty($_FILES['fotoDePerfil']['name'])) {

            $file_name = $_FILES['fotoDePerfil']['name'];
            $file_tmp = $_FILES['fotoDePerfil']['tmp_name'];
            $upload_folder = 'public/uploads/';
            $file_path = $upload_folder . $file_name;
            move_uploaded_file($file_tmp, $_SERVER['DOCUMENT_ROOT'] . '/' . $file_path);
            $this->model->editarFoto($file_path, $idUsuario);
        }

        foreach ($fields as $field => $method){
            if (isset($_POST['$field'])){
                $this->model->$method($_POST['$field'], $idUsuario);
            }
        }
    }

}
