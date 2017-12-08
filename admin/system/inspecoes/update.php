<div class="content form_create">

    <article>

        <header>
            <h1>Atualizar Inspeção:</h1>
        </header>

        <?php
        $insp = filter_input(INPUT_GET, 'emp', FILTER_VALIDATE_INT);
        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        print_r($data);
        if ($data && $data['SendPostForm']):
//            $data['inspeção_status'] = ($data['SendPostForm'] == 'Atualizar' ? '0' : '1');
//            $data['inspeção_capa'] = ($_FILES['inspeção_capa']['tmp_name'] ? $_FILES['inspeção_capa'] : 'null');

            unset($data['SendPostForm']);
            require('_models/AdminInspecao.class.php');
            $cadastraVoo = new AdminInspecao;
            $cadastraVoo->ExeUpdate($insp, $data);

            WSErro($cadastraVoo->getError()[0], $cadastraVoo->getError()[1]);
        else:
            $readInsp = new Read;
            $readInsp->ExeRead("tipo_inspecao", "WHERE idInspecao = :insp", "insp={$insp}");
            if (!$readInsp->getResult()):
                header('Location: painel.php?exe=inspecoes/index&empty=true');
            else:
                $data = $readInsp->getResult()[0];
//                extract($data);
            endif;
        endif;

        $checkCreate = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
        if ($checkCreate && empty($cadastraVoo)):
            WSErro("A inspeção <b>{$data['descricaoInspecao']}</b> foi cadastrada com sucesso no sistema!", WS_ACCEPT);
        endif;
        ?>

        <form name="PostForm" action="" method="post" enctype="multipart/form-data">
            <div id="form-top" class="form-group">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label><span class="field">Descrição:</span></label> 
                        <input class="form-control" type="text" name="descricaoInspecao" value="<?= $data['descricaoInspecao'] ?>"/>
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">TL:</span> </label>
                        <input class="form-control" type="text" name="tlInspecao" value="<?= $data['tlInspecao'] ?>"/>
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">TC:</span> </label>
                        <input class="form-control" type="text" name="tcInspecao" value="<?= $data['tcInspecao'] ?>"/>
                    </div><!--
                    -->
                    <div class="form-group col-md-4">
                        <label><span class="field">Frequência por Tempo:</span> </label>
                        <input class="form-control" type="number" name="frequencia_for_time" value="<?= $data['frequencia_for_time'] ?>"/>
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">Frequência por Data:</span> </label>
                        <input class="form-control" type="date" name="frequencia_for_date" value="<?= $data['frequencia_for_date'] ?>"/>
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">Itens de Inspeção:</span> </label>
                        <input class="form-control" type="text" name="itensInspecao" value="<?= $data['itensInspecao'] ?>"/>
                    </div>

                </div>

            </div><!--/line-->

                    <!--<input type="submit" class="btn blue" value="Rascunho" name="SendPostForm" />-->
            <!--<input type="submit" class="btn green" value="Cadastrar" name="SendPostForm" />-->

            <div class="gbform"></div>

            <input type="submit" class="btn blue" value="Atualizar" name="SendPostForm" />
            <input type="submit" class="btn green" value="Atualizar & Publicar" name="SendPostForm" />
        </form>

    </article>

    <div class="clear"></div>
</div> <!-- content form- -->