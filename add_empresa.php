<?php
include_once 'bases/cabecalho.php';
include_once 'conn.php';
?>
<div class="row">
    <div class="col s12 m6 push-m3">
        <h3 class="light"> Nova Empresa </h3>
        <form action="crud/create_company.php" method="POST">
            <div class="input-field col s12">
                <input type="text" name="razao_social" id="razao_social" maxlength="45">
                <label for="razao_social">Razão Social</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="fantasia" id="fantasia" maxlength="45">
                <label for="fantasia">Nome Fantasia</label>
            </div>
            <div class="input-field col s8">
                <script>
                    function fMasc(objeto, mascara) {
                        obj = objeto
                        masc = mascara
                        setTimeout("fMascEx()", 1)
                    }
                    function fMascEx() {
                        obj.value = masc(obj.value)
                    }
                    function mCNPJ(cnpj) {
                        cnpj = cnpj.replace(/\D/g, "")
                        cnpj = cnpj.replace(/^(\d{2})(\d)/, "$1.$2")
                        cnpj = cnpj.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3")
                        cnpj = cnpj.replace(/\.(\d{3})(\d)/, ".$1/$2")
                        cnpj = cnpj.replace(/(\d{4})(\d)/, "$1-$2")
                        return cnpj
                    }
                </script>
                <input type="text" name="cnpj" id="cnpj" onkeydown="javascript: fMasc(this, mCNPJ);" maxlength="18">
                <label for="cnpj">CNPJ</label>
            </div>
            <div class="input-field col s4">
                <input type="text" name="inscr_estadual" id="inscr_estadual" maxlength="14">
                <label for="inscr_estadual">Inscr. Estadual</label>
            </div>
            <div class="input-field col s2">
                <input type="text" name="cep" id="cep" maxlength="9">
                <label for="cep">CEP</label>
            </div>
            <div class="input-field col s5">
                <select required name="uf" id="uf">
                    <option value="" name="">--Selecione o estado--</option>
                    <?php
                    $sql = "select * from tb_uf order by uf_ext";
                    $result_uf = pg_query($conexao, $sql) or die("Não foi possível conectar-se ao banco de dados PostgreSQL. Erro: " . pg_last_error());
                    if ($result_uf) {
                        while ($row = pg_fetch_array($result_uf)) {
                            echo '<option value="' . $row["uf_ext"] . '">' . $row["uf_ext"] . '</option>';
                        }
                    }
                    ?>
                </select>

<!--                <input type="text" name="uf" id="uf" maxlength="20"> -->
                <label for="uf">Estado</label>
            </div>
            <div class="input-field col s5">
                <input type="text" name="cidade" id="cidade" maxlength="45">
                <label for="cidade">Cidade</label>
            </div>
            <div class="input-field col s10">
                <input type="text" name="rua" id="rua" maxlength="20">
                <label for="rua">Rua/Av...</label>
            </div>
            <div class="input-field col s2">
                <input type="text" name="nro" id="nro" maxlength="6">
                <label for="nro">Número</label>
            </div>
            <div class="input-field col s6">
                <input type="text" name="complemento" id="complemento" maxlength="15">
                <label for="complemento">Complemento</label>
            </div>
            <div class="input-field col s6">
                <input type="text" name="bairro" id="bairro" maxlength="15">
                <label for="bairro">Bairro</label>
            </div>
            <div class="input-field col s4">
                <input type="text" name="fone" id="fone" maxlength="14">
                <label for="fone">Telefone principal</label>
            </div>
            <div class="input-field col s8">
                <input type="text" name="email" id="email" maxlength="50">
                <label for="email">E-mail</label>
            </div>
            <div class="input-field col s12">
                <textarea id="obs" name="obs" class="materialize-textarea" maxlength="255"></textarea>
                <label for="obs">Observações</label>
            </div>
            <button type="submit" name="btn-cadastrar" class="btn"> Cadastrar </button>
            <a href="empresas.php" class="btn green"> Lista de empresas </a>
        </form>

    </div>
</div>
<?php
include_once 'bases/rodape.php';
?>