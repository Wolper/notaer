<div class="content form_create">

    <article>

        <header>
            <h1>Cadastrar Inspeção:</h1>
        </header>

        <?php
        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        print_r($data);
        if ($data && $data['SendPostForm']):
//            $data['empresa_status'] = ($data['SendPostForm'] == 'Cadastrar' ? '0' : '1');
//            $data['empresa_capa'] = ($_FILES['empresa_capa']['tmp_name'] ? $_FILES['empresa_capa'] : null);
            unset($data['SendPostForm']);
            $comp = false;
            if ($data['tcInspecao'] == 'M/H' || $data['tcInspecao'] == 'D/H'):
                $comp = true;
            endif;

            require('_models/AdminInspecao.class.php');
            $cadastraInspecao = new AdminInspecao;
            $cadastraInspecao->ExeCreate($data);

            if (!$cadastraInspecao->getResult()):
                WSErro($cadastraInspecao->getError()[0], $cadastraInspecao->getError()[1]);
            else:
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

                    <div class="form-group col-md-2">
                        <label><span class="field">PN:</span></label> 
                        <input class="form-control" type="text" name="pnInspecao" />
                    </div>
                    <div class="form-group col-md-2">
                        <label><span class="field">SN:</span></label> 
                        <input class="form-control" type="text" name="snInspecao" />
                    </div>

                    <div class="form-group col-md-2">
                        <label><span class="field">TL:</span> </label>
                        <select class="form-control" name="tlInspecao" required>
                            <option disabled="" selected=""></option>
                            <option>OC</option>                        
                            <option>TBO</option>                        
                            <option>OTL</option>                        
                            <option>SSL</option>                        
                        </select>
                    </div>

                    <div class="form-group col-md-2">
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
                </div>
                <div id="freq_simples" class="row" style="display: none">
                    <div class="form-group col-md-3">
                        <label><span class="field">Frequencia:</span></label>
                        <input class="form-control" type="number" name="frequencia_for_time" placeholder="só números" />
                    </div>

                    <div class="form-group col-md-6 right">
                        <label><span class="field">Itens de Inspeção:</span> </label>
                        <input class="form-control" type="text" name="itensInspecao" placeholder="caso não exista, digite nenhum" />
                    </div>
                </div>

                <div id="freq_composta" class="row"  style="display: none">
                    <div class="form-group col-md-3">
                        <label><span class="field">Frequencia/Hora:</span></label>
                        <input class="form-control" type="number" name="frequencia_for_time" placeholder="só números" />
                    </div>

                    <div class="form-group col-md-3">
                        <label><span class="field">Frequencia/M/D:</span></label>
                        <input class="form-control" type="text" name="frequencia_for_date" placeholder="só números" />
                    </div>

                    <div class="form-group col-md-6">
                        <label><span class="field">Itens de Inspeção:</span> </label>
                        <input class="form-control" type="text" name="itensInspecao" placeholder="caso não exista, digite nenhum" />
                    </div>
                </div>

            </div><!--/line-->

                    <!--<input type="submit" class="btn blue" value="Rascunho" name="SendPostForm" />-->
            <input type="submit" class="btn green" value="Cadastrar" name="SendPostForm" />

        </form>
    </article>

    <div class="clear"></div>
</div> <!-- content form- -->