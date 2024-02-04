<?php

//Servidor remoto
$con = mysql_connect('127.0.01','pibema_admin','Srv@pmib2007');
//Servidor local
//$con = mysql_connect('localhost','pibemaprgovbr','info0016');

if (!$con) die ("<h1>Falha na conexão com o Banco de Dados!</h1>");


// Caso a conexão seja aprovada, então conecta o Banco de Dados.	
$db = mysql_select_db("pibema_site",$con);

// para a conexão com o MySQL
mysql_set_charset('utf8',$con);


?>