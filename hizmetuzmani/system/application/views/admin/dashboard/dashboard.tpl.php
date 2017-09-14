<?php
/*********
* Author:  Koushik Rout
* Date  :  30 March 2012
* Modified By: 
* Modified Date: 
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
$('.left_inside_box ul li').filter(':even').css('background','#EBEBEB');


})});    
</script>

<div id="right_panel">
	<div class="left_dashboard">
		<div class="top_box">
			
<table class="quick_link" width="100%" >
	<tr>
		<td rowspan="2" colspan="2">
			<p>Welcome to Hizmetuzmani</p>				
		</td>
        <td>&nbsp;
                
        </td>
         <td>&nbsp;
                
        </td>
    </tr>
    <tr>
		<td>
			<ul>
				<li class="quick_links"><a id="jobs_2" href="<?php echo admin_base_url().'manage_jobs/show_all/' ?>">Jobs</a></li>
				<li class="quick_links"><a id="quotes_2" href="<?php echo admin_base_url().'manage_quotes/show_list/' ?>">Quotes</a></li>
				
			</ul>
		</td>
		<td>
			<ul>
				<li class="quick_links"><a id="buyers_3" href="<?php echo admin_base_url().'manage_buyers/' ?>">Buyers</a></li>
				<li class="quick_links"><a id="trades_3" href="<?php echo admin_base_url().'manage_tradesman/' ?>">Tradesman</a></li>
			</ul>
		</td>
	</tr>
</table>
</div>

		<div class="clr"></div>
		 <div class="left_inside_box">
         <div class="title"><?php echo "Site Summary";?></div>
			 <ul style="list-style-type: none;">
				 <li>Total buyers :<span><?php echo $i_total_buyer ?></span></li>
				 <li>Total tradesmen :<span><?php echo $i_total_tradesman; ?></span></li>
				 <li>Total users to approve :<span><?php echo $i_total_user_to_approve; ?></span></li>
				 <li>Total jobs to approve :<span><?php echo $new_jobs_to_approve; ?></span></li>
				 <li>Total quotes placed today :<span><?php echo $i_tot_quotes; ?></span></li>
				 <li>Total messages posted today :<span><?php echo $i_tot_msg_post ?></span></li>
				 <!--<li>Total payment has been made today :<span><?php echo $total_pay_amount ?></span></li>-->
			 </ul>
		</div>
		<div class="clr"></div>
		<div class="left_inside_box">
        <div class="title"><?php echo "Latest Notification";?></div>
		 <ul style="list-style-type: none;">
		 <?php if($latest_notification) {
		 
		 		foreach($latest_notification as $val)
					{
		  ?>
             <li><?php echo $val['msg'] ?></li>
          <?php } } else { ?>
			<li><?php echo 'No item found';?></li>
		  <?php } ?>
         </ul>
         <p>&nbsp;</p>
         <div class="view_all"><a id="notification_4" href="<?php echo admin_base_url().'manage_notification/' ?>">View All</a></div>
		</div>
	</div>
	<!--END OF DIV-left_dashboard -->
	
	
<div class="right_dashboard">
	   
			<div class="dashboard_box">
				<div class="title"><?php echo "New Jobs";?></div>
				<div class="content">
					<ul>
					<?php if($new_jobs) {					
						foreach($new_jobs as $val)
							{
					 ?>
						<li><?php echo $val['s_title'] ?> </li>	
					<?php } } else { ?>
						<li><?php echo 'No item found';?></li>
				    <?php } ?>					
					</ul>
					<p>&nbsp;</p>
                    <div class="view_all"><a id="new_2" href="<?php echo admin_base_url().'manage_jobs/show_list/' ?>">View All</a></div>
				</div>
				
			</div>
		   <!-- END OF DIV-dashboard_box -->
			
			<div class="clr"></div>
			<div class="dashboard_box">
				<div class="title"><?php echo "Active Jobs";?></div>
				<div class="content">
					<ul>
					<?php if($active_jobs) {					
						foreach($active_jobs as $val)
							{
					 ?>
						<li><?php echo $val['s_title'] ?> </li>	
					<?php } } else { ?>
						<li><?php echo 'No item found';?></li>
				    <?php } ?>	
					</ul>					
                    <p>&nbsp;</p>
                    <div class="view_all"><a id="active_2" href="<?php echo admin_base_url().'manage_jobs/show_active/' ?>">View All</a></div>                    
				</div>
				
			</div>
		   
		   <div class="clr"></div>
			<div class="dashboard_box">
				<div class="title"><?php echo "Completed Jobs";?></div>
				<div class="content">
					<ul>
						<?php if($completed_jobs) {					
						foreach($completed_jobs as $val)
							{
					 	?>
							<li><?php echo $val['s_title'] ?> </li>	
						<?php } } else { ?>
							<li><?php echo 'No item found';?></li>
						<?php } ?>						
					</ul>
                    <p>&nbsp;</p>
                    <div class="view_all"><a id="complete_2" href="<?php echo admin_base_url().'manage_jobs/show_complete/' ?>">View All</a></div>
				</div>
				
			</div>
           
            
	
	<!--END OF DIV-content -->
</div>
<!--END OF DIV-right_dashboard -->
</div>
