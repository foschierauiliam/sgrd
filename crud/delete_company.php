<?php
// Sessão
session_start();
// Conexão
require_once '../conn.php';

if(isset($_POST['btn-deletar'])):
	
	$empresa = pg_escape_string($conexao, $_POST['id']);

	// Remoção dos usuários da empresa
	$sql = "DELETE FROM tb_usuario WHERE cod_empresa = '$empresa'";
	if(pg_query($conexao, $sql)):
		$_SESSION['mensagem'] = "Usuários removidos. Removendo empresa...";
	else:
		$_SESSION['mensagem'] = "Erro ao deletar usuário".pg_result_error();
	endif;

	$sql = "DELETE FROM tb_empresa WHERE cod_empresa = '$empresa'";

	if(pg_query($conexao, $sql)):
		$_SESSION['mensagem'] = "Deletado com sucesso!";
		header('Location: ../empresas.php');
	else:
		$_SESSION['mensagem'] = "Erro ao deletar".pg_result_error();
		header('Location: ../empresas.php');
	endif;

endif;