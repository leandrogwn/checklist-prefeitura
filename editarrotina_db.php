<?php
	include ("conecta.php");
	$codrotina = $_GET["codrotina"];
	$nome_rotina = $_POST["nome_rotina"];
	$atualiza = ("UPDATE cl_rotina SET nome_rotina='$nome_rotina' WHERE cod_rotina ='$codrotina'");	
	mysql_select_db($db, $con);
    $result = mysql_query($atualiza, $con) or die(mysql_error());
		if($result){
			echo'<script type="text/javascript">
					location.replace ("checklist.php");
				</script>';
		}else{
			echo'<script type="text/javascript">
					alert ("Erro ao alterar a Rotina no banco de dados");
					location. replace ("checklist.php");
				</script>';
			}
		mysql_close($sql);
?>