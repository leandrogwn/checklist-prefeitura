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
	$cod_subrotina = $_GET["codsubrotina"];
?>
<form action="addcriterio_db.php?cod_subrotina=<?php echo $cod_subrotina; ?>" method="post">
	<fieldset>
    	<legend>Adicionar Critério</legend>
        <div align="center">
        	<label>Informe a descrição do Critério a ser adicionada</label>
            <br><br>
            <textarea name="nome_criterio" id="nome_criterio" autofocus required></textarea>
        </div>
        <div align="right">
        	<input id="botao" type="submit" value="Adicionar Critério" />
        </div>
	</fieldset>
</form>
</body>
</html