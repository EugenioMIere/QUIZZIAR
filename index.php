<?php
session_start();

include_once ("Configuration.php");
$router = Configuration::getRouter();

if (isset($_SESSION['rol'])) {

    $rol = $_SESSION['rol'];
    $controllersValidos = ["admin", "editor", "login", "pregunta", "ranking", "registro", "user"];
    $controller = "login";

    if (isset($_GET['controller'])){
        $controller = $_GET['controller'];

        if ($_SESSION['rol'] === 'editor'){
            switch ($controller){
                case "admin":
                case "pregunta":
                case "ranking":
                case "user":
                    header("Location: /login");
                    break;
            }
        } elseif ($_SESSION['rol'] === 'user'){
            switch ($controller){
                case "admin":
                case "editor":
                    header("Location: /login");
                    break;
            }
        } elseif ($_SESSION['rol'] === 'admin'){
            switch ($controller){
                case "user":
                case "editor":
                case "pregunta":
                case "ranking":
                header("Location: /login");
                    break;
            }
        }
        $action = isset($_GET['action']) ? $_GET['action'] : " ";
    }

}elseif($_GET["controller"]=="login"||$_GET["controller"]=="registro" ) {

        $controller = isset($_GET["controller"]) ? $_GET["controller"] : "" ;
        $action = isset($_GET["action"]) ? $_GET["action"] : "" ;
}else{
    $controller = "login" ;
    $action = "home" ;
}



$router->route($controller, $action);