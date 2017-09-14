<?php
/*********
* Author: Koushik Rout
* Date  : 26 April 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For province detail
* 
* @package General
* @subpackage province
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/province/
*/

    /////////Css For Popup View//////////
    echo $css;
?>

<?php
    /////////Javascript For Popup View//////////
    echo $js;
?>
<base href="<?php echo base_url(); ?>" />
<script language="javascript">
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){
    
    //$("table tr td").css("float","right");
    
})});    
</script>
<script type="text/javascript">
  jQuery(function($) {
 
    var galleries = $('.ad-gallery').adGallery();
    $('#switch-effect').change(
      function() {
        galleries[0].settings.effect = $(this).val();
        return false;
      }
    );
    $('#toggle-slideshow').click(
      function() {
        galleries[0].slideshow.toggle();
        return false;
      }
    );
  });
  </script>  
    
<style>
   /*  banner*/


table td {font-family:Arial, Helvetica, sans-serif; font-size: 12;}
</style>
<div>

    <p>&nbsp;</p>
    <div id="div_err">
        <?php
          show_msg();  
        ?>
    </div>     
    <div >
    <? /*****Modify Section Starts*******/?>
    <div  style="float: left;  width: 45%;">
      <table  border="0" cellspacing="0" cellpadding="0" width="95%">
            <tr><td colspan="2" style="background-color: #D0D0D0;"><strong>Basic Informaion</strong></td></tr>
            <tr><td width="130px"><strong>Property ID :</strong></td><td><?php echo $info['s_property_id']; ?></td></tr>
            <tr><td><strong>Property Name :</strong></td><td><?php echo $info['s_property_name']; ?></td></tr>
            <tr><td><strong>Owner Name :</strong></td><td><?php echo $info['s_first_name'].' '.$info['s_last_name']; ?></td></tr>
            <tr><td><strong>Owner Email :</strong></td><td><?php echo $info['s_email']; ?></td></tr>
            <tr><td><strong>Bank/Paypal Details :</strong></td><td><?php echo $info['s_paypal_details']; ?></td></tr>  
            
            
            <tr><td colspan="2"><td></tr>
            <tr><td colspan="2" style="background-color: #D0D0D0;"><strong>Location</strong></td></tr>
            
            <tr><td><strong>City :</strong></td><td><?php echo $info['s_city']; ?></td></tr>
            <tr><td><strong>State :</strong></td><td><?php echo $info['s_state']; ?></td></tr>
            <tr><td><strong>Country :</strong></td><td><?php echo $info['s_country']; ?></td></tr>
            <tr><td><strong>Zipcode :</strong></td><td><?php echo $info['s_zipcode']; ?></td></tr>
            
            <tr><td colspan="2"><td></tr>
            <tr><td colspan="2" style="background-color: #D0D0D0;" ><strong>Feature/Facilities</strong></td></tr>
            <tr><td><strong>Accommdation :</strong></td><td><?php echo $info['e_accommodation_type']; ?></td></tr>
            <tr><td><strong>Property Type :</strong></td><td><?php echo $info['s_property_type_name']; ?></td></tr>
            <tr><td><strong>Guests :</strong></td><td><?php echo $info['i_total_guests']; ?></td></tr>
            <tr><td><strong>Bed Type :</strong></td><td><?php echo $info['s_bed_type_name']; ?></td></tr>
            <tr><td><strong>Bed Rooms :</strong></td><td><?php echo $info['i_total_bedrooms']; ?></td></tr>
            <tr><td><strong>Bath Rooms :</strong></td><td><?php echo $info['i_total_bathrooms']; ?></td></tr>
            <tr><td><strong>Aminities :</strong></td><td><?php echo $s_amenities; ?></td></tr>
            
            <tr><td colspan="2"><td></tr>
            <tr><td colspan="2" style="background-color: #D0D0D0;"><strong>Price</strong></td></tr>
            <tr><td><strong>Standard Price :</strong></td><td><?php echo $info['s_currency_symbol'].$info['d_standard_price']; ?></td></tr>
            <tr><td><strong>Weekly Rate :</strong></td><td><?php echo $info['s_currency_symbol'].$info['d_weekly_price']; ?></td></tr>
            <tr><td><strong>Monthly Rate :</strong></td><td><?php echo $info['s_currency_symbol'].$info['d_monthly_price']; ?></td></tr>
            <tr><td><strong>Additional Guests :</strong></td><td><?php echo $info['s_currency_symbol'].$info['d_additional_price']; ?></td></tr>
            
            
            <tr><td colspan="2"><td></tr>
            <tr><td colspan="2" style="background-color: #D0D0D0;"><strong>Condition</strong></td></tr>
            <tr><td><strong>Check in After :</strong></td><td>
			<?php 
			if($info['i_checkin_after']<12){ echo  $info['i_checkin_after'].' AM'; }
			else if($info['i_checkin_after']>12 && $info['i_checkin_after']<=23) { echo ($info['i_checkout_before']-12).' PM'; }
			else if($info['i_checkin_after']==12) { echo $info['i_checkin_after'].' PM';}
			else if($info['i_checkin_after']>23) { echo ($info['i_checkout_before']-12).' AM';}
			
			?>
			<?php //echo $info['i_checkin_after']<=12?$info['i_checkin_after'].' AM':($info['i_checkin_after']-12).' PM'; ?>
			</td></tr>
            <tr><td><strong>Check in Before :</strong></td><td>
			<?php 
			if($info['i_checkout_before']<12){ echo  $info['i_checkout_before'].' AM'; }
			else if($info['i_checkout_before']>12 && $info['i_checkout_before']<=23) { echo ($info['i_checkout_before']-12).' PM'; }
			else if($info['i_checkout_before']==12) { echo $info['i_checkout_before'].' PM';}
			else if($info['i_checkout_before']>23) { echo ($info['i_checkout_before']-12).' AM';}
			
			?>
			<?php //echo $info['i_checkout_before']<=12?$info['i_checkout_before'].' AM':($info['i_checkout_before']-12).' PM'; ?>
			</td></tr>
            <tr><td><strong>Cancellation Policy :</strong></td><td><?php echo $info['s_cancellation_policy_name']; ?></td></tr>
            
     

      </table>
      </div>
      <div  style="float: right;  width: 54%; " >
            <div id="container">
          <div id="gallery" class="ad-gallery">
            <div class="ad-image-wrapper"> </div>
            <div class="ad-nav" >
              <div class="ad-thumbs">
                <ul class="ad-thumb-list">
                <?php  
                    if($arr_image)
                    {
                        foreach($arr_image as $val)
                        { ?>
                           <li> <a href="<?php echo base_url()."uploaded/property/large/".$val["large"] ?>"><img src="<?php echo base_url()."uploaded/property/min/".$val["min"] ?>" alt=""  title="" /></a> </li> 
              
                 <?php                
                        }
               
                        
                    } 
                ?>
                  
                 <!-- <li> <a href="uploaded/property/2.jpg"><img src="uploaded/property/thumbs/t2.jpg" alt=""  title="" /></a> </li>
                  <li> <a href="uploaded/property/3.jpg"><img src="uploaded/property/thumbs/t3.jpg" alt=""  title="" /></a> </li>
                  <li> <a href="uploaded/property/4.jpg"><img src="uploaded/property/thumbs/t4.jpg" alt=""  title="" /></a> </li>
                  <li> <a href="uploaded/property/5.jpg"><img src="uploaded/property/thumbs/t5.jpg" alt=""  title="" /></a> </li>
                  <li> <a href="uploaded/property/6.jpg"><img src="uploaded/property/thumbs/t6.jpg" alt=""  title="" /> </a> </li>
                  <li> <a href="uploaded/property/7.jpg"><img src="uploaded/property/thumbs/t7.jpg" alt=""  title="" /></a> </li>
                  <li> <a href="uploaded/property/8.jpg"><img src="uploaded/property/thumbs/t8.jpg" alt=""  title="" /></a> </li>
                  <li> <a href="uploaded/property/9.jpg"><img src="uploaded/property/thumbs/t9.jpg" alt=""  title="" /></a> </li>   -->
                </ul>
              </div>
            </div>
            <div class="spacer"></div>
          </div>
        </div>
        <div class="spacer"></div> 
         <div  style="margin-top: 5px;;" >
         <table>
         <tr><td style="background-color: #D0D0D0;"><strong>Description </strong></td></tr>
         <tr><td><p><?php echo $info['s_description']; ?></p></td></tr>
         <tr><td>&nbsp;</td></tr>
         <tr><td style="background-color: #D0D0D0;"><strong>House Rules </strong></td></tr>
         <tr><td><p><?php echo $info['s_house_rules']; ?></p></td></tr>
         </table>
         </div>
        
      </div>
    <? /*****end Modify Section*******/?>      
    </div>

</div>
