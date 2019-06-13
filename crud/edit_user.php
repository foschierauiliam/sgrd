<?php

// Sessão
session_start();
// Conexão
require_once '../conn.php';

if (isset($_POST['btn-editar'])) {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $perfil = $_POST["perfil"];
    $empresa = $_POST["empresa"];
    $cargo = $_POST["cargo"];
    $senha = password_hash($_POST["senha"], PASSWORD_BCRYPT);
    $conf_senha = password_hash($_POST["conf_senha"], PASSWORD_BCRYPT);
    $email = $_POST["email"];
    $cpf = $_POST["cpf"];
    $status_usuario = 0;
    $usuario = $_POST['cod_usuario'];
    $sql = "update tb_usuario SET primeiro_nome = '$first_name', ultimo_nome = '$last_name', cod_perfil = '$perfil', cod_empresa = '$empresa', cod_area_setor = '$cargo', pass_usuario = '$senha', email_usuario = '$email', cpf_usuario = '$cpf' WHERE cod_usuario = '$usuario'";

    if (pg_query($sql)) {
        $_SESSION['mensagem'] = "Atualizado com sucesso!";
        header('Location: ../usuarios.php');
    } else {
        $_SESSION['mensagem'] = "Erro ao atualizar. " . $erro = pg_last_error();
        ;
        header('Location: ../usuarios.php');
    }
}