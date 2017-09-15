<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 9 june 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For news detail
* 
* @package Content Management
* @subpackage news
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/news/
*/

    /////////Css For Popup View//////////
    echo $css;
?>

<?php
    /////////Javascript For Popup View//////////
    echo $js;
?>
<script language="javascript">
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){
    $("#show_hide").click();
	$("#tabbar2 ul li a").click(function() {
		
		   $( '#tabbar2 ul li a').each(function(){
			 $('#tabbar2 ul li a').removeClass();
			 currentId = $(this).attr('id');
			 $('#div'+currentId).hide();
		   }); 
		   
		   $(this).addClass('select');
		   currentId = $(this).attr('id');
		   $('#div'+currentId).show();
		});
})});    
</script>    

<div id="right_panel">
    <h2>Account: <?php echo $info["s_name"];?></h2>
    <p>&nbsp;</p>
    
    	<div id="tabbar2">
        <ul>
          <li><a href="javascript:void(0)" class="select" id="1"><span>Profile</span></a></li>
          <li><a href="javascript:void(0)" id="2"><span>Job(s)</span></a></li>
          <li><a href="javascript:void(0)" id="3"><span>Feedback</span></a></li>
		  <li><a href="javascript:void(0)" id="4"><span>Referral</span></a></li>
        </ul>
      </div>
	  <div id="tabcontent">
		  <div id="div1">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<th width="15%" align="left"><h4>Account Information</h4></th>
				<th width="35%" align="left">&nbsp;</th>
				<th width="15%">&nbsp;</th>
				<th width="35%">&nbsp;</th>
			  </tr>
			  <tr>
			  
				<td bgcolor="#f1f1f1">Name:</td>
				<td><?php echo $info["s_name"];?></td>
				<td bgcolor="#f1f1f1">Email:</td>
				<td><?php echo $info["s_email"];?></td>
				
			  </tr>
			  <tr>
				<td bgcolor="#f1f1f1">Username: </td>
				<td><?php echo $info["s_username"];?></td>
				<td bgcolor="#f1f1f1">Skype ID: </td>
				<td><?php echo $info["s_skype_id"];?></td>
			  </tr>
			  <tr>
				<td bgcolor="#f1f1f1">State: </td>
				<td><?php echo $info["s_state"];?></td>
				<td bgcolor="#f1f1f1">MSN ID: </td>
				<td><?php echo $info["s_msn_id"];?></td>
			  </tr>
			  <tr>
				<td bgcolor="#f1f1f1">Postal code: </td>
				<td><?php echo $info["s_zip"];?> </td>          
				<td bgcolor="#f1f1f1">Yahoo ID: </td>
				<td><?php echo $info["s_yahoo_id"];?></td>
			  </tr>
			  <tr>
				 <td bgcolor="#f1f1f1">Address: </td>
				<td><?php echo $info["s_address"];?></td>
			   <td bgcolor="#f1f1f1">Contact No: </td>
				<td><?php echo $info["s_contact_no"];?></td>
			  </tr>
			  <?php 
				//echo $image_path."thumb_".$info["s_user_image"];
				$img = (!empty($info["s_user_image"])&&file_exists($image_up_path."thumb_".trim($info["s_user_image"])))?" <img src='".$image_path."thumb_".$info["s_user_image"]."' height='65px' width='65px' />":" <img src='images/admin/img.png'/>";
			?>
			  
			  <tr>
			   <td bgcolor="#f1f1f1">Profile picture:</td>
				<td><?php echo $img;?> </td>
			   
				<td bgcolor="#f1f1f1">&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td bgcolor="#f1f1f1">Created On:</td>
				<td><?php echo $info["dt_created_on"];?> </td>
				<td bgcolor="#f1f1f1">Status</td>
				<td><?php echo $info["s_is_active"];?></td>
			  </tr>
			 
			</table>
		 
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<th width="15%" align="left"><h4>History</h4></th>
				<th width="35%" align="left">&nbsp;</th>
				<th width="15%">&nbsp;</th>
				<th width="35%">&nbsp;</th>
			  </tr>
			  <tr>
				<td bgcolor="#f1f1f1">Total Job(s) Worked:</td>
				<td><?php echo count($job_list);?></td>
				
			  </tr>
			
			</table>
			
		  </div>
		  <div id="div2" style="display:none;">
		  <div class="details_box" style="border:0 !important;">
            <div class="heading">Job(s) worked on</div>
            <div class="description" >
              <table width="100%" border="0" cellspacing="0" cellpadding="0">                
                <tr>
                  <th align="left">Title</th>
                  <th align="left">Keyword</th> 
				  <th align="left">Category</th>                 
                  <th align="left">Status</th>
				  <?php /*?><th align="left">Date</th><?php */?>
                </tr>
				 <?php 
			  		if(count($job_list)>0)
					{
						foreach($job_list as $job)
						{
							?>
							<tr>
							  <td ><?php echo $job['s_title']?></td>     
							   <td width="20%"><?php echo $job['s_keyword']?></td>            
							  <td width="25%"><?php echo $job['s_category_name']?></td>							 
							  <td width="10%"><?php echo $job['s_is_active']?></td>
							 <?php /*?> <td width="10%"><?php echo $job['dt_created_on']?></td><?php */?>
							</tr>
						   <?php
						}
					}
					else
					{
			  ?>
			  		<tr>
					  <td  colspan="4">No record found</td>
					</tr>
			  <?php
						
					}
			  ?>
              </table>
            </div>
          </div>
			
		  </div>
		  <div id="div3" style="display:none;">
		 	 <div class="details_box" style="border:0 !important;">
            <div class="heading">Feedback</div>
            <div class="description">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                
                <tr>
                  <th align="left">Job</th>
                  <th align="left">Comments</th> 
				  <th align="left">Buyer</th>
				  <th align="left">Rating</th>                 
                  <th align="left">Type</th>
				  <th align="left">Date</th>
				  <th align="left">Status</th>
                </tr>
				 <?php 
			  		if(count($feedback_list)>0)
					{
						foreach($feedback_list as $feed)
						{
						?>
						
                <tr>
                  <td ><?php echo $feed['s_job_title']?></td>
                 
                  <td width="25%"><?php echo $feed['s_comments']?></td>
				  <td width="10%"><?php echo $feed['s_sender_user']?></td>
				  <td width="10%"><?php echo show_star($feed['i_rating'])?></td>
                  <td width="10%"><?php echo $feed['s_positive']?></td>
				  <td width="10%"><?php echo $feed['dt_created_on']?></td>
				  <td width="10%"><?php echo $feed['s_status']?></td>
                </tr>
               <?php
						}
					}
					else
					{
			  ?>
			  		<tr>
					  <td  colspan="6">No record found</td>
					</tr>
			  <?php
						
					}
			  ?>
              </table>
            </div>
          </div>
		  </div>
		  <div id="div4" style="display:none;">
		 	 <div class="details_box" style="border:0 !important;">
            <div class="heading">Referral</div>
            <div class="description">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                
                <tr>                  
				  <th align="left">Name</th>
				  <th align="left">Email</th>
				  <th align="left">Referral Date</th>
				  <th align="left">Status</th>
                </tr>
				 <?php 
			  		if(count($rec_list)>0)
					{
						foreach($rec_list as $feed)
						{
						?>
						
                <tr>
				  <td width="10%"><?php echo $feed['s_name']?></td>
				  <td width="10%"><?php echo $feed['s_email']?></td>
				  <td width="10%"><?php echo $feed['dt_recommend_on']?></td>
				  <td width="10%"><?php echo $feed['s_is_active']?></td>
                </tr>
               <?php
						}
					}
					else
					{
			  ?>
			  		<tr>
					  <td  colspan="6">No record found</td>
					</tr>
			  <?php
						
					}
			  ?>
              </table>
            </div>
          </div>
		  </div>
		  
	  </div>
  

  </div>