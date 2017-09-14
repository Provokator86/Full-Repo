<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 30 March 2012
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

$('.description tr').filter(':odd').css('background','#f2f2f2');

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
    <h2><?php echo $info["s_title"];?></h2>
    <p>&nbsp;</p>
    
    	<div id="tabbar2" style="display:none;">
        <ul>
          <li><a href="javascript:void(0)" class="select" id="1"><span>Details</span></a></li>
          <li><a href="javascript:void(0)" id="2"><span>Quote(s)</span></a></li>
          <li><a href="javascript:void(0)" id="3"><span>Feedback</span></a></li>
		  <li><a href="javascript:void(0)" id="4"><span>History</span></a></li>
        </ul>
      </div>
	  <div id="tabcontent1">
		  <div id="div1">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<th width="15%" align="left"><h4>Job Information</h4></th>
				<th width="35%" align="left">&nbsp;</th>
				<th width="15%">&nbsp;</th>
				<th width="35%">&nbsp;</th>
			  </tr>
			  <tr>
				<td bgcolor="#f1f1f1">Title:</td>
				<td><?php echo $info["s_title"];?></td>
				<td bgcolor="#f1f1f1">Buyer Name:</td>
				<td><?php echo $info["s_buyer_name"];?></td>
				
			  </tr>
			  <tr>
				<td bgcolor="#f1f1f1">Category: </td>
				<td><?php echo $info["s_category_name"];?></td>
				<td bgcolor="#f1f1f1">Budget Price: </td>
				<td><?php echo $info["d_budget_price"];?> TL</td>
			  </tr>
			  <tr>
				<td bgcolor="#f1f1f1">Keywords: </td>
				<td><?php echo $info["s_keyword"];?></td>
				<td bgcolor="#f1f1f1">Quoting Periods: </td>
				<td><?php echo $info["i_quoting_period_days"];?> Week(s)</td>
			  </tr>
			  <tr>
				<td bgcolor="#f1f1f1">Supply Material: </td>
				<td><?php echo $info["s_supply_material"];?> </td>          
				<td bgcolor="#f1f1f1">Status: </td>
				<td><?php echo $info["s_is_active"];?></td>
			  </tr>
			  <tr>
				 <td bgcolor="#f1f1f1">Date Created: </td>
				<td><?php echo $info["dt_created_on"];?></td>
			   <td bgcolor="#f1f1f1">Date Expired: </td>
				<td><?php echo $info["dt_expired_on"];?></td>
			  </tr>
			   <tr>
				<td bgcolor="#f1f1f1">Date Approved:</td>
				<td><?php echo $info["dt_admin_approval_date"];?> </td>
				 <td bgcolor="#f1f1f1">Tradesman Assigned:</td>
				<td><?php echo $info["tradesman_name"];?></td>
			  </tr>
			  <?php 
				//echo $image_up_path."thumb_".$info["image"];
				$img = (!empty($info["image"])&&file_exists($image_up_path."thumb_".trim($info["image"])))?" <img src='".$image_path."thumb_".$info["image"]."' />":" <img src='images/admin/img.png'/>";
			?>
			  
			  <!--<tr>
			   <td bgcolor="#f1f1f1">Tradesman Assigned:</td>
				<td><?php echo $info["tradesman_name"];?></td>
			   
				<td bgcolor="#f1f1f1">&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>-->
			   <tr>
			   <td bgcolor="#f1f1f1">Description:</td>
				<td colspan="3"><?php echo $info["s_description"];?></td>
			   
				
			 
			 
			</table>
		 
			
			
		  </div>
		  <div id="div2" >
		  <div class="details_box" style="border:0 !important;">
            <div class="heading">Quote(s)</div>
            <div class="description" >
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                
                <tr>
                  <th align="left">Tradesman</th>				  
				  <th align="left">Comment</th>
                  <th align="left">Value</th> 
				  <th align="left">Date</th>                 
                  <th align="left">Status</th>
				 <?php /*?> <th align="left">Date</th><?php */?>
                </tr>
				 <?php 
			  		if(count($quote_list)>0)
					{
						foreach($quote_list as $quote)
						{
						?>
						
                <tr>
                  <td ><a title="View" href="<?php echo admin_base_url().'tradesman_profile_view/index/'.encrypt($quote["i_tradesman_id"]);?>"><?php echo $quote['s_username']?></td>   
				   <td width="25%"><?php echo $quote['s_comment']?></td> 
				  <td width="20%"><?php echo $quote['s_quote']?></td>              
                  <td width="20%"><?php echo $quote['dt_entry_date']?></td>				  
                  <td width="10%"><?php echo $quote['s_status']?></td>
				 <?php /*?> <td width="10%"><?php echo $job['dt_created_on']?></td><?php */?>
                </tr>
               <?php
						}
					}
					else
					{
			  ?>
			  		<tr>
					  <td  colspan="5">No record found</td>
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
				  <th align="left">Tradesman</th>
				  <th align="left">Rating</th>                 
                  <th align="left">Type</th>
				  <th align="left">Date</th>
				 <?php /*?> <th align="left">Status</th><?php */?>
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
				  <td width="10%"><?php echo $feed['s_receiver_user']?></td>
				  <td width="10%"><?php echo show_star($feed['i_rating'])?></td>
                  <td width="10%"><?php echo $feed['s_positive']?></td>
				  <td width="10%"><?php echo $feed['dt_created_on']?></td>
				<?php /*?>  <td width="10%"><?php echo $feed['s_status']?></td><?php */?>
                </tr>
               <?php
						}
					}
					else
					{
			  ?>
			  		<tr>
					  <td  colspan="5">No record found</td>
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
            <div class="heading">History</div>
            <div class="description">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                
                  <tr>
					  <th align="left">Status</th>
					 
					</tr>
				 <?php 
			  		if(count($history_details)>0)
					{
						foreach($history_details as $feed)
						{
						?>
						
                <tr>
                  <td ><?php echo $feed['msg_string']?></td>
                 
                
                </tr>
               <?php
						}
					}
					else
					{
			  ?>
			  		<tr>
					  <td >No record found</td>
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