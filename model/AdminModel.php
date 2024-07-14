<?php

class AdminModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }
    public function getUserDetails($userId)
    {
        $sql = "SELECT * from usuario WHERE id = '$userId'";
        return $this->database->query($sql);
    }

    public function getCantidadDeUsuarios($filtros){
        $whereClause = "";
        $fechaDesde = $filtros['fechaDesde'];
        $fechaHasta = $filtros['fechaHasta'];

        if(!empty($fechaDesde) && !empty($fechaHasta)){
            $whereClause = " WHERE fecha_creacion >= '" . $fechaDesde . "' 
            AND fecha_creacion <= '" . $fechaHasta . "'
            AND rol = 'user'";
        }else{
            $whereClause = " WHERE rol = 'user'";
        }

        $sql = "SELECT COUNT(*) as cantidad_usuarios,rol
        FROM usuario
        " . $whereClause . ";";

        return $this->database->query($sql);
    }

    public function getCantidadPartidasJugadas($filtros){
        $whereClause = "";
        $fechaDesde = $filtros['fechaDesde'];
        $fechaHasta = $filtros['fechaHasta'];

        if(!empty($fechaDesde) && !empty($fechaHasta)){
            $whereClause = " WHERE fecha_creacion >= '" . $fechaDesde . "' 
            AND fecha_creacion <= '" . $fechaHasta . "'
            ";
        }

        $sql = "SELECT COUNT(DISTINCT id) as cantidad_partidas 
        FROM partidas
        " . $whereClause . ";";

        return $this->database->query($sql);
    }

    public function getCantidadPreguntas($filtros){
        $whereClause = "";
        $fechaDesde = $filtros['fechaDesde'];
        $fechaHasta = $filtros['fechaHasta'];

        if(!empty($fechaDesde) && !empty($fechaHasta)){
            $whereClause = " WHERE fecha_creacion >= '" . $fechaDesde . "' AND fecha_creacion <= '" . $fechaHasta . "'";
        }

         $sql = "SELECT COUNT(*) as cantidad_preguntas 
         FROM preguntas
         " . $whereClause . ";";

         return $this->database->query($sql);
    }

    public function getCantidadSugeridas($filtros){
        $whereClause = "";
        $fechaDesde = $filtros['fechaDesde'];
        $fechaHasta = $filtros['fechaHasta'];

        if(!empty($fechaDesde) && !empty($fechaHasta)){
            $whereClause = " WHERE fecha_creacion >= '" . $fechaDesde . "' AND fecha_creacion <= '" . $fechaHasta . "'";
        }

        $sql = "SELECT COUNT(*) as cantidad_sugeridas 
        FROM preguntas_sugeridas
        " . $whereClause . ";";

        return $this->database->query($sql);
    }

    public function getPorcentajeCorrectasPorUsuario($filtros){
        $whereClause = "";
        $fechaDesde = $filtros['fechaDesde'];
        $fechaHasta = $filtros['fechaHasta'];

        if(!empty($fechaDesde) && !empty($fechaHasta)){
                $whereClause = " WHERE p.fecha_creacion >= '" . $fechaDesde . "' AND p.fecha_creacion <= '" . $fechaHasta . "'";
        }

        $sql = "SELECT u.nombreDeUsuario,
        (SUM(p.correctas) * 100.0 / (SUM(p.correctas) + SUM(p.incorrectas))) AS porcentaje
        FROM partidas p 
        JOIN usuario u ON p.usuario_id = u.id
        " . $whereClause . " GROUP BY u.nombreDeUsuario";

        return $this->database->query($sql);
    }

    public function getCantidadDeUsuariosPorPais($filtros){
        $whereClause = "";
        $fechaDesde = $filtros['fechaDesde'];
        $fechaHasta = $filtros['fechaHasta'];

        if(!empty($fechaDesde) && !empty($fechaHasta)){
            $whereClause = " WHERE fecha_creacion >= '" . $fechaDesde . "' AND fecha_creacion <= '" . $fechaHasta . "'";
        }

        $sql = "SELECT pais, COUNT(*) AS cantidad_usuarios_por_pais
        FROM usuario" . $whereClause . " 
        GROUP BY pais";

        return $this->database->query($sql);
    }

    public function getCantidadDeUsuariosPorGenero($filtros){
        $whereClause = "";
        $fechaDesde = $filtros['fechaDesde'];
        $fechaHasta = $filtros['fechaHasta'];

        if(!empty($fechaDesde) && !empty($fechaHasta)){
            $whereClause = " WHERE fecha_creacion >= '" . $fechaDesde . "' AND fecha_creacion <= '" . $fechaHasta . "'";
        }

        $sql = "SELECT genero, COUNT(*) AS cantidad_usuarios_por_genero
        FROM usuario
        " . $whereClause . "
        GROUP BY genero";

        return $this->database->query($sql);
    }

    public function getCantidadDeUsuariosPorGrupoDeEdad($filtros){
        // menores < 18, medio > 18 y < 65, jubilados >= 65

        $whereClause = "";
        $fechaDesde = $filtros['fechaDesde'];
        $fechaHasta = $filtros['fechaHasta'];

        if(!empty($fechaDesde) && !empty($fechaHasta)){
            $whereClause = " WHERE fecha_creacion >= '" . $fechaDesde . "' AND fecha_creacion <= '" . $fechaHasta . "'";
        }

        $sql = "SELECT CASE
        WHEN TIMESTAMPDIFF(YEAR, fechaDeNacimiento, CURDATE()) < 18 THEN 'Menores'
        WHEN TIMESTAMPDIFF(YEAR, fechaDeNacimiento, CURDATE()) >= 18 AND TIMESTAMPDIFF(YEAR, fechaDeNacimiento, CURDATE()) < 65 THEN 'Medio'
        WHEN TIMESTAMPDIFF(YEAR, fechaDeNacimiento, CURDATE()) >= 65 THEN 'Jubilados'
        ELSE 'Otro'
        END AS grupo_edad,
        COUNT(*) AS cantidad_usuarios_por_grupo
        FROM usuario
        " . $whereClause . "
        GROUP BY grupo_edad";

        return $this->database->query($sql);
    }


}