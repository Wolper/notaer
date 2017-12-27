<div class="content home">

    <h1>Espaço reservado para exibição e alertas de manutenção!</h1>

    <?php
    $readInsp = new Read();
    $readInsp->ExeRead('tipo_inspecao');

    if (!$readInsp->getRowCount() > 0):
        echo 'Ainda não há dados das aeronaves cadastrados';
    else:
        extract($readInsp->getResult()[0]);
        echo $descricaoInspecao;
    endif;
    ?>

    <div class="clear"></div>
</div> <!-- content home -->