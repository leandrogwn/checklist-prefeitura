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
	$codsubrotina = $_GET['codsubrotina'];
	$busca = mysql_query("SELECT * FROM cl_sub_rotina WHERE cod_sub_rotina = '$codsubrotina'") or die ("Não foi possivel encontrar o código da Sub-Rotina. ".mysql_error());
	$linha = mysql_fetch_assoc($busca);
?>
<form action="editarsubrotina_db.php?codsubrotina=<?php echo $codsubrotina;?>" method="post">
	<fieldset>
    	<legend>Editar Sub-Rotina</legend>
        <div align="center">
        	<label>Altere o nome da Sub-Rotina selecionada</label>
            <br><br>
            <input type="text" name="nome_subrotina" id="nome_subrotina" required value="<?php echo $linha['nome_sub_rotina'];?>"/>
        </div>
        <div align="right">
        	<input id="botao" type="submit" value="Alterar Sub-Rotina" />
        </div>
	</fieldset>
</form>
<?php 
	mysql_free_result($busca);
	mysql_close($con);
?>
</body>
</html