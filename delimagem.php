<?php
	include ("conecta.php");
	$cod_img = $_GET["apagar"];
	$del = mysql_query("DELETE FROM cl_img WHERE cod_img = '$cod_img'") or die ("Não foi possivel deletar a Imagem. ".mysql_error());	
	$busca = mysql_query("SELECT cod_img FROM cl_img WHERE cod_img = '$cod_img'");
	$result = mysql_num_rows($busca);
		if($result == 0){
			echo'<script type="text/javascript">
					window.opener = window
					window.close("#")
				</script>';
		}else{
			echo'<script type="text/javascript">
					alert ("Erro ao excluir a Imagem do banco de dados");
					history.back(-2);
				</script>';
			}
		mysql_free_result($busca);
		mysql_close($con);
?>