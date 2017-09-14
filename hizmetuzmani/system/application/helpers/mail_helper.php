<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function sendMail($to, $subject, $message ,$attachment='', $formmalid = 'info@hizmetuzmani.ca', $formname = 'Hizmetuzmani', $cc='', $bcc='')
{
    global $CI;
	
	$config['mailtype'] = 'html';
    $config['charset'] = 'utf-8';
	
    if (empty($formmalid))
    {
        $formmalid = $CI->config->item('CONF_EMAIL_ID');
        $formname  = $CI->config->item('MAIL_FROM_NAME');
    }

    $CI->load->library('email');
	$CI->email->initialize($config);
    $CI->email->from($formmalid, $formname);
    $CI->email->to($to);
    $CI->email->cc($cc);
    $CI->email->bcc($bcc);
    $CI->email->subject($subject);
    $CI->email->message($message);
	
	if(!empty($attachment))
	{
	$CI->email->attach($attachment);
	}
	 if(SITE_FOR_LIVE)///For live site
	{	
		if ($CI->email->send())
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	else{
		return true;		
	}
}
?>
