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
//    include_once 'conn.php';
    require_once 'conn.php';

    if (isset($_POST['btn-entrar'])) {
        $erros = array();
        $lg_login = pg_escape_string($conexao, $_POST['login']);
        $lg_senha = pg_escape_string($conexao, $_POST['senha']);

        if (empty($lg_login) or empty($lg_senha)) {
            $erros[] = " Os campos Login e Senha devem ser preenchidos !";
            header('Location: index.php');
        } else {
            $sql = "select cod_usuario from tb_usuario where cod_usuario = '$lg_login'";
            $result = pg_query($conexao, $sql);
            if (pg_num_rows($result) > 0) {
//            $sql = "select u.cod_usuario, u.pass_usuario, e.razao_social,p.desc_perfil,cc.desc_area_setor from tb_usuario u inner join tb_empresa e on u.cod_empresa = e.cod_empresa inner join tb_perfis p on u.cod_perfil = p.cod_perfil inner join tb_area_setor cc on u.cod_area_setor = cc.cod_area_setor where u.cod_usuario = '$lg_login'";
                $sql = "select * from tb_usuario u inner join tb_empresa e on u.cod_empresa = e.cod_empresa inner join tb_perfis p on u.cod_perfil = p.cod_perfil inner join tb_area_setor cc on u.cod_area_setor = cc.cod_area_setor where u.cod_usuario = '$lg_login'";
                $result = pg_query($conexao, $sql);
                $dados = pg_fetch_array($result);
                if ($dados['status_usuario'] == 0) {
                    $erros[] = "Usuário inativo. Contate o administrador do sistema";
                    header('Location: index.php');
                } else {
                    if (password_verify($lg_senha, $dados['pass_usuario'])) {
                        $_SESSION['logado'] = true;
                        $_SESSION['cod_usuario'] = $dados['cod_usuario'];
                        $_SESSION['nome'] = $dados['primeiro_nome'];
                        $_SESSION['perfil'] = $dados['desc_perfil'];
                        $_SESSION['empresa'] = $dados['razao_social'];
                        $_SESSION['centro_custo'] = $dados['desc_area_setor'];
                        $_SESSION['cod_perfil'] = $dados['cod_perfil'];
                        $_SESSION['cod_empresa'] = $dados['cod_empresa'];
                        $_SESSION['cod_centro_custo'] = $dados['cod_area_setor'];
                        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                            $ip = $_SERVER['HTTP_CLIENT_IP'];
                        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                        } else {
                            $ip = $_SERVER['REMOTE_ADDR'];
                        }
                        $_SESSION['ip'] = $ip;
                        $erros[] = NULL;
                        header('Location: home.php');
                    } else {
                        $erros[] = "Senha não confere";
                        header('Location: index.php');
                    }
                }
            } else {
                $erros[] = " Usuário inexistente ";
                header('Location: index.php');
            }
        }
    }
    ?>

    <?php
    if (!empty($erros)) {
        foreach ($erros as $erro) {
            $_SESSION['mensagem'] = $erro;
        }
    }
    ?> 
    <body style="background-image: url('login_background.jpeg'); width: 100%; background-repeat: no-repeat; background-size: cover ;">
        <div class="section"></div>
        <main>
            <center>
                <div class="row">
                    <div class="container">
                        <div class="section"></div>
                        <div class="z-depth-2 grey lighten-4 row s12 m6 l9" style="display: inline-block; padding: 32px 48px 0px 48px; margin-top: 20px; margin-bottom: 10px;  border: 1px solid #EEE; border-radius: 8px;" >
                            <img class="responsive-img" style="width: 100px;" src="logo.png" />
                            <div class="section"><b>SGRD</b></div>
                            <form class="col s12" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                <div class="row">
                                    <div class="col s12">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="text" name="login" id="login"><br>
                                        <label for="login"><i class="material-icons left">account_circle</i>Login</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input class="validate" type="password" name="senha" id="senha"><br>
                                        <label for="senha"><i class="material-icons left">lock</i>Senha</label>
                                    </div>
                                </div>
                                <br />
                                <center>
                                    <div class="row">
                                        <button class="col s12 btn btn-large waves-effect red" type="submit" name="btn-entrar"> Entrar </button>
                                    </div>
                                </center>
                                <div class="section"></div>
                                <div class="row">
                                    <a class="black-text" href="tutorial.html" target="_blank">Tutorial</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </center>
            <div class="section"></div>
            <div class="section"></div>
        </main>
        <script src="js/materialize.min.js"></script>
        <script src="js/jquery-3.4.0.js"></script>
        <script type="text/javascript">M.AutoInit();</script>
        <script>
            $("#senha").on("focusout", function (e) {
                if ($(this).val() != $("#conf_senha").val()) {
                    $("#conf_senha").removeClass("valid").addClass("invalid");
                } else {
                    $("#conf_senha").removeClass("invalid").addClass("valid");
                }
            });

            $("#conf_senha").on("keyup", function (e) {
                if ($("#senha").val() != $(this).val()) {
                    $(this).removeClass("valid").addClass("invalid");
                } else {
                    $(this).removeClass("invalid").addClass("valid");
                }
            });
            var password = document.getElementById("senha"), confirm_password = document.getElementById("conf_senha");

            function validatePassword() {
                if (password.value != confirm_password.value) {
                    confirm_password.setCustomValidity("Passwords Don't Match");
                } else {
                    confirm_password.setCustomValidity('');
                }
            }
            password.onchange = validatePassword;
            confirm_password.onkeyup = validatePassword;
        </script>
    </body>
</html>