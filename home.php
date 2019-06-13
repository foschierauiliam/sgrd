<?php
include_once 'bases/cabecalho.php';

if (!isset($_SESSION['logado'])) {

    header('Location: index.php');
}

$_SESSION['btn-additem-status'] = "";
$_SESSION['div-status'] = "hidden";

// ajuste da div de análise, caso o perfil seja de colaborador
if ($cod_perfil == 2) {
    $div_analise = "hidden";
    $div_meus_pedidos = 'class="col s12"';
} else {
    $div_analise = "";
    $div_meus_pedidos = 'class="col s12 l6"';
}
?>
<div class="row">
    <div class="col s12">
        <div <?php echo $div_meus_pedidos; ?>>
            <table class="col s12 l12">
                <tr>
                    <td><h5 class="light">Meus pedidos em aberto</h5></td>
                    <?php
                    $sql = "select sum (vlr_total_pedido) from tb_pedidos where cod_solicitante = '$usuario' AND (cod_etapa = 1 OR cod_etapa = 2 OR cod_etapa = 3)";
                    $result = pg_fetch_array(pg_query($sql));
                    if (is_null($result[0])) {
                        $total_pedidos = "$";
                        $total_pedidos .= 0.00;
                    } else {
                        $total_pedidos = $result[0];
                    }
                    ?>
                    <td class="right"><h5 class="light">Total: R<?php echo str_replace('.', ',', $total_pedidos); ?></h5></td>
                </tr>
            </table>
            <table class="striped col s12 l12">
                <thead>
                    <tr>
                        <th>Pedido nº</th>
                        <th>Valor</th>
                        <th>Status do pedido</th>
                        <th></th>
                        <th></th>

                    </tr>
                </thead>

                <tbody>
                    <?php
                    $sql = "select distinct on (p.cod_pedido) * from tb_pedidos p inner join tb_itens_pedido i on p.cod_pedido = i.cod_pedido inner join tb_empresa e on p.cod_empresa = e.cod_empresa inner join tb_usuario u on p.cod_solicitante = u.cod_usuario inner join tb_etapa et on p.cod_etapa = et.cod_etapa where (u.cod_usuario = '$usuario' AND (p.cod_etapa = 1 or p.cod_etapa = 2 or p.cod_etapa = 3))";
                    $retorno = pg_query($sql);

                    if (pg_num_rows($retorno) > 0) {

                        while ($dados = pg_fetch_array($retorno)) {
                            ?>
                            <tr>
                                <td><?php echo $dados['cod_pedido']; ?></td>
                                <td>R<?php echo str_replace('.', ',', $dados['vlr_total_pedido']); ?></td>
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
                    </tr>
                    <?php
                };
                ?>

                </tbody>
            </table>
            <br>
        </div>
        <div <?php echo $div_meus_pedidos; ?>>
            <table class="col s12 l12">
                <tr>
                    <td><h5 class="light">Meus pedidos pagos</h5></td>
                    <?php
                    $sql = "select sum (vlr_total_pedido) from tb_pedidos where cod_solicitante = '$usuario' AND cod_etapa = 4";
                    $result = pg_fetch_array(pg_query($sql));
                    if (is_null($result[0])) {
                        $total_pedidos = "$";
                        $total_pedidos .= 0.00;
                    } else {
                        $total_pedidos = $result[0];
                    }
                    ?>
                    <td class="right"><h5 class="light">Total: R<?php echo str_replace('.', ',', $total_pedidos); ?></h5></td>
                </tr>
            </table>

            <table class="striped col s12 l12">
                <thead>
                    <tr>
                        <th>Pedido nº</th>
                        <th>Valor total</th>
                        <th>Status do pedido</th>
                        <th></th>
                        <th></th>

                    </tr>
                </thead>

                <tbody>
                    <?php
                    $sql = "select distinct on (p.cod_pedido) * from tb_pedidos p inner join tb_itens_pedido i on p.cod_pedido = i.cod_pedido inner join tb_empresa e on p.cod_empresa = e.cod_empresa inner join tb_usuario u on p.cod_solicitante = u.cod_usuario inner join tb_etapa et on p.cod_etapa = et.cod_etapa where (u.cod_usuario = '$usuario' AND p.cod_etapa = 4)";
                    $retorno = pg_query($sql);

                    if (pg_num_rows($retorno) > 0) {

                        while ($dados = pg_fetch_array($retorno)) {
                            ?>
                            <tr>
                                <td><?php echo $dados['cod_pedido']; ?></td>
                                <td>R<?php echo str_replace('.', ',', $dados['vlr_total_pedido']); ?></td>
                                <td><?php echo $dados['desc_etapa']; ?></td>
                                <td><a href="exibePedido.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>" target="_blank" class="btn-floating green"><i class="material-icons" title="Visualizar itens">view_list</i></a></td>
                                <td></td>
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
                        </tr>
                        <?php
                    };
                    ?>

                </tbody>
            </table>
        </div>

        <!-- PEDIDOS EM ANÁLISE -->
        <div <?php echo $div_analise; ?> id="gestores">
            <table class="col s12 l12">
                <tr>
                    <td><h5 class="light">Aguardam sua análise</h5></td>
                    <?php
                    $gestor = pg_num_rows(pg_query("select * from tb_usuario where cod_empresa = '$cod_empresa' AND cod_perfil = 3"));
                    $financeiro = pg_num_rows(pg_query("select * from tb_usuario where cod_empresa = '$cod_empresa' AND cod_perfil = 4"));
                    $administrador = pg_num_rows(pg_query("select * from tb_usuario where cod_empresa = '$cod_empresa' AND cod_perfil = 5"));
                    $master = pg_num_rows(pg_query("select * from tb_usuario where cod_perfil = 6"));
                    $sql_analise = "select sum (vlr_total_pedido) from tb_pedidos where cod_solicitante = '$usuario' AND cod_etapa = 4";
                    if ($gestor == 0 && $financeiro == 0 && $administrador == 0) {
                        $sql_analise = "select sum (vlr_total_pedido) from tb_pedidos p where (p.cod_solicitante != '$usuario' AND (p.cod_etapa = 1 OR p.cod_etapa = 2 OR p.cod_etapa = 3))";
                    }  elseif ($cod_perfil == 3){
                           $sql_analise = "select sum (vlr_total_pedido) from tb_pedidos p inner join tb_usuario u on p.cod_solicitante = u.cod_usuario where (p.cod_solicitante != '$usuario' AND p.cod_etapa = 1 AND p.cod_empresa = $cod_empresa AND u.cod_area_setor = '$cod_area')";
                    }                    
                    else {
                        $sql_analise = "select sum (vlr_total_pedido) from tb_pedidos p where (p.cod_solicitante != '$usuario' AND (p.cod_etapa = 1 OR p.cod_etapa = 2 OR p.cod_etapa = 3) AND p.cod_empresa = $cod_empresa)";
                    }
                    $result_analise = pg_fetch_array(pg_query($sql_analise));
                    if (is_null($result_analise[0])) {
                        $total_pedidos_analise = "$";
                        $total_pedidos_analise .= 0.00;
                    } else {
                        $total_pedidos_analise = $result_analise[0];
                    }
                    ?>
                    <td class="right"><h5 class="light">Total: R<?php echo str_replace('.', ',', $total_pedidos_analise);?></h5></td>

                </tr>
            </table>


            <table class="striped col s12 l12">
                <thead>
                    <tr>
                        <th>Pedido nº</th>
                        <th>Solicitante</th>
                        <th>Área</th>
                        <th>Valor total</th>
                        <th>Status do pedido</th>
                        <th></th>
                        <th></th>

                    </tr>
                </thead>

                <tbody>

                    <?php
                    if ($gestor == 0 && $financeiro == 0 && $administrador == 0) {
                        $sql = "select distinct on (p.cod_pedido) * from tb_pedidos p inner join tb_itens_pedido i on p.cod_pedido = i.cod_pedido inner join tb_empresa e on p.cod_empresa = e.cod_empresa inner join tb_usuario u on p.cod_solicitante = u.cod_usuario inner join tb_etapa et on p.cod_etapa = et.cod_etapa where (p.cod_solicitante != '$usuario' AND (p.cod_etapa = 1 OR p.cod_etapa = 2 OR p.cod_etapa = 3))";
                    } else {
                        $sql = "select distinct on (p.cod_pedido) * from tb_pedidos p inner join tb_itens_pedido i on p.cod_pedido = i.cod_pedido inner join tb_empresa e on p.cod_empresa = e.cod_empresa inner join tb_usuario u on p.cod_solicitante = u.cod_usuario inner join tb_etapa et on p.cod_etapa = et.cod_etapa where (p.cod_solicitante != '$usuario' AND (p.cod_etapa = 1 OR p.cod_etapa = 2 OR p.cod_etapa = 3) AND u.cod_empresa = $cod_empresa)";
                    }
                    $retorno = pg_query($sql);
                    if (pg_num_rows($retorno) > 0) {

                        while ($dados = pg_fetch_array($retorno)) {

                            switch ($dados['cod_etapa']) {
                                case 1:
                                    if ($gestor > 0) {
                                        //    if ($gestor > 0 AND $cod_perfil != $dados['cod_perfil']) {    
                                        if (($cod_perfil == 3 && $cod_area == $dados['cod_area_setor']) or $cod_perfil == 4 or $cod_perfil == 5) {
                                            ?>    
                                            <tr>
                                                <td><?php echo $dados['cod_pedido']; ?></td>
                                                <td><?php echo $dados['cod_solicitante']; ?></td>
                                                <?php
                                                $sql = "select desc_area_setor from tb_area_setor where cod_area_setor = " . $dados['cod_area_setor'];
                                                $result = pg_fetch_array(pg_query($conexao, $sql));
                                                ?>
                                                <td><?php echo $result[0]; ?></td>
                                                <td>R<?php echo str_replace('.', ',', $dados['vlr_total_pedido']); ?></td>
                                                <td><?php echo $dados['desc_etapa']; ?></td>
                                                <td><a href="exibePedido.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>" target="_blank" class="btn-floating green"><i class="material-icons" title="Visualizar itens">view_list</i></a></td>
                                                <td><a href="crud/edit_analysis.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>&approved=true" class="btn-floating green"><i class="material-icons" title="Aprovar pedido">check</i></a></td>
                                                <td><a href="crud/edit_analysis.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>&unapproved=true" class="btn-floating red"><i class="material-icons" title="Reprovar pedido">clear</i></a></td>
                                            </tr>
                                            <?php
                                        }
                                        //} elseif ($financeiro > 0) {
                                    } elseif ($financeiro > 0 AND ( $dados['cod_perfil'] = 3 or $dados['cod_perfil'] = 4)) {
                                        if ($cod_perfil == 4) {
                                            ?>    
                                            <tr>
                                                <td><?php echo $dados['cod_pedido']; ?></td>
                                                <td><?php echo $dados['cod_solicitante']; ?></td>
                                                <?php
                                                $sql = "select desc_area_setor from tb_area_setor where cod_area_setor = " . $dados['cod_area_setor'];
                                                $result = pg_fetch_array(pg_query($conexao, $sql));
                                                ?>
                                                <td><?php echo $result[0]; ?></td>
                                                <td>R<?php echo str_replace('.', ',', $dados['vlr_total_pedido']); ?></td>
                                                <td><?php echo $dados['desc_etapa']; ?></td>
                                                <td><a href="exibePedido.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>" target="_blank" class="btn-floating green"><i class="material-icons" title="Visualizar itens">view_list</i></a></td>
                                                <td><a href="crud/edit_analysis.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>&approved=true" class="btn-floating green"><i class="material-icons" title="Aprovar pedido">check</i></a></td>
                                                <td><a href="crud/edit_analysis.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>&unapproved=true" class="btn-floating red"><i class="material-icons" title="Reprovar pedido">clear</i></a></td>
                                            </tr>
                                            <?php
                                        }
                                    } elseif ($administrador > 0 AND ( $dados['cod_perfil'] = 3 or $dados['cod_perfil'] = 4)) {
                                        if ($cod_perfil == 5) {
                                            ?>    
                                            <tr>
                                                <td><?php echo $dados['cod_pedido']; ?></td>
                                                <td><?php echo $dados['cod_solicitante']; ?></td>
                                                <?php
                                                $sql = "select desc_area_setor from tb_area_setor where cod_area_setor = " . $dados['cod_area_setor'];
                                                $result = pg_fetch_array(pg_query($conexao, $sql));
                                                ?>
                                                <td><?php echo $result[0]; ?></td>
                                                <td>R<?php echo str_replace('.', ',', $dados['vlr_total_pedido']); ?></td>
                                                <td><?php echo $dados['desc_etapa']; ?></td>
                                                <td><a href="exibePedido.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>" target="_blank" class="btn-floating green"><i class="material-icons" title="Visualizar itens">view_list</i></a></td>
                                                <td><a href="crud/edit_analysis.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>&approved=true" class="btn-floating green"><i class="material-icons" title="Aprovar pedido">check</i></a></td>
                                                <td><a href="crud/edit_analysis.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>&unapproved=true" class="btn-floating red"><i class="material-icons" title="Reprovar pedido">clear</i></a></td>
                                            </tr>
                                            <?php
                                        }
                                    } elseif ($master > 0) {
                                        if ($cod_perfil == 6) {
                                            ?>    
                                            <tr>
                                                <td><?php echo $dados['cod_pedido']; ?></td>
                                                <td><?php echo $dados['cod_solicitante']; ?></td>
                                                <?php
                                                $sql = "select desc_area_setor from tb_area_setor where cod_area_setor = " . $dados['cod_area_setor'];
                                                $result = pg_fetch_array(pg_query($conexao, $sql));
                                                ?>
                                                <td><?php echo $result[0]; ?></td>
                                                <td>R<?php echo str_replace('.', ',', $dados['vlr_total_pedido']); ?></td>
                                                <td><?php echo $dados['desc_etapa']; ?></td>
                                                <td><a href="exibePedido.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>" target="_blank" class="btn-floating green"><i class="material-icons" title="Visualizar itens">view_list</i></a></td>
                                                <td><a href="crud/edit_analysis.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>&approved=true" class="btn-floating green"><i class="material-icons" title="Aprovar pedido">check</i></a></td>
                                                <td><a href="crud/edit_analysis.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>&unapproved=true" class="btn-floating red"><i class="material-icons" title="Reprovar pedido">clear</i></a></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                        </tr>
                                        <?php
                                    }
                                    break;
                                case 2:
                                    if ($financeiro > 0) {
                                        if ($cod_perfil == 4 or $cod_perfil == 5) {
                                            ?>    
                                            <tr>
                                                <td><?php echo $dados['cod_pedido']; ?></td>
                                                <td><?php echo $dados['cod_solicitante']; ?></td>
                                                <?php
                                                $sql = "select desc_area_setor from tb_area_setor where cod_area_setor = " . $dados['cod_area_setor'];
                                                $result = pg_fetch_array(pg_query($conexao, $sql));
                                                ?>
                                                <td><?php echo $result[0]; ?></td>
                                                <td>R<?php echo str_replace('.', ',', $dados['vlr_total_pedido']); ?></td>
                                                <td><?php echo $dados['desc_etapa']; ?></td>
                                                <td><a href="exibePedido.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>" target="_blank" class="btn-floating green"><i class="material-icons" title="Visualizar itens">view_list</i></a></td>
                                                <td><a href="crud/edit_analysis.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>&approved=true" class="btn-floating green"><i class="material-icons" title="Aprovar pedido">check</i></a></td>
                                                <td><a href="crud/edit_analysis.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>&unapproved=true" class="btn-floating red"><i class="material-icons" title="Reprovar pedido">clear</i></a></td>
                                            </tr>
                                            <?php
                                        }
                                    } elseif ($administrador > 0) {
                                        if ($cod_perfil == 5) {
                                            ?>    
                                            <tr>
                                                <td><?php echo $dados['cod_pedido']; ?></td>
                                                <td><?php echo $dados['cod_solicitante']; ?></td>
                                                <?php
                                                $sql = "select desc_area_setor from tb_area_setor where cod_area_setor = " . $dados['cod_area_setor'];
                                                $result = pg_fetch_array(pg_query($conexao, $sql));
                                                ?>
                                                <td><?php echo $result[0]; ?></td>
                                                <td>R<?php echo str_replace('.', ',', $dados['vlr_total_pedido']); ?></td>
                                                <td><?php echo $dados['desc_etapa']; ?></td>
                                                <td><a href="exibePedido.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>" target="_blank" class="btn-floating green"><i class="material-icons" title="Visualizar itens">view_list</i></a></td>
                                                <td><a href="crud/edit_analysis.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>&approved=true" class="btn-floating green"><i class="material-icons" title="Aprovar pedido">check</i></a></td>
                                                <td><a href="crud/edit_analysis.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>&unapproved=true" class="btn-floating red"><i class="material-icons" title="Reprovar pedido">clear</i></a></td>
                                            </tr>
                                            <?php
                                        }
                                    } elseif ($master > 0) {
                                        if ($cod_perfil == 6) {
                                            ?>    
                                            <tr>
                                                <td><?php echo $dados['cod_pedido']; ?></td>
                                                <td><?php echo $dados['cod_solicitante']; ?></td>
                                                <?php
                                                $sql = "select desc_area_setor from tb_area_setor where cod_area_setor = " . $dados['cod_area_setor'];
                                                $result = pg_fetch_array(pg_query($conexao, $sql));
                                                ?>
                                                <td><?php echo $result[0]; ?></td>
                                                <td>R<?php echo str_replace('.', ',', $dados['vlr_total_pedido']); ?></td>
                                                <td><?php echo $dados['desc_etapa']; ?></td>
                                                <td><a href="exibePedido.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>" target="_blank" class="btn-floating green"><i class="material-icons" title="Visualizar itens">view_list</i></a></td>
                                                <td><a href="crud/edit_analysis.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>&approved=true" class="btn-floating green"><i class="material-icons" title="Aprovar pedido">check</i></a></td>
                                                <td><a href="crud/edit_analysis.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>&unapproved=true" class="btn-floating red"><i class="material-icons" title="Reprovar pedido">clear</i></a></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                        </tr>
                                        <?php
                                    }
                                    break;
                                case 3:
                                    if ($financeiro > 0) {
                                        if ($cod_perfil == 4 or $cod_perfil == 5) {
                                            ?>    
                                            <tr>
                                                <td><?php echo $dados['cod_pedido']; ?></td>
                                                <td><?php echo $dados['cod_solicitante']; ?></td>
                                                <?php
                                                $sql = "select desc_area_setor from tb_area_setor where cod_area_setor = " . $dados['cod_area_setor'];
                                                $result = pg_fetch_array(pg_query($conexao, $sql));
                                                ?>
                                                <td><?php echo $result[0]; ?></td>
                                                <td>R<?php echo str_replace('.', ',', $dados['vlr_total_pedido']); ?></td>
                                                <td><?php echo $dados['desc_etapa']; ?></td>
                                                <td><a href="exibePedido.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>" target="_blank" class="btn-floating green"><i class="material-icons" title="Visualizar itens">view_list</i></a></td>
                                                <td><a href="crud/edit_analysis.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>&approved=true" class="btn-floating green"><i class="material-icons" title="Aprovar pedido">check</i></a></td>
                                                <td><a href="crud/edit_analysis.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>&unapproved=true" class="btn-floating red"><i class="material-icons" title="Reprovar pedido">clear</i></a></td>
                                            </tr>
                                            <?php
                                        }
                                    } elseif ($administrador > 0) {
                                        if ($cod_perfil == 5) {
                                            ?>    
                                            <tr>
                                                <td><?php echo $dados['cod_pedido']; ?></td>
                                                <td><?php echo $dados['cod_solicitante']; ?></td>
                                                <?php
                                                $sql = "select desc_area_setor from tb_area_setor where cod_area_setor = " . $dados['cod_area_setor'];
                                                $result = pg_fetch_array(pg_query($conexao, $sql));
                                                ?>
                                                <td><?php echo $result[0]; ?></td>
                                                <td>R<?php echo str_replace('.', ',', $dados['vlr_total_pedido']); ?></td>
                                                <td><?php echo $dados['desc_etapa']; ?></td>
                                                <td><a href="exibePedido.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>" target="_blank" class="btn-floating green"><i class="material-icons" title="Visualizar itens">view_list</i></a></td>
                                                <td><a href="crud/edit_analysis.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>&approved=true" class="btn-floating green"><i class="material-icons" title="Aprovar pedido">check</i></a></td>
                                                <td><a href="crud/edit_analysis.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>&unapproved=true" class="btn-floating red"><i class="material-icons" title="Reprovar pedido">clear</i></a></td>
                                            </tr>
                                            <?php
                                        }
                                    } elseif ($master > 0) {
                                        if ($cod_perfil == 6) {
                                            ?>    
                                            <tr>
                                                <td><?php echo $dados['cod_pedido']; ?></td>
                                                <td><?php echo $dados['cod_solicitante']; ?></td>
                                                <?php
                                                $sql = "select desc_area_setor from tb_area_setor where cod_area_setor = " . $dados['cod_area_setor'];
                                                $result = pg_fetch_array(pg_query($conexao, $sql));
                                                ?>
                                                <td><?php echo $result[0]; ?></td>
                                                <td>R<?php echo str_replace('.', ',', $dados['vlr_total_pedido']); ?></td>
                                                <td><?php echo $dados['desc_etapa']; ?></td>
                                                <td><a href="exibePedido.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>" target="_blank" class="btn-floating green"><i class="material-icons" title="Visualizar itens">view_list</i></a></td>
                                                <td><a href="crud/edit_analysis.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>&approved=true" class="btn-floating green"><i class="material-icons" title="Aprovar pedido">check</i></a></td>
                                                <td><a href="crud/edit_analysis.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>&unapproved=true" class="btn-floating red"><i class="material-icons" title="Reprovar pedido">clear</i></a></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>    
                                        <tr>
                                            <td><?php echo $dados['cod_pedido']; ?></td>
                                            <td><?php echo $dados['cod_solicitante']; ?></td>
                                            <?php
                                            $sql = "select desc_area_setor from tb_area_setor where cod_area_setor = " . $dados['cod_area_setor'];
                                            $result = pg_fetch_array(pg_query($conexao, $sql));
                                            ?>
                                            <td><?php echo $result[0]; ?></td>
                                            <td>R<?php echo str_replace('.', ',', $dados['vlr_total_pedido']); ?></td>
                                            <td><?php echo $dados['desc_etapa']; ?></td>
                                            <td><a href="exibePedido.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>" target="_blank" class="btn-floating green"><i class="material-icons" title="Visualizar itens">view_list</i></a></td>
                                            <td><a href="crud/edit_analysis.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>&approved=true" class="btn-floating green"><i class="material-icons" title="Aprovar pedido">check</i></a></td>
                                            <td><a href="crud/edit_analysis.php?nro_pedido=<?php echo $dados['cod_pedido']; ?>&unapproved=true" class="btn-floating red"><i class="material-icons" title="Reprovar pedido">clear</i></a></td>

                                        </tr>
                                        <?php
                                    }
                                    break;
                                default:
                                    ?>
                                    <tr>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                    <?php
                                    break;
                            }
                        }
                    } else {
                        ?>
                        <tr>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <?php
                    }
                    ?>

                </tbody>
            </table>

        </div>


    </div>
</div>

<?php
include_once 'bases/rodape.php';
?>