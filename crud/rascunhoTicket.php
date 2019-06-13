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

$usuario = $_SESSION['cod_usuario'];
$nome = $_SESSION['nome'];
$cod_perfil = $_SESSION['cod_perfil'];
$perfil = $_SESSION['perfil'];
$cod_empresa = $_SESSION['cod_empresa'];
$empresa = $_SESSION['empresa'];
$cod_area = $_SESSION['cod_centro_custo'];
$area = $_SESSION['centro_custo'];


if (isset($_POST['btn-additem'])) {
    $nro_pedido = $_REQUEST['nro_pedido'];
    $cod_usuario = $usuario;
    $inicio = $_POST["periodo_ini_pedido"];
    $fim = $_POST["periodo_fim_pedido"];
    $obs = $_POST["justif_pedido"];
    $destino = $_POST["destino_pedido"];
    $vlr_total = $_POST['vlr_total_pedido'];
    date_default_timezone_set('America/Sao_Paulo');
    $data_pedido = date("Y-m-d");
    $cod_etapa = 5;
    $_SESSION['btn-additem-status'] = "disabled";
    $_SESSION['div-status'] = "";


    $sql = "insert into tb_pedidos (cod_pedido, cod_solicitante, data_pedido, periodo_ini_pedido, periodo_fim_pedido, justif_pedido, destino_pedido, vlr_total_pedido, cod_etapa, cod_empresa) "
            . "values('$nro_pedido', '$cod_usuario', '$data_pedido', '$inicio', '$fim', '$obs', '$destino', '$vlr_total', '$cod_etapa', '$cod_empresa')";

    if (pg_query($sql)) {
        $_SESSION['mensagem'] = "Pedido em rascunho!";
        header('Location: ../add_pedido.php?nro_pedido=' . $nro_pedido);
    } else {
        $_SESSION['mensagem'] = "Erro ao cadastrar rascunho. Contate o administrador" . $erro = pg_last_error();
        ;
//		header('Location: ../pedidos.php');
    }
}
