<?php
require('third-party/fpdf/fpdf.php');
class PDFCreator
{
    public function generarPDF($img){

        $pdf = new FPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage('P','A4',0);
        $pdf->SetFont('Times','',12);
        $pdf->Cell(0,10,'Reporte',0,1,'C',0);


        $pdf->image($img,20,50,170,0);

        $pdf->Output();
    }

}