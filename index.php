<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sem título</title>
<link rel="stylesheet" href="web_tools/reset.css">
<style>
body{
	background:url(img/carbon.png) repeat;
	}
	
#hair{
	text-align:center;
	background:url(web_tools/img/grey_wash_wall.png) repeat;
	}
	
#help{
	border:1px solid #000;
	border-radius:8px;
	margin:20px auto;
	padding:10px 20px;
	background:#141414;
	width:365px;
	color:#FFF;
}
#help img{
	float:left;
	margin:1px 10px 0 -10px;
}
#login{
	margin-top:50px;
	
}
input{
	border:none;
	border-radius:8px;
	padding:2px;
	width:250px
}
#btn{
	width:50px;
}
</style>
</head>

<body>
<div id="hair"><br><br><img src="img/cabe_checklist_login.png"><br><br><br>
<img src="img/LOGI.png"><br><br></div>
<div id="help"><img src="img/information.png">Preencha os campos corretamente e clique em "Login".</div><br><br>
<div id="login">
<form method="post" action="principal.php">
<table align="center">
<tr>
<td>
<font color="#FFFFFF">Login:</font></td><td><input type="text" name="user" id="user"></td></tr><tr><td>
<font color="#FFFFFF">Senha:</font></td><td><input type="password" id="pass" name="pass"></td></tr><tr><td colspan="2" align="right"><input type="submit" id="btn" value="Login"></td></tr></table>
</form>
</div>
</body>
</html>