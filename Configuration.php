<?php

include_once 'controller/RegistroController.php';
include_once 'controller/LoginController.php';

include_once 'model/RegistroModel.php';
include_once 'model/LoginModel.php';

include_once 'helper/Database.php';
include_once 'helper/Router.php';
include_once 'helper/MustachePresenter.php';
include_once 'helper/Presenter.php';

include_once('vendor/mustache/src/Mustache/Autoloader.php');

class Configuration {
    // CONTROLLERS

    public static function getRegistroController(): RegistroController
    {
        return new RegistroController(self::getRegistroModel(), self::getPresenter());
    }

    public static function getLoginController(): LoginController
    {
        return new LoginController(self::getLoginModel(), self::getPresenter());
    }

    // MODELS
    private static function getRegistroModel(): RegistroModel
    {
        return new RegistroModel(self::getDatabase());
    }

    private static function getLoginModel(): LoginModel
    {
        return new LoginModel(self::getDatabase());
    }

    // HELPERS
    public static function getDatabase(){
        $config = self::getConfig();
        return new Database($config["servername"], $config["username"], $config["password"], $config["database"]);
    }
    private static function getConfig(){
        return parse_ini_file("config/config.ini");
    }

    public static function getRouter(): Router
    {
        return new Router("getRegistroController", "home" );
    }

    private static function getPresenter(): MustachePresenter
    {
        return new MustachePresenter("view/template");
    }
}
