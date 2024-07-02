<?php
session_start();

include_once ("Configuration.php");
$router = Configuration::getRouter();

if (isset($_SESSION['rol'])) {

    $controller = isset($_GET["controller"]) ? $_GET["controller"] : "" ;
    $action = isset($_GET["action"]) ? $_GET["action"] : "";

}elseif($_GET["controller"]=="login"||$_GET["controller"]=="registro" ) {

        $controller = isset($_GET["controller"]) ? $_GET["controller"] : "" ;
        $action = isset($_GET["action"]) ? $_GET["action"] : "" ;
}else{
    $controller = "login" ;
    $action = "home" ;
}



$router->route($controller, $action);