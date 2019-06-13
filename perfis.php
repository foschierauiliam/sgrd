<?php
// Conexão
include_once 'conn.php';
// Header
include_once 'bases/cabecalho.php';
// Sessão / Mensagem
include_once 'bases/mensagem.php';
?>
<div class="row">
    <div class="col s12 m8 push-m2">
        <h3 class="light"> Perfis </h3>
        <table class="striped">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Perfil</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php
                $sql = "select * from tb_perfis order by cod_perfil";
                $retorno = pg_query($sql);
                if (pg_num_rows($retorno) > 0) {
                    while ($dados = pg_fetch_array($retorno)) {
                        ?>
                        <tr>
                            <td><?php echo $dados['cod_perfil']; ?></td>
                            <td><?php echo $dados['desc_perfil']; ?></td>
                            <td><a href="edit_perfil.php?cod_perfil=<?php echo $dados['cod_perfil']; ?>" class="btn-floating orange"><i class="material-icons">edit</i></a></td>
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
        <br>
    </div>
</div>

<?php
// Rodapé
include_once 'bases/rodape.php';
?>
