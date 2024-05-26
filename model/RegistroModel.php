<?php

/*use exception\UsuarioExistente;*/

class RegistroModel
{
    private $database;
    public function __construct ($database){
        $this->database = $database;
    }

    /**
     * @throws UsuarioExistente
     */
    public function add($nombreCompleto, $email, $fechaDeNacimiento, $genero, $pais, $ciudad, $nombreDeUsuario, $password, $fotoDePerfil) {

        // Si el usuario no existe (buscando por email), lo guarda:
        if (!$this->elUsuarioYaExiste($email)){
            $sql = "INSERT INTO `usuario`(`nombreCompleto`, `email`, `fechaDeNacimiento`, `genero`, `pais`, `ciudad`, `nombreDeUsuario`, `password`, `fotoDePerfil`, `rol`)
            VALUES ('$nombreCompleto','$email','$fechaDeNacimiento','$genero','$pais','$ciudad','$nombreDeUsuario','$password','$fotoDePerfil','jugador')";
            $this->database->query($sql);
        } else {

            throw new UsuarioExistente();

        }

        /*$this->database->execute("INSERT INTO `usuario`(`nombreCompleto`, `email`, `fechaDeNacimiento`, `genero`, `pais`, `ciudad`, `nombreDeUsuario`, `password`, `fotoDePerfil`, `rol`)
        VALUES ('$nombreCompleto','$email','$fechaDeNacimiento','$genero','$pais','$ciudad','$nombreDeUsuario','$password','$fotoDePerfil','jugador')");*/

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
        $sql= "SELECT COUNT(*) FROM usuario WHERE email = '$email'";

        $count = $this->database->query($sql);


        if ($count >0){
            return true;
        } return false;




    }

}