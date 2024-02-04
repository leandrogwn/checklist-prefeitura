<?php

/*$html = '
 <html>
 <head>
   <style="text/css">
     body {
       font-family: Calibri, DejaVu Sans, Arial;
       margin: 0;
       padding: 0;
       border: none;
       font-size: 13px;
     }
 
     #exemplo {
       width: 100%;
       height: auto;
       overflow: hidden;
       padding: 5px 0;
       text-align: center;
       background-color: #CCC;
       color: #FFF;
     }
   </style>
 </head>
 <body>
   <div id="exemplo">
     Gerar PDF com a classe DOMPDF para PHP.
   </div>
 </body>
 </html>';

//inclui a biblioteca dompdf
require_once("dompdf/dompdf_config.inc.php");

//instancia-se a clase dompdf
$dompdf = new DOMPDF();

//conteúdo que sera convertido para pdf
$dompdf -> load_html($html);

//tamanho do papel e sua orientação
$dompdf -> set_paper('A4','portrait');

//converte o arquivo
$dompdf -> render();

//salvo no diretorio temporario e exibido
$dompdf -> stream("nomedoarquivo.pdf");*/

$url = file_get_contents('http://localhost/wordpress/checklist/view_relat.php');
echo $url;
?>