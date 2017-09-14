<!--tab-->
<script type="text/JavaScript" src="js/fe/tab.js"></script>
<script type="text/javascript" >
$(document).ready(function(){
	
	var index = <?php echo $param ?>;	
	$(".tab-content ul li").filter(':eq(' + index + ')').find("a").addClass("select");
	
	$('.tab-details > div.details').hide();
	$('.tab-details > div.details').filter(':eq(' + index + ')').fadeIn('slow');
	
});
</script>
<!--tab-->
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="container-box">
	<div class="list-box02">
		  <div class="how-works-box">
		  <p><img src="images/fe/icon01.png" alt="" />Easily list and showcase your property for free</p>
		  </div>
		  
		  <div class="how-works-box">
		  <p><img src="images/fe/icon02.png" alt="" />Manage your requeste and bookings using our free easy-to-use tools</p>
		  </div> 
		  
		  
		  <div class="how-works-box">
		  <p><img src="images/fe/icon03.png" alt="" />Welcome your guest and receive your rental fee from house Trip straight away.</p>
		  </div>   
		  
		   <div class="how-works-box last-box">
		  <p><img src="images/fe/icon04.png" alt="" />Enjoy worry-free travel. Wimdu only transfers your payment to the host 24 hours after you have checked in. And we insure you for free. </p>
		  </div> 
		  
	</div>
			<!-- VIDEO DIV -->
			<div class="video-div">
			<!--<iframe width="640" height="390" src="http://www.youtube.com/embed/Wtbt4JCmDJ0" frameborder="0" allowfullscreen></iframe>-->	<?php echo $s_youtube_snippet_for_how_it_works; ?>
			</div>
			<div class="spacer">&nbsp;</div>
			<!-- VIDEO DIV -->
			<!--tab-->
			<div class="tab-part">
				  <div class="tab-content">
						<ul>
							  <li><a href="javascript:void(0);"><span>How It Works </span></a></li>
							  <li><a href="javascript:void(0);"><span>Why To Book</span></a></li>
							  <li><a href="javascript:void(0);"><span> Why To Host</span></a></li>
						</ul>
				  </div>
				  <!--tab_details-->
			  <div class="tab-details">
					<!--1st tab-->
					<div class="details">
					<img src="images/fe/how-it-works-photo.png" alt="" />
					<?php if($info){ echo $info[4]['s_description']; } ?>
					
					 </div>
					<!--1st tab-->
					<!--2nd tab-->
					<div class="details">
					 <img src="images/fe/Why-To-Book.png" alt="" />
						 
								<?php if($info){ echo $info[6]['s_description']; } ?>
						  
					</div>
					<!--2nd tab-->
					<!--3rd tab-->
					<div class="details">
						 
						  <img src="images/fe/Why-To-host.png" alt="Why-To-host" />
								<?php if($info){ echo $info[5]['s_description']; } ?>
						  
					</div>
					<!--3rd tab-->
			</div>
		<!--tab_details-->
	</div>
	<!--tab-->
</div>