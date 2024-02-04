<?php
	error_reporting(0);
	include("conecta.php");
	$rot = $_POST['select_relatorio_rotina'];
	$ano = $_POST['select_relatorio_ano'];
	$mes = $_POST['select_relatorio_mes'];
	$obs = $_POST['obs'];
	$img = $_POST['img'];
	if($rot == "all"){
	//pra cima ok
	$todas = mysql_query("SELECT cod_rotina FROM cl_rotina ORDER BY cod_rotina ASC") or die ("Não foi possivel localizar os códigos das rotinas. ".mysql_error());
	echo '<html>';
	echo '<head>';
	header("Content-Type: text/html; charset=utf-8",true);
	Header('Cache-Control: no-cache');
	Header('Pragma: no-cache');
	echo '<style>
                table{
                    width:100%;
                    border-color:#000000;
                    border-collapse:collapse;
                }
                #legenda{
                    text-align:right;
                }
                #resposta_crit{
					text-align:center;
				}
				#resposta_subcrit{
					margin-top:-20px;
					text-align:right;
					margin-right:10px;
				}
				#img, #img_crit{
					padding:5px;
					
				}
				#obs, #obs_crit, #img, #img_crit{
					border-color: #000000 #000000 #000000 #000000; 
					border-style: solid;
					border-top-width: 1px;
					border-right-width: 1px;
					border-bottom-width: 1px;
					border-left-width: 1px;
					border-radius:9px;
					padding:10px;
				}
				img{
					border-radius:9px;
				}
				p{
                    text-align:center;
					text-transform:uppercase;
                }
				#uper{
					text-transform:uppercase;
				}
            </style>';
			
		if($mes == 0){
			?>
			<title>Relatório Completo - ANO <?php echo $ano; ?><img src="img/cabe_checklist.png"> </title>
           	</head>
            <body>
			<p>CHECK LIST PARA ORIENTAÇÃO DO TRABALHO DE AUDITORIA - RELATÓRIO <?php echo $ano; ?> COMPLETO</p><br>
        
        <?php
		while($t = mysql_fetch_assoc($todas)){
			
		//código da rotina
		$rt = $t['cod_rotina'];
		
		//busca os meses que receberam resposta 
		$b = mysql_query("SELECT distinct month(data_preenchimento) as cl_anual FROM cl_preencher WHERE YEAR(data_preenchimento) = '$ano' ORDER BY cl_anual ASC") or die ("Não foi possivel localizar a data de preenchimento. ".mysql_error());

		//busca a rotina selecionada
		$busca_rotina = mysql_query("SELECT * FROM cl_rotina WHERE cod_rotina = '$rt' ") or die("Não foi possivel localizar a rotina. ". mysql_error());
		$lista_rotina = mysql_fetch_assoc($busca_rotina);
			
		//busca as subrotinas da rotina selecionada
		$busca_sub_rotina = mysql_query("SELECT * FROM cl_sub_rotina WHERE fk_cod_rotina = '$rt' ") or die("Não foi possivel localizar a sub-rotina. ". mysql_error());
		while($lista_anual = mysql_fetch_assoc($b))	{
			
		//faz a pesquisa se tem algo preenchido na data pedida
		$mes_atual = $lista_anual['cl_anual'];
		?>
		<p><?php echo $lista_rotina['nome_rotina'];?> - PERÍODO <?php echo $mes_atual.'/'.$ano; ?></p>
		<?php
		//busca as subrotinas da rotina selecionada
		$busca_sub_rotina = mysql_query("SELECT * FROM cl_sub_rotina WHERE fk_cod_rotina = '$rt' ") or die("Não foi possivel localizar a sub-rotina. ". mysql_error());
		while($lista_sub_rotina = mysql_fetch_assoc($busca_sub_rotina)){ ?>
            <table align="center" cellpadding="2" border="1">
            <tr>
                <td colspan="3" id="uper"><?php echo $lista_rotina['nome_rotina'];?></td>
            </tr>
            <tr>
                <td colspan="3" id="uper"><?php echo $lista_sub_rotina['nome_sub_rotina'];?></td>
            </tr>
            <tr>
                <td id="legenda" colspan="3">Legenda: N/A = Não se aplica.</td>
            </tr>
            <tr>
                <td width="85px" align="center">Nº da Ordem</td>
                <td>Descrição</td>
                <td width="75" align="center">Situação</td>
            </tr>
            <?php //busca os critérios da rotina
			$cod_sub_r = $lista_sub_rotina['cod_sub_rotina'];
			$busca_criterio = mysql_query("SELECT * FROM cl_criterio WHERE fk_cod_sub_rotina = '$cod_sub_r' ") or die("Não foi possivel localizar a rotina. ". mysql_error());
			$cont_criterio = 1;
			while($lista_criterio = mysql_fetch_assoc($busca_criterio)){
				
			//descobrir se existem sub_criterios
			$cod_criterio = $lista_criterio['cod_criterio'];
			$busca_sub_criterio = mysql_query("SELECT * FROM cl_sub_criterio WHERE fk_cod_criterio = '$cod_criterio' ") or die("Erro ao tentar localizar possivel sub_critério. ". mysql_error());
			$reg_sub_cri = mysql_num_rows($busca_sub_criterio);
			
			//busca resposta e observações critérios
			$busca_cl_preecher = mysql_query("SELECT * FROM cl_preencher WHERE cod_criterio = '$cod_criterio' AND YEAR(data_preenchimento) = '$ano' AND MONTH(data_preenchimento) = '$mes_atual' ") or die ("Não foi possivel localizar o codigo do criterio preenchido. ".mysql_error());
			$lista_cl_preencher_crit = mysql_fetch_assoc($busca_cl_preecher);
			$cod_pre_cl_preencher_crit = $lista_cl_preencher_crit['cod_preenchimento'];
			
			//busca imagens
			$busca_img_crit = mysql_query("SELECT * FROM cl_img WHERE fk_cod_preenchimento = '$cod_pre_cl_preencher_crit' ") or die ("Não foi possivel encontrar o código de preenchimento na tabela cl_img. ".mysql_error());
			$qtd_img_crit = mysql_num_rows($busca_img_crit);
			?>
            <tr>
            	<td align="center"><?php echo $cont_criterio++;?></td>
                <td><?php echo $lista_criterio['descricao'];
				if($reg_sub_cri == 0){
					$observacao = $lista_cl_preencher_crit['obs'];
					if($obs == 1 && $observacao != ""){
						echo '<div id="obs_crit"><img src="img/information.png"><font size="-1"><u>Observações:</u></font><br>'.$lista_cl_preencher_crit['obs'].'</div><hr>';	
					}
					if($img == 1 && $qtd_img_crit >= 1){
						echo '<div id="img_crit">';
						while($lista_img_crit = mysql_fetch_assoc($busca_img_crit)){?>
							<img src="/checklist/<?php echo $lista_img_crit['img'];?>" width="150px" >
						<?php }
						echo '</div>';
					}
				}
                ?>
                </td>
            <?php
				if($reg_sub_cri == 0){
					//não tem sub_criterio
					echo '<td><div id="resposta_crit">';
					switch($lista_cl_preencher_crit['resposta']){
						case "s":
							echo '<b>SIM</b>';
							break;
						case "n":
							echo '<b>NÃO</b>';
							break;
						default:
							echo '<b>N/A</b>';
					}
					echo '</div>';
					echo '</td>';
					echo '</tr>';
				}else{
					//tem sub_criterio	
					echo '<td>Itens<img src="img/baixo.jpg"></td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td></td>';
					echo '<td colspan="2">';
					$ol = 1;
					while($lista_sub_criterio = mysql_fetch_assoc($busca_sub_criterio)){
						//busca respostas e observações sub-criterios
						$cod_sub_criterio = $lista_sub_criterio['cod_sub_criterio'];
						$busca_cl_preecher_sub = mysql_query("SELECT * FROM cl_preencher WHERE cod_sub_criterio = '$cod_sub_criterio' AND MONTH(data_preenchimento) = '$mes_atual' ") or die ("Não foi possivel localizar o codigo do sub-criterio preenchido. ".mysql_error());
						$lista_cl_preencher_sub = mysql_fetch_assoc($busca_cl_preecher_sub);
						$cod_pre_cl_preencher_sub = $lista_cl_preencher_sub['cod_preenchimento'];
						if($img == 1){
							//busca imagens
							$busca_img = mysql_query("SELECT * FROM cl_img WHERE fk_cod_preenchimento = '$cod_pre_cl_preencher_sub' ") or die ("Não foi possivel encontrar o código de preenchimento na tabela cl_img. ".mysql_error());
							$qtd_img_sub_crit = mysql_num_rows($busca_img);
						}
						if($ol == 1){
							$ol = 0;
							echo '<ol style="list-style:lower-latin">';
       					}
						echo '<li>';
						echo $lista_sub_criterio['descricao_criterio'];
						echo '<div id="resposta_subcrit">';
						switch ($lista_cl_preencher_sub['resposta']){
							case "s":
								echo '<b>SIM</b>';
								break;
							case "n":
								echo '<b>NÃO</b>';
								break;
							default:
								echo '<b>N/A</b>';
						}
						echo '</div>';
						$observacao_sub = $lista_cl_preencher_sub['obs'];
						if($obs == 1 && $observacao_sub != ""){
							echo '<div id="obs"><img src="img/information.png"><font size="-1"><u>Observações:</u></font><br>'.$lista_cl_preencher_sub['obs'].'</div>';	
						}
						if($img == 1 && $qtd_img_sub_crit >= 1){
							echo '<br><div id="img">';
							while($lista_img = mysql_fetch_assoc($busca_img)){?>
								<img src="/checklist/<?php echo $lista_img['img'];?>" width="150px">
							<?php }
							echo '</div>';
						}
						echo '</li><hr>';
					}
					echo '</ol>';
					echo '</td>';
					echo '</tr>';
				}
			}//fim do while do lista_criterio			
			?>
            </table>
            <br>
	<?php }// fim do while do lista_sub_rotina 
		}	
	}
}else{
?>
        <title>Relatório <?php echo $lista_rotina['nome_rotina']; ?> Mensal - <?php echo $mes; ?> </title>
           	</head>
            <body>
			<p>CHECK LIST PARA ORIENTAÇÃO DO TRABALHO DE AUDITORIA</p>
            
            <?php while($t = mysql_fetch_assoc($todas)){
			
			//código da rotina
			$rt = $t['cod_rotina'];
			
            //busca as resposta do mes e ano escolhido
			$b = mysql_query("SELECT DISTINCT MONTH(data_preenchimento) as mes_atual FROM cl_preencher WHERE YEAR(data_preenchimento) = '$ano' AND MONTH(data_preenchimento) = '$mes' ") or die ("Não foi possivel localizar os registros com o ano e o mes escolhido. ".mysql_error());
			
			//busca a rotina selecionada
			$busca_rotina = mysql_query("SELECT * FROM cl_rotina WHERE cod_rotina = '$rt' ") or die("Não foi possivel localizar a rotina. ". mysql_error());
			$lista_rotina = mysql_fetch_assoc($busca_rotina);
			
			//busca as subrotinas da rotina selecionada
			$busca_sub_rotina = mysql_query("SELECT * FROM cl_sub_rotina WHERE fk_cod_rotina = '$rt' ") or die("Não foi possivel localizar a sub-rotina. ". mysql_error());
			
			while($lista_anual = mysql_fetch_assoc($b))	{
				
				//faz a pesquisa se tem algo preenchido na data pedida
				$mes_atual = $lista_anual['mes_atual'];
				?>
				<p><?php echo $lista_rotina['nome_rotina'];?> - PERÍODO <?php echo $mes_atual.'/'.$ano; ?></p>
				<?php
				//busca as subrotinas da rotina selecionada
				$busca_sub_rotina = mysql_query("SELECT * FROM cl_sub_rotina WHERE fk_cod_rotina = '$rt' ") or die("Não foi possivel localizar a sub-rotina. ". mysql_error());
             while($lista_sub_rotina = mysql_fetch_assoc($busca_sub_rotina)){?>
            <table align="center" cellpadding="2" border="1">
            <tr>
                <td colspan="3"><?php echo $lista_rotina['nome_rotina'];?></td>
            </tr>
            <tr>
                <td colspan="3"><?php echo $lista_sub_rotina['nome_sub_rotina'];?></td>
            </tr>
            <tr>
                <td id="legenda" colspan="3">Legenda: N/A = Não se aplica.</td>
            </tr>
            <tr>
                <td width="85px" align="center">Nº da Ordem</td>
                <td>Descrição</td>
                <td width="75" align="center">Situação</td>
            </tr>
            <?php //busca os critérios da rotina
			$cod_sub_r = $lista_sub_rotina['cod_sub_rotina'];
			$busca_criterio = mysql_query("SELECT * FROM cl_criterio WHERE fk_cod_sub_rotina = '$cod_sub_r' ") or die("Não foi possivel localizar a rotina. ". mysql_error());
			$cont_criterio = 1;
			while($lista_criterio = mysql_fetch_assoc($busca_criterio)){
				
			//descobrir se existem sub_criterios
			$cod_criterio = $lista_criterio['cod_criterio'];
			$busca_sub_criterio = mysql_query("SELECT * FROM cl_sub_criterio WHERE fk_cod_criterio = '$cod_criterio' ") or die("Erro ao tentar localizar possivel sub_critério. ". mysql_error());
			$reg_sub_cri = mysql_num_rows($busca_sub_criterio);
			
			//busca resposta e observações critérios
			$busca_cl_preecher = mysql_query("SELECT * FROM cl_preencher WHERE cod_criterio = '$cod_criterio' AND YEAR(data_preenchimento) = '$ano' AND MONTH(data_preenchimento) = '$mes' ") or die ("Não foi possivel localizar o codigo do criterio preenchido. ".mysql_error());
			$lista_cl_preencher_crit = mysql_fetch_assoc($busca_cl_preecher);
			$cod_pre_cl_preencher_crit = $lista_cl_preencher_crit['cod_preenchimento'];
			
			//busca imagens
			$busca_img_crit = mysql_query("SELECT * FROM cl_img WHERE fk_cod_preenchimento = '$cod_pre_cl_preencher_crit' ") or die ("Não foi possivel encontrar o código de preenchimento na tabela cl_img. ".mysql_error());
			$qtd_img_crit = mysql_num_rows($busca_img_crit);
			?>
            <tr>
            	<td align="center"><?php echo $cont_criterio++;?></td>
                <td><?php echo $lista_criterio['descricao'];
				$observacao = $lista_cl_preencher_crit['obs'];
				if($reg_sub_cri == 0 && $observacao != ""){
					if($obs == 1){
						echo '<div id="obs_crit"><img src="img/information.png"><font size="-1"><u>Observações:</u></font><br>'.$lista_cl_preencher_crit['obs'].'</div><hr>';
					}
					if($img == 1 && $qtd_img_crit >= 1){
						echo '<div id="img_crit">';
						while($lista_img_crit = mysql_fetch_assoc($busca_img_crit)){?>
							<img src="/checklist/<?php echo $lista_img_crit['img'];?>" width="150px" >
						<?php }
						echo '</div>';
					}
				}
                ?>
                </td>
            <?php
				if($reg_sub_cri == 0){
					//não tem sub_criterio
					echo '<td><div id="resposta_crit">';
					switch($lista_cl_preencher_crit['resposta']){
						case "s":
							echo '<b>SIM</b>';
							break;
						case "n":
							echo '<b>NÃO</b>';
							break;
						default:
							echo '<b>N/A</b>';
					}
					echo '</div>';
					echo '</td>';
					echo '</tr>';
				}else{
					//tem sub_criterio	
					echo '<td>Itens<img src="img/baixo.jpg"></td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td></td>';
					echo '<td colspan="2">';
					$ol = 1;
					while($lista_sub_criterio = mysql_fetch_assoc($busca_sub_criterio)){
						//busca respostas e observações sub-criterios
						$cod_sub_criterio = $lista_sub_criterio['cod_sub_criterio'];
						$busca_cl_preecher_sub = mysql_query("SELECT * FROM cl_preencher WHERE cod_sub_criterio = '$cod_sub_criterio' AND MONTH(data_preenchimento) = '$mes' ") or die ("Não foi possivel localizar o codigo do sub-criterio preenchido. ".mysql_error());
						$lista_cl_preencher_sub = mysql_fetch_assoc($busca_cl_preecher_sub);
						$cod_pre_cl_preencher_sub = $lista_cl_preencher_sub['cod_preenchimento'];
						if($img == 1){
							//busca imagens
							$busca_img = mysql_query("SELECT * FROM cl_img WHERE fk_cod_preenchimento = '$cod_pre_cl_preencher_sub' ") or die ("Não foi possivel encontrar o código de preenchimento na tabela cl_img. ".mysql_error());
							$qtd_img_sub_crit = mysql_num_rows($busca_img);
						}
						if($ol == 1){
							$ol = 0;
							echo '<ol style="list-style:lower-latin">';
       					}
						echo '<li>';
						echo $lista_sub_criterio['descricao_criterio'];
						echo '<div id="resposta_subcrit">';
						switch ($lista_cl_preencher_sub['resposta']){
							case "s":
								echo '<b>SIM</b>';
								break;
							case "n":
								echo '<b>NÃO</b>';
								break;
							default:
								echo '<b>N/A</b>';
						}
						echo '</div>';
						// vai ser usado ainda $lista_cl_preencher_sub['cod_preenchimento'];
						$observacao_sub = $lista_cl_preencher_sub['obs'];
						if($obs == 1 && $observacao_sub != ""){
							if($observacao != " "){
							echo '<div id="obs"><img src="img/information.png"><font size="-1"><u>Observações:</u></font><br>'.$lista_cl_preencher_sub['obs'].'teste</div>';
							}
						}
						if($img == 1 && $qtd_img_sub_crit >= 1){
							echo '<br><div id="img">';
							while($lista_img = mysql_fetch_assoc($busca_img)){?>
								<img src="/checklist/<?php echo $lista_img['img'];?>" width="150px">
							<?php }
							echo '</div>';
						}
						echo '</li><hr>';
					}
					echo '</ol>';
					echo '</td>';
					echo '</tr>';
				}	
			}//fim do while do lista_criterio			
			?>
            </table>
           	<br>
	<?php }// fim do while do lista_sub_rotina 	
	}
?>
<!--//-->
</body>
</html>
	<?php
		}
}
	//pra baixo ok	
}else{
	echo '<html>';
	echo '<head>';
	echo '<style>
                table{
                    width:100%;
                    border-color:#000000;
                    border-collapse:collapse;
                }
                #legenda{
                    text-align:right;
                }
                p{
                    text-align:center;
                }
				#resposta_crit{
					text-align:center;
				}
				#resposta_subcrit{
					margin-top:-20px;
					text-align:right;
					margin-right:10px;
				}
				#img, #img_crit{
					padding:5px;
				}
				#obs, #obs_crit, #img, #img_crit{
					border-color: #000000 #000000 #000000 #000000; 
					border-style: solid;
					border-top-width: 1px;
					border-right-width: 1px;
					border-bottom-width: 1px;
					border-left-width: 1px;
					border-radius:9px;
					padding:10px;
				}
				img{
					border-radius:9px;
				}
				p{
                    text-align:center;
					text-transform:uppercase;
                }
				#uper{
					text-transform:uppercase;
				}
            </style>';
			
		//busca os meses que receberam resposta 
		$b = mysql_query("SELECT distinct month(data_preenchimento) as cl_anual FROM cl_preencher WHERE YEAR(data_preenchimento) = '$ano' ORDER BY cl_anual ASC") or die ("Não foi possivel localizar a data de preenchimento. ".mysql_error());

		//busca a rotina selecionada
		$busca_rotina = mysql_query("SELECT * FROM cl_rotina WHERE cod_rotina = '$rot' ") or die("Não foi possivel localizar a rotina. ". mysql_error());
		$lista_rotina = mysql_fetch_assoc($busca_rotina);
			
		//busca as subrotinas da rotina selecionada
		$busca_sub_rotina = mysql_query("SELECT * FROM cl_sub_rotina WHERE fk_cod_rotina = '$rot' ") or die("Não foi possivel localizar a sub-rotina. ". mysql_error());		
		if($mes == 0){
			$qtd_data_anual = mysql_num_rows($b);
			if($qtd_data_anual == 0){
		?>
        	<title>Relatório <?php echo $lista_rotina['nome_rotina']; ?> Anual - <?php echo $ano; ?> </title>
           	</head>
            <body>
			<p>Não existem dados para o ano solicitado</p>
            <?php
            }else{
			?>
			<title>Relatório <?php echo $lista_rotina['nome_rotina']; ?> Anual - <?php echo $ano; ?> </title>
           	</head>
            <body>
			<p>CHECK LIST PARA ORIENTAÇÃO DO TRABALHO DE AUDITORIA</p><br>
        <?php
		while($lista_anual = mysql_fetch_assoc($b))	{
		//faz a pesquisa se tem algo preenchido na data pedida
		$mes_atual = $lista_anual['cl_anual'];
		?>
		<p>PERÍODO - <?php echo $mes_atual.'/'.$ano; ?></p>
		<?php
//busca as subrotinas da rotina selecionada
	$busca_sub_rotina = mysql_query("SELECT * FROM cl_sub_rotina WHERE fk_cod_rotina = '$rot' ") or die("Não foi possivel localizar a sub-rotina. ". mysql_error());
		while($lista_sub_rotina = mysql_fetch_assoc($busca_sub_rotina)){ ?>
            <table align="center" cellpadding="2" border="1">
            <tr>
                <td colspan="3"><?php echo $lista_rotina['nome_rotina'];?></td>
            </tr>
            <tr>
                <td colspan="3"><?php echo $lista_sub_rotina['nome_sub_rotina'];?></td>
            </tr>
            <tr>
                <td id="legenda" colspan="3">Legenda: N/A = Não se aplica.</td>
            </tr>
            <tr>
                <td width="85px" align="center">Nº da Ordem</td>
                <td>Descrição</td>
                <td width="75" align="center">Situação</td>
            </tr>
            <?php //busca os critérios da rotina
			$cod_sub_r = $lista_sub_rotina['cod_sub_rotina'];
			$busca_criterio = mysql_query("SELECT * FROM cl_criterio WHERE fk_cod_sub_rotina = '$cod_sub_r' ") or die("Não foi possivel localizar a rotina. ". mysql_error());
			$cont_criterio = 1;
			while($lista_criterio = mysql_fetch_assoc($busca_criterio)){
				
			//descobrir se existem sub_criterios
			$cod_criterio = $lista_criterio['cod_criterio'];
			$busca_sub_criterio = mysql_query("SELECT * FROM cl_sub_criterio WHERE fk_cod_criterio = '$cod_criterio' ") or die("Erro ao tentar localizar possivel sub_critério. ". mysql_error());
			$reg_sub_cri = mysql_num_rows($busca_sub_criterio);
			
			//busca resposta e observações critérios
			$busca_cl_preecher = mysql_query("SELECT * FROM cl_preencher WHERE cod_criterio = '$cod_criterio' AND YEAR(data_preenchimento) = '$ano' AND MONTH(data_preenchimento) = '$mes_atual' ") or die ("Não foi possivel localizar o codigo do criterio preenchido. ".mysql_error());
			$lista_cl_preencher_crit = mysql_fetch_assoc($busca_cl_preecher);
			$cod_pre_cl_preencher_crit = $lista_cl_preencher_crit['cod_preenchimento'];
			
			//busca imagens
			$busca_img_crit = mysql_query("SELECT * FROM cl_img WHERE fk_cod_preenchimento = '$cod_pre_cl_preencher_crit' ") or die ("Não foi possivel encontrar o código de preenchimento na tabela cl_img. ".mysql_error());
			$qtd_img_crit = mysql_num_rows($busca_img_crit);
			?>
            <tr>
            	<td align="center"><?php echo $cont_criterio++;?></td>
                <td><?php echo $lista_criterio['descricao'];
				if($reg_sub_cri == 0){
					$observacao = $lista_cl_preencher_crit['obs'];
					if($obs == 1 && $observacao != ""){
						echo '<div id="obs_crit"><img src="img/information.png"><font size="-1"><u>Observações:</u></font><br>'.$lista_cl_preencher_crit['obs'].'</div><hr>';
					}
					if($img == 1 && $qtd_img_crit >= 1){
						echo '<div id="img_crit">';
						while($lista_img_crit = mysql_fetch_assoc($busca_img_crit)){?>
							<img src="/checklist/<?php echo $lista_img_crit['img'];?>" width="150px" >
						<?php }
						echo '</div>';
					}
				}
                ?>
                </td>
            <?php
				if($reg_sub_cri == 0){
					//não tem sub_criterio
					echo '<td><div id="resposta_crit">';
					switch($lista_cl_preencher_crit['resposta']){
						case "s":
							echo '<b>SIM</b>';
							break;
						case "n":
							echo '<b>NÃO</b>';
							break;
						default:
							echo '<b>N/A</b>';
					}
					echo '</div>';
					echo '</td>';
					echo '</tr>';
				}else{
					//tem sub_criterio	
					echo '<td>Itens<img src="img/baixo.jpg"></td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td></td>';
					echo '<td colspan="2">';
					$ol = 1;
					while($lista_sub_criterio = mysql_fetch_assoc($busca_sub_criterio)){
						//busca respostas e observações sub-criterios
						$cod_sub_criterio = $lista_sub_criterio['cod_sub_criterio'];
						$busca_cl_preecher_sub = mysql_query("SELECT * FROM cl_preencher WHERE cod_sub_criterio = '$cod_sub_criterio' AND MONTH(data_preenchimento) = '$mes_atual' ") or die ("Não foi possivel localizar o codigo do sub-criterio preenchido. ".mysql_error());
						$lista_cl_preencher_sub = mysql_fetch_assoc($busca_cl_preecher_sub);
						$cod_pre_cl_preencher_sub = $lista_cl_preencher_sub['cod_preenchimento'];
						if($img == 1){
							//busca imagens
							$busca_img = mysql_query("SELECT * FROM cl_img WHERE fk_cod_preenchimento = '$cod_pre_cl_preencher_sub' ") or die ("Não foi possivel encontrar o código de preenchimento na tabela cl_img. ".mysql_error());
							$qtd_img_sub_crit = mysql_num_rows($busca_img);
						}
						if($ol == 1){
							$ol = 0;
							echo '<ol style="list-style:lower-latin">';
       					}
						echo '<li>';
						echo $lista_sub_criterio['descricao_criterio'];
						echo '<div id="resposta_subcrit">';
						switch ($lista_cl_preencher_sub['resposta']){
							case "s":
								echo '<b>SIM</b>';
								break;
							case "n":
								echo '<b>NÃO</b>';
								break;
							default:
								echo '<b>N/A</b>';
						}
						echo '</div>';
						$observacao_sub = $lista_cl_preencher_sub['obs'];
						if($obs == 1 && $observacao_sub != ""){
							echo '<div id="obs"><img src="img/information.png"><font size="-1"><u>Observações:</u></font><br>'.$lista_cl_preencher_sub['obs'].'</div>';	
						}
						if($img == 1 && $qtd_img_sub_crit >= 1){
							echo '<br><div id="img">';
							while($lista_img = mysql_fetch_assoc($busca_img)){?>
								<img src="/checklist/<?php echo $lista_img['img'];?>" width="150px">
							<?php }
							echo '</div>';
						}
						echo '</li><hr>';
					}
					echo '</ol>';
					echo '</td>';
					echo '</tr>';
				}
			}//fim do while do lista_criterio			
			?>
            </table>
            <br>
	<?php }// fim do while do lista_sub_rotina 
		}	
	}
	}else{
		  ?>
        <title>Relatório <?php echo $lista_rotina['nome_rotina']; ?> Mensal - <?php echo $mes; ?> </title>
           	</head>
            <body>
			<p>CHECK LIST PARA ORIENTAÇÃO DO TRABALHO DE AUDITORIA</p>
            <p><?php echo $lista_rotina['nome_rotina']; ?> - PERÍODO <?php echo $mes.'/'.$ano; ?></p>
            <?php while($lista_sub_rotina = mysql_fetch_assoc($busca_sub_rotina)){?>
            <table align="center" cellpadding="2" border="1">
            <tr>
                <td colspan="3" id="uper"><?php echo $lista_rotina['nome_rotina'];?></td>
            </tr>
            <tr>
                <td colspan="3" id="uper"><?php echo $lista_sub_rotina['nome_sub_rotina'];?></td>
            </tr>
            <tr>
                <td id="legenda" colspan="3">Legenda: N/A = Não se aplica.</td>
            </tr>
            <tr>
                <td width="85px" align="center">Nº da Ordem</td>
                <td>Descrição</td>
                <td width="75" align="center">Situação</td>
            </tr>
            <?php //busca os critérios da rotina
			$cod_sub_r = $lista_sub_rotina['cod_sub_rotina'];
			$busca_criterio = mysql_query("SELECT * FROM cl_criterio WHERE fk_cod_sub_rotina = '$cod_sub_r' ") or die("Não foi possivel localizar a rotina. ". mysql_error());
			$cont_criterio = 1;
			while($lista_criterio = mysql_fetch_assoc($busca_criterio)){
				
			//descobrir se existem sub_criterios
			$cod_criterio = $lista_criterio['cod_criterio'];
			$busca_sub_criterio = mysql_query("SELECT * FROM cl_sub_criterio WHERE fk_cod_criterio = '$cod_criterio' ") or die("Erro ao tentar localizar possivel sub_critério. ". mysql_error());
			$reg_sub_cri = mysql_num_rows($busca_sub_criterio);
			
			//busca resposta e observações critérios
			$busca_cl_preecher = mysql_query("SELECT * FROM cl_preencher WHERE cod_criterio = '$cod_criterio' AND YEAR(data_preenchimento) = '$ano' AND MONTH(data_preenchimento) = '$mes' ") or die ("Não foi possivel localizar o codigo do criterio preenchido. ".mysql_error());
			$lista_cl_preencher_crit = mysql_fetch_assoc($busca_cl_preecher);
			$cod_pre_cl_preencher_crit = $lista_cl_preencher_crit['cod_preenchimento'];
			
			//busca imagens
			$busca_img_crit = mysql_query("SELECT * FROM cl_img WHERE fk_cod_preenchimento = '$cod_pre_cl_preencher_crit' ") or die ("Não foi possivel encontrar o código de preenchimento na tabela cl_img. ".mysql_error());
			$qtd_img_crit = mysql_num_rows($busca_img_crit);
			?>
            <tr>
            	<td align="center"><?php echo $cont_criterio++;?></td>
                <td><?php echo $lista_criterio['descricao'];
				$observacao = $lista_cl_preencher_crit['obs'];
				if($reg_sub_cri == 0 && $observacao != ""){
					if($obs == 1){
						echo '<div id="obs_crit"><img src="img/information.png"><font size="-1"><u>Observações:</u></font><br>'.$lista_cl_preencher_crit['obs'].'</div><hr>';
					}
					if($img == 1 && $qtd_img_crit >= 1){
						echo '<div id="img_crit">';
						while($lista_img_crit = mysql_fetch_assoc($busca_img_crit)){?>
							<img src="/checklist/<?php echo $lista_img_crit['img'];?>" width="150px" >
						<?php }
						echo '</div>';
					}
				}
                ?>
                </td>
            <?php
				if($reg_sub_cri == 0){
					//não tem sub_criterio
					echo '<td><div id="resposta_crit">';
					switch($lista_cl_preencher_crit['resposta']){
						case "s":
							echo '<b>SIM</b>';
							break;
						case "n":
							echo '<b>NÃO</b>';
							break;
						default:
							echo '<b>N/A</b>';
					}
					echo '</div>';
					echo '</td>';
					echo '</tr>';
				}else{
					//tem sub_criterio	
					echo '<td>Itens<img src="img/baixo.jpg"></td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td></td>';
					echo '<td colspan="2">';
					$ol = 1;
					while($lista_sub_criterio = mysql_fetch_assoc($busca_sub_criterio)){
						//busca respostas e observações sub-criterios
						$cod_sub_criterio = $lista_sub_criterio['cod_sub_criterio'];
						$busca_cl_preecher_sub = mysql_query("SELECT * FROM cl_preencher WHERE cod_sub_criterio = '$cod_sub_criterio' AND MONTH(data_preenchimento) = '$mes' ") or die ("Não foi possivel localizar o codigo do sub-criterio preenchido. ".mysql_error());
						$lista_cl_preencher_sub = mysql_fetch_assoc($busca_cl_preecher_sub);
						$cod_pre_cl_preencher_sub = $lista_cl_preencher_sub['cod_preenchimento'];
						if($img == 1){
							//busca imagens
							$busca_img = mysql_query("SELECT * FROM cl_img WHERE fk_cod_preenchimento = '$cod_pre_cl_preencher_sub' ") or die ("Não foi possivel encontrar o código de preenchimento na tabela cl_img. ".mysql_error());
							$qtd_img_sub_crit = mysql_num_rows($busca_img);
						}
						if($ol == 1){
							$ol = 0;
							echo '<ol style="list-style:lower-latin">';
       					}
						echo '<li>';
						echo $lista_sub_criterio['descricao_criterio'];
						echo '<div id="resposta_subcrit">';
						switch ($lista_cl_preencher_sub['resposta']){
							case "s":
								echo '<b>SIM</b>';
								break;
							case "n":
								echo '<b>NÃO</b>';
								break;
							default:
								echo '<b>N/A</b>';
						}
						echo '</div>';
						// vai ser usado ainda $lista_cl_preencher_sub['cod_preenchimento'];
						$observacao = $lista_cl_preencher_sub['obs'];
						if($obs == 1 && $observacao != ""){
							echo '<div id="obs"><img src="img/information.png"><font size="-1"><u>Observações:</u></font><br>'.$lista_cl_preencher_sub['obs'].'teste</div>';
						}
						if($img == 1 && $qtd_img_sub_crit >= 1){
							echo '<br><div id="img">';
							while($lista_img = mysql_fetch_assoc($busca_img)){?>
								<img src="/checklist/<?php echo $lista_img['img'];?>" width="150px">
							<?php }
							echo '</div>';
						}
						echo '</li><hr>';
					}
					echo '</ol>';
					echo '</td>';
					echo '</tr>';
				}
			}//fim do while do lista_criterio			
			?>
          </table>
            <br>
	<?php }// fim do while do lista_sub_rotina 
	}
