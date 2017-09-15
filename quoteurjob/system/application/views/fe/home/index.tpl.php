<script type="text/javascript">
$(document).ready(function(){
	$("#news_submit").click(function(){		
			 $("#frm_newletter").submit();
		});
	
	$("#frm_newletter").submit(function(){
		 var b_valid=true;
		 var s_err="";
		 $("#newsletter_err").hide("slow"); 
		 var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
		 
		 if($.trim($("#txt_name").val())=="" || $.trim($("#txt_name").val())=="Name") 
		 {
			s_err +='<?php echo addslashes(t('Enter name'))?>.<br />';
			b_valid=false;
		 }
		 if($.trim($("#txt_email").val())=="" || $.trim($("#txt_email").val())=="E-mail") 
		 {
		 	s_err +='<?php  echo addslashes(t('Enter email'))?>.<br />';
			b_valid=false;
		 }
		 else if(!emailPattern.test($("#txt_email").val()))
		 {
		 	s_err +='<?php echo addslashes(t('Wrong email format'))?>.<br />';
			b_valid=false;
		 }
		/////////validating//////
		if(!b_valid)
		{
			$("#newsletter_err").html(s_err).show("slow");
		}		 

		return b_valid;		 
		 
		 
		 
	});
});
</script>

<div class="body_bg">
            <div class="banner" style="height:262px;">
                  <div class="banner_left">
                        <ul class="tab5_set">
                              <li><a href="JavaScript:void(0);" title="search_job" class="tab1 active1"><strong><?php echo t('Search for Job')?></strong></a></li>
                              <li>|</li>
                              <li><a href="JavaScript:void(0);" title="search_service" class="tab1"><strong><?php echo t('Search for Tradesman')?></strong></a></li>
                        </ul>
                        <div id="search_job" class="tsb_text">
						<form name="frm_indx_job_src" method="post" action="<?php echo base_url().'job/find_job'?>">
                              <h5><?php echo t('What Job Do You Need?')?></h5>
                              <input type="text"  name="txt_fulltext_src" id="txt_fulltext_src" />
                              <h4><span><?php echo t('Popular Searches')?> : </span><?php echo t('Handyman, Babysitter, Personal Trainer,')?> </h4>
                              <h5> <?php echo t('Where')?> <span style="font-size:14px;"><?php echo t('( City / Postal Code )')?></span>?</h5>
                              <input type="text" name="txt_fulladd_src" id="txt_fulladd_src" />
                              <input  class="button03" type="submit" value="<?php echo t('Search')?>"/>
						</form>
                        </div>
                        <div id="search_service" class="tsb_text" style="display:none;">
						<form name="frm_indx_trades_src" method="post" action="<?php echo base_url().'find_tradesman'?>">
                              <h5><?php echo t('What Service Do You Need?')?></h5>
                              <input type="text"  name="txt_fulltext_src" id="txt_fulltext_src" />
                              <h4><span><?php echo t('Popular Searches')?> : </span><?php echo t('Handyman, Babysitter, Personal Trainer')?>, </h4>
                               <h5> <?php echo t('Where')?> <span style="font-size:14px;"><?php echo t('( City / Postal Code )')?></span>?</h5>
                              <input type="text" name="txt_fulladd_src" id="txt_fulladd_src" />
                              <input  class="button03" type="submit" value="<?php echo t('Search')?>" />
                       	</form>
					    </div>
                  </div>
                  <div class="banner_right">
                        <div id="slider" class="nivoSlider"> <img src="images/fe/banner.png" alt="" title="#detail01"/> <img src="images/fe/banner2.png" alt="" title="#detail02" /> </div>
                        <div id="detail01" class="nivo-html-caption">
                              <h2><?php echo t('Let Local Tradesmans Completed for your job')?>. </h2>
                              <p><?php echo t('Choose  from 1000s of rated and approved pros, including handymen, carpenters, 
                                    housecleaners, painter, tutors & more')?>. </p>
                              <h3><?php echo t('Get Started now, it\'s free')?>!
                                    <input  class="pink_button" type="button" value="<?php echo t('Post a Job')?>" onclick="window.location.href='<?php echo base_url().'job/job_post' ?>'"/>
                              </h3>
                        </div>
                        <div id="detail02" class="nivo-html-caption">
                              <p><?php echo t('Choose  from 1000s of rated and approved pros, including handymen, carpenters, 
                                    housecleaners, painter, tutors & more')?>. </p>
                        </div>
                  </div>
            </div>
            <div class="how_work">
                  <div style="width:210px;"><?php echo t('Post a Job')?></div>
                  <div style="width:182px;"><?php echo t('Get Quotes')?></div>
                  <div style="width:190px;"><?php echo t('Hire a Tradesman')?></div>
                  <div style="width:170px;"><?php echo t('Leave FeedBack')?></div>
            </div>
            <div class="body_left">
                 <?php
				 	include_once(APPPATH.'views/fe/common/home_job_category_list.tpl.php');
				 ?>
                  <h1 style="float:left;"><?php echo t('News')?></h1>
                  <div class="arrow"> <a href="#" class="prev"><img src="images/fe/up.png" alt="" /></a> <a href="#" class="next"><img src="images/fe/down.png" alt="" /></a> </div>
                  <div class="shadow_small">
                        <div class="left_box" style="padding: 0px;">
                              <div class="newsticker">
                                    <ul>
									<?php
									
									if($news_list)
									{
										foreach($news_list as $val)
										{
									?>
                                          <li>
                                                <div class="left_box02">
                                                      <h2><?php echo substr($val['s_title'],0,15)?> <span>- <?php echo $val['fn_created_on']?></span></h2>
                                                      <p><a href="<?php echo base_url().'home/news/'.encrypt($val['id'])?>" class="grey_link"><?php echo substr($val['s_description'],0,30)?></a></p>
                                                </div>
                                          </li>
									<?php
										}
									}else {
									?>	  
											<li>
                                                <div class="left_box02">
                                                      <h2><?php echo t('News Heading')?> <span>- 06/02/2011</span></h2>
                                                      <p><?php echo t('No Record Found')?></p>
                                                </div>
                                          </li>
									
                                       
									<?php } ?>     
                                    </ul>
                              </div>
                        </div>
                  </div>
                  <h1><?php echo t('Client')?><span> <?php echo t('Testimonials')?></span></h1>
                  <div class="shadow_small">
                        <div class="left_box" style="padding:0px; ">
                              <div class="testimonial">
                                    <ul>
									<?php
									if($testimonial_list)
									{
										foreach($testimonial_list as $val)
										{
									?>
                                          <li>
                                                <div class="left_box02"> <img src="images/fe/dot1.png" alt="" class="left" />
                                                      <p> <a href="<?php echo base_url().'home/testimonial_details/'.encrypt($val['id'])?>" class="grey_link"><?php echo $val['s_content']?></a></p>
                                                      <img src="images/fe/dot2.png"  class="right"/>
                                                      <h2 style="text-align:right"><em>- <?php echo $val['s_person_name']?> </em><br />
                                                            <span><?php echo $val['fn_entry_date']?></span></h2>
                                                </div>
                                          </li>
                                     <?php 
									 	}
									 } else {
									 	echo '<li></li>';
									  } ?>    
                                    </ul>
                              </div>
                              <div class="button_bg">
                                    <input  class="button" type="button" value="<?php echo t('View More')?>"  onclick="window.location.href='<?php echo base_url().'home/testimonial'?>'" />
                              </div>
                        </div>
                  </div>
                  <h1><?php echo t('Newsletter')?><span> <?php echo t('Signup')?></span></h1>
				  <div id="newsletter_err"></div>
                  <div class="shadow_small">
				  	<form name="frm_newletter" id="frm_newletter" action="<?php echo base_url().'home/save_newsletter'?>" method="post"> 
                        <div class="left_box_black">
                              <input id="txt_name" name="txt_name" type="text"  value="Name" size="35" onclick="if(this.value=='Name') document.getElementById('txt_name').value ='';" onblur="if(this.value=='') document.getElementById('txt_name').value ='Name';"/>
							  
                              <input id="txt_email" name="txt_email" type="text"  value="E-mail" size="35" onclick="if(this.value=='E-mail') document.getElementById('txt_email').value ='';" onblur="if(this.value=='') document.getElementById('txt_email').value ='E-mail';"/>
                              <div class="dot"></div>
                              <input  class="button" type="button" id="news_submit" value="<?php echo t('Subscribe Now')?>"/>
                        </div>
					</form>							
                  </div>
            </div>
            <div class="body_right">
                  <div class="right_box_all">
                        <div class="body_right_01">
                              <h1> <?php echo t('Are ')?> <span> <?php echo t('you looking for a job to be done')?>?</span></h1>
                              <div style="min-height:175px;">
                                    <ul>
                                          <li><?php echo t('Leave the hard work to us')?></li>
                                          <li><?php echo t('Receive multiple quotes into your inbox')?></li>
                                          <li><?php echo t('Its Completely free')?></li>
                                          <li><?php echo t('Review Feedback and Ratings')?></li>
                                          <li><?php echo t('Choose the Pro that suits you')?></li>
                                    </ul>
                              </div>
                              <input  class="button" type="button" value="<?php echo t('How it Works')?> " onclick="window.location.href='<?php echo base_url().'home/how_it_works/TVNOaFkzVT0/';?>'"/>
                        </div>
                        <div class="body_right_01" style="float:right;">
                              <h1> <?php echo t('Are ')?> <span><?php echo t('you a Tradesman')?>?</span></h1>
                              <div style="min-height:175px;">
                                    <ul>
                                          <li><?php echo t('Create your profile')?></li>
                                          <li><?php echo t('Receive job offers from clients')?></li>
                                          <li><?php echo t('Grow your business')?></li>
                                          <li><?php echo t('Make more money')?>!!</li>
                                    </ul>
                              </div>
                              <input  class="button" type="button" value="<?php echo t('How it Works')?> " onclick="window.location.href='<?php echo base_url().'home/how_it_works/TWlOaFkzVT0/';?>'"/>
                        </div>
                        <div class="spacer"></div>
                  </div>
                  <div class="right_box_all">
                        <h1 style="float:left"><?php echo get_title_string(t('Featured Tradesman'))?><?php //echo t('Featured')?> <span><?php //echo t('Tradesman')?> </span></h1>
                        <a href="<?php echo base_url().'find_tradesman' ?>" class="red_link right"><em><?php echo t('View All Tradesman')?>..</em>.</a>
                        <div class="shadow_big">
                              <div class="right_box_all_inner" style="padding:0px;">
                                    <!--box-->
									
							  <?php
							  if($tradesman_list)
							  {
							  	$i=1;
							  	  foreach($tradesman_list as $val)
								  {
								$img = (!empty($val["s_user_image"])&&file_exists($image_up_path."thumb_".trim($val["s_user_image"])))?" <img src='".$image_path."thumb_".$val["s_user_image"]."' width='66' height='65'  />":" <img src='images/fe/man.png'/>";
								$profile_link = base_url()."tradesman_profile/".encrypt($val['id']);
								//echo $img;
							  ?>
                                    <div class="<?php echo ($i++%2) ? 'white_box':'white_box sky_box'?>">
                                         <div class="photo"><a href="<?php echo $profile_link?>"><?php echo $img;?></a></div>
                                          <div class="inner_box">
                                                <h6><a href="<?php echo $profile_link?>" class="red_link"><?php echo $val['s_name']?></a><span> - <?php echo t('Member since')?> <?php echo $val['dt_created_on']?></span></h6>
                                                <div class="inner_box_left">
                                                      <h5><?php echo t('Main Skills & Trades')?>:</h5>
                                                       <?php echo $val['s_skills']?> </div>
                                                <div class="inner_box_right"> 
														<?php if($val['i_jobs_won'] > 0) { ?>
														 <span><?php echo $val['i_jobs_won']?> </span> <?php echo t('jobs won')?>
										  				<?php } ?>
														<br />
														<?php if($val['i_feedback_received']>0) { ?>
                                                <?php echo $val['i_feedback_received']?> <?php echo t('feedback comments')?>
												<?php } ?>
                                                      <br />
                                                      <?php echo show_star($val['i_feedback_rating']);?>
												</div>
                                          </div>
                                          <div class="spacer"></div>
                                    </div>
                                    
                                    <!--box end-->
									<?php 
								}
							} else echo t('No Record Found');?> 
                              </div>
                        </div>
                  </div>
				  <?php
				  if($complete_job_list)
				  {
				  ?>
				  
                  <div class="right_box_all">
                        <h1 style="float:left"><?php //echo get_title_string(t('Jobs Just Completed'))?><?php echo t('Jobs ')?><span> <?php echo t('Just Completed')?></span></h1>
						<?php
						if(decrypt($loggedin['user_type_id'])!=1)
						{
						?>
                        <a href="<?=base_url().'job/completed_job'?>" class="red_link right"><em><?php echo t('More')?>..</em>.</a>
						<?php } ?>
                        <div class="shadow_big">
                              <div class="right_box_all_inner" style="padding-bottom:0px;">
							  	<?php
								foreach($complete_job_list as $val)
								{
								?>
                                    <div class="com_job"> <a href="<?=base_url().'job/job_details/'.encrypt($val['id'])?>" class="red_link"><strong><?=$val['s_title']?></strong></a>
                                          <p><?=$val['s_description']?></p>
                                          <div class="indx_work"><?=$val['s_category_name']?></div>
                                          <div class="indx_work2"><?=$val['s_city']?></div>
										  <div class="indx_work4"><b><?php echo t('Tradesman')?></b>:<?=$val['s_username']?></div>
                                          <div class="indx_work3"><em><?php echo t('Completed').t(' on')?>: <?=$val['dt_completed_date']?> </em></div>
                                          <div class="spacer"></div>
                                    </div>
								<?php } ?>	
									
                              </div>
                        </div>
                  </div>
				  <?php } ?>
				  
            </div>
            <div class="spacer"></div>
      </div>

	  