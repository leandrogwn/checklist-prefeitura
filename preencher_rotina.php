<html>
<head>
	<title>Check List</title>
<!--<link rel="stylesheet" href="web_tools/litebox/css/lightbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="web_tools/litebox/js/prototype.lite.js"></script>
<script type="text/javascript" src="web_tools/litebox/js/moo.fx.js"></script>
<script type="text/javascript" src="web_tools/litebox/js/litebox-1.0.js"></script>-->

<script src="mootools.js" type="text/javascript"></script>
<script src="sexylightbox.js" type="text/javascript"></script>
<link rel="stylesheet" href="sexylightbox.css" type="text/css" media="all" />


<script type="text/javascript" src="functions.js"></script>
<link type="text/css" rel="stylesheet" href="web_tools/style.css" />

<style type="text/css">
	a {
		color:#333; text-decoration:none;
	}
	#li_sub_crit{
		margin-right:215px;
		text-align:justify;
	}
	
	a:hover {
		color:#ccc; text-decoration:none;
	}
	#check{
		margin-top:10px;
		margin-right:-215;
	}
	#td_crit{
		text-align:justify;
	}
	#miniatura{
		border-radius:8px;
		float:left;
		margin-top:-21px; 
	}
</style>
    <script>
		window.addEvent('domready', function() {
		//new SexyLightBox();
		new SexyLightBox({find:'sexylightbox', OverlayStyles:{'background-color':'#fff'},captionColor:'#FFF'});
    new SexyLightBox({find:'LGWhite', color:'white', hexcolor:'#FFFFFF', captionColor:'#000'});

		});
	</script>
