<?php
	include ("conecta.php");
	$cod_rotina = $_GET["codrotina"];
	$del = mysql_query("DELETE FROM cl_rotina WHERE cod_rotina = '$cod_rotina'") or die ("Não foi possivel deletar a Rotina. ".mysql_error());	
	$busca = mysql_query("SELECT cod_rotina FROM cl_rotina WHERE cod_rotina = '$cod_rotina'");
	$result = mysql_num_rows($busca);
		if($result == 0){
			echo'<script type="text/javascript">
					alert ("A Rotina foi excluida da base de dados com sucesso.");
					location.replace ("checklist.php");
				</script>';
		}else{
			echo'<script type="text/javascript">
					alert ("Erro ao excluir a Rotina do banco de dados");
					location. replace ("checklist.php");
				</script>';
			}
		mysql_free_result($busca);
		mysql_close($con);
?>