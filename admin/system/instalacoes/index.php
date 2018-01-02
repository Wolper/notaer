<div class="content list_content">

    <section class="list_emp">

        <h1>Inspeções:</h1>      

        <?php
        $empty = filter_input(INPUT_GET, 'empty', FILTER_VALIDATE_BOOLEAN);
        if ($empty):
            WSErro("Oppsss: Você tentou editar uma inspeção que não existe no sistema!", WS_INFOR);
        endif;

        $action = filter_input(INPUT_GET, 'action', FILTER_DEFAULT);
        if ($action):
            require ('_models/AdminInspecao.class.php');

            $empAction = filter_input(INPUT_GET, 'emp', FILTER_VALIDATE_INT);
            $empUpdate = new AdminInspecao();

            switch ($action):
                case 'active':
                    $empUpdate->ExeStatus($empAction, '1');
                    WSErro("O status da inspecao foi atualizado para <b>ativo</b>. Inspecao publicado!", WS_ACCEPT);
                    break;

                case 'inative':
                    $empUpdate->ExeStatus($empAction, '0');
                    WSErro("O status da inspecao foi atualizado para <b>inativo</b>. Inspecao agora é um rascunho!", WS_ALERT);
                    break;

                case 'delete':
                    $empUpdate->ExeDelete($empAction);
                    WSErro($empUpdate->getError()[0], $empUpdate->getError()[1]);
                    break;

                default :
                    WSErro("Ação não foi identifica pelo sistema, favor utilize os botões!", WS_ALERT);
            endswitch;
        endif;

        $empi = 0;
        $getPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $Pager = new Pager('painel.php?exe=inspecoes/index&page=');
        $Pager->ExePager($getPage, 10);

        $readInspecao = new Read;

        $readInspecao->ExeRead("tipo_inspecao", "ORDER BY descricaoInspecao ASC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
        if ($readInspecao->getResult()):
            foreach ($readInspecao->getResult() as $insp):
                $empi++;
                extract($insp);
//                $status = (!$idInspecao ? 'style="background: #fffed8"' : '');
//                $stateObj = clone($readInspecao);
//                $stateObj->ExeRead("app_estados", "WHERE estado_id = :est", "est={$inspecao_uf}");
//                $state = ($stateObj->getResult() ? $stateObj->getResult()[0]['estado_uf'] : 'NULL');
//
//                $cityObj = clone($readInspecao);
//                $cityObj->ExeRead("app_cidades", "WHERE cidade_id = :city", "city={$inspecao_cidade}");
//                $city = ($cityObj->getResult() ? $cityObj->getResult()[0]['cidade_nome'] : 'NULL');
                ?>
                <article<?php if ($empi % 2 == 0) echo ' class="right"'; ?>>
                    <header>

                        <hgroup>
                            <?= '<b>Descrição: </b>' . strtoupper(str_replace('-', ' ', $descricaoInspecao))  . '<br/><b>PN: </b>' . $pnInspecao . '<br/><b>SN: </b>' . $snInspecao . '<br/><b>TL: </b>' . $tlInspecao . '<br/><b>TC: </b>' . $tcInspecao . '<br/><b>Frequência: </b>' . $frequencia_for_time; ?>
                        </hgroup>
                        
                    </header>
                    <ul class="info post_actions">
                        <!--<li><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($inspecao_date)); ?>Hs</li>-->

                        <li><a class="act_edit" href="painel.php?exe=inspecoes/update&emp=<?= $idInspecao; ?>" title="Editar">Editar</a></li>
<!--
                        <?php if (!$idInspecao): ?>
                            <li><a class="act_inative" href="painel.php?exe=inspecoes/index&emp=<?= $idInspecao; ?>&action=active" title="Ativar">Ativar</a></li>
                        <?php else: ?>
                            <li><a class="act_ative" href="painel.php?exe=inspecoes/index&emp=<?= $idInspecao; ?>&action=inative" title="Inativar">Inativar</a></li>
                        <?php endif; ?>
-->
                        <li><a class="act_delete" href="painel.php?exe=inspecoes/index&emp=<?= $idInspecao; ?>&action=delete" title="Excluir">Deletar</a></li>
                    </ul>
                </article>
                <?php
            endforeach;
        else:
            $Pager->ReturnPage();
            WSErro("Desculpe, ainda não existem inspeções cadastradas!", WS_INFOR);
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