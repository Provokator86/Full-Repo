<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');	
   
/*
+-------------------------------------------------------+
| Send email 											|
+-------------------------------------------------------+
| @params $to emial , $subject, $message, $from eamil	|
+-------------------------------------------------------+
| @returns TRUE if the email send other wise FALSE		|
+-------------------------------------------------------+
| Added by SWI on 2 June 2016		                |
+-------------------------------------------------------+
*/

function sendSmtpEmail()
{
	
}
function sendEmail($to, $subject, $message, $from='info@ams.com', $cc = '', $bcc = '', $attach_url = '')
{
	try
	{
		$CI = &get_instance();
		
		if(SITE_FOR_LIVE)
		{
			/*$CI->load->library('email');
			$config['protocol'] = 'sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';*/
			
			// codeuridea.com				
			$config = array(
								'protocol' 		=> 'smtp',
								'smtp_host' 	=> 'mail.codeuridea.com',
								'smtp_user' 	=> 'projects@codeuridea.com',
								'smtp_pass' 	=> '$h1eld687#',
								'smtp_port' 	=> '25',
								'smtp_crypto'	=> 'ssl',
								'mailpath' 		=> '/usr/sbin/sendmail',
								'charset' 		=> 'iso-8859-1',
								'wordwrap' 		=> TRUE,
								'mailtype' 		=> 'html',
								'smtp_timeout' 	=> 20
							);
			
			
			$CI->load->library('email', $config);
			$CI->email->set_newline("\r\n");	
			
		}
		else // Send email from localhost
		{			
			// Gmail				
			$config = array(
								'protocol' 		=> 'smtp',
								'smtp_host' 	=> 'smtp.gmail.com',
								'smtp_user' 	=> 'cynthiagreenw@gmail.com',
								'smtp_pass' 	=> '123testing',
								'smtp_port' 	=> '465',
								'smtp_crypto'	=> 'ssl',
								'mailpath' 		=> '/usr/sbin/sendmail',
								'charset' 		=> 'iso-8859-1',
								'wordwrap' 		=> TRUE,
								'mailtype' 		=> 'html',
								'smtp_timeout' 	=> 20
							);
			// codeuridea.com				
			/*$config = array(
								'protocol' 		=> 'smtp',
								'smtp_host' 	=> 'mail.codeuridea.com',
								'smtp_user' 	=> 'projects@codeuridea.com',
								'smtp_pass' 	=> '$h1eld687#',
								'smtp_port' 	=> '25',
								'smtp_crypto'	=> 'ssl',
								'mailpath' 		=> '/usr/sbin/sendmail',
								'charset' 		=> 'iso-8859-1',
								'wordwrap' 		=> TRUE,
								'mailtype' 		=> 'html',
								'smtp_timeout' 	=> 20
							);*/
			
			
			$CI->load->library('email', $config);
			$CI->email->set_newline("\r\n");	
		}
        
		
			
		$CI->email->initialize($config);                    
        $CI->email->clear();                    
        
        $CI->email->from($from);                    
        $CI->email->to($to);
        if(!empty($cc)) $CI->email->cc($cc);
        if(!empty($bcc)) $CI->email->bcc($bcc);
        $CI->email->subject($subject);
        $CI->email->message($message);
        
        if(!empty($attach_url))
            $CI->email->attach($attach_url);
        if($CI->email->send())
        {
           return true; 
        }
        else
        {
            //echo 'hi';
            //echo $CI->email->print_debugger();
            //exit;
            return SITE_FOR_LIVE ? false : true;
        }
        //return $CI->email->send();
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}
/* End of file email_helper.php */
/* Location: ./system/application/helpers/email_helper.php */
