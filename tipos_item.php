<?php
// Conexão
include_once 'conn.php';
// Header
include_once 'bases/cabecalho.php';
?>
<div class="row">
    <div class="col s12 m8 push-m2">
        <h3 class="light"> Tipos de itens </h3>
        <table class="striped">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Descrição do item</th>
                    <th>Ações</th>

                    <th></th>
                </tr>
            </thead>


            <form method="POST" action="">
                <input type="hidden" name="id">
                <div class="input-field col s8">
                    <input type="text" name="tipo_item" placeholder="Tipo de item..." maxlength="20" />
                </div>
                <div class="input-field col s4">
                    <input class="btn" type="submit" value="Cadastrar" name="cadastrar" />
                </div>
            </form>

            <?php
            //Validando a existência dos dados
            if (isset($_POST["cadastrar"])) {
                $tipo = $_POST["tipo_item"];
                $sql = "insert into tb_tipo_item (tipo_item) values ('" . $tipo . "')";
                $resposta = pg_query($sql);
                if ($resposta) {
                    $_SESSION['mensagem'] = "Cadastrado com sucesso!";
                    header('Location: tipos_item.php');
                } else {
                    $_SESSION['mensagem'] = "Impossível cadastrar devido ao erro " . pg_last_error();
                    header('Location: tipos_item.php');
                }
            }
            if (isset($_REQUEST['act']) == 'del') {
                $id = $_REQUEST['id'];
                $sql = "delete from tb_tipo_item where cod_tipo_item = '$id'";
                $resposta = pg_query($sql);
                if ($resposta) {
                    $_SESSION['mensagem'] = "Removido com sucesso!";
                    header('Location: tipos_item.php');
                } else {
                    $_SESSION['mensagem'] = "Impossível remover devido ao erro " . pg_last_error();
                    header('Location: tipos_item.php');
                }
            }
            ?>
            <tbody>
                <?php
                $sql = "select * from tb_tipo_item";
                $retorno = pg_query($sql);
                if ($retorno) {
                    while ($row = pg_fetch_array($retorno)) {
                        echo '<tr><td>' . $row["cod_tipo_item"] . '</td>';
                        echo '<td>' . $row["tipo_item"] . '</td>';
                        echo '<td><a href="?act=del&id=' . $row["cod_tipo_item"] . '">Remover</td></tr>';
                    }
                }
                ?>
            </tbody>
        </table>
        <br>
    </div>
</div>

<?php
// Rodapé
include_once 'bases/rodape.php';
?>