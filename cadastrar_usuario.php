<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Novo usuário</title>
<link rel="stylesheet" href="web_tools/reset.css">
<link rel="stylesheet" href="web_tools/style.css">
<link rel="stylesheet" href="web_tools/menu.css">
</head>
<body>
<div id="tamanho">
    <div align="left">
    
    <br><br>
    <style>
	input{
		text-transform:lowercase!important;
	}
	#nome{
		width:225px;
		text-transform:none!important;
	}
	</style>
        <form action="cadastrar_usuario_bd.php" method="post">
        	<fieldset>
        		<legend>Cadastrar novo usuário</legend><br>
                <label>Primeiro nome:</label><br>
            	<input type="text" name="nome" required id="nome">
            <br>
                <label>Login:</label><br>
            	<input type="text" name="login" required id="login">
            <br>
            <label>Senha:</label><br>
            	<input type="text" name="senha" required id="senha"><br>
            <label>Permissões</label><br>
            <fieldset>
            <input type="checkbox" class="check" name="cad">Cadastrar Usuário | <input type="checkbox" class="check" name="gerar">Gerar Check List | <input type="checkbox" class="check" name="responder">Responder Check List | <input type="checkbox" class="check" name="relatorio">Relatório Check List
            
            <br>
            </fieldset>
            <div align="center">
            	<input type="submit" value="Incluir Usuário" id="btngrupo"></div>
             </fieldset>
        </form>
    </div>
</div> 
<script language="Javascript" type="text/javascript">
	parent.document.getElementById("altframe").height = document.getElementById("tamanho").scrollHeight + 40; //40: Margem Superior e Inferior, somadas
</script> 
</body>
</html>
