<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 29 March 2012
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
* @link views/admin/site_setting/
*/

?>

<script type="text/javascript" src="<?=base_url()?>js/flowplayer-3.2.6.min.js"></script>

<script language="javascript">
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){

$('#s_contact_number').numeric({allow:"-"});
$('#i_records_per_page').numeric();

var g_controller="<?php echo $pathtoclass;?>";//controller Path 
    
$('input[id^="btn_cancel"]').each(function(i){
   $(this).click(function(){
       $.blockUI({ message: 'Just a moment please...' });
       window.location.href=g_controller;
   }); 
});      
    
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
    var s_err="";
    $("#div_err").hide("slow"); 
	$(".success_massage").hide("slow");

   /* if($.trim($("#s_sitename").val())=="") 
    {
        s_err +='Please provide site name.<br />';
        b_valid=false;
    }*/
	if($.trim($("#s_site_address").val())=="") 
    {
        s_err +='Please provide site address.<br />';
        b_valid=false;
    }
	else if(!site_pattern.test($("#s_site_address").val()))	
	{
		s_err +='Please provide correct site address.<br />';
		b_valid=false;
	}
	
	if($.trim($("#s_facebook_address").val())=="") 
    {
        s_err +='Please provide facebook address.<br />';
        b_valid=false;
    }
	else if(!site_pattern.test($("#s_facebook_address").val()))	
	{
		s_err +='Please provide correct facebook address.<br />';
		b_valid=false;
	}	
	
	/////////  EMAIL VERIFICATION ////////
	
	
	var adminEmailaddressVal = $.trim($("#s_admin_email").val());
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
	
	var emailaddressVal = $.trim($("#s_paypal_email").val());
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
/*	
	if($.trim($("#s_contact_number").val())=="") 
    {
        s_err +='Please provide contact number.<br />';
        b_valid=false;
    }*/
	
  	if($.trim($("#i_records_per_page").val())=="") 
    {
        s_err +='Please provide records per page.<br />';
        b_valid=false;
    }
	else if(isNaN($.trim($("#i_records_per_page").val())))
	{
		s_err +='Records per page will be numeric value.<br />';
        b_valid=false;
	}
	
	/*if($.trim($("#dd_default_language").val())=="") 
    {
        s_err +='Please select default language.<br />';
        b_valid=false;
    }  */

	
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
							<input id="s_admin_email" name="s_admin_email" value="<?php echo $posted["s_admin_email"];?>" 
							type="text" size="50" />						</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
					<td>&nbsp;</td>
					<td colspan="2" class="caption_txt">From here Admin can set the email address, from where all emails will be sent to the registered user's of the site.</td></tr>
					
					<tr>
						<td>Paypal Email *:</td>
						<td>
							<input id="s_paypal_email" name="s_paypal_email" value="<?php echo $posted["s_paypal_email"];?>" 
							type="text" size="50" />						</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
					<td>&nbsp;</td>
					<td colspan="2" class="caption_txt">From here Admin can set the Paypal email ID to receive the commission payments.</td></tr>
					
					<tr>
						<td>Facebook address *:</td>
						<td>
							<input id="s_facebook_address" name="s_facebook_address" value="<?php echo $posted["s_facebook_address"];?>" 
							type="text" size="50" />						</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
					<td>&nbsp;</td>
					<td colspan="2" class="caption_txt">From here Admin can set the Facebook address .</td></tr>
					
					<tr>
						<td>Site Address*:</td>
						<td>
							<input id="s_site_address" name="s_site_address" value="<?php echo $posted["s_site_address"];?>" 
							type="text" size="50" />						</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
					<td>&nbsp;</td>
					<td colspan="2" class="caption_txt">From here Admin can set the actual URL of the site.</td></tr>
					
					
					<tr>
					  <td valign="top">Records Per Page *: </td>
					  <td align="left"><input id="i_records_per_page" name="i_records_per_page" value="<?php echo $posted["i_records_per_page"];?>" 
							type="text" size="50" /></td>
					  <td>&nbsp;</td>
				  </tr>
				  <tr>
					<td>&nbsp;</td>
					<td colspan="2" class="caption_txt">From here Admin can set the number of records to be displayed per page in admin interface.</td></tr>
					<?php /*?><tr>
						<td valign="top">Default Language  *: </td>
						<td align="left">

						<select name="dd_default_language" id="dd_default_language">
						<option value="">Select Language</option>
						<?php echo makeOptionLanguage(' ',$posted["i_default_language"]);?>
						</select>
						</td>
						<td>&nbsp;</td>
					</tr>     
					<tr>
					<td>&nbsp;</td>
					<td colspan="2" class="caption_txt">From here Admin can set the default language. The default language is the language in which the visitor's of the site will be able to view the site.</td>
					</tr> <?php */?>
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
