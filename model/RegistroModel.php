<?php

/*use exception\UsuarioExistente;*/

use exception\UsuarioExistente;

class RegistroModel
{
    private $database;
    public function __construct ($database){
        $this->database = $database;
    }

    /**
     * @throws UsuarioExistente
     */
    public function add($nombreCompleto, $email, $fechaDeNacimiento, $genero, $pais, $ciudad, $nombreDeUsuario, $password, $fotoDePerfil, $token) {

        // Si el usuario no existe (buscando por email), lo guarda:
        if (!$this->elUsuarioYaExiste($email)){
            $sql = "INSERT INTO `usuario`(`nombreCompleto`, `email`, `fechaDeNacimiento`, `genero`, `pais`, `ciudad`, `nombreDeUsuario`, `password` ,`fotoDePerfil`, `rol`, `token`)
            VALUES ('$nombreCompleto','$email','$fechaDeNacimiento','$genero','$pais','$ciudad','$nombreDeUsuario','$password','$fotoDePerfil','editor','$token')";
            $this->database->execute($sql);
        } else {

            throw new UsuarioExistente();

        }

    }
    public function verificarToken($token,$email){

        $sql = "SELECT token from usuario WHERE email = '$email'";
        $tokenDB = $this->database->query($sql);
        if ($token==$tokenDB[0]['token']){
            return true;
        }else{
            return false;
        }

    }

    /* funcion del admin
    public function delete($emailUsuarioAEliminar, $passwordDelUsuario){
        if ($this->elUsuarioYaExiste($emailUsuarioAEliminar)){
            $sql = "DELETE FROM usuario WHERE email = '$emailUsuarioAEliminar'";
            $this->database->query($sql);
        } else {
            throw new UsuarioInexistente();
        }

    } */

    private function elUsuarioYaExiste($email){

        $sql = "SELECT * from usuario WHERE email = '$email'";
        return $this->database->query($sql);

    }

}