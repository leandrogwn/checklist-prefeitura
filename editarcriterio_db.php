<?php
	include ("conecta.php");
	$codcriterio = $_GET['codcriterio'];
	$nome_criterio = $_POST["nome_criterio"];
	$atualiza = ("UPDATE cl_criterio SET descricao='$nome_criterio' WHERE cod_criterio ='$codcriterio'");	
	mysql_select_db($db, $con);
    $result = mysql_query($atualiza, $con) or die(mysql_error());
		if($result){
			echo'<script type="text/javascript">
					location.replace ("checklist.php");
				</script>';
		}else{
			echo'<script type="text/javascript">
					alert ("Erro ao alterar o Critério no banco de dados");
					location. replace ("checklist.php");
				</script>';
			}
		mysql_close($sql);
?>