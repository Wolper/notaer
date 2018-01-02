<?php
ob_start();
session_start();
require('../_app/Config.inc.php');

$login = new Login(3);
$logoff = filter_input(INPUT_GET, 'logoff', FILTER_VALIDATE_BOOLEAN);
$getexe = filter_input(INPUT_GET, 'exe', FILTER_DEFAULT);

if (!$login->CheckLogin()):
    unset($_SESSION['userlogin']);
    header('Location: index.php?exe=restrito');
else:
    $userlogin = $_SESSION['userlogin'];
endif;

if ($logoff):
    unset($_SESSION['userlogin']);
    header('Location: index.php?exe=logoff');
endif;
?>
<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <title>NOTAER</title>
        <!--[if lt IE 9]>
            <script src="../_cdn/html5.js"></script> 
         <![endif]-->

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,800' rel='stylesheet' type='text/css' />
        <link rel="stylesheet" href="css/reset.css" />
        <link rel="stylesheet" href="css/admin.css" />
        <link rel="stylesheet" href="bootstrap/bootstrap.min.css" />
        <link rel="shortcut icon" href="images/favicon.ico" />
        <script type="text/javascript" src="bootstrap/jquery.min.js"></script>
        <script type="text/javascript" src="bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" src="__jsc/script.js"></script>
    </head>

    <body class="painel">

        <header id="navadmin">
            <div class="content">

                <h1 class="logomarca">Pro Admin</h1>

                <ul class="systema_nav radius">
                    <li class="username">Olá <?= $userlogin['user_name']; ?> <?= $userlogin['user_lastname']; ?></li>
                    <li><a class="icon profile radius" href="painel.php?exe=users/profile">Perfil</a></li>
                    <li><a class="icon users radius" href="painel.php?exe=users/users">Usuários</a></li>
                    <li><a class="icon logout radius" href="painel.php?logoff=true">Sair</a></li>
                </ul>

                <nav>
                    <!--<h1><a href="painel.php" title="Painel">Painel</a></h1>-->

                    <?php
                    //ATIVA MENU
                    if (isset($getexe)):
                        $linkto = explode('/', $getexe);
                    else:
                        $linkto = array();
                    endif;
                    ?>

                    <ul class="menu">
                        <li class="li<?php if (in_array('painel', $linkto)) echo ' active'; ?>"><a class="opensub" href="painel.php">Painel Geral</a>
                            <ul class="sub">
<!--                                <li><a href="painel.php?exe=voo/create">Registrar Voo</a></li>
                                <li><a href="painel.php?exe=voo/index">Listar / Editar Registro</a></li>-->
                            </ul>
                        </li>
                        
                        <li class="li<?php if (in_array('voo', $linkto)) echo ' active'; ?>"><a class="opensub" onclick="return false;" href="#">Registro de Atividade Aérea</a>
                            <ul class="sub">
                                <li><a href="painel.php?exe=voo/create">Registrar</a></li>
                                <li><a href="painel.php?exe=voo/index">Listar / Editar</a></li>
                                <li><a href="painel.php?exe=voo/diario">Gerar Diário de Bordo</a></li>
                            </ul>
                        </li>

                        <li class="li<?php if (in_array('aeronaves', $linkto)) echo ' active'; ?>"><a class="opensub" onclick="return false;" href="#">Aeronaves</a>
                            <ul class="sub">
                                <li><a href="painel.php?exe=aeronaves/create">Cadastrar Aeronave</a></li>
                                <li><a href="painel.php?exe=instalacoes/create">Cadastrar Instalação</a></li>
                                <li><a href="painel.php?exe=aeronaves/index">Listar / Editar Aeronave</a></li>
                            </ul>
                        </li> 

                        <li class="li<?php if (in_array('inspecoes', $linkto)) echo ' active'; ?>"><a class="opensub" onclick="return false;" href="#">Inspeções</a>
                            <ul class="sub">
                                <li><a href="painel.php?exe=inspecoes/create">Cadastrar Inspeção</a></li>
                                <li><a href="painel.php?exe=inspecoes/index">Listar / Editar Inspeção</a></li>
                            </ul>
                        </li>

                        <li class="li"><a href="painel.php" target="_blank" class="opensub">Relatórios</a></li>
                    </ul>
                </nav>

                <div class="clear"></div>
            </div><!--/CONTENT-->
        </header>

        <div id="painel">
            <?php
            //QUERY STRING
            if (!empty($getexe)):
                $includepatch = __DIR__ . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . strip_tags(trim($getexe) . '.php');
            else:
                $includepatch = __DIR__ . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'home.php';
            endif;

            if (file_exists($includepatch)):
                require_once($includepatch);
            else:
                echo "<div class=\"content notfound\">";
                WSErro("<b>Erro ao incluir tela:</b> Erro ao incluir o controller /{$getexe}.php!", WS_ERROR);
                echo "</div>";
            endif;
            ?>
        </div> <!-- painel -->

        <footer class="main_footer">         
            <p style="color: #ccc;">developed by <b>Dikson Delgado</b> - <?= date('Y'); ?> - <i>version: Beta</i></p>
        </footer>

    </body>

    <script src="../_cdn/jquery.js"></script>
    <script src="../_cdn/jmask.js"></script>
    <script src="../_cdn/combo.js"></script>
    <script src="__jsc/tiny_mce/tiny_mce.js"></script>
    <script src="__jsc/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
    <script src="__jsc/admin.js"></script>
</html>
<?php
ob_end_flush();
