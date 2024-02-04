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
	$cod_rotina = $_GET["codsubrotina"];
?>
<form action="addsubrotina_db.php?cod_rot=<?php echo $cod_rotina; ?>" method="post">
	<fieldset>
    	<legend>Adicionar Sub-Rotina</legend>
        <div align="center">
        	<label>Informe o nome da Sub-Rotina a ser adicionada</label>
            <br><br>
            <input type="text" name="nome_subrotina" id="nome_subrotina" autofocus required />
        </div>
        <div align="right">
        	<input id="botao" type="submit" value="Adicionar Sub-Rotina" />
        </div>
	</fieldset>
</form>
</body>
</html