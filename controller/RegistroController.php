<?php

use exception\UsuarioExistente;

class RegistroController
{
    private $model;
    private $presenter;
    private $mail;

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
            $fotoDePerfil = $_FILES['fotoDePerfil'];



            if (!$this->elEmailEsValido($email)) {
                $error = "El correo electrónico no es válido";
                $this->presenter->render("view/registroView.mustache", ['error' => $error]);
                return ;
            }

            if ($this->passwordsIguales($password, $repitePassword)){
                try {
                    $token = uniqid();

                    // Manejo de la foto de perfil
                    if ($fotoDePerfil){
                        $file_name = $_FILES['fotoDePerfil']['name'];
                        $file_tmp = $_FILES['fotoDePerfil']['tmp_name'];
                        $upload_folder = 'public/uploads/';
                        $file_path = $upload_folder . $file_name;
                        move_uploaded_file($file_tmp, $_SERVER['DOCUMENT_ROOT'] . '/' . $file_path);
                        $fotoDePerfil = $file_path;
                    }

                    $this->model->add($nombreCompleto, $email, $fechaDeNacimiento, $genero, $pais, $ciudad, $nombreDeUsuario, $password, $fotoDePerfil, $token);

                    if ($this->enviarEmailRegistro($email, $nombreCompleto, $token)) {

                        echo 'Se envió un correo de verificación.';
                        $this->presenter->render("view/verificaTuCorreoView.mustache"/*, [$error => $error]*/);
                    }else {
                        echo 'ERROR.';
                        header('Location:/registro?error=ERROR-EMAIL');
                        exit();
                    }
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
        isset($_POST['nombreDeUsuario']) && isset($_POST['password']) && isset($_POST['repitePassword']) &&
        isset($_FILES['fotoDePerfil'])){

          return $usuarioARegistrar = [
              "nombreCompleto" => $_POST['nombreCompleto'],
              "email" => $_POST['email'],
              "fechaDeNacimiento" => $_POST['fechaDeNacimiento'],
              "genero" => $_POST['genero'],
              "pais" => $_POST['pais'],
              "ciudad" => $_POST['ciudad'],
              "nombreDeUsuario" => $_POST['nombreDeUsuario'],
              "password" => $_POST['password'],
              "repitePassword"=> $_POST['repitePassword'],

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

    /**
     * @throws Exception
     */
    public function enviarEmailRegistro($email, $nombreCompleto, $token)
    {
            $this->model->sendMail($email,$nombreCompleto, $token);
            header('Location:/registro/pedirConfirmacionDeCorreo');
            exit();

    }
    public function verificarUsuario()
    {
        $tokenCod = $_GET['token'];
        $emailCod = $_GET['email'];


        if (isset($_GET['token']) && isset($_GET['email'])) {

            $usuarioVerificado = $this->model->verificarToken($tokenCod, $emailCod);

            if ($usuarioVerificado) {

                header('Location: /login/login');/*?EXITO=1*/
            } else {
                header('Location:/error?codError=333');
            }
            exit();
        } else {
            header('Location:/error?codError=222');
            exit();
        }
    }
    public function pedirConfirmacionDeCorreo(){
        $this->presenter->render("view/verificaTuCorreoView.mustache");
    }
}