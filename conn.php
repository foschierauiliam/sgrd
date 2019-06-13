<?php
	$str_conexao = "host=127.0.0.1 dbname=sgrd user=svc_sgrd password=d3sp3s4";
	$conexao = pg_connect($str_conexao) or die ("Não foi possível conectar-se ao banco de dados PostgreSQL. Erro: ".pg_last_error());
?>
