<?php

class LoginController
{
    private $model;
    private $presenter;

    public function __constructor($model, $presenter){
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function login(){
        $usuarioBuscado = $this->datosLoginCompletos();

        if ($usuarioBuscado){
            $email = $usuarioBuscado['email'];
            $password = $usuarioBuscado['email'];

            $result = $this->model->logIn($email, $password);
            if (count($result) > 0){
                session_start();
                $_SESSION['id'] = $result[0]['id'];
                $_SESSION['rol'] = $result[0]['rol'];
                // Segun el rol del usuario, redirijo:
                $rol = $_SESSION['rol'];
                $url = $this->manejoDeUrls($rol);
                header("Location: $url");
            }
        } else {
            $error = "Email o contraseña incorrectos";
            $this->presenter->render("view/loginView.mustache", [$error => $error]);
        }
    }

    private function manejoDeUrls($rol): string
    {
        $url = "";

        switch ($rol){
            case 'admin':
                $url = "view/adminView.mustache";
                break;
            case 'jugador':
                $url = "view/jugadorView.mustache";
                break;
            case 'editor':
                $url = "view/editorView.mustache";
                break;
        }
        return $url;
    }

    private function datosLoginCompletos(){
        if (isset($_POST['email']) && isset($_POST['password'])){
            return $datosLogin = [
                "email" => $_POST['email'],
               "password" => $_POST['password']
            ];
        } return false;
    }


}