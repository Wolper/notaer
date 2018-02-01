<div class="content home" style="width: 80%;">

    <section class="list_emp">
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
        $Pager->ExePager($getPage, 15);

        $readInspecao = new Read;
        ?>
        <div class="content home" style="width: 80%;">

            <h1>Inspeções</h1>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="text-uppercase text-center" style="background: black; color: white;">
                        <tr>
                            <th>Descrição</th>
                            <th>PN</th>
                            <th>SN</th>
                            <th>TL</th>
                            <th>TC</th>
                            <th>Frequência/Tempo</th>
                            <th>Frequência/Data</th>                          
                            <th style="color: blue;">Edição</th>
                            <th style="color: red;">Exclusão</th>
                        </tr>
                    </thead>
                    <tbody class="text-uppercase text-center bg-success">

                        <?php
                        $readInspecao->ExeRead("tipo_inspecao", "ORDER BY descricaoInspecao ASC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");

                        if (!$readInspecao->getRowCount() > 0):
                            echo 'Ainda não há dados das aeronaves cadastrados';
                        else:
                            foreach ($readInspecao->getResult() as $insp):
                                $empi++;
                                extract($insp);
                                ?>
                                <tr>
                                    <td><?= $descricaoInspecao ?></td>
                                    <td><?= $pnInspecao ?></td>
                                    <td><?= $snInspecao ?></td>
                                    <td><?= $tlInspecao ?></td>
                                    <td><?= $tcInspecao ?></td>
                                    <td><?= $frequencia_for_time ?></td>
                                    <td><?= $frequencia_for_date ?></td>
                                    <td><a   style="color: blue" class="act_edit" href="painel.php?exe=inspecoes/update&emp=<?= $id_tipo_inspecao; ?>" title="Editar">Editar</a></td>
                                    <td><a   style="color: red;" class="act_delete" href="painel.php?exe=inspecoes/index&emp=<?= $id_tipo_inspecao; ?>&action=delete" title="Excluir">Deletar</a></td>
                                </tr>

                                <?php
                            endforeach;
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="clear"></div>
        </div> <!-- content home -->

        <div class="clear"></div>
    </section>

    <?php
    $Pager->ExePaginator("inspecao");
    echo $Pager->getPaginator();
    ?>

    <div class="clear"></div>
</div> <!-- content home -->