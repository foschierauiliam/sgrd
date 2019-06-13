<?php
// Sessão
session_start();
// Conexão
require_once '../conn.php';

if(isset($_REQUEST['cod_usuario'])){
    $usuario = $_REQUEST['cod_usuario'];
    $sql = "select status_usuario from tb_usuario where cod_usuario = '$usuario'";
    $retorno = pg_query($sql);
    while($dados = pg_fetch_array($retorno)){
		$status = $dados['status_usuario'];
		if ($status==0) {
			$new_status = 1;
		}
		else {
			$new_status = 0;	
		}
    }

	$sql = "update tb_usuario SET status_usuario = '$new_status'WHERE cod_usuario = '$usuario'";

	if(pg_query($sql)){
		$_SESSION['mensagem'] = "Status alterado!";
		header('Location: ../usuarios.php');

	}
	else {
		$_SESSION['mensagem'] = "Erro ao alterar status. ".$erro= pg_last_error();;
		header('Location: ../usuarios.php');
	}
}