?>
<!--//-->
</body>
</html>
<?php
	}
?>

<form action="gerar_pdf.php" method="post"  enctype="multipart/form-data">

<textarea name="relatorio" style="display:none;">
<?php
	error_reporting(0);
	include("conecta.php");
	$rot = $_POST['select_relatorio_rotina'];
	$ano = $_POST['select_relatorio_ano'];
	$mes = $_POST['select_relatorio_mes'];
	$obs = $_POST['obs'];
	$img = $_POST['img'];
	if($rot == "all"){
	//pra cima ok
	$todas = mysql_query("SELECT cod_rotina FROM cl_rotina ORDER BY cod_rotina ASC") or die ("Não foi possivel localizar os códigos das rotinas. ".mysql_error());
	echo '<html>';
	echo '<head>';
	header("Content-Type: text/html; charset=utf-8",true);
	Header('Cache-Control: no-cache');
	Header('Pragma: no-cache');
	echo '<style>
				@page {
						margin-top: 189px;
						margin-bottom:50px
				}

                table{
                    width:100%;
                    border-color:#000000;
                    border-collapse:collapse;
                }
                #legenda{
                    text-align:right;
                }
                #resposta_crit{
					text-align:center;
				}
				#resposta_subcrit{
					margin-top:-20px;
					text-align:right;
					margin-right:10px;
				}
				#img, #img_crit{
					padding:5px;
					
				}
				#obs, #obs_crit, #img, #img_crit{
					border-color: #000000 #000000 #000000 #000000; 
					border-style: solid;
					border-top-width: 1px;
					border-right-width: 1px;
					border-bottom-width: 1px;
					border-left-width: 1px;
					border-radius:9px;
					padding:10px;
				}
				img{
					border-radius:9px;
				}
				p{
                    text-align:center;
					text-transform:uppercase;
                }
				#uper{
					text-transform:uppercase;
				}
            </style>';
			
		if($mes == 0){
			?>
			<title>Relatório Completo - ANO <?php echo $ano; ?><img src="img/cabe_checklist.png"> </title>
           	</head>
            

            
            <body>
			<script type="text/php">
				if ( isset($pdf) ) {
				// Configurações para ajustar o tamanho do texto, cores, e dimensões da area do arquivo
				$font = Font_Metrics::get_font("Helvetica");
				$size = 9;
				$color = array(0,0,0);
				$text_height = Font_Metrics::get_font_height($font,$size);
				$foot = $pdf->open_object();
				$w = $pdf->get_width();
				$h = $pdf->get_height();
				// Cria cabeçalho
				$pdf -> image("img/logo_timb.jpg","jpg",32, 600, 97, 100);
				$b = $h - $text_height - 700;
				$pdf->line(12, $b, $w - 16, $b, $color, 0.5);
				// Cria uma linha no rodapé
				$y = $h - $text_height - 32;
				$pdf->line(12, $y, $w - 16, $y, $color, 0.5);
				$pdf->close_object();
				$pdf -> add_object($foot, "all");
				$pdf->add_object($font, "all");
				// Insere um texto um pouco acima da linha do rodapé
				$_texto = utf8_encode("
				AV. NEY EURISON NAPOLI, 1426  -  FONES:(45) 3238-1347  -  3238-1355  -  CEP 85.478-000  -  IBEMA  -  PARANÁ");
				$_texto1 = utf8_encode("prefeitura@pibema.pr.gov.br  -  www.pibema.pr.gov.br");
				$w1 = Font_Metrics::get_text_width($_texto , $font, 9);
				$w2 = Font_Metrics::get_text_width($_texto1 , $font, 7);
				$y = $h - $text_height - 27;
				$pdf->page_text($w / 2 - $w1 / 2, $y, $_texto , $font, 9, $color);
				$r = $h - $text_height - 18;
				$pdf->page_text($w / 2 - $w2 / 2, $r, $_texto1 , $font, 7, $color);
				// Numero da pagina
				$text = utf8_encode("Página {PAGE_NUM} de {PAGE_COUNT} ") ;
				$width = Font_Metrics::get_text_width("Pagina 1 de 2", $font, 6);
				$y = $h - $text_height - 10;
				$w = $w - 14;
				$pdf->page_text($w - $width, $y, $text, $font, 6, $color);
				}
            </script>
<div id="top_pdf">
			<p>CHECK LIST PARA ORIENTAÇÃO DO TRABALHO DE AUDITORIA - RELATÓRIO <?php echo $ano; ?> COMPLETO</p><br>
        
        <?php
		while($t = mysql_fetch_assoc($todas)){
			
		//código da rotina
		$rt = $t['cod_rotina'];
		
		//busca os meses que receberam resposta 
		$b = mysql_query("SELECT distinct month(data_preenchimento) as cl_anual FROM cl_preencher WHERE YEAR(data_preenchimento) = '$ano' ORDER BY cl_anual ASC") or die ("Não foi possivel localizar a data de preenchimento. ".mysql_error());

		//busca a rotina selecionada
		$busca_rotina = mysql_query("SELECT * FROM cl_rotina WHERE cod_rotina = '$rt' ") or die("Não foi possivel localizar a rotina. ". mysql_error());
		$lista_rotina = mysql_fetch_assoc($busca_rotina);
			
		//busca as subrotinas da rotina selecionada
		$busca_sub_rotina = mysql_query("SELECT * FROM cl_sub_rotina WHERE fk_cod_rotina = '$rt' ") or die("Não foi possivel localizar a sub-rotina. ". mysql_error());
		while($lista_anual = mysql_fetch_assoc($b))	{
			
		//faz a pesquisa se tem algo preenchido na data pedida
		$mes_atual = $lista_anual['cl_anual'];
		?>
		<p><?php echo $lista_rotina['nome_rotina'];?> - PERÍODO <?php echo $mes_atual.'/'.$ano; ?></p>
		<?php
		//busca as subrotinas da rotina selecionada
		$busca_sub_rotina = mysql_query("SELECT * FROM cl_sub_rotina WHERE fk_cod_rotina = '$rt' ") or die("Não foi possivel localizar a sub-rotina. ". mysql_error());
		while($lista_sub_rotina = mysql_fetch_assoc($busca_sub_rotina)){ ?>
            <table align="center" cellpadding="2" border="1">
            <tr>
                <td colspan="3" id="uper"><?php echo $lista_rotina['nome_rotina'];?></td>
            </tr>
            <tr>
                <td colspan="3" id="uper"><?php echo $lista_sub_rotina['nome_sub_rotina'];?></td>
            </tr>
            <tr>
                <td id="legenda" colspan="3">Legenda: N/A = Não se aplica.</td>
            </tr>
            <tr>
                <td width="85px" align="center">Nº da Ordem</td>
                <td>Descrição</td>
                <td width="75" align="center">Situação</td>
            </tr>
            <?php //busca os critérios da rotina
			$cod_sub_r = $lista_sub_rotina['cod_sub_rotina'];
			$busca_criterio = mysql_query("SELECT * FROM cl_criterio WHERE fk_cod_sub_rotina = '$cod_sub_r' ") or die("Não foi possivel localizar a rotina. ". mysql_error());
			$cont_criterio = 1;
			while($lista_criterio = mysql_fetch_assoc($busca_criterio)){
				
			//descobrir se existem sub_criterios
			$cod_criterio = $lista_criterio['cod_criterio'];
			$busca_sub_criterio = mysql_query("SELECT * FROM cl_sub_criterio WHERE fk_cod_criterio = '$cod_criterio' ") or die("Erro ao tentar localizar possivel sub_critério. ". mysql_error());
			$reg_sub_cri = mysql_num_rows($busca_sub_criterio);
			
			//busca resposta e observações critérios
			$busca_cl_preecher = mysql_query("SELECT * FROM cl_preencher WHERE cod_criterio = '$cod_criterio' AND YEAR(data_preenchimento) = '$ano' AND MONTH(data_preenchimento) = '$mes_atual' ") or die ("Não foi possivel localizar o codigo do criterio preenchido. ".mysql_error());
			$lista_cl_preencher_crit = mysql_fetch_assoc($busca_cl_preecher);
			$cod_pre_cl_preencher_crit = $lista_cl_preencher_crit['cod_preenchimento'];
			
			//busca imagens
			$busca_img_crit = mysql_query("SELECT * FROM cl_img WHERE fk_cod_preenchimento = '$cod_pre_cl_preencher_crit' ") or die ("Não foi possivel encontrar o código de preenchimento na tabela cl_img. ".mysql_error());
			$qtd_img_crit = mysql_num_rows($busca_img_crit);
			?>
            <tr>
            	<td align="center"><?php echo $cont_criterio++;?></td>
                <td><?php echo $lista_criterio['descricao'];
				if($reg_sub_cri == 0){
					$observacao = $lista_cl_preencher_crit['obs'];
					if($obs == 1 && $observacao != ""){
						echo '<div id="obs_crit"><img src="img/information.png"><font size="-1"><u>Observações:</u></font><br>'.$lista_cl_preencher_crit['obs'].'</div><hr>';	
					}
					if($img == 1 && $qtd_img_crit >= 1){
						echo '<div id="img_crit">';
						while($lista_img_crit = mysql_fetch_assoc($busca_img_crit)){?>
							<img src="/checklist/<?php echo $lista_img_crit['img'];?>" width="150px" >
						<?php }
						echo '</div>';
					}
				}
                ?>
                </td>
            <?php
				if($reg_sub_cri == 0){
					//não tem sub_criterio
					echo '<td><div id="resposta_crit">';
					switch($lista_cl_preencher_crit['resposta']){
						case "s":
							echo '<b>SIM</b>';
							break;
						case "n":
							echo '<b>NÃO</b>';
							break;
						default:
							echo '<b>N/A</b>';
					}
					echo '</div>';
					echo '</td>';
					echo '</tr>';
				}else{
					//tem sub_criterio	
					echo '<td>Itens<img src="img/baixo.jpg"></td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td></td>';
					echo '<td colspan="2">';
					$ol = 1;
					while($lista_sub_criterio = mysql_fetch_assoc($busca_sub_criterio)){
						//busca respostas e observações sub-criterios
						$cod_sub_criterio = $lista_sub_criterio['cod_sub_criterio'];
						$busca_cl_preecher_sub = mysql_query("SELECT * FROM cl_preencher WHERE cod_sub_criterio = '$cod_sub_criterio' AND MONTH(data_preenchimento) = '$mes_atual' ") or die ("Não foi possivel localizar o codigo do sub-criterio preenchido. ".mysql_error());
						$lista_cl_preencher_sub = mysql_fetch_assoc($busca_cl_preecher_sub);
						$cod_pre_cl_preencher_sub = $lista_cl_preencher_sub['cod_preenchimento'];
						if($img == 1){
							//busca imagens
							$busca_img = mysql_query("SELECT * FROM cl_img WHERE fk_cod_preenchimento = '$cod_pre_cl_preencher_sub' ") or die ("Não foi possivel encontrar o código de preenchimento na tabela cl_img. ".mysql_error());
							$qtd_img_sub_crit = mysql_num_rows($busca_img);
						}
						if($ol == 1){
							$ol = 0;
							echo '<ol style="list-style:lower-latin">';
       					}
						echo '<li>';
						echo $lista_sub_criterio['descricao_criterio'];
						echo '<div id="resposta_subcrit">';
						switch ($lista_cl_preencher_sub['resposta']){
							case "s":
								echo '<b>SIM</b>';
								break;
							case "n":
								echo '<b>NÃO</b>';
								break;
							default:
								echo '<b>N/A</b>';
						}
						echo '</div>';
						$observacao_sub = $lista_cl_preencher_sub['obs'];
						if($obs == 1 && $observacao_sub != ""){
							echo '<div id="obs"><img src="img/information.png"><font size="-1"><u>Observações:</u></font><br>'.$lista_cl_preencher_sub['obs'].'</div>';	
						}
						if($img == 1 && $qtd_img_sub_crit >= 1){
							echo '<br><div id="img">';
							while($lista_img = mysql_fetch_assoc($busca_img)){?>
								<img src="/checklist/<?php echo $lista_img['img'];?>" width="150px">
							<?php }
							echo '</div>';
						}
						echo '</li><hr>';
					}
					echo '</ol>';
					echo '</td>';
					echo '</tr>';
				}
			}//fim do while do lista_criterio			
			?>
            </table>
            <br>
	<?php }// fim do while do lista_sub_rotina 
		}	
	}
}else{
?>
        <title>Relatório <?php echo $lista_rotina['nome_rotina']; ?> Mensal - <?php echo $mes; ?> </title>
           	</head>
            <body>
			<p>CHECK LIST PARA ORIENTAÇÃO DO TRABALHO DE AUDITORIA</p>
            
            <?php while($t = mysql_fetch_assoc($todas)){
			
			//código da rotina
			$rt = $t['cod_rotina'];
			
            //busca as resposta do mes e ano escolhido
			$b = mysql_query("SELECT DISTINCT MONTH(data_preenchimento) as mes_atual FROM cl_preencher WHERE YEAR(data_preenchimento) = '$ano' AND MONTH(data_preenchimento) = '$mes' ") or die ("Não foi possivel localizar os registros com o ano e o mes escolhido. ".mysql_error());
			
			//busca a rotina selecionada
			$busca_rotina = mysql_query("SELECT * FROM cl_rotina WHERE cod_rotina = '$rt' ") or die("Não foi possivel localizar a rotina. ". mysql_error());
			$lista_rotina = mysql_fetch_assoc($busca_rotina);
			
			//busca as subrotinas da rotina selecionada
			$busca_sub_rotina = mysql_query("SELECT * FROM cl_sub_rotina WHERE fk_cod_rotina = '$rt' ") or die("Não foi possivel localizar a sub-rotina. ". mysql_error());
			
			while($lista_anual = mysql_fetch_assoc($b))	{
				
				//faz a pesquisa se tem algo preenchido na data pedida
				$mes_atual = $lista_anual['mes_atual'];
				?>
				<p><?php echo $lista_rotina['nome_rotina'];?> - PERÍODO <?php echo $mes_atual.'/'.$ano; ?></p>
				<?php
				//busca as subrotinas da rotina selecionada
				$busca_sub_rotina = mysql_query("SELECT * FROM cl_sub_rotina WHERE fk_cod_rotina = '$rt' ") or die("Não foi possivel localizar a sub-rotina. ". mysql_error());
             while($lista_sub_rotina = mysql_fetch_assoc($busca_sub_rotina)){?>
            <table align="center" cellpadding="2" border="1">
            <tr>
                <td colspan="3"><?php echo $lista_rotina['nome_rotina'];?></td>
            </tr>
            <tr>
                <td colspan="3"><?php echo $lista_sub_rotina['nome_sub_rotina'];?></td>
            </tr>
            <tr>
                <td id="legenda" colspan="3">Legenda: N/A = Não se aplica.</td>
            </tr>
            <tr>
                <td width="85px" align="center">Nº da Ordem</td>
                <td>Descrição</td>
                <td width="75" align="center">Situação</td>
            </tr>
            <?php //busca os critérios da rotina
			$cod_sub_r = $lista_sub_rotina['cod_sub_rotina'];
			$busca_criterio = mysql_query("SELECT * FROM cl_criterio WHERE fk_cod_sub_rotina = '$cod_sub_r' ") or die("Não foi possivel localizar a rotina. ". mysql_error());
			$cont_criterio = 1;
			while($lista_criterio = mysql_fetch_assoc($busca_criterio)){
				
			//descobrir se existem sub_criterios
			$cod_criterio = $lista_criterio['cod_criterio'];
			$busca_sub_criterio = mysql_query("SELECT * FROM cl_sub_criterio WHERE fk_cod_criterio = '$cod_criterio' ") or die("Erro ao tentar localizar possivel sub_critério. ". mysql_error());
			$reg_sub_cri = mysql_num_rows($busca_sub_criterio);
			
			//busca resposta e observações critérios
			$busca_cl_preecher = mysql_query("SELECT * FROM cl_preencher WHERE cod_criterio = '$cod_criterio' AND YEAR(data_preenchimento) = '$ano' AND MONTH(data_preenchimento) = '$mes' ") or die ("Não foi possivel localizar o codigo do criterio preenchido. ".mysql_error());
			$lista_cl_preencher_crit = mysql_fetch_assoc($busca_cl_preecher);
			$cod_pre_cl_preencher_crit = $lista_cl_preencher_crit['cod_preenchimento'];
			
			//busca imagens
			$busca_img_crit = mysql_query("SELECT * FROM cl_img WHERE fk_cod_preenchimento = '$cod_pre_cl_preencher_crit' ") or die ("Não foi possivel encontrar o código de preenchimento na tabela cl_img. ".mysql_error());
			$qtd_img_crit = mysql_num_rows($busca_img_crit);
			?>
            <tr>
            	<td align="center"><?php echo $cont_criterio++;?></td>
                <td><?php echo $lista_criterio['descricao'];
				$observacao = $lista_cl_preencher_crit['obs'];
				if($reg_sub_cri == 0 && $observacao != ""){
					if($obs == 1){
						echo '<div id="obs_crit"><img src="img/information.png"><font size="-1"><u>Observações:</u></font><br>'.$lista_cl_preencher_crit['obs'].'</div><hr>';
					}
					if($img == 1 && $qtd_img_crit >= 1){
						echo '<div id="img_crit">';
						while($lista_img_crit = mysql_fetch_assoc($busca_img_crit)){?>
							<img src="/checklist/<?php echo $lista_img_crit['img'];?>" width="150px" >
						<?php }
						echo '</div>';
					}
				}
                ?>
                </td>
            <?php
				if($reg_sub_cri == 0){
					//não tem sub_criterio
					echo '<td><div id="resposta_crit">';
					switch($lista_cl_preencher_crit['resposta']){
						case "s":
							echo '<b>SIM</b>';
							break;
						case "n":
							echo '<b>NÃO</b>';
							break;
						default:
							echo '<b>N/A</b>';
					}
					echo '</div>';
					echo '</td>';
					echo '</tr>';
				}else{
					//tem sub_criterio	
					echo '<td>Itens<img src="img/baixo.jpg"></td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td></td>';
					echo '<td colspan="2">';
					$ol = 1;
					while($lista_sub_criterio = mysql_fetch_assoc($busca_sub_criterio)){
						//busca respostas e observações sub-criterios
						$cod_sub_criterio = $lista_sub_criterio['cod_sub_criterio'];
						$busca_cl_preecher_sub = mysql_query("SELECT * FROM cl_preencher WHERE cod_sub_criterio = '$cod_sub_criterio' AND MONTH(data_preenchimento) = '$mes' ") or die ("Não foi possivel localizar o codigo do sub-criterio preenchido. ".mysql_error());
						$lista_cl_preencher_sub = mysql_fetch_assoc($busca_cl_preecher_sub);
						$cod_pre_cl_preencher_sub = $lista_cl_preencher_sub['cod_preenchimento'];
						if($img == 1){
							//busca imagens
							$busca_img = mysql_query("SELECT * FROM cl_img WHERE fk_cod_preenchimento = '$cod_pre_cl_preencher_sub' ") or die ("Não foi possivel encontrar o código de preenchimento na tabela cl_img. ".mysql_error());
							$qtd_img_sub_crit = mysql_num_rows($busca_img);
						}
						if($ol == 1){
							$ol = 0;
							echo '<ol style="list-style:lower-latin">';
       					}
						echo '<li>';
						echo $lista_sub_criterio['descricao_criterio'];
						echo '<div id="resposta_subcrit">';
						switch ($lista_cl_preencher_sub['resposta']){
							case "s":
								echo '<b>SIM</b>';
								break;
							case "n":
								echo '<b>NÃO</b>';
								break;
							default:
								echo '<b>N/A</b>';
						}
						echo '</div>';
						// vai ser usado ainda $lista_cl_preencher_sub['cod_preenchimento'];
						$observacao_sub = $lista_cl_preencher_sub['obs'];
						if($obs == 1 && $observacao_sub != ""){
							if($observacao != " "){
							echo '<div id="obs"><img src="img/information.png"><font size="-1"><u>Observações:</u></font><br>'.$lista_cl_preencher_sub['obs'].'teste</div>';
							}
						}
						if($img == 1 && $qtd_img_sub_crit >= 1){
							echo '<br><div id="img">';
							while($lista_img = mysql_fetch_assoc($busca_img)){?>
								<img src="/checklist/<?php echo $lista_img['img'];?>" width="150px">
							<?php }
							echo '</div>';
						}
						echo '</li><hr>';
					}
					echo '</ol>';
					echo '</td>';
					echo '</tr>';
				}	
			}//fim do while do lista_criterio			
			?>
            </table>
           	<br>
	<?php }// fim do while do lista_sub_rotina 	
	}
?>
<!--//-->
</body>
</html>
	<?php
		}
}
	//pra baixo ok	
}else{
	echo '<html>';
	echo '<head>';
	echo '<style>
                table{
                    width:100%;
                    border-color:#000000;
                    border-collapse:collapse;
                }
                #legenda{
                    text-align:right;
                }
                p{
                    text-align:center;
                }
				#resposta_crit{
					text-align:center;
				}
				#resposta_subcrit{
					margin-top:-20px;
					text-align:right;
					margin-right:10px;
				}
				#img, #img_crit{
					padding:5px;
				}
				#obs, #obs_crit, #img, #img_crit{
					border-color: #000000 #000000 #000000 #000000; 
					border-style: solid;
					border-top-width: 1px;
					border-right-width: 1px;
					border-bottom-width: 1px;
					border-left-width: 1px;
					border-radius:9px;
					padding:10px;
				}
				img{
					border-radius:9px;
				}
				p{
                    text-align:center;
					text-transform:uppercase;
                }
				#uper{
					text-transform:uppercase;
				}
            </style>';
			
		//busca os meses que receberam resposta 
		$b = mysql_query("SELECT distinct month(data_preenchimento) as cl_anual FROM cl_preencher WHERE YEAR(data_preenchimento) = '$ano' ORDER BY cl_anual ASC") or die ("Não foi possivel localizar a data de preenchimento. ".mysql_error());

		//busca a rotina selecionada
		$busca_rotina = mysql_query("SELECT * FROM cl_rotina WHERE cod_rotina = '$rot' ") or die("Não foi possivel localizar a rotina. ". mysql_error());
		$lista_rotina = mysql_fetch_assoc($busca_rotina);
			
		//busca as subrotinas da rotina selecionada
		$busca_sub_rotina = mysql_query("SELECT * FROM cl_sub_rotina WHERE fk_cod_rotina = '$rot' ") or die("Não foi possivel localizar a sub-rotina. ". mysql_error());		
		if($mes == 0){
			$qtd_data_anual = mysql_num_rows($b);
			if($qtd_data_anual == 0){
		?>
        	<title>Relatório <?php echo $lista_rotina['nome_rotina']; ?> Anual - <?php echo $ano; ?> </title>
           	</head>
            <body>
			<p>Não existem dados para o ano solicitado</p>
            <?php
            }else{
			?>
			<title>Relatório <?php echo $lista_rotina['nome_rotina']; ?> Anual - <?php echo $ano; ?> </title>
           	</head>
            <body>
			<p>CHECK LIST PARA ORIENTAÇÃO DO TRABALHO DE AUDITORIA</p><br>
        <?php
		while($lista_anual = mysql_fetch_assoc($b))	{
		//faz a pesquisa se tem algo preenchido na data pedida
		$mes_atual = $lista_anual['cl_anual'];
		?>
		<p>PERÍODO - <?php echo $mes_atual.'/'.$ano; ?></p>
		<?php
//busca as subrotinas da rotina selecionada
	$busca_sub_rotina = mysql_query("SELECT * FROM cl_sub_rotina WHERE fk_cod_rotina = '$rot' ") or die("Não foi possivel localizar a sub-rotina. ". mysql_error());
		while($lista_sub_rotina = mysql_fetch_assoc($busca_sub_rotina)){ ?>
            <table align="center" cellpadding="2" border="1">
            <tr>
                <td colspan="3"><?php echo $lista_rotina['nome_rotina'];?></td>
            </tr>
            <tr>
                <td colspan="3"><?php echo $lista_sub_rotina['nome_sub_rotina'];?></td>
            </tr>
            <tr>
                <td id="legenda" colspan="3">Legenda: N/A = Não se aplica.</td>
            </tr>
            <tr>
                <td width="85px" align="center">Nº da Ordem</td>
                <td>Descrição</td>
                <td width="75" align="center">Situação</td>
            </tr>
            <?php //busca os critérios da rotina
			$cod_sub_r = $lista_sub_rotina['cod_sub_rotina'];
			$busca_criterio = mysql_query("SELECT * FROM cl_criterio WHERE fk_cod_sub_rotina = '$cod_sub_r' ") or die("Não foi possivel localizar a rotina. ". mysql_error());
			$cont_criterio = 1;
			while($lista_criterio = mysql_fetch_assoc($busca_criterio)){
				
			//descobrir se existem sub_criterios
			$cod_criterio = $lista_criterio['cod_criterio'];
			$busca_sub_criterio = mysql_query("SELECT * FROM cl_sub_criterio WHERE fk_cod_criterio = '$cod_criterio' ") or die("Erro ao tentar localizar possivel sub_critério. ". mysql_error());
			$reg_sub_cri = mysql_num_rows($busca_sub_criterio);
			
			//busca resposta e observações critérios
			$busca_cl_preecher = mysql_query("SELECT * FROM cl_preencher WHERE cod_criterio = '$cod_criterio' AND YEAR(data_preenchimento) = '$ano' AND MONTH(data_preenchimento) = '$mes_atual' ") or die ("Não foi possivel localizar o codigo do criterio preenchido. ".mysql_error());
			$lista_cl_preencher_crit = mysql_fetch_assoc($busca_cl_preecher);
			$cod_pre_cl_preencher_crit = $lista_cl_preencher_crit['cod_preenchimento'];
			
			//busca imagens
			$busca_img_crit = mysql_query("SELECT * FROM cl_img WHERE fk_cod_preenchimento = '$cod_pre_cl_preencher_crit' ") or die ("Não foi possivel encontrar o código de preenchimento na tabela cl_img. ".mysql_error());
			$qtd_img_crit = mysql_num_rows($busca_img_crit);
			?>
            <tr>
            	<td align="center"><?php echo $cont_criterio++;?></td>
                <td><?php echo $lista_criterio['descricao'];
				if($reg_sub_cri == 0){
					$observacao = $lista_cl_preencher_crit['obs'];
					if($obs == 1 && $observacao != ""){
						echo '<div id="obs_crit"><img src="img/information.png"><font size="-1"><u>Observações:</u></font><br>'.$lista_cl_preencher_crit['obs'].'</div><hr>';
					}
					if($img == 1 && $qtd_img_crit >= 1){
						echo '<div id="img_crit">';
						while($lista_img_crit = mysql_fetch_assoc($busca_img_crit)){?>
							<img src="/checklist/<?php echo $lista_img_crit['img'];?>" width="150px" >
						<?php }
						echo '</div>';
					}
				}
                ?>
                </td>
            <?php
				if($reg_sub_cri == 0){
					//não tem sub_criterio
					echo '<td><div id="resposta_crit">';
					switch($lista_cl_preencher_crit['resposta']){
						case "s":
							echo '<b>SIM</b>';
							break;
						case "n":
							echo '<b>NÃO</b>';
							break;
						default:
							echo '<b>N/A</b>';
					}
					echo '</div>';
					echo '</td>';
					echo '</tr>';
				}else{
					//tem sub_criterio	
					echo '<td>Itens<img src="img/baixo.jpg"></td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td></td>';
					echo '<td colspan="2">';
					$ol = 1;
					while($lista_sub_criterio = mysql_fetch_assoc($busca_sub_criterio)){
						//busca respostas e observações sub-criterios
						$cod_sub_criterio = $lista_sub_criterio['cod_sub_criterio'];
						$busca_cl_preecher_sub = mysql_query("SELECT * FROM cl_preencher WHERE cod_sub_criterio = '$cod_sub_criterio' AND MONTH(data_preenchimento) = '$mes_atual' ") or die ("Não foi possivel localizar o codigo do sub-criterio preenchido. ".mysql_error());
						$lista_cl_preencher_sub = mysql_fetch_assoc($busca_cl_preecher_sub);
						$cod_pre_cl_preencher_sub = $lista_cl_preencher_sub['cod_preenchimento'];
						if($img == 1){
							//busca imagens
							$busca_img = mysql_query("SELECT * FROM cl_img WHERE fk_cod_preenchimento = '$cod_pre_cl_preencher_sub' ") or die ("Não foi possivel encontrar o código de preenchimento na tabela cl_img. ".mysql_error());
							$qtd_img_sub_crit = mysql_num_rows($busca_img);
						}
						if($ol == 1){
							$ol = 0;
							echo '<ol style="list-style:lower-latin">';
       					}
						echo '<li>';
						echo $lista_sub_criterio['descricao_criterio'];
						echo '<div id="resposta_subcrit">';
						switch ($lista_cl_preencher_sub['resposta']){
							case "s":
								echo '<b>SIM</b>';
								break;
							case "n":
								echo '<b>NÃO</b>';
								break;
							default:
								echo '<b>N/A</b>';
						}
						echo '</div>';
						$observacao_sub = $lista_cl_preencher_sub['obs'];
						if($obs == 1 && $observacao_sub != ""){
							echo '<div id="obs"><img src="img/information.png"><font size="-1"><u>Observações:</u></font><br>'.$lista_cl_preencher_sub['obs'].'</div>';	
						}
						if($img == 1 && $qtd_img_sub_crit >= 1){
							echo '<br><div id="img">';
							while($lista_img = mysql_fetch_assoc($busca_img)){?>
								<img src="/checklist/<?php echo $lista_img['img'];?>" width="150px">
							<?php }
							echo '</div>';
						}
						echo '</li><hr>';
					}
					echo '</ol>';
					echo '</td>';
					echo '</tr>';
				}
			}//fim do while do lista_criterio			
			?>
            </table>
            <br>
	<?php }// fim do while do lista_sub_rotina 
		}	
	}
	}else{
		  ?>
        <title>Relatório <?php echo $lista_rotina['nome_rotina']; ?> Mensal - <?php echo $mes; ?> </title>
           	</head>
            <body>
			<p>CHECK LIST PARA ORIENTAÇÃO DO TRABALHO DE AUDITORIA</p>
            <p><?php echo $lista_rotina['nome_rotina']; ?> - PERÍODO <?php echo $mes.'/'.$ano; ?></p>
            <?php while($lista_sub_rotina = mysql_fetch_assoc($busca_sub_rotina)){?>
            <table align="center" cellpadding="2" border="1">
            <tr>
                <td colspan="3" id="uper"><?php echo $lista_rotina['nome_rotina'];?></td>
            </tr>
            <tr>
                <td colspan="3" id="uper"><?php echo $lista_sub_rotina['nome_sub_rotina'];?></td>
            </tr>
            <tr>
                <td id="legenda" colspan="3">Legenda: N/A = Não se aplica.</td>
            </tr>
            <tr>
                <td width="85px" align="center">Nº da Ordem</td>
                <td>Descrição</td>
                <td width="75" align="center">Situação</td>
            </tr>
            <?php //busca os critérios da rotina
			$cod_sub_r = $lista_sub_rotina['cod_sub_rotina'];
			$busca_criterio = mysql_query("SELECT * FROM cl_criterio WHERE fk_cod_sub_rotina = '$cod_sub_r' ") or die("Não foi possivel localizar a rotina. ". mysql_error());
			$cont_criterio = 1;
			while($lista_criterio = mysql_fetch_assoc($busca_criterio)){
				
			//descobrir se existem sub_criterios
			$cod_criterio = $lista_criterio['cod_criterio'];
			$busca_sub_criterio = mysql_query("SELECT * FROM cl_sub_criterio WHERE fk_cod_criterio = '$cod_criterio' ") or die("Erro ao tentar localizar possivel sub_critério. ". mysql_error());
			$reg_sub_cri = mysql_num_rows($busca_sub_criterio);
			
			//busca resposta e observações critérios
			$busca_cl_preecher = mysql_query("SELECT * FROM cl_preencher WHERE cod_criterio = '$cod_criterio' AND YEAR(data_preenchimento) = '$ano' AND MONTH(data_preenchimento) = '$mes' ") or die ("Não foi possivel localizar o codigo do criterio preenchido. ".mysql_error());
			$lista_cl_preencher_crit = mysql_fetch_assoc($busca_cl_preecher);
			$cod_pre_cl_preencher_crit = $lista_cl_preencher_crit['cod_preenchimento'];
			
			//busca imagens
			$busca_img_crit = mysql_query("SELECT * FROM cl_img WHERE fk_cod_preenchimento = '$cod_pre_cl_preencher_crit' ") or die ("Não foi possivel encontrar o código de preenchimento na tabela cl_img. ".mysql_error());
			$qtd_img_crit = mysql_num_rows($busca_img_crit);
			?>
            <tr>
            	<td align="center"><?php echo $cont_criterio++;?></td>
                <td><?php echo $lista_criterio['descricao'];
				$observacao = $lista_cl_preencher_crit['obs'];
				if($reg_sub_cri == 0 && $observacao != ""){
					if($obs == 1){
						echo '<div id="obs_crit"><img src="img/information.png"><font size="-1"><u>Observações:</u></font><br>'.$lista_cl_preencher_crit['obs'].'</div><hr>';
					}
					if($img == 1 && $qtd_img_crit >= 1){
						echo '<div id="img_crit">';
						while($lista_img_crit = mysql_fetch_assoc($busca_img_crit)){?>
							<img src="/checklist/<?php echo $lista_img_crit['img'];?>" width="150px" >
						<?php }
						echo '</div>';
					}
				}
                ?>
                </td>
            <?php
				if($reg_sub_cri == 0){
					//não tem sub_criterio
					echo '<td><div id="resposta_crit">';
					switch($lista_cl_preencher_crit['resposta']){
						case "s":
							echo '<b>SIM</b>';
							break;
						case "n":
							echo '<b>NÃO</b>';
							break;
						default:
							echo '<b>N/A</b>';
					}
					echo '</div>';
					echo '</td>';
					echo '</tr>';
				}else{
					//tem sub_criterio	
					echo '<td>Itens<img src="img/baixo.jpg"></td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td></td>';
					echo '<td colspan="2">';
					$ol = 1;
					while($lista_sub_criterio = mysql_fetch_assoc($busca_sub_criterio)){
						//busca respostas e observações sub-criterios
						$cod_sub_criterio = $lista_sub_criterio['cod_sub_criterio'];
						$busca_cl_preecher_sub = mysql_query("SELECT * FROM cl_preencher WHERE cod_sub_criterio = '$cod_sub_criterio' AND MONTH(data_preenchimento) = '$mes' ") or die ("Não foi possivel localizar o codigo do sub-criterio preenchido. ".mysql_error());
						$lista_cl_preencher_sub = mysql_fetch_assoc($busca_cl_preecher_sub);
						$cod_pre_cl_preencher_sub = $lista_cl_preencher_sub['cod_preenchimento'];
						if($img == 1){
							//busca imagens
							$busca_img = mysql_query("SELECT * FROM cl_img WHERE fk_cod_preenchimento = '$cod_pre_cl_preencher_sub' ") or die ("Não foi possivel encontrar o código de preenchimento na tabela cl_img. ".mysql_error());
							$qtd_img_sub_crit = mysql_num_rows($busca_img);
						}
						if($ol == 1){
							$ol = 0;
							echo '<ol style="list-style:lower-latin">';
       					}
						echo '<li>';
						echo $lista_sub_criterio['descricao_criterio'];
						echo '<div id="resposta_subcrit">';
						switch ($lista_cl_preencher_sub['resposta']){
							case "s":
								echo '<b>SIM</b>';
								break;
							case "n":
								echo '<b>NÃO</b>';
								break;
							default:
								echo '<b>N/A</b>';
						}
						echo '</div>';
						// vai ser usado ainda $lista_cl_preencher_sub['cod_preenchimento'];
						$observacao = $lista_cl_preencher_sub['obs'];
						if($obs == 1 && $observacao != ""){
							echo '<div id="obs"><img src="img/information.png"><font size="-1"><u>Observações:</u></font><br>'.$lista_cl_preencher_sub['obs'].'teste</div>';
						}
						if($img == 1 && $qtd_img_sub_crit >= 1){
							echo '<br><div id="img">';
							while($lista_img = mysql_fetch_assoc($busca_img)){?>
								<img src="/checklist/<?php echo $lista_img['img'];?>" width="150px">
							<?php }
							echo '</div>';
						}
						echo '</li><hr>';
					}
					echo '</ol>';
					echo '</td>';
					echo '</tr>';
				}
			}//fim do while do lista_criterio			
			?>
          </table>
            <br>
	<?php }// fim do while do lista_sub_rotina 
	}
?>
<!--//-->
</div>
</body>
</html>
<?php
	}
?>
</textarea>
<input type="submit" value="Imprimir">
</form>