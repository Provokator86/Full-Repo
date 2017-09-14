<script type="text/javascript" src="js/jquery.form.js"></script>  
<script type="text/javascript">
jQuery(function($){
	$(document).ready(function() {		
	
		var booking_id = '';
			$(".review_link").click(function() {
			booking_id = $(this).attr('rel');
			$("#h_booking_id").val(booking_id);
			show_dialog('photo_zoom02');
		});
		
	
		
		/* after clicking on the submit button */
		 var options_review = {
		 		beforeSubmit:  valid_check,
                success:    function(msg) { 
						
					   if(msg)
						{    
							hide_dialog('photo_zoom02');
							window.location.href    =   base_url+'account/my_travel_booking/'  ;
						}
                    
                    } 
                };
				
        $('#frm_post_review').ajaxForm(options_review);
		
		
		
		/* end after clicking on the accept button */
	
	});  // end document ready
	
});

function valid_check(formData, jqForm, options){
			 
		
			var b_valid = true;
			
			if($.trim($("#txt_name").val())=="") //// For  name 
            {               
				$("#txt_name").next(".err").html('<strong>Provide your name.</strong>').slideDown('slow');      
				b_valid  =  false;
            }
            else
            {
                $("#txt_name").next(".err").slideUp('slow').html('');
            }
			
			if($.trim($("#ta_comment").val())=="") //// For  name 
            {               
				$("#ta_comment").next(".err").html('<strong>Provide comment.</strong>').slideDown('slow');      
				b_valid  =  false;
            }
            else
            {
                $("#ta_comment").next(".err").slideUp('slow').html('');
            }
			if($("#FileField").val()!="")
            {
                var file    =   $("#FileField").val() ;
                var ext     =   file.split('.').pop().toLowerCase();
				
                switch(ext)
                {
                    case 'jpg'  :
                    case 'jpeg' :
                    case 'png'  :
                    case 'gif'  :
                                
                                break;
                    default     :
                                 $("#FileField").next(".err").html('<strong>Please provide proper image file format.</strong>').slideDown('slow'); 
                                 b_valid    =   false;
                                
                }
                
            }
			
			if(b_valid)
			{				
				return true		
			}	
			else
			{
				return false
			}		
		
		
		
		}
/**
* This function use to show the history of job.
*/
function show_review(booking_id)
{
  
	 $.ajax({
					type: "POST",
					async: false,
					url: base_url+'account/ajax_fetch_review',
					data: "booking_id="+booking_id,
					success: function(ret_){
						
							$("#review_show").html($.trim(ret_));
							show_dialog('photo_zoom03');   
						
					}
	 });
}



/**
* This function is to remove review 
*/
function remove_review(id)
{
   
    jQuery(function($){
        $.ajax({
                            type: "POST",
                            async: false,
                            url: base_url+'account/ajax_remove_review',
                            data: "review_id="+id,
                            success: function(msg){
                                if(msg)
                                {
									hide_dialog('photo_zoom03');
									window.location.href    =   base_url+'account/my_travel_booking/'  ;
                                }
                            }
                        });
    });
    
}

