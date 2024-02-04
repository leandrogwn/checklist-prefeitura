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
	$cod_criterio = $_GET["addcodcriterio"];
?>
<form action="addsubcriterio_db.php?cod_criterio=<?php echo $cod_criterio; ?>" method="post">
	<fieldset>
    	<legend>Adicionar Sub-Critério</legend>
        <div align="center">
        	<label>Informe a descrição do Sub-Critério a ser adicionada</label>
            <br><br>
            <textarea name="nome_subcriterio" id="nome_subcriterio" autofocus required></textarea>
        </div>
        <div align="right">
        	<input id="botao" type="submit" value="Adicionar Sub-Critério" />
        </div>
	</fieldset>
</form>
</body>
</html