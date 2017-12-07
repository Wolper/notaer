<!--HOME CONTENT-->

<?php
$EmpLink = $Link->getData()['empresa_link'];
$Cat = $Link->getData()['empresa_cat'];
?>

<div class="site-container">

    <section class="page_empresas">
        <header class="emp_header">
            <h2><?= $Cat; ?></h2>
            <p class="tagline">Conheça as empresas cadastradas no seu guia online. Encontre aqui empresas <?= $Cat; ?></p>
        </header>

        <?php
        $getPage = (!empty($Link->getLocal()[2]) ? $Link->getLocal()[2] : 1);
        $Pager = new Pager(HOME . '/empresas/' . $EmpLink . '/');
        $Pager->ExePager($getPage, 5);
        
        $readVoo = new Read;
        $readVoo->ExeRead("app_empresas", "WHERE empresa_status = 1 AND empresa_categoria = :cat ORDER BY empresa_date DESC LIMIT :limit OFFSET :offset", "cat={$EmpLink}&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
        if (!$readVoo->getResult()):
            $Pager->ReturnPage();
            WSErro("Desculpe, ainda não existem empresas cadastras {$Cat}, favor volte depois!", WS_INFOR);
        else:
            $View = new View;
            $tpl = $View->Load('empresa_list');
            foreach ($readVoo->getResult() as $voo):

                $Cidade = new Read;
                $Cidade->ExeRead("app_cidades", "WHERE cidade_id = :cidadeid", "cidadeid={$voo['empresa_cidade']}");
                $Cidade = $Cidade->getResult()[0]['cidade_nome'];

                $Estado = new Read;
                $Estado->ExeRead("app_estados", "WHERE estado_id = :estadoid", "estadoid={$voo['empresa_uf']}");
                $Estado = $Estado->getResult()[0]['estado_uf'];

                $voo['empresa_cidade'] = $Cidade;
                $voo['empresa_uf'] = $Estado;

                $View->Show($voo, $tpl);
            endforeach;
            
            echo '<footer>';
            echo '<nav class="paginator">';
            echo '<h2>Mais resultados para NOME DA CATEGORIA</h2>';
            
            $Pager->ExePaginator("app_empresas", "WHERE empresa_status = 1 AND empresa_categoria = :cat", "cat={$EmpLink}");
            echo $Pager->getPaginator();
            
            echo '</nav>';
            echo '</footer>';
            
        endif;
        ?>          
        

    </section>

    <!--SIDEBAR-->
    <?php require(REQUIRE_PATH . '/inc/sidebar.inc.php'); ?>

    <div class="clear"></div>
</div><!--/ site container -->