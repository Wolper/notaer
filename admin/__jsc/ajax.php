<?php

require('../../_app/Config.inc.php');
require '../_models/AdminEtapaVoo.class.php';

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (isset($data) && isset($data['SendPostForm'])):

    $data['voo_status'] = ($data['SendPostForm'] == 'Cadastrar' ? '0' : '1' );

    $dadosVoo['voo_status'] = $data['voo_status'];
    $dadosVoo['data_do_voo'] = $data['data_do_voo'];
    $dadosVoo['numero_voo'] = $data['numero_voo'];
    $dadosVoo['idaeronave'] = $data['idaeronave'];
    $dadosVoo['comandante'] = $data['comandante'];
    $dadosVoo['copiloto'] = $data['copiloto'];
    $dadosVoo['topD'] = $data['topD'];
    $dadosVoo['topE'] = $data['topE'];
    $dadosVoo['historico'] = $data['historico'];

    $dadosVoo['partida'] = $data['partida'];
    $dadosVoo['corte'] = $data['corte'];
    $dadosVoo['ciclo'] = $data['ciclo'];
    $dadosVoo['tempo_total_de_voo'] = $data['tempo_total_de_voo'];
    $dadosVoo['total_de_pousos'] = $data['total_de_pousos'];
    $dadosVoo['combustivel_total_consumido'] = $data['combustivel_total_consumido'];
    $dadosVoo['natureza'] = $data['natureza'];

    unset($data['SendPostForm']);

    require('../_models/AdminVoo.class.php');
    $cadastraVoo = new AdminVoo;
    $cadastraVoo->ExeCreate($dadosVoo);

    if (!$cadastraVoo->getResult()):
        WSErro($cadastraVoo->getError()[0], $cadastraVoo->getError()[1]);
    else:
        $cadastraEtapa = new AdminEtapaVoo();
        for ($i = 0; $i < $dadosVoo['total_de_pousos']; $i++):
            if ($i < 1):
                $indice = '';
            else:
                $indice = $i;
            endif;

            $dadosEtapa['idvoo'] = $cadastraVoo->getIdVoo();
            $dadosEtapa['numero_etapa'] = $data['numero_etapa' . $indice];
            $dadosEtapa['origem'] = $data['origem' . $indice];
            $dadosEtapa['destino'] = $data['destino' . $indice];
            $dadosEtapa['hora_de_pouso'] = $data['hora_de_pouso' . $indice];
            $dadosEtapa['combustivel_consumido'] = $data['combustivel_consumido' . $indice];


            $cadastraEtapa->ExeCreate($dadosEtapa);
        endfor;
    endif;
    $dados = array_merge($dadosVoo, $dadosEtapa);
    echo json_encode($dados);
endif;