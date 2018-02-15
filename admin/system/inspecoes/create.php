<div class="content form_create">

    <article>

        <header>
            <h1>Cadastrar Inspeção:</h1>
        </header>

        <?php
        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ($data && $data['SendPostForm']):
            if ($_FILES) { // Verificando se existe o envio de arquivos.
                $nome = strstr($_FILES['arquivo']['name'], '.', true);
                $FileName = Check::Name($nome) . strrchr($_FILES['arquivo']['name'], '.');
                $data['itensInspecao'] = $FileName;
            }

            unset($data['SendPostForm']);
            $comp = false;
            if ($data['tcInspecao'] === 'M/H' || $data['tcInspecao'] === 'D/H'):
                $comp = true;
            endif;

            require('_models/AdminInspecao.class.php');
            $cadastraInspecao = new AdminInspecao;
            $cadastraInspecao->ExeCreate($data);

            if (!$cadastraInspecao->getResult()):
                WSErro($cadastraInspecao->getError()[0], $cadastraInspecao->getError()[1]);
            else:
                if ($_FILES) { //  move documentos anexados.
                    $documentos['name'] = $_FILES['arquivo']['name'];
                    $documentos['tmp_name'] = $_FILES['arquivo']['tmp_name'];
                    $documentos['type'] = $_FILES['arquivo']['type'];
                    $documentos['size'] = $_FILES['arquivo']['size'];
                    $upload = new Upload;
                    $upload->File($documentos);
                }
                if ($data['tcInspecao'] == 'M/H' || $data['tcInspecao'] == 'D/H'):
                    header("Location:painel.php?exe=inspecoes/update&create=true&emp={$cadastraInspecao->getResult()}&comp=true");
                else:
                    header("Location:painel.php?exe=inspecoes/update&create=true&emp={$cadastraInspecao->getResult()}&comp=false");
                endif;
            endif;
        endif;
        ?>

        <form name="PostForm" action="" method="post" enctype="multipart/form-data">
            <div id="form-top" class="form-group">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label><span class="field">Descrição:</span></label> 
                        <input class="form-control" type="text" name="descricaoInspecao" />
                    </div>

                    <div class="form-group col-md-3">
                        <label><span class="field">PN:</span></label> 
                        <input class="form-control" type="text" name="pnInspecao" />
                    </div>
                    <div class="form-group col-md-3">
                        <label><span class="field">SN:</span></label> 
                        <input class="form-control" type="text" name="snInspecao" />
                    </div>

                    <div class="form-group col-md-2">
                        <label><span class="field">Tipo:</span> </label>
                        <select class="form-control" name="tipoInspecao" required>
                            <option disabled="" selected=""></option>
                            <option>CELULA</option>                        
                            <option>MOTOR</option>                                                 
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label><span class="field">TL:</span> </label>
                        <select class="form-control" name="tlInspecao" required>
                            <option disabled="" selected=""></option>
                            <option>OC</option>                        
                            <option>TBO</option>                        
                            <option>OTL</option>                        
                            <option>SSL</option>                        
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label><span class="field">TC:</span> </label>
                        <select id="frequencia" class="form-control" name="tcInspecao" required>
                            <option disabled="" selected=""></option>
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


                    <!----------------------------------------------------------------------------------------------->
                    <!--Na divPai abaixo, será dicionada uma div dinamicamente com os campos adequados, conforme a seleção do usuário--> 
                    <div id="divPai"></div>
                    <!----------------------------------------------------------------------------------------------->
                </div>
                <mark>Antes de anexar, renomeie o arquivo, caso haja pontos (.) na nomeclatura</mark></br>
                <label><span class="field">Anexar Documentos:</span></label>
                <input type="file" name="arquivo" />

            </div>
            <input type="submit" class="btn green" value="Cadastrar" name="SendPostForm" />

        </form>
    </article>

    <div class="clear"></div>
</div> <!-- content form- -->