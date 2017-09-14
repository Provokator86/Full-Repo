<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 02 May 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For tradesmen detail
* 
* @package Content Management
* @subpackage news
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/tradesman_profile_view/
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
	  <div id="tabcontent1">
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
			  	<td bgcolor="#f1f1f1">Social Media: </td>
				<td><?php echo (!empty($info['i_sm']))?$info["s_sm"].' ('.$info["s_type_sm"].')':"";?></td>
				<td bgcolor="#f1f1f1">City: </td>
				<td><?php echo $info["s_city"];?></td>
				<!--<td bgcolor="#f1f1f1">Skype ID: </td>
				<td><?php echo $info["s_skype_id"];?></td>
				<td bgcolor="#f1f1f1">MSN ID: </td>
				<td><?php echo $info["s_msn_id"];?></td>-->
			  </tr>
			  <tr>					
				<td bgcolor="#f1f1f1">Province: </td>
				<td><?php echo $info["s_state"];?></td>
				<td bgcolor="#f1f1f1">Zip code: </td>
				<td><?php echo $info["s_zip"];?> </td>  
			  </tr>
			  <tr>				 
				<td bgcolor="#f1f1f1">Address: </td>
				<td><?php echo $info["s_address"];?></td>  
				<td bgcolor="#f1f1f1">Address2: </td>
				<td><?php echo $info["s_address2"];?></td>    
				
			  </tr>
			  <?php /*?><tr>
				<td bgcolor="#f1f1f1">Address2: </td>
				<td><?php echo $info["s_address2"];?></td>
			   <td bgcolor="#f1f1f1">Contact No: </td>
				<td><?php echo $info["s_contact_no"];?></td>
			  </tr><?php */?>
			  
			  <?php 
				
				$img = (!empty($info["s_profile_pic"]))?" <img src='".$image_path."thumb_".$info["s_profile_pic"]."' height='65px' width='65px' />":" <img src='images/admin/img.png'/>";
			?>
			  
			  <tr>
			   <td bgcolor="#f1f1f1">Profile picture:</td>
				<td><?php echo $img;?> </td>
			   
				<td bgcolor="#f1f1f1">About Tradesman</td>
				<td><?php echo $info["s_about_me"];?></td>
			  </tr>
              <tr>
                <td bgcolor="#f1f1f1">GSM NO:</td>
                <td><?php echo $info["s_gsm_no"];?> </td>
                <td bgcolor="#f1f1f1">TYPE</td>
                <td><?php echo $info["s_type"];?></td>
              </tr>
			  <?php if($info['i_trade_type'] == 2) { ?>
              <tr>
                <td bgcolor="#f1f1f1">Tax Office Name:</td>
                <td><?php echo $info["s_taxoffice_name"];?> </td>
                <td bgcolor="#f1f1f1">Tax No</td>
                <td><?php echo $info["s_tax_no"];?></td>
              </tr>
			  <?php } ?>
              <tr>
                <td bgcolor="#f1f1f1">Work places:</td>
                <td>
				<?php 
				if(!empty($info['workplace'])) 
				{ 
				foreach($info['workplace'] as $key=>$val) 
				{
					if(count($val)-1==$key)
					{
					$concat = '';
					}
					else
					{
					$concat = ', </br>';
					}
					echo $val['s_work_place'].$concat;					
				}
				} 
				?> </td>
                <td bgcolor="#f1f1f1">keyword</td>
                <td><?php echo $info["s_keyword"];?></td>
              </tr>
			  <tr>
				<td bgcolor="#f1f1f1">Category Specialist: </td>
				<td>
				<?php 
				if(!empty($info['category'])) 
					{ 
						$address = '<table width="600" border="0" cellspacing="0" cellpadding="0">';	
						$address .= '<tr>';	
						$address .= 	'<td width="60%" style="font-style:italic;">Category Name</td>';
						$address .= 	'<td width="40%" style="font-style:italic;">Year(s) of experience</td>';
						$address .= '</tr>';
					foreach($info['category'] as $key=>$val) 
					{		
							
						$address .= '<tr>';	
						$address .= 	'<td width="30%">'.$val['s_category_name'].'</td>';
						$address .= 	'<td width="70%" align="center">'.$val['s_experience'].'</td>';
						$address .= '</tr>';										
						
					}
						$address .='</table>';	
					}
					echo $address;
				?> 
				</td>
			   <td bgcolor="#f1f1f1">Payment Accept</td>
				<td><?php 
				if(!empty($info['payment_unit'])) 
					{ 
						$address = '<table width="600" border="0" cellspacing="0" cellpadding="0">';	
						$address .= '<tr>';	
						$address .= 	'<td width="45%" style="font-style:italic; text-align:center;">No.</td>';
						$address .= 	'<td width="50%" style="font-style:italic;text-align:center;">Payment Accept in</td>';
						$address .= '</tr>';
					foreach($info['payment_unit'] as $key=>$val) 
					{		
							
						$address .= '<tr>';	
						$address .= 	'<td width="30%" align="center">'.($key+1).'</td>';
						$address .= 	'<td width="30%">'.$val['s_payment_unit'].'</td>';
						$address .= '</tr>';										
						
					}
						$address .='</table>';	
					}
					echo $address;
				?> </td>
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
			<?php if($info['i_trade_type']==1) { ?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<th width="15%" align="left"><h4>Address Proof File</h4></th>
				<th colspan="3"align="left">&nbsp;</th>
				
			  </tr>
			  <?php 
			  if(count($info['s_address_file'])>0) {			  	
			  ?>
				  <tr>
					<td bgcolor="#f1f1f1"><?php echo 'File '.$i++;?></td>
					<td colspan="3"><a href="<?php echo base_url().'admin/tradesman_profile_view/download_address/'.encrypt($info['s_address_file']);?>"><?php echo t('Download')?></a></td>
					
				  </tr>
			<?php	}  ?>
			
			</table>
			<?php } ?>
			
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
					  <td  colspan="7">No record found</td>
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