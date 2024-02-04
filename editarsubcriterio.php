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
	$editarsubcriterio = $_GET['editarsubcriterio'];
	$busca = mysql_query("SELECT * FROM cl_sub_criterio WHERE cod_sub_criterio = '$editarsubcriterio'") or die ("Não foi possivel encontrar o código do Sub-Critério. ".mysql_error());
	$linha = mysql_fetch_assoc($busca);
?>
<form action="editarsubcriterio_db.php?codsubcriterio=<?php echo $editarsubcriterio;?>" method="post">
	<fieldset>
    	<legend>Editar Sub-Critério</legend>
        <div align="center">
        	<label>Altere o nome do Sub-Critério selecionado</label>
            <br><br>
           <textarea name="nome_subcriterio" id="nome_subcriterio" required><?php echo $linha['descricao_criterio'];?></textarea>
        </div>
        <div align="right">
        	<input id="botao" type="submit" value="Alterar Sub-Critério" />
        </div>
	</fieldset>
</form>
<?php 
	mysql_free_result($busca);
	mysql_close($con);
?>
</body>
</html