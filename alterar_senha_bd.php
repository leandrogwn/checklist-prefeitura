<?php
	include ("conecta.php");
	
	$cod = $_GET['cod'];
	$sa = $_POST["senha_atual"];
	$ns = $_POST["repete_senha"];
	
	$busca = mysql_query("SELECT senha FROM cl_admin WHERE id_user = '$cod'") or die ("Não foi possível localizar o código desejado. ".mysql_error());
	
	$reg = mysql_fetch_assoc($busca);
	$senha_banco = $reg['senha'];
	
	if($sa == $senha_banco){
	
		$atualiza = ("UPDATE cl_admin SET senha = '$ns' WHERE id_user = '$cod' ");
		
		mysql_select_db($db, $con);
		$resultado = mysql_query($atualiza, $con) or die(mysql_error());
		if($resultado){
		echo '<script>
				alert ("Senha alterada com sucesso!");
				window.history.back(2);
			 </script>';
		}else{
		echo '<script>
				alert ("Não foi possível alterar a senha!");
				location.replace("alterar_senha.php");
			 </script>';
		}
		mysql_free_result($busca);
		mysql_close($con);
	}else{
		echo '<script>
				alert ("Sua senha atual não confere. Tente novamente!");
				location.replace("alterar_senha.php");
			 </script>';
	}
?>
