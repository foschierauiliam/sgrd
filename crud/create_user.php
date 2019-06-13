<?php

// Sessão
session_start();
// Conexão
require_once '../conn.php';

// Clear
function limpar($entrada) {
    global $conexao;
    // sql
    $var = pg_escape_string($conexao, $entrada);
    // xss
    $var = htmlspecialchars($var);
    return $var;
}

if (isset($_POST['btn-cadastrar'])) {
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
    $usuario = strtolower(substr($first_name, 0, 1));
    $usuario .= strtolower(substr($last_name, 0, 1));
    $usuario .= preg_replace('/[^0-9]/', '', substr($cpf, 6));
    $sql = "insert into tb_usuario (cod_usuario, primeiro_nome, ultimo_nome, cod_perfil, cod_empresa, cod_area_setor, pass_usuario, email_usuario, cpf_usuario, status_usuario) values ('$usuario','$first_name','$last_name','$perfil','$empresa','$cargo','$senha','$email','$cpf','$status_usuario')";

    if (pg_query($sql)) {
        $_SESSION['mensagem'] = "Cadastrado com sucesso!";
        header('Location: ../usuarios.php');
    } else {
        $_SESSION['mensagem'] = "Erro ao cadastrar. " . $erro = pg_last_error();
        ;
        header('Location: ../usuarios.php');
    }
}