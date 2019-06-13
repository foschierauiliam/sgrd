<?php
// Sessão
session_start();
// Conexão
require_once '../conn.php';

if(isset($_POST['btn-deletar'])):
	
	$usuario = pg_escape_string($conexao, $_POST['id']);

	$sql = "DELETE FROM tb_usuario WHERE cod_usuario = '$usuario'";

	if(pg_query($conexao, $sql)):
		$_SESSION['mensagem'] = "Deletado com sucesso!";
		header('Location: ../usuarios.php');
	else:
		$_SESSION['mensagem'] = "Erro ao deletar".pg_result_error();
		header('Location: ../usuarios.php');
	endif;
endif;