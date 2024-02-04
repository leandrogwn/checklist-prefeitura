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
	$codrotina = $_GET['codrotina'];
	$busca = mysql_query("SELECT * FROM cl_rotina WHERE cod_rotina = '$codrotina'") or die ("Não foi possivel encontrar o código da rotina. ".mysql_error());
	$linha = mysql_fetch_assoc($busca);
?>
<form action="editarrotina_db.php?codrotina=<?php echo $codrotina;?>" method="post">
	<fieldset>
    	<legend>Editar Rotina</legend>
        <div align="center">
        	<label>Altere o nome da Rotina selecionada</label>
            <br><br>
            <input type="text" name="nome_rotina" id="nome_rotina" required value="<?php echo $linha['nome_rotina'];?>"/>
        </div>
        <div align="right">
        	<input id="botao" type="submit" value="Alterar Rotina" />
        </div>
	</fieldset>
</form>
<?php 
	mysql_free_result($busca);
	mysql_close($con);
?>
</body>
</html