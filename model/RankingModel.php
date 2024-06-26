<?php

class RankingModel
{
    private $database;

    public function __construct ($database){
        $this->database = $database;
    }

    public function getRanking(){
        // foto de perfil | nombre | puntos de partida > visualizacion de ranking
        $sql = "SELECT SUM(p.correctas) AS total_correctas, u.id, u.nombreDeUsuario, u.fotoDePerfil 
        FROM partidas p JOIN usuario u ON p.usuario_id = u.id 
        GROUP BY u.id, u.nombreDeUsuario, u.fotoDePerfil 
        ORDER BY total_correctas DESC";

        // Cada fila del resultado como un array asociativo
        $ranking = $this->database->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        foreach($ranking as $i => $user){
            $ranking[$i]['ranking'] = $i + 1;
        }

        return $ranking;
    }

}