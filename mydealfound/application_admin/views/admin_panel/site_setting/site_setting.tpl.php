<?php

/*********
* Author: acs
* Date  : 24 June 2011
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

<?php /*?><script type="text/javascript" src="<?=base_url()?>js/flowplayer-3.2.6.min.js"></script><?php */?>

<script language="javascript">
//jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {

	$(document).ready(function(){	
	
	
	$('#s_contact_number').numeric({allow:"-"});	
	$('#i_records_per_page').numeric();	
	//$('#s_subcription_amount').numeric({});	
	
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
		var site_pattern = /^(http|https)\:\/\/((www\.)+[a-zA-Z0-9\-\.\?\,\'\/\\\+&amp;=:%\$#_]*)?/;	
		var emailReg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		var s_err="";
		var priceRg = /^\+?[0-9]*\.?[0-9]+$/;
		var intRegex = /^\d+$/;
	
		$("#div_err").hide("slow"); 	
		$(".success_massage").hide("slow");	
		var adminEmailaddressVal = $.trim($("#s_contact_us_email").val());	
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
		
		if($.trim($("#d_cashback").val())=="") 	
		{	
			s_err +='Please provide cashback value.<br />';	
			b_valid=false;	
		}
		else if(!intRegex.test($("#d_cashback").val()))		
		{	
			s_err +='Please provide cashback value numeric.<br />';	
			b_valid=false;	
		}
		
		if($.trim($("#d_min_balance").val())=="") 	
		{	
			s_err +='Please provide minimum balance for payment.<br />';	
			b_valid=false;	
		}	
		else if(!priceRg.test($("#d_min_balance").val()))		
		{	
			s_err +='Please provide proper minimum balance for payment.<br />';	
			b_valid=false;	
		}
		
		if($.trim($("#s_twitter_url").val())!="")	
		{
			if(!site_pattern.test($.trim($("#s_twitter_url").val())))	
			{	
				s_err +='Please provide provide correct Twitter address.<br />';	
				b_valid=false;	
			}		
		}	
		if($.trim($("#s_pinterest_url").val())!="")	
		{	
			if(!site_pattern.test($("#s_pinterest_url").val()))	
			{	
				s_err +='Please provide provide correct Pinterest address.<br />';	
				b_valid=false;	
			}		
		}	
		if($.trim($("#s_facebook_url").val())!="")	
		{	
			if(!site_pattern.test($("#s_facebook_url").val()))	
			{	
				s_err +='Please provide provide correct Facebook address.<br />';	
				b_valid=false;	
			}		
		}	
		if($.trim($("#s_google_plus_url").val())!="")	
		{	
			if(!site_pattern.test($.trim($("#s_google_plus_url").val())))	
			{	
				s_err +='Please provide provide correct Google Plus address.<br />';	
				b_valid=false;	
			}		
		}	
		if($.trim($("#s_address").val())=="") 	
		{	
			s_err +='Please provide site address.<br />';	
			b_valid=false;	
		}	
		else if(!site_pattern.test($("#s_address").val()))		
		{	
			s_err +='Please provide correct site address.<br />';	
			b_valid=false;	
		}		
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
			<?php /*?><tr>

				<td width="20%">Site Name *:</td>

				<td width="50%">

					<input id="s_sitename" name="s_sitename" value="<?php echo $posted["s_sitename"];?>" 

					type="text" size="50" />						</td>

				<td>&nbsp;</td>

				<td>&nbsp;</td>

			</tr><?php */?>

			<tr>
				<td>Admin Email  *:</td>
				<td>
					<input id="s_contact_us_email" name="s_contact_us_email" value="<?php echo $posted["s_contact_us_email"];?>" 

					type="text" size="50" />						</td>

				<td>&nbsp;</td>

				<td>&nbsp;</td>

			</tr>

			<tr>

				<td>Site Title *:</td>

				<td>

					<input id="s_site_title" name="s_site_title" value="<?php echo $posted["s_site_title"];?>" 

					type="text" size="50" />						</td>

				<td>&nbsp;</td>

				<td>&nbsp;</td>

			</tr>

			<tr>

					<td>&nbsp;</td>

					<td class="caption_txt" colspan="2">From here Admin can set the site title.</td>

			</tr>

			

			<tr>

				<td>Address *:</td>

				<td>

					<input id="s_address" name="s_address" value="<?php echo $posted["s_address"];?>" 

					type="text" size="50" />						</td>

				<td>&nbsp;</td>

				<td>&nbsp;</td>

			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="caption_txt" colspan="2">From here Admin can set the address</td>
			</tr>
			
			
			<tr>
				<td>Minimum Balance For Withdrawl *:</td>
				<td>
				<input id="d_min_balance" name="d_min_balance" value="<?php echo $posted["d_min_balance"];?>" type="text" size="50" />
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="caption_txt" colspan="2">From here Admin can set the minimum balance required for withdrawl.</td>
			</tr>
			
			
			<tr>
				<td>Referral Cashback *:</td>
				<td>
				<input id="d_cashback" name="d_cashback" value="<?php echo $posted["d_cashback"];?>" type="text" size="50" />
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="caption_txt" colspan="2">From here Admin can set the cashback % value.</td>
			</tr>

			<tr>

				<td>Telephone:</td>

				<td>

					<input id="s_telephone" name="s_telephone" value="<?php echo $posted["s_telephone"];?>" 

					type="text" size="50" />						</td>

				<td>&nbsp;</td>

				<td>&nbsp;</td>

			</tr>

			<tr>

				<td>&nbsp;</td>

				<td class="caption_txt" colspan="2">From here Admin can set the Telephone number.</td>

			</tr>

			<tr>

				<td>Twitter URL :</td>

				<td>

					<input id="s_twitter_url" name="s_twitter_url" value="<?php echo $posted["s_twitter_url"];?>" 

					type="text" size="50" />						</td>

				<td>&nbsp;</td>

				<td>&nbsp;</td>

			</tr>

			<tr>

					<td>&nbsp;</td>

					<td class="caption_txt" colspan="2">From here Admin can set the Pinterest URL.</td>

			</tr>

			<tr>

				<td>Pinterest URL :</td>

				<td>

				<input id="s_pinterest_url" name="s_pinterest_url" value="<?php echo $posted["s_pinterest_url"];?>" 

					type="text" size="50" />						</td>

				<td>&nbsp;</td>

				<td>&nbsp;</td>

			</tr>

			<tr>

					<td>&nbsp;</td>

					<td class="caption_txt" colspan="2">From here Admin can set the Twitter URL.</td>

			</tr>

			<tr>

				<td>Facebook URL :</td>

				<td>

					<input id="s_facebook_url" name="s_facebook_url" value="<?php echo $posted["s_facebook_url"];?>" 

					type="text" size="50" />						</td>

				<td>&nbsp;</td>

				<td>&nbsp;</td>

			</tr>

			<tr>

					<td>&nbsp;</td>

					<td class="caption_txt" colspan="2">From here Admin can set the Facebook URL.</td>

			</tr>

			

			<tr>
				<td>Google Plus URL :</td>
				<td>
				<input id="s_google_plus_url" name="s_google_plus_url" value="<?php echo $posted["s_google_plus_url"];?>" type="text" size="50" />
				</td>

				<td>&nbsp;</td>
				<td>&nbsp;</td>

			</tr>

			<tr>
				<td>&nbsp;</td>
				<td class="caption_txt" colspan="2">From here Admin can set the Google Analytics For Deal Site .</td>
			</tr>

			<tr>
				<td>Code :</td>
				<td>
					<textarea style="width: 283px; height: 57px;" id="s_google_analitics_deal" name="s_google_analitics_deal"  ><?php echo $posted["s_google_analitics_deal"];?></textarea>	
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
   			<tr>
				<td>&nbsp;</td>
				<td class="caption_txt"  colspan="2">From here Admin can set the Google Analytics For Deal Site.</td>
			</tr>

			<tr>
				<td>Code :</td>
				<td>
				<textarea style="width: 283px; height: 57px;" id="s_google_analitics_coupon" name="s_google_analitics_coupon"  ><?php echo $posted["s_google_analitics_coupon"];?></textarea>	
				</td>

				<td>&nbsp;</td>
				<td>&nbsp;</td>

			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="caption_txt" colspan="2">From here Admin can set the Google Analytics For Coupon Site.</td>
			</tr>

			

			<tr>                                                    

			  <td valign="top">Records Per Page *: </td> 
			  <td align="left"><input id="i_records_per_page" name="i_records_per_page" value="<?php echo $posted["i_records_per_page"];?>" type="text" size="50" /></td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td class="caption_txt" colspan="2">From here Admin can set the number of records to be displayed per page in admin interface.</td>
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

