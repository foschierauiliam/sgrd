<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>SGRD - Sistema de Gestão de Reembolso de Despesas</title>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link rel="stylesheet" href="css/materialize.min.css">

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <?php
    include 'bases/mensagem.php';
    require_once 'conn.php';

    if (!isset($_SESSION['logado'])) {

        header('Location: index.php');
    }

    $usuario = $_SESSION['cod_usuario'];
    $nome = $_SESSION['nome'];
    $cod_perfil = $_SESSION['cod_perfil'];
    $perfil = $_SESSION['perfil'];
    $cod_empresa = $_SESSION['cod_empresa'];
    $empresa = $_SESSION['empresa'];
    $cod_area = $_SESSION['cod_centro_custo'];
    $area = $_SESSION['centro_custo'];
    $ip = $_SESSION['ip'];
    ?>
    <body>

        <ul id="menu_pedidos" class="dropdown-content">
            <li><a href="add_pedido.php">Novo pedido</a></li>
            <li><a href="usr_pedidos.php">Consulta pedidos</a></li>
        </ul>
        <ul id="menu_cadastros" class="dropdown-content">
            <li><a href="usuarios.php">Usuários</a></li>
            <?php
            if ($cod_perfil == 6) {
                echo '<li><a href="empresas.php">Empresas</a></li>';
            }
            ?>
            <li><a href="tipos_item.php">Tipos de Itens</a></li>

        </ul>
        <ul id="menu_usuario" class="dropdown-content">
            <li><a href="#!"><?php echo $usuario; ?></a></li>
            <li><a href="#!"><?php echo $perfil; ?></a></li>
            <li><a href="#!"><?php echo $empresa; ?></a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
        <ul class="sidenav" id="menu-mobile">
            <div class="card medium">
                <div class="card-image">
                    <img src="login_background.jpeg">
                    <span class="card-title">Bem vindo(a), <?php echo $nome; ?></span>
                </div>
                <div class="card-content">
                    <p><?php echo $empresa; ?></p>
                    <p>Login: <?php echo $usuario; ?></p>
                    <p>Perfil: <?php echo $perfil; ?></p>
                </div>
                <div class="card-action">
                    <a class="grey-text" href="logout.php"><i class="material-icons right">exit_to_app</i>Logout</a>
                </div>
            </div>
            <li><a class="collapsible-header" href="home.php">Home</a></li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header" href="#!"><i class="material-icons right">arrow_drop_down</i>Pedidos</a> 
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="add_pedido.php">Novo pedido</a></li>
                                <li><a href="usr_pedidos.php">Consulta pedidos</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>

            <?php
            //menu variável
            if ($cod_perfil == 5 || $cod_perfil == 6) {
                ?>
                <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                        <li>
                            <a class="collapsible-header" href="#">Cadastros<i class="material-icons right">arrow_drop_down</i></a> 
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="usuarios.php">Usuários</a></li>
                                    <?php
                                    if ($cod_perfil == 6) {
                                        echo '<li><a href="empresas.php">Empresas</a></li>';
                                    }
                                    ?>
                                    <li><a href="tipos_item.php">Tipos de Itens</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a class="collapsible-header" href="logs_pedidos.php" >Logs</a></li>
                    </ul>
                </li>
            <?php } ?>
        </ul>




        <nav class="red" style="padding: 0px 10px;">
            <div class="nav-wrapper">
                <div class="brand-logo"><img src="logo.png" style="width: 50px; padding: 0; margin-top: 20%;" /></div>

                <a href="#" class="sidenav-trigger" data-target="menu-mobile">
                    <i class="material-icons">menu</i>
                </a>
                <div class="col s12 m6">
                    <ul class="right hide-on-med-and-down">
                        <li><a href="home.php">Home</a></li>
                        <li><a class="dropdown-trigger" href="#!" data-target="menu_pedidos">Pedidos<i class="material-icons right">arrow_drop_down</i></a></li>
                        <?php
                        //menu variável
                        if ($cod_perfil == 5 || $cod_perfil == 6) {
                            ?><li><a class="dropdown-trigger" href="#" data-target="menu_cadastros">Cadastros<i class="material-icons right">arrow_drop_down</i></a></li> <?php
                            ?><li><a href="logs_pedidos.php" >Logs</a></li><?php
                        }
                        ?>
                        <li><a class="dropdown-trigger" data-target="menu_usuario" href="#"><?php echo $nome; ?><i class="material-icons right">account_circle</i></a></li>
                        <!-- Dropdown Trigger -->
                    </ul>
                </div>
            </div>
        </nav> 
