<?php if($property_list) {
		$i = 1;
		foreach($property_list as $value)
		{
			 $property_image = $value["s_property_image"][0]["s_property_image"];

 ?>
<div class="propaty-box">
				<div class="propaty-photo">
				<?php echo showThumbImageDefault('property_image',$property_image,'small',226,150); ?>
					  <div class="number-bg"><?php echo $i ?></div>
				</div>
				<div class="propaty-text">
					  <h3><a href="javascript:void(0);"><?php echo $value["s_property_name"] ?></a></h3>
					  <div class="price"><?php echo showAmountCurrency($value["d_standard_price"]) ?><br />
							/night</div>
					  <br class="spacer" />
					  <p><?php echo $value["s_accommodation"] ?> (Guests <?php echo $value["i_total_guests"] ?>) </p>
					  <p><img src="images/fe/star.png" alt="star" /><img src="images/fe/star.png" alt="star" /><img src="images/fe/star.png" alt="star" /><img src="images/fe/star.png" alt="star" /><img src="images/fe/star.png" alt="star" />3 reviews </p>
					  <p>164 people have booked with Martina </p>
					  <div class="favorites-box">
							<div class="booking">
							<a href="<?php echo base_url().'profile/'.encrypt($owner_info["id"]) ?>"><?php echo showThumbImageDefault('user_image',$value["s_image"],'min',75,53); ?></a>
							</div>
							<div class="favorites">
								  <h6><a href="javascript:void(0);">Add to Favorites</a> </h6>
								  <div class="favorites-icon"><a href="javascript:void(0);"><img src="images/fe/favorites.png" alt="favorites" /></a></div>
								  <br class="spacer" />
								  <input class="green-button" type="button" value="See Offer " />
							</div>
					  </div>
					  <br class="spacer" />
				</div>
				<div class="spacer"></div>
		  </div>

<?php $i++; } } else { ?>	
<p>No place found</p>
<?php } ?>	  
		  
<!--<div class="propaty-box bg">-->
 <div class="page-number">
 	<?php echo $page_links; ?>
 </div>
