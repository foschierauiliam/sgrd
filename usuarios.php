<?php
// Header
include_once 'bases/cabecalho.php';

if ($cod_perfil == 2 || $cod_perfil == 3 || $cod_perfil == 4) {
    $_SESSION['mensagem'] = "Você não possui permissão de acesso nesta página !";
    header('Location: home.php');
}
?>
<div class="row">
    <div class="col s12 m8 l12">
        <h3 class="light"> Usuários </h3>
        <form method="POST" action="">
            <div class="input-field col s4 l3">
                <select required name="select_login" id="select_login">
                    <option value="0">Todos</option>
                    <?php
                    if ($cod_perfil == 6) {
                        $sql = "select * from tb_usuario order by primeiro_nome";
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
            <div class="input-field col s4 l3">
                <select required name="centro_custo" id="centro_custo">
                    <option value="0">Todos</option>
                    <?php
                    $sql = "select * from tb_area_setor order by desc_area_setor";
                    $result_etapa = pg_query($conexao, $sql) or die("Não foi possível conectar-se ao banco de dados PostgreSQL. Erro: " . pg_last_error());
                    if ($result_etapa) {
                        while ($row = pg_fetch_array($result_etapa)) {
                            echo '<option value="' . $row["cod_area_setor"] . '">' . $row["desc_area_setor"] . '</option>';
                        }
                    }
                    ?>
                </select>
                <label for="centro_custo">Centro de Custo</label>
            </div>
            <div class="input-field col s4 l3">
                <select required name="status" id="status">
                    <option value="2">Todos</option>
                    <option value="1">Ativos</option>
                    <option value="0">Inativos</option>
                </select>
                <label for="status">Situação usuário</label>
            </div>            
            <div class="input-field col s12 l3">
                <input class="btn" type="submit" value="Filtrar" name="filtrar" />
                <a href=""><input class="btn" type="button" value="Todos" name="todos" /></a>
                <a href="add_usuario.php"><input class="btn" type="button" value="Novo" name="add" /></a>

            </div>
        </form>
        <div class="col s12 l12">
            <table class="striped">
                <thead>
                    <tr>
                        <th>Usuário:</th>
                        <th>Nome:</th>
                        <th>Centro de Custo:</th>
                        <th>Empresa:</th>
                        <th>Email:</th>
                        <th></th>
                        <th></th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $sql = "select * from tb_usuario u inner join tb_empresa e on u.cod_empresa = e.cod_empresa inner join tb_area_setor c on u.cod_area_setor = c.cod_area_setor";
                    if ($cod_perfil == 5) {
                        $sql .= " where e.cod_empresa = '$cod_empresa'";
                    }
                    if (isset($_POST["filtrar"])) {
                        $status = $_POST['status'];
                        $centro_custo = $_POST['centro_custo'];
                        $select_login = $_POST['select_login'];
                        if ($status == 0 || $status == 1) {
                            if ($cod_perfil != 6) {
                                $sql .= " AND u.status_usuario = '$status'";
                            } else {
                                $sql .= " where u.status_usuario = '$status'";
                            }
                        }
                        if ($select_login) {
                            $sql .= " AND u.cod_usuario = '$select_login'";
                        }
                        if ($centro_custo) {
                            if ($cod_perfil != 6) {
                                $sql .= " AND u.cod_area_setor = '$centro_custo'";
                            } else {
                                if (!$status || $select_login) {
                                    $sql .= " where u.cod_area_setor = '$centro_custo'";
                                } else {
                                    $sql .= " AND u.cod_area_setor = '$centro_custo'";
                                }
                            }
                        }
                    }
                    $sql .= " order by e.razao_social";
                    $retorno = pg_query($sql);

                    if (pg_num_rows($retorno) > 0) {

                        while ($dados = pg_fetch_array($retorno)) {
                            ?>
                            <tr>
                                <td><?php echo $dados['cod_usuario']; ?></td>
                                <td><?php echo $dados['primeiro_nome'] . ' ' . $dados['ultimo_nome']; ?></td>
                                <td><?php echo $dados['desc_area_setor']; ?></td>
                                <td><?php echo $dados['razao_social']; ?></td>
                                <td><?php echo $dados['email_usuario']; ?></td>
                                <?php if ($cod_perfil == 5 || $cod_perfil == 6) { ?>
                                    <td><a href="edit_usuario.php?cod_usuario=<?php echo $dados['cod_usuario']; ?>" class="btn-floating orange"><i class="material-icons">edit</i></a></td>
                                    <td><a href="#modal<?php echo $dados['cod_usuario']; ?>" class="btn-floating red modal-trigger"><i class="material-icons">delete</i></a></td>
                                <?php } ?>
                                <?php
                                $status = $dados['status_usuario'];
                                if ($status == 0) {
                                    $cor_status = "grey";
                                } else {
                                    $cor_status = "green";
                                }
                                ?>
                                <td><a href="crud/edit_status.php?cod_usuario=<?php echo $dados['cod_usuario']; ?>" class="btn-floating <?php echo $cor_status; ?> modal-trigger"><i class="material-icons">check</i></a></td>
                                <!-- Modal Structure -->
                        <div id="modal<?php echo $dados['cod_usuario']; ?>" class="modal">
                            <div class="modal-content">
                                <h4>Opa!</h4>
                                <p>Tem certeza que deseja excluir esse cliente?</p>
                            </div>
                            <div class="modal-footer">					     

                                <form action="crud/delete_user.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $dados['cod_usuario']; ?>">
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
// Rodapé
include_once 'bases/rodape.php';
?>