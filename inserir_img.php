<!DOCTYPE html>
<head>
	<title>Inserir Imagens</title>
</head>
<body>

<?php
	$r = $_GET['r'];
	$cp = $_GET['cp'];
?>
<form method="post" action="inserir_img_bd.php?r=<?php echo $r;?>&cp=<?php echo $cp;?>" enctype="multipart/form-data">
	<fieldset>
    	<legend>Inserir imagem</legend>
        <label>Selecione o arquivo que deseja adicionar</label><br>
        <input type="file" size="90" accept="image/jpeg" accept="image/gif" accept="image/x-png" name="file_img">
        <br><br>
        <label>Insira um título para imagem</label><br>
        <input type="text" size="70" name="titulo">
        <br><br>
        <input type="submit" name="submit" value="Carregar Imagem">
    </fieldset>
</form>
</body>
</html>