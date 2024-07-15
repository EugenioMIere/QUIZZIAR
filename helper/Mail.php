<?php
/*namespace controller;*/
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class Mail
{
    /**
     * @var mixed
     */
    private $mail;
    /**
     * @var mixed
     */
    private $password;

    public function __construct ($mail, $password){
        $this->mail = $mail;
        $this->password = $password;
    }
    public function enviar($correoReceptor, $nombreReceptor, $token, $correoRemitente, $nombreRemitente)
    {


        $enlaceVerificacion = 'http://localhost/registro/verificarUsuario?token=' . $token . '&email=' . $correoReceptor;

        $mailer = new PHPMailer(true);



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

        $mailer->Username = $this->mail;
        $mailer->Password = $this->password;

        $mailer->setFrom($correoRemitente, $nombreRemitente);

        $mailer->addAddress($correoReceptor, $nombreReceptor);

        $mailer->isHTML(true);
        $mailer->Subject = 'Verificacion de Registro en QUIZZIAR';
        $mailer->Body = '<h1>¡Hola ' . $nombreReceptor . '!</h1><br> <h3>¡Gracias por registrarte! <br> Por favor, haz clic en el siguiente enlace para verificar tu cuenta: <a href="' . $enlaceVerificacion . '">Verificar cuenta</a></h3>';
        $mailer->send();



    }

}