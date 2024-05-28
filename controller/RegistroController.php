<?php

/*namespace controller;*/

include_once 'exception/UsuarioExistente.php';

use exception\UsuarioExistente;


class RegistroController
{
    private $model;
    private $presenter;

    public function __construct ($model, $presenter){
        $this->model = $model;
        $this->presenter = $presenter;
    }


    public function home()
    {
        $this->presenter->render("view/registroView.mustache");
    }
    public function registrar(){
        $usuarioValido = $this->tengoLaInfoCompleta();

        if ($usuarioValido){
            $nombreCompleto = $usuarioValido['nombreCompleto'];
            $email = $usuarioValido['email'];
            $fechaDeNacimiento = $usuarioValido['fechaDeNacimiento'];
            $genero = $usuarioValido['genero'];
            $pais = $usuarioValido['pais'];
            $ciudad = $usuarioValido['ciudad'];
            $nombreDeUsuario = $usuarioValido['nombreDeUsuario'];
            $password = $usuarioValido['password'];
            $repitePassword = $usuarioValido['repitePassword'];
            /*$fotoDePerfil = $usuarioValido['fotoDePerfil'];*/



            if (!$this->elEmailEsValido($email)) {
                $error = "El correo electrónico no es válido";
                $this->presenter->render("view/registroView.mustache", ['error' => $error]);
                return ;
            }

            if ($this->passwordsIguales($password, $repitePassword)){
                try {
                    $this->model->add($nombreCompleto, $email, $fechaDeNacimiento, $genero, $pais, $ciudad, $nombreDeUsuario, $password, "prueba"/*$fotoDePerfil*/);
                    header("Location: /login/login");
                    exit();
                } catch (UsuarioExistente $ex){
                    $error = "El usuario ya existe";
                    $this->presenter->render("view/registroView.mustache", [$error => $error]);
                }
            } else {
                $error = "Las contraseñas no coinciden";
                $this->presenter->render("view/registroView.mustache", [$error => $error]);
            }

        } else {
            $error = "Por favor, complete todos los campos del formulario";
            $this->presenter->render("view/registroView.mustache", [$error => $error]);
        }
    }

    private function tengoLaInfoCompleta(){
        if (isset($_POST['nombreCompleto']) && isset($_POST['email']) && isset($_POST['fechaDeNacimiento'])  &&
        isset($_POST['genero']) && isset($_POST['pais']) && isset($_POST['ciudad']) &&
        isset($_POST['nombreDeUsuario']) && isset($_POST['password']) && isset($_POST['repitePassword']) /*&&
            isset($_POST['fotoDePerfil'])? $_POST['fotoDePerfil'] : ''*/){

          return $usuarioARegistrar = [
              "nombreCompleto" => $_POST['nombreCompleto'],
              "email" => $_POST['email'],
              "fechaDeNacimiento" => $_POST['fechaDeNacimiento'],
              "genero" => $_POST['genero'],
              "pais" => $_POST['pais'],
              "ciudad" => $_POST['ciudad'],
              "nombreDeUsuario" => $_POST['nombreDeUsuario'],
              "password" => $_POST['password'],
              "repitePassword"=> $_POST['repitePassword']

          ];

        } return false;

    }

    private function passwordsIguales($password, $repitePassword)
    {
        if ($password === $repitePassword){
            return true;
        } return false;
    }

    private function elEmailEsValido($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)){
            return true;
        } return false;
    }
}