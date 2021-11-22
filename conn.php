<?php
	$str_conexao = "host=    ec2-54-225-187-177.compute-1.amazonaws.com dbname=d9e8avgv2d38gv user=d1ieaa0m3khvv1 password=666baafe7c912f1684d1d72602a086c6ef986042c62ffa8477ba9a94809882d1";
	$conexao = pg_connect($str_conexao) or die ("Não foi possível conectar-se ao banco de dados PostgreSQL. Erro: ".pg_last_error());
?>
