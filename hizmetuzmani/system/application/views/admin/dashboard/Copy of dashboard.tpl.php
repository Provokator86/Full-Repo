<?php
/*********
* Author:  Koushik Rout
* Date  :  28 DEC 2011
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
})});    
</script>
<div id="right_panel">
    <h2><?php echo $heading;?></h2>
	<div class="info_box">From here Admin can get the site summary.</div>
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
			<div class="title"><?php echo "Quick Actions";?></div>
			<div class="content">
				<ul>
					<?php /*?><li><span style=" color:#FF0066;font-style:italic; font-weight:bold;">Total Number of Buyers : </span><a style="text-decoration:underline;" target="_blank" href="javascript:void(0)">5</a></li><?php */?>
					
				</ul> 
			</div>
			
		</div>
		 <!-- END OF DIV-dashboard_box -->   
		<div class="dashboard_box">
			<div class="title"><?php echo "Site Statistics";?> </div>
			<div class="content">
			    <ul>

				</ul> 
			</div>
			<!--<div class="view_all"><a target="_blank" href="javascript:void(0);">View All</a></div>-->
		</div>	
		
		<div class="dashboard_box">
			<div class="title"><?php echo "Active Jobs";?> </div>
			<div class="content">
			    <ul>

				</ul> 
			</div>
			<span class="view_all"><a target="_blank" href="javascript:void(0);">View All</a></span>
		</div>
		
	
		
		
		
       <!-- END OF DIV-dashboard_box -->
		<?php /*?><div class="clr"></div>
        <div class="dashboard_box">
            <div class="title"><?php echo "New Members";?></div>
            <div class="content">
                <!--<ul>
                    <li><span style=" color:#FF0066;font-style:italic; font-weight:bold;">Total Number of Buyers : </span><a style="text-decoration:underline;" target="_blank" href="javascript:void(0)">5</a></li>
                    
                </ul> -->
            </div>
            
        </div>
         <!-- END OF DIV-dashboard_box -->   
        <div class="dashboard_box">
            <div class="title"><?php echo "Site Summary";?> </div>
            <div class="content">
                <ul>

                </ul> 
            </div>
            <div class="view_all"><a target="_blank" href="javascript:void(0);">View All</a></div>
        </div>    
		
		<div class="dashboard_box">
			<div class="title"><?php echo "Test";?> </div>
			<div class="content">
			    <ul>

				</ul> 
			</div>
			<div class="view_all"><a target="_blank" href="javascript:void(0);">View All</a></div>
		</div>
       <!-- END OF DIV-dashboard_box --><?php */?>
        <div class="clr"></div>
       
</div>
<!--END OF DIV-content -->
</div>
