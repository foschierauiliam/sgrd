<?php

// Sessão
session_start();
// Conexão
require_once '../conn.php';
require_once 'registra_logs_acoes.php';

$pedido = $_REQUEST['nro_pedido'];
$sql = "select cod_etapa from tb_pedidos where cod_pedido = '$pedido'";
$retorno = pg_fetch_array(pg_query($sql));
$etapa = $retorno[0];
if (isset($_REQUEST['approved']) == "true") {
    $etapa = $etapa + 1;
}
if (isset($_REQUEST['unapproved']) == "true") {
    $etapa = 6;
}

$sql = "update tb_pedidos SET cod_etapa = '$etapa' WHERE cod_pedido = '$pedido'";

if (pg_query($sql)) {
    $_SESSION['mensagem'] = "Análise registrada! ";
    date_default_timezone_set('America/Sao_Paulo');
    $log_data = date('Y-m-d H:i:s');
    if ($etapa == 6){
        $log_operacao = 'Reprova pedido';
    }
    else {
        $log_operacao = 'Aprova pedido';
    }
    registra_log($_SESSION['cod_usuario'], $log_data, $_SESSION['ip'], $log_operacao, $pedido);
    header('Location: ../home.php');
} else {
    $_SESSION['mensagem'] = "Erro ao efetuar análise. " . $erro = pg_last_error();
    ;
    header('Location: ../home.php');
}
