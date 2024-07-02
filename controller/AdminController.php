<?php
/*require_once('third-party/jpgraph/src/jpgraph.php');
require_once('third-party/jpgraph/src/jpgraph_bar.php');*/
class AdminController
{
    private $model;
    private $presenter;
    private $pdf;
    public function __construct($model, $presenter, $pdf)
    {
        $this->model = $model;
        $this->presenter = $presenter;
        $this->pdf = $pdf;

    }

    public function home()
    {
        $idUsuario = $_SESSION['id'];
        $usuario = $this->model->getUserDetails($idUsuario);
        $this->presenter->render("view/adminView.mustache", ['vista' => 'hidden',"usuario" => $usuario]);
    }

    public function getCantidadDeUsuarios(){
        $filtros = $this->obtenerFiltrosDeFecha();
        $resultados = $this->model->getCantidadDeUsuarios($filtros);
        $auxiliar = $this->auxiliaresDefecha($filtros);


        $labels = [];
        $data = [];

        foreach ($resultados as $fila){
            $labels[] = $fila['rol'];
            $data[] = $fila['cantidad_usuarios'];
        }
        $result = $this->generarGraficoDeBarras($labels, $data,'Cantidad de usuarios '.$auxiliar['auxiliarA'].$filtros['fechaDesde'].$auxiliar['auxiliarB'].$filtros['fechaHasta'].'','', 'Registrados','getCantidadDeUsuariosPorGenero' );
        $this->presenter->render("view/adminView.mustache", ['resultado' => $result]);
    }

    public function getCantidadPartidasJugadas(){
        $filtros = $this->obtenerFiltrosDeFecha();
        $resultados = $this->model->getCantidadPartidasJugadas($filtros);
        $auxiliar = $this->auxiliaresDefecha($filtros);

        $labels = [];
        $data = [];

        foreach ($resultados as $fila){
            $labels[] = 'partidas';
            $data[] = $fila['cantidad_partidas'];
        }
        $result = $this->generarGraficoDeBarras($labels, $data,'Cantidad de partidas '.$auxiliar['auxiliarA'].$filtros['fechaDesde'].$auxiliar['auxiliarB'].$filtros['fechaHasta'].'','', 'Cantidad de partidas','getCantidadDeUsuariosPorGenero' );
        $this->presenter->render("view/adminView.mustache", ['resultado' => $result]);
    }

    public function getCantidadPreguntas(){
        $filtros = $this->obtenerFiltrosDeFecha();
        $resultados = $this->model->getCantidadPreguntas($filtros);
        $auxiliar = $this->auxiliaresDefecha($filtros);

        $labels = [];
        $data = [];

        foreach ($resultados as $fila){
            $labels[] = 'preguntas';
            $data[] = $fila['cantidad_preguntas'];
        }
        $result = $this->generarGraficoDeBarras($labels, $data,'Cantidad de preguntas '.$auxiliar['auxiliarA'].$filtros['fechaDesde'].$auxiliar['auxiliarB'].$filtros['fechaHasta'].'','', 'Registrados','getCantidadDeUsuariosPorGenero' );
        $this->presenter->render("view/adminView.mustache", ['resultado' => $result]);
    }

    public function getCantidadSugeridas(){
        $filtros = $this->obtenerFiltrosDeFecha();
        $resultados = $this->model->getCantidadSugeridas($filtros);
        $auxiliar = $this->auxiliaresDefecha($filtros);

        $labels = [];
        $data = [];

        foreach ($resultados as $fila){
            $labels[] = 'preguntas sugeridas';
            $data[] = $fila['cantidad_sugeridas'];
        }
        $result = $this->generarGraficoDeBarras($labels, $data,'Cantidad de preguntas sugeridas '.$auxiliar['auxiliarA'].$filtros['fechaDesde'].$auxiliar['auxiliarB'].$filtros['fechaHasta'].'','', 'Registrados','getCantidadDeUsuariosPorGenero' );
        $this->presenter->render("view/adminView.mustache", ['resultado' => $result]);
    }
    public function getPorcentajeCorrectasPorUsuario(){
        $filtros = $this->obtenerFiltrosDeFecha();
        $resultados = $this->model->getPorcentajeCorrectasPorUsuario($filtros);
        $auxiliar = $this->auxiliaresDefecha($filtros);

        $labels = [];
        $data = [];

        foreach ($resultados as $fila){
            $labels[] = $fila['nombreDeUsuario'];
            $data[] = $fila['porcentaje'];
        }

        $result = $this->generarGraficoDeBarras($labels, $data,'Cantidad de respuestas correctas por usuario '.$auxiliar['auxiliarA'].$filtros['fechaDesde'].$auxiliar['auxiliarB'].$filtros['fechaHasta'].'','Usuario', 'Cantidad respuestas correctas','getPorcentajeCorrectasPorUsuario' );
        $this->presenter->render("view/adminView.mustache", ['resultado' => $result]);
    }

