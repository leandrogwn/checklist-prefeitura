<?php
	include ("conecta.php");
	$nome_rotina = $_POST["nome_rotina"];
	$sql = "INSERT INTO cl_rotina (nome_rotina) VALUES ('$nome_rotina')";	
	mysql_select_db($db, $con);
    $result = mysql_query($sql, $con) or die(mysql_error());
		if($result){
			echo'<script type="text/javascript">
					location.replace ("checklist.php");
				</script>';
		}else{
			echo'<script type="text/javascript">
					alert ("Erro ao gravar Rotina no banco de dados");
					location. replace ("checklist.php");
				</script>';
			}
		mysql_close($sql);
?>