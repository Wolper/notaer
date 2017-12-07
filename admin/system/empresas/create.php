<div class="content form_create">

    <article>

        <header>
            <h1>Cadastrar Inspeção:</h1>
        </header>

        <?php
        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if ($data && $data['SendPostForm']):
            $data['empresa_status'] = ($data['SendPostForm'] == 'Cadastrar' ? '0' : '1');
            $data['empresa_capa'] = ($_FILES['empresa_capa']['tmp_name'] ? $_FILES['empresa_capa'] : null);

            unset($data['SendPostForm']);
            require('_models/AdminEmpresa.class.php');
            $cadastraVoo = new AdminVoo;
            $cadastraVoo->ExeCreate($data);

            if (!$cadastraVoo->getResult()):
                WSErro($cadastraVoo->getError()[0], $cadastraVoo->getError()[1]);
            else:
                header("Location:painel.php?exe=empresas/update&create=true&emp={$cadastraVoo->getResult()}");
            endif;
        endif;
        ?>

        <form id="form" name="PostForm" action="" method="post" enctype="multipart/form-data">
            <div id="form-top" class="form-group">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label><span class="field">Descrição:</span></label> 
                        <input class="form-control" type="text" name="descricaoInspecao" />
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">Itens de Inspeção:</span> </label>
                        <input class="form-control" type="text" name="itensInspecao" />
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">PN:</span> </label>
                        <input class="form-control" type="text" name="pnInspecao" />
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">SN:</span> </label>
                        <input class="form-control" type="text" name="snInspecao" />
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">in-ANV:</span> </label>
                        <input class="form-control" type="text" name="in-anvInspecao" />
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">in-DATE:</span> </label>
                        <input class="form-control" type="text" name="in-dateInspecao" />
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">in-TSO:</span> </label>
                        <input class="form-control" type="text" name="in-tsoInspecao" />
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">TL:</span> </label>
                        <input class="form-control" type="text" name="tlInspecao" />
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">TC:</span> </label>
                        <input class="form-control" type="text" name="tCInspecao" />
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">Frequência por Tempo:</span> </label>
                        <input class="form-control" type="text" name="frequencia_for_time" />
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">Frequência por Data:</span> </label>
                        <input class="form-control" type="text" name="frequencia_for_date" />
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">Vencimento por Tempo:</span> </label>
                        <input class="form-control" type="text" name="vencimento_for_time" />
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">Vencimento por Data:</span> </label>
                        <input class="form-control" type="text" name="vencimento_for_time" />
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">Disponível por Tempo:</span> </label>
                        <input class="form-control" type="text" name="vencimento_for_time" />
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">Disponível por Data:</span> </label>
                        <input class="form-control" type="text" name="vencimento_for_time" />
                    </div>

                </div>

            </div><!--/line-->

            <input type="hidden" name="voo_status" value="0" />
                           <!--<input type="submit" class="btn blue" value="Rascunho" name="SendPostForm" />-->
            <input type="submit" class="btn green" value="Cadastrar" name="SendPostForm" />

        </form>
    </article>

    <div class="clear"></div>
</div> <!-- content form- -->