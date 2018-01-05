<?php
$query = "SELECT * FROM voo AS v JOIN etapas_voo ev ON v.idvoo = ev.idvoo";
$readRegVoo = new Read;
$readRegVoo->FullRead($query);

if ($readRegVoo->getRowCount() > 0):
    print_r($readRegVoo->getResult());
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
                    <th>In/Anv</th>
                    <th>In/Data</th>
                    <th>In/TSN</th>
                    <th>In/TSO</th>
                    <th>Venc/Tempo</th>
                    <th>Venc/Data</th>
                    <th>Disp/Tempo</th>
                    <th>Venc/Data</th>
                </tr>
            </thead>
            <tbody class="text-uppercase text-center bg-success">
<?php
$readInsp = new Read();
$readInsp->FullRead('SELECT * FROM inspecao AS i JOIN tipo_inspecao AS ti ON i.idInspecao = ti.id_tipo_inspecao');

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
        echo '<td>' . $in_anvInspecao . '</td>';
        $inData = explode('-', $in_dataInspecao);
        echo '<td>' . $inData[2] . '/' . $inData[1] . '/' . $inData[0] . '</td>';
        echo '<td>' . $in_tsnInspecao . '</td>';
        echo '<td>' . $in_tsoInspecao . '</td>';
        echo '<td>' . $vencimento_for_time . '</td>';
        echo '<td>' . $vencimento_for_date . '</td>';
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