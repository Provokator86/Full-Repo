<script type="text/javascript"src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="js/jquery.scrollfollow.js"></script>
<script type="text/javascript" src="js/jquery.fancybox-1.3.4.js"></script>
<script type="text/javascript" src="js/fe/tab3.js"></script>
<script type="text/javascript">
		$(document).ready(function() {
			$("a[rel=gallery_group]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			});
			
		$(".lightbox1_main").fancybox({
			'titlePosition'		: 'inside',
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'showCloseButton'	: true
		});	
			
			
	});
</script>
<script type="text/javascript" src="js/fe/jquery.nivo.slider.js"></script>
<script type="text/javascript">
$(window).load(function() {
	$('#slider').nivoSlider({
		effect:'fade',
		manualAdvance: true,
	});
});


</script>
<link rel="stylesheet" type="text/css" href="css/fe/fancybox.css"  />
<link rel="stylesheet" href="css/fe/slider.css" type="text/css" media="screen" />   
<script type="text/javascript">
  var map;
  function initialize() {
  	 var myLatlng = new google.maps.LatLng(<?php echo $profile_info['s_lat'];?>, <?php echo $profile_info['s_lng'];?>)
	var myOptions = {
	  zoom: 10,
	  center: myLatlng,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById('map'),
		myOptions);
		
    var marker = new google.maps.Marker({
        position: myLatlng, 
        map: map,
        title:"<?php echo $profile_info['s_name'];?>"
    }); 		
  }

  google.maps.event.addDomListener(window, 'load', initialize);
  $(document).ready(function() {
	$('div.rightSidebar').scrollFollow({ speed: 500, offset: 10 });
});
</script>
<script>
/*setTimeout('hide_div()', 5000);
function hide_div()
{
	$("#div22").hide();
}*/
</script>
<div id="banner_section"> 
    <?php
	include_once(APPPATH."views/fe/common/header_top.tpl.php");
	?>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
    <?php
	include_once(APPPATH."views/fe/common/common_buyer_search.tpl.php");
	?>
<div id="content_section">
    <div id="content">
        <div id="inner_container02">
            <div class="title">
			
                <!--<h3><span>Professional</span> Profile</h3>-->
				<?php /*?><h3 style="font-weight:bold; font-size:32px; color:#00A3BE;"><?php echo $profile_info["s_business_name"];?></h3><?php */?>
				<?php if($profile_info["s_business_name"]) { 
				
				//$str = pre_next_string($profile_info["s_business_name"]);
				//pr($str,1);
				$cnt = strpos($profile_info["s_business_name"],' ');  
				$name1 = substr($profile_info["s_business_name"],0,$cnt);
				$name2 = substr($profile_info["s_business_name"],$cnt+1,strlen($profile_info["s_business_name"]));
				?>
				<h3 style="font-weight:bold; font-size:24px; font:Arial,Helvetica,sans-serif;">
				<span style="font-weight:bold; font-size:24px; font:Arial,Helvetica,sans-serif; color:#00B0CD;"><?php echo $name1 ?></span> <?php echo $name2?>
				</h3>
				<?php } ?>
				<?php /*?><h3 style="font-weight:bold; font-size:24px; font:Arial,Helvetica,sans-serif; color:#00B0CD;"><?php echo $profile_info["s_business_name"];?></h3><?php */?>
            </div>
            <div class="section01">
                <div class="professional_profile">
					<?php 
					//  pr($profile_info);
						//$img = (!empty($profile_info["s_user_image"])&&file_exists($image_up_path."thumb_".trim($profile_info["s_user_image"])))?" <img src='".$image_path."thumb_".$profile_info["s_user_image"]."' width='100' height='100' />":" <img src='images/fe/img-01.jpg'/>";
					 
					  ?>
                    <div class="box01">
                        <div class="img_box"><?php echo showThumbImageDefault('user_profile',$profile_info["s_user_image"],100,100)//echo $img ?></div>
                        <div class="txt_box">
                           <?php /*?> <h6><?php echo $profile_info["s_business_name"];?></h6><?php */?>
                            <p><span class="blue_txt">Skill Set:</span> <?php echo $profile_info["s_skills"];?></p>                            
                            <p>&nbsp;</p>
                            <!--<div class="link_box07"><a href="javascript:void(0)" onclick="return show_dialog('lightbox2')">Invite To Job</a></div>-->
							<?php
							//pr($loggedin);exit;							
							if(decrypt($loggedin['user_type_id'])==1)
							{
							?>

							<div class="link_box07">
							<a href="<?php echo base_url().'invite_tradesman/'.encrypt($profile_info["id"])?>" class="lightbox1_main">Invite To Job</a>							
							</div>
							<?php } ?>
                        </div>
                    </div>
                    <div class="box02">
                        <h6><span class="blue">JOB HISTORY</span></h6>
                        <div class="blue_box">
                            <div class="cell"><img src="images/fe/icon-12.png" alt="" width="20" height="20" /><?php echo $profile_info['i_jobs_won']?> jobs won</div>
                            <div class="cell"><img src="images/fe/icon-13.png" alt="" width="20" height="20" /><?php echo $profile_info['i_feedback_received']?> reviews</div>
                            <div class="cell"><!--<img src="images/fe/star-mark01.png" alt="" />-->
							<?php echo show_star($profile_info['i_feedback_rating'])?></div>
                            <div class="cell">Rating : <?php echo $profile_info['f_positive_feedback_percentage']?>%   Positive</div>
                        </div>
                    </div>
                    <!--<div class="box02">
                        <h6><span class="orange">Credentials</span></h6>
                        <div class="orange_box">
                            <div class="cell">Verified Member</div>
                            <div class="cell"><a href="javascript:void(0)"><img src="images/icon-14.png" alt="" /></a><a href="javascript:void(0)"><img src="images/icon-15.png" alt="" /></a><a href="javascript:void(0)"><img src="images/icon-16.png" alt="" /></a><a href="javascript:void(0)"><img src="images/icon-17.png" alt="" /></a></div>
                        </div>
                    </div>-->
                </div>
                <div class="profile_picture">
				<?php
						if(empty($profile_info["s_user_image"]) && empty($album_list) )
						{
							echo "No images available.";
						}
						else
						{ ?>
                    <div id="slider-wrapper">
                        <div id="slider" class="nivoSlider">
							
						<?php
						 if(!empty($profile_info["s_user_image"])&& file_exists($image_up_path."thumb_slider_".trim($profile_info["s_user_image"]))) { ?>		
						<img src="<?php echo $slider_image_up_path."thumb_slider_".trim($profile_info["s_user_image"])?>"  /> 			
						<?php } ?>
						<?php 						
						//echo showThumbImageDefault('user_profile',$profile_info["s_user_image"],100,100);
						if(count($album_list)>0)
						{
							foreach($album_list as $img)
								{	
						?> 
						<img src="<?php echo $album_image_path."thumb/thumb_slider_".$img['s_image']?>" width="100" height="100" alt="<?php echo htmlspecialchars($img['s_title'])?>" /> 
						<!--<img src="images/fe/photo-02.jpg" alt="" /> <img src="images/fe/photo-03.jpg" alt="" /> <img src="images/fe/photo-04.jpg" alt="" /> -->
						<?php } 
						} 						
						?>
						
						</div>
                    </div>
					<?php } ?>
                </div>
            </div>
            <div class="section02">
                <div class="location">
                    <div class="title03">
                        <h5><span>Location</span></h5>
                    </div>
                    <div class="content_box">
                        <!--<iframe width="450" height="330" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=uk&amp;aq=&amp;sll=56.130366,-106.346771&amp;sspn=108.12427,346.289063&amp;vpsrc=0&amp;ie=UTF8&amp;hq=&amp;hnear=United+Kingdom&amp;t=m&amp;z=3&amp;ll=55.378051,-3.435973&amp;output=embed"></iframe>-->
                    	<div id="map" style="width:450px; height:330px;">
						</div>
					</div>
                </div>
                <div class="verified">
                    <div class="title03">
                        <h5><span>Verified</span> Member</h5>
                    </div>
                    <div class="content_box">
                       <!-- <p>Members' verification has nothing to do with the quality of their work.</p>-->
					    <p>Jobshoppa has verified this member by validating their contact details.</p>
                        <!--<p>&nbsp;</p>-->
                        <!--<p>Members' verification only gives an additional layer of trustworthiness to those  who give us work and pay us money.</p>-->
                        <p>&nbsp;</p>
<?php /*?>						<div class="box01"><a style="text-decoration:none;" href="javascript:void(0)"><?php if($profile_info['i_verify_phone']==0) {echo '<img src="images/fe/icon-08a.png" alt="" />';} else { echo '<img src="images/fe/icon-08.png" alt="" />'; } ?>:  Phone Verified</a></div>
						<div class="box01"><a style="text-decoration:none;" href="javascript:void(0)"><img src="images/fe/icon-09.png" alt="" />:   Email Verified</a></div>
						<div class="box01"><a style="text-decoration:none;" href="javascript:void(0)"><?php if($profile_info['i_verify_facebook']==0) {echo '<img src="images/fe/icon-10a.png" alt="" />';} else { echo '<img src="images/fe/icon-10.png" alt="" />'; } ?>:   Facebook  Verified</a></div>
						<div class="box01"><a style="text-decoration:none;" href="javascript:void(0)"><?php if($profile_info['i_verify_credentials']==0) {echo '<img src="images/fe/icon-11a.png" alt="" />';} else { echo '<img src="images/fe/icon-11.png" alt="" />'; } ?>:   Credentials  Reviewed</a></div>
<?php */?>             
						<?php if($profile_info['i_verify_phone']==1) {?><div class="box01"><img src="images/fe/icon-08.png" alt="" />:  Phone Verified</div><?php } ?>
						<div class="box01"><img src="images/fe/icon-09.png" alt="" />:   Email Verified</div>
						<?php if($profile_info['i_verify_facebook']==1) {?><div class="box01"> <img src="images/fe/icon-10.png" alt="" />:   Facebook  Verified</div><?php } ?>
						<?php if($profile_info['i_verify_credentials']==1) { ?><div class="box01">  <img src="images/fe/icon-11.png" alt="" />:   Credentials  Reviewed</div><?php } ?>
     
					</div>
                </div>
            </div>
            <div class="section03">
                <div id="pro_tab">
                    <ul>
                        <li><a href="javascript:void(0)" id="11" class="select" ><span>Profile</span></a></li>
                        <li><a href="javascript:void(0)" id="22"><span>Reviews</span></a></li>
                    </ul>
                </div>
                <div class="profile" id="div11">
						
                    <div class="grey_box02">
                        <h6>Photos:</h6>
						<?php 
						if(count($album_list)>0)
						{
							foreach($album_list as $img)
								{	
						?>
                        <ul class="photo2">
                            <li><a rel="gallery_group" href="<?php echo $album_image_path.$img['s_image']?>" title="<?php echo htmlspecialchars($img['s_title'])?>">
							<img alt="<?php echo htmlspecialchars($img['s_title'])?>" src="<?php echo $album_image_thumb_path.'thumb_'.$img['s_image']?>"  width="110px" height="100px"/></a>
							</li>
                        </ul>	
						<?php } } else {
						echo 'No images available';
						}
						?>					
                    </div>
						
					
					<?php if(!empty($profile_info["s_about_me"])) {?>
                    <div class="grey_box03">
                        <h6>About <?php echo $profile_info["s_business_name"];?>:</h6>
                        <p><?php echo $profile_info["s_about_me"];?></p>
                    </div>
					<?php } ?>
					<?php if(!empty($profile_info["s_qualification"])) { ?>
                    <div class="grey_box02">
                        <h6>Qualifications And Accreditations:</h6>
                        <p><?php echo $profile_info["s_qualification"];?></p>
                    </div>
					<?php } ?>
					<?php if(!empty($profile_info["s_skills"])) { ?>
                    <div class="grey_box03">
                        <h6>Services and Specialities:</h6>
                        <p><?php echo $profile_info["s_skills"];?></p>
                    </div>
					<?php } ?>
					<?php if(!empty($profile_info["s_work_history"])) { ?>
                    <div class="grey_box02">
                        <h6>Work History:</h6>
                        <p><?php echo $profile_info["s_work_history"];?></p>
                    </div>
					<?php } ?>
					
					<?php /*?><?php if(!empty($profile_info["s_payment_type"])) { ?>
                    <div class="grey_box03">
                        <h6>Payment Type:</h6>
                        <p><?php echo $profile_info["s_payment_type"];?></p>
                    </div>
					<?php } ?>
					<?php if(!empty($profile_info["s_like_travel"])) { ?>
                    <div class="grey_box02">
                        <h6>Like to Travel:</h6>
                        <p><?php echo $profile_info["s_like_travel"];?></p>
                    </div>
					<?php } ?><?php */?>
					<?php if(!empty($profile_info["s_payment_type"]) || !empty($profile_info["s_like_travel"])) { ?>
                    <div class="grey_box03">
                        <h6>Additional Information:</h6>
						<?php if(!empty($profile_info["s_payment_type"])) { ?>
                        <p> I accept <?php echo $profile_info["s_payment_type"];?>.</p>
						<?php } ?>
						<?php if(!empty($profile_info["s_like_travel"])) { ?>
                        <p> I <?php echo $profile_info["s_like_travel"];?> travel to my client.</p>
						<?php } ?>
						<?php if(!empty($profile_info["s_phone_internet"])) { ?>
                        <p> I <?php echo $profile_info["s_phone_internet"];?> do jobs over phone/internet.</p>
						<?php } ?>
                    </div>
					<?php } ?>
					
                </div>
				
                <div class="review" id="div22" style="display:none;">
					
					 <?php  echo $feedback_contents;?>
				
                </div>
				
		
            </div>
            <div class="clr"></div>
        </div>
        <div class="clr"></div>
    </div>
    <div class="clr"></div>
</div>