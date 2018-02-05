<div class="content form_create">

    <article>

        <header>
            <h1>Cadastrar Instalaçao:</h1>
        </header>

        <?php
        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    
        if ($data && $data['SendPostForm']):

            unset($data['SendPostForm']);

            require('_models/AdminInstalacao.class.php');
            $cadastraInstalacao = new AdminInstalacao;
            $cadastraInstalacao->ExeCreate($data);

            if (!$cadastraInstalacao->getResult()):
                WSErro($cadastraInstalacao->getError()[0], $cadastraInstalacao->getError()[1]);
            else:
                header("Location:painel.php?exe=instalacoes/update&create=true&emp={$cadastraInstalacao->getResult()}");
            endif;
        endif;
        ?>

        <form name="PostForm" action="" method="post" enctype="multipart/form-data">
            <div id="form-top" class="form-group">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label><span class="field">Aeronave:</span></label>
                        <select class="form-control j_loadcity" name="idaeronave">
                            <option></option>
                            <?php
                            $readAero = new Read;
                            $readAero->ExeRead("aeronave");

                            if ($readAero->getRowCount()):
                                foreach ($readAero->getResult() as $aeronave):
                                    extract($aeronave);
                                    echo "<option value=\"{$idAeronave}\" ";
                                    if (isset($data['idaeronave']) && $data['idaeronave'] == $idAeronave):
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
                        <select class="form-control j_loadcity" name="idtipoinspecao">
                            <option></option>
                            <?php
                            $readInsp = new Read;
                            $readInsp->ExeRead("tipo_inspecao");

                            if ($readInsp->getRowCount()):
                                foreach ($readInsp->getResult() as $insp):
                                    extract($insp);
                                    echo "<option value=\"{$id_tipo_inspecao}\" ";
                                    if (isset($data['inspecao']) && $data['inspecao'] == $id_tipo_inspecao):
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
                        <input id="in_anv" class="form-control formHour" type="text" name="in_anvInspecao" placeholder="00000:00"/>
                    </div>

                    <div class="form-group col-md-3">
                        <label><span class="field">In-Data:</span></label> 
                        <input class="form-control" type="date" name="in_dataInspecao" required=""/>
                    </div>
                    <div class="form-group col-md-3">
                        <label><span class="field">In-TSN:</span></label> 
                        <input class="form-control formHour" type="text" name="in_tsnInspecao"  placeholder="00000:00"/>
                    </div>
                    <div class="form-group col-md-3">
                        <label><span class="field">In-TS0:</span></label> 
                        <input class="form-control formHour" type="text" name="In_tsoInspecao"  placeholder="00000:00"/>
                    </div>

                </div><!--/line-->
            </div>
                    <!--<input type="submit" class="btn blue" value="Rascunho" name="SendPostForm" />-->
            <input type="submit" class="btn green" value="Cadastrar" name="SendPostForm" />

        </form>
    </article>

    <div class="clear"></div>
</div> <!-- content form- -->