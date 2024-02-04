<?php
	error_reporting(0);
	include ("conecta.php");
	$cod_subcriterio = $_GET["delcodsubcriterio"];
	$del = mysql_query("DELETE FROM cl_sub_criterio WHERE cod_sub_criterio = '$cod_subcriterio'") or die ("Não foi possivel deletar sub-critério. ".mysql_error());	
	$busca = mysql_query("SELECT cod_sub_criterio FROM cl_subcriterio WHERE cod_sub_criterio = '$cod_subcriterio'");
	$result = mysql_num_rows($busca);
		if($result == 0){
			echo'<script type="text/javascript">
					alert ("O Sub-Critério foi excluido da base de dados com sucesso.");
					location.replace ("checklist.php");
				</script>';
		}else{
			echo'<script type="text/javascript">
					alert ("Erro ao excluir Sub-Critério do banco de dados");
					location. replace ("checklist.php");
				</script>';
			}
		mysql_free_result($busca);
		mysql_close($con);
?>