<div class="content home" style="width: 100%;">

    <section class="list_emp">
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
        $Pager->ExePager($getPage, 5);

        $readVoo = new Read;
        ?>
        <div class="content home" style="width: 80%;">

            <h1>Atividades Aéreas:</h1>      
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="text-uppercase text-center" style="background: black; color: white; text-align: justify">
                        <tr>
                            <th>Nº Voo</th>
                            <th>Data do Voo</th>
                            <th>Aeronave</th>
                            <th>Comandante</th>
                            <th>Copiloto</th>
                            <th>Natureza</th>
                            <th>Tempo Voo</th>
                            <th>Nº Pousos</th>                          
                            <!--<th>Combustível</th>-->                          
                            <th>Histórico</th>                          
                            <th>Ocorrência</th>                          
                            <th>Discrepância</th>                          
                            <th>RelPrev</th>                          
                            <th style="color: blue;">Edição</th>
                            <th style="color: red;">Exclusão</th>
                        </tr>
                    </thead>
                    <tbody class="text-uppercase text-center bg-success">

                        <?php
//                        $readVoo->ExeRead("voo", "ORDER BY numero_voo ASC, data_do_voo ASC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
//                        $readVoo->FullRead("SELECT * FROM voo AS v JOIN aeronave AS ae ON v.idaeronave = ae.idAeronave ORDER BY idvoo DESC, data_do_voo ASC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                        $readVoo->FullRead("SELECT * FROM voo AS v JOIN aeronave AS ae ON v.idaeronave = ae.idAeronave ORDER BY idvoo DESC, data_do_voo ASC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");

                        if (!$readVoo->getRowCount() > 0):
                            echo 'Ainda não há dados das aeronaves cadastrados';
                        else:
                            foreach ($readVoo->getResult() as $insp):
                                $empi++;
                                extract($insp);
                                ?>
                                <tr>
                                    <td><?= $numero_voo ?></td>
                                    <?php
                                    $data = explode('-', $data_do_voo);
                                    ?>
                                    <td><?= $data[2].'/'.$data[1].'/'.$data[0] ?></td>
                                    <!--<td><?= $data_do_voo ?></td>-->
                                    <td><?= $nomeAeronave ?></td>
                                    <td><?= $comandante ?></td>
                                    <td><?= $copiloto ?></td>
                                    <td><?= $natureza ?></td>
                                    <td><?= $tempo_total_de_voo ?></td>
                                    <td><?= $total_de_pousos ?></td>
                                    <!--<td><?= $combustivel_total_consumido ?></td>-->
                                    <td style="width: 300%"><?= $historico ?></td>
                                    <td><?= $ocorrencia ?></td>
                                    <td><?= $discrepancia ?></td>
                                    <td><?= $relprev ?></td>
                                    <td><a style="color: blue" class="act_edit" href="painel.php?exe=voo/update&emp=<?= $idvoo; ?>" title="Editar">Editar</a></td>
                                    <td><a style="color: red;" class="act_delete" href="painel.php?exe=voo/index&emp=<?= $idvoo; ?>&action=delete" title="Excluir">Deletar</a></td>
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
    $Pager->ExePaginator("voo");
    echo $Pager->getPaginator();
    ?>

    <div class="clear"></div>
</div> <!-- content home -->
