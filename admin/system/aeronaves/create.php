<?php
if (!class_exists('Login')) :
    header('Location: ../../painel.php');
    die;
endif;
?>

<div class="content form_create">

    <article>

        <header>
            <h1>Cadastrar Aeronave:</h1>
        </header>

        <?php
        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($data['SendPostForm'])):
            unset($data['SendPostForm']);

            require('_models/AdminAeronave.class.php');
            $cadastraAeronave = new AdminAeronave();
            $cadastraAeronave->ExeCreate($data);

            if (!$cadastraAeronave->getResult()):
                WSErro($cadastraAeronave->getError()[0], $cadastraAeronave->getError()[1]);
            else:
                header('Location: painel.php?exe=aeronaves/update&create=true&catid=' . $cadastraAeronave->getResult());
            endif;
        endif;
        ?>

        <form name="PostForm" action="" method="post" enctype="multipart/form-data">
            <div id="form-top" class="form-group">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label><span class="field">Prefixo:</span></label> 
                        <input class="form-control" type="text" name="prefixoAeronave" />
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label><span class="field">Serial Number:</span></label> 
                        <input class="form-control" type="number" name="snAeronave" />
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">Nome:</span> </label>
                        <input class="form-control" type="text" name="nomeAeronave" />
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">Modelo:</span> </label>
                        <input class="form-control" type="text" name="modeloAeronave" />
                    </div>

                    <div class="form-group col-md-4">
                        <label><span class="field">Horas de Voo:</span> </label>
                        <input class="formHour form-control" type="text" name="horasDeVooAeronave"  placeholder="00000:00"/>
                    </div>

                </div>

            </div><!--/line-->

                                  <!--<input type="submit" class="btn blue" value="Rascunho" name="SendPostForm" />-->
            <input type="submit" class="btn green" value="Cadastrar" name="SendPostForm" />

        </form>

    </article>

    <div class="clear"></div>
</div> <!-- content home -->