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

$sql = "select cod_pedido from tb_itens_pedido";
$result_pedido = pg_query($conexao, $sql) or die("Não foi possível conectar-se ao banco de dados PostgreSQL. Erro: " . pg_last_error());
if ($result_pedido) {
    while ($row = pg_fetch_array($result_pedido)) {
        $sql = "select * from tb_pedidos where cod_pedido = " . $row['cod_pedido'];
        $result = pg_query($conexao, $sql) or die("Não foi possível conectar-se ao banco de dados PostgreSQL. Erro: " . pg_last_error());
        if (pg_num_rows($result) == 0) {
            $sql = "delete from tb_pedidos where cod_pedido = " . $row['cod_pedido'];
            $result = pg_query($conexao, $sql) or die("Não foi possível conectar-se ao banco de dados PostgreSQL. Erro: " . pg_last_error());
            $_SESSION['mensagem'] = "Rascunho removido. ";
            header('Location: ../home.php');
        }
    }
}
?>


