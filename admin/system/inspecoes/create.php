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
                print_r($data);
                unset($data['SendPostForm']);
                print_r($data);
                require('_models/AdminInspecao.class.php');
                $cadastraInspecao = new AdminInspecao;
                $cadastraInspecao->ExeCreate($data);

                if (!$cadastraInspecao->getResult()):
                    WSErro($cadastraInspecao->getError()[0], $cadastraInspecao->getError()[1]);
                else:
                    header("Location:painel.php?exe=inspecoes/update&create=true&emp={$cadastraInspecao->getResult()}");
                endif;
            endif;
            ?>

        <form name="PostForm" action="" method="post" enctype="multipart/form-data">
            <div id="form-top" class="form-group">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label><span class="field">Descrição:</span></label> 
                        <input class="form-control" type="text" name="descricaoInspecao" value="blablabla"/>
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">TL:</span> </label>
                        <input class="form-control" type="text" name="tlInspecao" value="OC"/>
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">TC:</span> </label>
                        <input class="form-control" type="text" name="tcInspecao" value="M"/>
                    </div><!--
                    -->
                    <div class="form-group col-md-4">
                        <label><span class="field">Frequência por Tempo:</span> </label>
                        <input class="form-control" type="number" name="frequencia_for_time" value="4500"/>
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">Frequência por Data:</span> </label>
                        <input class="form-control" type="date" name="frequencia_for_date" value="2017-12-07"/>
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">Itens de Inspeção:</span> </label>
                        <input class="form-control" type="text" name="itensInspecao" value="blablabla"/>
                    </div>

                </div>

            </div><!--/line-->

                    <!--<input type="submit" class="btn blue" value="Rascunho" name="SendPostForm" />-->
            <input type="submit" class="btn green" value="Cadastrar" name="SendPostForm" />

        </form>
    </article>

    <div class="clear"></div>
</div> <!-- content form- -->