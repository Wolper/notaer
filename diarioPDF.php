<?php

define('FPDF', 'FONTPATH', 'font/');
require('./_app/Config.inc.php');
require './admin/pdf/fpdf.php';
header("Content-type: text/html; charset=utf-8");

$get = filter_input_array(INPUT_GET, FILTER_DEFAULT);

if (isset($get)):

    $diario = new Read();
    $diario->FullRead("SELECT * FROM (SELECT * FROM voo AS v JOIN etapas_voo AS e ON v.idvoo = e.id_voo WHERE data_do_voo = '" . $get['data'] . "' AND idaeronave = '" . $get['aeronave'] . "' GROUP BY v.numero_voo) AS vooetapa JOIN aeronave AS aero ON vooetapa.idaeronave = aero.idAeronave");

    unset($get);


    $pdf = new FPDF('L', 'cm', 'A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTitle('Diário de bordo', $isUTF8 = TRUE);
//$pdf->SetTextColor(0, 0, 150);
    date_default_timezone_set('America/Sao_Paulo');
    $mes = date('m');
    if ($diario->getRowCount() > 0):
        foreach ($diario->getResult() as $result):
            extract($result);

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
            $pdf->Cell(3, 1, utf8_decode($comandante), 1, 0, 'C');
            $pdf->Cell(1.5, 1, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1.5, 1, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(3, 1, utf8_decode($copiloto), 1, 0, 'C');
            $pdf->Cell(1.5, 1, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1.5, 1, utf8_decode(''), 1, 1, 'C');
            $pdf->Cell(3, 1, utf8_decode($topD), 1, 0, 'C');
            $pdf->Cell(1.5, 1, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1.5, 1, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(3, 1, utf8_decode($topE), 1, 0, 'C');
            $pdf->Cell(1.5, 1, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1.5, 1, utf8_decode(''), 1, 0, 'C');

            $pdf->SetFont('Arial', 'B', 14);
            $pdf->SetXY(13, 1);
            $pdf->MultiCell(11, 3.5, utf8_decode(''), 1, 'C');
            $pdf->Image('./admin/images/logoNotaer.jpg', 13.25, 1.25, 2, 2);
            $pdf->SetXY(13.25, 1);
            $pdf->MultiCell(11, 1, utf8_decode('PARTE I - REGISTRO DE VOO'), 0, 'C');
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->SetXY(13, 1);
            $pdf->MultiCell(11, 3, utf8_decode('DIÁRIO DE BORDO Nº '), 0, 'C');
            $pdf->SetXY(13, 1);
            $data = explode('-', $data_do_voo);
            $pdf->MultiCell(11, 5, utf8_decode('DATA: ' . $data[2] . '/' . $data[1] . '/' . $data[0]), 0, 'C');
            $pdf->SetXY(24, 1);
            $pdf->MultiCell(4, 1.5, utf8_decode(''), 1, 'C');
            $pdf->SetXY(24, 2.5);
            $pdf->MultiCell(4, 2.5, utf8_decode(''), 1, 'C');
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetXY(24, 1.5);
            $pdf->MultiCell(4, 2.5, utf8_decode('VEMD'), 0, 'C');
            $pdf->SetXY(24, 2);
            $pdf->MultiCell(4, 2.5, utf8_decode('Último voo do Dia'), 0, 'C');

            $pdf->SetXY(1, 4.5);
            $pdf->Cell(5, 0.5, utf8_decode('Marcas: ' . $prefixoAeronave), 1, 0, 'L');
            $pdf->Cell(5, 0.5, utf8_decode('Fabricante: ' . $fabricanteCelula), 1, 0, 'L');
            $pdf->Cell(5, 0.5, utf8_decode('Modelo: ' . $modeloCelula), 1, 0, 'L');
            $pdf->Cell(4, 0.5, utf8_decode('S/N: ' . $serialCelula), 1, 0, 'L');
            $pdf->Cell(4, 0.5, utf8_decode('Cat. Reg: '), 1, 0, 'L');

            $pdf->SetXY(1, 5);
            $pdf->Cell(9, 0.5, utf8_decode('Horas de voo anterior: '), 1, 0, 'L');
            $pdf->Cell(9, 0.5, utf8_decode('Horas de voo do dia: '), 1, 0, 'L');
            $pdf->Cell(9, 0.5, utf8_decode('Horas de voo final: '), 1, 1, 'L');
            $pdf->Cell(9, 0.5, utf8_decode('Horas de voo anterior: '), 1, 0, 'L');
            $pdf->Cell(9, 0.5, utf8_decode('Horas de voo do dia: '), 1, 0, 'L');
            $pdf->Cell(9, 0.5, utf8_decode('Horas de voo final: '), 1, 0, 'L');

            $pdf->SetXY(1, 6);
            $pdf->Cell(5, 1, utf8_decode('Trecho '), 1, 0, 'C');
            $pdf->Cell(9, 0.5, utf8_decode('Célula '), 1, 0, 'C');
            $pdf->Cell(3, 0.5, utf8_decode('Motor '), 1, 0, 'C');
            $pdf->Cell(10, 0.5, utf8_decode('Geral '), 1, 1, 'C');


            $pdf->SetFont('Arial', 'B', 8);

//ALINHAMENTO DA COLUNA CÉLULA
            $pdf->SetXY(6, 6.5);
            $pdf->Cell(7, 0.5, utf8_decode('Horas'), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode('Ciclos'), 1, 0, 'C');

//ALINHAMENTO DA COLUNA MOTOR
            $pdf->Cell(1, 0.5, utf8_decode('Horas'), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode('Ciclos'), 1, 0, 'C');

//ALINHAMENTO DA COLUNA GERAL
            $pdf->Cell(1.5, 1, utf8_decode('Comb'), 1, 0, 'C');
            $pdf->Cell(1.25, 1, utf8_decode('Ordem'), 1, 0, 'C');
            $pdf->Cell(1, 1, utf8_decode('Pax'), 1, 0, 'C');
            $pdf->Cell(1, 1, utf8_decode('Nat'), 1, 0, 'C');
            $pdf->Cell(1, 1, utf8_decode('1P'), 1, 0, 'C');
            $pdf->Cell(2.25, 1, utf8_decode('ANAC'), 1, 0, 'C');
            $pdf->Cell(1, 1, utf8_decode('Rub'), 1, 0, 'C');
            $pdf->Cell(1, 1, utf8_decode('2P'), 1, 0, 'C');


            $pdf->SetXY(18, 6.3);
            $pdf->Cell(1.5, 2, utf8_decode('QAV'), 0, 0, 'C');
            $pdf->Cell(1.25, 2, utf8_decode('Voo'), 0, 0, 'C');
            $pdf->SetXY(26, 6.3);
            $pdf->Cell(1, 2, utf8_decode('Cmte'), 0, 0, 'C');



            $pdf->SetXY(1, 7);
            $pdf->Cell(0.30, 0.5, utf8_decode('Et'), 1, 0, 'C');
            $pdf->Cell(2.35, 0.5, utf8_decode('De'), 1, 0, 'C');
            $pdf->Cell(2.35, 0.5, utf8_decode('Para'), 1, 0, 'C');


            $pdf->Cell(1, 0.5, utf8_decode('Par'), 1, 0, 'C');
            $pdf->Cell(1, 0.5, utf8_decode('Dec'), 1, 0, 'C');
            $pdf->Cell(1, 0.5, utf8_decode('Pou'), 1, 0, 'C');
            $pdf->Cell(1, 0.5, utf8_decode('Cor'), 1, 0, 'C');
            $pdf->Cell(1, 0.5, utf8_decode('Diu'), 1, 0, 'C');
            $pdf->Cell(1, 0.5, utf8_decode('Not'), 1, 0, 'C');
            $pdf->Cell(1, 0.5, utf8_decode('Tot'), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode('Pousos'), 1, 0, 'C');
            $pdf->Cell(1, 0.5, utf8_decode('Total'), 1, 0, 'C');
            $pdf->Cell(1, 0.5, utf8_decode('NG'), 1, 0, 'C');
            $pdf->Cell(1, 0.5, utf8_decode('NTL'), 1, 0, 'C');


//--------------TRECHO QUE VAI ITERAR AS ETAPAS----------------

            $pdf->SetXY(1, 7.5);
            $readEtapas = new Read;
            $readEtapas->ExeRead("etapas_voo", "WHERE id_voo =:id", "id={$idvoo}");

            if ($readEtapas->getRowCount() > 0):
                foreach ($readEtapas->getResult() as $etapas):
                    extract($etapas);
                    $pdf->Cell(0.30, 0.5, utf8_decode($numero_etapa), 1, 0, 'C');
                    $pdf->Cell(2.35, 0.5, utf8_decode($origem), 1, 0, 'C');
                    $pdf->Cell(2.35, 0.5, utf8_decode($destino), 1, 0, 'C');
                    $p = explode(':', $partida);
                    $pdf->Cell(1, 0.5, utf8_decode($p[0] . ':' . $p[1]), 1, 0, 'C');
                    $d = explode(':', $decolagem);
                    $pdf->Cell(1, 0.5, utf8_decode($d[0] . ':' . $d[1]), 1, 0, 'C');
                    $po = explode(':', $pouso);
                    $pdf->Cell(1, 0.5, utf8_decode($po[0] . ':' . $po[1]), 1, 0, 'C');
                    $c = explode(':', $corte);
                    $pdf->Cell(1, 0.5, utf8_decode($c[0] . ':' . $c[1]), 1, 0, 'C');
                    $pdf->Cell(1, 0.5, utf8_decode($diurno), 1, 0, 'C');
                    $pdf->Cell(1, 0.5, utf8_decode($noturno), 1, 0, 'C');

                  $hora = intval((strtotime($pouso) - strtotime($decolagem))/3600);
                  $minuto = floatval((strtotime($pouso) - strtotime($decolagem))/60);
                  $resultado = $hora .':'. $minuto;


                    $pdf->Cell(1, 0.5, utf8_decode($resultado), 1, 0, 'C');
                    $pdf->Cell(2, 0.5, utf8_decode($qtepouso), 1, 0, 'C');
                    $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
                    $pdf->Cell(1, 0.5, utf8_decode($ng), 1, 0, 'C');
                    $pdf->Cell(1, 0.5, utf8_decode($ntl), 1, 0, 'C');

                    $pdf->Cell(1.5, 0.5, utf8_decode($combustivel_consumido), 1, 0, 'C');
                    $pdf->Cell(1.25, 0.5, utf8_decode(''), 1, 0, 'C');
                    $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
                    $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
                    $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
                    $pdf->Cell(2.25, 0.5, utf8_decode(''), 1, 0, 'C');
                    $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
                    $pdf->Cell(1, 0.5, utf8_decode(''), 1, 1, 'C');
                endforeach;
            endif;

            for ($i = 0; $i < (12 - $qte_etapas); $i++):
                $pdf->Cell(0.30, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(2.35, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(2.35, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(2, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');

                $pdf->Cell(1.5, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(1.25, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(2.25, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(1, 0.5, utf8_decode(''), 1, 1, 'C');
            endfor;

//--------------FIM DI TRECHO QUE ITERA AS ETAPAS----------------


            $pdf->SetXY(1, 13.5);
            $pdf->Cell(5, 0.5, utf8_decode('Total'), 1, 0, 'C');

            $pdf->Cell(1, 0.5, utf8_decode('////////'), 1, 0, 'C', true);
            $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1, 0.5, utf8_decode('////////'), 1, 0, 'C', true);
            $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');

            $pdf->Cell(1.5, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(8.5, 0.5, utf8_decode('////////////////////////////////////////////////////////////////////////////////////////////////////'), 1, 1, 'C', true);

            $pdf->Cell(27, 0.5, utf8_decode('Ocorrências: '), 1, 1, 'L');
            $pdf->Cell(27, 0.5, utf8_decode(''), 1, 1, 'L');
            $pdf->Cell(27, 0.5, utf8_decode(''), 1, 1, 'L');
            $pdf->Cell(27, 0.5, utf8_decode(''), 1, 1, 'L');
            $pdf->Cell(27, 0.5, utf8_decode('Lavagem de Compressor: (   )Sim   (   )Não   Nº VEMD/Voo:           Obs:'), 1, 1, 'L');

            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Image('./admin/images/logoNotaer.jpg', 1, 1, 2, 2);
            $pdf->Cell(13.5, 2, utf8_decode('RELATÓRIO DE MANUTENÇÃO'), 1, 0, 'C');
            $pdf->Cell(13.5, 2, utf8_decode('PARTE II - SITUAÇÃO TÉCNICA DA AERONAVE'), 1, 1, 'C');

            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(27, 0.5, utf8_decode('DISCREPÂNCIAS'), 1, 1, 'C');

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(13.5, 0.5, utf8_decode('REGISTRO DA TRIPULAÇÃO'), 1, 0, 'C');
            $pdf->Cell(13.5, 0.5, utf8_decode('APROVAÇÃO DE RETORNO AO SERVIÇO'), 1, 1, 'C');

            $pdf->Cell(2, 0.5, utf8_decode('Data'), 1, 0, 'C');
            $pdf->Cell(1, 0.5, utf8_decode('SIST'), 1, 0, 'C');
            $pdf->Cell(6.5, 0.5, utf8_decode('DISCREPÂNCIA'), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode('ANAC'), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode('Rub'), 1, 0, 'C');

            $pdf->Cell(2, 0.5, utf8_decode('Data'), 1, 0, 'C');
            $pdf->Cell(1, 0.5, utf8_decode('SIST'), 1, 0, 'C');
            $pdf->Cell(6.5, 0.5, utf8_decode('AÇÃO CORRETIVA'), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode('ANAC'), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode('Rub'), 1, 1, 'C');

//--------------TRECHO DE ITERAÇÃO DE DISCREPÂNCIA E APROVAÇÃO DE SERVIÇO---------
            for ($i = 0; $i < 7; $i++):
                $pdf->Cell(2, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(6.5, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(2, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(2, 0.5, utf8_decode(''), 1, 0, 'C');

                $pdf->Cell(2, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(1, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(6.5, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(2, 0.5, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(2, 0.5, utf8_decode(''), 1, 1, 'C');
            endfor;

//--------------FIM DO TRECHO DE ITERAÇÃO DE DISCREPÂNCIA E APROVAÇÃO DE SERVIÇO---------

            $pdf->Cell(13.5, 0.5, utf8_decode('DADOS DE VOO'), 1, 0, 'C');
            $pdf->Cell(13.5, 0.5, utf8_decode('SERVIÇOS REALIZADOS'), 1, 1, 'C');

            $pdf->Cell(3.5, 0.5, utf8_decode(''), 1, 0, 'C', true);
//$pdf->Cell(4, 0.5, utf8_decode('HORAS CÉLULA'), 1, 0, 'C');
            $pdf->Cell(4, 0.5, utf8_decode('CÉLULA'), 1, 0, 'C');
//$pdf->Cell(2, 0.5, utf8_decode('HS MOTOR'), 1, 0, 'C');
//$pdf->Cell(4, 0.5, utf8_decode('CICLO MOTOR'), 1, 0, 'C');
            $pdf->Cell(6, 0.5, utf8_decode('MOTOR'), 1, 0, 'C');
//$pdf->Cell(4, 0.5, utf8_decode('CICLO MOTOR'), 1, 0, 'C');
            $pdf->Cell(13.5, 0.5, utf8_decode(''), 1, 1, 'C');

            $pdf->Cell(3.5, 0.5, utf8_decode(''), 1, 0, 'C', true);
            $pdf->Cell(2, 0.5, utf8_decode('HORAS'), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode('POUSOS'), 1, 0, 'C');
//$pdf->Cell(2, 0.5, utf8_decode('MOTOR'), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode('HORAS'), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode('NG'), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode('NTL'), 1, 0, 'C');
            $pdf->Cell(13.5, 0.5, utf8_decode(''), 1, 1, 'C');

            $pdf->Cell(3.5, 0.5, utf8_decode('Anterior'), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(13.5, 0.5, utf8_decode(''), 1, 1, 'C');

            $pdf->Cell(3.5, 0.5, utf8_decode('Do dia'), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(13.5, 0.5, utf8_decode(''), 1, 1, 'C');

            $pdf->Cell(3.5, 0.5, utf8_decode('Total'), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(2, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(13.5, 0.5, utf8_decode(''), 1, 1, 'C');

            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(13.5, 0.5, utf8_decode('CONTROLE DE INSPEÇÕES'), 1, 0, 'C');
            $pdf->Cell(13.5, 0.5, utf8_decode(''), 1, 1, 'C');

            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(0.5, 0.5, utf8_decode(''), 1, 0, 'C', true);
            $pdf->Cell(1.875, 0.5, utf8_decode('INSPEÇÃO'), 1, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode('DISPONÍVEL'), 1, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode('DIA'), 1, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode('TOTAL'), 1, 0, 'C');
            $pdf->Cell(5.5, 0.5, utf8_decode('HORA DE INSPEÇÕES'), 1, 0, 'C');
            $pdf->Cell(13.5, 0.5, utf8_decode(''), 1, 1, 'C');

            $pdf->Cell(0.5, 0.5, utf8_decode(''), 0, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(0.5, 0.5, utf8_decode(''), 0, 0, 'C');
            $pdf->Cell(5, 0.5, utf8_decode('Última Intervenção'), 1, 0, 'L');
            $pdf->Cell(13.5, 0.5, utf8_decode(''), 1, 1, 'C');

            $pdf->Cell(0.5, 0.5, utf8_decode(''), 0, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(0.5, 0.5, utf8_decode(''), 0, 0, 'C');
            $pdf->Cell(5, 0.5, utf8_decode('Próxima Intervenção'), 1, 0, 'L');
            $pdf->Cell(13.5, 0.5, utf8_decode(''), 1, 1, 'C');

            $pdf->Cell(0.5, 0.5, utf8_decode(''), 0, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(0.5, 0.5, utf8_decode(''), 0, 0, 'C');
            $pdf->Cell(5, 0.5, utf8_decode('TSN Próxima Intervenção'), 1, 0, 'L');
            $pdf->Cell(13.5, 0.5, utf8_decode(''), 1, 1, 'C');


            $pdf->Cell(0.5, 0.5, utf8_decode(''), 0, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(0.5, 0.5, utf8_decode(''), 0, 0, 'C');
            $pdf->Cell(5, 0.5, utf8_decode('Última Intervenção'), 1, 0, 'L');
            $pdf->Cell(13.5, 0.5, utf8_decode(''), 1, 1, 'C');

            $pdf->Cell(0.5, 0.5, utf8_decode(''), 0, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(0.5, 0.5, utf8_decode(''), 0, 0, 'C');
            $pdf->Cell(5, 0.5, utf8_decode('Próxima Intervenção'), 1, 0, 'L');
            $pdf->Cell(13.5, 0.5, utf8_decode(''), 1, 1, 'C');

            $pdf->Cell(0.5, 0.5, utf8_decode(''), 0, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(1.875, 0.5, utf8_decode(''), 1, 0, 'C');
            $pdf->Cell(0.5, 0.5, utf8_decode(''), 0, 0, 'C');
            $pdf->Cell(5, 0.5, utf8_decode('TSN Próxima Intervenção'), 1, 0, 'L');
            $pdf->Cell(13.5, 0.5, utf8_decode(''), 1, 1, 'C');

            $pdf->SetXY(1, 12);
            $pdf->Cell(0.5, 1.5, utf8_decode(''), 1, 1, 'C');
            $pdf->SetXY(1, 12.25);
            $pdf->Cell(0.5, 0.3, utf8_decode('C'), 0, 1, 'C');
            $pdf->Cell(0.5, 0.3, utf8_decode('E'), 0, 1, 'C');
            $pdf->Cell(0.5, 0.3, utf8_decode('L'), 0, 0, 'C');

            $pdf->SetXY(1, 13.5);
            $pdf->Cell(0.5, 1.5, utf8_decode(''), 1, 0, 'C');
            $pdf->SetXY(1, 13.75);
            $pdf->Cell(0.5, 0.3, utf8_decode('M'), 0, 1, 'C');
            $pdf->Cell(0.5, 0.3, utf8_decode('O'), 0, 1, 'C');
            $pdf->Cell(0.5, 0.3, utf8_decode('T'), 0, 0, 'C');

            $pdf->SetXY(9, 12);
            $pdf->Cell(0.5, 1.5, utf8_decode(''), 1, 0, 'C');
            $pdf->SetXY(9, 12.25);
            $pdf->Cell(0.5, 0.3, utf8_decode('C'), 0, 0, 'C');
            $pdf->SetXY(9, 12.55);
            $pdf->Cell(0.5, 0.3, utf8_decode('E'), 0, 0, 'C');
            $pdf->SetXY(9, 12.85);
            $pdf->Cell(0.5, 0.3, utf8_decode('L'), 0, 0, 'C');

            $pdf->SetXY(1, 13.5);
            $pdf->Cell(0.5, 1.5, utf8_decode(''), 1, 0, 'C');
            $pdf->SetXY(9, 13.75);
            $pdf->Cell(0.5, 0.3, utf8_decode('M'), 0, 0, 'C');
            $pdf->SetXY(9, 14.05);
            $pdf->Cell(0.5, 0.3, utf8_decode('O'), 0, 0, 'C');
            $pdf->SetXY(9, 14.35);
            $pdf->Cell(0.5, 0.3, utf8_decode('T'), 0, 0, 'C');

//-------------COLUNAS DE ASSINATURAS-----------------
            $pdf->SetXY(1, 15);
            $pdf->MultiCell(6.75, 3, utf8_decode(''), 1, 'C');

            $pdf->SetXY(7.75, 15);
            $pdf->MultiCell(6.75, 3, utf8_decode(''), 1, 'C');

            $pdf->SetXY(14.50, 15);
            $pdf->MultiCell(6.75, 3, utf8_decode(''), 1, 'C');

            $pdf->SetXY(21.25, 15);
            $pdf->MultiCell(6.75, 3, utf8_decode(''), 1, 'C');

            $pdf->SetXY(1, 15);
            $pdf->Cell(6.75, 1, utf8_decode('REALIZADA INSPEÇÃO PRÉ-VOO (BFF)'), 0, 0, 'C');
            $pdf->Cell(6.75, 1, utf8_decode('REALIZADA INSPEÇÃO PÓS-VOO (ALF)'), 0, 0, 'C');
            $pdf->Cell(6.75, 1, utf8_decode('REALIZADA INSPEÇÃO PRÉ-VOO (BFF)'), 0, 0, 'C');
            $pdf->Cell(6.75, 1, utf8_decode('REALIZADA INSPEÇÃO PÓS-VOO (ALF)'), 0, 0, 'C');

            $pdf->SetXY(1, 15.55);
            $pdf->Cell(6.75, 3, utf8_decode('_______________________'), 0, 0, 'C');
            $pdf->Cell(6.75, 3, utf8_decode('_______________________'), 0, 0, 'C');
            $pdf->Cell(6.75, 3, utf8_decode('_______________________'), 0, 0, 'C');
            $pdf->Cell(6.75, 3, utf8_decode('_______________________'), 0, 0, 'C');

            $pdf->SetXY(1, 15.95);
            $pdf->Cell(6.75, 3, utf8_decode('Mecânico / ANAC'), 0, 0, 'C');
            $pdf->Cell(6.75, 3, utf8_decode('Mecânico / ANAC'), 0, 0, 'C');
            $pdf->Cell(6.75, 3, utf8_decode('Piloto / ANAC'), 0, 0, 'C');
            $pdf->Cell(6.75, 3, utf8_decode('Piloto / ANAC'), 0, 0, 'C');

        endforeach;
    endif;

//$pdf->Cell(19, 1, '', 0, 1, 'C');
//$pdf->Cell(3, 1, utf8_decode('Nº VOO'), 0, 0, 'C', '');
//$pdf->Cell(8, 1, utf8_decode('ID_AERO'), 0, 0, 'C', '');
//$pdf->Cell(3, 1, utf8_decode('T. TEMPO VOO'), 0, 0, 'C', '');
//$pdf->Cell(2, 1, utf8_decode('T. POUSOS'), 0, 0, 'C', '');
//$pdf->Cell(3, 1, utf8_decode('COMB.'), 0, 1, 'C', '');
//$pdf->SetTextColor(0, 0, 0);
//------------------    FIM DO CABEÇALHO    -------------------
//if ($diario->getRowCount() > 0):
//
//    extract($diario->getResult()[0]);
//    $pdf->Cell(3, 1, utf8_decode($numero_voo), 'T', 0, 'C', '');
//    $pdf->Cell(8, 1, utf8_decode($idaeronave), 'T', 0, 'C', '');
//    $pdf->Cell(3, 1, utf8_decode($tempo_total_de_voo), 'T', 0, 'C', '');
//    $pdf->Cell(2, 1, utf8_decode($total_de_pousos), 'T', 0, 'C', '');
//    $pdf->Cell(3, 1, utf8_decode($combustivel_total_consumido), 'T', 1, 'C', '');
//
//endif;
//$pdf->Cell(19, 1, utf8_decode(''), 0, 1, 'C');
//$pdf->Cell(19, 1, utf8_decode(''), 0, 1, 'C');
//$pdf->Cell(19, 1, utf8_decode('Data/Hora de Emissão: ' . date('d / m / Y - H:i') . 'h'), 0, 1, 'R');

    $pdf->Output();
endif;