    public function getCantidadDeUsuariosPorPais(){
        $filtros = $this->obtenerFiltrosDeFecha();
        $resultados = $this->model->getCantidadDeUsuariosPorPais($filtros);
        $auxiliar = $this->auxiliaresDefecha($filtros);

        $labels = [];
        $data = [];

        foreach ($resultados as $fila){
            $labels[] = $fila['pais'];
            $data[] = $fila['cantidad_usuarios_por_pais'];
        }
        $result = $this->generarGraficoDeBarras($labels, $data,'Cantidad de usuarios por pais '.$auxiliar['auxiliarA'].$filtros['fechaDesde'].$auxiliar['auxiliarB'].$filtros['fechaHasta'].'','Pais', 'Cantidad de usuarios por pais','getCantidadDeUsuariosPorPais' );
        $this->presenter->render("view/adminView.mustache", ['resultado' => $result]);

    }

    public function getCantidadDeUsuariosPorGenero(){
        $filtros = $this->obtenerFiltrosDeFecha();
        $resultados = $this->model->getCantidadDeUsuariosPorGenero($filtros);
        $auxiliar = $this->auxiliaresDefecha($filtros);

        $labels = [];
        $data = [];

        foreach ($resultados as $fila){
            $labels[] = $fila['genero'];
            $data[] = $fila['cantidad_usuarios_por_genero'];
        }
        $result = $this->generarGraficoDeBarras($labels, $data,'Cantidad de usuarios por genero '.$auxiliar['auxiliarA'].$filtros['fechaDesde'].$auxiliar['auxiliarB'].$filtros['fechaHasta'].'','Genero', 'Cantidad de usuarios por genero','getCantidadDeUsuariosPorGenero' );
        $this->presenter->render("view/adminView.mustache", ['resultado' => $result]);
    }

    public function getCantidadDeUsuariosPorGrupoDeEdad(){
        $filtros = $this->obtenerFiltrosDeFecha();
        $resultados = $this->model->getCantidadDeUsuariosPorGrupoDeEdad($filtros);
        $auxiliar = $this->auxiliaresDefecha($filtros);

        $labels = [];
        $data = [];

        foreach ($resultados as $fila){
            $labels[] = $fila['grupo_edad'];
            $data[] = $fila['cantidad_usuarios_por_grupo'];
        }
        $result = $this->generarGraficoDeBarras($labels, $data,'Cantidad de usuarios por grupo de edad '.$auxiliar['auxiliarA'].$filtros['fechaDesde'].$auxiliar['auxiliarB'].$filtros['fechaHasta'].'','Grupo', 'Cantidad de usuarios por grupo de edad','getCantidadDeUsuariosPorGrupoDeEdad' );
        $this->presenter->render("view/adminView.mustache", ['resultado' => $result]);
    }

    private function obtenerFiltrosDeFecha(){
        return [
            'fechaDesde' => $_POST['fechaDesde'] ?? "",
            'fechaHasta' => $_POST['fechaHasta'] ?? ""
        ];
    }

    private function generarGraficoDeBarras($labels, $data, $title, $xaxis, $yaxis, $nombreArchivo){
        $graph = new Graph(800, 600);
        $graph->SetScale('textlin');

        $barplot = new BarPlot($data);
        $graph->Add($barplot);

        $graph->xaxis->SetTickLabels($labels);

        $graph->title->Set($title);
        $graph->xaxis->title->Set($xaxis);
        $graph->yaxis->title->Set($yaxis);

        $graph->Stroke(_IMG_HANDLER);

        // Guardar la imagen en un archivo temporal
        $fileName = 'public/graphic/' . $nombreArchivo . '.png';
        $graph->img->Stream($fileName);

        // Devolver la ruta del archivo generado
        return $fileName;
    }

    public function generarPDF(){

        if (!empty($_POST['image_name'])){
            $img = $_POST['image_name'];
            $this->pdf->generarPDF($img);
        }else{
            header('location:/view/adminView.php');
            exit();
        }


    }
    private function auxiliaresDefecha($filtro): array
    {

        if (empty($filtros['fechaDesde'])){
            $auxiliar =[
                "auxiliarA" => '',
                "auxiliarB" => 'hasta'];
        }elseif (empty($filtros['fechaHasta'])){
            $auxiliar =[
                "auxiliarA" => 'desde ',
                "auxiliarB" => ''];
        }else{
            $auxiliar =[
                "auxiliarA" => 'desde ',
                "auxiliarB" => ' hasta '];
        }
        return $auxiliar;
    }




}