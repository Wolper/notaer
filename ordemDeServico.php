<?php

define('FPDF', 'FONTPATH', 'font/');
require('./_app/Config.inc.php');
require './admin/pdf/fpdf.php';
header("Content-type: text/html; charset=utf-8");

//$get = filter_input_array(INPUT_GET, FILTER_DEFAULT);
//
//if (isset($get)):
//
$diario = new Read();
$diario->FullRead("SELECT * FROM aeronave aero JOIN inspecao AS insp ON aero.idAeronave = insp.idAeronave WHERE aero.idAeronave = 1 AND insp.idtipoinspecao = 2");
//$diario->FullRead("SELECT * FROM tipo_inspecao AS ti JOIN (SELECT * FROM aeronave aero JOIN inspecao AS insp ON aero.idAeronave = insp.idAeronave WHERE aero.idAeronave = 1 AND insp.idtipoinspecao = 2) AS aeroinsp ON aeroinsp.idtipoinspecao = ti.id_tipo_inspecao");
//    unset($get);


$pdf = new FPDF('P', 'cm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTitle('Ordem de Serviço', $isUTF8 = TRUE);
//$pdf->SetTextColor(0, 0, 150);
date_default_timezone_set('America/Sao_Paulo');
$mes = date('m');
if ($diario->getRowCount() > 0):
    foreach ($diario->getResult() as $result):
        extract($result);
//------------------    CABEÇALHO DO PDF    -------------------
//$pdf->Cell(19, 1, utf8_decode('Diário de Bordo'), 0, 1, 'C');
//$pdf->Cell(19, 1, '', 0, 1, 'C');


        $pdf->Image('./admin/images/brasao.jpg', 1.25, 1, 3, 3);
        $pdf->Image('./admin/images/escudo.jpg', 16.85, 1.05, 2.9, 2.9);

        $pdf->Cell(3.5, 3, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(12, 3, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(3.5, 3, utf8_decode(''), 1, 0, 'C');

        $pdf->SetXY(5, 1.3);
        $pdf->Cell(11, 1, utf8_decode('SECRETARIA DA CASA MILITAR'), 0, 1, 'C');
        $pdf->SetXY(5, 1.8);
        $pdf->Cell(11, 1, utf8_decode('NÚCLEO DE OPERAÇÕES E TRANSPORTE AÉREO'), 0, 1, 'C');
        $pdf->SetXY(5, 2.3);
        $pdf->Cell(11, 1, utf8_decode('SEÇÃO DE MANUTENÇÃO'), 0, 0, 'C');
        $pdf->SetXY(5, 2.8);
        $pdf->Cell(11, 1, utf8_decode('CONTROLE TÉCNICO DE MANUTENÇÃO'), 0, 0, 'C');
        $pdf->SetXY(5, 4);
        $pdf->Cell(11, 1, utf8_decode('ORDEM DE SERVIÇO'), 0, 1, 'C');

        $pdf->SetFillColor(200, 200, 200);
        $pdf->Cell(3.5, 0.5, utf8_decode('PREFIXO'), 1, 0, 'C', true);
        $pdf->Cell(3, 0.5, utf8_decode('TIPO'), 1, 0, 'C', true);
        $pdf->Cell(3, 0.5, utf8_decode('VERSÃO'), 1, 0, 'C', true);
        $pdf->Cell(3, 0.5, utf8_decode('SN/ANV'), 1, 0, 'C', true);
        $pdf->Cell(3, 0.5, utf8_decode('Nº OS'), 1, 0, 'C', true);
        $pdf->Cell(3.5, 0.5, utf8_decode('SUPLEMENTO'), 1, 1, 'C', true);

        $pdf->Cell(3.5, 0.5, utf8_decode($prefixoAeronave), 1, 0, 'C');
        $pdf->Cell(3, 0.5, utf8_decode($modeloCelula), 1, 0, 'C');
        $pdf->Cell(3, 0.5, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(3, 0.5, utf8_decode($serialCelula), 1, 0, 'C');
        $pdf->Cell(3, 0.5, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(3.5, 0.5, utf8_decode('N/A'), 1, 0, 'C');

        $pdf->SetXY(1, 6.25);
        $pdf->Cell(19, 0.5, utf8_decode('DADOS DA AERONAVE'), 0, 1, 'C');

        $pdf->Cell(6, 0.5, utf8_decode('CÉLULA'), 1, 0, 'C', true);
//$pdf->Cell(3, 0.5, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(6.5, 0.5, utf8_decode('MOTOR 01'), 1, 0, 'C', true);
//$pdf->Cell(3, 0.5, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(6.5, 0.5, utf8_decode('MOTOR 02'), 1, 1, 'C', true);
//$pdf->Cell(3.5, 0.5, utf8_decode(''), 1, 1, 'C');

        $pdf->Cell(2, 0.5, utf8_decode('TSN'), 1, 0, 'C');
        $pdf->Cell(4, 0.5, utf8_decode($horasDeVooAeronave), 1, 0, 'C');
        $pdf->Cell(1, 0.5, utf8_decode('TSN'), 1, 0, 'C');
        $pdf->Cell(2.25, 0.5, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(1, 0.5, utf8_decode('TSO'), 1, 0, 'C');
        $pdf->Cell(2.25, 0.5, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(1, 0.5, utf8_decode('TSN'), 1, 0, 'C');
        $pdf->Cell(2.25, 0.5, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(1, 0.5, utf8_decode('TSO'), 1, 0, 'C');
        $pdf->Cell(2.25, 0.5, utf8_decode(''), 1, 1, 'C');

        $pdf->Cell(2, 0.5, utf8_decode('POUSOS'), 1, 0, 'C');
        $pdf->Cell(4, 0.5, utf8_decode($pousos), 1, 0, 'C');
        $pdf->Cell(1, 0.5, utf8_decode('NG'), 1, 0, 'C');
        $pdf->Cell(2.25, 0.5, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(1, 0.5, utf8_decode('CSO'), 1, 0, 'C');
        $pdf->Cell(2.25, 0.5, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(1, 0.5, utf8_decode('NG'), 1, 0, 'C');
        $pdf->Cell(2.25, 0.5, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(1, 0.5, utf8_decode('CSO'), 1, 0, 'C');
        $pdf->Cell(2.25, 0.5, utf8_decode(''), 1, 1, 'C');

        $pdf->Cell(2, 0.5, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(4, 0.5, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(1, 0.5, utf8_decode('NTL'), 1, 0, 'C');
        $pdf->Cell(2.25, 0.5, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(1, 0.5, utf8_decode('CSO'), 1, 0, 'C');
        $pdf->Cell(2.25, 0.5, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(1, 0.5, utf8_decode('NTL'), 1, 0, 'C');
        $pdf->Cell(2.25, 0.5, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(1, 0.5, utf8_decode('CSO'), 1, 0, 'C');
        $pdf->Cell(2.25, 0.5, utf8_decode(''), 1, 1, 'C');


        $pdf->SetXY(1, 9);
        $pdf->Cell(19, 0.5, utf8_decode('TAREFAS'), 0, 1, 'C');

        $pdf->Cell(1, 0.5, utf8_decode('Item'), 1, 0, 'C', true);
        $pdf->Cell(4.4, 0.5, utf8_decode('Descrição dos serviços'), 1, 0, 'C', true);
        $pdf->Cell(4.4, 0.5, utf8_decode('Resultado da intervenção'), 1, 0, 'C', true);
        $pdf->Cell(2, 0.5, utf8_decode('Data'), 1, 0, 'C', true);
        $pdf->Cell(2, 0.5, utf8_decode('Tempo'), 1, 0, 'C', true);
        $pdf->Cell(2.3, 0.5, utf8_decode('Mecânico'), 1, 0, 'C', true);
        $pdf->Cell(2.9, 0.5, utf8_decode('Assinatura'), 1, 1, 'C', true);

        $pdf->Cell(1, 1, utf8_decode('1'), 1, 0, 'C');
        $pdf->Cell(4.4, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(4.4, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(2, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(2, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(2.3, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(2.9, 1, utf8_decode(''), 1, 1, 'C');

        $pdf->Cell(1, 1, utf8_decode('2'), 1, 0, 'C');
        $pdf->Cell(4.4, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(4.4, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(2, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(2, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(2.3, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(2.9, 1, utf8_decode(''), 1, 1, 'C');

        $pdf->Cell(1, 1, utf8_decode('3'), 1, 0, 'C');
        $pdf->Cell(4.4, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(4.4, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(2, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(2, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(2.3, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(2.9, 1, utf8_decode(''), 1, 1, 'C');

        $pdf->Cell(1, 1, utf8_decode('4'), 1, 0, 'C');
        $pdf->Cell(4.4, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(4.4, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(2, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(2, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(2.3, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(2.9, 1, utf8_decode(''), 1, 1, 'C');

        $pdf->Cell(1, 1, utf8_decode('5'), 1, 0, 'C');
        $pdf->Cell(4.4, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(4.4, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(2, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(2, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(2.3, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(2.9, 1, utf8_decode(''), 1, 1, 'C');

        $pdf->Cell(1, 1, utf8_decode('6'), 1, 0, 'C');
        $pdf->Cell(4.4, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(4.4, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(2, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(2, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(2.3, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(2.9, 1, utf8_decode(''), 1, 1, 'C');

        $pdf->Cell(11.8, 0.5, utf8_decode('Tempo Gasto nas Inspeções'), 1, 0, 'C');
        $pdf->Cell(2, 0.5, utf8_decode(''), 1, 0, 'C');
        $pdf->SetFillColor(0);
        $pdf->Cell(2.3, 0.5, utf8_decode(''), 1, 0, 'C', true);
        $pdf->Cell(2.9, 0.5, utf8_decode(''), 1, 1, 'C', true);

        $pdf->Cell(19, 0.5, utf8_decode('Obs:'), 1, 1, 'L');
        $pdf->Cell(19, 0.5, utf8_decode('Emissão'), 1, 1, 'C');

        $pdf->SetFillColor(200, 200, 200);
        $pdf->Cell(3, 0.5, utf8_decode('DATA'), 1, 0, 'C', true);
        $pdf->Cell(6, 0.5, utf8_decode('RESPONSÁVEL'), 1, 0, 'C', true);
        $pdf->Cell(4, 0.5, utf8_decode('ANAC'), 1, 0, 'C', true);
        $pdf->Cell(6, 0.5, utf8_decode('ASSINATURA'), 1, 1, 'C', true);

        $pdf->Cell(3, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(6, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(4, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(6, 1, utf8_decode(''), 1, 1, 'C');

        $pdf->Cell(19, 0.5, utf8_decode('RESULTADO DA AÇÃO DE MANUTENÇÃO REALIZADA'), 1, 1, 'C');

        $pdf->Cell(19, 1, utf8_decode(''), 1, 1, 'C');
        $pdf->SetFontSize(8);
        $pdf->SetY(19.7);
        $pdf->Cell(19, 0.3, utf8_decode('Certifico que a aeronave XXXX XXXX, SN, XXX sofreu as intervenções acimarelacionadas conforme manual de Manutenção XXX'), 0, 1, 'C');
        $pdf->Cell(19, 0.5, utf8_decode('Revisão XX atulizada em: xx/xx/xxxx e/ou XXXXX e está aprovada para retorno ao serviço'), 0, 1, 'C');

        $pdf->SetFontSize(10);
        $pdf->Cell(19, 0.5, utf8_decode('Inspeção p/ Liberação - Ferramentas'), 1, 1, 'C', true);
        $pdf->SetFontSize(7);
        $pdf->Cell(19, 1, utf8_decode('Asseguro que as FERRAMENTAS utilizadas para este serviço foram recolhidas para seus devidos locais (Caixa de Ferramenta/Carrinho de Ferramenta/Tenda)'), 1, 1, 'C');

        $pdf->SetFontSize(10);
        $pdf->Cell(19, 0.5, utf8_decode('Inspeção p/ Liberação - FOD'), 1, 1, 'C', true);
        $pdf->SetFontSize(7);
        $pdf->Cell(19, 1, utf8_decode('Feita a inspeção FOD, certifico que a aeronave está liberada para giro/voo, estando isenta de objetos estranhos.)'), 1, 1, 'C');

        $pdf->SetFontSize(10);
        $pdf->Cell(3, 0.5, utf8_decode('DATA'), 1, 0, 'C');
        $pdf->Cell(6, 0.5, utf8_decode('MECÂNICO'), 1, 0, 'C');
        $pdf->Cell(4, 0.5, utf8_decode('ANAC'), 1, 0, 'C');
        $pdf->Cell(6, 0.5, utf8_decode('ASSINATURA'), 1, 1, 'C');

        $pdf->Cell(3, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(6, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(4, 1, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(6, 1, utf8_decode(''), 1, 1, 'C');

    endforeach;
endif;

$pdf->Output();
