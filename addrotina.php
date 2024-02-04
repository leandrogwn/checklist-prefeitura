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
?>
<form action="addrotina_db.php" method="post">
	<fieldset>
    	<legend>Adicionar Rotina</legend>
        <div align="center">
        	<label>Informe o nome da Rotina a ser adicionada</label>
            <br><br>
            <input type="text" name="nome_rotina" id="nome_rotina" autofocus required />
        </div>
        <div align="right">
        	<input id="botao" type="submit" value="Adicionar Rotina" />
        </div>
	</fieldset>
</form>
</body>
</html