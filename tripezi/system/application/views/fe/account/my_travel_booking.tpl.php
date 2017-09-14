<script type="text/javascript">

function cancelBooking(booking_id,cur_obj)
{
   
    jQuery(function($){
         jConfirm('Are you sure to cancel this booking?', 'Confirmation Box', function(r) {
            
            if(r)
            {
                         $.ajax({
                                type: "POST",
                                async: false,
                                url: base_url+'account/ajax_cancel_booking',
                                data: "booking_id="+booking_id,
                                success: function(msg){
                                    if(msg)
                                    {                                                           
                                        if(msg=='success')
                                        {
                                            jAlert('Booking is successfully canceled.', 'Success Cancellation');  
                                            $(cur_obj).parent().html('Awaiting for admin response');
                                          
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
<?php include_once(APPPATH."views/fe/common/message.tpl.php"); ?>
	<?php include_once(APPPATH."views/fe/common/account_left_menu.tpl.php"); ?>
	<div class="right-part02">
	  <div class="text-container">
		<div class="inner-box03">
			  <div class="page-name02 margin00">My Travel &amp; Booking</div>
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

 <!--lightbox to post review -->
<div class="light-box review-bg photo_zoom02">
<div id="div_err2">
</div>
      <div class="close"><a href="javascript:void(0)" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
      <h4>Post Your Reviews</h4>
      <div class="form-box">
      <form name="frm_post_review" id="frm_post_review" action="<?php echo base_url().'account/ajax_post_review' ?>" method="post" enctype="multipart/form-data">
            <label>Name</label>
            <div class="text-fell-bg">
                  <input name="txt_name" id="txt_name" type="text" />
				  <div class="err"><?php echo form_error('txt_name'); ?></div>
            </div>
			
            <div class="spacer">&nbsp;</div>
            <label>Rating</label>
            <div class="spacer">&nbsp;</div>
            <select id="opt_rating" name="opt_rating" style="width:273px;">
				  <?php echo makeOptionRating(); ?>
            </select>
			<div class="err"><?php echo form_error('opt_rating'); ?></div>
            <br  class="spacer"/>
            <label>Photo</label>
            <br  class="spacer"/>
            <div id="FileUpload">
				
				  <input type="file" name="f_image"  size="84" id="BrowserHidden" onchange="getElementById('FileField').value = getElementById('BrowserHidden').value;" />
				  <div id="BrowserVisible">
						<input type="text" id="FileField" name="txt_image"  />
						<div class="err"><?php echo form_error('txt_image'); ?></div> 
				  </div>
				   
			</div>
            <br  class="spacer"/>
            <label>Comment</label>
            <div class="textarea-box">
                  <textarea name="ta_comment" id="ta_comment" cols="" rows=""><?php echo $posted["ta_comment"] ?></textarea>
				  <div class="err"><?php echo form_error('ta_comment'); ?></div>
            </div>
			<input type="hidden" name="h_booking_id" id="h_booking_id" value="" />
            <input  type="submit" value="Submit" class="button-blu" name="btn_post_review" id="btn_post_review"/>
      </div>
      </form>
</div>
<!-- lightbox -->
 <!-- lightbox for review -->
<div class="light-box photo_zoom03">
      <div class="close"><a href="javascript:void(0)" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
      <h4>Reviews</h4>
	  <!-- review content div -->
	  <div id="review_show">
      </div>   
	  <!-- review content div -->  
      <div class="spacer"></div>
      
      
</div>
<!--lightbox-->

<div class="light-box photo_zoom10">
      <div class="close"><a href="javascript:void(0)" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
      
      <h4>Booking details</h4>
      <div class="spacer"></div>
      <div id="lightbox_inner">
     
      </div>
</div>