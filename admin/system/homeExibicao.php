
<div class="content home" style="width: 80%;">

    <h1>Controle de Inspeções:</h1>
    <div class="table-responsive">
        <?php
        require './_models/AdminManutencao.class.php';

        $get = filter_input_array(INPUT_GET, FILTER_DEFAULT);

        if (isset($get)):

            $query = "SELECT * FROM (SELECT * FROM inspecao AS i JOIN tipo_inspecao AS ti ON i.idtipoinspecao = ti.id_tipo_inspecao  WHERE i.idAeronave = '" . $get['aeronave'] . "' GROUP BY i.idtipoinspecao) AS ma JOIN (SELECT * FROM aeronave) AS aero ON aero.idAeronave = ma.idAeronave WHERE aero.idAeronave = '" . $get['aeronave'] . "'";

            $readRegVoo = new Read;
            $readRegVoo->FullRead($query);

            if (!$readRegVoo->getRowCount() > 0):
                echo 'Ainda não há dados das aeronaves cadastrados';

            else:
                foreach ($readRegVoo->getResult() as $cons):
                    extract($cons);

                    $vetData = explode('-', $in_dataInspecao);

                    $updateInsp = new AdminManutencao;

                    if ($tcInspecao === 'H'):
                        $hora = explode(':', $in_anvInspecao);
                        $tsn[0] = 0;
                        $tso[0] = 0;

                        if (isset($in_tsnInspecao)):
                            $tsn = explode(':', $in_tsnInspecao);
                        endif;

                        if (isset($in_tsoInspecao)):
                            $tso = explode(':', $in_tsoInspecao);
                        endif;

                        $tempoVenc = (int) ($hora[0] * 60 + $hora[1]) + ((int) $frequencia_for_time * 60) - ((int) $tsn[0] * 60 + (int) $tso[0] * 60);
                        $tempoVenc /= 60;

                        $vencInt = intval($tempoVenc);
                        $vencFloat = ($tempoVenc - $vencInt);
                        $vencFloat *= 60;

                        if ($vencFloat === 0):
                            $Data['vencimento_for_time'] = $vencInt . ':00';
                        else:
                            $Data['vencimento_for_time'] = $vencInt . ':' . intval($vencFloat);
                        endif;
                        $Data['vencimento_for_date'] = NULL;

                        if (isset($vencimento_for_time)):
                            $horasAero = explode(':', $horasDeVooAeronave);
                            $in_anv = explode(':', $in_anvInspecao);

                            $kmAero = (int) $horasAero[0] * 60 + (int) $horasAero[1];

                            $tempoVenc *= 60;

                            $totalMinutos = $tempoVenc - $kmAero;
                            $totalMinutos /= 60;

                            $dispInt = intval($totalMinutos);
                            $dispFloat = (floatval($totalMinutos) - $dispInt);
                            $dispFloat *= 60;
                            $disponivelFloat = intval($dispFloat);




                            if ($dispFloat === 0):
                                $Data['disponivel_for_time'] = $dispInt . ':00';
                            elseif (strlen($disponivelFloat) === 1):
                                $Data['disponivel_for_time'] = $dispInt . ':0' . $disponivelFloat;
                            else:
                                $Data['disponivel_for_time'] = $dispInt . ':' . $disponivelFloat;
                            endif;
                            $Data['disponivel_for_date'] = NULL;
                        endif;

                        $updateInsp->ExeUpdate($idInspecao, $Data);

                    elseif ($tcInspecao === 'D'):
                        $vencimento = new DateTime($in_dataInspecao);
                        $vencimento->add(new DateInterval('P' . $frequencia_for_time . 'D'));
                        $Data['vencimento_for_date'] = $vencimento->format('Y-m-d');
                        $Data['vencimento_for_time'] = NULL;

                        $venc = new DateTime($vencimento_for_date);
                        $disp = new DateTime(date('Y-m-d'));
                        $interval = $disp->diff($venc);
                        $Data['disponivel_for_date'] = $interval->format($interval->y . ' anos, ' . $interval->m . ' meses, ' . $interval->d . ' dias');
                        $Data['disponivel_for_time'] = NULL;

                        $updateInsp->ExeUpdate($idInspecao, $Data);

                    elseif ($tcInspecao === 'M'):
                        $vencimento = new DateTime($in_dataInspecao);
                        $vencimento->add(new DateInterval('P' . $frequencia_for_time . 'M'));
                        $Data['vencimento_for_date'] = $vencimento->format('Y-m-d');
                        $Data['vencimento_for_time'] = NULL;

                        $venc = new DateTime($vencimento_for_date);
                        $disp = new DateTime(date('Y-m-d'));
                        $interval = $disp->diff($venc);
                        $Data['disponivel_for_date'] = $interval->format($interval->y . ' anos, ' . $interval->m . ' meses, ' . $interval->d . ' dias');
                        $Data['disponivel_for_time'] = NULL;

                        $updateInsp->ExeUpdate($idInspecao, $Data);

                    elseif ($tcInspecao === 'D/H'):
                        $hora = explode(':', $in_anvInspecao);
                        $tsn[0] = 0;
                        $tso[0] = 0;

                        if (isset($in_tsnInspecao)):
                            $tsn = explode(':', $in_tsnInspecao);
                        endif;

                        if (isset($in_tsoInspecao)):
                            $tso = explode(':', $in_tsoInspecao);
                        endif;

                        $tempoVenc = (int) ($hora[0] * 60 + $hora[1]) + ((int) $frequencia_for_time * 60) - ((int) $tsn[0] * 60 + (int) $tso[0] * 60);
                        $tempoVenc /= 60;

                        $vencInt = intval($tempoVenc);
                        $vencFloat = ($tempoVenc - $vencInt);
                        $vencFloat *= 60;

                        if ($vencFloat === 0):
                            $Data['vencimento_for_time'] = $vencInt . ':00';
                        else:
                            $Data['vencimento_for_time'] = $vencInt . ':' . intval($vencFloat);
                        endif;
                        $Data['vencimento_for_date'] = NULL;

                        if (isset($vencimento_for_time)):
                            $horasAero = explode(':', $horasDeVooAeronave);
                            $in_anv = explode(':', $in_anvInspecao);

                            $kmAero = (int) $horasAero[0] * 60 + (int) $horasAero[1];

                            $tempoVenc *= 60;

                            $totalMinutos = $tempoVenc - $kmAero;
                            $totalMinutos /= 60;

                            $dispInt = intval($totalMinutos);
                            $dispFloat = (floatval($totalMinutos) - $dispInt);
                            $dispFloat *= 60;
                            $disponivelFloat = intval($dispFloat);

                            if ($dispFloat === 0):
                                $Data['disponivel_for_time'] = $dispInt . ':00';
                            elseif (strlen($disponivelFloat) === 1):
                                $Data['disponivel_for_time'] = $dispInt . ':0' . $disponivelFloat;
                            else:
                                $Data['disponivel_for_time'] = $dispInt . ':' . $disponivelFloat;
                            endif;
                            $Data['disponivel_for_date'] = NULL;
                        endif;


                        $vencimento = new DateTime($in_dataInspecao);
                        $vencimento->add(new DateInterval('P' . $frequencia_for_date . 'D'));
                        $Data['vencimento_for_date'] = $vencimento->format('Y-m-d');

                        $venc = new DateTime($vencimento_for_date);
                        $disp = new DateTime(date('Y-m-d'));
                        $interval = $disp->diff($venc);
                        $Data['disponivel_for_date'] = $interval->format($interval->y . ' anos, ' . $interval->m . ' meses, ' . $interval->d . ' dias');

                        $updateInsp->ExeUpdate($idInspecao, $Data);

                    elseif ($tcInspecao === 'M/H'):
                        $hora = explode(':', $in_anvInspecao);
                        $hora[0] = (int) $hora[0];
                        $tsn[0] = 0;
                        $tso[0] = 0;

                        if (isset($in_tsnInspecao)):
                            $tsn = explode(':', $in_tsnInspecao);
                            $tsn[0] = (int) $tsn[0];
                        endif;

                        if (isset($in_tsoInspecao)):
                            $tso = explode(':', $in_tsoInspecao);
                            $tso[0] = (int) $tsn[0];
                        endif;

                        if (isset($hora[1])):
                            $tempoVenc = (int) ($hora[0] * 60 + $hora[1]) + ((int) $frequencia_for_time * 60) - ((int) $tsn[0] * 60 + (int) $tso[0] * 60);
                        else:
                            $tempoVenc = (int) ($hora[0] * 60) + ((int) $frequencia_for_time * 60) - ((int) $tsn[0] * 60 + (int) $tso[0] * 60);
                        endif;
                        $tempoVenc /= 60;

                        $vencInt = intval($tempoVenc);
                        $vencFloat = ($tempoVenc - $vencInt);
                        $vencFloat *= 60;

                        if ($vencFloat === 0):
                            $Data['vencimento_for_time'] = $vencInt . ':00';
                        else:
                            $Data['vencimento_for_time'] = $vencInt . ':' . intval($vencFloat);
                        endif;
                        $Data['vencimento_for_date'] = NULL;



                        if (isset($vencimento_for_time)):
                            $horasAero = explode(':', $horasDeVooAeronave);
                            $in_anv = explode(':', $in_anvInspecao);

                            $kmAero = (int) $horasAero[0] * 60 + (int) $horasAero[1];

                            $tempoVenc *= 60;

                            $totalMinutos = $tempoVenc - $kmAero;
                            $totalMinutos /= 60;

                            $dispInt = intval($totalMinutos);
                            $dispFloat = (floatval($totalMinutos) - $dispInt);
                            $dispFloat *= 60;
                            $disponivelFloat = intval($dispFloat);
                            $findme = '-8';
                            $pos = strpos($disponivelFloat, $findme);

                            if ($dispFloat === 0):
                                $Data['disponivel_for_time'] = $dispInt . ':00';
                            elseif (strlen($disponivelFloat) === 1 && !$pos):
                                $Data['disponivel_for_time'] = $dispInt . ':0' . $disponivelFloat;
                            else:
                                $Data['disponivel_for_time'] = $dispInt . ':' . $disponivelFloat;
                            endif;
                            $Data['disponivel_for_date'] = NULL;
                        endif;

                        $vencimento = new DateTime($in_dataInspecao);
                        $vencimento->add(new DateInterval('P' . $frequencia_for_date . 'M'));
                        $Data['vencimento_for_date'] = $vencimento->format('Y-m-d');

                        $venc = new DateTime($vencimento_for_date);
                        $disp = new DateTime(date('Y-m-d'));
                        $interval = $disp->diff($venc);
                        $Data['disponivel_for_date'] = $interval->format($interval->y . ' anos, ' . $interval->m . ' meses, ' . $interval->d . ' dias');

                        $updateInsp->ExeUpdate($idInspecao, $Data);
                    else:


