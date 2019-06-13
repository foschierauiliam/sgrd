<?php
// Sessão
session_start();
// Conexão
require_once '../conn.php';

if(isset($_POST['btn-editar'])){
	$cod_empresa = $_POST["cod_empresa"];
	$razao_social = $_POST["razao_social"];
	$fantasia = $_POST["fantasia"];
	$cnpj = $_POST["cnpj"];
	$inscr_estadual = $_POST["inscr_estadual"];
	$cep = $_POST["cep"];
	$uf = $_POST["uf"];
	$cidade = $_POST["cidade"];
	$rua = $_POST["rua"];
	$nro = $_POST["nro"];
	$complemento = $_POST["complemento"];
	$bairro = $_POST["bairro"];
	$fone = $_POST["fone"];
	$email = $_POST["email"];
	$obs = $_POST["obs"];
	$sql = "update tb_empresa SET razao_social = '$razao_social', cnpj_empresa = '$cnpj', end_empresa_rua = '$rua', end_empresa_nro = '$nro', end_empresa_complem = '$complemento', end_empresa_bairro = '$bairro', end_empresa_cidade = '$cidade', end_empresa_uf = '$uf', end_empresa_cep = '$cep', inscr_estadual = '$inscr_estadual', fone_empresa = '$fone', email_empresa = '$email', nome_fantasia = '$fantasia', obs = '$obs' WHERE cod_empresa = '$cod_empresa'";
	if(pg_query($sql)){
		$_SESSION['mensagem'] = "Atualizado com sucesso!";
		header('Location: ../empresas.php');
	}
	else {
		$_SESSION['mensagem'] = "Erro ao atualizar. ".$erro= pg_last_error();;
		header('Location: ../empresas.php');
	}
}