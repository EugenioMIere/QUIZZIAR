<?php
require_once('third-party/jpgraph/src/jpgraph.php');
require_once('third-party/jpgraph/src/jpgraph_bar.php');
class AdminController
{
    private $model;
    private $presenter;

    public function __construct($model, $presenter)
    {
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function home()
    {
        $this->presenter->render("view/adminView.mustache");
    }

    public function getCantidadDeUsuarios(){
        $filtros = $this->obtenerFiltrosDeFecha();
        $resultado = $this->model->getCantidadDeUsuarios($filtros);

        $this->presenter->render("view/adminView.mustache", ['cantidad_de_usuarios' => $resultado]);
    }

    public function getCantidadPartidasJugadas(){
        $filtros = $this->obtenerFiltrosDeFecha();
        $resultado = $this->model->getCantidadPartidasJugadas($filtros);

        $this->presenter->render("view/adminView.mustache", ['cantidad_de_pj' => $resultado]);
    }

    public function getCantidadPreguntas(){
        $filtros = $this->obtenerFiltrosDeFecha();
        $resultado = $this->model->getCantidadPreguntas($filtros);

        $this->presenter->render("view/adminView.mustache", ['cantidad_de_preg' => $resultado]);
    }

    public function getCantidadSugeridas(){
        $filtros = $this->obtenerFiltrosDeFecha();
        $resultado = $this->model->getCantidadSugeridas($filtros);

        $this->presenter->render("view/adminView.mustache", ['cantidad_de_preg_sug' => $resultado]);
    }

//    Métodos que necesitan gráficos:
    public function getPorcentajeCorrectasPorUsuario(){
        $filtros = $this->obtenerFiltrosDeFecha();
        $resultados = $this->model->getPorcentajeCorrectasPorUsuario($filtros);

        $labels = [];
        $data = [];

        foreach ($resultados as $fila){
            $labels[] = $fila['nombreDeUsuario'];
            $data[] = $fila['porcentaje'];
        }
    }

    public function getCantidadDeUsuariosPorPais(){
        $filtros = $this->obtenerFiltrosDeFecha();
        $resultados = $this->model->getCantidadDeUsuariosPorPais($filtros);

        $labels = [];
        $data = [];

        foreach ($resultados as $fila){
            $labels[] = $fila['pais'];
            $data[] = $fila['cantidad_usuarios_por_pais'];
        }

    }

    public function getCantidadDeUsuariosPorGenero(){
        $filtros = $this->obtenerFiltrosDeFecha();
        $resultados = $this->model->getCantidadDeUsuariosPorGenero($filtros);

        $labels = [];
        $data = [];

        foreach ($resultados as $fila){
            $labels[] = $fila['genero'];
            $data[] = $fila['cantidad_usuarios_por_genero'];
        }
    }

    public function getCantidadDeUsuariosPorGrupoDeEdad(){
        $filtros = $this->obtenerFiltrosDeFecha();
        $resultados = $this->model->getCantidadDeUsuariosPorGrupoDeEdad($filtros);

        $labels = [];
        $data = [];

        foreach ($resultados as $fila){
            $labels[] = $fila['grupo_edad'];
            $data[] = $fila['cantidad_usuarios_por_grupo'];
        }
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



}