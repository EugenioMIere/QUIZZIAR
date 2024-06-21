<?php

class AdminController
{
    private $model;
    private $presenter;

    public function __construct($model, $presenter)
    {
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function home()
    {
        $this->presenter->render("view/adminView.mustache");
    }

    public function getCantidadDeUsuarios(){
        $filtros['fechaDesde'] = $_POST['fechaDesde'] ?? "";
        $filtros['fechaHasta'] = $_POST['fechaHasta'] ?? "";

        $usuarios = $this->model->getCantidadDeUsuarios($filtros);

    }

    public function getCantidadPartidasJugadas(){
        $filtros['fechaDesde'] = $_POST['fechaDesde'] ?? "";
        $filtros['fechaHasta'] = $_POST['fechaHasta'] ?? "";

        $partidasJugadas = $this->model->getCantidadPartidasJugadas($filtros);
    }

    public function getCantidadPreguntas(){
        $filtros['fechaDesde'] = $_POST['fechaDesde'] ?? "";
        $filtros['fechaHasta'] = $_POST['fechaHasta'] ?? "";

        $cantidadPreguntas = $this->model->getCantidadPreguntas($filtros);
    }

    public function getCantidadSugeridas(){
        $filtros['fechaDesde'] = $_POST['fechaDesde'] ?? "";
        $filtros['fechaHasta'] = $_POST['fechaHasta'] ?? "";

        $cantidadSugeridas = $this->model->getCantidadSugeridas($filtros);
    }

    public function getPorcentajeCorrectasPorUsuario(){
        $filtros['fechaDesde'] = $_POST['fechaDesde'] ?? "";
        $filtros['fechaHasta'] = $_POST['fechaHasta'] ?? "";

        $porcentajeUsuarios = $this->model->getPorcentajeCorrectasPorUsuario($filtros);
    }

    public function getCantidadDeUsuariosPorPais(){
        $filtros['fechaDesde'] = $_POST['fechaDesde'] ?? "";
        $filtros['fechaHasta'] = $_POST['fechaHasta'] ?? "";

        $usuariosPorPais = $this->model->getCantidadDeUsuariosPorPais($filtros);
    }

    public function getCantidadDeUsuariosPorGenero()
    {
        $filtros['fechaDesde'] = $_POST['fechaDesde'] ?? "";
        $filtros['fechaHasta'] = $_POST['fechaHasta'] ?? "";

    $usuariosPorGenero = $this->model->getCantidadDeUsuariosPorGenero($filtros);
    }

    public function getCantidadDeUsuariosPorGrupoDeEdad()
    {
        $filtros['fechaDesde'] = $_POST['fechaDesde'] ?? "";
        $filtros['fechaHasta'] = $_POST['fechaHasta'] ?? "";

        $usuariosPorGrupoDeEdad = $this->model->getCantidadDeUsuariosPorGrupoDeEdad($filtros);
    }


}