<?php
	if($_POST['envia']){
		//error_reporting(0);
		include('conecta.php');
		$modo_insercao = $_POST['modo_insercao'];
		$data_preenchimento = $_POST['data_preenchimento'];
		//separação de data
        $str = explode("-",$data_preenchimento);
        $dia = $str[2];
        $mes = $str[1];
        $ano = $str[0];		
		extract($_POST);
		foreach(array($rot) as $info1)
		foreach(array($subr) as $info2)
		foreach(array($cri) as $info3)
		foreach(array($subc) as $info4)
		foreach(array($res) as $info5)
		foreach(array($obs) as $info6)
		if($modo_insercao == "insere"){
			for($cont = 0; $cont < count($info1); $cont++){
				$insere = "insert into cl_preencher (data_preenchimento, cod_rotina, cod_sub_rotina, cod_criterio, cod_sub_criterio, resposta, obs) values ('$data_preenchimento','$info1[$cont]','$info2[$cont]','$info3[$cont]','$info4[$cont]','$info5[$cont]','$info6[$cont]')";
				//confirmar
				mysql_select_db($db, $con);
				$resultado = mysql_query($insere, $con) or die (mysql_error());
				if($resultado){
					?>
						<script type="text/javascript">
							alert ("Inserção concluída!");
							window.opener = window
							window.close("#")
						</script>
					<?php
				}else{
					?>
						<script type="text/javascript">
							alert ("A Inserção não pode ser concluída! Tente novamente");
							location.replace("responder.php");
						</script>
					<?php
				}	
			}
		}else{				
			for($cont = 0; $cont < count($info5); $cont++){
				echo $info6[$cont].'-'.
				$info5[$cont].'-'.
				$info4[$cont].'-'.
				$info3[$cont].'-'.
				$info2[$cont].'-'.
				$info1[$cont].'<br>';
				//$atualiza = ("UPDATE cl_preencher SET resposta = '$info5[$cont]', obs = '$info6[$cont]' WHERE month(data_preenchimento) = '$mes' and year(data_preenchimento) = '$ano' and cod_criterio = '$info3[$cont]' and cod_sub_criterio = '$info4[$cont]' ");
				//confirmar
				//mysql_select_db($db, $con);	
				//$resultado = mysql_query($atualiza, $con) or die (mysql_error());
			}
			if($resultado){
				/*?>
					<script type="text/javascript">
						alert ("Atualização efetuada com sucesso!");
						window.opener = window
						window.close("#")
					</script>
				<?php*/
			}else{
				?>
					<script type="text/javascript">
						alert ("A atualização não pode ser concluída! Tente novamente");
						//history.back(-2);
					</script>
				<?php
			}
		}	
	}
	mysql_close($con);
?>