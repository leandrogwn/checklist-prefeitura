<?php
	include ("conecta.php");
	$codsubrotina = $_GET['codsubrotina'];
	$nome_subrotina = $_POST["nome_subrotina"];
	$atualiza = ("UPDATE cl_sub_rotina SET nome_sub_rotina='$nome_subrotina' WHERE cod_sub_rotina ='$codsubrotina'");	
	mysql_select_db($db, $con);
    $result = mysql_query($atualiza, $con) or die(mysql_error());
		if($result){
			echo'<script type="text/javascript">
					location.replace ("checklist.php");
				</script>';
		}else{
			echo'<script type="text/javascript">
					alert ("Erro ao alterar a Sub-Rotina no banco de dados");
					location. replace ("checklist.php");
				</script>';
			}
		mysql_close($sql);
?>