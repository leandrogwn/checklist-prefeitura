<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sem título</title>
<link rel="stylesheet" href="web_tools/reset.css">
<link rel="stylesheet" href="web_tools/style.css">
</head>

<body>
<?php
	include("conecta.php");
	$busca_rotina = mysql_query("SELECT	* FROM cl_rotina") or die ("Não foi possivel localizar as rotinas no banco de dados. ".mysql_error());
	
?>
<form action="preencher_rotina.php" method="post" target="_blank">
	<table>
    	<tr>
        	<td>Selecione a Rotina</td>
            <td colspan="2">Data Preenchimento</td>
        </tr>
        <tr>
        	<td>
            	<select name="rotina" id="rotina">
                	<?php
						while($linha_rotina = mysql_fetch_assoc($busca_rotina)){		
					?>
                	<option value="<?php echo $linha_rotina['cod_rotina']; ?>">
                    	<?php
							echo $linha_rotina['nome_rotina'];
						?>
                    </option>
                	<?php
						}
					?>
                </select>
            </td>
            <td>
            	<input type="date" name="data_preenchimento" id="data_preenchimento" value="<?php echo date('Y-m-d'); ?>"/>
            </td>
            <td>
            	<input type="submit" value="Avançar"  />
            </td>
    </table>
</form><br /><br /><br />
<div align="center">
	<img src="img/checked.png" />
</div>
</body>
</html>