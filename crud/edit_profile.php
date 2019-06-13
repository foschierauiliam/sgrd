<?php

// Sessão
session_start();
// Conexão
require_once '../conn.php';

if (isset($_POST['btn-editar'])) {
    $desc_perfil = $_POST['desc_perfil'];
    $cod_perfil = $_POST['cod_perfil'];
    $sql = "update tb_perfis SET desc_perfil = '$desc_perfil' WHERE cod_perfil = '$cod_perfil'";
    if (pg_query($sql)) {
        $_SESSION['mensagem'] = "Atualizado com sucesso!";
        header('Location: ../perfis.php');
    } else {
        $_SESSION['mensagem'] = "Erro ao atualizar. " . $erro = pg_last_error();
        ;
        header('Location: ../usuarios.php');
    }
}