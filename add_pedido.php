<?php
include_once 'bases/cabecalho.php';
$usuario = $_SESSION['cod_usuario'];
$nome = $_SESSION['nome'];
$cod_perfil = $_SESSION['cod_perfil'];
$perfil = $_SESSION['perfil'];
$cod_empresa = $_SESSION['cod_empresa'];
$empresa = $_SESSION['empresa'];
$cod_area = $_SESSION['cod_centro_custo'];
$area = $_SESSION['centro_custo'];


if (isset($_REQUEST['nro_pedido'])) {
    $nro_pedido = $_REQUEST['nro_pedido'];
} else {
    $nro_pedido = date('YmdHis') . mt_rand(1000, 9999);
}
$_SESSION['nro_pedido'] = $nro_pedido;
$sql_pedido = "select * from tb_pedidos where cod_pedido = $nro_pedido";
$result = pg_query($sql_pedido);
$retorno_pedido = pg_fetch_array($result);

if (pg_num_rows($result) > 0) {
    $editavel = "disabled";
    $inicio = $retorno_pedido["periodo_ini_pedido"];
    $fim = $retorno_pedido["periodo_fim_pedido"];
    $obs = $retorno_pedido["justif_pedido"];
    $destino = $retorno_pedido["destino_pedido"];
    $sql_vlr_total = "select sum (valor_item) from tb_itens_pedido where cod_pedido = '$nro_pedido'";
    $result_vlr_total = pg_fetch_array(pg_query($sql_vlr_total));
    $vlr_total = $result_vlr_total[0];
    $cod_empresa = $retorno_pedido['cod_empresa'];
    $sql_empresa = "select razao_social from tb_empresa where cod_empresa = '$cod_empresa'";
    $result_empresa = pg_fetch_array(pg_query($sql_empresa));
    $razao_social = $result_empresa['razao_social'];
} else {
    $editavel = "";
    $inicio = "";
    $fim = "";
    $obs = "";
    $destino = "";
    $vlr_total = 0;
    $sql_empresa = "select razao_social from tb_empresa where cod_empresa = '$cod_empresa'";
    $result_empresa = pg_fetch_array(pg_query($sql_empresa));
    $razao_social = $result_empresa['razao_social'];
}
?>
<div class="row">
    <div class="col s10 m6 l12 push-m3">
        <h3 class="light"> Novo Pedido </h3>
        <form name="cadastra_pedido" id="cadastra_pedido" action="crud/rascunhoTicket.php?nro_pedido=<?php echo $nro_pedido; ?>" method="POST">

            <div class="input-field col s12">
                <select disabled name="empresa" id="empresa">
                    <option value="<?php echo $cod_empresa; ?>" name=""><?php echo $razao_social; ?></option>
                    <?php
                    $sql = "select * from tb_empresa order by razao_social";
                    $result_empresa = pg_query($conexao, $sql) or die("Não foi possível conectar-se ao banco de dados PostgreSQL. Erro: " . pg_last_error());
                    if ($result_empresa) {
                        while ($row = pg_fetch_array($result_empresa)) {
                            echo '<option value="' . $row["cod_empresa"] . '">' . $row["razao_social"] . '</option>';
                        }
                    }
                    ?>
                </select>
                <label for="empresa">Empresa</label>
            </div>
            <div class="input-field col s6">
                <input <?php echo $editavel; ?> required type="date" name="periodo_ini_pedido" id="periodo_ini_pedido" value="<?php echo $inicio; ?>">
                <label for="periodo_ini_pedido">Período inicial</label>
            </div>
            <div class="input-field col s6">
                <input <?php echo $editavel; ?> required type="date" name="periodo_fim_pedido" id="periodo_fim_pedido" value="<?php echo $fim; ?>">
                <label for="periodo_fim_pedido">Período final</label>
            </div>
            <div class="input-field col s12">
                <textarea <?php echo $editavel; ?> required id="justif_pedido" name="justif_pedido" class="materialize-textarea" maxlength="255"><?php echo $obs; ?></textarea>
                <label for="justif_pedido">Justificativa</label>
            </div>
            <div class="input-field col s6">
                <input <?php echo $editavel; ?> required maxlength="15" type="text" name="destino_pedido" id="destino_pedido" value="<?php echo $destino; ?>">
                <label for="destino_pedido">Destino (cidade/estado)...</label>
            </div>
            <div class="input-field col s6">
                <input readonly type="text" name="vlr_total_pedido" id="vlr_total_pedido" value="<?php echo $vlr_total; ?>">
                <label for="vlr_total_pedido">Valor total</label>
                <?php $_SESSION['vlr_total_pedido'] = $vlr_total; ?>
            </div> 
            <?php
            if (isset($_SESSION['btn-additem-status'])) {
                $btn_status = $_SESSION['btn-additem-status'];
            } else {
                $btn_status = "";
            }
            if (isset($_SESSION['div-status'])) {
                $div_status = $_SESSION['div-status'];
            } else {
                $div_status = "";
            }
            ?>
            <button type="submit" class="btn-floating green modal-trigger" name="btn-additem" id="btn-additem" <?php echo $btn_status; ?>><i class="material-icons">add</i></button>

            <label for="btn-additem">Adicionar itens</label>

        </form>   
        <br>
        <div <?php echo $div_status; ?> >
            <form action="crud/add_item.php?nro_pedido=<?php echo $nro_pedido; ?>" method="POST" enctype="multipart/form-data"> 
                <input type="hidden" id="nro_pedido" name="nro_pedido" value="<?php echo $nro_pedido; ?>">
                <div class="input-field col s6 m7 l2">
                    <input type="date" name="data_despesa" id="data_despesa" required>
                    <label for="data_despesa">Data</label>
                </div>
                <div class="input-field col s12 l2">
                    <select required name="tipo_despesa" id="tipo_despesa">
                        <option value="<?php echo $_SESSION['tipo_despesa']; ?>">--Selecione--</option>
                        <?php
                        $sql = "select * from tb_tipo_item order by tipo_item";
                        $result_item = pg_query($conexao, $sql) or die("Não foi possível conectar-se ao banco de dados PostgreSQL. Erro: " . pg_last_error());
                        if ($result_item) {
                            while ($row = pg_fetch_array($result_item)) {
                                echo '<option value="' . $row["cod_tipo_item"] . '">' . $row["tipo_item"] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <label for="tipo_despesa">Tipo</label>
                </div>
                <div class="input-field col s4 l2">
                    <input type="number" min="0.00" step="0.01" name="valor_despesa" id="valor_despesa" required>
                    <label for="valor_despesa">Valor</label>
                </div>
                <div class="input-field col s8 l6">
                    <input type="text" name="descr_despesa" id="descr_despesa" required>
                    <label for="descr_despesa">Descrição</label>
                </div>
                <div class="file-field input-field col s10 l10">
                    <div class="btn">
                        <script>
                            function validaArquivo() {
                                var fileInput = document.getElementById('compr_despesa');
                                var filePath = fileInput.value;
                                var allowedExtensions = /(\.jpg|\.jpeg|\.pdf|\.png|\.gif)$/i;
                                if (!allowedExtensions.exec(filePath)) {
                                    alert('Formatos de arquivo suportados: .png .jpeg .jpg .png .gif .pdf  .tiff !!!');
                                    fileInput.value = '';
                                    return false;
                                }
                                else
                                {
                                    return true;
                                }
                            }
                        </script>
                        <span><i class="material-icons" title="Anexar comprovante de despesa">file_upload</i></span>
                        <input type="file" name="compr_despesa" onchange="return validaArquivo()" id="compr_despesa" required validate accept=".png, .jpg, .gif, .jpeg, .pdf, .tiff">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text"  placeholder="Anexar comprovante de despesa">
                    </div>
                </div>
                <div class="col s2 l2">
                    <button type="submit" class="btn-floating green modal-trigger"><i class="material-icons" title="Adicionar item">done</i></button>
                    <label for="btn-cadastrar">Inserir item</label>
                </div>
            </form>
            <br>

            <!-- Listagem dos itens sendo inclusos-->
            <br><br>
            <div class="col s12 l4">
                <a href="crud/createTicket.php?nro_pedido=<?php echo $nro_pedido; ?>&createticket=true" class="btn" title="Confirmar pedido"> Cadastrar pedido </a>
                <a href="crud/limpaPedidovazio.php" class="btn red" title="Cancelar pedido">  Cancelar pedido  </a>
            </div>
            <br />
            <div class="col s12">
                <h4 class="light"> Itens adicionados </h4>
            </div>
            <table class="striped">
                <thead>
                    <tr>
                        <th>Pedido</th>
                        <th>Data da Despesa</th>
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th>Descrição</th>
                        <th>Comprovante</th>
                        <th></th>
                        <th></th>
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
                                <td><?php echo $dados['cod_pedido']; ?></td>
                                <td><?php echo $dados['data_despesa']; ?></td>
                                <td><?php echo $dados['tipo_item']; ?></td>
                                <td>R$ <?php echo str_replace('.',',',$dados['valor_item']); ?></td>
                                <td><?php echo $dados['obs_item']; ?></td>
                                <td><?php echo $dados['comprovante_item']; ?></td>
                                <td><?php // echo $dados['comprovante_item'];                                 ?></td>
                                <td><a href="#modal<?php echo $dados['cod_item_pedido']; ?>" class="btn-floating red modal-trigger"><i class="material-icons">delete</i></a></td>

                                <!-- Modal Structure -->
                        <div id="modal<?php echo $dados['cod_item_pedido']; ?>" class="modal">
                            <div class="modal-content">
                                <h4>Opa!</h4>
                                <p>Tem certeza que deseja excluir esse item?</p>
                            </div>
                            <div class="modal-footer">					     

                                <form action="crud/delete_item.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $dados['cod_item_pedido']; ?>">
                                    <button type="submit" name="btn-deletar" class="btn red">Sim, quero deletar</button>

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
                        <td>-</td>
                    </tr>

                    <?php
                };
                ?>

                </tbody>
            </table>
        </div>
        <br>
    </div>
</div>
<?php
include_once 'bases/rodape.php';
?>