<?php
	$str_conexao = "host=ec2-184-72-238-22.compute-1.amazonaws.com dbname=d9e8avgv2d38gv user=kcawpzlaalfrjt password=5819dd1f663cf8ce23971ac81056b46e7061bec6d007ba131d8292077a036387";
	$conexao = pg_connect($str_conexao) or die ("Não foi possível conectar-se ao banco de dados PostgreSQL. Erro: ".pg_last_error());
?>