//                **************************************************
//                **************************************************
//                FALTA CONDICIONAIS PARA AS CONDIÇÕES DE POUSO(P) E NÃO SE APLICA(X)
                    endif;
                endforeach;
                ?>
                <table class="table table-striped table-bordered table-hover">
                    <thead class="text-uppercase text-center" style="background: black; color: white;">
                        <tr>
                            <th>Descrição</th>
                            <th>PN</th>
                            <th>SN</th>
                            <th>TL</th>
                            <th>TC</th>
                            <th>F/T</th>
                            <th>F/D</th>
                            <th>In/Anv</th>
                            <th>In/Data</th>
                            <th>In/TSN</th>
                            <th>In/TSO</th>
                            <th>Venc/Tempo</th>
                            <th>Venc/Data</th>
                            <th>Disp/Tempo</th>
                            <th>Disp/Data</th>
                        </tr>

                    </thead>
                    <tbody class="text-uppercase text-center bg-success">
                        <?php
                        $readInsp = new Read();
                        $readInsp->FullRead("SELECT * FROM inspecao AS i JOIN tipo_inspecao AS ti ON i.idtipoinspecao = ti.id_tipo_inspecao WHERE i.idAeronave = '" . $get['aeronave'] . "'");

                        if (!$readInsp->getRowCount() > 0):
                            echo 'Ainda não há dados das aeronaves cadastrados';
                        else:
                            foreach ($readInsp->getResult() as $query):

                                extract($query);

                                $v = new DateTime($vencimento_for_date);
                                $disp = new DateTime(date('Y-m-d'));
                                $dif = $disp->diff($v);
                                $y = $dif->format($dif->y);
                                $m = $dif->format($dif->m);
                                $di = $dif->format($dif->d);

                                $d = explode(':', $disponivel_for_time);

                                if ($disponivel_for_time !== null):
                                    if ($d[0] < '0' || $d[1] < '0'):
                                        echo '<tr style="background: #EE0000">';
                                    elseif ($d[0] <= '10' && $d[0] >= '0'):
                                        echo '<tr style="background: #FFE7A1">';
                                    elseif ($d[0] > '10'):
                                        echo '<tr style="background: #4cae4c">';
                                    endif;
                                endif;

                                if ($disponivel_for_date !== null):
                                    if ($y === '0' && $m === '0' && $di < '0'):
                                        echo '<tr style="background: #EE0000">';
                                    elseif ($y === '0' && $m === '0' && $di <= '10'):
                                        echo '<tr style="background: #FFE7A1">';
                                    elseif ($y > '0' || $m > '0' || $di > '10'):
                                        echo '<tr style="background: #4cae4c">';
                                    endif;
                                endif;

                                if ($disponivel_for_date !== null && $disponivel_for_time !== null):
                                    if (($y === '0' && $m === '0' && $di < '0') || ($d[0] < '0' || $d[1] < '0')):
                                        echo '<tr style="background: #EE0000">';
                                    elseif (($y === '0' && $m === '0' && $di <= '10') || ($d[0] <= '10' && $d[0] >= '0')):
                                        echo '<tr style="background: #FFE7A1">';
                                    elseif (($y > '0' || $m > '0' || $di > '10') || ($d[0] > '10')):
                                        echo '<tr style="background: #4cae4c">';
                                    endif;
                                endif;

                                echo '<td>' . (str_replace('-', ' ', $descricaoInspecao)) . '</td>';
                                echo '<td>' . $pnInspecao . '</td>';
                                echo '<td>' . $snInspecao . '</td>';
                                echo '<td>' . $tlInspecao . '</td>';
                                echo '<td>' . $tcInspecao . '</td>';
                                echo '<td>' . $frequencia_for_time . '</td>';
                                echo '<td>' . $frequencia_for_date . '</td>';
                                echo '<td>' . $in_anvInspecao . '</td>';
                                $inData = explode('-', $in_dataInspecao);
                                echo '<td>' . $inData[2] . '/' . $inData[1] . '/' . $inData[0] . '</td>';
                                echo '<td>' . $in_tsnInspecao . '</td>';
                                echo '<td>' . $in_tsoInspecao . '</td>';
                                echo '<td>' . $vencimento_for_time . '</td>';

                                if (isset($vencimento_for_date)):
                                    $inVencData = explode('-', $vencimento_for_date);
                                    echo '<td>' . $inVencData[2] . '/' . $inVencData[1] . '/' . $inVencData[0] . '</td>';
                                else:
                                    echo '<td></td>';
                                endif;
                                echo '<td>' . $disponivel_for_time . '</td>';
                                echo '<td>' . $disponivel_for_date . '</td>';
                                echo '</tr>';
                            endforeach;

                        endif;
                    endif;
                endif;
                ?>
            </tbody>
        </table>
    </div>
    <div class="clear"></div>
</div> <!-- content home -->
