<script type="text/javascript">
jQuery(function($) {
$(document).ready(function(){

	$(".lightbox1_main").fancybox({
		'titlePosition'		: 'inside',
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'showCloseButton'	: true
		});
	});
});
</script>

<div id="banner">
        <ul class="top_bar">
            <li><a href="<?php echo base_url()?>"><img src="images/fe/home1.png" alt="" /> Home</a></li>
            <?php
			  if($breadcrumb)
			  {
				$total  = count($breadcrumb);
				$x=1;
				foreach($breadcrumb as $key=>$val){
			  ?>
				<li> &raquo;</li>
				<?php
					if($x==$total)
					{
				?>
					<li><?php echo $key;?></li>
				<?php
					}else{
				?>									
					<li><a href="<?php echo $val;?>"><?php echo $key;?></a></li>
			  <?php
					}
					$x++;	
				}
			  }
		   ?>	
        </ul>
        <!-- log box -->
       
	  <?php
	  	if(empty($loggedin))
    	{
	  ?> 
	  	<div id="log_box">
            <ul>
                <li><a href="<?php echo base_url().'user/login'?>"><img src="images/fe/icon-05.png" alt="" />Login</a></li>
                <li>|</li>
                <li><a href="<?php echo base_url().'home/sign_up_lightbox'?>" class="lightbox1_main"><img src="images/fe/icon-06.png" alt="" />Signup</a></li>
            </ul>
		</div>	
		<?php
		} else {
		?>	
		<div id="account_box"> <img src="images/fe/icon-06a.png" alt="" /> 
		Welcome <?php echo $loggedin['user_name']?> <span>|</span> 
		<img src="images/fe/dashboarda.png" alt="" /><a href="<?php echo base_url().'user/dashboard'?>">Your Dashboard</a> 
		<span>|</span> <img src="images/fe/logouta.png" alt="" /><a href="<?php echo base_url().'user/logout'?>">Sign out</a> 
		</div>			
		<?php } ?>
        
        <!-- /log box -->
        <div class="clr"></div>
    </div>

