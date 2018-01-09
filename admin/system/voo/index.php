<div class="content list_content">

    <section class="list_emp">

        <h1>Atividades Aéreas:</h1>      

        <?php
        $empty = filter_input(INPUT_GET, 'empty', FILTER_VALIDATE_BOOLEAN);
        if ($empty):
            WSErro("Oppsss: Você tentou editar uma atividade aérea que não existe no sistema!", WS_INFOR);
        endif;

        $action = filter_input(INPUT_GET, 'action', FILTER_DEFAULT);
        if ($action):
            require ('_models/AdminVoo.class.php');

            $empAction = filter_input(INPUT_GET, 'emp', FILTER_VALIDATE_INT);
            $empUpdate = new AdminVoo();

            switch ($action):
                case 'active':
                    $empUpdate->ExeStatus($empAction, '1');
                    WSErro("O status da atividade aérea foi atualizado para <b>ativo</b>. Atividade aérea publicado!", WS_ACCEPT);
                    break;

                case 'inative':
                    $empUpdate->ExeStatus($empAction, '0');
                    WSErro("O status da atividade aérea foi atualizado para <b>inativo</b>. Atividade aérea agora não é mais editável!", WS_ALERT);
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
        $Pager = new Pager('painel.php?exe=voo/index&page=');
        $Pager->ExePager($getPage, 10);

        $readVoo = new Read;

        $readVoo->ExeRead("voo", "ORDER BY numero_voo ASC, data_do_voo ASC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
        if ($readVoo->getResult()):
            foreach ($readVoo->getResult() as $voo):
                $empi++;
                extract($voo);
                $status = (!$idaeronave ? 'style="background: #fffed8"' : '');

                ?>
                <article<?php if ($empi % 2 == 0) echo ' class="right"'; ?> <?= $status; ?>>
                    <header>

                        <hgroup>
                            <h1><a target="_blank" href="../voo/<?= $numero_voo; ?>" title="Ver Voo"><?= '<b>Nº do voo: </b>' . $numero_voo; ?></a></h1><br>
                            <h2><?= '<b>Data do Voo: </b>' . $data_do_voo . '<br><br> <b>Comandante: </b>' . $comandante . ' <br><br> <b>Copiloto: </b>' . $copiloto; ?></h2><br>
                            <h2><?= '<b>Top D: </b>' . $topD . '<br><br> <b>top E: </b>' . $topE . ' <br><br> <b>Histórico: </b>' . $historico; ?></h2>
                        </hgroup>
                    </header>
                    <ul class="info post_actions">
                        <li><strong>Data atual:</strong> <?= date('d/m/Y H:i', strtotime($data_do_voo)); ?>Hs</li>

                        <li><a class="act_edit" href="painel.php?exe=voo/update&emp=<?= $idvoo; ?>" title="Editar">Editar</a></li>

                        <?php if (!$idaeronave): ?>
                            <li><a class="act_inative" href="painel.php?exe=voo/index&emp=<?= $idvoo; ?>&action=active" title="Ativar">Ativar</a></li>
                        <?php else: ?>
                            <li><a class="act_ative" href="painel.php?exe=voo/index&emp=<?= $idvoo; ?>&action=inative" title="Inativar">Inativar</a></li>
                        <?php endif; ?>

                        <li><a class="act_delete" href="painel.php?exe=voo/index&emp=<?= $idvoo; ?>&action=delete" title="Excluir">Deletar</a></li>
                    </ul>
                </article>
                <?php
            endforeach;
        else:
            $Pager->ReturnPage();
            WSErro("Desculpe, ainda não existem voos cadastrados!", WS_INFOR);
        endif;
        ?>

        <div class="clear"></div>
    </section>


    <?php
    $Pager->ExePaginator("voo");
    echo $Pager->getPaginator();
    ?>

    <div class="clear"></div>
</div> <!-- content home -->