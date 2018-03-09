<?php

require('../../_app/Config.inc.php');
require '../_models/AdminAeronave.class.php';

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (isset($data) && isset($data['SendPostForm'])):
    $tempoDeVoo = NULL;

    $data['voo_status'] = ($data['SendPostForm'] == 'Cadastrar' ? '0' : '1' );

    $dadosVoo['voo_status'] = $data['voo_status'];
    $dadosVoo['data_do_voo'] = $data['data_do_voo'];
    $dadosVoo['numero_voo'] = $data['numero_voo'];
    $dadosVoo['idaeronave'] = $data['idaeronave'];
    $dadosVoo['comandante'] = $data['comandante'];
    $dadosVoo['copiloto'] = $data['copiloto'];
    $dadosVoo['topD'] = $data['topD'];
    $dadosVoo['topE'] = $data['topE'];
    $dadosVoo['natureza'] = $data['natureza'];


    $dadosVoo['tempo_total_de_voo'] = $data['tempo_total_de_voo'];
    $dadosVoo['total_de_pousos'] = $data['total_de_pousos'];
    $dadosVoo['combustivel_total_consumido'] = $data['combustivel_total_consumido'];
    $dadosVoo['historico'] = $data['historico'];
    $dadosVoo['ocorrencia'] = $data['ocorrencia'];
    $dadosVoo['discrepancia'] = $data['discrepancia'];
    $dadosVoo['relprev'] = $data['relprev'];
    $dadosVoo['qte_etapas'] = $data['qte_etapas'];

    unset($data['SendPostForm']);

    require('../_models/AdminVoo.class.php');
    $cadastraVoo = new AdminVoo;
    $cadastraVoo->ExeCreate($dadosVoo);

    if (!$cadastraVoo->getResult()):
        print_r($cadastraVoo->getResult());
        WSErro($cadastraVoo->getError()[0], $cadastraVoo->getError()[1]);
    else:
        require '../_models/AdminEtapaVoo.class.php';
        $cadastraEtapa = new AdminEtapaVoo();
        for ($i = 0; $i < $dadosVoo['qte_etapas']; $i++):
            if ($i < 1):
                $indice = '';
            else:
                $indice = $i;
            endif;

            $dadosEtapa['id_voo'] = $cadastraVoo->getIdVoo();
            $dadosEtapa['numero_etapa'] = $data['numero_etapa' . $indice];
            $dadosEtapa['origem'] = $data['origem' . $indice];
            $dadosEtapa['destino'] = $data['destino' . $indice];
            $dadosEtapa['partida'] = $data['partida' . $indice];
            $dadosEtapa['decolagem'] = $data['decolagem' . $indice];
            $dadosEtapa['pouso'] = $data['pouso' . $indice];
            $dadosEtapa['corte'] = $data['corte' . $indice];
            $dadosEtapa['ng'] = $data['ng' . $indice];
            $dadosEtapa['ntl'] = $data['ntl' . $indice];
            $dadosEtapa['diurno'] = $data['diurno' . $indice];
            $dadosEtapa['noturno'] = $data['noturno' . $indice];
            $dadosEtapa['qtepouso'] = $data['qtepouso' . $indice];
            $dadosEtapa['combustivel_consumido'] = $data['combustivel_consumido' . $indice];

            $cadastraEtapa->ExeCreate($dadosEtapa);

            /*
              --------------------------------------------------------------------------------------
              FASE DE ATUALIZAÇÃO DAS HORAS DE VOO DA AERONAVE C/ BASE NOS TEMPOS DE PARTIDA E CORTE
              --------------------------------------------------------------------------------------
             */

            $decolagem = new DateTime($dadosEtapa['decolagem']);
            $pouso = new DateTime($dadosEtapa['pouso']);
            $interval = $pouso->diff($decolagem);

            if (isset($tempoDeVoo)):
                $tempoDeVoo->h = $tempoDeVoo->h + $interval->h;
                $tempoDeVoo->i = $tempoDeVoo->i + $interval->i;

            else:
                $tempoDeVoo = $interval;
            endif;
        endfor;


//------------LÊ AS HORAS DE VOO DA AERONAVE------------
        $read = new Read;
        $read->ExeRead('aeronave', "WHERE idAeronave = :idAero", "idAero={$dadosVoo['idaeronave']}");

        if ($read->getResult()):
            extract($read->getResult()[0]);

            /*
              --------------------------------------------------------------------------------------
              FASE DE ATUALIZAÇÃO DA NTL E NG DA AERONAVE
              --------------------------------------------------------------------------------------
             */
            $dataAero['ntl1'] = $ntl1 + $dadosEtapa['ntl'];
            $dataAero['ng1'] = $ng1 + $dadosEtapa['ng'];

//------------EXTRAI HORAS DE VOO DA AERONAVE (STR) E TRANSFORMA EM (DATATIME)-----------
            $horasVooAero = explode(':', $horasDeVooAeronave);
            if (isset($horasVooAero[1])):
                $horas = $horasVooAero[0] * 3600;
                $minutos = $horasVooAero[1] * 60;
                $horasTrans = $horas + $minutos;
            else:
                $horas = $horasVooAero[0] * 3600;
                $horasTrans = $horas;
            endif;

            $horasD = $tempoDeVoo->h * 3600;
            $minutosD = $tempoDeVoo->i * 60;
            $horasVooDiario = $horasD + $minutosD;
            $totalHoras = ($horasTrans + $horasVooDiario) / 3600;

            $minutos = $totalHoras - intval($totalHoras);
            $minutos *= 60;

//------------ATUALIZA HORAS DE VOO DA AERONAVE------------            
            $dataAero['horasDeVooAeronave'] = intval($totalHoras) . ':' . $minutos;
            $updateAero = new AdminAeronave;
            $updateAero->ExeUpdate($dadosVoo['idaeronave'], $dataAero);
        endif;

        $dados = array_merge($dadosVoo, $dadosEtapa);
        echo json_encode($dados);
    endif;
endif;
