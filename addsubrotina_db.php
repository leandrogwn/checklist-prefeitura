<?php
	include ("conecta.php");
	$cod_rot = $_GET["cod_rot"];
	$nome_subrotina = $_POST["nome_subrotina"];
	
	$sql = "INSERT INTO cl_sub_rotina (fk_cod_rotina, nome_sub_rotina) VALUES ('$cod_rot','$nome_subrotina')";	
	mysql_select_db($db, $con);
    $result = mysql_query($sql, $con) or die(mysql_error());
		if($result){
			echo'<script type="text/javascript">
					location.replace ("checklist.php");
				</script>';
		}else{
			echo'<script type="text/javascript">
					alert ("Erro ao gravar a Sub-Rotina no banco de dados");
					location. replace ("checklist.php");
				</script>';
			}
		mysql_close($sql);
?>