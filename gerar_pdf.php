<?php
   $content = $_POST['relatorio'];

    require_once('html2pdf/html2pdf.class.php');
 
  
$pdf = new HTML2PDF();  
  
$pdf->WriteHTML($content);  
  
$pdf->Output('Relatorio.pdf','I');
	?>
