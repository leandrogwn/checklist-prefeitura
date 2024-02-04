<?php

$gerar_pdf = $_POST['relatorio'];

//inclui a biblioteca dompdf
require_once("dompdf/dompdf_config.inc.php");

//Aqui eu estou decodificando o tipo de charset do documento, para evitar erros nos acentos das letras e etc.
$gerar_pdf = utf8_decode($gerar_pdf);

//instancia-se a clase dompdf
$dompdf = new DOMPDF();

//conteúdo que sera convertido para pdf
$dompdf -> load_html($gerar_pdf);

//tamanho do papel e sua orientação
$dompdf -> set_paper('A4','portrait');

//converte o arquivo
$dompdf -> render();

//salvo no diretorio temporario e exibido
$pdf = $dompdf->output();     
$dompdf -> stream('Relatório '.date('d/m/Y').'.pdf');
?>
