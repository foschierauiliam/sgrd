<?php
	// Conexão
	include_once 'conn.php';
	include_once 'bases/cabecalho.php';
	// Select
	if(isset($_GET['cod_perfil'])){
		$cod_perfil = pg_escape_string($_GET['cod_perfil']);
		$sql = "SELECT * FROM tb_perfis WHERE cod_perfil = '$cod_perfil'";
		$resultado = pg_query($sql);
		$dados = pg_fetch_array($resultado);
	}
?>
<div class="row">
	<div class="col s12 m6 push-m3">
		<h3 class="light"> Editar Perfil </h3>
		<form action="crud/edit_profile.php" method="POST">
			<input type="hidden" name="cod_perfil" value="<?php echo $dados['cod_perfil'];?>">
			<div class="input-field col s12">
                            <input type="text" name="desc_perfil" id="first_name" value="<?php echo $dados['desc_perfil'];?>">
				<label for="desc_perfil">Nome do perfil</label>
			</div>
			<button type="submit" name="btn-editar" class="btn"> Atualizar</button>
			<a href="perfis.php" class="btn green"> Lista de perfis </a>
		</form>
		
	</div>
</div>

<?php
// Footer
include_once 'bases/rodape.php';
?>
