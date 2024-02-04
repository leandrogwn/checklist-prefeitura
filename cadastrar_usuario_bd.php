<?php
	$login = $_POST["login"];
	$senha = $_POST["senha"];
	
	
	if (isset($_POST["cad"])) {
    	$cad = 1;
	}else{
		$cad = 0;
	}
	if (isset($_POST["gerar"])) {
    	$gerar = 1;
	}else{
		$gerar = 0;
	}
	if (isset($_POST["responder"])) {
    	$responder = 1;
	}else{
		$responder = 0;
	}
	if (isset($_POST["relatorio"])) {
    	$relatorio = 1;
	}else{
		$relatorio = 0;
	}
	$nome = $_POST["nome"];

	
	include("conecta.php");
	
	$busca = mysql_query("SELECT login FROM cl_admin WHERE login = '$login' ") or die ("Não foi possivel buscar os nomes no Banco de Dados".mysql_error());
	$registro = mysql_num_rows($busca);
	if ($registro == 0){
		$insere = "INSERT INTO cl_admin(login, senha, cad_user, gerar, responder, relatorio, nome) VALUES ('$login','$senha','$cad','$gerar','$responder','$relatorio','$nome')";
	}else{
		?>
        <script type="text/javascript">
			alert ("Já existe um usuário com este nome no Banco de Dados. Especifique outro!");
				window.history.back();
			</script>
		<?php
	}
	//confirmar
	mysql_select_db($db, $con);
	$resultado = mysql_query($insere, $con) or die (mysql_error());
	if($resultado){
		?>
        	<script type="text/javascript">
				alert ("Usuário incluido com sucesso!");
				location.replace("cadastrar_usuario.php");
				
			</script>
		<?php
	}
	mysql_free_result($busca);
	mysql_close($con);
?>