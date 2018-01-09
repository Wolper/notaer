
<div class="content form_create">

    <article>

        <header>
            <h1>Gerar Diário de Bordo:</h1>
        </header>

        <form id="form" name="PostForm" target="_blank" action="http://localhost/notaer/diarioPDF.php" method="post" enctype="multipart/form-data">
            <div id="form-top" class="form-group">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label><span class="field">Data do Diário:</span></label> 
                        <input id="datavoo" class="form-control" type="date" name="data_do_voo" value="2017-12-13"/>
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