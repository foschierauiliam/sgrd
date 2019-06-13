<?php

// Sessão
session_start();
// Conexão
require_once '../conn.php';

if (isset($_REQUEST['nro_pedido'])) {

    $pedido = $_POST['nro_pedido'];
    $data_despesa = $_POST["data_despesa"];
    $tipo_despesa = $_POST["tipo_despesa"];
    $valor_despesa = $_POST["valor_despesa"];
    $descr_despesa = $_POST["descr_despesa"];
    $extensoes = array("png", "jpg", "gif", "jpeg", "pdf", "tiff");
    $extensao = pathinfo($_FILES['compr_despesa']['name'], PATHINFO_EXTENSION);
    if (in_array($extensao, $extensoes)) {
        $pasta = "../upload/";
        $temporario = $_FILES['compr_despesa']['tmp_name'];
        $novo_nome = $pedido . "_" . uniqid() . ".$extensao";
        $_SESSION['nome_comprovante'] = $novo_nome;

        if (move_uploaded_file($temporario, $pasta . $novo_nome)) {
            $_SESSION['mensagem'] = "Upload realizado com sucesso";
        } else {
            $_SESSION['mensagem'] = "Erro. Não foi possível fazer o upload";
        }
    } else {
        $_SESSION['mensagem'] = "Formato inválido";
    }

   $nome_compr_despesa = $novo_nome;

    $sql = "insert into tb_itens_pedido ( data_despesa, cod_tipo_item, valor_item, obs_item, cod_pedido, comprovante_item) values ('$data_despesa','$tipo_despesa','$valor_despesa','$descr_despesa','$pedido','$nome_compr_despesa')";
    if (pg_query($sql)) {
        $_SESSION['mensagem'] = "Item adicionado!";
        header('Location: ../add_pedido.php?nro_pedido=' . $pedido);
    } else {
        $_SESSION['mensagem'] = "Erro ao alterar status. " . $erro = pg_last_error();
        header('Location: ../add_pedido.php?nro_pedido=' . $nro_pedido);
    }
}
?>