<div class="content form_create">

    <article>

        <header>
            <h1>Atualizar Inspeção:</h1>
        </header>

        <?php
        $insp = filter_input(INPUT_GET, 'emp', FILTER_VALIDATE_INT);
        $comp = filter_input(INPUT_GET, 'comp', FILTER_DEFAULT);
        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ($data && $data['SendPostForm']):

            if ($_FILES) { // Verificando se existe o envio de arquivos.
                $nome = strstr($_FILES['arquivo']['name'], '.', true);
                $FileName = Check::Name($nome) . strrchr($_FILES['arquivo']['name'], '.');
                $data['itensInspecao'] = $FileName;
            }
            unset($data['SendPostForm']);
            require('_models/AdminInspecao.class.php');
            $cadastraVoo = new AdminInspecao;
            $cadastraVoo->ExeUpdate($insp, $data);
            if ($_FILES) { //  move documentos anexados.
                $documentos['name'] = $_FILES['arquivo']['name'];
                $documentos['tmp_name'] = $_FILES['arquivo']['tmp_name'];
                $documentos['type'] = $_FILES['arquivo']['type'];
                $documentos['size'] = $_FILES['arquivo']['size'];
                $upload = new Upload;
                $upload->File($documentos);
            }
            WSErro($cadastraVoo->getError()[0], $cadastraVoo->getError()[1]);
        else:
            $readInsp = new Read;
            $readInsp->ExeRead("tipo_inspecao", "WHERE id_tipo_inspecao = :insp", "insp={$insp}");
            if (!$readInsp->getResult()):
                header('Location: painel.php?exe=inspecoes/index&empty=true');
            else:
                $data = $readInsp->getResult()[0];
                if ($data['tcInspecao'] !== 'M/H' && $data['tcInspecao'] !== 'D/H'):
                    $comp = false;
                endif;
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

                    <div class="form-group col-md-3">
                        <label><span class="field">PN:</span></label> 
                        <input class="form-control" type="text" name="pnInspecao" value="<?= $data['pnInspecao'] ?>"/>
                    </div>
                    <div class="form-group col-md-3">
                        <label><span class="field">SN:</span></label> 
                        <input class="form-control" type="text" name="snInspecao" value="<?= $data['snInspecao'] ?>"/>
                    </div>

                    <div class="form-group col-md-2">
                        <label><span class="field">Tipo:</span> </label>
                        <select class="form-control" name="tipoInspecao">
                            <option><?= $data['tipoInspecao'] ?></option>
                            <option>CÉLULA</option>                        
                            <option>MOTOR</option>                                                 
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label><span class="field">TL:</span> </label>
                        <select class="form-control" name="tlInspecao">
                            <option><?= $data['tlInspecao'] ?></option>
                            <option>OC</option>                        
                            <option>TBO</option>                        
                            <option>OTL</option>                        
                            <option>SSL</option>                        
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label><span class="field">Previsão Limite:</span> </label>
                        <select class="form-control" name="limiteInspecao" required>
                            <option><?= $data['limiteInspecao'] ?></option>
                            <option value="10">10%</option>                        
                            <option value="15">15%</option>                        
                            <option value="20">20%</option>                        
                            <option value="25">25%</option>                        
                            <option value="30">30%</option>                        
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label><span class="field">TC:</span> </label>
                        <select class="form-control" name="tcInspecao">
                            <option><?= $data['tcInspecao'] ?></option>
                            <option>M</option>                        
                            <option>D</option>                        
                            <option>H</option>                        
                            <option>M/H</option>                        
                            <option>D/H</option>                        
                            <option>P</option>  
                            <option>T</option>                        
                            <option>N</option>  
                            <option>X</option>                        
                        </select>
                    </div>

                    <div class="row">

                        <?php
                        if ($comp === 'false'):
                            ?> 
                            <div class="form-group col-md-3">
                                <label><span class="field">Frequencia:</span></label>
                                <input class="form-control" type="number" name="frequencia_for_time" placeholder="só números"  value="<?= $data['frequencia_for_time'] ?>"/>
                            </div>
                            <?php
                        else:
                            ?>
                            <div class="form-group col-md-3">
                                <label><span class="field">Frequencia/Hora:</span></label>
                                <input class="form-control" type="number" name="frequencia_for_time" placeholder="só números"   value="<?= $data['frequencia_for_time'] ?>"/>
                            </div>

                            <div class="form-group col-md-3">
                                <label><span class="field">Frequencia/M/D:</span></label>
                                <input id="freq_MD" class="form-control" type="text" name="frequencia_for_date" placeholder="só números"   value="<?= $data['frequencia_for_date'] ?>"/>
                            </div>
                        <?php
                        endif;
                        ?>
                    </div>
                </div><!--/line-->

                <mark>Antes de anexar, renomeie o arquivo, caso haja pontos (.) na nomeclatura</mark></br>
                <label><span class="field">Anexar Documentos:</span></label>
                <input type="file" name="arquivo" value="<?= $data['itensInspecao'] ?>" />

                    <!--<input type="submit" class="btn blue" value="Rascunho" name="SendPostForm" />-->
            <!--<input type="submit" class="btn green" value="Cadastrar" name="SendPostForm" />-->

                <div class="gbform"></div>

                <input type="submit" class="btn blue" value="Atualizar" name="SendPostForm" />
                <!--<input type="submit" class="btn green" value="Atualizar & Publicar" name="SendPostForm" />-->
        </form>

    </article>

    <div class="clear"></div>
</div> <!-- content form- -->