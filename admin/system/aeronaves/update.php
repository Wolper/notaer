<?php
if (!class_exists('Login')) :
    header('Location: ../../painel.php');
    die;
endif;
?>

<div class="content form_create">

    <article>

        <header>
            <h1>Atualizar Aeronave:</h1>
        </header>

        <?php
        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $idAero = filter_input(INPUT_GET, 'catid', FILTER_VALIDATE_INT);

        if (!empty($data['SendPostForm'])):
            unset($data['SendPostForm']);

            require('_models/AdminAeronave.class.php');
            $cadastraAeronave = new AdminAeronave;
            $cadastraAeronave->ExeUpdate($idAero, $data);

            WSErro($cadastraAeronave->getError()[0], $cadastraAeronave->getError()[1]);
        else:
            $read = new Read;
            $read->ExeRead("aeronave", "WHERE idAeronave = :id", "id={$idAero}");
            if (!$read->getResult()):
                header('Location: painel.php?exe=aeronaves/index&empty=true');
            else:
                $data = $read->getResult()[0];
            endif;
        endif;

        WSErro("A Aeronave <b>{$data['nomeAeronave']}</b> foi cadastrada com sucesso no sistema! Continue atualizando a mesma!", WS_ACCEPT);
        ?>

        <form name="PostForm" action="" method="post" enctype="multipart/form-data">
            <div id="form-top" class="form-group">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label><span class="field">Prefixo:</span></label> 
                        <input class="form-control" type="text" name="prefixoAeronave" value="<?= $data['prefixoAeronave'] ?>"/>
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">Serial Number:</span></label> 
                        <input class="form-control" type="number" name="snAeronave"  value="<?= $data['snAeronave'] ?>"/>
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">Nome:</span> </label>
                        <input class="form-control" type="text" name="nomeAeronave"  value="<?= $data['nomeAeronave'] ?>"/>
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">Modelo:</span> </label>
                        <input class="form-control" type="text" name="modeloAeronave"  value="<?= $data['modeloAeronave'] ?>"/>
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">Horas de Voo:</span> </label>
                        <input class="formHour form-control" type="text" name="horasDeVooAeronave"  value="<?= $data['horasDeVooAeronave'] ?>"/>
                    </div>

                </div>

            </div><!--/line-->

                                  <!--<input type="submit" class="btn blue" value="Rascunho" name="SendPostForm" />-->
            <!--<input type="submit" class="btn green" value="Cadastrar" name="SendPostForm" />-->
            <div class="gbform"></div>

            <input type="submit" class="btn blue" value="Atualizar" name="SendPostForm" />
        </form>

    </article>

    <div class="clear"></div>
</div> <!-- content home -->