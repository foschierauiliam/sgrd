<?php
// Header
include_once 'bases/cabecalho.php';

$usuario = $_SESSION['cod_usuario'];
$nome = $_SESSION['nome'];
$cod_perfil = $_SESSION['cod_perfil'];
$perfil = $_SESSION['perfil'];
$cod_empresa = $_SESSION['cod_empresa'];
$empresa = $_SESSION['empresa'];
$cod_area = $_SESSION['cod_centro_custo'];
$area = $_SESSION['centro_custo'];

if ($cod_perfil == 5 || $cod_perfil == 6) {
?>
<div class="row">
    <div class="col s12 m8 push-m2">
        <h3 class="light"> Registros de ações em pedidos </h3>
        <table class="striped">
            <thead>
                <tr>
                    <th>Data da ação</th>
                    <th>Usuário</th>
                    <th>IP de origem</th>
                    <th>Tipo de operação</th>
                    <th>Pedido nª</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $sql = "select * from tb_logs_pedidos l inner join tb_pedidos p on l.cod_pedido = p.cod_pedido";
                if ($cod_perfil == 5) {
                    $sql .= " AND cod_empresa = '$cod_empresa'";
                }
                $sql .= " order by l.data_hora desc";
                $retorno = pg_query($sql);

                if (pg_num_rows($retorno) > 0) {

                    while ($dados = pg_fetch_array($retorno)) {
                        ?>
                        <tr>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($dados['data_hora'])); ?></td>
                            <td><?php echo $dados['cod_usuario']; ?></td>
                            <td><?php echo $dados['ip_origem']; ?></td>
                            <td><?php echo $dados['operacao']; ?></td>
                            <td><a href="exibePedido.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>" target="_blank"><?php echo $dados['cod_pedido']; ?></a></td>
                        </tr>
                        <?php
                    };
                } else {
                    ?>

                    <tr>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    <?php
                };
                $nro_pedido = date('YmdHis') . mt_rand(1000, 9999);
                ?>

            </tbody>
        </table>
        <br>
    </div>
</div>
<?php
}
else 
{
     $_SESSION['mensagem'] = "Acesso não autorizado a esta página!";
     header('Location: home.php');
}
// Rodapé
include_once 'bases/rodape.php';
?>
