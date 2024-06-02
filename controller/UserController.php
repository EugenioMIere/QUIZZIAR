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

            $usuario = $this->model->getUserDetailsLobby($userId);

            $this->presenter->render("view/perfilPropioView.mustache", [$usuario => $usuario]);
        }
    }

}