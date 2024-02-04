<!DOCTYPE html>
<html lang="pt-br">
<head>
		<meta charset="utf-8" />
		<link type="text/css" rel="stylesheet" href="web_tools/reset.css" />
		<link type="text/css" rel="stylesheet" href="web_tools/style.css" />
<?php
	Header('Cache-Control: no-cache');
	Header('Pragma: no-cache');
?>
</head>
<body>
<?php
	include ("topo.php");
	include ("conecta.php");
	$editarcriterio = $_GET['editarcriterio'];
	$busca = mysql_query("SELECT * FROM cl_criterio WHERE cod_criterio = '$editarcriterio'") or die ("Não foi possivel encontrar o código do Critério. ".mysql_error());
	$linha = mysql_fetch_assoc($busca);
?>
<form action="editarcriterio_db.php?codcriterio=<?php echo $editarcriterio;?>" method="post">
	<fieldset>
    	<legend>Editar Critério</legend>
        <div align="center">
        	<label>Altere o nome do Critério selecionado</label>
            <br><br>
           <textarea name="nome_criterio" id="nome_criterio" required><?php echo $linha['descricao'];?></textarea>
        </div>
        <div align="right">
        	<input id="botao" type="submit" value="Alterar Critério" />
        </div>
	</fieldset>
</form>
<?php 
	mysql_free_result($busca);
	mysql_close($con);
?>
</body>
</html