<?php
session_start();

include_once ("Configuration.php");
$router = Configuration::getRouter();

if (isset($_SESSION['rol'])) {

    $controller = isset($_GET["controller"]) ? $_GET["controller"] : "" ;
    $action = isset($_GET["action"]) ? $_GET["action"] : "";

}else{

    if ($_GET["controller"]=="login" && $_GET["action"]=="login") {

        $controller = isset($_GET["controller"]) ? $_GET["controller"] : "" ;
        $action = isset($_GET["action"]) ? $_GET["action"] : "" ;
    }else{
        $controller = "login" ;
        $action = "home" ;
    }
}



$router->route($controller, $action);