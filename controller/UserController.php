<?php

class UserController
{
    private $model;
    private $presenter;

    public function __construct($model, $presenter){
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function obtenerDetallesDelUsuario(){
        if(isset($_SESSION['id'])){
            $userId = $_SESSION['id'];
            $usuario = $this->model->getUserDetails($userId);
            $this->presenter->render("view/perfilPropioView.mustache", [$usuario => $usuario]);
        }
    }

    public function obtenerInformacionLobby(){
        if(isset($_SESSION['id'])){
            $userId = $_SESSION['id'];
            $usuario = $this->model->getUserDetails($userId);
            $this->presenter->render("view/perfilPropioView.mustache", [$usuario => $usuario]);
        }
    }

    public function obtenerInformacionHeader(){
        if (isset($_SESSION['id'])){
            $userId = $_SESSION['id'];
            $usuario = $this->model->getUserDetails($userId);
            $this->presenter->render("view/template/header.mustache", [$usuario => $usuario]);
        }
    }

    public function redirigirNuevaPartida()
    {
        $userId = $_SESSION['id'];
        $this->model->registrarPartida($userId);
        $this->presenter->render("view/jugarPartidaInicio.mustache");
    }


    public function redirigirDatosUsuario()
    {
        $this->presenter->render("view/perfilPropioView.mustache");
    }

    public function redirigirRanking()
    {
        $this->presenter->render("view/verRankingView.mustache");
    }

    public function redirigirAMisPartidas(){
        $this->presenter->render("view/misPartidasView.mustache");
    }
}
