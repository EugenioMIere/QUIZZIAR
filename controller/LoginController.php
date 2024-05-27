<?php

class LoginController
{
    private $model;
    private $presenter;

    public function __construct($model, $presenter) {
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function login() {
        $usuarioBuscado = $this->datosLoginCompletos();
        if ($usuarioBuscado) {
            $emailLogin = $usuarioBuscado['emailLogin'];
            $passwordLogin = $usuarioBuscado['passwordLogin'];

            $result = $this->model->logIn($emailLogin, $passwordLogin);
            if (count($result) > 0) {
                session_start();
                $_SESSION['id'] = $result[0]['id'];
                $_SESSION['rol'] = $result[0]['rol'];
                $rol = $_SESSION['rol'];
                $url = $this->manejoDeUrls($rol);
                $this->redirect($url);
            }
        } else {
            $error = "Email o contraseña incorrectos";
            $this->presenter->render("view/loginView.mustache", ['error' => $error]);
        }
    }

    private function manejoDeUrls($rol): string {
        $url = "";

        switch ($rol) {
            case 'administrador':
                $url = "view/adminView.mustache";
                break;
            case 'usuario':
                $url = "view/usuarioView.mustache";
                break;
            case 'editor':
                $url = "view/editorView.mustache";
                break;
        }
        return $url;
    }

    private function datosLoginCompletos() {
        if (isset($_POST['emailLogin']) && isset($_POST['passwordLogin'])) {
            return [
                "emailLogin" => $_POST['emailLogin'],
                "passwordLogin" => $_POST['passwordLogin']
            ];
        }
        return false;
    }

    private function redirect($url) {
        header("Location: " . $url);
        exit();
    }
}
