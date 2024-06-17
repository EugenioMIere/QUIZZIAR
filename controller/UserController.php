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

    public function editar(){
        $id = $_SESSION['id'];

        $usuario = $this->model->getUserDetails($id);

        $this->presenter->render("view/editarPerfilView.mustache", ["usuario" => $usuario]);
    }
}