</head>
    <body>

    <form action="salvar.php" method="POST" enctype="multipart/form-data">
    <?php
		error_reporting(0);
        include('conecta.php');
        //recebe dados do formulario
        $cod_rotina = $_POST['rotina'];
        $data_preenchimento = $_POST['data_preenchimento'];
        //separação de data
        $str = explode("-",$data_preenchimento);
        $dia = $str[2];
        $mes = $str[1];
        $ano = $str[0];
		//Começa a putaria :D
		//busca as subrotinas com o código da rotina
		$busca_sub_rotina = mysql_query("select * from cl_sub_rotina where fk_cod_rotina = '$cod_rotina'");
		//loop de todas as subrotinas da rotina selecionada
		$cont_radio = 1;
		while($lista_sub_rotina = mysql_fetch_assoc($busca_sub_rotina)){
			$cod_sub_rotina = $lista_sub_rotina['cod_sub_rotina'];
		echo '<fieldset style="background-color:#ededed">'; //primeiro fieldset
		echo '<table>'; //primeira tabela
		?>
		<input type="hidden" name="data_preenchimento" value="<?php echo $data_preenchimento?>"
		<tr>
			<td style="text-transform:uppercase; font-weight:bold; color:#665;"><?php  echo $lista_sub_rotina['nome_sub_rotina']; ?></td>	
		</tr>
		<tr>
		<?php
        //busca os criterios com o código da subrotina
        $busca_criterio = mysql_query ("select * from cl_criterio where fk_cod_sub_rotina = '$cod_sub_rotina'");
        //primeira linha do loop criterio
        $cont_crit = 1;
        echo '<table border="5" width="95%" align="center" bgcolor="#FFFFFF" bordercolor="#EEEEEE" style="border-radius:12px;">';
        ?>
                <tr bgcolor="#667667" style="color:#ffffff">
                    <td align="center" width="100px">Nº da Ordem</td>
                    <td>Descrição</td>
                    <td align="center" width="185px">Ações</td>
                </tr>
        <?php
        //loop de criterios com fk igual ao cod_sub_rotina
        while ($lista_criterio = mysql_fetch_assoc($busca_criterio)){
            $cod_criterio = $lista_criterio['cod_criterio'];
            //busca as subrotinas ja preenchidas
			$busca_preencher = mysql_query("select * from cl_preencher where month(data_preenchimento) = '$mes' and year(data_preenchimento) = '$ano' and cod_rotina = '$cod_rotina' and cod_sub_rotina = '$cod_sub_rotina' and cod_criterio = '$cod_criterio' "); 
			$resposta = mysql_fetch_assoc($busca_preencher);
			//começa a segunda putaria ^^
			$busca_sub_criterio = mysql_query("select * from cl_sub_criterio where fk_cod_criterio = '$cod_criterio'");
			$qtd_sub_criterio = mysql_num_rows($busca_sub_criterio); 
			//busca as imagens tabela cl_img
			$cod_preenchimento = $resposta['cod_preenchimento'];
			$busca_img = mysql_query("select * from cl_img where fk_cod_preenchimento = '$cod_preenchimento' ");
			$qtd_img = mysql_num_rows($busca_img);
			//verefica se existem registros com os dados atuais
			$qtd_registro = mysql_num_rows($busca_preencher);
            ?>
                <tr height="40px">
                    <td align="center"><?php echo $cont_crit; $cont_crit++ ?></td><?php //inicio e fim da coluna do contador de criterios ?>
                    <td id="td_crit"><?php echo $lista_criterio['descricao']; // inicio da coluna dos critérios ok?> 
                    <?php //estilo da div obs 
                            if($resposta['obs'] == ""){
                        ?>
                        <style>
                        #obs<?php echo $cont_radio; ?>{
                            display:none;
                            border:1px solid #d0d0d0;
                            border-radius:8px;
                            background:url(img/paper_fibers.png);
                            color:#333;	
                        }
                        </style>
                        <?php
                            }else{
                        ?>
                        <style>
                        #obs<?php echo $cont_radio; ?>{
                        display:block;
                        border:1px solid #d0d0d0;
                        border-radius:8px;
                        background:url(img/paper_fibers.png);
                        color:#333;	
                        }
                        </style>
                         <?php
                            }
                         //estilo da div img 
                            if($qtd_img == 0){
                        ?>
                        <style>
                        #img<?php echo $cont_radio; ?>{
                            display:none;
                            border:1px solid #d0d0d0;
                            border-radius:8px;
                            background:url(img/paper_fibers.png);
                            color:#333;	
                        }
                        </style>
                        <?php
                            }else{
                        ?>
                        <style>
                        #img<?php echo $cont_radio; ?>{
                        display:block;
                        border:1px solid #d0d0d0;
                        border-radius:8px;
                        background:url(img/paper_fibers.png);
                        color:#333;
                        margin-top:5px;
                        }
                        </style>
                         <?php
                            }
                        ?>
                        <style>
                        #btn<?php echo $cont_radio; ?>{
                            display:none;
                            border:1px solid #d0d0d0;
                            border-radius:8px;
                            background:url(img/paper_fibers.png);
                            color:#333;	
                        }
                        </style>
                        <?php 
                                //se quantidade de subcriterios for diferente de 0 significa que a textarea do
                                //critério em foco não precisa ser criada
                                if($qtd_sub_criterio == 0){
                           ?>
                        <?php //div das obs ?>
                        <div align="left" id="obs<?php echo $cont_radio; ?>">
                            <div align="left" ><img src="img/information.png"><font color="#999999"><font size="-1">Observações</font></font></div>
                            <div align="right" style="margin-top:-15px; margin-bottom:-15px;">
                            <a href="#" onclick="document.getElementById('obs<?php echo $cont_radio; ?>').style.display='none';"><img src="img/icone_fechar.png" title="Minimizar as observações"></a></div><br>
                            <div align="left"><textarea name="obs[]" id="txtobs<?php echo $cont_radio; ?>" style="border:none; background:url(img/paper_fibers.png); width:100%; height:auto;" autofocus placeholder="Insira uma observação"><?php echo $resposta['obs']; ?></textarea></div>
                        </div>
                            <?php
                                }
                                if($qtd_sub_criterio == 0){
                            ?>
                            
                        <?php //div das img ?>
                        <div align="left" id="img<?php echo $cont_radio; ?>"><br>                        
                            <div align="right" style="margin-top:-15px; margin-bottom:-15px;">
                            <a href="#" onclick="document.getElementById('img<?php echo $cont_radio; ?>').style.display='none';"><img src="img/icone_fechar.png" title="Minimizar as imagens"></a></div><br>
                           
                            <div align="left" style="height:30px; background:url(img/paper_fibers.png);">
                                <?php
                                    //busca e loop das imagens em miniatura
                                    while($lista_img = mysql_fetch_assoc($busca_img)){
                                        ?>
                                        
                                        <a href="<?php echo $lista_img['img'];?>"  class="LGWhite" rel="<?php echo $lista_img['fk_cod_preenchimento'];?>" title="<?php echo $lista_img['titulo'];?>"><img src="<?php echo $lista_img['img'];?>" id="miniatura" width="30" height="30" style="padding:3px;" alt="Clique para ampliar" /></a>
										<a href="delimagem.php?apagar=<?php echo $lista_img['cod_img']; ?>" onClick="return confirm('Deseja realmente apagar esta imagem?');"><img id="ex_ima" src="img/2815_16x16.png" title="Excluir imagem"></a>
   
                                        <?php
                                    }
                                    //resto do código aqui=							
                                ?>   
                            </div>
                        </div><?php 
                                }
                        ?>   
                    </td> <?php // fim da coluna da descrição dos critérios... ok ?>
                    <?php
                        if ($qtd_sub_criterio == 0 ){ // revisar ####################################### revisar linha
                    ?>
                    <td align="center" width="195px"> <?php //inicio da coluna dos radios... ok?>
                    <?php 
                        //se não houver ocorrencias de preenchimento no mes em foco inclui os radios padrões
                        if($qtd_registro == 0){
                    ?>
                        <input type="hidden" name="rot[]" value="<?php echo $cod_rotina?>">
                        <input type="hidden" name="subr[]" value="<?php echo $cod_sub_rotina?>">
                        <input type="hidden" name="cri[]" value="<?php echo $cod_criterio?>">
                        <input type="hidden" name="subc[]" value="">
                        <input type="hidden" name="res[]" id="d<?php echo '1000'.$cont_radio?>"> 
                        <input type="radio" name="<?php echo '1000'.$cont_radio?>" value="s" id= "<?php echo $cont_radio?>" onClick="fun('s',<?php echo '1000'.$cont_radio?>)">S
                        <input type="radio" name="<?php echo '1000'.$cont_radio?>" value="n" id= "<?php echo $cont_radio?>" onClick="fun('n',<?php echo '1000'.$cont_radio?>)">N
                        <input type="radio" name="<?php echo '1000'.$cont_radio?>" value="na" id= "<?php echo $cont_radio?>" checked="checked" onClick="fun('na',<?php echo '1000'.$cont_radio?>)">N/A
                        <script>
                            window.onload = fun('na',<?php echo '1000'.$cont_radio?>);
                        </script>
                        <?php //mostrar textarea obs ?>
                        <a href="#" onclick="document.getElementById('obs<?php echo $cont_radio; ?>').style.display='block';"><img src="img/comment.png" title="Inserir observação" style="margin-top:3px; margin-bottom:-3px;"></a>
                    <?php            			
                }else{
                //variavel res recebe a opção salva para o critério sendo s,n ou na
                $res = $resposta['resposta'];
                switch($res){
                    case "s":
                        ?>
                            <script>
                                function fun<?php echo $cont_radio?>(obj){
                                    document.getElementById("d<?php echo $cont_radio?>").value = obj;	
                                }
                            </script>
                            <input type="hidden" name="rot[]" value="<?php echo $cod_rotina?>">
                            <input type="hidden" name="subr[]" value="<?php echo $cod_sub_rotina?>">
                            <input type="hidden" name="cri[]" value="<?php echo $cod_criterio?>">
                            <input type="hidden" name="subc[]" value="">
                            <input type="hidden" name="res[]" id="d<?php echo '1000'.$cont_radio?>">
                            <input type="radio" name="<?php echo '1000'.$cont_radio?>" value="s" id= "<?php echo $cont_radio?>" checked="checked" onClick="fun('s',<?php echo '1000'.$cont_radio?>)">S
                            <input type="radio" name="<?php echo '1000'.$cont_radio?>" value="n" id= "<?php echo $cont_radio?>" onClick="fun('n',<?php echo '1000'.$cont_radio?>)">N
                            <input type="radio" name="<?php echo '1000'.$cont_radio?>" value="na" id= "<?php echo $cont_radio?>" onClick="fun('na',<?php echo '1000'.$cont_radio?>)">N/A	
                            <script>
                            	window.onload = fun('s',<?php echo '1000'.$cont_radio?>);
                            </script>
                            <?php //mostrar textarea obs ?>
                            <a href="#" onclick="document.getElementById('obs<?php echo $cont_radio; ?>').style.display='block';"><img src="img/comment.png" title="Inserir observação" style="margin-top:3px; margin-bottom:-3px;"></a>
                            <?php //mostrar botão add img ?>
                           <a href="inserir_img.php?r=<?php echo $cod_rotina;?>&cp=<?php echo $cod_preenchimento;?>" target="_self"><img src="img/insert_image.png" title="Inserir imagem" style="margin-top:3px; margin-bottom:-3px;"></a>
                        
                        <?php
                        break;
                    case "n":
                        ?>
                                        
                            <input type="hidden" name="rot[]" value="<?php echo $cod_rotina?>">
                            <input type="hidden" name="subr[]" value="<?php echo $cod_sub_rotina?>">
                            <input type="hidden" name="cri[]" value="<?php echo $cod_criterio?>">
                            <input type="hidden" name="subc[]" value="">
                            <input type="hidden" name="res[]" id="d<?php echo '1000'.$cont_radio?>">  
                            <input type="radio" name="<?php echo '1000'.$cont_radio?>" value="s" id= "<?php echo $cont_radio?>" onClick="fun('s',<?php echo '1000'.$cont_radio?>)">S
                            <input type="radio" name="<?php echo '1000'.$cont_radio?>" value="n" id= "<?php echo $cont_radio?>" checked="checked" onClick="fun('n',<?php echo '1000'.$cont_radio?>)">N
                            <input type="radio" name="<?php echo '1000'.$cont_radio?>" value="na" id= "<?php echo $cont_radio?>" onClick="fun('na',<?php echo '1000'.$cont_radio?>)">N/A	
                            <script>
                            	window.onload = fun('n',<?php echo '1000'.$cont_radio?>);
                            </script>       
                            <?php //Mostra textarea obs ?>
                            <a href="#" onclick="document.getElementById('obs<?php echo $cont_radio; ?>').style.display='block';"><img src="img/comment.png" title="Inserir observação" style="margin-top:3px; margin-bottom:-3px;"></a>
                            <?php //Mostra botão add imagem ?>
                            <a href="inserir_img.php?r=<?php echo $cod_rotina?>&cp=<?php echo $cod_preenchimento?>" target="_self"><img src="img/insert_image.png" title="Inserir imagem" style="margin-top:3px; margin-bottom:-3px;"></a>
                        <?php
                        break;
                    default:		
                        ?>
                            <script>
							
                                function fun<?php echo $cont_radio?>(obj){
                                    document.getElementById("d<?php echo $cont_radio?>").value = obj;	
                                }
                            </script>
                            <? //criterios ** ?>
                           <input type="hidden" name="rot[]" value="<?php echo $cod_rotina?>">
                            <input type="hidden" name="subr[]" value="<?php echo $cod_sub_rotina?>">
                            <input type="hidden" name="cri[]" value="<?php echo $cod_criterio?>">
                            <input type="hidden" name="subc[]" value="">
                            <input type="hidden" name="res[]" id="d<?php echo '1000'.$cont_radio?>"> 
                            <input type="radio" name="<?php echo '1000'.$cont_radio?>" value="s" id= "<?php echo $cont_radio?>" onClick="fun('s',<?php echo '1000'.$cont_radio?>)">S
                            <input type="radio" name="<?php echo '1000'.$cont_radio?>" value="n" id= "<?php echo $cont_radio?>" onClick="fun('n',<?php echo '1000'.$cont_radio?>)">N
                            <input type="radio" name="<?php echo '1000'.$cont_radio?>" value="na" id= "<?php echo $cont_radio?>" checked="checked" onClick="fun('na',<?php echo '1000'.$cont_radio?>)">N/A
                            <script>
                                window.onload = fun('na',<?php echo '1000'.$cont_radio?>);
                            </script>
                            <?php //Mostra textarea obs ?>
                            <a href="#" onclick="document.getElementById('obs<?php echo $cont_radio; ?>').style.display='block';"><img src="img/comment.png" title="Inserir observação" style="margin-top:3px; margin-bottom:-3px;"></a>
                            
                           <?php //Mostra botão add imagem ?>
                           <a href="inserir_img.php?r=<?php echo $cod_rotina;?>&cp=<?php echo $cod_preenchimento;?>" target="_self"><img src="img/insert_image.png" title="Inserir imagem" style="margin-top:3px; margin-bottom:-3px;"></a>
                        <?php
                    }
            }
            ?>
            </td> <?php //finaliza a terceira coluna, coluna de radio buttons... ok?>
    <?php
        }else{
    ?>
        <td align="center">Sub-Critérios&nbsp;<img src="img/baixo.jpg"></td> <?php //caso tenha subcriterios não inclui os radios, inclui o texto e passa para uma nova linha... ok ?>
        </tr> <?php //fecha a linha do critério... ok ?>
        <tr><?php //inicia uma nova linha para os subcritérios... ?>
            <td></td><?php  //inicia e termina uma nova coluna vazia... ok?>
                    <td colspan="2"><?php //inicia uma nova coluna para os subcritérios ?>
                        <?php
                        $ol = 1;
						$cont_sub_crit = 1;
                            while($lista_sub_criterio = mysql_fetch_assoc($busca_sub_criterio)){
                                $cod_sub_criterio = $lista_sub_criterio['cod_sub_criterio'];
                                if($ol == 1){
                                    $ol = 0;
                                    echo '<ol style="list-style:lower-latin">';
        }
                                    ?>
                                        <li id="li_sub_crit">
                                            <?php echo $lista_sub_criterio['descricao_criterio']; ?>
                                        <div id="rescrit" style="width:550px;"> <?php //inicio primeira div?>
                                            <?php //Inicio ?>
                                            <div align="left">
                                            <?php
                                                $busca_preencher_sub_crit = mysql_query("select * from cl_preencher where month(data_preenchimento) = '$mes' and year(data_preenchimento) = '$ano' and cod_rotina = '$cod_rotina' and cod_sub_rotina = '$cod_sub_rotina' and cod_criterio = '$cod_criterio' and cod_sub_criterio = '$cod_sub_criterio'"); 
                                                $resposta_sub_crit = mysql_fetch_assoc($busca_preencher_sub_crit); 
                                                //busca as imagens tabela cl_img
                                                $cod_preenchimento_sub_crit = $resposta_sub_crit['cod_preenchimento'];
                                                $busca_img_sub_crit = mysql_query("select * from cl_img where fk_cod_preenchimento = '$cod_preenchimento_sub_crit' ");
                                                $qtd_img_sub_crit = mysql_num_rows($busca_img_sub_crit);
                                                //verefica se existem registros com os dados atuais
                                                $qtd_registro_sub_crit = mysql_num_rows($busca_preencher_sub_crit);
                                                                
                                                 //Stilo da div obs 
                                                        if($resposta_sub_crit['obs'] == ""){
                                                    ?>
                                                    <style>
                                                    #obs_sc<?php echo $cont_radio.$cont_sub_crit; ?>{
                                                        display:none;
                                                        border:1px solid #d0d0d0;
                                                        border-radius:8px;
                                                        background:url(img/paper_fibers.png);
                                                        color:#333;	
                                                        width:550px;
                                                        margin-top:30px;
                                                        margin-bottom:-30px;	
                                                    }
                                                    </style>
                                                    <?php
                                                        }else{
                                                    ?>
                                                    <style>
                                                    #obs_sc<?php echo $cont_radio.$cont_sub_crit; ?>{
                                                        display:block;
                                                        border:1px solid #d0d0d0;
                                                        border-radius:8px;
                                                        background:url(img/paper_fibers.png);
                                                        color:#333;
                                                        width:550px;
                                                        margin-top:30px;
                                                        margin-bottom:-30px;																																																				
                                                    }
                                                    </style>
                                                     <?php
                                                        }
                                                     //Stilo da div img 
                                                        if($qtd_img_sub_crit == 0){
                                                    ?>
                                                    <style>
                                                    #imgsc<?php echo $cont_radio.$cont_sub_crit; ?>{
                                                        display:none;
                                                        border:1px solid #d0d0d0;
                                                        border-radius:8px;
                                                        background:url(img/paper_fibers.png);
                                                        color:#333;	
                                                        
                                                    }
                                                    </style>
                                                    <?php
                                                        }else{
                                                    ?>
                                                    <style>
                                                    #imgsc<?php echo $cont_radio.$cont_sub_crit; ?>{
                                                    display:block;
                                                    border:1px solid #d0d0d0;
                                                    border-radius:8px;
                                                    background:url(img/paper_fibers.png);
                                                    color:#333;
                                                    width:550px;
                                                    margin-top:35px;
                                                    height:45px;
                                                    }
                                                    </style>
                                                     <?php
                                                        }
                                                    ?>
                                                    
                                                    <style>
                                                    #btn_sc<?php echo $cont_radio.$cont_sub_crit; ?>{
                                                        display:none;
                                                        border:1px solid #d0d0d0;
                                                        border-radius:8px;
                                                        background:url(img/paper_fibers.png);
                                                        color:#333;	
                                                    }	
                                                    </style>
                                                    <?php //div das obs ?>
                                                    <div align="left" id="obs_sc<?php echo $cont_radio.$cont_sub_crit; ?>">
                                                        <div align="left" ><img src="img/information.png"><font color="#999999"><font size="-1">Observações</font></font></div>
                                                        <div align="right" style="margin-top:-15px; margin-bottom:-15px;">
                                                        <a href="#" onclick="document.getElementById('obs_sc<?php echo $cont_radio.$cont_sub_crit; ?>').style.display='none';"><img src="img/icone_fechar.png" title="Minimizar as observações"></a></div><br>
                                                        <div align="left"><textarea name="obs[]" id="txtobs<?php echo $cont_radio.$cont_sub_crit; ?>" style="border:none; background:url(img/paper_fibers.png); width:100%; height:auto;" autofocus placeholder="Insira uma observação"><?php echo $resposta_sub_crit['obs']; ?></textarea></div>
                                                    </div>
                                                    
                                                    <?php //div das img ?>
                                                    <div align="left" id="imgsc<?php echo $cont_radio.$cont_sub_crit; ?>" style="height:60px;"><br>													
                                                        <div align="right" style=" margin-bottom:-12px;">
                                                        <a href="#" onclick="document.getElementById('imgsc<?php echo $cont_radio.$cont_sub_crit; ?>').style.display='none';"><img src="img/icone_fechar.png" title="Minimizar as imagens" style="margin-bottom:-20px;"></a></div><br>
                                                       
                                                        <div align="left">
                                                        <?php
                                                            //busca e loop das imagens em miniatura
                                                            while($lista_img_sub_crit = mysql_fetch_assoc($busca_img_sub_crit)){
                                                                //echo ' <img src="img/barra_v.png" height="30px">'; //barra vertical
                                                         ?>
                                                         
                                                         <a href="<?php echo $lista_img_sub_crit['img'];?>"  class="LGWhite" rel="<?php echo $lista_img_sub_crit['fk_cod_preenchimento'];?>" title="<?php echo $lista_img_sub_crit['titulo'];?>"><img src="<?php echo $lista_img_sub_crit['img'];?>" id="miniatura" width="30" height="30" style="padding:3px;" alt="Clique para ampliar" /></a>
														 <a href="delimagem.php?apagar=<?php echo $lista_img_sub_crit['cod_img']; ?>" onClick="return confirm('Deseja realmente apagar esta imagem?');"><img id="ex_ima" src="img/2815_16x16.png" title="Excluir imagem"></a>

                                                        <?php										
                                                        }
                                                    ?>
                                                </div>
                                            </div>														
                                        </div>
                                    </div>
                    <div id="check" align="right">
                    <?php
                    //se não houve nenhuma alteração no mes em foco inclui os radiobuttons padrão
                    if($qtd_registro_sub_crit == 0){
                    ?>												
                    <input type="hidden" name="rot[]" value="<?php echo $cod_rotina?>">
                    <input type="hidden" name="subr[]" value="<?php echo $cod_sub_rotina?>">
                    <input type="hidden" name="cri[]" value="<?php echo $cod_criterio?>">
                    <input type="hidden" name="subc[]" value="<?php echo $cod_sub_criterio?>">
                    <input type="hidden" name="res[]" id="d<?php echo $cont_radio.$cont_sub_crit?>"> 
                    <input type="radio" name="<?php echo $cont_radio.$cont_sub_crit?>" value="s" id= "<?php echo $cont_radio.$cont_sub_crit?>" onClick="fun('s',<?php echo $cont_radio.$cont_sub_crit?>)">S
                    <input type="radio" name="<?php echo $cont_radio.$cont_sub_crit?>" value="n" id= "<?php echo $cont_radio.$cont_sub_crit?>" onClick="fun('n',<?php echo $cont_radio.$cont_sub_crit?>)">N
                    <input type="radio" name="<?php echo $cont_radio.$cont_sub_crit?>" value="na" id= "<?php echo $cont_radio.$cont_sub_crit?>" checked="checked" onClick="fun('na',<?php echo $cont_radio.$cont_sub_crit?>)">N/A
                    <script>
                        window.onload = fun('na',<?php echo $cont_radio.$cont_sub_crit?>);
                    </script>
                <?php //mostrar textarea das img ?>
                <a href="#" onclick="document.getElementById('obs_sc<?php echo $cont_radio.$cont_sub_crit?>').style.display='block';"><img src="img/comment.png" title="Inserir observação" style="margin-top:3px; margin-bottom:-3px;"></a>
                <?php      
				$cont_sub_crit++;      			
    }else{
        //variavel res recebe o valor contido na entidade resposta pode ser s,n ou na
        echo '<div align="right" style="width:195px; margin-top:-30px;">';
        $res_sub_crit = $resposta_sub_crit['resposta'];
        switch($res_sub_crit){
            case "s":
                ?>
                    <input type="hidden" name="rot[]" value="<?php echo $cod_rotina?>">
                    <input type="hidden" name="subr[]" value="<?php echo $cod_sub_rotina?>">
                    <input type="hidden" name="cri[]" value="<?php echo $cod_criterio?>">
                    <input type="hidden" name="subc[]" value="<?php echo $cod_sub_criterio?>">
                    <input type="hidden" name="res[]" id="d<?php echo $cont_radio.$cont_sub_crit?>"> 
                    <input type="radio" name="<?php echo $cont_radio.$cont_sub_crit?>" value="s" id= "<?php echo $cont_radio.$cont_sub_crit?>" checked="checked" onClick="fun('s',<?php echo $cont_radio.$cont_sub_crit?>)">S
                    <input type="radio" name="<?php echo $cont_radio.$cont_sub_crit?>" value="n" id= "<?php echo $cont_radio.$cont_sub_crit?>" onClick="fun('n',<?php echo $cont_radio.$cont_sub_crit?>)">N
                    <input type="radio" name="<?php echo $cont_radio.$cont_sub_crit?>" value="na" id= "<?php echo $cont_radio.$cont_sub_crit?>" onClick="fun('na',<?php echo $cont_radio.$cont_sub_crit?>)">N/A	
                    <script>
                    	window.onload = fun('s',<?php echo $cont_radio.$cont_sub_crit?>);
                    </script> 
                <?php //mostrar textarea das img ?>
                <a href="#" onclick="document.getElementById('obs_sc<?php echo $cont_radio.$cont_sub_crit?>').style.display='block';"><img src="img/comment.png" title="Inserir observação" style="margin-top:3px; margin-bottom:-3px;"></a>
                <?php //mostrar botão add img ?>
               <a href="inserir_img.php?r=<?php echo $cont_radio.$cont_sub_crit?>&cp=<?php echo $cod_preenchimento_sub_crit?>"><img src="img/insert_image.png" title="Inserir imagem" style="margin-top:3px; margin-bottom:-3px;"></a>
                <?php
                break;
            case "n":
                ?>           
                    <input type="hidden" name="rot[]" value="<?php echo $cod_rotina?>">
                    <input type="hidden" name="subr[]" value="<?php echo $cod_sub_rotina?>">
                    <input type="hidden" name="cri[]" value="<?php echo $cod_criterio?>">
                    <input type="hidden" name="subc[]" value="<?php echo $cod_sub_criterio?>">
                    <input type="hidden" name="res[]" id="d<?php echo $cont_radio.$cont_sub_crit?>">  
                    <input type="radio" name="<?php echo $cont_radio.$cont_sub_crit?>" value="s" id= "<?php echo $cont_radio.$cont_sub_crit?>" onClick="fun('s',<?php echo $cont_radio.$cont_sub_crit?>)">S
                    <input type="radio" name="<?php echo $cont_radio.$cont_sub_crit?>" value="n" id= "<?php echo $cont_radio.$cont_sub_crit?>" checked="checked" onClick="fun('n',<?php echo $cont_radio.$cont_sub_crit?>)">N
                    <input type="radio" name="<?php echo $cont_radio.$cont_sub_crit?>" value="na" id= "<?php echo $cont_radio.$cont_sub_crit?>" onClick="fun('na',<?php echo $cont_radio.$cont_sub_crit?>)">N/A	
                    <script>
                    	window.onload = fun('n',<?php echo $cont_radio.$cont_sub_crit?>);
                    </script>
                <?php //mostrar textarea obs ?>
                <a href="#" onclick="document.getElementById('obs_sc<?php echo $cont_radio.$cont_sub_crit?>').style.display='block';"><img src="img/comment.png" title="Inserir observação" style="margin-top:3px; margin-bottom:-3px;"></a>
                <?php //mostrar botão add img ?>
                <a href="inserir_img.php?r=<?php echo $cod_rotina?>&cp=<?php echo $cod_preenchimento_sub_crit?>" target="_self"><img src="img/insert_image.png" title="Inserir imagem" style="margin-top:3px; margin-bottom:-3px;"></a>
                <?php
                break;
            default:		
                ?>
                    <? //subcriterios ?>
                   <input type="hidden" name="rot[]" value="<?php echo $cod_rotina?>">
                    <input type="hidden" name="subr[]" value="<?php echo $cod_sub_rotina?>">
                    <input type="hidden" name="cri[]" value="<?php echo $cod_criterio?>">
                    <input type="hidden" name="subc[]" value="<?php echo $cod_sub_criterio?>">
                    <input type="hidden" name="res[]" id="d<?php echo $cont_radio.$cont_sub_crit?>"> 
                    <input type="radio" name="<?php echo $cont_radio.$cont_sub_crit?>" value="s" id= "<?php echo $cont_radio.$cont_sub_crit?>" onClick="fun('s',<?php echo $cont_radio.$cont_sub_crit?>)">S
                    <input type="radio" name="<?php echo $cont_radio.$cont_sub_crit?>" value="n" id= "<?php echo $cont_radio.$cont_sub_crit?>" onClick="fun('n',<?php echo $cont_radio.$cont_sub_crit?>)">N
                    <input type="radio" name="<?php echo $cont_radio.$cont_sub_crit?>" value="na" id= "<?php echo $cont_radio.$cont_sub_crit?>" checked="checked" onClick="fun('na',<?php echo $cont_radio.$cont_sub_crit?>)">N/A
                    <script>
                    	 window.onload = fun('na',<?php echo $cont_radio.$cont_sub_crit?>);
                    </script>
                <?php //mostrar textarea obs ?>
                <a href="#" onclick="document.getElementById('obs_sc<?php echo $cont_radio.$cont_sub_crit?>').style.display='block';"><img src="img/comment.png" title="Inserir observação" style="margin-top:3px; margin-bottom:-3px;"></a>
               <?php //mostrar botão add img ?>
               <a href="inserir_img.php?r=<?php echo $cod_rotina;?>&cp=<?php echo $cod_preenchimento_sub_crit?>" target="_self"><img src="img/insert_image.png" title="Inserir imagem" style="margin-top:3px; margin-bottom:-3px;"></a>
                <?php
            }    
			$cont_sub_crit++;   
   		}
    ?>    
                    </li>
               <hr/>  
            <?php
            	
            }
            echo '</ol>';             
            ?>
    </td> 
    <?php
        }
    ?>
    </tr>
    <?php   
    $cont_radio++;  
    }
    echo '</table>'; //fim segunda tabela
    ?>
    <?php
    echo '</table>'; //fim primeira tabela
    echo '</fieldset>'; //fim segundo fieldset
    echo '<br>';
    }
    $botao = 1;
    if($qtd_registro == 0){
        ?>
        <input type="hidden" name="cont_radio" value="<?php echo $cont_radio; ?>">
        <input type="hidden" name="modo_insercao" value="insere">
        <script>
            alert ("Este mês ainda não recebeu nenhuma alteração");
        </script>
    <?php
        $botao = 0;
    }else{
    ?>
        <input type="hidden" name="modo_insercao" value="atualiza">
    <?php
    }
    if($botao == 0){
    ?>
    </div> 
        <input type="submit" name="envia" value="Inserir Check-List" />
    </form>
    <p>
      <?php
        }else{
    ?>
      <input type="submit" name="envia" value="Atualizar Check-List" />
      </form>
      <?php
        }
    ?>
    </p>
    </div> 
   
    </body>
</html>