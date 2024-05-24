<?php

class RegistroModel
{
    private $database;
    public function __construct ($database){
        $this->database = $database;
    }

    public function add($nombreCompleto, $email, $fechaDeNacimiento, $genero, $pais, $ciudad,$nombreDeUsuario, $password, $fotoDePerfil){
        $sql = "INSERT INTO usuario (nombreCompleto, email, fechaDeNacimiento, genero, pais, ciudad, nombreDeUsuairo, password, fotoDePerfil) 
        VALUES ($nombreCompleto, $email, $fechaDeNacimiento, $genero, $pais, $ciudad, $nombreDeUsuario, $password, $fotoDePerfil)";
    }

}