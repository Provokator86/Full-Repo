<script type="text/javascript">
$(document).ready(function(){

$(".lightbox1_main").fancybox({
	'titlePosition'		: 'inside',
	'transitionIn'		: 'none',
	'transitionOut'		: 'none',
	'showCloseButton'	: true
});

$("div.job_box").last().css('border-bottom','none');


	$("#news_submit").click(function(){		
			 $("#frm_newletter").submit();
		});
	
	$("#frm_newletter").submit(function(){
		 var b_valid=true;
		 var s_err="";
		// $("#newsletter_err").hide("slow"); 
		 var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
		 
		 if($.trim($("#txt_name").val())=="" || $.trim($("#txt_name").val())=="Name") 
		 {
			s_err +='Enter name.<br />';
			b_valid=false;
		 }
		 if($.trim($("#txt_email").val())=="" || $.trim($("#txt_email").val())=="Email") 
		 {
		 	s_err +='Enter email.<br />';
			b_valid=false;
		 }
		 else if(!emailPattern.test($("#txt_email").val()))
		 {
		 	s_err +='Wrong email format.<br />';
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
<script type="text/javascript">
var base_url = '<?php echo base_url();?>';
$(function() {
	$(".testimonial").jCarouselLite({
		vertical: true,
		hoverPause:true,
		visible: 1,
		auto:200,
		speed:3000
	});
});

$(document).ready( function(){	
	$('#lofslidecontent45').lofJSidernews 
	({
		interval:4000,
   		direction:'opacity',
   		duration:1000,
   		easing:'easeInOutSine'
	});						
});

function frm_status_submit()
{
	$("#frm_status").submit();
}
</script>

<div id="banner_section">
    <div id="banner">
		<div style="height:30px;">

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
		<div id="account_box">
		<img src="images/fe/icon-06a.png" alt="" />Welcome <?php echo $loggedin['user_name']?> <span>|</span>
		<img src="images/fe/dashboarda.png" alt="" /><a href="<?php echo base_url().'user/dashboard'?>">Your Dashboard</a> <span>|</span> <img src="images/fe/logouta.png" alt="" /><a href="<?php echo base_url().'user/logout'?>">Sign out</a> </div>
					
		<?php } ?><div class="clr"></div>
		</div>
        <!-- gallery -->
        <div id="gallery">
            <div id="lofslidecontent45" class="lof-slidecontent">
                <div class="preload">
                    <div></div>
                </div>
                <!-- MAIN CONTENT -->
                <div class="lof-main-outer">
                    <ul class="lof-main-wapper">
					<?php
					if($banner_list)
					{
						$cnt = 1;
						foreach($banner_list as $val)
						{
					?>
                        <li> <!--<img src="images/fe/image1_big.jpg" alt="" title="Newsflash 1">-->
							<img src="<?php echo $thumbPath.'thumb_'.$val['s_banner_file'] ?>" alt="" title="">
							 <div class="lof-main-item-desc" style="height:75px; text-align:left;">
                                <h4><?php echo $val['s_title'] ?> - <span class="grey_txt12"><?php echo $val['s_name'] ?> </span></h4>
                                <p><?php echo $val['s_desc'] ?>.</p>
                            </div>
                        </li>
                      <!-- <li> <img src="images/fe/image2_big.jpg" title="Newsflash 2">
                            <div class="lof-main-item-desc">
                                <h4>Lorem Ipsum is simply dummy text - <span class="grey_txt12">Brooklyn, NY</span></h4>
                                <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.</p>
                            </div>
                        </li>
                         <li> <img src="images/fe/image1_big.jpg" title="Newsflash 3">
                            <div class="lof-main-item-desc">
                                <h4>Lorem Ipsum is simply dummy text - <span class="grey_txt12">Brooklyn, NY</span></h4>
                                <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.</p>
                            </div>
                        </li>
                        <li> <img src="images/fe/image2_big.jpg" title="Newsflash 4">
                            <div class="lof-main-item-desc">
                                <h4>Lorem Ipsum is simply dummy text - <span class="grey_txt12">Brooklyn, NY</span></h4>
                                <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.</p>
                            </div>
                        </li>
                        <li> <img src="images/fe/image1_big.jpg" title="Newsflash 5">
                            <div class="lof-main-item-desc">
                                <h4>Lorem Ipsum is simply dummy text - <span class="grey_txt12">Brooklyn, NY</span></h4>
                                <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.</p>
                            </div>
                        </li>
                        <li> <img src="images/fe/image2_big.jpg" title="Newsflash 6">
                            <div class="lof-main-item-desc">
                                <h4>Lorem Ipsum is simply dummy text - <span class="grey_txt12">Brooklyn, NY</span></h4>
                                <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.</p>
                            </div>
                        </li>-->
						<?php } $cnt++; } ?>
                    </ul>
                </div>
                <!-- END MAIN CONTENT -->
                <!-- NAVIGATOR -->
                <div class="lof-navigator-outer">
                    <ul class="lof-navigator">
						<?php
					if($banner_list)
					{
						$cnt = 1;
						foreach($banner_list as $val)
						{
					?>
                        <li>
                            <div style="text-align:center;"> <!--<img src="images/fe/image1.jpg" alt="" />-->
							<img src="<?php echo $thumbPath.'thumb_small_'.$val['s_banner_file'] ?>" alt="" /> </div>
                        </li>
                        <!--<li>
                            <div> <img src="images/fe/image2.jpg" alt="" /> </div>
                        </li>
                        <li>
                            <div> <img src="images/fe/image1.jpg" alt="" /> </div>
                        </li>
                        <li>
                            <div> <img src="images/fe/image2.jpg" alt="" /> </div>
                        </li>
                        <li>
                            <div> <img src="images/fe/image1.jpg" alt="" /> </div>
                        </li>
                        <li>
                            <div> <img src="images/fe/image2.jpg" alt="" /> </div>
                        </li>-->
						<?php } $cnt++; } ?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /gallery -->
        <!-- log box -->
		

		
		
        <!-- /log box -->
        <!-- search box -->
        <div id="search">
            <div class="tab_box">
                <ul>
                    <li><a href="javascript:void(0)" id="tab1" class="select">Client</a></li>
                    <li><a href="javascript:void(0)" id="tab2">Professional</a></li>
                </ul>
            </div>
			<form name="frm_indx_professional_src" method="post" action="<?php echo base_url().'find_tradesman'?>">
            <div class="form_box" id="divtab1">
                <div class="label01">What service do you need ?</div>
                <div class="field01">
                    <input name="txt_fulltext_src" id="txt_fulltext_src" type="text" />
                </div>
                <div class="label02"><span>For example:</span> Handyman, Babysitter, Personal Trainer... </div>
                <div class="label01">City/Post Code</div>
                <div class="field01">
                    <input name="txt_fulladd_src" id="txt_fulladd_src" type="text" />
                </div>
                <div class="field02">
                    <input type="submit" value="Search" class="btn_submit"  />
                </div>
            </div>
			</form>
            
			<form name="frm_indx_job_src" method="post" action="<?php echo base_url().'job/find_job'?>">
            <div class="form_box" id="divtab2" style="display:none;">
                <div class="label01">What type of job do you need?</div>
                <div class="field01">
                    <input type="text"  name="txt_fulltext_src" id="txt_fulltext_src" />
                </div>
                <div class="label02"><span>For example:</span> Handyman, Babysitter, Personal Trainer...</div>
                <div class="label01">City/Postal Code</div>
                <div class="field01">
                   <input type="text" name="txt_fulladd_src" id="txt_fulladd_src" />
                </div>
                <div class="field02">
                    <input type="submit" value="Submit" class="btn_submit"/>
                </div>
            </div>
			</form>
            
        </div>
        <!-- /search box -->
        <div class="clr"></div>
    </div>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
<div id="service_section">
    <!--<div id="service">
        <img src="images/fe/numbering.png" alt="" />
    </div>-->
	<div class="banner_buttom_bg">
  		<div class="banner_buttom_bg_wrapper">
  				<div class="box01">Post<br/>
        				<span>a job</span></div>
        		<div class="box01">Receive <br/>
						<span>quotes</span></div>
				<div class="box01">Hire<br/>
						<span>the best</span></div>
				<div class="box01" style="margin-left:100px; margin-right:0px;">Leave<br/>
						<span>a Review</span></div>
   		</div>
	</div>
</div>
<!-- /SERVICES SECTION -->
<!-- CONTENT SECTION -->
<div id="content_section">
    <div id="content">
        <div id="index_container">
            <!-- left section -->
            <div id="left_section">
                <!-- client section -->
                <div id="client_section">
                    <div class="title">
                        <h3><span>Client?</span> Don’t Stress</h3>
                    </div>
                    <div class="content_box">
                        <ul class="list01">
                            <li>Let us do the hard work for you</li>
                            <li>Receive multiple quotes from top pros</li>
                            <li>View reviews and ratings easily</li>
                            <li>Save time , Save  money, its totally Free!!</li>
                        </ul>
                    </div>
                    <div class="how_box">
                        <input name="" type="button" class="btn" value="How it Works"  onclick="window.location.href='<?php echo base_url().'home/how_it_works/TVNOaFkzVT0' ?>'"/>
                    </div>
                </div>
                <!-- /client section -->
                <!-- professional section -->
                <div id="professional_section">
                    <div class="title">
                        <h3><span>Service</span> Professional</h3>
                    </div>
                    <div class="content_box">
                        <ul class="list01">
                            <li>Create a smashing profile</li>
                            <li>Receive multiple job offers from potential Clients</li>
                            <li>Grow your business faster</li>
                            <li>Make more money!!</li>
                        </ul>
                    </div>
                    <div class="how_box">
                        <input name="" type="button" class="btn" value="How it Works"  onclick="window.location.href='<?php echo base_url().'home/how_it_works/TWlOaFkzVT0' ?>'"/>
                    </div>
                </div>
                <!-- /professional section -->
                <div class="clr"></div>
                <!-- current section -->
                <div id="current_section">
                    <div class="title">
                        <h3><span>Job</span> Opportunities</h3>
                    </div>
                    <div class="content_box">
					<?php
					//pr($job_opportunity_list);
					if($job_opportunity_list)
					{
						foreach($job_opportunity_list as $val)
						{
							
					?>					
                        <div class="job_box">
                            <div class="date_box"><?php echo date("d M",$val['i_entry_date'])?><br />
                                <span><?php echo date("Y",$val['i_entry_date'])?></span></div>
                            <div class="job_detail">
                                <h4><a href="<?php echo base_url().'job/job_details/'.encrypt($val['id'])?>"><?php echo string_part($val["s_title"],30);?></a></h4>
                                <p><a href="<?php echo base_url().'job/job_details/'.encrypt($val['id'])?>"><?php echo string_part($val["s_description"],80);?> </a></p>
                            </div>
                        </div>
                   <?php
				   		}
				   } else 
				   		echo '<div class="job_box">No Job found.</div>';
				   ?>     
                        
                        
                    </div>
                    <div class="view_more"><a href="javascript:void(0);" onclick="frm_status_submit()">View More...</a></div>
                </div>
                <!-- /current section -->
                <!-- completed section -->
                <div id="completed_section">
                    <div class="title">
                        <h3><span>Completed</span> Jobs</h3>
                    </div>
                    <div class="content_box">
					<?php
					//pr($complete_job_list);
				 	 if($complete_job_list)
				  	 {
					 	foreach($complete_job_list as $val)
						{
				 	 ?>
                        <div class="job_box">
                            <div class="job_title"><a href="<?php echo base_url().'job/job_details/'.encrypt($val['id'])?>"><?php echo string_part($val["s_title"],20);?></a> - <span><?php echo $val['dt_entry_date']?></span></div>
                            <div class="job_detail">
                                <p><a href="<?php echo base_url().'job/job_details/'.encrypt($val['id'])?>"><?php echo string_part($val["s_description"],90);?></a></p>
                            </div>
                        </div>
                     <?php
					 	}
					 } else 
					 	echo '<div class="job_box">No Job found.</div>';
					 ?>   
                        
                        
                    </div>
                    <div class="view_more"><a href="<?php echo base_url().'job/completed_job' ?>">View More...</a></div>
                </div>
                <!-- /completed section -->
                <div class="clr"></div>
                <!-- feactured section -->
                <div id="feactured_section">
                    <div class="title">
                        <h3><span>Featured</span> Professionals</h3>
                    </div>
					<?php
					//pr($tradesman_list);
					 if($tradesman_list)
					 {
						$i=1;
						foreach($tradesman_list as $val)
						{
					?>	
                    <div class="<?php echo ($i%2) ? 'white_box' : 'grey_box'?>">
                        <div class="img_box"><a href="<?php echo base_url().'find_tradesman/tradesman_profile/'.encrypt($val['id'])?>"><?php echo showThumbImageDefault('user_profile',$val["s_user_image"],80,60);?></a></div>
                        <div class="txt_box01">
                            <p class="orng_txt16"><a href="<?php echo base_url().'find_tradesman/tradesman_profile/'.encrypt($val['id'])?>"><?php echo $val['s_username']?></a> <span>- Member since <?php echo $val['dt_created_on']?></span></p>
                            <div class="left_box">
                                <p class="blue_txt">Main Skills &amp; Trades:</p>
                                <p><?php echo $val['s_skills']?></p>
                            </div>
                            <div class="right_box">
                                <p><span class="blue_txt"><?php echo $val['i_jobs_won']?></span> job(s) won</p>
                                <p><span class="blue_txt"><?php echo $val['i_feedback_received']?></span> review comments</p>
                                <p> <?php echo show_star($val['i_feedback_rating']);?></p>
                            </div>
                        </div>
                    </div>
                    <?php
						$i++;
						}
					} else 
						echo '<div class="white_box">No featured tradesman found.</div>';
					?>
                    
					
                    
                    
                    <div class="view_more"><a href="<?php echo base_url().'find_tradesman'?>">View More...</a></div>
                </div>
                <!-- /feactured section -->
                <div class="clr"></div>
            </div>
            <!-- /left section -->
            <!-- right section -->
            <div id="right_section">
                <!-- category -->
                <div id="category">
                    <div class="title">
                        <h3><span>Jobs by</span> Category</h3>
                    </div>
                    <div class="content_box">
                        <div class="top">
                            <ul>
                                <li><a href="javascript:void(0)" id="1" class="select">Top Categories</a></li>
                                <li><a href="javascript:void(0)" id="2">All Categories A-Z</a></li>
                            </ul>
                        </div>
                        <div class="mid">
                            <div class="list_box" id="div1">
                                <ul class="list">                                   
								<?php
								if($top_category_list)
								{
									foreach($top_category_list as $val)
									{
								?>
								<li><a href="<?php echo base_url().'job/find_job/'.encrypt($val['id'])?>"><?php echo $val['s_category_name']?></a></li>
								<?php
									}
								} else {
								?>
									<li><a href="javascript:void(0);"><?php echo 'No record found';?></a></li>
								<?php	
									}
								 ?>
                                </ul>
                            </div>
                            <div class="list_box" id="div2" style="display:none;">
                                <ul class="list">
                                    <?php
								if($category_list)
								{
									foreach($category_list as $val)
									{
								?>
								<li><a href="<?php echo base_url().'job/find_job/'.encrypt($val['id'])?>"><?php echo $val['s_category_name']?></a></li>
								<?php
									}
								} else {
								?>
									<li><a href="javascript:void(0);"><?php echo 'No record found';?></a></li>
								<?php	
									}
								 ?>
                                </ul>
                            </div>
                            <div class="all_box">
                                <div class="view_all"><a href="<?php echo base_url().'job/find_job' ?>">All Categories</a></div>
                            </div>
                        </div>
                        <div class="bot">&nbsp;</div>
                    </div>
                </div>
                <!-- /category -->
                <!-- safety -->
                <div id="safety">

                    <div class="title">
                        <h3><span>Safety!!</span> <span class="small">Our top priority</span></h3>
                    </div>
					<?php
					if($safety)
					{
						foreach($safety as $val)
						{
					?>
                    <div class="content_box">
                        <p>"<?php echo substr($val['s_description'],0,100)?>.. "</p>
                    </div>
					<?php } } ?>
                    <div class="view_more"><a href="<?php echo base_url().'home/safety_details' ?>">Read More...</a></div>
                    <div class="image_box"><img src="images/fe/img-02.jpg" alt="" width="250" height="200" /></div>
                    <div class="facebook_box">
					<div class="fb-like-box" data-href="http://www.facebook.com/pages/Jobshoppa/146950728720680" data-width="250" data-show-faces="true" data-stream="false" data-header="false"></div>
					
					<!--<img src="images/fe/img-03.jpg" alt="" width="250" height="256" />-->
					
					</div>
                </div>
                <!-- /safety -->
                <!-- testimonial -->
                <div id="testimonial">
                    <div class="title">
                        <h3><span>Testimonials</span></h3>
                    </div>
                    <div class="content_box">
                        <div class="top">&nbsp;</div>
                        <div class="mid">
                            <div class="testimonial">
                                <ul>
									<?php
									if($testimonial_list)
									{
										foreach($testimonial_list as $val)
										{
									?>
                                    <li>
                                        <p class="test_txt"><img src="images/fe/q-mark-top.gif" alt="" /> 
										<?php echo $val['s_content']?>.. <img src="images/fe/q-mark-bot.gif" alt="" /></p>
                                        <p class="orng_txt14">- <?php echo $val['s_person_name']?></p>
                                        <p class="grey_txt12"><?php echo $val['fn_entry_date']?></p>
                                    </li>
									<?php 
									 	}
									 } else {
									 	echo '<li></li>';
									  } ?>  
                                </ul>								
                            </div>
                        </div>
                        <div class="bot">&nbsp;</div>
                    </div>
                    <div class="view_more"><a href="<?php echo base_url().'home/testimonial'?>">View More...</a></div>
                </div>
                <!-- /testimonial -->
                <!-- newsletter -->
                <div id="newsletter">
                    <div class="title">
                        <h3><span>Newsletter</span> Signup</h3>
                    </div>
					
                    <div class="content_box">
					<div id="newsletter_err" style="color:#F58726;"></div>
                        <div class="top">&nbsp;</div>
						<form name="frm_newletter" id="frm_newletter" action="<?php echo base_url().'home/save_newsletter'?>" method="post"> 
                        <div class="mid">
                            <div class="field01">
                                <input id="txt_name" name="txt_name" type="text" value="Name" onfocus="if(this.value=='Name')this.value='';" onblur="if(this.value=='')this.value='Name';" />
                            </div>
                            <div class="field01">
                                <input id="txt_email" name="txt_email" type="text" value="Email" onfocus="if(this.value=='Email')this.value='';" onblur="if(this.value=='')this.value='Email';" />
                            </div>
                            <div class="field01">
                                <input type="submit" id="news_submit" value="Subscribe" />
                            </div>
                        </div>
						</form>
                        <div class="bot">&nbsp;</div>
                    </div>
                </div>
                <!-- /newsletter -->
            </div>
            <!-- /right section -->
            <div class="clr"></div>
        </div>
    </div>
 </div>	
<form name="frm_status" id="frm_status" method="post" action="<?php echo base_url().'job/find_job'?>">	  
<input type="hidden" name="opt_status" id="opt_status" value="TVNOaFkzVT0=" />
</form>	
