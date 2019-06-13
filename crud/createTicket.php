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

if (isset($_REQUEST['createticket']) == "true") {
    $nro_pedido = $_REQUEST['nro_pedido'];
    $cod_etapa = 1;
    $vlr_total = $_SESSION['vlr_total_pedido'];

    $sql = "update tb_pedidos set cod_etapa = '$cod_etapa', vlr_total_pedido = '$vlr_total' where cod_pedido = '$nro_pedido'";

    if (pg_query($sql)) {
        $_SESSION['mensagem'] = "Pedido cadastrado com sucesso!";
        date_default_timezone_set('America/Sao_Paulo');
        $log_data = date('Y-m-d H:i:s');
        $log_operacao = 'Cadastra pedido';
        registra_log($_SESSION['cod_usuario'], $log_data, $_SESSION['ip'], $log_operacao, $nro_pedido);
        header('Location: ../home.php');
    } else {
        $_SESSION['mensagem'] = "Erro ao cadastrar pedido. " . $erro = pg_last_error();
        ;
        header('Location: ../home.php');
    }
}