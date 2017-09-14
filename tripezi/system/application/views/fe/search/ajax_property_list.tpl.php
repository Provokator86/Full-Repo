<script type="text/javascript">
/**
	* This function is to add favourites a property
	*/
	function addToFavourite(property_id,cur_obj)
	{
		jQuery(function($){
			$("#err_msg").removeClass('success_massage error_massage');
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
									$('#div_err_').html('<div id="err_msg" class="success_massage">Property has been added to favourite succesfully</div>').show('slow').delay(2000).hide(500);
									$(cur_obj).parent().html('<a href="javascript:void(0);" onclick="removeFavourite('+property_id+',this)">Remove Favourites</a>');
								  
								}
								else if(msg=='login_error')
								{
									$('#div_err_').html('<div id="err_msg" class="error_massage">Please login to add favourite.</div>').show('slow').delay(2000).hide(500);
								}
								else if(msg=='owner_error')
								{
									$('#div_err_').html('<div id="err_msg" class="error_massage">You can not add your own property to favourite.</div>').show('slow').delay(2000).hide(500);
								}
								else if(msg=='exist')
								{
									$('#div_err_').html('<div id="err_msg" class="error_massage">You have already been added this property to favourite.</div>').show('slow').delay(2000).hide(500);
								}
								
							}
						}
					});
		});
		
	}
	
	/**
	* This function is to remove favourites a property
	*/
	function removeFavourite(property_id,cur_obj)
	{
		
	
		jQuery(function($){
			$("#err_msg").removeClass('success_massage error_massage');
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
											$('#div_err_').html('<div id="err_msg" class="success_massage">Removed from favourite succesfully</div>').show('slow').delay(2000).hide(500);											
											$(cur_obj).parent().html('<a href="javascript:void(0);" onclick="addToFavourite('+property_id+',this)">Add to Favourites</a>');
										  
										}
										else if(msg=='error')
										{
											$('#div_err_').html('<div id="err_msg" class="error_massage">Failed to remove from  favourite.</div>').show('slow').delay(2000).hide(500);
										}
										
									}
								}
							});
		});
		
	
	}
	
	jQuery(function($){
		$(document).ready(function(){
			
		});
	});	
</script>
<?php 
$map_address=array();
	if($property_list) 
	{
			$i = 1;
			
		
		
		foreach($property_list as $value)
		{
			 $property_image = $value["s_property_image"][0]["s_property_image"];
			 
			 $property_url	=	encrypt($value['id']).'/'.make_my_url($value['s_accommodation']).'/'.make_my_url($value['s_property_name']) ;
			 
			 $owner_url =  encrypt($value['i_owner_id']).'/'.make_my_url($value['s_first_name'].' '.$value['s_last_name']) ;				 
			 
			 $map_address[]=array(	'address_or_latlng'=>	$value["s_lattitude"].', '.$value["s_longitude"],
									'title'=>				$value["s_property_name"],
									'link_or_html'=>		base_url()."property/details/".$property_url,					
									'icon'=>				base_url()."no_imaged/index/".$i
								 );
												
			
 
 		    
 
 ?>
 		
<div class="propaty-box">
				<div class="propaty-photo">
				<?php echo showThumbImageDefault('property_image',$property_image,'small',225,150); ?>
					  <div class="number-bg"><?php echo $i ?></div>
				</div>
				<div class="propaty-text">
					<?php /*?>  <h3><a href="<?php echo base_url()."property/details/".encrypt($value["id"]) ?>"><?php echo $value["s_property_name"] ?></a></h3><?php */?>
					  <h3><a href="<?php echo base_url()."property/details/".$property_url ?>"><?php echo $value["s_property_name"] ?></a></h3>
					  <div class="price"><?php echo showAmountCurrency(getAmountByCurrency($value["d_standard_price"],$value["i_currency_id"])) ?><br />
							/night</div>
					  <br class="spacer" />
					  <p><?php echo $value["s_accommodation"] ?> (Guests <?php echo $value["i_total_guests"] ?>) </p>
					  <p><?php echo show_star($value["review_rate"]["avg_rating"]) ?><?php echo $value["review_rate"]["i_total"] ?> reviews </p>
					  <p><?php echo $value["i_total_booking"] ?> people have booked with <?php echo $value["s_property_name"] ?> </p>
					  <div class="favorites-box">
							<div class="booking">
							<a href="<?php echo base_url().'profile/'.$owner_url ?>"><?php echo showThumbImageDefault('user_image',$value["s_image"],'min',75,'auto'); ?></a>							
							</div>
							
							<?php if($value["i_total_positive_review"]>=3) { ?>
							<span class="verified-host">Verified host</span>
							<?php } ?>
							
							<div class="favorites">
								  <h6>
								  <?php  if($value["i_favourite"]==0 && !empty($loggedin)) { ?>
							<a href="javascript:void(0);" onclick="addToFavourite('<?php echo $value["id"] ?>',this)">Add to Favourites</a> 
							<?php } else if($value["i_favourite"]==1 && !empty($loggedin)){ ?>
							<a href="javascript:void(0);" onclick="removeFavourite('<?php echo $value["id"] ?>',this)">Remove Favourites</a>
							<?php } ?>
								  </h6>
								   <?php  if(!empty($loggedin)) { ?>
								  <div class="favorites-icon"><a href="javascript:void(0);"><img src="images/fe/favorites.png" alt="favorites" /></a></div>
								  <?php } ?>
								  <br class="spacer" />
								  <input class="green-button" type="button" value="See Offer" onclick="window.location.href='<?php echo base_url()."property/details/".encrypt($value["id"]) ?>'" />
							</div>
					  </div>
					  <br class="spacer" />
				</div>
				<div class="spacer"></div>
		  </div>

	<?php $i++; } } else { ?>	
	
	<p>No place found</p>
	<?php } ?>	  
<script type="text/javascript">
			var arr_marker = <?=json_encode($map_address)?>;
			
			LIB_GMAP_MARKER_DEL_ALL("test_id");
			LIB_GMAP_MARKER_ADD_ARR("test_id",arr_marker);
			/*
			jQuery('div.map-box').css({visibility:
										(arr_marker.length==0)?'hidden':'visible'
			});
			*/
		</script>		  
<!--<div class="propaty-box bg">-->
 <div class="page-number">
 	<?php echo $page_links; ?>
 </div>
