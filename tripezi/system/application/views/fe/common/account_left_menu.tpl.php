<div class="left-part02">
  <div class="link-box02">
	<ul>
	  
      <li <?php echo ($left_menu==1)?'class="select"':""; ?> ><a href="<?php echo base_url().'dashboard' ?>"><img src="images/fe/dashboard-icon.png" alt="dashboard" />Dashboard</a></li>
	  <li <?php echo ($left_menu==2)?'class="select"':""; ?> ><a href="<?php echo base_url().'manage-account' ?>"><img src="images/fe/manage-account.png" alt="manage-account" />Manage Account</a></li>
	   <?php if($i_am_owner==1) { ?>
	  <li <?php echo ($left_menu==3)?'class="select"':""; ?>><a href="<?php echo base_url().'manage-property' ?>"><img src="images/fe/manage-my-property.png" alt="manage-my-property" />Manage My Property</a></li>
	  <?php } ?>
	  <li <?php echo ($left_menu==4)?'class="select"':""; ?>><a href="<?php echo base_url().'manage-internal-messaging' ?>"><img src="images/fe/messaging.png" alt="messaging" />Manage Internal Messaging</a></li>
	   <?php if($i_am_owner==1) { ?>
	  <li <?php echo ($left_menu==5)?'class="select"':""; ?>><a href="<?php echo base_url().'my-property-booking' ?>"><img src="images/fe/booking-icon.png" alt="booking-icon" />My  Property Booking</a></li>
	  <?php } ?>
	  <?php if($i_am_traveler==1) { ?>
	  <li <?php echo ($left_menu==6)?'class="select"':""; ?>><a href="<?php echo base_url().'my-travel-booking' ?>"><img src="images/fe/travel.png" alt="travel" />My Travel &amp; Booking</a></li>
	  <?php } ?>
	</ul>
	<div class="spacer"></div>
  </div>
</div>