<?php
/*********
* Author: Arnab Chattopadhyay
* Date  : 30 Dec 2010
* Modified By: Jagannath Samanta
* Modified Date: Jul 5,2011
* 
* Purpose:
*  View For Admin Dashboard Edit
* 
* @package Home
* @subpackage News
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/dashboard/
*/

?>


<script language="javascript">
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){

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
    var s_err="";
    $("#div_err").hide("slow"); 

    if($.trim($("#txt_first_name").val())=="") 
    {
        s_err +='Please provide First Name.<br />';
        b_valid=false;
    }
	if($.trim($("#txt_last_name").val())=="") 
    {
        s_err +='Please provide Last Name.<br />';
        b_valid=false;
    }
	if($.trim($("#txt_user_name").val())=="") 
    {
        s_err +='Please provide Username.<br />';
        b_valid=false;
    }
	if($.trim($("#txt_user_email").val())=="") 
    {
        s_err +='Please provide Email.<br />';
        b_valid=false;
    }
	
	/*******
	if($.trim($("#txt_password").val())=="") 
    {
        s_err='<div id="err_msg" class="error_massage">Please provide news title.</div>';
        b_valid=false;
    }
	if($.trim($("#txt_new_password").val())=="") 
    {
        s_err='<div id="err_msg" class="error_massage">Please provide news title.</div>';
        b_valid=false;
    }
	if($.trim($("#txt_confirm_password").val())=="") 
    {
        s_err='<div id="err_msg" class="error_massage">Please provide news title.</div>';
        b_valid=false;
    }
	*///
	if($.trim($("#txt_password").val())=="" && $.trim($("#txt_new_password").val())!="")
	{
		s_err +='Please provide Old Password.';
		b_valid=false;
	}
	else
	{
		if(($.trim($("#txt_new_password").val())!="" || $.trim($("#txt_confirm_password").val())!="") && ($.trim($("#txt_new_password").val()) != $.trim($("#txt_confirm_password").val())))
		{
			s_err +='New Password and Confirm Password did not match.<br />';
			b_valid=false;
		}
		/*if($.trim($("#txt_new_password").val())!= '' && $.trim($("#txt_password").val())=="")
		{
			s_err +='New Password and Confirm Password did not match.';
			b_valid=false;
		}*/
	}
	
	
	/*if((text = tinyMCE.get('txt_news_description').getContent())=='') 
    {
        s_err='<div id="err_msg" class="error_massage">Please provide Description .</div>';
        b_valid=false;
    }*/
    
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
	<div class="info_box">From here you can set your personal email id and other personal settings.</div>
	<div class="clr"></div>
  <!-- ============= dashboard link div ============= -->  
  <?php /*
    <div id="dashboard_link_div">
    	<ul class="dashboardlink" style="list-style-type:none;">             
            <li><a  id="mnu_3_2" href="<?=admin_base_url()?>milestones/"><img src="images/admin/CreateAccounts.gif" alt="" />Milestones Management</a></li> 
            <li><a  id="mnu_3_1" href="<?=admin_base_url()?>content/show_email_content"><img src="images/admin/CreateAccounts.gif" alt="" />Email Template Management</a></li>    
                                          
            <li><a  id="mnu_3_0" href="<?=admin_base_url()?>news/"><img src="images/admin/CreateAccounts.gif" alt="" />News Management</a></li>
            <li><a id="mnu_3_1"  href="<?=admin_base_url()?>Idea/"><img src="images/admin/CreateAccounts.gif" alt="" />Content Management</a></li>
            <li><a id="mnu_4_2"  href="<?=admin_base_url()?>gallery/"><img src="images/admin/CreateAccounts.gif" alt="" />Photo Gallery  Management</a></li>
        </ul>
    </div>
  <!-- ============= end dashboard link div ============= -->  
        <div style="clear:both"></div>
		*/ ?>
  <!-- ============= dashboard user information div ============= -->  
    <?php /*?><div id="dashboard_link_div">
    	<ul class="dashboardlink" style="list-style-type:none;">
            <li>Number of active user in site:</li>
            <li>[<?php echo $i_no_active_user;?>]</li>
        </ul>
    	<ul class="dashboardlink" style="list-style-type:none;">
            <li>Number of inactive user in site:</li>
            <li>[<?php echo $i_no_inactive_user;?>]</li>
        </ul>
    </div><?php */?>
  <!-- ============= end dashboard user information div ============= -->  
        <div style="clear:both"></div>
  <!-- ============= dashboard notification div ============= -->  
  <?php 
  /*
    <div id="dashboard_link_div" style="border:#CCCCCC 1px solid;">
    	<ul class="dashboardlink" style="list-style-type:none;">
            <li>Notification area</li>
        </ul>
    </div>
  */
  ?>
  <!-- ============= end dashboard notification div ============= -->  
    
    <div id="accountlist">
    	<h2>My Account</h2>
		
        
        <form id="frm_add_edit" name="frm_add_edit" method="post" action="">
<!--<input type="hidden" id="h_mode" name="h_mode" value="<?php echo $posted["h_mode"];?>">-->
<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
    
        <div id="div_err">
            <?php
              show_msg("error");  
              echo validation_errors();
            ?>
        </div>
        <div id="div_err">
            <?php
              show_msg();  
            ?>
        </div>     
    <div class="add_edit">
    <? /*****Modify Section Starts*******/?>
    <div id="myaccount">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>First Name *:</td>
          <td><input id="txt_first_name" name="txt_first_name" value="<?php echo $posted["txt_first_name"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Last Name *:</td>
          <td><input id="txt_last_name" name="txt_last_name" value="<?php echo $posted["txt_last_name"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Username *:</td>
          <td><input id="txt_user_name" name="txt_user_name" value="<?php echo $posted["txt_user_name"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
         <tr>
          <td>Email *:</td>
          <td><input id="txt_user_email" name="txt_email" value="<?php echo $posted["txt_email"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        
        <tr>
          <td colspan="2">
          <strong>Change your password:</strong>
          <br /><span style="font-size:10px">(To change your password you have to fill up the following three fields properly.)</span>
          </td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        
        <tr>
          <td>Old Password *:</td>
          <td><input id="txt_password" name="txt_password" value="" type="password" size="40" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>New Password *:</td>
          <td><input id="txt_new_password" name="txt_new_password" value="" type="password" size="40" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Confirm Password *:</td>
          <td><input id="txt_confirm_password" name="txt_confirm_password" value="" type="password" size="40" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        
      </table>
      </div>
    <? /*****end Modify Section*******/?>      
    </div>
    <div class="left">
    <input id="btn_save" name="btn_save" type="button" value="Save" title="Click here to save content." /> 
    <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving content and return to previous page."/>
    </div>
    
</form>
        
    </div>  
  </div>
