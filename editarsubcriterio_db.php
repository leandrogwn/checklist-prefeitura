<?php
	include ("conecta.php");
	$codsubcriterio = $_GET['codsubcriterio'];
	$nome_subcriterio = $_POST["nome_subcriterio"];
	$atualiza = ("UPDATE cl_sub_criterio SET descricao_criterio='$nome_subcriterio' WHERE cod_sub_criterio ='$codsubcriterio'");	
	mysql_select_db($db, $con);
    $result = mysql_query($atualiza, $con) or die(mysql_error());
		if($result){
			echo'<script type="text/javascript">
					location.replace ("checklist.php");
				</script>';
		}else{
			echo'<script type="text/javascript">
					alert ("Erro ao alterar o Sub-Critério no banco de dados");
					location. replace ("checklist.php");
				</script>';
			}
		mysql_close($sql);
?>