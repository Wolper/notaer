<div class="content form_create">

    <article>

        <header>
            <h1>Gerar Diário de Bordo:</h1>
        </header>

        <?php
        $post = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (isset($post) && $post['SendPostForm']):

            $diario = new Read();
            $diario->FullRead("SELECT * FROM (SELECT * FROM voo AS v JOIN etapas_voo AS e ON v.idvoo = e.id_voo WHERE data_do_voo = '" . $post['data_do_voo'] . "' AND idaeronave = '" . $post['idaeronave'] . "' GROUP BY v.numero_voo) AS vooetapa JOIN aeronave AS aero ON vooetapa.idaeronave = aero.idAeronave");

            if ($diario->getRowCount() > 0):
                header("Location: ../diarioPDF.php?data={$post['data_do_voo']}&aeronave={$post['idaeronave']}");
            else:
                WSErro("Não foi identificado diário de voo para esta data ou aeronave", WS_ALERT);
            endif;
        endif;
        ?>

        <form name="PostForm" method="post" enctype="multipart/form-data" target="_blank">
            <div id="form-top" class="form-group">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label><span class="field">Data do Diário:</span></label> 
                        <input id="datavoo" class="form-control" type="date" name="data_do_voo" required=""/>
                    </div>
                    <div class="form-group col-md-4">
                        <label><span class="field">Aeronave:</span></label>
                        <select class="form-control j_loadcity" name="idaeronave" required="">
                            <option></option>
                            <?php
                            $readAero = new Read;
                            $readAero->ExeRead("aeronave");

                            if ($readAero->getRowCount()):
                                foreach ($readAero->getResult() as $aeronave):
                                    extract($aeronave);
                                    echo "<option value=\"{$idAeronave}\" ";
                                    if (isset($data['aeronave']) && $data['aeronave'] == $idAeronave):
                                        echo "selected";
                                    endif;
                                    echo "> {$nomeAeronave} </option>";
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>
                <input type="submit" class="btn green" value="Gerar Diário" name="SendPostForm" />
            </div>
        </form>

        <div class="div">

        </div>

    </article>

    <div class="clear"></div>
</div> <!-- content form- -->