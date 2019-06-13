<?php
include_once 'conn.php';
include_once 'bases/cabecalho.php';
// Select
if (isset($_GET['cod_empresa'])) {
    $cod_empresa = pg_escape_string($_GET['cod_empresa']);
    $sql = "SELECT * FROM tb_empresa WHERE cod_empresa = '$cod_empresa'";
    $resultado = pg_query($sql);
    $dados = pg_fetch_array($resultado);
}
?>

<div class="row">
    <div class="col s12 m6 push-m3">
        <h3 class="light"> Editar Empresa </h3>
        <form action="crud/edit_company.php" method="POST">
            <input type="hidden" name="cod_empresa" value="<?php echo $dados['cod_empresa']; ?>">			
            <div class="input-field col s12">
                <input type="text" name="razao_social" id="razao_social" maxlength="45" value="<?php echo $dados['razao_social']; ?>">
                <label for="razao_social">Razão Social</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="fantasia" id="fantasia" maxlength="45" value="<?php echo $dados['nome_fantasia']; ?>">
                <label for="fantasia">Nome Fantasia</label>
            </div>
            <div class="input-field col s8">
                <input type="text" name="cnpj" id="cnpj" maxlength="18" value="<?php echo $dados['cnpj_empresa']; ?>">
                <label for="cnpj">CNPJ</label>
            </div>
            <div class="input-field col s4">
                <input type="text" name="inscr_estadual" id="inscr_estadual" maxlength="14" value="<?php echo $dados['inscr_estadual']; ?>">
                <label for="inscr_estadual">Inscr. Estadual</label>
            </div>
            <div class="input-field col s2">
                <input type="text" name="cep" id="cep" maxlength="9" value="<?php echo $dados['end_empresa_cep']; ?>">
                <label for="cep">CEP</label>
            </div>
            <div class="input-field col s5">
                <input type="text" name="uf" id="uf" maxlength="20" value="<?php echo $dados['end_empresa_uf']; ?>">
                <label for="uf">Estado</label>
            </div>
            <div class="input-field col s5">
                <input type="text" name="cidade" id="cidade" maxlength="45" value="<?php echo $dados['end_empresa_cidade']; ?>">
                <label for="cidade">Cidade</label>
            </div>
            <div class="input-field col s10">
                <input type="text" name="rua" id="rua" maxlength="20" value="<?php echo $dados['end_empresa_rua']; ?>">
                <label for="rua">Rua/Av...</label>
            </div>
            <div class="input-field col s2">
                <input type="text" name="nro" id="nro" maxlength="6" value="<?php echo $dados['end_empresa_nro']; ?>">
                <label for="nro">Número</label>
            </div>
            <div class="input-field col s6">
                <input type="text" name="complemento" id="complemento" maxlength="15" value="<?php echo $dados['end_empresa_complem']; ?>">
                <label for="complemento">Complemento</label>
            </div>
            <div class="input-field col s6">
                <input type="text" name="bairro" id="bairro" maxlength="15" value="<?php echo $dados['end_empresa_bairro']; ?>">
                <label for="bairro">Bairro</label>
            </div>
            <div class="input-field col s4">
                <input type="text" name="fone" id="fone" maxlength="14" value="<?php echo $dados['fone_empresa']; ?>">
                <label for="fone">Telefone principal</label>
            </div>
            <div class="input-field col s8">
                <input type="text" name="email" id="email" maxlength="50" value="<?php echo $dados['email_empresa']; ?>">
                <label for="email">E-mail</label>
            </div>
            <div class="input-field col s12">
                <textarea id="obs" name="obs" class="materialize-textarea" maxlength="255" rows="3"><?php echo $dados['obs']; ?></textarea>
                <label for="obs">Observações</label>
            </div>
            <button type="submit" name="btn-editar" class="btn"> Atualizar</button>
            <a href="empresas.php" class="btn green"> Lista de clientes </a>
        </form>

    </div>
</div>

<?php
// Footer
include_once 'bases/rodape.php';
?>
