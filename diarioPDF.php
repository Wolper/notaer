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

//------------------    CABEÇALHO DO PDF    -------------------
//$pdf->Cell(19, 1, utf8_decode('Diário de Bordo'), 0, 1, 'C');
//$pdf->Cell(19, 1, '', 0, 1, 'C');

$pdf->Cell(12, 1, utf8_decode('APRESENTAÇÃO DA TRIPULAÇÃO'), 1, 1, 'C');
$pdf->Cell(3, 0.5, utf8_decode('Tripulante'), 1, 0, 'C');
$pdf->Cell(1.5, 0.5, utf8_decode('Hora'), 1, 0, 'C');
$pdf->Cell(1.5, 0.5, utf8_decode('Rubrica'), 1, 0, 'C');
$pdf->Cell(3, 0.5, utf8_decode('Tripulante'), 1, 0, 'C');
$pdf->Cell(1.5, 0.5, utf8_decode('Hora'), 1, 0, 'C');
$pdf->Cell(1.5, 0.5, utf8_decode('Rubrica'), 1, 1, 'C');
$pdf->Cell(3, 1, utf8_decode(''), 1, 0, 'C');
$pdf->Cell(1.5, 1, utf8_decode(''), 1, 0, 'C');
$pdf->Cell(1.5, 1, utf8_decode(''), 1, 0, 'C');
$pdf->Cell(3, 1, utf8_decode(''), 1, 0, 'C');
$pdf->Cell(1.5, 1, utf8_decode(''), 1, 0, 'C');
$pdf->Cell(1.5, 1, utf8_decode(''), 1, 1, 'C');
$pdf->Cell(3, 1, utf8_decode(''), 1, 0, 'C');
$pdf->Cell(1.5, 1, utf8_decode(''), 1, 0, 'C');
$pdf->Cell(1.5, 1, utf8_decode(''), 1, 0, 'C');
$pdf->Cell(3, 1, utf8_decode(''), 1, 0, 'C');
$pdf->Cell(1.5, 1, utf8_decode(''), 1, 0, 'C');
$pdf->Cell(1.5, 1, utf8_decode(''), 1, 0, 'C');

$pdf->SetFont('Arial', 'B', 16);
$pdf->SetXY(13, 1);
$pdf->MultiCell(11, 3.5, utf8_decode(''), 1, 'C');
$pdf->SetXY(13, 1);
$pdf->MultiCell(11, 1, utf8_decode('REGISTRO DE VOO'), 0, 'C');
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetXY(13, 1);
$pdf->MultiCell(11, 3, utf8_decode('DIÁRIO DE BORDO Nº '), 0, 'C');
$pdf->SetXY(13, 1);
$pdf->MultiCell(11, 5, utf8_decode('DATA: ' . date('d/m/Y')), 0, 'C');
$pdf->SetXY(24, 1);
$pdf->MultiCell(4, 1.5, utf8_decode(''), 1, 'C');
$pdf->SetXY(24, 2.5);
$pdf->MultiCell(4, 3, utf8_decode(''), 1, 'C');
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetXY(24, 1.5);
$pdf->MultiCell(4, 3, utf8_decode('VEMD'), 0, 'C');
$pdf->SetXY(24, 2);
$pdf->MultiCell(4, 3, utf8_decode('Último voo do Dia'), 0, 'C');

$pdf->SetXY(1, 4.5);
$pdf->Cell(5, 1, utf8_decode('Marcas: '), 1, 0, 'L');
$pdf->Cell(5, 1, utf8_decode('Fabricante: '), 1, 0, 'L');
$pdf->Cell(5, 1, utf8_decode('Modelo: '), 1, 0, 'L');
$pdf->Cell(4, 1, utf8_decode('S/N: '), 1, 0, 'L');
$pdf->Cell(4, 1, utf8_decode('Cat. Reg: '), 1, 0, 'L');

$pdf->SetXY(1, 5.5);
$pdf->Cell(9, 1, utf8_decode('Horas de voo anterior: '), 1, 0, 'L');
$pdf->Cell(9, 1, utf8_decode('Horas de voo do dia: '), 1, 0, 'L');
$pdf->Cell(9, 1, utf8_decode('Horas de voo final: '), 1, 1, 'L');
$pdf->Cell(9, 1, utf8_decode('Horas de voo anterior: '), 1, 0, 'L');
$pdf->Cell(9, 1, utf8_decode('Horas de voo do dia: '), 1, 0, 'L');
$pdf->Cell(9, 1, utf8_decode('Horas de voo final: '), 1, 0, 'L');

$pdf->SetXY(1, 7.5);
$pdf->Cell(5, 2, utf8_decode('Trecho '), 1, 0, 'C');
$pdf->Cell(8.5, 1, utf8_decode('Célula '), 1, 0, 'C');
$pdf->Cell(5, 1, utf8_decode('Motor '), 1, 0, 'C');
$pdf->Cell(8.5, 1, utf8_decode('Geral '), 1, 0, 'C');











//
//$pdf->Cell(19, 1, '', 0, 1, 'C');
//$pdf->Cell(3, 1, utf8_decode('Nº VOO'), 0, 0, 'C', '');
//$pdf->Cell(8, 1, utf8_decode('ID_AERO'), 0, 0, 'C', '');
//$pdf->Cell(3, 1, utf8_decode('T. TEMPO VOO'), 0, 0, 'C', '');
//$pdf->Cell(2, 1, utf8_decode('T. POUSOS'), 0, 0, 'C', '');
//$pdf->Cell(3, 1, utf8_decode('COMB.'), 0, 1, 'C', '');
//$pdf->SetTextColor(0, 0, 0);
//------------------    FIM DO CABEÇALHO    -------------------

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
