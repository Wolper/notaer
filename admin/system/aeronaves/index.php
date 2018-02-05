<?php
$empty = filter_input(INPUT_GET, 'empty', FILTER_VALIDATE_BOOLEAN);
if ($empty):
    WSErro("Você tentou editar uma aeronave que não existe no sistema!", WS_INFOR);
endif;

$action = filter_input(INPUT_GET, 'action', FILTER_DEFAULT);
if ($action):
    require ('_models/AdminAeronave.class.php');

    $empAction = filter_input(INPUT_GET, 'emp', FILTER_VALIDATE_INT);
    $empUpdate = new AdminAeronave();

    switch ($action):
        case 'active':
            $empUpdate->ExeStatus($empAction, '1');
            WSErro("O status da aeronave foi atualizado para <b>ativo</b>. Inspecao publicado!", WS_ACCEPT);
            break;

        case 'inative':
            $empUpdate->ExeStatus($empAction, '0');
            WSErro("O status da aeronave foi atualizado para <b>inativo</b>. Inspecao agora é um rascunho!", WS_ALERT);
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
$Pager = new Pager('painel.php?exe=aeronaves/index&page=');
$Pager->ExePager($getPage, 10);

$readAeronave = new Read;
?>

<div class="content home" style="width: 80%;">

    <h1>Aeronaves</h1>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead class="text-uppercase text-center" style="background: black; color: white;">
                <tr>
                    <th>Nome</th>
                    <th>Prefixo</th>
                    <th>Modelo Célula</th>
                    <th>Fabricante Célula</th>
                    <th>SN Célula</th>
                    <th>Pousos</th>
                    <th>Modelo Motor</th>
                    <th>Fabricante Motor</th>
                    <th>SN Motor</th>                           
                    <th>NTL</th>
                    <th>NG</th>
                    <th>Horas de Voo</th>
                    <th style="color: blue;">Edição</th>
                    <th style="color: red;">Exclusão</th>
                </tr>
            </thead>
            <tbody class="text-uppercase text-center bg-success">
                <?php
                $readAeronave->ExeRead("aeronave", "ORDER BY nomeAeronave ASC LIMIT :limit OFFSET :offset", "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");

                if (!$readAeronave->getRowCount() > 0):
                    echo 'Ainda não há dados das aeronaves cadastrados';
                else:
                    foreach ($readAeronave->getResult() as $insp):
                        $empi++;
                        extract($insp);
                        ?>
                        <tr>
                            <td><?= $nomeAeronave ?></td>
                            <td><?= $prefixoAeronave ?></td>
                            <td><?= $modeloCelula ?></td>
                            <td><?= $fabricanteCelula ?></td>
                            <td><?= $serialCelula ?></td>
                            <td><?= $pousos ?></td>
                            <td><?= $modeloMotor ?></td>
                            <td><?= $fabricanteMotor ?></td>
                            <td><?= $serialMotor ?></td>
                            <td><?= $ntl ?></td>
                            <td><?= $ng ?></td>
                            <td><?= $horasDeVooAeronave ?></td>
                            <td><a   style="color: blue" class="act_edit" href="painel.php?exe=aeronaves/update&catid=<?= $idAeronave; ?>" title="Editar">Editar</a></td>
                            <td><a   style="color: red;" class="act_delete" href="painel.php?exe=aeronaves/index&emp=<?= $idAeronave; ?>&action=delete" title="Excluir">Deletar</a></td>
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



<?php
$Pager->ExePaginator("aeronave");
echo $Pager->getPaginator();
?>

<div class="clear"></div>
</div> <!-- content home -->