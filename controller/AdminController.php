<?php
require_once('third-party/jpgraph/src/jpgraph.php');
require_once('third-party/jpgraph/src/jpgraph_bar.php');
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
        $this->presenter->render("view/adminView.mustache", ['vista' => 'hidden']);
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
        if (empty($filtros['fechaDesde'])){
            $auxiliarA = '';
            $auxiliarB = '';
        }else{
            $auxiliarA = 'desde ';
            $auxiliarB = ' hasta ';

        }
        $resultados = $this->model->getPorcentajeCorrectasPorUsuario($filtros);

        $labels = [];
        $data = [];

        foreach ($resultados as $fila){
            $labels[] = $fila['nombreDeUsuario'];
            $data[] = $fila['porcentaje'];
        }

        $result = $this->generarGraficoDeBarras($labels, $data,'Cantidad de respuestas correctas por usuario '.$auxiliarA.$filtros['fechaDesde'].$auxiliarB.$filtros['fechaHasta'].'','Usuario', 'Cantidad respuestas correctas','getPorcentajeCorrectasPorUsuario' );
        $this->presenter->render("view/adminView.mustache", ['resultado' => $result]);
    }

    public function getCantidadDeUsuariosPorPais(){
        $filtros = $this->obtenerFiltrosDeFecha();
        if (empty($filtros['fechaDesde'])){
            $auxiliarA = '';
            $auxiliarB = '';
        }else{
            $auxiliarA = 'desde ';
            $auxiliarB = ' hasta ';

        }
        $resultados = $this->model->getCantidadDeUsuariosPorPais($filtros);

        $labels = [];
        $data = [];

        foreach ($resultados as $fila){
            $labels[] = $fila['pais'];
            $data[] = $fila['cantidad_usuarios_por_pais'];
        }
        $result = $this->generarGraficoDeBarras($labels, $data,'Cantidad de usuarios por pais '.$auxiliarA.$filtros['fechaDesde'].$auxiliarB.$filtros['fechaHasta'].'','Pais', 'Cantidad de usuarios por pais','getCantidadDeUsuariosPorPais' );
        $this->presenter->render("view/adminView.mustache", ['resultado' => $result]);

    }

    public function getCantidadDeUsuariosPorGenero(){
        $filtros = $this->obtenerFiltrosDeFecha();
        if (empty($filtros['fechaDesde'])){
            $auxiliarA = '';
            $auxiliarB = '';
        }else{
            $auxiliarA = 'desde ';
            $auxiliarB = ' hasta ';

        }
        $resultados = $this->model->getCantidadDeUsuariosPorGenero($filtros);

        $labels = [];
        $data = [];

        foreach ($resultados as $fila){
            $labels[] = $fila['genero'];
            $data[] = $fila['cantidad_usuarios_por_genero'];
        }
        $result = $this->generarGraficoDeBarras($labels, $data,'Cantidad de usuarios por genero '.$auxiliarA.$filtros['fechaDesde'].$auxiliarB.$filtros['fechaHasta'].'','Genero', 'Cantidad de usuarios por genero','getCantidadDeUsuariosPorGenero' );
        $this->presenter->render("view/adminView.mustache", ['resultado' => $result]);
    }

    public function getCantidadDeUsuariosPorGrupoDeEdad(){
        $filtros = $this->obtenerFiltrosDeFecha();
        if (empty($filtros['fechaDesde'])){
            $auxiliarA = '';
            $auxiliarB = '';
        }else{
            $auxiliarA = 'desde ';
            $auxiliarB = ' hasta ';

        }
        $resultados = $this->model->getCantidadDeUsuariosPorGrupoDeEdad($filtros);

        $labels = [];
        $data = [];

        foreach ($resultados as $fila){
            $labels[] = $fila['grupo_edad'];
            $data[] = $fila['cantidad_usuarios_por_grupo'];
        }
        $result = $this->generarGraficoDeBarras($labels, $data,'Cantidad de usuarios por grupo de edad '.$auxiliarA.$filtros['fechaDesde'].$auxiliarB.$filtros['fechaHasta'].'','Grupo', 'Cantidad de usuarios por grupo de edad','getCantidadDeUsuariosPorGrupoDeEdad' );
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
        $img = $_POST['image_name'];
        $this->pdf->generarPDF($img);
    }




}