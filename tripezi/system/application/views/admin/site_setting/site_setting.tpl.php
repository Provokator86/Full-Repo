<?php
/*********
* Author: Koushik
* Date  : 02 July 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
* View For Admin Site Setting Edit
* 
* @package Site Setting
* @subpackage Site Setting
* 
* @link InfController.php 
* @link My_Controller.php
* @Controler Site_setting
*/

?>
<script language="javascript">
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>";//controller Path 

$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
       $.blockUI({ message: 'Just a moment please...' });
       $("#frm_add_edit").submit();
   }); 
});    

   
///////////Submitting the form/////////
$("#frm_add_edit").submit(function(){
    var b_valid=true;
	//var site_pattern = /^(?:http:\/\/)?(?:[\w-]+\.)+[a-z]{2,6}$/;
	var site_pattern = /^(http)(s?)\:\/\/((www\.)+[a-zA-Z0-9\-\.\?\,\'\/\\\+&amp;=:%\$#_]*)?/;
	var emailReg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	var charge = /^\+?[0-9]*\.?[0-9]+$/;
    var s_err="";
    $("#div_err").hide("slow"); 
	$(".success_massage").hide("slow");

	
	/////////  EMAIL VERIFICATION ////////
	
	
	var adminEmailaddressVal = $.trim($("#txt_admin_email").val());
	if(adminEmailaddressVal=="") 
	{
		s_err +='Please provide admin email.<br />';
		b_valid=false;
	}
	
	if(!emailReg.test(adminEmailaddressVal)) 
	{
		s_err +='Please provide proper admin email.<br />';
		b_valid=false;
	}
	
	var emailaddressVal = $.trim($("#txt_paypal_email").val());
	if(emailaddressVal=="") 
	{
		s_err +='Please provide paypal email.<br />';
		b_valid=false;
	}
	
	if(!emailReg.test(emailaddressVal)) 
	{
		s_err +='Please provide proper paypal email.<br />';
		b_valid=false;
	}
	

	///////////// END OF EMAIL VERIFICATION  //////////
	
  	if($.trim($("#txt_facebook_address").val())=="") 
    {
        s_err +='Please provide facebook address.<br />';
        b_valid=false;
    }
    else if(!site_pattern.test($("#txt_facebook_address").val()))    
    {
        s_err +='Please provide correct facebook address.<br />';
        b_valid=false;
    }
    if($.trim($("#txt_twitter_address").val())=="") 
    {
        s_err +='Please provide twitter address.<br />';
        b_valid=false;
    }
    if($.trim($("#txt_linkedin_address").val())=="") 
    {
        s_err +='Please provide twitter address.<br />';
        b_valid=false;
    }
   /* if($.trim($("#txt_sms_gateway_key").val())=="") 
    {
        s_err +='Please provide Sms gateway key.<br />';
        b_valid=false;
    }*/
    if($.trim($("#txt_google_map_key").val())=="") 
    {
        s_err +='Please provide google map key for version 2.<br />';
        b_valid=false;
    }
	if($.trim($("#txt_google_map_key_gmap3").val())=="") 
    {
        s_err +='Please provide google map key for version 3.<br />';
        b_valid=false;
    }
	
	if($.trim($("#d_service_charge").val())=="") 
    {
        s_err +='Please provide service charge percentage.<br />';
        b_valid=false;
    } 
	else if(!charge.test($("#d_service_charge").val()))	
	{
		s_err +='Please provide proper service charge percentage.<br />';
		b_valid=false;
	} 
	if($.trim($("#d_commission_charge").val())=="") 
    {
        s_err +='Please provide site commission charge percentage.<br />';
        b_valid=false;
    } 
	else if(!charge.test($("#d_commission_charge").val()))	
	{
		s_err +='Please provide proper site commission charge percentage.<br />';
		b_valid=false;
	}
    if($.trim($("#txt_smtp_host").val())=="") 
    {
        s_err +='Please provide smtp host.<br />';
        b_valid=false;
    }
    if($.trim($("#d_service_charge").val())=="") 
    {
        s_err +='Please provide smtp user name.<br />';
        b_valid=false;
    } 
    if($.trim($("#d_service_charge").val())=="") 
    {
        s_err +='Please provide smtp password.<br />';
        b_valid=false;
    }  

	
    /////////validating//////
    if(!b_valid)
    {
        $.unblockUI();  
        $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
    }
    
    return b_valid;
}); 


   
///////////end Submitting the form/////////    
    
})});    
</script>
<div id="right_panel">
<h2><?php echo $heading;?></h2>
<div class="info_box">From here Admin can set various settings as described below.</div>
	<div class="clr"></div>
	<div id="accountlist">
		<h2>Site Setting</h2>
		<form id="frm_add_edit" name="frm_add_edit" method="post" action="" enctype="multipart/form-data">
			<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
			
			<div id="div_err">
				<?php
					show_msg("error");  
					echo validation_errors();
				?>
			</div>
			<div id="div_err"><?php show_msg(); ?></div>     
			<div class="add_edit">
			<? /*****Modify Section Starts*******/?>
			<div id="myaccount">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" >
					
					  <tr>
                        <td>Admin Email *:</td>
                        <td>
                            <input id="txt_admin_email" name="txt_admin_email" value="<?php echo $posted["txt_admin_email"];?>" 
                            type="text" size="50" />                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                    <td>&nbsp;</td>
                    <td colspan="2" class="caption_txt">From here Admin can set the email address, from where all emails will be sent to the registered user's of the site.</td></tr>
                    
                    <tr>
                        <td>Paypal Email *:</td>
                        <td>
                            <input id="txt_paypal_email" name="txt_paypal_email" value="<?php echo $posted["txt_paypal_email"];?>" 
                            type="text" size="50" />                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                    <td>&nbsp;</td>
                    <td colspan="2" class="caption_txt">From here Admin can set the Paypal email ID.</td></tr>
                    
                    <tr>
                        <td>Facebook address *:</td>
                        <td>
                            <input id="txt_facebook_address" name="txt_facebook_address" value="<?php echo $posted["txt_facebook_address"];?>" 
                            type="text" size="50" />                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                    <td>&nbsp;</td>
                    <td colspan="2" class="caption_txt">From here Admin can set the Facebook address .</td></tr>
                    
                    <tr>
                        <td>Twitter Address*:</td>
                        <td>
                            <input id="txt_twitter_address" name="txt_twitter_address" value="<?php echo $posted["txt_twitter_address"];?>" 
                            type="text" size="50" />                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                    <td>&nbsp;</td>
                    <td colspan="2" class="caption_txt">From here Admin can set the Twitter address.</td></tr>
                    
                    
                     <tr>
                        <td>LinkedIn Address*:</td>
                        <td>
                            <input id="txt_linkedin_address" name="txt_linkedin_address" value="<?php echo $posted["txt_linkedin_address"];?>" 
                            type="text" size="50" />                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                    <td>&nbsp;</td>
                    <td colspan="2" class="caption_txt">From here Admin can set the Linkedin address.</td></tr>
					
					<tr>
                        <td>Google+ Address*:</td>
                        <td>
                            <input id="txt_google_plus_address" name="txt_google_plus_address" value="<?php echo $posted["txt_google_plus_address"];?>" 
                            type="text" size="50" />                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                    <td>&nbsp;</td>
                    <td colspan="2" class="caption_txt">From here Admin can set the Google+ address.</td></tr>
					
					<tr>
                        <td>Youtube Address*:</td>
                        <td>
                            <input id="txt_youtube_address" name="txt_youtube_address" value="<?php echo $posted["txt_youtube_address"];?>" 
                            type="text" size="50" />                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                    <td>&nbsp;</td>
                    <td colspan="2" class="caption_txt">From here Admin can set the Youtube address.</td></tr>
                    
                    <?php /*?><tr>
                        <td>SMS geteway key*:</td>
                        <td>
                            <input id="txt_sms_gateway_key" name="txt_sms_gateway_key" value="<?php echo $posted["txt_sms_gateway_key"];?>" 
                            type="text" size="50" />                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                    <td>&nbsp;</td>
                    <td colspan="2" class="caption_txt">From here Admin can set the sms gateway key.</td></tr><?php */?>
                    
                    
                    <tr>
                        <td>Google map key for gmap 2*:</td>
                        <td>
                            <input id="txt_google_map_key" name="txt_google_map_key" value="<?php echo $posted["txt_google_map_key"];?>" 
                            type="text" size="50" />                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
						<td>&nbsp;</td>
						<td colspan="2" class="caption_txt">From here Admin can set the google map key for gmap version 2.</td>
					</tr>
					
					<tr>
                        <td>Google map key for gmap 3*:</td>
                        <td>
                            <input id="txt_google_map_key_gmap3" name="txt_google_map_key_gmap3" value="<?php echo $posted["txt_google_map_key_gmap3"];?>" 
                            type="text" size="50" />                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
						<td>&nbsp;</td>
						<td colspan="2" class="caption_txt">From here Admin can set the google map key for gmap version 3.</td>
					</tr>
					
					<tr>
                        <td>Service Charge Percentage (%) *:</td>
                        <td>
                            <input id="d_service_charge" name="d_service_charge" value="<?php echo $posted["d_service_charge"];?>" 
                            type="text" size="50" />                        
						</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
						<td>&nbsp;</td>
						<td colspan="2" class="caption_txt">From here Admin can set the service charge percenatge.</td>
					</tr>
					
					<tr>
                        <td>Site Commission Percentage (%) *:</td>
                        <td>
                            <input id="d_commission_charge" name="d_commission_charge" value="<?php echo $posted["d_commission_charge"];?>" 
                            type="text" size="50" />                        
						</td>
                        <td>&nbsp;</td>
                    </tr>
                    
                    
                    <tr>
						<td>&nbsp;</td>
						<td colspan="2" class="caption_txt">From here Admin can set the site commission charge percenatge.</td>
					</tr>
					
					<tr>
                        <td>Youtube snippet for page How it works *:</td>
                        <td>
                            <textarea name="s_youtube_snippet" id="s_youtube_snippet" cols="47" rows="5"><?php echo $posted["s_youtube_snippet"] ?></textarea>                    
						</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
						<td>&nbsp;</td>
						<td colspan="2" class="caption_txt">Please set the iframe as width = 560 and height = 315.</td>
					</tr>
                    <tr>
                        <td>SMTP Host *:</td>
                        <td>
                            <input id="txt_smtp_host" name="txt_smtp_host" value="<?php echo $posted["txt_smtp_host"];?>" 
                            type="text" size="50" />                        
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>SMTP User Id *:</td>
                        <td>
                            <input id="txt_smtp_userid" name="txt_smtp_userid" value="<?php echo $posted["txt_smtp_userid"];?>" 
                            type="text" size="50" />                        
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>SMTP User Password *:</td>
                        <td>
                            <input id="txt_smtp_password" name="txt_smtp_password" value="<?php echo $posted["txt_smtp_password"];?>" 
                            type="text" size="50" />                        
                        </td>
                        <td>&nbsp;</td>
                    </tr>
					
				</table>
			</div>
			<? /*****end Modify Section*******/?>      
			</div>
			<div class="left">
				<input id="btn_save" name="btn_save" type="button" value="Save" title="Click here to save content." /> 
				<!--<input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" 
				title="Click here to cancel saving content and return to previous page."/>-->
			</div>
		</form>
	</div>  
</div>
