<div class="content cat_list">

    <section>

        <h1>Aeronaves:</h1>

        <?php
        $empty = filter_input(INPUT_GET, 'empty', FILTER_VALIDATE_BOOLEAN);
        if ($empty):
            WSErro("Você tentou editar uma aeronave que não existe no sistema!", WS_INFOR);
        endif;

//        $action = filter_input(INPUT_GET, 'action', FILTER_DEFAULT);
//        if ($action):
//            require ('_models/AdminAeronave.class.php');
//
//            $empAction = filter_input(INPUT_GET, 'emp', FILTER_VALIDATE_INT);
//            $empUpdate = new AdminInspecao();
//
//            switch ($action):
//                case 'active':
//                    $empUpdate->ExeStatus($empAction, '1');
//                    WSErro("O status da aeronave foi atualizado para <b>ativo</b>. Inspecao publicado!", WS_ACCEPT);
//                    break;
//
//                case 'inative':
//                    $empUpdate->ExeStatus($empAction, '0');
//                    WSErro("O status da aeronave foi atualizado para <b>inativo</b>. Inspecao agora é um rascunho!", WS_ALERT);
//                    break;
//
//                case 'delete':
//                    $empUpdate->ExeDelete($empAction);
//                    WSErro($empUpdate->getError()[0], $empUpdate->getError()[1]);
//                    break;
//
//                default :
//                    WSErro("Ação não foi identifica pelo sistema, favor utilize os botões!", WS_ALERT);
//            endswitch;
//        endif;

        $empi = 0;
        $getPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $Pager = new Pager('painel.php?exe=aeronaves/index&page=');
        $Pager->ExePager($getPage, 10);

        $readAeronave = new Read;

        $readAeronave->ExeRead("aeronave", "ORDER BY nomeAeronave ASC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
        if ($readAeronave->getResult()):
            foreach ($readAeronave->getResult() as $insp):
                $empi++;
                extract($insp);
//                $status = (!$idAeronave ? 'style="background: #fffed8"' : '');
//                $stateObj = clone($readAeronave);
//                $stateObj->ExeRead("app_estados", "WHERE estado_id = :est", "est={$inspecao_uf}");
//                $state = ($stateObj->getResult() ? $stateObj->getResult()[0]['estado_uf'] : 'NULL');
//
//                $cityObj = clone($readAeronave);
//                $cityObj->ExeRead("app_cidades", "WHERE cidade_id = :city", "city={$inspecao_cidade}");
//                $city = ($cityObj->getResult() ? $cityObj->getResult()[0]['cidade_nome'] : 'NULL');
                ?>
                <article<?php if ($empi % 2 == 0) echo ' class="right"'; ?>>
                    <header>

                        <!--                        <div class="img thumb_small">
                        <?= $prefixoAeronave . ' - ' . $tlInspecao . ' - ' . $tcInspecao . ' - ' . $frequencia_for_time . ' - ' . $frequencia_for_date; ?>
                                                </div>-->

                        <hgroup>
                            <?= $prefixoAeronave . ' - ' . $snAeronave . ' - ' . $nomeAeronave . ' - ' . $modeloAeronave . ' - ' . $horasDeVooAeronave; ?>

                        </hgroup>
                    </header>
                    <ul class="info post_actions">
                        <!--<li><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($inspecao_date)); ?>Hs</li>-->

                        <li><a class="act_edit" href="painel.php?exe=aeronaves/update&emp=<?= $idAeronave; ?>" title="Editar">Editar</a></li>
                  
                        <li><a class="act_delete" href="painel.php?exe=aeronaves/index&emp=<?= $idAeronave; ?>&action=delete" title="Excluir">Deletar</a></li>
                    </ul>
                </article>
                <?php
            endforeach;
        else:
            $Pager->ReturnPage();
            WSErro("Desculpe, ainda não existem aeronaves cadastradas!", WS_INFOR);
        endif;
        ?>

        <div class="clear"></div>
    </section>


    <?php
    $Pager->ExePaginator("inspecao");
    echo $Pager->getPaginator();
    ?>

    <div class="clear"></div>
</div> <!-- content home -->