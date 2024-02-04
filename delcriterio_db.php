<?php
	include ("conecta.php");
	$cod_criterio = $_GET["delcodcriterio"];
	$del = mysql_query("DELETE FROM cl_criterio WHERE cod_criterio = '$cod_criterio'") or die ("Não foi possivel deletar Critério. ".mysql_error());	
	$busca = mysql_query("SELECT cod_criterio FROM cl_criterio WHERE cod_criterio = '$cod_criterio'");
	$result = mysql_num_rows($busca);
		if($result == 0){
			echo'<script type="text/javascript">
					alert ("O Critério foi excluido da base de dados com sucesso.");
					location.replace ("checklist.php");
				</script>';
		}else{
			echo'<script type="text/javascript">
					alert ("Erro ao excluir Critério do banco de dados");
					location. replace ("checklist.php");
				</script>';
			}
		mysql_free_result($busca);
		mysql_close($con);
?>