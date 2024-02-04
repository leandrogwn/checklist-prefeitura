<?php
	error_reporting(0);
	$login_digitado = $_POST['user'];
	$senha_digitada = $_POST['pass'];

if ($login_digitado == "" || $senha_digitada == ""){
	echo "<br><br><center><h2>Os campos login e senha devem ser preenchidos</2></center>";
	echo "<br><br><center><a href=\"index.php\">Clique aqui para tentar novamente</a></center>";
}else{
	//inclusão arquivo de conexão com o banco
	include("conecta.php");
	//abre conexão com a tabela
	$busca = mysql_query("SELECT * FROM cl_admin WHERE login = '$login_digitado'")
	or die("<br>Não foi possivel realizar a busca. Erro: ".mysql_error());
	
	while($reg = mysql_fetch_assoc($busca)){
		$cod = $reg["id_user"];
		$login_db = $reg["login"];
		$senha_db = $reg["senha"];
		$cad_u = $reg["cad_user"];
		$ger = $reg["gerar"];
		$res = $reg["responder"];
		$rel = $reg["relatorio"];
		$nome = $reg["nome"];
	}
	if($login_db == $login_digitado && $senha_db == $senha_digitada){
		?> 

<!DOCTYPE html>
<head lang="pt">
<?php header("Content-Type: text/html; charset=utf-8",true); ?>
<?php
	Header('Cache-Control: no-cache');
	Header('Pragma: no-cache');
?>

<title>Check List</title>
<link rel="stylesheet" href="web_tools/reset.css">
<link rel="stylesheet" href="web_tools/style.css">
<link rel="stylesheet" href="web_tools/menu.css">
<script>
	function master(){
		alert('Função habilitada somente para usuário principal!');
	}	
	function sair(){
		location.replace("index.php");	
	}
</script>
</head>
<body  onload="UR_Start()">
    <div>
      <ul id="nav">
      	<li><a href="#"><img src="img/key.png"></a>
            <ul>
             <li><?php  if ($cad_u == TRUE){ echo '<a href="cadastrar_usuario.php" target="meio">';} else {echo '<a href="#" onClick="master()">'; } ?>Cadastrar Usuário</a></li>
                <li><a href="alterar_senha.php?cod=<?php echo $cod;?>" target="meio">Alterar Senha</a></li>
                <li><a href="#" onClick="sair()">Sair</a></li>
            </ul>       
        </li>
        <li><a href="#">CHECK LIST</a>
        	<ul>
                   <li><?php if ($ger == TRUE){ echo '<a href="checklist.php" target="_blank">';} else {echo '<a href="#" onClick="master()">';  }?>GERAR</a>
                       
              </li>
                <li><?php if ($res == TRUE){ echo '<a href="responder.php" target="meio">';} else {echo '<a href="#" onClick="master()">'; } ?>RESPONDER</a></li>
                 <li><?php if ($rel == TRUE){ echo '<a href="relatorio.php" target="meio">';} else {echo '<a href="#" onClick="master()">'; } ?>RELATÓRIO</a></li>
          </ul>
        </li>
	    
     <script language = "JavaScript"> 
	var dataHora,xHora,xDia,dia,mes,ano,txtSaudacao; 
	dataHora = new Date(); 
	xHora = dataHora.getHours(); 
	if (xHora >= 0 && xHora < 12) {txtSaudacao =  " bom Dia! "} 
	if (xHora >= 12 && xHora < 18) {txtSaudacao = " boa Tarde! "} 
	if (xHora >= 18 && xHora <= 23) {txtSaudacao = " boa Noite! "} 
	
	xDia = dataHora.getDay(); 
	diaSemana = new Array(7); 
	diaSemana[0] = "Domingo"; 
	diaSemana[1] = "Segunda-feira"; 
	diaSemana[2] = "Terça-feira"; 
	diaSemana[3] = "Quarta-feira"; 
	diaSemana[4] = "Quinta-Feira"; 
	diaSemana[5] = "Sexta-Feira"; 
	diaSemana[6] = "Sábado"; 
	dia = dataHora.getDate(); 
	mes = dataHora.getMonth(); 
	mesDoAno = new Array(12); 
	mesDoAno[0] = "janeiro"; 
	mesDoAno[1] = "fevereiro"; 
	mesDoAno[2] = "março"; 
	mesDoAno[3] = "abril"; 
	mesDoAno[4] = "maio"; 
	mesDoAno[5] = "junho"; 
	mesDoAno[6] = "julho"; 
	mesDoAno[7] = "agosto"; 
	mesDoAno[8] = "setembro"; 
	mesDoAno[9]= "outubro"; 
	mesDoAno[10]= "novembro"; 
	mesDoAno[11] = "dezembro"; 
	ano = dataHora.getFullYear(); 
	document.write("<div id='saudacao'><font face='verdana' color='#CCCCCC'>" + "Olá <?php echo $nome; ?>,"+ txtSaudacao + "" + 
	diaSemana[xDia] + ", " + dia + " de " + mesDoAno[mes] + " de " + ano + 
	"</font></div>");
	</script>
      </ul>
</div>
<script> 
	function UR_Start() {
		UR_Nu = new Date;
		UR_Indhold = showFilled(UR_Nu.getHours()) + ":" + showFilled(UR_Nu.getMinutes()) + ":" + showFilled(UR_Nu.getSeconds());
		document.getElementById("ur").innerHTML = UR_Indhold;
		setTimeout("UR_Start()",1000);
	}
	function showFilled(Value) {
		return (Value > 9) ? "" + Value : "0" + Value;
	}

</script>

<div id="topo">
	
    <div id="figura" align="left">
        <img src="img/cabe_checklist.png">
    </div>
    
</div>
<div id="relogio" align="right">
    	<font id="ur" size="10" face="Trebuchet MS, Verdana, Arial, sans-serif" color="#DAD3B7" ></font>
    </div>
<iframe name="meio" id="altframe" src="inicial.php"> </iframe>
<?php 
		mysql_free_result($busca);
		mysql_close($con);
	 ?>
</body>
</html>
<?php
}else{
		?> <script>
		alert("Login ou Senha incorreta. Tente novamente");
		location.replace("index.php");
        </script>
        <?php
		
	}
		mysql_free_result($busca);
		mysql_close($con);
}
?>