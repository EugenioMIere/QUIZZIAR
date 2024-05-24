<?php

use controller\RegistroController;
use helper\Database;
use helper\MustachePresenter;
use helper\Router;

class Configuration {
    // CONTROLLERS

    public static function getRegistroController(){
        return new RegistroController(self::getRegistroModel(), self::getPresenter());
    }

    // MODELS
    public static function getRegistroModel(){
        return new RegistroModel(self::getDatabase());
    }

    // HELPERS
    public static function getDatabase(){
        $config = self::getConfig();
        return new Database($config["servername"], $config["username"], $config["password"], $config["database"]);
    }
    private static function getConfig(){
        return parse_ini_file("config/config.ini");
    }

    public static function getRouter()
    {
        return new Router("getPublicController", "home" );
    }

    private static function getPresenter()
    {
        return new MustachePresenter("view/template");
    }
}