<div class="container-box">
	  <div class="gry-box">
		  <h2>Profile</h2>
		  <div class="border02" ></div>
		  <div class="profile">
		  <?php echo showThumbImageDefault('user_image',$user["s_image"],'thumb',174,171); ?>
		  </div>
		  <div class="profile-content">
		  <ul>
		  	<li><?php echo $user["s_first_name"].' '.$user["s_last_name"] ?></li>
		  	<li><span>Facebook:</span> <?php echo $user["s_facebook_address"] ?> <span><?php echo ($user["i_facebook_verified"]==1)?"<strong>(Verified)</strong>":""; ?></span></li>
	  		<li><span>Twitter:</span> <?php echo $user["s_twitter_address"] ?> <span><?php echo ($user["i_twitter_verified"]==1)?"<strong>(Verified)</strong>":""; ?></span></li>
		  	<li><span>Linkedin:</span>  <?php echo $user["s_linkedin_address"] ?> <span><?php echo ($user["i_linkedin_verified"]==1)?"<strong>(Verified)</strong>":""; ?></span></li>
			<li><span>Country:</span> <?php echo $user["s_country"] ?></li>
	  		<li><span>State:</span> <?php echo $user["s_state"] ?></li>
			<?php /*?><?php if((!empty($loggedin) && count($arr_booking)>0 && ($paid_flag==1)) || (decrypt($loggedin["user_id"])== $user["id"]) || (!empty($loggedin) && count($arr_booking1)>0 && ($paid_flag1==1))) { ?>
			<li><span>Address:</span> <?php echo $user["s_address"] ?></li>
			<li><span>Contact No.:</span> <?php echo $user["s_phone_number"] ?></li>
			<?php } ?><?php */?>
			<?php if((!empty($loggedin) && ($paid_flag==1)) || (decrypt($loggedin["user_id"])== $user["id"]) || (!empty($loggedin) && ($paid_flag1==1))) { ?>
			<li><span>Address:</span> <?php echo $user["s_address"] ?></li>
			<li><span>Contact No.:</span> <?php echo $user["s_phone_number"] ?></li>
			<?php } ?>
			<?php if($i_total_positive_rating>=3) { ?>
			<li><span style="font-weight:bold;">Verified Host</span> <?php //echo $user["s_address"] ?></li>
			<?php } ?>
		  </ul>
	
	
	
		<p class="margin-top02"><?php echo $user["s_about_me"] ?></p>
		  </div>
		  <div class="spacer"></div>
		  
		  
		   <h2>My Property List</h2>
		  <div class="border02" ></div>
		  <div class="photo-content">
		  	<?php if($properties) {
				foreach($properties as $value)
					{ $img = $value["s_property_image"][0]["s_property_image"];
			 ?>
		  <a href="<?php echo base_url().'property/details/'.encrypt($value["id"]) ?>" title="<?php echo $value["s_property_name"] ?>">
		 <?php /*?> <img src="images/fe/property-photo.png" alt="<?php echo $value["s_property_name"] ?>" title="<?php echo $value["s_property_name"] ?>" /><?php */?>
		 <?php echo showThumbImageDefault('property_image',$img,'thumb',212,194); ?>
		  </a>
		  <?php } } else { ?>
		  <p>No property found</p>
		  <?php } ?>
		  <!--<a href="search-results-details.html"><img src="images/fe/property-photo02.png" alt="property-photo02" /></a>
		  <a href="search-results-details.html"><img src="images/fe/property-photo03.png" alt="property-photo03" /></a>
		  <a href="search-results-details.html"><img src="images/fe/property-photo04.png" alt="property-photo04" class="last-link" /></a>-->
		  <div class="spacer"></div>
		  </div>
		<div class="spacer"></div>
	  </div>
                  
</div>