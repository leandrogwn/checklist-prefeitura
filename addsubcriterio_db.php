<?php
	include ("conecta.php");
	$cod_criterio = $_GET["cod_criterio"];
	$nome_subcriterio = $_POST["nome_subcriterio"];
	
	$sql = "INSERT INTO cl_sub_criterio (fk_cod_criterio, descricao_criterio) VALUES ('$cod_criterio','$nome_subcriterio')";	
	mysql_select_db($db, $con);
    $result = mysql_query($sql, $con) or die(mysql_error());
		if($result){
			echo'<script type="text/javascript">
					location.replace ("checklist.php");
				</script>';
		}else{
			echo'<script type="text/javascript">
					alert ("Erro ao gravar Sub-Critério no banco de dados");
					location. replace ("checklist.php");
				</script>';
			}
		mysql_close($sql);
?>