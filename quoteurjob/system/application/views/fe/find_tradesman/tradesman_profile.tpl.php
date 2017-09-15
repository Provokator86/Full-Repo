<script type="text/javascript"src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="js/jquery.scrollfollow.js"></script>
<script type="text/javascript" src="js/jquery.fancybox-1.3.4.js"></script>
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
	});
	</script>
<link rel="stylesheet" type="text/css" href="css/fe/fancybox.css"  />
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

<div id="div_container">
      <div class="body_bg">
	   <?php if(decrypt($loggedin['user_type_id'])==2){ ?>
             <div class="banner">			
                  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>				  
            </div>
		<?php } 
			elseif(decrypt($loggedin['user_type_id'])==1){ ?>
             <div class="banner">			
                  <?php include_once(APPPATH.'views/fe/common/common_buyer_search.tpl.php'); ?>				  
            </div>
		<?php }
				else
				{
				 ?>
				 <div class="banner">			
					  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>				  
				</div>
		<?php } ?>
			
            <div class="body_left rightSidebar">
               <?php include_once(APPPATH.'views/fe/common/tradesman_category_list.tpl.php'); ?>	
			   <h1><?php echo t('Location')?></h1>
                  <div class="shadow_small">
                        <div class="left_box">
                              <div id="map">
                              </div>
                        </div>
                  </div>		  
            </div>
            <div class="body_right">
                
                        <h1><?php echo get_title_string(t('Tradesman Profile'))?>  </h1>
                        <div class="shadow_big">
                              <ul class="tab6">
                                    <li><a href="JavaScript:void(0);" title="profile" class="tab1 active1"><span><?php echo t('Profile')?> </span></a></li>
                                    <li><a href="JavaScript:void(0);" title="feedback" class="tab1"><span><?php echo t('Feedback')?> </span></a></li>
                              </ul>
                              <div class="right_box_all_inner">
                                    <div class="tsb_text" id="profile">
                                          <div class="white_box">
										  <?php 
										//  pr($profile_info);
										  	$img = (!empty($profile_info["s_user_image"])&&file_exists($image_up_path."thumb_".trim($profile_info["s_user_image"])))?" <img src='".$image_path."thumb_".$profile_info["s_user_image"]."' width='66' height='65' />":" <img src='images/fe/man.png'/>";
										  
										  ?>
                                                <div class="photo"><?php echo $img ?></div>
                                                <div class="inner_box">
                                                      <h6>
													  	
															<?php echo $profile_info["s_name"];?>
															<span> <?php echo t('- Member since');?> <?php echo $profile_info["dt_created_on"];?></span>
													  </h6>
                                                      <div class="inner_box_left">
                                                            <h5><?php echo t('Last login')?>: 
																<span class="grey_text"><?php echo $profile_info["dt_last_login_on"];?></span>
															</h5>
                                                            <h5><?php echo t('User Name')?>: 
																<span class="grey_text">
																	<?php echo $profile_info["s_username"];?>
																</span>
															</h5>
                                                            <h5><?php echo t('Category')?>:
															<span class="grey_text">
																<?php echo $profile_info["s_category_name"];?>
															</span>
															</h5> 
                                                             <h5><?php echo t('What payment types do you accept?')?>: 
															 <span class="grey_text">
															 	<?php echo $profile_info["s_payment_type"];?>
															 </span>
															</h5>    
                                                            <h5><?php echo t('Would you like to Travel?')?> : 
															<span class="grey_text">
																<?php echo $profile_info["s_like_travel"];?>
															</span>
															</h5>
                                                            <h5><?php echo t('City')?>: 
															<span class="grey_text"><?php echo $profile_info["s_city"];?></span>
															</h5>
															 <h5><?php echo t('Postal Code')?>: 
															 <span class="grey_text"><?php echo $profile_info["s_postal_code"];?></span>
															 </h5>
															 
															 <h5>
															 <span><?php echo $profile_info['i_feedback_received']?></span> <span class="grey_text"><?php echo t('feedback comments')?> - </span>
															 <span><?php echo $profile_info['f_positive_feedback_percentage']?>% </span><span class="grey_text"><?php echo t('Positive')?></span>
															 </h5>
															 
															 
                                                      </div>
                                                      <div class="inner_box_right" style=" width:270px;">
                                                            <h4><?php echo $profile_info["s_business_name"];?></h4>
                                                            <a href="<?php echo base_url().'invite_tradesman/'.encrypt($profile_info["id"])?>" class="lightbox_main" ><input name="" type="button" class="button" value="<?php echo t('Invite');?>" /></a>
                                                      </div>
                                                </div>
                                                <div class="spacer"></div>
                                          </div>
                                          <h3 style="border:0px; margin-bottom:5px;"><?php echo t('Qualification')?></h3>
                                          <p><?php echo $profile_info["s_qualification"];?></p>
                                          <h3 style="border:0px; margin-bottom:5px;"><?php echo t('About me')?></h3>
                                          <p><?php echo $profile_info["s_about_me"];?></p>
                                          <h3 style="border:0px; margin-bottom:5px;"><?php echo t('Skills')?></h3>
                                          <p><?php echo $profile_info["s_skills"];?></p>
										  <?php 
												if(count($album_list)>0)
												{
												?>
                                          <h3 style="border:0px; margin-bottom:5px;"><?php echo t('Photo Album')?></h3>
                                          <div class="photo_all">
										  	<?php
												foreach($album_list as $img)
												{	
												
											?>
                                                <div class="photo">
													 <a rel="gallery_group" href="<?php echo $album_image_path.$img['s_image']?>" title="<?php echo htmlspecialchars($img['s_title'])?>">
													 	<img alt="<?php echo htmlspecialchars($img['s_title'])?>" src="<?php echo $album_image_thumb_path.'thumb_'.$img['s_image']?>" />
													 </a>
												</div>
                                               <?php } ?>
                                                <div class="spacer"></div>
                                          </div>
										   <?php }  ?>
                                          <h3><?php echo t('Recent Feedback')?></h3>
                                          <div class="feedback_div_blue">
										  		<?php if(is_array($feedback_info) && count($feedback_info)>0) { ?>
												
                                                <div class="left"><strong><?php echo $feedback_info[0]['s_job_title']?></strong></div>
                                                <div class="right"> <?php echo show_star($feedback_info[0]['i_rating'])?>
												 <?php echo $feedback_info[0]['s_category_name']?></div>
                                                <div class="spacer"></div>
                                                <div class="com_job "> <img src="images/fe/dot1.png" alt="" class="left" />
                                                      <p><em><?php echo $feedback_info[0]['s_comments']?></em></p>
                                                      <img src="images/fe/dot2.png" alt=""  class="right"/>
                                                      <div class="spacer"></div>
													  <?php if($feedback_info[0]['i_positive'] == 1){ ?>
                                                      <div class="feedback_img">
													  	<img src="images/fe/icon02.png" alt="" style="margin-right:5px;" />
														<?php echo t('Positive feedback')?>
													  </div>
													  <?php } ?>
                                                      <h2 style="text-align:right;"class="right">- <?php echo $feedback_info[0]['s_sender_user']?><br/>
                                                            <span> <?php echo $feedback_info[0]['dt_created_on']?></span></h2>
                                                      <div class="spacer"></div>
                                                </div>
												<?php } else { ?>
													
                                                <div class="left"><strong><?php echo t('No feedback yet')?>.</strong></div>
												<?php } ?>
                                          </div>
                                    </div>
                                    <div class="tsb_text" id="feedback" style="display:none;">
                                          <h4 style="border-bottom:1px solid #e0e0e0;">
										  <?php //if($profile_info['i_jobs_won'] > 0) { ?>
										  	<span><?php echo $profile_info['i_jobs_won']?></span> <?php echo t('Jobs won')?>, 
											<?php //} ?>
											<?php // if($profile_info['i_feedback_received'] > 0) { ?>
											<span><?php echo $profile_info['i_feedback_received']?></span> <?php echo t('feedback comments')?> -
											<?php //} ?>
											<?php //if($profile_info['f_positive_feedback_percentage'] > 0) { ?>
											 <span><?php echo $profile_info['f_positive_feedback_percentage']?>% <?php echo t('Positive')?></span> 
											 <?php //} ?>
										  </h4>
										  <br />
										   <div id="job_list">
                                        	 <?php echo $feedback_contents;?>
										 </div>
                                    </div>
                              </div>
                        </div>
                 
            </div>
            <div class="spacer"></div>
      </div>
</div>