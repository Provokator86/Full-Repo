 <!--part-four-->
	 <?php include_once(APPPATH."views/fe/common/footer_destination.tpl.php"); ?>
 <!--part-four-->
</div>
      </div>
<!--body part-->
<!--footer link part-->
<div class="footer-link-part">
	<div class="wrapper">
	  <div class="copyright"><span>&copy; Copyright Tripezi. All Rights Reserved.</span></div>
	  <div class="link-box">
		<ul>
		<?php if(!empty($loggedin)) { ?>
			<li><a href="<?php echo base_url().'property/favourites' ?>">Favourites</a></li>
		<?php } ?>	
		  <li><a <?php //echo ($this->i_footer_menu==1)?'class="select"': '' ?> href="<?php echo base_url().'faq' ?>">FAQ</a></li>
		  <li><a <?php //echo ($this->i_footer_menu==1)?'class="select"': '' ?> href="<?php echo base_url().'blog' ?>">Blog</a></li>
		  <li><a <?php //echo ($this->i_footer_menu==2)?'class="select"': '' ?> href="<?php echo base_url().'press' ?>">Press</a></li>
		  <li><a <?php //echo ($this->i_footer_menu==3)?'class="select"': '' ?> href="<?php echo base_url().'job' ?>">Jobs</a></li>
		  <li><a <?php //echo ($this->i_footer_menu==4)?'class="select"': '' ?> href="<?php echo base_url().'about-us' ?>">About us</a></li>
		  <li><a <?php //echo ($this->i_footer_menu==5)?'class="select"': '' ?> href="<?php echo base_url().'terms-privacy' ?>">Terms &amp; Privacy</a></li>
		  <li><a <?php //echo ($this->i_footer_menu==6)?'class="select"': '' ?> href="<?php echo base_url().'testimonials' ?>">Testimonials</a></li>
		  <li><a <?php //echo ($this->i_footer_menu==7)?'class="select"': '' ?> href="<?php echo base_url().'contact-us' ?>">Contact us</a></li>
		  <li class="last-link"><a <?php //echo ($this->i_footer_menu==8)?'class="select"': '' ?> href="<?php echo base_url().'site-map' ?>">Site Map</a></li>
		</ul>
	  </div>
	</div>
</div>
<!--footer link part-->