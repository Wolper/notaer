
<div class="content home" style="width: 80%;">

    <h1>Controle de Inspeções:</h1>
    <div class="table-responsive">
        <?php
        require './_models/AdminManutencao.class.php';

        $get = filter_input_array(INPUT_GET, FILTER_DEFAULT);

        if (isset($get)):

            $atualiza = new AdminManutencao;
            $atualiza->modificaControles($get['aeronave']);
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
                ?>
            </tbody>
        </table>
    </div>
    <div class="clear"></div>
</div> <!-- content home -->
