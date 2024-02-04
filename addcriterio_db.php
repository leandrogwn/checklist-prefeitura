<?php
	include ("conecta.php");
	$cod_subrot = $_GET["cod_subrotina"];
	$nome_criterio = $_POST["nome_criterio"];
	
	$sql = "INSERT INTO cl_criterio (fk_cod_sub_rotina, descricao) VALUES ('$cod_subrot','$nome_criterio')";	
	mysql_select_db($db, $con);
    $result = mysql_query($sql, $con) or die(mysql_error());
		if($result){
			echo'<script type="text/javascript">
					location.replace ("checklist.php");
				</script>';
		}else{
			echo'<script type="text/javascript">
					alert ("Erro ao gravar Critério no banco de dados");
					location. replace ("checklist.php");
				</script>';
			}
		mysql_close($sql);
?>