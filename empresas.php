<?php
// Conexão
include_once 'conn.php';
// Header
include_once 'bases/cabecalho.php';
// Sessão / Mensagem
include_once 'bases/mensagem.php';
?>
<div class="row">
    <div class="col s12 m8 l12">
        <h3 class="light"> Empresas </h3>
        <table class="striped">
            <thead>
                <tr>
                    <th>Razão Social:</th>
                    <th>CNPJ:</th>
                    <th>Cidade:</th>
                    <th>Estado:</th>
                    <th>Telefone:</th>
                    <th>E-mail</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "select * from tb_empresa order by razao_social";
                $retorno = pg_query($sql);


                if (pg_num_rows($retorno) > 0) {

                    while ($dados = pg_fetch_array($retorno)) {
                        ?>
                        <tr>
                            <td><?php echo $dados['razao_social']; ?></td>
                            <td><?php echo $dados['cnpj_empresa']; ?></td>
                            <td><?php echo $dados['end_empresa_cidade']; ?></td>
                            <td><?php echo $dados['end_empresa_uf']; ?></td>
                            <td><?php echo $dados['fone_empresa']; ?></td>
                            <td><?php echo $dados['email_empresa']; ?></td>
                            <td><a href="edit_empresa.php?cod_empresa=<?php echo $dados['cod_empresa']; ?>" class="btn-floating orange"><i class="material-icons">edit</i></a></td>
                            <td><a href="#modal<?php echo $dados['cod_empresa']; ?>" class="btn-floating red modal-trigger"><i class="material-icons">delete</i></a></td>


                            <!-- Modal Structure -->
                    <div id="modal<?php echo $dados['cod_empresa']; ?>" class="modal">
                        <div class="modal-content">
                            <h4>Opa!</h4>
                            <p>Tem certeza que deseja excluir esta empresa? Os usuários vinculados à ela também serão excluídos.</p>
                        </div>
                        <div class="modal-footer">					     

                            <form action="crud/delete_company.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $dados['cod_empresa']; ?>">
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
        <br>
        <a href="add_empresa.php" class="btn">Adicionar empresa</a>
    </div>
</div>
<?php
// Rodapé
include_once 'bases/rodape.php';
?>
