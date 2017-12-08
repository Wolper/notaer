<div class="content cat_list">

    <section>

        <h1>Aeronaves:</h1>

        <?php
        $empty = filter_input(INPUT_GET, 'empty', FILTER_VALIDATE_BOOLEAN);
        if ($empty):
            WSErro("Você tentou editar uma aeronave que não existe no sistema!", WS_INFOR);
        endif;

        $delCat = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
        if ($delCat):
            require ('_models/AdminCategory.class.php');
            $deletar = new AdminCategory;
            $deletar->ExeDelete($delCat);

            WSErro($deletar->getError()[0], $deletar->getError()[1]);
        endif;


        $readAero = new Read;
        $readAero->ExeRead("aeronave", "WHERE idAeronave ORDER BY nomeAeronave ASC");
        if (!$readAero->getResult()):

        else:
            foreach ($readAero->getResult() as $aero):
                extract($aero);
                ?>
                <section>
                    <header>
                        <h4><?= '<small>Prefixo: </small>' . $prefixoAeronave . '<small> - Nome: </small>' . $nomeAeronave . '<small> - Modelo: </small>' . $modeloAeronave . '<small> - Horas de Voo: </small>' . $horasDeVooAeronave; ?></h4>

                        <ul class="info post_actions">
        <!--                            <li><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($category_date)); ?>Hs</li>-->
                            <li><a class="act_edit" href="painel.php?exe=aeronaves/update&catid=<?= $category_id; ?>" title="Editar">Editar</a></li>
                            <li><a class="act_delete" href="painel.php?exe=aeronaves/index&delete=<?= $category_id; ?>" title="Excluir">Deletar</a></li>
                        </ul>
                    </header><small>
                </section>
                <?php
            endforeach;
        endif;
        ?>

        <div class="clear"></div></small>
    </section>

    <div class="clear"></div>
</div> <!-- content home -->