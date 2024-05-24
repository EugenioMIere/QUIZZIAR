<?php

namespace controller;

use exception\UsuarioExistente;

class RegistroController
{
    private $model;
    private $presenter;

    public function __construct ($model, $presenter){
        $this->model = $model;
        $this->presenter = $presenter;
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
            $fotoDePerfil = $usuarioValido['fotoDePerfil'];

            if ($this->passwordsIguales($password, $repitePassword)){
                try {
                    $this->model->add($nombreCompleto, $email, $fechaDeNacimiento, $genero, $pais, $ciudad, $nombreDeUsuario,
                        $password, $fotoDePerfil);
                    header("Location: view/login.mustache");
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
        isset($_POST['nombreDeUsuario']) && isset($_POST['password']) && isset($_POST['repitePassword']) &&
        isset($_POST['fotoDePerfil'])){
          return $usuarioARegistrar = [
              "nombreCompleto" => $_POST['nombreCompleto'],
              "email" => $_POST['email'],
              "fechaDeNacimiento" => $_POST['fechaDeNacimiento'],
              "genero" => $_POST['genero'],
              "pais" => $_POST['pais'],
              "ciudad" => $_POST['ciudad'],
              "nombreDeUsuario" => $_POST['nombreDeUsuario'],
              "password" => $_POST['repitePassword'],
              "fotoDePerfil" => $_POST['fotoDePerfil']
          ];
        } return false;
    }

    private function passwordsIguales($password, $repitePassword){
        if ($password === $repitePassword){
            return true;
        } return false;
    }
}