</script>
<?php if($property_list) {    
    //pr($property_list); 
        foreach($property_list as $value)
		{
			$image = $value["s_property_image"][0]["s_property_image"];
			
	$owner_url =  encrypt($value['i_owner_user_id']).'/'.make_my_url($value['owner_first_name'].' '.$value['owner_last_name']);
	
	$property_url	=	encrypt($value['i_property_id']).'/'.make_my_url($value['s_accommodation']).'/'.make_my_url($value['s_property_name']) ;
			
?>
<div class="manage-property-box"> <?php echo showThumbImageDefault('property_image',$image,'small',226,150); ?>
                   <?php /*?> <h3><a href="<?php echo base_url().'property/details/'.encrypt($value["i_property_id"]) ; ?>"><?php echo $value['s_property_name']; ?></a></h3><?php */?>
				    <h3><a href="<?php echo base_url().'property/details/'.$property_url; ?>"><?php echo $value['s_property_name']; ?></a></h3>
                    <h4><?php echo showAmountCurrency(getAmountByCurrency($value["d_standard_price"],$value["i_currency_id"])) ?> /night <span>Host: <a href="<?php echo base_url().'profile/'.$owner_url; ?>"><?php echo $value['owner_first_name']; ?></a></span> 
                     <?php /*?><?php 
                     if($value['e_status']=='Amount paid' && time()<$value['t_booked_to'])
                     { ?>
                      <em><a href="<?php echo base_url().'write-a-message/'.encrypt($value['id']); ?>">Write Message</a></em>
                     <?php 
                     } ?><?php */?>
					 <?php 
                     if(time()<$value['t_booked_to'] && $value['e_status']!='Cancelled' && $value['e_status']!='Cancelled and Approved by admin')
                     { ?>
                      <em><a href="<?php echo base_url().'write-a-message/'.encrypt($value['id']); ?>">Write Message</a></em>
                     <?php 
                     } ?>
					 
                    </h4>
                    <br />
                    <?php 
             
                     if($value['e_status']=='Amount paid' || $value['e_status']=='Cancelled') // ammount paid and prorety is booked
                     {
                         $onclick   =   'onclick="show_booking_details(\''.encrypt($value['id']).'\');"' ;
                     }
                     else
                     {
                         $onclick   =   '';
                     }
                     ?>
                    <p><?php echo $value['s_accommodation']; ?> (<?php if($onclick!='')
                     {?> <a href="javascript:void(0);" <?php  echo $onclick; ?> >
                     <?php
                     }
                     ?>
                        Guest <?php echo $value['i_total_guests']; ?>
                    <?php if($onclick!='')
                     {?>
                     </a>
                      <?php
                     }
                     ?>)
                      </p>
                    <p><?php echo show_star(round($value["rate"][0]["avg_rating"])); ?> <?php echo $value["rate"][0]["i_total"] ?> reviews </p>
                    <p>Booked on: <?php echo $value['dt_booked_on']; ?></p>
					<p>Check In: <?php echo $value['dt_booked_from']; ?> Check Out: <?php echo $value['dt_booked_to']; ?></p>
                    <p>Status:<span><?php 
                     if($value['e_status']=='Request sent')
                     {
                         echo 'Request Sent';
                     }
                     else if($value['e_status']=='Approve by user')
                     {
                         echo 'Approved by owner '.'<a href="'.base_url().'booking-details/'.encrypt($value['id']).'">Click here to Pay</a>';
                     }
                     else if($value['e_status']=='Amount paid')
                     {
                         echo 'Booked '.'<a href="javascript:void(0);" onclick="cancelBooking(\''.encrypt($value['id']).'\',this);" >Click here to Cancel Booking</a>';
                         
                     }
                      else if($value['e_status']=='Cancelled')
                     {
                         echo 'Awaiting for admin response';
                         
                     }
                     else if($value['e_status']=='Cancelled and Approved by admin')
                     {
                         echo 'Cancelled';
                         
                     }
                     ?></span></p>
                    <br class="spacer" />
                    <div class="icon-box05">
						<?php if($value["i_count_review"]==0) { ?>
						<a href="javascript:void(0);" class="review_link" rel="<?php echo $value["id"] ?>">
							<img src="images/fe/review.png" alt="post-review" title="post-review" />
						</a>   
						<?php } else if($value["i_count_review"]==1) { ?>
						<a href="javascript:void(0);" onclick="show_review('<?php echo $value['id'] ;?>');">
							<img src="images/fe/review.png" alt="see-review" title="see-review" />
						</a>    
						<?php } ?>              
					<?php  if($value['e_status']=='Approve by user')
                    {
                    ?>
                        <a  href="<?php echo base_url().'booking-details/'.encrypt($value['id']) ; ?>"><img src="images/fe/pay.png" alt="pay" title="pay" /></a>
                    <?php
                    }
                    ?>
                     <!--<a href="javascript:void(0);"><img src="images/fe/del01.png" alt="del01" title="delete" /></a>-->
					 </div>
                    <div class="spacer"></div>
</div>
				 <?php  } } else { ?>
				<div class="manage-property-box no-border">
					<p>No property found.</p>
				</div>
				<?php } ?>
 <div class="page-number">
     <?php echo $page_links; ?>
 </div>