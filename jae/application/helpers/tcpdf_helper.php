<?php 
//if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FCPATH."application/libraries/tcpdf_lib/tcpdf/tcpdf.php");  
$title_set = '';
class MYPDF extends TCPDF {
 
    //Page header
    public function Header() {     
        
       global $title_set;
       // Set font
        $this->SetFont('helvetica', 'B', 10);
        // Title
        $this->Cell(0, 15, $title_set, 0, false, 'C', 0, '', 0, false, 'M', 'M');      
    }

    // Page footer
    public function Footer() {
        
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}


function contact_pdf_create_tcpdf($html, $filename='', $stream=TRUE, $config = array()) 
{    
    require_once(FCPATH."application/libraries/tcpdf_lib/tcpdf/tcpdf.php");       
    //$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    
    global $title_set;
    if($config['title_set'] >= 0)
        $title_set = 'SET - '.$config['title_set'];
    else
        $title_set = 'SET - XXX';
	
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);	
	$pdf->SetPrintHeader(TRUE);
	$pdf->SetPrintFooter(false);
	$pdf->SetMargins(5, 15, 5);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_BOTTOM);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	
	
	$pdf->SetTitle($title_set);
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

	
	$pdf->AddPage();
	$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);
	//writeHTMLCell( $w, $h, $x, $y, $html = '', $border = 0, $ln = 0, $fill = false, $reseth = true, $align = '', $autopadding = true )
	
    if ($stream)
        $pdf->Output("{$filename}.pdf", 'I');
    else
        return $pdf->Output("{$filename}.pdf", 'S');
}

function pdf_create_tcpdf($html, $filename='', $stream=TRUE) 
{   
    require_once(FCPATH."application/libraries/tcpdf_lib/tcpdf/tcpdf.php");       
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    //$pdf = new TCPDF();
    //$pdf->setFooterData(array(0,0,0), array(0,0,0));
	//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	#$pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
	$pdf->SetPrintHeader(false);
	$pdf->SetPrintFooter(false);
	$pdf->SetMargins(5, 15, 5);
    $pdf->SetHeaderMargin(PDF_MARGIN_TOP);
    //$pdf->SetHeaderMargin(15);
	#$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	$pdf->SetFooterMargin(PDF_MARGIN_BOTTOM);
	//$pdf->SetFooterMargin(15);
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);	
	//$pdf->SetAutoPageBreak(TRUE, 15);	
	$pdf->AddPage();
	
	//$pdf->writeHTMLCell(0, 0, '', '', $html, 1, 1, 0, true, '', true);
	$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);
	//writeHTMLCell( $w, $h, $x, $y, $html = '', $border = 0, $ln = 0, $fill = false, $reseth = true, $align = '', $autopadding = true )
	
    if ($stream)
        $pdf->Output("{$filename}.pdf", 'I');
    else
        return $pdf->Output("{$filename}.pdf", 'S');
    
}
