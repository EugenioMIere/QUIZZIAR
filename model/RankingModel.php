<?php

class RankingModel
{
    private $database;

    public function __construct ($database){
        $this->database = $database;
    }

    public function getRanking(){
        // foto de perfil | nombre | puntos de partida > visualizacion de ranking
        $sql = "SELECT 
        u.id, u.fotoDePerfil, u.nombreDeUsuario, SUM(p.correctas) AS total_correctas
        FROM  usuario u JOIN partidas p 
        ON u.id = p.usuario_id 
        GROUP BY u.id, u.fotoDePerfil, u.nombreDeUsuario 
        ORDER BY total_correctas DESC";

        $ranking = $this->database->query($sql);

        return $ranking;

    }

}