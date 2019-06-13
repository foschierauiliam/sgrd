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

if(isset($_POST['btn-cadastrar'])){
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
        date_default_timezone_set('America/Sao_Paulo');
        $data_cadastro = date("Y-m-d");

	$sql = "insert into tb_empresa (razao_social, cnpj_empresa, end_empresa_rua, end_empresa_nro, end_empresa_complem, end_empresa_bairro, end_empresa_cidade, end_empresa_uf,end_empresa_cep, inscr_estadual, data_cadastro, fone_empresa, email_empresa, nome_fantasia, obs) values('$razao_social', '$cnpj', '$rua', '$nro', '$complemento', '$bairro', '$cidade', '$uf', '$cep', '$inscr_estadual', '$data_cadastro', '$fone', '$email', '$fantasia', '$obs')";

	if(pg_query($sql)){
		$_SESSION['mensagem'] = "Cadastrado com sucesso!";
		header('Location: ../empresas.php');

	}
	else {
		$_SESSION['mensagem'] = "Erro ao cadastrar. ".$erro= pg_last_error();;
		header('Location: ../empresas.php');
	}
}