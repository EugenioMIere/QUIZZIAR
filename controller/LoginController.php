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
        if (!empty($_SESSION['rol'])){
            $this->sessionRedirect();
        }else{
            $this->mostrarLogin();
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
                $this->presenter->render("view/loginView.mustache", ['rol' => $_SESSION['rol']]);
                $this->home();
            } else {
                $error = "Email o contraseña incorrectos, o usuario no activo";
                $this->presenter->render("view/loginView.mustache", ['error' => $error]);
            }
        } else {
            $error = "Complete todos los campos";
            $this->presenter->render("view/loginView.mustache", ['error' => $error]);
        }
        return $url;
    }

    public function logout(){
        unset($_SESSION['id']);
        unset($_SESSION['rol']);
        $this->presenter->render("view/loginView.mustache");
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

    private function sessionRedirect()
    {
        if ($_SESSION['rol'] === "usuario"){
            header('Location:/user/lobby');
            exit();

        }elseif ($_SESSION['rol'] === "editor"){
            header('Location:/editor');
            exit();

        }elseif ($_SESSION['rol'] === "administrador"){
            header('Location:/admin');
            exit();
        }

    }

}