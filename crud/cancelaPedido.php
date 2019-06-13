<?php

// Sessão
session_start();
// Conexão
require_once '../conn.php';
require_once 'registra_logs_acoes.php';

// Clear
function limpar($entrada) {
    global $conexao;
    // sql
    $var = pg_escape_string($conexao, $entrada);
    // xss
    $var = htmlspecialchars($var);
    return $var;
}

if (isset($_REQUEST['cancela']) == "true") {
    $nro_pedido = $_REQUEST['nro_pedido'];
    $cod_etapa = 7;


    $sql = "update tb_pedidos set cod_etapa = '$cod_etapa' where cod_pedido = '$nro_pedido'";

    if (pg_query($sql)) {
        $_SESSION['mensagem'] = "Pedido cancelado pelo usuário!";
        date_default_timezone_set('America/Sao_Paulo');
        $log_data = date('Y-m-d H:i:s');
        $log_operacao = 'Cancela pedido';
        registra_log($_SESSION['cod_usuario'], $log_data, $_SESSION['ip'], $log_operacao, $nro_pedido);
        header('Location: ../home.php');
        
    } else {
        $_SESSION['mensagem'] = "Erro ao cancelar pedido. " . $erro = pg_last_error();
        ;
        header('Location: ../home.php');
    }
}