<script type="text/javascript">
$(document).ready(function() {

    
    $("#show-all_child a").click(function(){
        var filter_option   =   $("#show-all").val();
       $.ajax({
                            type: "POST",
                            async: false,
                            url: base_url+'account/ajax_pagination_property_booking_list',
                            data: "filter_option="+filter_option,
                            success: function(msg){
                                if(msg)
                                { 
                                    $("#property_list").html(msg);                                                          
                                }
                            }
                        });
    });
});
function approveBookingRequest(booking_id,cur_obj)
{
    jQuery(function($){
        jConfirm('Are you sure to approve this booking?', 'Confirmation Box', function(r) {
            
            if(r)
            {
                $.ajax({
                            type: "POST",
                            async: false,
                            url: base_url+'account/ajax_approve_booking',
                            data: "booking_id="+booking_id,
                            success: function(msg){
                                if(msg)
                                {                                                           
                                    if(msg=='success')
                                    {
                                        jAlert('Booking is successfully approved.', 'Success Approval');
                                        $(cur_obj).parent().html('Approved');
                                      
                                    }
                                    
                                }
                            }
                        });   
                      
                
            }
           
            });
        
        
        
    });
    
}
/**
* This function is to show the shadow box details of booking 
*/
function show_booking_details(booking_id)
{
   
    jQuery(function($){
        $.ajax({
                            type: "POST",
                            async: false,
                            url: base_url+'account/ajax_fetch_booking_details',
                            data: "booking_id="+booking_id,
                            success: function(msg){
                                if(msg)
                                {
                                $("#lightbox_inner").html(msg)   ;                                                        
                                 show_dialog('photo_zoom10');
                                }
                            }
                        });
    });
    
}
</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="container-box">
	<?php include_once(APPPATH."views/fe/common/account_left_menu.tpl.php"); ?>
	<div class="right-part02">
	  <div class="text-container">
		<div class="inner-box03">
			  <div class="page-name02 margin00"><span>My  Property Booking</span> <select id="show-all" name="show-all" style="width:114px;"> 
              <option value="1">Show All</option>
              <option value="2">Requested</option>
              <option value="3">Approved</option>
              <option value="4">Ammount Paid</option>
              </select></div>
			  <div class="spacer">&nbsp;</div>
			  
                <div id="property_list">
                    <?php echo $property_list ?>
                </div>
			 

			  <div class="spacer">&nbsp;</div>
		</div>
	  </div>
	</div>
	<br class="spacer" />
</div>


<div class="light-box photo_zoom10">
      <div class="close"><a href="javascript:void(0)" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
      
      <h4>Booking details</h4>
      <div class="spacer"></div>
      <div id="lightbox_inner">
     
      </div>
</div>