<?php
// Sessão
session_start();
// Conexão
require_once '../conn.php';

if(isset($_POST['btn-deletar'])):
	
	$item = pg_escape_string($conexao, $_POST['id']);

	$sql = "DELETE FROM tb_itens_pedido WHERE cod_item_pedido = '$item'";

	if(pg_query($conexao, $sql)):
		$_SESSION['mensagem'] = "Item removido";
		header('Location: ../add_pedido.php?nro_pedido=' . $_SESSION['nro_pedido']);
	else:
		$_SESSION['mensagem'] = "Erro ao deletar".pg_result_error();
		header('Location: ../add_pedido.php?nro_pedido=' . $_SESSION['nro_pedido']);
	endif;
endif;