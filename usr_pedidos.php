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
    <div class="col s12 m8 l12">
        <h3 class="light"> Relatório de pedidos </h3>
        <form method="POST" action="">
            <?php if ($cod_perfil == 3 OR $cod_perfil == 4 OR $cod_perfil == 5 OR $cod_perfil == 6) { ?>
                <div class="input-field col s3">
                    <select required name="select_login" id="select_login">
                        <option value="0">Todos</option>
                        <?php
                        if ($cod_perfil == 3) {
                            $sql = "select * from tb_usuario where cod_empresa = '$cod_empresa' AND cod_area_setor = '$cod_area' order by primeiro_nome";
                        } else {
                            $sql = "select * from tb_usuario where cod_empresa = '$cod_empresa' order by primeiro_nome";
                        }
                        $result_usuario = pg_query($conexao, $sql) or die("Não foi possível conectar-se ao banco de dados PostgreSQL. Erro: " . pg_last_error());
                        if ($result_usuario) {
                            while ($row = pg_fetch_array($result_usuario)) {
                                echo '<option value="' . $row["cod_usuario"] . '">' . $row["primeiro_nome"] . ' ' . $row["ultimo_nome"] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <label for="select_login">Usuário</label>
                </div>

                <?php
            }
            ?>
            <div class="input-field col s4 l3">
                <input required type="date" name="periodo_inicial" id="periodo_inicial" >
                <label for="periodo_inicial">Início</label>
            </div>
            <div class="input-field col s4 l3">
                <input required type="date" name="periodo_final" id="periodo_final" >
                <label for="periodo_final">Final</label>
            </div>
            <div class="input-field col s4 l3">
                <select required name="etapas" id="etapas">
                    <option value="0">Todas</option>
                    <?php
                    $sql = "select * from tb_etapa order by desc_etapa";
                    $result_etapa = pg_query($conexao, $sql) or die("Não foi possível conectar-se ao banco de dados PostgreSQL. Erro: " . pg_last_error());
                    if ($result_etapa) {
                        while ($row = pg_fetch_array($result_etapa)) {
                            echo '<option value="' . $row["cod_etapa"] . '">' . $row["desc_etapa"] . '</option>';
                        }
                    }
                    ?>
                </select>
                <label for="etapas">Etapa</label>

            </div>
            <div class="input-field col s12 l3">
                <input class="btn" type="submit" value="Filtrar" name="filtrar" />
                <a href=""><input class="btn" type="button" value="Todos" name="todos" /></a>

            </div>
        </form>
        <div class="col s12 m6 l12">
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
                    if ($cod_perfil == 2) {
                        $select_login = NULL;
                        $sql .= " where cod_solicitante = '$usuario'";
                    }
                    if ($cod_perfil == 3) {
                        $sql .= " where p.cod_empresa = '$cod_empresa' AND u.cod_area_setor = '$cod_area'";
                    }
                    if ($cod_perfil == 4 OR $cod_perfil == 5) {
                        $sql .= " where p.cod_empresa = '$cod_empresa'";
                    }

                    if (isset($_POST["filtrar"])) {
                        $filtro_inicio = $_POST['periodo_inicial'];
                        $filtro_fim = $_POST['periodo_final'];
                        $filtro_etapa = $_POST['etapas'];
                        if ($cod_perfil != 2) {
                        $select_login = $_POST['select_login'];
                        }
                        if ($filtro_etapa) {
                            if ($cod_perfil != 6) {
                                $sql .= " AND p.cod_etapa = '$filtro_etapa' AND p.data_pedido between '$filtro_inicio' AND '$filtro_fim' ";
                            } else {
                                $sql .= " where p.cod_etapa = '$filtro_etapa' AND p.data_pedido between '$filtro_inicio' AND '$filtro_fim' ";
                            }
                        } else {
                            if ($cod_perfil != 6) {
                                $sql .= " AND p.data_pedido between '$filtro_inicio' AND '$filtro_fim' ";
                            } else {
                                $sql .= " where p.data_pedido between '$filtro_inicio' AND '$filtro_fim' ";
                            }
                        }
                        if ($select_login ) {
                            $sql .= " AND p.cod_solicitante = '$select_login'";
                        }
                    }
                    $retorno = pg_query($sql);
//                echo 'SQL ' . $sql;
                    if (pg_num_rows($retorno) > 0) {

                        while ($dados = pg_fetch_array($retorno)) {
                            ?>
                            <tr>
                                <td><?php echo $dados['cod_pedido']; ?></td>
                                <td><?php echo $dados['primeiro_nome'] . ' ' . $dados['ultimo_nome']; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($dados['data_pedido'])); ?></td>
                                <td><?php echo $dados['razao_social']; ?></td>
                                <td>R<?php echo str_replace('.',',',$dados['vlr_total_pedido']); ?></td>
                                <td><?php echo $dados['desc_etapa']; ?></td>
                                <td><a href="exibePedido.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>" target="_blank" class="btn-floating green"><i class="material-icons" title="Visualizar itens">view_list</i></a></td>

                            </tr>
                            <?php
                        };
                    } else {
                        $_SESSION['mensagem'] = "Nenhum resultado encontrado para os parâmetros informados!";
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
        </div>
        <br>
    </div>
</div>
<?php
// Rodapé
include_once 'bases/rodape.php';
?>
