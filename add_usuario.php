<?php
include_once 'bases/cabecalho.php';
?>
<div class="row">
    <div class="col s12 m6 push-m3">
        <h3 class="light"> Novo Usuário </h3>
        <form action="crud/create_user.php" method="POST" name="createuser">
            <div class="input-field col s12">
                <input type="text" name="first_name" id="first_name">
                <label for="first_name">Primeiro Nome</label>
            </div>

            <div class="input-field col s12">
                <input type="text" name="last_name" id="last_name" maxlength="25">
                <label for="last_name">Último Nome</label>
            </div>
            <div class="input-field col s12">
                <select name="perfil" id="perfil">
                    <option value="" name="">--Selecione o perfil--</option>
                    <?php
                    $sql = "select * from tb_perfis";
                    if ($cod_perfil != 6) {
                        $sql .= " where cod_perfil != 6";
                    }
                    $sql .= " order by desc_perfil";
                    $result_perfis = pg_query($conexao, $sql) or die("Não foi possível conectar-se ao banco de dados PostgreSQL. Erro: " . pg_last_error());
                    if ($result_perfis) {
                        while ($row = pg_fetch_array($result_perfis)) {
                            echo '<option value="' . $row["cod_perfil"] . '">' . $row["desc_perfil"] . '</option>';
                        }
                    }
                    ?>
                </select>
                <label for="perfil">Perfil</label>
            </div>
            <div class="input-field col s12">
                <?php if ($cod_perfil == 6) { ?>
                    <select name="empresa" id="empresa">
                        <option value="" name="">--Selecione a empresa--</option>
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
                <?php } else {
                    ?>
                    <input type="hidden" name="empresa" id="empresa" value="<?php echo $cod_empresa; ?>">
                    <input type="text" disabled name="razao_social" id="razao_social" value="<?php echo $empresa; ?>">
                    <label for="razao_social">Empresa</label>
                <?php } ?>
            </div>
            <div class="input-field col s12">
                <select name="cargo" id="cargo">
                    <option value="" name="">--Selecione a área/cargo--</option>
                    <?php
                    $sql = "select * from tb_area_setor order by desc_area_setor";
                    $result_area = pg_query($conexao, $sql) or die("Não foi possível conectar-se ao banco de dados PostgreSQL. Erro: " . pg_last_error());
                    if ($result_area) {
                        while ($row = pg_fetch_array($result_area)) {
                            echo '<option value="' . $row["cod_area_setor"] . '">' . $row["desc_area_setor"] . '</option>';
                        }
                    }
                    ?>
                </select>
                <label for="cargo">Centro de Custo</label>
            </div>
            <div class="input-field col s12">
                <input type="password" name="senha" id="senha">
                <label for="senha">Senha</label>
            </div>
            <div class="input-field col s12">
                <input type="password" name="conf_senha" id="conf_senha">
                <label for="conf_senha">Confirme a senha</label>
            </div>
            <div class="input-field col s12">
                <script type="text/javascript">
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
                    function mCPF(cpf) {
                        cpf = cpf.replace(/\D/g, "")
                        cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2")
                        cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2")
                        cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2")
                        return cpf
                    }
                </script>
                <input type="text" name="cpf" onkeydown="javascript: fMasc(this, mCPF);" id="cpf" maxlength="14" >
                <label for="cpf">CPF</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="email" id="email">
                <label for="email">E-mail</label>
            </div>
            <button type="submit" name="btn-cadastrar" class="btn"> Cadastrar </button>
            <a href="usuarios.php" class="btn green"> Lista de usuários </a>
        </form>

    </div>
</div>
<?php
include_once 'bases/rodape.php';
?>