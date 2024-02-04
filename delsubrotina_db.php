<?php
	include ("conecta.php");
	$cod_subrotina = $_GET["codsubrotina"];
	$del = mysql_query("DELETE FROM cl_sub_rotina WHERE cod_sub_rotina = '$cod_subrotina'") or die ("Não foi possivel deletar a Sub-Rotina. ".mysql_error());	
	$busca = mysql_query("SELECT cod_sub_rotina FROM cl_sub_rotina WHERE cod_sub_rotina = '$cod_subrotina'");
	$result = mysql_num_rows($busca);
		if($result == 0){
			echo'<script type="text/javascript">
					alert ("A Sub-Rotina foi excluida da base de dados com sucesso.");
					location.replace ("checklist.php");
				</script>';
		}else{
			echo'<script type="text/javascript">
					alert ("Erro ao excluir a Sub-Rotina do banco de dados");
					location. replace ("checklist.php");
				</script>';
			}
		mysql_free_result($busca);
		mysql_close($con);
?>