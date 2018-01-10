<div class="content form_create">

    <article>

        <header>
            <h1>Atualizar Instalação:</h1>
        </header>

        <?php
        $insp = filter_input(INPUT_GET, 'emp', FILTER_VALIDATE_INT);
        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ($data && $data['SendPostForm']):
//            $data['inspeção_status'] = ($data['SendPostForm'] == 'Atualizar' ? '0' : '1');
//            $data['inspeção_capa'] = ($_FILES['inspeção_capa']['tmp_name'] ? $_FILES['inspeção_capa'] : 'null');

            unset($data['SendPostForm']);
            require('_models/AdminInstalacao.class.php');
            $cadastraVoo = new AdminInstalacao;
            $cadastraVoo->ExeUpdate($insp, $data);

            WSErro($cadastraVoo->getError()[0], $cadastraVoo->getError()[1]);
        else:
            $readInsp = new Read;
            $readInsp->ExeRead("inspecao", "WHERE idInspecao = :insp", "insp={$insp}");
            if (!$readInsp->getResult()):
                header('Location: painel.php?exe=instalacao/index&empty=true');
            else:
                $data = $readInsp->getResult()[0];
//                extract($data);
            endif;
        endif;

        $checkCreate = filter_input(INPUT_GET, 'create', FILTER_VALIDATE_BOOLEAN);
        if ($checkCreate && empty($cadastraVoo)):
            WSErro("A instalação foi cadastrada com sucesso no sistema!", WS_ACCEPT);
        endif;
        ?>

        <form name="PostForm" action="" method="post" enctype="multipart/form-data">
            <div id="form-top" class="form-group">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label><span class="field">Aeronave:</span></label>
                         <select class="form-control j_loadcity" name="idaeronave">

                            <?php
                            $readAero = new Read;
                            $readAero->ExeRead("aeronave");

                            if ($readAero->getRowCount()):
                                foreach ($readAero->getResult() as $aeronave):
                                    extract($aeronave);
                                    echo "<option value=\"{$idAeronave}\" ";

                                    if (isset($data[0]['idaeronave']) && $data[0]['idaeronave'] == $idAeronave):
                                        echo "selected";
                                    endif;

                                    echo "> {$nomeAeronave} </option>";
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label><span class="field">Tipo de Inspeção:</span></label>
                         <select class="form-control j_loadcity" name="id_tipo_inspecao" value="<?= $data[0]['id_tipo_inspecao']; ?>">

                            <?php
                            $readAero = new Read;
                            $readAero->ExeRead("tipo_inspecao");

                            if ($readAero->getRowCount()):
                                foreach ($readAero->getResult() as $inspecao):
                                    extract($inspecao);
                                    echo "<option value=\"{$id_tipo_inspecao}\" ";

                                    if (isset($data[0]['id_tipo_inspecao']) && $data[0]['id_tipo_inspecao'] == $id_tipo_inspecao):
                                        echo "selected";
                                    endif;

                                    echo "> {$descricaoInspecao} </option>";
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label><span class="field">In-Anv:</span></label> 
                        <input class="formHour form-control" type="text" name="in_anvInspecao" value="<?= $data['in_anvInspecao'] ?>"/>
                    </div>

                    <div class="form-group col-md-3">
                        <label><span class="field">In-Data:</span></label> 
                        <input class="form-control" type="date" name="in_dataInspecao" value="<?= $data['in_dataInspecao'] ?>"/>
                    </div>
                    <div class="form-group col-md-3">
                        <label><span class="field">In-TSN:</span></label> 
                        <input class="form-control" type="time" name="in_tsnInspecao" value="<?= $data['in_tsnInspecao'] ?>"/>
                    </div>
                    <div class="form-group col-md-3">
                        <label><span class="field">In-TS0:</span></label> 
                        <input class="form-control" type="time" name="in_tsoInspecao" value="<?= $data['in_tsoInspecao'] ?>"/>
                    </div>

                </div><!--/line-->
            </div>
            
            <div class="gbform"></div>

            <input type="submit" class="btn blue" value="Atualizar" name="SendPostForm" />
            <!--<input type="submit" class="btn green" value="Atualizar & Publicar" name="SendPostForm" />-->
        </form>

    </article>

    <div class="clear"></div>
</div> <!-- content form- -->