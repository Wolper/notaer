<?php

define('FPDF', 'FONTPATH', 'font/');
require('./_app/Config.inc.php');
require './admin/pdf/fpdf.php';
header("Content-type: text/html; charset=utf-8");

$pdf = new FPDF('L', 'cm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTitle('Relatório Consolidado de Pontos', $isUTF8 = TRUE);
//$pdf->SetTextColor(0, 0, 150);
date_default_timezone_set('America/Sao_Paulo');
$mes = date('m');

$diario = new Read();
$diario->FullRead("SELECT * FROM voo AS v JOIN etapas_voo AS e ON v.idvoo = e.idvoo GROUP BY v.numero_voo");

$pdf->Cell(19, 1, utf8_decode('Diário de Bordo'), 0, 1, 'C');
$pdf->Cell(19, 1, '', 0, 1, 'C');

$pdf->Cell(12, 1, utf8_decode('APRESENTAÇÃO DA TRIPULAÇÃO'), 1, 0, 'C');
$pdf->MultiCell(10, 6, utf8_decode('REGISTRO DE VOO'), 1, 'C');
$pdf->SetXY(23, 3);
$pdf->MultiCell(4, 6, utf8_decode('REGISTRO DE VOO'), 1, 'C');
$pdf->Cell(19, 1, '', 0, 1, 'C');
$pdf->Cell(3, 1, utf8_decode('Nº VOO'), 0, 0, 'C', '');
$pdf->Cell(8, 1, utf8_decode('ID_AERO'), 0, 0, 'C', '');
$pdf->Cell(3, 1, utf8_decode('T. TEMPO VOO'), 0, 0, 'C', '');
$pdf->Cell(2, 1, utf8_decode('T. POUSOS'), 0, 0, 'C', '');
$pdf->Cell(3, 1, utf8_decode('COMB.'), 0, 1, 'C', '');

//$pdf->SetTextColor(0, 0, 0);

if ($diario->getRowCount() > 0):

    extract($diario->getResult()[0]);
    $pdf->Cell(3, 1, utf8_decode($numero_voo), 'T', 0, 'C', '');
    $pdf->Cell(8, 1, utf8_decode($idaeronave), 'T', 0, 'C', '');
    $pdf->Cell(3, 1, utf8_decode($tempo_total_de_voo), 'T', 0, 'C', '');
    $pdf->Cell(2, 1, utf8_decode($total_de_pousos), 'T', 0, 'C', '');
    $pdf->Cell(3, 1, utf8_decode($combustivel_total_consumido), 'T', 1, 'C', '');

endif;

$pdf->Cell(19, 1, utf8_decode(''), 0, 1, 'C');
$pdf->Cell(19, 1, utf8_decode(''), 0, 1, 'C');
$pdf->Cell(19, 1, utf8_decode('Data/Hora de Emissão: ' . date('d / m / Y - H:i') . 'h'), 0, 1, 'R');
$pdf->Cell(19, 1, utf8_decode(''), 0, 1, 'C');
$pdf->Cell(19, 1, utf8_decode('Comandante de Cia/Chefe de Seção'), 0, 1, 'C');
$pdf->Output();
