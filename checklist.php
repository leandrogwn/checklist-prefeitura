<!DOCTYPE html>
<html lang="pt-br">
	<head>
    <?php // header("Content-Type: text/html; charset=utf-8",true); ?>
    <?php
		//Header('Cache-Control: no-cache');
		//Header('Pragma: no-cache');
	?>
		<meta charset="utf-8" />
		<title>Check List</title>
		<link type="text/css" rel="stylesheet" href="web_tools/reset.css" />
		<link type="text/css" rel="stylesheet" href="web_tools/style.css" />
	<script>
		function ancora() {		
			this.location = "#base";		
		}		
		</script>
    </head>
	<body onLoad="ancora();">
		<?php
		include ("conecta.php");
		include ("topo.php");
		error_reporting(0);
		?>
		<fieldset>
			<div id="sub_rotina">
				<?php $busca_rot = mysql_query("SELECT * FROM cl_rotina") or die("Não foi possivel buscar rotinas no banco de dados. " . mysql_error());
				$reg_rot = mysql_num_rows($busca_rot);
				?>
				<?php
$cont_rot = 1;
while($linha_rot = mysql_fetch_assoc($busca_rot)){
//inicio rotina
				?>
				<table width="100%">
					<tr>
						<td>
						<div id="rot_span">
							<?php echo $cont_rot . '. ' . $linha_rot['nome_rotina']; ?>
						</div><?php //fim rotina
								//inicio subrotina
								$cod_fk_rotina = $linha_rot['cod_rotina'];
								$busca_sub_rot = mysql_query("SELECT * FROM cl_sub_rotina WHERE fk_cod_rotina = '$cod_fk_rotina'") or die("Não foi possivel carregar as subrotinas da base de dados. " . mysql_error());
								$reg_sub_rot = mysql_num_rows($busca_sub_rot);
						?>
						<fieldset>
							<table width="100%">
								<?php
$cont_sub_rot = 1;
while($linha_sub_rot = mysql_fetch_assoc($busca_sub_rot)){
								?>
								<tr>
									<td>
									<div id="subrot_span">
										<?php echo $cont_rot . '.' . $cont_sub_rot . ' ' . $linha_sub_rot['nome_sub_rotina']; ?>
									</div><?php //fim subrotina
											//inicio critérios
											$cod_fk_sub_rotina = $linha_sub_rot['cod_sub_rotina'];
											$busca_criterio = mysql_query("SELECT * FROM cl_criterio WHERE fk_cod_sub_rotina = '$cod_fk_sub_rotina'") or die("Não foi possivel carregar os critérios da base de dados. " . mysql_error());
											$reg_criterio = mysql_num_rows($busca_criterio);
									?>
									<fieldset>
										<?php
$cont_criterio = 1;
while($linha_criterio = mysql_fetch_assoc($busca_criterio)){
										?>
										<table border="1px" width="100%" background="../img/paperfibra.png">
											<tr bgcolor="#CCCCCC">
												<td width="100px"> Nº da Ordem </td>
												<td> Descriçao </td>
												<td width="100px" align="center"> Ações </td>
											</tr>
											<tr>
												<td><?php
												if ($cont_criterio < 10) {
													$cont_crit = '0' . $cont_criterio;
													echo $cont_crit;
												} else {
													$cont_crit = $cont_criterio;
													echo $cont_crit;
												}
												?></td>
												<td><?php echo $linha_criterio['descricao']; ?></td>
												<td><a href="delcriterio_db.php?delcodcriterio=<?php echo $linha_criterio['cod_criterio']; ?>"><img src="img/2815_32x32.png" title="Excluir Critério <?php echo ' ' . $cont_crit; ?>" onclick="javascript:return confirm('Atenção! Ao excluir um Critério você estará excluindo todos os Sub-Critérios associados ao Critério. Deseja excluir este Critério?')"></a><a href="editarcriterio.php?editarcriterio=<?php echo $linha_criterio['cod_criterio']; ?>"><img src="img/6059_32x32.png" title="Editar Critério<?php echo ' ' . $cont_crit; ?>"></a><a href="addsubcriterio.php?addcodcriterio=<?php echo $linha_criterio['cod_criterio']; ?>"><img src="img/file_add.png" title="Adicionar Sub-Critério ao Critério <?php echo ' ' . $cont_crit; ?>"></a></td>
											</tr>
											<?php
//inicia o subcriterio
$cod_fk_subcriterio = $linha_criterio['cod_criterio'];
$busca_sub_criterio = mysql_query("SELECT * FROM cl_sub_criterio WHERE fk_cod_criterio ='$cod_fk_subcriterio'") or die ("Não foi possivel carregar os subcriterios. ".mysql_error());
$reg_sub_criterio = mysql_num_rows($busca_sub_criterio);
if($reg_sub_criterio != 0){
//variavel para lower-alpha
											?>
											<tr>
												<td></td>
												<td><?php
$ol = 1;
while($linha_sub_criterio = mysql_fetch_assoc($busca_sub_criterio)){
if($ol == 1){
$ol = 0;
echo '<ol style="list-style:lower-latin">';
}
												?>
												<li id="li_criterio">
													<?php echo $linha_sub_criterio['descricao_criterio']; ?>
												</li>
												<div align="right" id="divcrit">
													<a href="delsubcriterio_db.php?delcodsubcriterio=<?php echo $linha_sub_criterio['cod_sub_criterio']; ?>" onclick="javascript:return confirm('Atenção! Deseja excluir este Sub-Critério?')"><img src="img/2815_32x32.png" width="22" title="Excluir Sub-Critério"></a>
													<a href="editarsubcriterio.php?editarsubcriterio=<?php echo $linha_sub_criterio['cod_sub_criterio']; ?>"><img src="img/6059_32x32.png" width="22" title="Editar Sub-Critério"></a>
												</div>
												<hr>
                                                
												<?php }
													echo '</ol>';
													echo '<td></td>';
													}
													//fim do subcriterio
												?></td>
												
											</tr>
										</table>
										<?php $cont_criterio++;
											echo '<hr>';
											}
										?>
										<table width="100%" background="../img/debut_light.png">
											<tr>
												<td align="left"><a href="delsubrotina_db.php?codsubrotina=<?php echo $linha_sub_rot['cod_sub_rotina']; ?>" onclick="javascript:return confirm('Atenção! Ao excluir uma Sub-Rotina você estará excluindo todos os Critérios e Sub-Critérios associados a Sub-Rotina. Deseja excluir esta Sub-Rotina?')"> <img src="img/2815_32x32.png" title="Excluir Sub-Rotina<?php echo ' ' . $cont_rot . '.' . $cont_sub_rot; ?>"></a><a href="editarsubrotina.php?codsubrotina=<?php echo $linha_sub_rot['cod_sub_rotina']; ?>"><img src="img/6059_32x32.png" title="Editar Sub-Rotina<?php echo ' ' . $cont_rot . '.' . $cont_sub_rot; ?>"> </a></td>
												<td align="right"><a href="addcriterio.php?codsubrotina=<?php echo $linha_sub_rot['cod_sub_rotina']; ?>"> <img src="img/file_add.png" title="Adicionar Critérios a Sub-Rotina<?php echo ' ' . $cont_rot . '.' . $cont_sub_rot; ?>"> </a></td>
											</tr>
										</table>
									</fieldset><?php $cont_sub_rot++;
											}
											echo '<hr>';
									?></td>
								</tr>
							</table>
							<table width="100%" background="../img/debut_light.png">
								<tr>
									<td align="left"><a href="delrotina_db.php?codrotina=<?php echo $linha_rot['cod_rotina']; ?>" onclick="javascript:return confirm('Atenção! Ao excluir uma Rotina você estará excluindo todas as Sub-Rotinas, Critérios e Sub-Critérios associados a Rotina. Deseja excluir esta Rotina?')"> <img src="img/2815_32x32.png" title="Excluir Rotina<?php echo ' ' . $cont_rot; ?>"></a><a href="editarrotina.php?codrotina=<?php echo $linha_rot['cod_rotina']; ?>"><img src="img/6059_32x32.png" title="Editar Rotina<?php echo ' ' . $cont_rot; ?>"> </a></td>
									<td align="right"><a href="addsubrotina.php?codsubrotina=<?php echo $linha_rot['cod_rotina']; ?>"> <img src="img/file_add.png" title="Adicionar Sub-Rotina a Rotina<?php echo ' ' . $cont_rot; ?>"> </a></td>
								</tr>
							</table>
						</fieldset><?php echo '<hr>'; ?></td>
					</tr>
				</table>
				<?php
				$cont_rot++;
				}
				mysql_free_result($busca_criterio);
				mysql_free_result($busca_rot);
				mysql_free_result($busca_sub_criterio);
				mysql_free_result($busca_sub_rot);
				mysql_close($con);
				?>
				<div align="right">
					<a href="addrotina.php" target="_parent">
					<input id="botao" type="button" value="Incluir Rotina">
					</a>
                    <a name="base"></a>
				</div>
			</div>
		</fieldset>
	</body>
</html>