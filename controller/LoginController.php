<?php

class LoginController
{
    private $model;
    private $presenter;


    public function __construct($model, $presenter) {
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function mostrarLogin(){
        $this->presenter->render("view/loginView.mustache");
    }

    public function home()
    {
        if ($_SESSION['rol'] === "usuario"){
            $this->presenter->render("view/usuarioView.mustache");
        }elseif ($_SESSION['rol'] === "editor"){
            header('Location:/editor');
            exit();
            /*$this->presenter->render("view/editorView.mustache");*/
        }elseif ($_SESSION['rol'] === "admin"){
            $this->presenter->render("view/adminView.mustache");
        }

    }

    public function login() {
        $url="";

        $usuarioBuscado = $this->datosLoginCompletos();
        if ($usuarioBuscado) {
            $emailLogin = $usuarioBuscado['emailLogin'];
            $passwordLogin = $usuarioBuscado['passwordLogin'];

            $result = $this->model->logIn($emailLogin, $passwordLogin);
            if (count($result) > 0) {
                $_SESSION['id'] = $result[0]['id'];
                $_SESSION['rol'] = $result[0]['rol'];
                $rol = $_SESSION['rol'];
                $url = $this->manejoDeUrls($rol);
                $this->redirect($url);
            } else {
                $error = "Email o contraseña incorrectos";
                $this->presenter->render("view/loginView.mustache", ['error' => $error]);
            }
        } else {
            $error = "Complete todos los campos";
            $this->presenter->render("view/loginView.mustache", ['error' => $error]);
        }
        return $url;
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
            default:
                $url = "view/loginView.mustache";
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