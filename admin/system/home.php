<?php ?>
<div class="content home">

    <h1>Manutenções</h1>
    <table border="0" width="100%" style="text-align: left">
        <tr style="background: black; color: white;">
            <th>Descrição</th>
            <th>PN</th>
            <th>SN</th>
            <th>TL</th>
            <th>TC</th>
            <th>In-Anv</th>
            <th>In-Data</th>
            <th>In-TSN</th>
            <th>In-TSO</th>
            <th>Venc. Tempo</th>
            <th>Venc. Data</th>
            <th>Disp. Tempo</th>
            <th>Venc. Data</th>
        </tr>

<?php
$readInsp = new Read();
$readInsp->FullRead('SELECT * FROM inspecao AS i JOIN tipo_inspecao AS ti ON i.idInspecao = ti.id_tipo_inspecao');

if (!$readInsp->getRowCount() > 0):
    echo 'Ainda não há dados das aeronaves cadastrados';
else:
    extract($readInsp->getResult()[0]);

    echo '<td>' . $descricaoInspecao . '</td>';
    echo '<td>' . $pnInspecao . '</td>';
    echo '<td>' . $snInspecao . '</td>';
    echo '<td>' . $tlInspecao . '</td>';
    echo '<td>' . $tcInspecao . '</td>';
    echo '<td>' . $in_anvInspecao . '</td>';
    echo '<td>' . $in_dataInspecao . '</td>';
    echo '<td>' . $in_tsnInspecao . '</td>';
    echo '<td>' . $in_tsoInspecao . '</td>';
    echo '<td>' . $vencimento_for_time . '</td>';
    echo '<td>' . $vencimento_for_date . '</td>';
    echo '<td>' . $disponivel_for_time . '</td>';
    echo '<td>' . $disponivel_for_date . '</td>';
    echo '<tr>';

endif;
?>

    </table>
    <div class="clear"></div>
</div> <!-- content home -->