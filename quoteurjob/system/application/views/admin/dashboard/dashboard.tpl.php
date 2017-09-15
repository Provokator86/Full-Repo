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
	<div class="info_box">From here Admin can get the site summary, jobs completed today, new jobs to be approved and the active jobs.</div>
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
 <div id="content">   
		<div class="dashboard_box">
			<div class="title"><?php echo ('Summary')?></div>
			<div class="content">
				<ul>
					<li><span style=" color:#FF0066;font-style:italic; font-weight:bold;"><?php echo 'Total Number of Buyers'?> : </span><a style="text-decoration:underline;" target="_blank" href="<?php echo admin_base_url().'manage_buyers/show_list' ?>"><?php echo $i_no_buyer ?></a></li>
					<li><span style=" color:#FF0066;font-style:italic; font-weight:bold;"><?php echo 'Total Number of Tradesman'?> : </span><a style="text-decoration:underline;" target="_blank" href="<?php echo admin_base_url().'manage_tradesman/show_list' ?>"><?php echo $i_no_tradesman ?></a></li>
					<li><span style=" color:#FF0066;font-style:italic; font-weight:bold;"><?php echo 'Total Buyers signup Today'?> : </span><a style="text-decoration:underline;" target="_blank" href="<?php echo admin_base_url().'manage_buyers/show_list' ?>"><?php echo $i_no_buyer_signup ?></a></li>
					<li><span style=" color:#FF0066;font-style:italic; font-weight:bold;"><?php echo ('Total Tradesman signup Today')?> : </span><a style="text-decoration:underline;" target="_blank" href="<?php echo admin_base_url().'manage_tradesman/show_list' ?>"><?php echo $i_no_tradesman_signup ?></a></li>
					<li><span style=" color:#FF0066;font-style:italic; font-weight:bold;"><?php echo ('Total Quotes Placed Today')?> : </span><a style="text-decoration:underline;" target="_blank" href="<?php echo admin_base_url().'job_live_report/show_qoute_list' ?>"><?php echo $i_tot_quotes ?></a></li>
					<li><span style=" color:#FF0066;font-style:italic; font-weight:bold;"><?php echo ('Total Messages Posted Today')?> : </span><a style="text-decoration:underline;" target="_blank" href="<?php echo admin_base_url().'manage_private_message/show_list' ?>"><?php echo $i_tot_msg_post ?></a></li>
					<li><span style=" color:#FF0066;font-style:italic; font-weight:bold;"><?php echo ('Total Jobs Accepted by Tradesmen Today')?> : </span><a style="text-decoration:underline;" target="_blank" href="<?php echo admin_base_url().'manage_jobs/show_in_progress' ?>"><?php echo $i_accept_jobs ?></a> </li>
					<li><span style=" color:#FF0066;font-style:italic; font-weight:bold;"><?php echo ('Total Payments Made Today')?> : </span><a style="text-decoration:underline;" target="_blank" href="<?php echo admin_base_url().'comm_payment_report/show_list' ?>"><?php echo $total_pay_amount ?></a></li>
				</ul>
			</div>
			
		</div>
		
		<div class="dashboard_box">
			<div class="title"><?php echo ('Jobs Completed Today')?> </div>
			<div class="content">
				<ul>
					<?php if($completed_jobs)
							{
								foreach($completed_jobs as $value)
								
								{
									
					 ?>
					 
					<li><a target="_blank" href="<?php echo admin_base_url().'job_overview/index/'.encrypt($value['id']) ?>"><span style=" color:#FF0066;font-style:italic; font-weight:bold;"><?php echo $value['s_title'] ?></span></a></li>
					
					<?php 
								} 
					
							} 
						else
						{	
					?>
					
					<li><?php echo ('No Record Found')?> </li>
					
					<?php } ?>
					<!--<li style="text-align:right"><a target="_blank" href="" style="text-decoration:underline;">View All</a></li>-->

				</ul>
			</div>
			<div class="view_all"><a target="_blank" href="<?php echo admin_base_url().'manage_jobs/show_complete' ?>">View All</a></div>
		</div>	
		<div class="clr"></div>
			
		<div class="dashboard_box">
			<div class="title"><?php echo ('New Jobs to be Approved')?> </div>
			<div class="content">
				<ul>
					<?php if(count($posted_jobs)>0)
							{
								foreach($posted_jobs as $value)
								
								{
					 ?>
					 
					<li><a target="_blank" href="<?php echo admin_base_url().'manage_jobs/show_list' ?>"><span style=" color:#FF0066;font-style:italic; font-weight:bold;"><?php echo $value['s_title'] ?></span></a></li>
					
					<?php 
								} 
					
							} 
						else
						{	
					?>
					
					<li><?php echo ('No Record Found')?> </li>
					
					<?php } ?>
					<!--<li style="text-align:right"><a target="_blank" href="" style="text-decoration:underline;">View All</a></li>-->
				</ul>
			</div>
			<div class="view_all"><a target="_blank" href="<?php echo admin_base_url().'manage_jobs/show_list' ?>">View All</a></div>
		</div>
		
		<div class="dashboard_box">
			<div class="title"><?php echo ('Active Jobs')?> </div>
			<div class="content">
				<ul>
						<?php if($active_jobs)
							{
								foreach($active_jobs as $value)
								
								{
					 ?>
					 
					<li><a target="_blank" href="<?php echo admin_base_url().'job_overview/index/'.encrypt($value['id']) ?>"><span style=" color:#FF0066;font-style:italic; font-weight:bold;"><?php echo $value['s_title'] ?></span></a></li>
					
					<?php 
								} 
					
							} 
						else
						{	
					?>
					
					<li><?php echo ('No Record Found')?> </li>
					
					<?php } ?>
					<!--<li style="text-align:right"><a target="_blank" href="" style="text-decoration:underline;">View All</a></li>-->
				</ul>
			</div>
			<div class="view_all"><a target="_blank" href="<?php echo admin_base_url().'manage_jobs/show_active' ?>">View All</a></div>
		</div>
		
					
	</div> 
	 
	 
  </div>
