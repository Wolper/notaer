<div class="content form_create">

    <article>

        <header>
            <h1>Controle de Inspeções:</h1>
        </header>

        <?php
        $post = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (isset($post) && $post['SendPostForm']):

            $diario = new Read();
            $diario->FullRead("SELECT * FROM (SELECT * FROM inspecao AS i JOIN tipo_inspecao AS ti ON i.idtipoinspecao = ti.id_tipo_inspecao) AS insp JOIN aeronave AS aero ON insp.idAeronave = aero.idAeronave");

            if ($diario->getRowCount() > 0):
                header("Location: ./painel.php?exe=homeExibicao&aeronave={$post['idaeronave']}");
            else:
                WSErro("Não foi identificado diário de voo para esta data ou aeronave", WS_ALERT);
            endif;
        endif;
        ?>

        <form id="form" name="PostForm" method="post" enctype="multipart/form-data">
            <div id="form-top" class="form-group">
                <div class="row">

                    <div class="form-group col-md-4">
                        <label><span class="field">Selecione a aeronave desejada:</span></label>
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
                <input type="submit" class="btn green" value="Enviar" name="SendPostForm" />
            </div>
        </form>
    </article>

    <div class="clear"></div>
</div> <!-- content form- -->