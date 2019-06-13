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


?>
<div class="row">
    <div class="col s12 m8 push-m2">
        <h3 class="light"> Pedidos </h3>
        <table class="striped">
            <thead>
                <tr>
                    <th>Pedido nº</th>
                    <th>Solicitante</th>
                    <th>Data do pedido</th>
                    <th>Empresa</th>
                    <th>Valor total</th>
                    <th>Status do pedido</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php
                $sql = "select distinct on (p.cod_pedido) * from tb_pedidos p inner join tb_itens_pedido i on p.cod_pedido = i.cod_pedido inner join tb_empresa e on p.cod_empresa = e.cod_empresa inner join tb_usuario u on p.cod_solicitante = u.cod_usuario inner join tb_etapa et on p.cod_etapa = et.cod_etapa";
                $retorno = pg_query($sql);

                if (pg_num_rows($retorno) > 0) {

                    while ($dados = pg_fetch_array($retorno)) {
                        ?>
                        <tr>
                            <td><?php echo $dados['cod_pedido']; ?></td>
                            <td><?php echo $dados['primeiro_nome'] . ' ' . $dados['ultimo_nome']; ?></td>
                            <td><?php echo $dados['data_pedido']; ?></td>
                            <td><?php echo $dados['razao_social']; ?></td>
                            <td><?php echo $dados['vlr_total_pedido']; ?></td>
                            <td><?php echo $dados['cod_etapa']; ?></td>
                            <td><?php echo $dados['desc_etapa']; ?></td>
                            <td><a href="exibePedido.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>" target="_blank" class="btn-floating green"><i class="material-icons" title="Visualizar itens">view_list</i></a></td>
                            <td><a href="#modal<?php echo $dados['cod_pedido']; ?>" class="btn-floating red modal-trigger"><i class="material-icons" title="Cancelar pedido">cancel</i></a></td>

                    <div id="modal<?php echo $dados['cod_pedido']; ?>" class="modal">
                        <div class="modal-content">
                            <h4>Opa!</h4>
                            <p>Tem certeza que deseja cancelar este pedido?</p>
                        </div>
                        <div class="modal-footer">					     

                            <form action="crud/cancelaPedido.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>&cancela=true" method="POST" />
                                <input type="hidden" name="id" value="<?php echo $dados['cod_pedido']; ?>">
                                <button type="submit" name="btn-deletar" class="btn red">Sim, quero cancelar</button>

                                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>

                            </form>

                        </div>
                    </div>
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
        <a href="add_pedido.php?nro_pedido=<?php echo $nro_pedido; ?>" class="btn">Novo pedido</a> 
        <!--                <a href="add_pedido.php" class="btn">Novo pedido</a>-->
    </div>
</div>
<?php
// Rodapé
include_once 'bases/rodape.php';
?>
