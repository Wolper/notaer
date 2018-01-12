
<?php
require './_models/AdminManutencao.class.php';

$query = 'SELECT * FROM inspecao AS i JOIN tipo_inspecao AS ti ON i.id_tipo_inspecao = ti.id_tipo_inspecao';

$readRegVoo = new Read;
$readRegVoo->FullRead($query);

if ($readRegVoo->getRowCount() > 0):
    foreach ($readRegVoo->getResult() as $insp):
        extract($insp);
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

            $Data['vencimento_for_time'] = $hora[0] + $frequencia_for_time - (int) $tsn[0] - (int) $tso[0] . ':' . $hora[1];
            $Data['vencimento_for_date'] = NULL;

            if(isset($vencimento_for_time)):
                 $interval = (int)$vencimento_for_time - (int)$in_anvInspecao;
            $Data['disponivel_for_time'] = $interval;
            endif;

            $updateInsp->ExeUpdate($idInspecao, $Data);

        elseif ($tcInspecao === 'D'):
            $vencimento = new DateTime($in_dataInspecao);
            $vencimento->add(new DateInterval('P' . $frequencia_for_time . 'D'));
            $Data['vencimento_for_date'] = $vencimento->format('Y-m-d');

            $venc = new DateTime($vencimento_for_date);
            $disp = new DateTime($in_dataInspecao);
            $interval = $disp->diff($venc);
            $Data['disponivel_for_date'] = $interval->format($interval->y . ' anos, ' . $interval->m . ' meses, ' . $interval->d . ' dias');

            $updateInsp->ExeUpdate($idInspecao, $Data);

        elseif ($tcInspecao === 'M'):
            $vencimento = new DateTime($in_dataInspecao);
            $vencimento->add(new DateInterval('P' . $frequencia_for_time . 'M'));
            $Data['vencimento_for_date'] = $vencimento->format('Y-m-d');

            $venc = new DateTime($vencimento_for_date);
            $disp = new DateTime($in_dataInspecao);
            $interval = $disp->diff($venc);
            $Data['disponivel_for_date'] = $interval->format($interval->y . ' anos, ' . $interval->m . ' meses, ' . $interval->d . ' dias');


            $updateInsp->ExeUpdate($idInspecao, $Data);

        elseif ($tcInspecao === 'D/H'):
            $hora = explode(':', $in_anvInspecao);
            $Data['vencimento_for_time'] = $hora[0] + $frequencia_for_time . ':' . $hora[1];

            $vencimento = new DateTime($in_dataInspecao);
            $vencimento->add(new DateInterval('P' . $frequencia_for_date . 'D'));
            $Data['vencimento_for_date'] = $vencimento->format('Y-m-d');

            $venc = new DateTime($vencimento_for_date);
            $disp = new DateTime($in_dataInspecao);
            $interval = $disp->diff($venc);
            $Data['disponivel_for_date'] = $interval->format($interval->y . ' anos, ' . $interval->m . ' meses, ' . $interval->d . ' dias');

            $updateInsp->ExeUpdate($idInspecao, $Data);

        elseif ($tcInspecao === 'M/H'):
            $hora = explode(':', $in_anvInspecao);
            $Data['vencimento_for_time'] = $hora[0] + $frequencia_for_time . ':' . $hora[1];

            $vencimento = new DateTime($in_dataInspecao);
            $vencimento->add(new DateInterval('P' . $frequencia_for_date . 'M'));
            $Data['vencimento_for_date'] = $vencimento->format('Y-m-d');

            $venc = new DateTime($vencimento_for_date);
            $disp = new DateTime($in_dataInspecao);
            $interval = $disp->diff($venc);
            $Data['disponivel_for_date'] = $interval->format($interval->y . ' anos, ' . $interval->m . ' meses, ' . $interval->d . ' dias');

            $updateInsp->ExeUpdate($idInspecao, $Data);
        else:

//                **************************************************
//                **************************************************
//                FALTA CONDICIONAIS DE POUSO(P) NÃO SE APLICA(X)
        endif;
    endforeach;
endif;
?>

<div class="content home" style="width: 80%;">

    <h1>Manutenções</h1>
    <div class="table-responsive">
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
                $readInsp->FullRead('SELECT * FROM inspecao AS i JOIN tipo_inspecao AS ti ON i.id_tipo_inspecao = ti.id_tipo_inspecao');

                if (!$readInsp->getRowCount() > 0):
                    echo 'Ainda não há dados das aeronaves cadastrados';
                else:
                    foreach ($readInsp->getResult() as $query):
                        extract($query);

                        echo '<tr>';
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
                        endif;

                        echo '<td>' . $disponivel_for_time . '</td>';
                        echo '<td>' . $disponivel_for_date . '</td>';
                        echo '</tr>';
                    endforeach;

                endif;
                ?>
            </tbody>
        </table>
    </div>
    <div class="clear"></div>
</div> <!-- content home -->