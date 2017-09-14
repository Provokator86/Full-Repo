<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function sendMail($to, $subject, $message , $formmalid = 'info@coupondesh.com', $formname = 'Coupondesh',$attachment='', $cc='', $bcc='')
{
	global $CI;
	$formmalid = 'info@coupondesh.com';
	$formname = 'Coupondesh';
	$config['mailtype'] = 'html';
    $config['charset'] = 'utf-8';
	//----------------------------------------------------
	$config['protocol'] = 'smtp';
    $config['smtp_host'] = "smtp.coupondesh.com";
	//$config['smtp_host'] = "mail.acumencs.com";
	
	$config['smtp_user'] =  'info@coupondesh.com';
	//$config['validate'] =  'true';
    //$config['smtp_user'] =  'smtp@acumencs.com';
	
	 
    $config['smtp_pass'] =  'DnCfTqM9';
	//$config['smtp_pass'] =  'smtp1234';
	
    $config['crlf'] = "\r\n";
    $config['newline'] = "\r\n";
	
	//-----------------------------------------------------
//echo "here";exit;
	//pr($formmalid);
    if (empty($formmalid))
    {
        $formmalid = $CI->config->item('CONF_EMAIL_ID');
        $formname  = $CI->config->item('MAIL_FROM_NAME');
    }
	
    $CI->load->library('email');
	$CI->email->initialize($config);
	$CI->email->clear();
    $CI->email->from($formmalid, $formname);
    $CI->email->to($to);
	$CI->email->subject($subject);
    $CI->email->message($message);
	
    if(!empty($attachment))
		{
			$CI->email->attach($attachment);
		}
	if(!empty($cc))
		{
			$CI->email->cc($cc);
		}	
    if(!empty($bcc))
		{
			$CI->email->bcc($bcc);
		}	
    
	
	/*if(SITE_FOR_LIVE)	///For live site
	{*/
	//echo "anish";
		if ($CI->email->send())
		{
			//echo 'send===='.$CI->email->print_debugger();	
			//exit;		 	
			return true;
		}
		else
		{	
			//echo 'not send==='.$CI->email->print_debugger();	
			//exit;
			return false;
		}
	/*}
	else
	{
		return true;		
	}*/
}
?>
