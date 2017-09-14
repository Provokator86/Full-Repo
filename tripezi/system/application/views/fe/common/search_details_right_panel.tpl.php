<script>
function addFavouriteProperty(property_id,cur_obj)
{
    jQuery(function($){
        $.ajax({
                            type: "POST",
                            async: false,
                            url: base_url+'property/ajax_add_favourite',
                            data: "property_id="+property_id,
                            success: function(msg){
                                if(msg)
                                {                                                           
                                    if(msg=='ok')
                                    {
                                        $(cur_obj).parent().html('<a href="javascript:void(0);" onclick="removeFavouriteProperty('+property_id+',this)">Remove Favourites</a>');
                                      
                                    }
                                    
                                }
                            }
                        });
    });
    
}

function removeFavouriteProperty(property_id,cur_obj)
{
    jQuery(function($){
        $.ajax({
                            type: "POST",
                            async: false,
                            url: base_url+'property/ajax_remove_favourite',
                            data: "property_id="+property_id,
                            success: function(msg){
                                if(msg)
                                {                                                           
                                    if(msg=='ok')
                                    {
                                        $(cur_obj).parent().html('<a href="javascript:void(0);" onclick="addFavouriteProperty('+property_id+',this)">Add to Favourites</a>');
                                      
                                    }
                                    
                                }
                            }
                        });
    });
    
}
</script>
<div class="search-details-right">
		  <div class="check-availability-box">
				<div class="check-box">
					  <h2><!--US--><?php echo showAmountCurrency(getAmountByCurrency($info["d_standard_price"],$info["i_currency_id"])) ?> / Night</h2>
					  <div class="guests-text">No. of Guests: <?php echo $info["i_total_guests"] ?></div>
					  <?php /*?><input class="green-button-big" type="button" value="Check Availability" onclick="window.location.href='<?php echo base_url().'property/details/'.encrypt($info["id"]).'/1' ?>'"/><?php */?>
					  <input class="green-button-big" type="button" value="Check Availability" id="btn_available"/>
				</div>
		  </div>
		  <div class="check-availability-box">
				<div class="check-box"> <span class="promise-text">The Property space lisying Promise </span>
					  <ul>
							<li>Every host is verified by telephone</li>
							<li>Property space listing_promise_checkmark</li>
							<li>Quality assured accommodation</li>
							<li>Property space listing_promise_checkmark</li>
							<li>Secure payment via SSL encryption</li>
					  </ul>
				</div>
		  </div>
		  <h2>Your Host </h2>
		  <div class="host-photo-bg" style="height:auto;">
				<div class="photo-div" style="height:auto;">
				<a href="<?php echo base_url().'profile/'.encrypt($owner_info["id"]) ?>">
				<?php echo showThumbImageDefault('user_image',$owner_info["s_image"],'thumb',279,'auto'); ?>
				</a>
				</div>
				<div class="host-name">
				<a href="<?php echo base_url().'profile/'.encrypt($owner_info["id"]) ?>"><?php echo $owner_info["s_first_name"].' '.$owner_info["s_last_name"] ?></a>
				</div>
		  </div>
		  <input class="green-button02" type="button" value="Contact Us" onclick="window.location.href='<?php echo base_url().'profile/'.encrypt($owner_info["id"]) ?>'"/>
		  <br class="spacer" />
		  <h2>Other Property</h2>
		  <?php if($other_property) {
		  
		  		foreach($other_property as $val)
				{ 
					$property_image = $val["s_property_image"][0]["s_property_image"];
		   ?>
		  <div class="propaty-text propaty-text02 border00">
				<div class="other-property-photo">
				<?php echo showThumbImageDefault('property_image',$property_image,'medium',290,128); ?>
				</div>
				<h3><a href="<?php echo base_url().'property/details/'.encrypt($val["id"]) ?>"><?php echo $val["s_property_name"] ?></a></h3>
				<div class="price06"><?php echo showAmountCurrency(getAmountByCurrency($val["d_standard_price"],$val["i_currency_id"])) ?><br />
					  /night</div>
				<br class="spacer" />
				<p><?php echo $val["s_accommodation"] ?> (Guests <?php echo $val["i_total_guests"] ?>) </p>
				<p><?php echo show_star($val["total_review"]["avg_rating"]) ?><?php echo $val["total_review"]["i_total"] ?> reviews </p>
				<p><?php echo $val["i_total_booking"] ?> people have booked with <?php echo $val["s_property_name"] ?> </p>
				<div class="favorites-box">
					  <div class="booking">
					  <a href="<?php echo base_url().'profile/'.encrypt($owner_info["id"]) ?>"><?php echo showThumbImageDefault('user_image',$val["s_image"],'min',75,53); ?></a>
					  </div>
					  <div class="favorites"> <?php //pr($loggedin); ?>
							<h6>
							<?php  if($val["i_favourite"]==0 && !empty($loggedin)) { ?>
							<a href="javascript:void(0);" onclick="addFavouriteProperty('<?php echo $val["id"] ?>',this)">Add to Favourites</a> 
							<?php } else if($val["i_favourite"]==1 && !empty($loggedin)){ ?>
							<a href="javascript:void(0);" onclick="removeFavouriteProperty('<?php echo $val["id"] ?>',this)">Remove Favourites</a>
							<?php } ?>
							</h6>
							<?php  if(!empty($loggedin)) { ?>
							<div class="favorites-icon"><a href="javascript:void(0);"><img src="images/fe/favorites.png" alt="favorites" /></a></div>
							<?php } ?>
							<br class="spacer" />
							<input class="green-button" type="button" value="See Offer " onclick="window.location.href='<?php echo base_url()."property/details/".encrypt($val["id"]) ?>'"/>
					  </div>
				</div>
				<br class="spacer" />
		  </div>
		 <?php } } else { ?> 
		 <p>No property found.</p>
		 <?php } ?>
		  
	</div>