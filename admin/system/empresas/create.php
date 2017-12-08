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
           

            <input type="hidden" name="voo_status" value="0" />
                           <!--<input type="submit" class="btn blue" value="Rascunho" name="SendPostForm" />-->
            <input type="submit" class="btn green" value="Cadastrar" name="SendPostForm" />

        </form>
    </article>

    <div class="clear"></div>
</div> <!-- content form- -->