<?php
require('third-party/fpdf/fpdf.php');
class PDFController
{
    public function generarPDF($img){
        // Creación del objeto de la clase heredada
        $pdf = new FPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage('L');
        $pdf->SetFont('Times','',12);
        $pdf->Cell(0,10,'Reporte',0,1,'C',0);

        /*$imagen = explode(',',$img,2)[1];
        $pic = 'data://text/plain;base64,' . $imagen;*/
        $pdf->image('public/graphic/getCantidadDeUsuariosPorGrupoDeEdad.png',20,50,250,0);

        $pdf->Output();
    }
}