<?php
/*********
* Author:  Koushik Rout
* Date  :  20 july 2012
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
/*$('.left_inside_box ul li').filter(':even').css('background','#EBEBEB');
*/

})});    
</script>

<div id="right_panel">
    <div class="left_dashboard">
        

        <div class="clr"></div>
         <div class="left_inside_box">
         <div class="title">Latest Users</div>
			 <div class="cont">
				 <ul>
				 	<?php if($users) {
							foreach($users as $value)
								{
					 ?>
					 <li><?php echo $value["s_first_name"].' '.$value["s_last_name"] ?> <br/><?php echo $value["s_city"]?>, <?php echo $value["s_state"]?>,<?php echo $value["s_country"]?></li>
					 <?php } } else { ?>
					 <ul>
					 <li>No user found.</li>
					 </ul>
					 <?php } ?>
				 </ul>	
				 <!--<p>&nbsp;</p>
				 <div class="view_link"><a id="new_2" href="javascript:void(0);">View All</a></div>-->
			 </div>	 	 
        </div>
        <div class="clr"></div>
        <div class="left_inside_box">
        <div class="title">Latest Properties</div>
			<div class="cont">
             <ul>
			 	<?php if($property) {
						foreach($property as $value)
							{
				 ?>
                 <li><?php echo $value["s_property_name"] ?> ( owner - <?php echo $value["s_first_name"].' '.$value["s_last_name"]?>) <br/><?php echo $value["s_city"]?>, <?php echo $value["s_state"]?>,<?php echo $value["s_country"]?>,<?php echo $value["s_zipcode"]?></li>
				 <?php } } else { ?>
				 <ul>
				 <li>No property found.</li>
				 </ul>
				 <?php } ?>
             </ul>	
			<!-- <p>&nbsp;</p>
             <div class="view_link"><a id="new_2" href="javascript:void(0);">View All</a></div>-->
		 </div>	        
        </div>
		<div class="clr"></div>
    </div>
    <!--END OF DIV-left_dashboard -->
    
    
<div class="right_dashboard">
       
            <div class="dashboard_box">
                <div class="title">Latest Booking</div>
                <div class="content">
                   <ul>
				   	<?php if($booking) {
						foreach($booking as $value)
							{
				 	?>
					 <li><?php echo $value["s_property_name"] ?> ( book by - <?php echo $value["s_first_name"].' '.$value["s_last_name"]?>) <br/>Booked from - <?php echo $value["dt_booked_from"] ?> to <?php echo $value["dt_booked_to"] ?></li>
					  <?php } } else { ?>
					  <ul>
					 <li>No booking found.</li>
					 </ul>
					 <?php } ?>
				   </ul>	
                   <!-- <p>&nbsp;</p>
                    <div class="view_all"><a id="new_2" href="javascript:void(0);">View All</a></div>-->
                </div>
                
            </div>
           <!-- END OF DIV-dashboard_box -->
            
            <div class="clr"></div>
            <div class="dashboard_box">
                <div class="title">Latest newsletter subscribers</div>
                <div class="content">
					<?php if($subscribers) {
						foreach($subscribers as $value)
							{
				 	?>
                    <ul>                    
                        <li><?php echo $value["s_name"] ?> <br/>Subscribed on : <?php echo $value["dt_created_on"] ?></li>
                    </ul>    
					 <?php } } else { ?>
					 <ul>
					 <li>No subscribers found.</li>
					 </ul>
					 <?php } ?>                
                    <!--<p>&nbsp;</p>
                    <div class="view_all"><a id="active_2" href="javascript:void(0);">View All</a></div>-->                    
                </div>
                
            </div>
           
           <div class="clr"></div>
            
    
    <!--END OF DIV-content -->
</div>
<!--END OF DIV-right_dashboard -->
</div>

