<?php

include_once 'controller/RegistroController.php';
include_once 'controller/LoginController.php';
include_once 'controller/UserController.php';
include_once 'controller/PreguntaController.php';
include_once 'controller/EditorController.php';
include_once 'controller/AdminController.php';
include_once 'controller/RankingController.php';
include_once ('controller/PDFController.php');
include_once ('controller/RankingController.php');


include_once 'model/RegistroModel.php';
include_once 'model/LoginModel.php';
include_once 'model/UserModel.php';
include_once 'model/PreguntaModel.php';
include_once 'model/EditorModel.php';
include_once 'model/AdminModel.php';
include_once 'model/RankingModel.php';

include_once 'helper/Database.php';
include_once 'helper/Router.php';
include_once 'helper/MustachePresenter.php';
include_once 'helper/Presenter.php';

include_once('vendor/mustache/src/Mustache/Autoloader.php');
include_once('vendor/PHPMailer-master/src/PHPMailer.php');
include_once('vendor/PHPMailer-master/src/Exception.php');
include_once('vendor/PHPMailer-master/src/SMTP.php');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

    public static function getUserController(): UserController
    {
        return new UserController(self::getUserModel(), self::getPresenter());
    }

    public static function getPreguntaController(): PreguntaController
    {
        return new PreguntaController(self::getPreguntaModel(), self::getPresenter());
    }

    public static function getRankingController(): RankingController
    {
        return new RankingController(self::getRankingModel(), self::getPresenter());
    }

    public static function getEditorController(): EditorController
    {
        return new EditorController(self::getEditorModel(), self::getPresenter());
    }

    public static function getAdminController(): AdminController
    {
        return new AdminController(self::getAdminModel(), self::getPresenter());
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
    
    private static function getUserModel(): UserModel
    {
        return new UserModel(self::getDatabase());
    }

    private static function getPreguntaModel(): PreguntaModel
    {
        return new PreguntaModel(self::getDatabase());
    }

    private static function getRankingModel(): RankingModel
    {
        return new RankingModel(self::getDatabase());
    }

    private static function getEditorModel(): EditorModel
    {
        return new EditorModel(self::getDatabase());
    }

    private static function getAdminmodel(): AdminModel
    {
        return new AdminModel(self::getDatabase());
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

    public function getPDFController() {
        return new PDFController();
    }


}
