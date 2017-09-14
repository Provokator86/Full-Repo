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
<style>
.dash_th{text-align:left; padding:5px 0px;font:bold 14px Arial, Helvetica, sans-serif !important; color:#FFFFFF;}
.dash_th span{ margin-left:4px !important;}
</style>

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
    <br />
    <!--h4>Site Statistics :</h4-->
    <div style="clear:both"></div>
    
  <!-- ============= dashboard Statistics div ============= -->  
  
  <!-- ============= end dashboard user information div ============= -->  
        
  <!-- ============= dashboard notification div ============= -->  
 
  <!-- ============= end dashboard notification div ============= -->
 <!-- <div id="tabcontent">
  
         <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th colspan="2" class="dash_th"><span>Total Member(s) Join Today</span></th>
            <th colspan="2"  class="dash_th"><span>Total Story Uploaded Today</span></th>
             <th colspan="2" class="dash_th"><span>Posted Comments Today</span></th>
            <?php if($user_type_id === '0'){?>
            <th colspan="2"  class="dash_th"><span>Total Payment Made Today</span></th>
            <?php  }?>
          </tr>
          <tr>
            <td bgcolor="#E9E9E9" width="18%">Authors : </td>
            <td width="5%"><strong><?php echo $member_join_today["i_tot_author"]?></strong></td>
            <td bgcolor="#E9E9E9" width="20%">Stories : </td>
            <td width="5%"> <strong><?php echo $story_uploaded_today[0]["i_tot_story"] > 0 ? $story_uploaded_today[0]["i_tot_story"] : 0;?></strong></td>
             <td bgcolor="#E9E9E9" width="16%">On Stories  : </td>
            <td width="5%"> <strong><?php echo $comment_on_story[0]["i_total_comment"] > 0 ? $comment_on_story[0]["i_total_comment"] : 0;?></strong></td>
            <?php if($user_type_id === '0'){?>
            <td bgcolor="#E9E9E9" width="23%"> Payments on Story Sold : </td>
            <td width="8%" align="right"><?php echo $story_sold_payment['net_price'] != ''?$indian_symbol.$story_sold_payment['net_price'] : 'Nil';?></td>
            <?php }?>
          </tr>
          <tr>
            <td bgcolor="#E9E9E9" width="18%">Retailers : </td>
            <td> <strong><?php echo $member_join_today["i_tot_retailer"]?></strong></td>
            <td bgcolor="#E9E9E9" width="20%">Articles : </td>
            <td> <strong><?php echo $story_uploaded_today[1]["i_tot_story"] > 0 ? $story_uploaded_today[1]["i_tot_story"] : 0;?></strong></td>
            <td bgcolor="#E9E9E9" width="16%">On Articles : </td>
            <td> <strong><?php echo $comment_on_story[0]["i_total_comment"] > 0 ? $comment_on_story[0]["i_total_comment"] : 0;?></strong></td>
            <?php if($user_type_id === '0'){?>
            <td bgcolor="#E9E9E9" width="23%">Payments on Advertisement : </td>
             <td  align="right"><?php echo $advertisement_payment['net_price'] != ''?$indian_symbol.$advertisement_payment['net_price'] : 'Nil' ;?></td>
            <?php }?>
          </tr>
          <tr>
            <td bgcolor="#E9E9E9" width="18%">Readers : </td>
            <td> <strong><?php echo $member_join_today["i_tot_readers"]?></strong></td>
            <td bgcolor="#E9E9E9" width="20%">Episodes : </td>
            <td> <strong><?php echo $story_uploaded_today[2]["i_tot_story"] > 0 ? $story_uploaded_today[2]["i_tot_story"] : 0;?></strong></td>
            <td bgcolor="#E9E9E9" width="16%">On Episodes : </td>
            <td> <strong><?php echo $comment_on_story[0]["i_total_comment"] > 0 ? $comment_on_story[0]["i_total_comment"] : 0;?></strong></td>
            <?php if($user_type_id === '0'){?>
            <td bgcolor="#E9E9E9" width="23%">Payments on Publisher Books Sold : </td>
            <td align="right"><?php echo $publisher_book_sold_payment['net_price'] !='' ? $indian_symbol.$publisher_book_sold_payment['net_price'] : 'Nil';?></td>
            <?php }?>
          </tr>
          <tr>
            <td bgcolor="#E9E9E9" width="18%">Publishers : </td>
            <td> <strong><?php echo $member_join_today["i_tot_publishers"]?></strong></td>
            <td bgcolor="#E9E9E9" width="20%">Reader's Club Created Today : </td>
            <td> <strong><?php echo $reader_club_join["i_total_reader_club_join"]?></strong></td>
            <td bgcolor="#E9E9E9" width="16%">On Publisher’s Book : </td>
            <td> <strong><?php echo $comment_on_publishers_book["i_total_comment"] > 0 ? $comment_on_publishers_book["i_total_comment"] : 0;?></strong></td>
            <?php if($user_type_id === '0'){?>
            <td bgcolor="#E9E9E9" width="23%">Payments on Retailer Subscription : </td>
            <td align="right"> <?php echo ($retailer_subscription_payment['net_price']!='')?$retailer_subscription_payment['net_price']:'Nil'; ?></td>
            <?php }?>
          </tr>
          <tr>
            <td bgcolor="#E9E9E9" width="18%">Advertiser : </td>
            <td> <strong><?php echo $member_join_today["i_tot_advertiser"]?></strong></td>
            <td bgcolor="#E9E9E9" width="20%">&nbsp;</td>
            <td>&nbsp;</td>
            <td bgcolor="#E9E9E9" width="16%">On Clubs Today : </td>
            <td> <strong><?php echo $comment_on_reader_club_msg["i_total_comment"] > 0 ? $comment_on_reader_club_msg["i_total_comment"] : 0;?></strong></td>
            <?php if($user_type_id === '0'){?>
            <td bgcolor="#E9E9E9" width="23%">Payments Collected Today :</td>
            <?php $total_collected  =    $story_sold_payment['net_price'] + $advertisement_payment['net_price'] + $publisher_book_sold_payment['net_price']+$retailer_subscription_payment['net_price']; ?>
            <td align="right"><?php echo $total_collected !='' ? $indian_symbol.$total_collected : 'Nil'; ?> </td>
            <?php }?>
          </tr>
          <tr>
            <td bgcolor="#E9E9E9" width="18%">Translator : </td>
            <td> <strong><?php echo $member_join_today["i_tot_translator"]?></strong></td>
            <td bgcolor="#E9E9E9" width="20%">&nbsp;</td>
            <td>&nbsp;</td>
            <td bgcolor="#E9E9E9" width="16%">&nbsp; </td>
            <td> <strong> </strong></td>
            <?php if($user_type_id === '0'){?>
            <td bgcolor="#E9E9E9" width="23%">&nbsp;</td>
            <td>&nbsp;</td>
            <?php }?>
          </tr>
        </table> 
        
        <p>&nbsp;</p>
		
		 <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th colspan="2" class="dash_th"><span>Story downloaded this week</span></th>
            <th colspan="2"  class="dash_th"><span>Story downloaded this month</span></th>
			<th colspan="2"  class="dash_th"><span>Story downloaded this year</span></th>
          
          </tr>
          <tr>
            <td bgcolor="#E9E9E9" width="18%">Total : </td>
            <td width="5%"><strong><?php echo $weekly_download > 0 ? $weekly_download : 0;?></strong></td>
            <td bgcolor="#E9E9E9" width="20%">Total : </td>
            <td width="5%"> <strong><?php echo $monthly_download > 0 ? $monthly_download : 0;?></strong></td>
			 <td bgcolor="#E9E9E9" width="20%">Total : </td>
            <td width="5%"> <strong><?php echo $yearly_download > 0 ? $yearly_download : 0;?></strong></td>
            
          </tr>
		  </table>
		  
		   <p>&nbsp;</p>
        
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th class="dash_th"><span>Latest Five Notifications</span></th>
          </tr>
          <?php
          if(!empty($latest_notification))
		  {
				foreach($latest_notification as $val)
				{
					echo '<tr><td>'.$val["msg"].'on '.$val["dt_created_on"].'</td></tr>';	
				} 
				echo '<tr><td><a href= "'.admin_base_url().'manage_notification/">View All</a></td></tr>'; 
		  }
		  else
		  {
				echo '<tr><td>No notification yet</td></tr>'; 
		  }
		  ?>
        </table>
  </div>
 -->
 <?php /*?><div id="content">   
		<div class="dashboard_box">
			<div class="title"><span><?php echo "Total Member(s) Join Today";?></span></div>
			<div class="content">
            

            
				<!--<ul>
					<li><span style=" color:#FF0066;font-style:italic; font-weight:bold;">Total Number of Buyers : </span><a style="text-decoration:underline;" target="_blank" href="javascript:void(0)">5</a></li>
					
				</ul> -->
			</div>
		<?php if(decrypt($user_type_id) == 0)
        {
        ?>	
		</div>
		 <!-- END OF DIV-dashboard_box -->   
		<div class="dashboard_box">
			<div class="title"><?php echo "New Stories";?> </div>
			<div class="content">
			    <ul>

				</ul> 
			</div>
			<div class="view_all"><a target="_blank" href="javascript:void(0);">View All</a></div>
		</div>	
       <!-- END OF DIV-dashboard_box -->
		<div class="clr"></div>
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
       <!-- END OF DIV-dashboard_box -->
       <div class="clr"></div>
       <?php }?>
        
       
</div><?php */?>
<!--END OF DIV-content -->
<p>&nbsp;</p>
</div>


