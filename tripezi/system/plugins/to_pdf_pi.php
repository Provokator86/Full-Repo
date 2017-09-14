<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function pdf_create($html, $filename, $stream=TRUE)
{   
	global $CI;
    require_once("dompdf/dompdf_config.inc.php"); 
    spl_autoload_register('DOMPDF_autoload');
   
    $dompdf = new DOMPDF();
	
    $dompdf->load_html($html);
	
    $dompdf->render();
	
	 
	
	// The next call will store the entire PDF as a string in $pdf

	$pdf = $dompdf->output();
	
	//file_put_contents("/home/acumencs/public_html/ci/application/public/invoices_temp/".$filename.".pdf", $pdf);
	file_put_contents($CI->config->item('ATTACHMENT_PDF_PATH').$filename.".pdf", $pdf);
	$dompdf->stream($filename.".pdf");

}