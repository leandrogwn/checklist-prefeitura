<?php
error_reporting(0);

//Se for enviado
if (isset($_POST['submit'])) {
include('conecta.php');

//função retira acentos
function retirar_acentos($sub){
    $acentos = array(
        'À','Á','Ã','Â', 'à','á','ã','â',
        'Ê', 'É',
        'Í', 'í', 
        'Ó','Õ','Ô', 'ó', 'õ', 'ô',
        'Ú','Ü',
        'Ç', 'ç',
        'é','ê', 
        'ú','ü',' ','(',')',
        );
    $remove_acentos = array(
        'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
        'e', 'e',
        'i', 'i',
        'o', 'o','o', 'o', 'o','o',
        'u', 'u',
        'c', 'c',
        'e', 'e',
        'u', 'u','_','','',
        );
    return str_replace($acentos, $remove_acentos, urldecode($sub));
}
	
//código de algumas entidades da tabela
$r = $_GET["r"]; //código rotina
$cp = $_GET["cp"]; //código de preenchimento
$tit = $_POST["titulo"]; //titulo da imagem

//Extensões permitidas
$ext = array("gif","jpg","png","jpeg");
 
//Quant. de campos do tipo FILE
$campos = 1;
 
//Obtendo info. dos arquivos
$f_name = $_FILES['file_img']['name'];
$f_tmp = $_FILES['file_img']['tmp_name'];
$f_type = $_FILES['file_img']['type'];
 
//Pegando o nome
$name = retirar_acentos($f_name);

//nome do arquivo para o banco
$name_bd = 'imagens'.'/'.$r.'/'.$name; 

//Verificando se o campo contem arquivo
if ( ($name!="") and (is_file($f_tmp)) and (in_array(substr($name, -3),$ext)) ) {

	//inicio

	$insere = "insert into cl_img (fk_cod_preenchimento, img, titulo) values ('$cp','$name_bd','$tit')";
	//confirmar
	mysql_select_db($db, $con);
	$resultado = mysql_query($insere, $con) or die (mysql_error());
	if($resultado){
		
		//cria diretórios
		mkdir("imagens",0777);
		mkdir("imagens/$r", 0777);
	
		//Movendo arquivo's do upload
		$up = move_uploaded_file($f_tmp, $name_bd);
 
		//Status
			if ($up==true):
				// Chama o arquivo com a classe WideImage
				require('wideimage/lib/WideImage.php');
				
				// Carrega a imagem a ser manipulada
				$image = WideImage::load($name_bd);
				
				// Redimensiona a imagem
				$image = $image->resize(700, 525);
				
				// Salva a imagem em um arquivo (novo ou não)
				$image->saveToFile($name_bd);

				echo  '<script type="text/javascript">
						alert ("Imagem inserida com sucesso, para visualiza-la clique em Ok e Avançar");
						window.close("#");
					</script>';
            else:
				echo '<script type="text/javascript">
						alert ("A imagem não pode ser inserida! Tente novamente");
						window.history.back();
					</script>';
			endif;
			echo "";
			}
	}else{
		?>
			<script type="text/javascript">
				alert ("A Inserção não pode ser concluída! Tente novamente");
				window.history.back();	
			</script>
		<?php

		//fim
	}
}
?>