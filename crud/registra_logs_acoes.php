<?php

require_once '../conn.php';
require_once '../bases/mensagem.php';
session_start();

if (!isset($_SESSION['logado'])) {

    header('Location: index.php');
}

function registra_log($log_usuario,$log_data,$log_ip,$log_operacao,$log_pedido) {
    $sql = "insert into tb_logs_pedidos (cod_usuario, data_hora, ip_origem, operacao,cod_pedido) values('$log_usuario','$log_data','$log_ip','$log_operacao','$log_pedido')";
    
    if (pg_query($sql)){
        return true;
    }
    else {
        $_SESSION['mensagem'] = "Erro ao registrar o log de atividade";
    }
}
