<?php
include_once 'bases/cabecalho.php';
if (isset($_REQUEST['nro_pedido'])) {
    $nro_pedido = $_REQUEST['nro_pedido'];
} elseif (isset($_REQUEST['nro_pedido']) == NULL) {
    $_SESSION['mensagem'] = "Número de pedido inválido.";
    header('Location: pedidos.php');
} else {
    $_SESSION['mensagem'] = "Nenhum pedido selecionado.";
    header('Location: pedidos.php');
}
?> 

<div class="row">
    <div class="col s12 m6 push-m3">
        <div align="right"></div>
        <?php
        $sql = "select distinct on (p.cod_pedido) * from tb_pedidos p inner join tb_itens_pedido i on p.cod_pedido = i.cod_pedido inner join tb_empresa e on p.cod_empresa = e.cod_empresa inner join tb_usuario u on p.cod_solicitante = u.cod_usuario inner join tb_etapa et on p.cod_etapa = et.cod_etapa where p.cod_pedido = '$nro_pedido'";
        $result = pg_fetch_array(pg_query($sql));
        ?>
        <p><h4 class="light"> Informações do pedido <a href="javascript:window.open('','_self').close();" class="right"><i class="material-icons" title="Fechar">highlight_off</i></a></h4></p>

        <div class="input-field col s12">
            <input readonly type="text" name="cod_empresa" id="cod_empresa" value="<?php echo $result['razao_social']; ?>">
            <label for="cod_empresa">Empresa</label>
        </div>

        <div class="input-field col s12">
            <input readonly type="text" name="cod_solicitante" id="cod_solicitante" value="<?php echo $result['cod_usuario'] . ' - ' . $result['primeiro_nome'] . ' ' . $result['ultimo_nome']; ?>">
            <label for="cod_solicitante">Solicitante</label>
        </div>

        <div class="input-field col s12">
            <input readonly type="text" name="data_solicitacao" id="data_solicitacao" value="<?php echo date('d/m/Y', strtotime($result['data_pedido'])); ?>">
            <label for="data_solicitacao">Data da solicitação</label>
        </div>

        <div class="input-field col s6">
            <input readonly type="date" name="periodo_ini_pedido" id="periodo_ini_pedido" value="<?php echo $result['periodo_ini_pedido']; ?>">
            <label for="periodo_ini_pedido">De</label>
        </div>
        <div class="input-field col s6">
            <input readonly type="date" name="periodo_fim_pedido" id="periodo_fim_pedido" value="<?php echo $result['periodo_fim_pedido']; ?>">
            <label for="periodo_fim_pedido">Até</label>
        </div>
        <div class="input-field col s12">
            <textarea readonly id="justif_pedido" name="justif_pedido" class="materialize-textarea"><?php echo $result['justif_pedido']; ?></textarea>
            <label for="justif_pedido">Justificativa</label>
        </div>
        <div class="input-field col s6">
            <input readonly type="text" name="destino_pedido" id="destino_pedido" value="<?php echo $result['destino_pedido']; ?>">
            <label for="destino_pedido">Destino</label>
        </div>
        <div class="input-field col s6">
            <input readonly type="text" name="vlr_total_pedido" id="vlr_total_pedido" value="R<?php echo str_replace('.', ',', $result['vlr_total_pedido']); ?>">
            <label for="vlr_total_pedido">Valor total do pedido</label>
        </div>
        <div class="input-field col s12">
            <input readonly type="text" name="status" id="status" value="<?php echo $result['desc_etapa']; ?>">
            <label for="status">Status</label>
        </div>

        <h4 class="light"> Itens </h4>
        <table class="striped">
            <thead>
                <tr>
                    <th>Data da Despesa</th>
                    <th>Tipo</th>
                    <th>Valor</th>
                    <th>Descrição</th>
                    <th>Comprovante</th>

                </tr>
            </thead>

            <tbody>
                <?php
                $sql = "select * from tb_itens_pedido i inner join tb_tipo_item t on i.cod_tipo_item = t.cod_tipo_item where cod_pedido = $nro_pedido";
                $retorno = pg_query($sql);

                if (pg_num_rows($retorno) > 0) {

                    while ($dados = pg_fetch_array($retorno)) {
                        ?>
                        <tr>
                            <td><?php echo date('d/m/Y', strtotime($dados['data_despesa'])); ?></td>
                            <td><?php echo $dados['tipo_item']; ?></td>
                            <td>R$ <?php echo str_replace('.', ',', $dados['valor_item']); ?></td>
                            <td><?php echo $dados['obs_item']; ?></td>

                            <td><a href="upload/<?php echo $dados['comprovante_item']; ?>" target="_blank" class="btn-floating red modal-trigger"><i class="material-icons center">crop_original</i></a></td>
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
                        <td>-</td>
                    </tr>

                    <?php
                };
                ?>

            </tbody>
        </table>
    </div>
</div>
<?php
include_once 'bases/rodape.php';
?>