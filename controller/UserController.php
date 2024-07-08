<?php
class UserController
{

    private $model;
    private $presenter;

    public function __construct($model, $presenter){
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function home(){
        $idUsuario = $_SESSION['id'];
        $usuario = $this->model->getUserDetails($idUsuario);

        // Verificar si los datos del usuario son válidos
        if ($usuario) {
            // Crear el texto con la información del usuario
            $userInfo = "Nombre: " . (isset($usuario['nombre']) ? $usuario['nombre'] : 'N/A') . "\n";
            $userInfo .= "Email: " . (isset($usuario['email']) ? $usuario['email'] : 'N/A') . "\n";
            $userInfo .= "Ciudad: " . (isset($usuario['ciudad']) ? $usuario['ciudad'] : 'N/A') . "\n";
            $userInfo .= "Nombre de Usuario: " . (isset($usuario['nombreDeUsuario']) ? $usuario['nombreDeUsuario'] : 'N/A') . "\n";
            $userInfo .= "Género: " . (isset($usuario['genero']) ? $usuario['genero'] : 'N/A') . "\n";

            // Generar el QR Code
            include($_SERVER['DOCUMENT_ROOT'] . '/phpqrcode/qrlib.php');

            $qrDir = $_SERVER['DOCUMENT_ROOT'] . '/public/qrcodes/';
            if (!is_dir($qrDir)) {
                mkdir($qrDir, 0755, true);
            }

            $qrFilePath = $qrDir . 'user_' . $idUsuario . '.png';
            QRcode::png($userInfo, $qrFilePath);

            // Pasar la URL del QR Code a la vista
            $this->presenter->render("view/lobby.mustache", [
                "usuario" => $usuario,
                "rol" => $_SESSION['rol'],
                "qr_url" => '/public/qrcodes/user_' . $idUsuario . '.png'
            ]);
        } else {
            echo 'Error: Datos de usuario no encontrados';
        }
    }

    public function redirigirNuevaPartida()
    {
        $userId = $_SESSION['id'];

        $this->model->registrarPartida($userId);
        $this->presenter->render("view/jugarPartidaInicio.mustache");
    }

    public function redirigirDatosUsuario()
    {
        $idUsuario = $_SESSION['id'];
        $usuario = $this->model->getUserDetails($idUsuario);
        $this->presenter->render("view/miPerfilView.mustache", ["usuario" => $usuario]);
    }

    public function irAPreguntasFrecuentes(){
        $this->presenter->render("view/preguntasFrecuentes.mustache");
    }

    public function redirigirRanking()
    {
        header('Location:/ranking/mostrarRanking');
        exit();
    }

    public function redirigirAMisPartidas(){
        $this->presenter->render("view/misPartidasView.mustache");
    }

    public function irASugerirPreguntas(){
        $this->presenter->render("view/sugerirPreguntaView.mustache");
    }

    public function sugerirPregunta(){
        if (isset($_POST['preguntaSugerida'])){
            $result = $this->model->sugerirPregunta($_POST['preguntaSugerida']);

            if ($result){
                $success= "La pregunta sugerida se ha enviado correctamente";
                $this->presenter->render("view/sugerirPreguntaView.mustache", ["success" => $success]);
            }

        } else {
            $error = "No se ha enviado ninguna pregunta. Intente nuevamente";
            $this->presenter->render("view/sugerirPreguntaView.mustache", ["error" => $error]);
        }
    }

    public function editarPerfil(){
        $idUser = $_SESSION['id'];
        $usuario = $this->model->getUserDetails($idUser);
        $this->presenter->render("view/editarPerfilView.mustache", ["usuario" => $usuario]);
    }

    public function guardarEdicionPerfil(){
        $idUsuario = $_SESSION['id'];

        $fields = [
            'nombreCompleto' => 'editarNombreComp',
            'email' => 'editarEmail',
            'pais' => 'editarPais',
            'ciudad' => 'editarCiudad',
            'nombreDeUsuario' => 'editarNombreUsuario',
            'genero' => 'editarGenero',
            'pais' => 'editarPais',
            'ciudad' => 'editarCiudad'
        ];

        if (!empty($_FILES['fotoDePerfil']['name'])) {

            $file_name = $_FILES['fotoDePerfil']['name'];
            $file_tmp = $_FILES['fotoDePerfil']['tmp_name'];
            $upload_folder = 'public/uploads/';
            $file_path = $upload_folder . $file_name;
            move_uploaded_file($file_tmp, $_SERVER['DOCUMENT_ROOT'] . '/' . $file_path);
            $this->model->editarFoto($file_path, $idUsuario);
        }

        foreach ($fields as $field => $method){
            if ((!empty($_POST[$field]))){
                $this->model->$method($_POST[$field], $idUsuario);
            }
        }

        $usuario = $this->model->getUserDetails($idUsuario);
        $this->presenter->render("view/miPerfilView.mustache", ["usuario" => $usuario]);
    }


    public function irAAgregarRedes(){
        $this->presenter->render("view/agregarRedSocialView.mustache");
    }

    public function agregarRedes(){
        $idUser = $_SESSION['id'];

        $fields = [
           'pagina_web' => ($_POST['pagina_web']),
            'github' => ($_POST['github']),
            'twitter' => ($_POST['twitter']),
            'instagram' => ($_POST['instagram']),
            'facebook' => ($_POST['facebook']),
        ];

        foreach ($fields as $red => $content){
            if (!empty($_POST[$red])){
                $this->model->agregarRed($idUser, $red, $content);
            }
        }

        $redes = $this->model->getRedesSociales($idUser);

        $this->presenter->render("view/miPerfilView.mustache", ["redes" => $redes]);
    }

    public function verPerfilAjeno(){
        $idUsuario = $_POST['id'];

        $usuario = $this->model->getUserDetails($idUsuario);
        $edad = $this->model->getEdad($idUsuario);
        $info = $this->model->getInfoJuego($idUsuario);
        $nivel = $this->getNivelJugador($idUsuario);

        if ($usuario){
            $this->presenter->render("view/perfilAjenoView.mustache", ["usuario" => $usuario, "info" => $info, "nivel" => $nivel, "edad" => $edad]);
        } else {
            $error = "¡Ups! Parece que ha habido un error. Intenta nuevamente más tarde!";
            $this->presenter->render("view/verRankingView.mustache", ["error" => $error]);
        }
    }

    private function getNivelJugador($idUsuario){
        $row = $this->model->getNivelJugador($idUsuario);

        $promedio = $row[0]['promedio_correctas_por_partida'] * 100;

        if ($promedio >= 70) {
            $nivelJugador = 'Avanzado';
        } elseif ($promedio >= 30) {
            $nivelJugador = 'Intermedio';
        } else {
            $nivelJugador = 'Principiante';
        }

        return $nivelJugador;

    }

    public function getMisPartidas(){
        $idUsuario = $_SESSION['id'];
        $partidas = $this->model->obtenerMisPartidas($idUsuario);

        if ($partidas){
            $this->presenter->render("view/misPartidasView.mustache", ["partidas" => $partidas]);
        } else {
            $error = "Aún no tienes un historial de partidas";
            $this->presenter->render("view/misPartidasView.mustache", ["error" => $error]);
        }
    }

    public function redirigirAPerdiste(){
        $idUsuario = $_SESSION['id'];
        $partidas = $this->model->datosPartida($idUsuario);


            $this->presenter->render("view/perdisteView.mustache", ["partidas" => $partidas]);

    }

    public function redirigirAEstadisticasDePartida() {

        $idUsuario = $_SESSION['id'];
        $partidas = $this->model->datosPartida($idUsuario);
        $this->presenter->render("view/resultadoPartida.mustache", ["partidas" => $partidas]);

    }
    public function lobby(){
        $this->presenter->render("view/lobby.mustache");
    }
}
