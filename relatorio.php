<link rel="stylesheet" type="text/css" href="web_tools/style.css">
<?php
	include("conecta.php");
	$busca_rotina = mysql_query("SELECT	* FROM cl_rotina") or die ("Não foi possivel localizar as rotinas no banco de dados. ".mysql_error());
	
	//busca os anos preenchidos
	$busca_ano = mysql_query("SELECT DISTINCT year(data_preenchimento) as orderyear FROM cl_preencher ORDER BY orderyear DESC") or die ("Não foi possivel localizar os anos preenchidos no banco de dados. ".mysql_error());
	
	//busca os meses preenchidos
	$busca_mes = mysql_query("SELECT DISTINCT month(data_preenchimento) as ordermonth FROM cl_preencher ORDER BY ordermonth DESC") or die ("Não foi possivel localizar os meses preenchidos no banco de dados. ".mysql_error());
	
?>
<form method="post" action="view_relat.php" target="_blank">
<fieldset>
<table id="tab_relatorio">
    <tr id="tab_relatorio_linha">
        <td>
        	<label>Selecione a rotina</label>
        </td>
        <td>
        	<label>Relatório Anual</label>
        </td>
        <td>
        	<label>Relatório Mensal</label>
        </td>


    </tr>
    <tr>
    	<td>
        <select name="select_relatorio_rotina" id="select_relatorio_rotina">
        	<option value="all">
                Todas
            </option>
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
        <select name="select_relatorio_ano" id="select_relatorio_ano">
            <?php
                while($linha_ano = mysql_fetch_assoc($busca_ano)){		
            ?>
            <option value="<?php echo $linha_ano['orderyear']; ?>">
                <?php
                    echo $linha_ano['orderyear'];
                ?>
            </option>
            <?php
                }
            ?>
        </select>
        </td>
        <td>
        <select name="select_relatorio_mes" id="select_relatorio_mes">
            <option value="0"> - </option>
            <?php
                while($linha_mes = mysql_fetch_assoc($busca_mes)){		
            ?>
            <option value="<?php echo $linha_mes['ordermonth']; ?>">
                <?php
                    echo $linha_mes['ordermonth'];
                ?>
            </option>
            <?php
                }
            ?>
        </select>
        </td>
    </tr>
    <tr>
        <td>
        <input type="checkbox" name="obs" align="left" id="obs" value="1">
        <label class="lbl_obs" >Exibir Observações </label>
        </td>
        <td>
        <input type="checkbox" name="img" id="img" value="1">
        <label class="lbl_img">Exibir Imagens</label>
        </td>
                <td>
        <input type="submit" value="Gerar Relatório">
        </td>
	</tr>
</table>
</fieldset>
</form>