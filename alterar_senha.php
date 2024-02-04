<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Alterar Senha</title>
<link rel="stylesheet" href="web_tools/reset.css">
<link rel="stylesheet" href="web_tools/style.css">
<link rel="stylesheet" href="web_tools/menu.css">
<style type="text/css">
#tamanho div div h1 {
	font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
}
#senha_atual, #nova_senha, #repete_senha{
	text-transform:none!important;
}
</style>
<?php
	Header('Cache-Control: no-cache');
	Header('Pragma: no-cache');
?>
</head>
<body>
<div id="tamanho">
<script>
	function confere_senha(){
		var sn = document.getElementById('nova_senha').value;
		var rs = document.getElementById('repete_senha').value;
			if (sn != rs){
				alert ("O campo Nova senha deve ser igual ao campo Repita a nova senha. Digite novamente!");
				document.getElementById('nova_senha').value = "";
				document.getElementById('repete_senha').value = "";
				document.getElementById('nova_senha').focus();
			}
	}
</script>
<?php
	include("conecta.php");
	
	$cod = $_GET['cod'];
?>
    <div align="left">
    
    <div align="center">
   <br><br><h1>Alteração de Senha</h1></div>
        <form action="alterar_senha_bd.php?cod=<?php echo $cod; ?>" method="post">
        	<fieldset>
            
        		Digite a senha atual<br>
            	<input type="password" name="senha_atual" required id="senha_atual" >
            <br>
            Digite sua nova senha<br>
            <input type="password" name="nova_senha" required id="nova_senha">
            <br>
            Repita a nova senha<br>
            <input type="password" name="repete_senha" required id="repete_senha">
            <br>
            <div align="center">
            	<input type="submit" value="Salvar Alterações" id="btngrupo_senha" onMouseOver="confere_senha()"></div>
             </fieldset>

        </form>
    </div>
</div> 
<script language="Javascript" type="text/javascript">
	parent.document.getElementById("altframe").height = document.getElementById("tamanho").scrollHeight + 40; //40: Margem Superior e Inferior, somadas
</script> 
</body>
</html>