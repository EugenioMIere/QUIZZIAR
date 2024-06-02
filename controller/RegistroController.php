<?php

/*namespace controller;*/
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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
                    $token = uniqid();
                    $this->model->add($nombreCompleto, $email, $fechaDeNacimiento, $genero, $pais, $ciudad, $nombreDeUsuario, $password,"prueba"/*$fotoDePerfil*/, $token);

                    if ($this->enviarEmailRegistro($email, $nombreCompleto, $token)) {

                        echo 'Se envió un correo de verificación.';
                        $this->presenter->render("view/registroView.mustache"/*, [$error => $error]*/);
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

    /**
     * @throws Exception
     */
    public function enviarEmailRegistro($email, $nombreCompleto, $token)
    {

        // Generar enlace verificacion
        $enlaceVerificacion = 'http://localhost/registro/verificarUsuario?token=' . $token . '&email=' . $email;

        $mailer = new PHPMailer(true);
        /*try {*/
            // Configuración del servidor SMTP

            $mailer->SMTPDebug = SMTP::DEBUG_SERVER;
            $mailer->isSMTP();
            $mailer->Host = 'smtp.gmail.com';
            $mailer->SMTPAuth = true;
            $mailer->SMTPSecure = 'ssl';

            $mailer->Port = 465;
            $mailer->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ]
            ];
            $mailer->Username = 'preguntadosweb2@gmail.com';
            $mailer->Password = 'piva gvba qwnu orri';




            // Configuración del remitente y destinatario
            $mailer->setFrom('preguntadosweb2@gmail.com', 'Pregunta2');
            $mailer->addAddress($email, $nombreCompleto);


            // Contenido del correo
            $mailer->isHTML(true);
            $mailer->Subject = 'Verificacion de Registro en Pregunta2';
            $mailer->Body = '<h1>¡Hola ' . $nombreCompleto . '!</h1><br> <h3>¡Gracias por registrarte! <br></br> Por favor, haz clic en el siguiente enlace para verificar tu cuenta: <a href="' . $enlaceVerificacion . '">Verificar cuenta</a></h3>';
            $mailer->send();

            // Redirigir a una vista de éxito
            header('Location:/autenticacion?mail=OK');
            exit();
        /*} catch (Exception $e) {
            header('Location:/autenticacion?mail=BAD');
            exit();
        }*/
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
}