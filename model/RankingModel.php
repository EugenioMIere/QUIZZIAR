<?php

class RankingModel
{
    private $database;

    public function __construct ($database){
        $this->database = $database;
    }

    public function getRanking(){
        // foto de perfil | nombre | puntos de partida > visualizacion de ranking
        $sql = "SELECT u.fotoDePerfil as fotoDePerfil, u.nombreDeUsuario as nombreDeUsuario, 
       p.correctas AS total_correctas FROM usuario u JOIN partidas p ON u.id = p.usuario_id
        GROUP BY u.nombre ORDER BY total_correctas DESC";

        // Cada fila del resultado como un array asociativo
        $ranking = $this->database->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        foreach($ranking as $i => $user){
            $ranking[$i]['ranking'] = $i + 1;
        }

        return $ranking;
    }

}