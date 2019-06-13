<?php
	// Conexão
	include_once 'conn.php';
	include_once 'bases/cabecalho.php';
	// Select
	if(isset($_GET['cod_usuario'])){
		$cod_usuario = pg_escape_string($_GET['cod_usuario']);
		$sql = "SELECT * FROM tb_usuario  u inner join tb_perfis p on u.cod_perfil = p.cod_perfil inner join tb_area_setor a on u.cod_area_setor = a.cod_area_setor inner join tb_empresa e on u.cod_empresa = e.cod_empresa WHERE U.cod_usuario = '$cod_usuario'";
		$resultado = pg_query($sql);
		$dados = pg_fetch_array($resultado);
	}
?>
<!-- Valida comparativo de senhas -->

<div class="row">
	<div class="col s12 m6 push-m3">
		<h3 class="light"> Editar Usuário </h3>
		<form action="crud/edit_user.php" method="POST">
			<input type="hidden" name="cod_usuario" value="<?php echo $dados['cod_usuario'];?>">
			<div class="input-field col s12">
				<input type="text" name="first_name" id="first_name" value="<?php echo $dados['primeiro_nome'];?>">
				<label for="first_name">Primeiro Nome</label>
			</div>

			<div class="input-field col s12">
				<input type="text" name="last_name" id="last_name" maxlength="25" value="<?php echo $dados['ultimo_nome'];?>">
				<label for="last_name">Último Nome</label>
			</div>
			<div class="input-field col s12">
				<select name="perfil" id="perfil">
	                <option value="<?php echo $dados['cod_perfil'] ?>"><?php echo $dados['desc_perfil']; ?></option>
                    <?php
                        $sql="select * from tb_perfis order by desc_perfil";
                        $result_perfis = pg_query($conexao,$sql) or die("Não foi possível conectar-se ao banco de dados PostgreSQL. Erro: ".pg_last_error());
                        if ($result_perfis){
                            while ($row = pg_fetch_array($result_perfis)) {
                                echo '<option value="'.$row["cod_perfil"].'">'.$row["desc_perfil"].'</option>';
                            }
                        }
                    ?>
                </select>
                <label for="perfil">Perfil</label>
			</div>
			<div class="input-field col s12">
				<select name="empresa" id="empresa">
                    <option value="<?php echo $dados['cod_empresa'];?>"><?php echo $dados['razao_social']; ?></option>
                    <?php
                        $sql="select * from tb_empresa order by razao_social";
                        $result_empresa = pg_query($conexao,$sql) or die("Não foi possível conectar-se ao banco de dados PostgreSQL. Erro: ".pg_last_error());
                        if ($result_empresa){
                            while ($row = pg_fetch_array($result_empresa)) {
                                echo '<option value="'.$row["cod_empresa"].'">'.$row["razao_social"].'</option>';
                            }
                        }
	                ?>
                </select>
				<label for="empresa">Empresa</label>
			</div>
			<div class="input-field col s12">
				<select name="cargo" id="cargo">
				    <option value="<?php echo $dados['cod_area_setor'];?>"><?php echo $dados['desc_area_setor']; ?></option>
			        <?php
			            $sql="select * from tb_area_setor order by desc_area_setor";
			            $result_area = pg_query($conexao,$sql) or die("Não foi possível conectar-se ao banco de dados PostgreSQL. Erro: ".pg_last_error());
			            if ($result_area){
			                while ($row = pg_fetch_array($result_area)) {
			                    echo '<option value="'.$row["cod_area_setor"].'">'.$row["desc_area_setor"].'</option>';
			                }
			            }
			        ?>
				</select>
				<label for="cargo">Centro de Custo</label>
			</div>
			<div class="input-field col s6">
				<input type="password" required name="senha" id="senha" class="validate">
				<label for="senha">Senha</label>
			</div>
			<div class="input-field col s6">
				<input type="password" required name="conf_senha" id="conf_senha" class="validate">
				<label id="lblConfSenha" for="conf_senha" data-error="Senha não confere" data-success="Senhas conferem">Confirme a senha</label>
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
				<input type="text" name="cpf" id="cpf" onkeydown="javascript: fMasc(this, mCPF);" value="<?php echo $dados['cpf_usuario'];?>">
				<label for="cpf">CPF</label>
			</div>
			<div class="input-field col s12">
				<input type="email" class="validate" name="email" id="email" value="<?php echo $dados['email_usuario'];?>">
				<label for="email">E-mail</label>
			</div>

			<button type="submit" name="btn-editar" class="btn"> Atualizar</button>
			<a href="usuarios.php" class="btn green"> Lista de clientes </a>
		</form>
		
	</div>
</div>

<?php
// Footer
include_once 'bases/rodape.php';
?>
