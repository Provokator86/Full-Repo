<script type="text/javascript">
  $(document).ready(function() {
      
      /****** Invite tradesman started ***********/
      $("#get_quote").click(function(){
          var tradesman_id  =   '<?php echo encrypt($info_tradesman['id']); ?>' ;
            $.ajax({
                type: "POST",
                url: base_url+'find_tradesman/ajax_fetch_active_jobs',
                data: "tradesman_id="+tradesman_id,
                success: function(msg){
				
				   if(msg=='not_login')
				   {
				   	 //alert(msg);	
					 window.location.href='<?php echo base_url().'user/login/TVNOaFkzVT0' ?>';
				   }	
                   else 
                   {
					   $("#job_listing").html(msg);
					   show_dialog('photo_zoom03');                       
                   }   
                }
            });   
          
      });  // end of get quote button
      
  });
  
function inviteTradesman()
{
      var i_invite  =   true ;
      $("input[name^=chk_jobs]:checked").each(function(){
          i_invite  =   false ;
      }); 
      if(i_invite)
      {
          $("#err_no_chk").text('<?php echo addslashes(t('Please select job')); ?>').slideDown(1000).delay(1000).fadeIn(1000);
      }
      else
      {
        
          $("#err_no_chk").hide();
          $("#frm_invite_req").submit();
          
      }
      
}
  
</script>
<div class="job_categories">
            <div class="top_part"></div>
            <div class="midd_part height02">
                  <div class="username_box">
                
                        <div class="left_box02"> <?php echo showThumbImageDefault('user_profile',$info_tradesman['s_image'],'no_image_man.png',259,178); ?>
                              <div class="spacer"></div>
							  <?php if(empty($loggedin) || decrypt($loggedin['user_type_id'])==1) { ?>
                              <input type="button" id="get_quote" value="<?php echo addslashes(t('Get a Quote'))?>" class="button marginleft02" href="javascript:void(0);"/>
                              <?php } ?>
                              
                              <div class="rating"><?php echo $info_tradesman['f_positive_feedback_percentage'] ?>% <?php echo addslashes(t('rating'))?> <br/> <?php echo show_star($info_tradesman['i_feedback_rating']); ?>

</div>
                        </div>
                        <div class="right_box02">
                            <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?> 
                              <h2><?php echo $info_tradesman['s_username'] ; ?> (<?php echo $won_jobs?>) 
							  <span> <?php if($info_tradesman['i_ssn_verified'] ||  $info_tradesman['i_address_verified']  || $info_tradesman['i_mobile_verified'] || $info_tradesman['i_verified']){ ?>
							  <img src="images/fe/Verified.png" alt="" />
							   <?php echo addslashes(t('Verified Tradesman'))?> <?php } ?>
							  </span></h2>
                              <h3><?php echo $info_tradesman['s_city_name'].' - '.$info_tradesman['s_province']; ?></h3>
                              <div class="spacer"></div>
                              <div class="categories">
                                    <h4><?php echo addslashes(t('Categories of expertise'))?></h4>
                                    <ul>
                                    <?php 
                                    if(!empty($arr_cat))
                                    {
                                        foreach($arr_cat as $val)
                                        { 
                                    ?>
                                    
                                          <li><img src="images/fe/tick.png" alt="" /><span><?php echo $val['s_category_name']?></span><em><?php echo $val['s_experience'].' ' ; echo ($val['s_experience']==1)?addslashes(t('year')):addslashes(t('years')); ?> </em></li>
                              <?php                                            
                                        }
                                    }
                                ?>
                                         
                                    </ul>
                              </div>
                              <div class="categories lastbox">
                                    <h4><?php echo addslashes(t('About working info'))?></h4>
                                    <ul>
                                    <?php
                                    if(!empty($work_place))
                                    {
                                        foreach($work_place as $val)
                                        {
                                    ?>
                                         <li><img src="images/fe/tick.png" alt="" /><?php echo $val['s_work_place'];  ?></li>
                                    <?php        
                                        }
                                    }
									
                                    ?>
									
									<?php if(!empty($payment_unit)) { ?>
                                    <li><img src="images/fe/tick.png" alt="" /><?php echo $payment_unit;  ?></li>
									<?php } ?>
									
									<?php if(!empty($work_days)) { ?>
                                    <li><img src="images/fe/tick.png" alt="" /><?php echo $work_days;  ?></li>
									<?php } ?>
                                   
									 <?php
                                    if(!empty($payment_time))
                                    {
                                        foreach($payment_time as $val)
                                        {
                                    ?>
                                         <li><img src="images/fe/tick.png" alt="" /><?php echo $val['s_pay_time'];  ?></li>
                                    <?php        
                                        }
                                    }
									
                                    ?>
                                         
                                         
                                    </ul>
                              </div>
                              <div class="spacer"></div>
                              
                             <div class="keyword_box"> 
                             <ul class="keyword">
                              <li><strong><?php echo addslashes(t('keywords'))?>:</strong></li>
                              <?php 
                              if(!empty($arr_keyword)) 
                              {
                                foreach($arr_keyword as $val)
                                {
                              ?>
                               <li> <a href="javascript:void(0);"><?php echo $val; ?></a></li>
                              <li>,&nbsp;</li>
                              
                              <?php       
                                }    
                              }
                               ?>
                             
                             
                              </ul> <div class="spacer"></div></div>
                              
                        </div>
                        <div class="spacer"></div>
                        <div class="body_left">
                        <div class="box03_out">
                              <div class="box03">
                                    <h3><?php echo addslashes(t('Profile Verified By'));  ?></h3>
                                    <?php if($info_tradesman['i_ssn_verified'] ||  $info_tradesman['i_address_verified']  || $info_tradesman['i_mobile_verified'] || $info_tradesman['i_verified'])
                                    {
                                        ?>
										<div class="verified_bg">
                                        <img src="images/fe/Verified02.png" alt="" />
										</div>
                                   <?php   
                                    } 
                                        ?>
                                    
                                    <div class="spacer"></div>
                                    <ul class="next_box03">
									<?php if($info_tradesman['i_ssn_verified']) { ?>
                                          <li><?php echo addslashes(t('Social security number'));  ?></li>
									<?php } ?>
									<?php if($info_tradesman['i_tax_no_verified']) { ?>
                                          <li><?php echo addslashes(t('Tax number'));  ?></li>
									<?php } ?>  
									<?php if($info_tradesman['i_address_verified']) { ?>
                                          <li><?php  echo addslashes(t('Address proof'));  ?></li>
									<?php } ?>
									<?php if($info_tradesman['i_mobile_verified']) { ?>
                                          <li><?php echo addslashes(t('Mobile phone'));  ?></li>
									<?php } ?>
									<?php if($info_tradesman['i_verified']) { ?>
                                          <li><?php echo addslashes(t('Email'));  ?></li>
									<?php } ?>	
									
                                          <?php /*?><li class="nobg"><img src="<?php  echo ($info_tradesman['i_address_verified'])?'images/fe/tick.png':'images/fe/deactivated.png' ; ?>"><?php  echo addslashes(t('Address proof'));  ?></li>
                                          <li class="nobg"><img src="<?php  echo ($info_tradesman['i_mobile_verified'])?'images/fe/tick.png':'images/fe/deactivated.png' ; ?>"><?php  echo addslashes(t('Mobile phone'));  ?></li>
                                          <li class="nobg"><img src="<?php  echo ($info_tradesman['i_verified'])?'images/fe/tick.png':'images/fe/deactivated.png' ; ?>"><?php echo addslashes(t('Email'));  ?></li><?php */?>
                                    </ul>
                                    <div class="spacer"></div>
                                   <!--<h4>Note: Only email verification not enough to get this</h4>-->
                                    <div class="spacer"></div>
                              </div></div>
                              
                              <div class="box03_out">
                              <div class="box03">
                                    <h3><?php echo addslashes(t('User stats'))?></h3>
                                    <ul class="next_box">
                                          <li><?php echo addslashes(t('Member since')); ?> <?php echo $info_tradesman['s_created_on']; ?></li>
                                          <li><?php echo addslashes(t('Last Login')); ?>: <?php echo $info_tradesman['s_last_login_on']; ?></li>
                                          <li> <?php echo $won_jobs.' '.addslashes(t('Won Jobs')); ?></li>
                                          <li><?php echo $quote_placed.' '.addslashes(t('quote placed')); ?></li>
                                          <!--<li># people viewed</li>   -->
                                    </ul>
                                    <div class="spacer"></div>
                              </div>
                              </div>
                              <div class="box03_out">
                              <div class="box03">
                                    <h3><?php echo addslashes(t('Similar tradesmen')); ?></h3>
                                    <ul class="next_box02">
                                    <?php
                                    // similar tradesman bhy category
                                    if(!empty($similar_tradesman))
                                    {
                                        foreach($similar_tradesman as $val)
                                        {
                                    ?>
                                        <li><a href="<?php echo base_url().'tradesman-profile/'.encrypt($val['i_user_id']) ?>"><?php echo $val['s_username']; ?></a></li>  
                                    <?php
                                        }
                                    }
                                    ?>

                                    </ul>
                                    <div class="spacer"></div>
                              </div>
                              </div>
                              <div class="box03_out">
                              <div class="box03">
                                    <h3><?php echo addslashes(t('Adsense  box'))?></h3>
									<?php //echo $info_tradesman['membership'][0]['i_plan_type'].'====' ?>
                                    <p><?php echo addslashes(t('ADSENSE'))?></p>
                                    <div class="spacer"></div>
                              </div>
                              </div>
                        </div>
                        <div class="body_right">
                              <div id="div_container">
                                    <ul class="tab7">
                                          <li><a href="JavaScript:void(0);" title="post_a_Job" class="tab2 active1"><span><?php echo addslashes(t('About tradesmen')); ?></span></a></li>
                                          <li>|</li>
										  <?php if($info_tradesman['membership'][0]['i_plan_type']!=2 && !empty($loggedin)) { ?>
                                          <li><a href="JavaScript:void(0);" title="get_quotes" class="tab2"><span><?php echo addslashes(t('Contact info')); ?></span></a></li>
                                          <li>|</li>
										  <?php } ?>
                                          <li><a href="JavaScript:void(0);" title="tradesman" class="tab2"><span><?php echo addslashes(t('Feedback')); ?></span></a></li>
                                    </ul>
                                    <div class="spacer"></div>
                                    <div class="body_right_03_inner">
                                          <!--1st tab-->
                                          <div class="tsb_text02" id="post_a_Job" style="display:block;">
                                                <p><?php echo nl2br($info_tradesman['s_about_me']); ?></p>
                                                <div class="spacer"></div>
                                          </div>
                                          <!--1st tab-->
                                          <!--2nd tab-->
										  <?php if($info_tradesman['membership'][0]['i_plan_type']!=2) { ?>
                                          <div class="tsb_text02" id="get_quotes" style="display:none;">
                                                <div class="lable03"><?php echo addslashes(t('Firm/Company name'))?>:</div>
                                                <div class="lable05">
												<?php if($info_tradesman['i_type']==2) { ?>
												<?php echo $info_tradesman['s_firm_name']; } else { ?>
												<?php echo $info_tradesman['s_business_name']; } ?>
												</div>
                                                <div class="spacer"></div>
                                                <div class="lable03"><?php echo addslashes(t('Address'))?>:</div>
                                                <div class="lable05"><?php echo $info_tradesman['s_address']; ?></div>
                                                <div class="spacer"></div>
                                                <div class="lable03"><?php echo addslashes(t('Contact number'))?>:</div>
                                                <div class="lable05"><?php  echo $info_tradesman['s_contact_no']; ?></div>
                                                <div class="spacer"></div>
                                                <!--<div class="lable03">Mobile:</div>
                                                <div class="lable05"></div>
                                                <div class="spacer"></div>-->
                                                <div class="lable03"><?php echo addslashes(t('Email'))?>:</div>
                                                <div class="lable05"><?php echo $info_tradesman['s_email']; ?></div>
                                                <div class="spacer"></div>
                                                <!--<div class="lable03">Website:</div>
                                                <div class="lable05"></div>-->
                                                <div class="spacer"></div>
                                                <h4><?php echo addslashes(t('Photo Album'))?></h4>
                                                <div class="photo_album1">
                                                <?php if(!empty($info_album))
                                                {
                                                    foreach($info_album as $val)
                                                    { 
													$photo_id = (strlen($val['id'])>1)?$val['id']:"0".$val['id'];
                                                ?>
                                                <div class="photo"><a onclick="show_dialog('photo_zoom<?php echo $photo_id ?>')"><?php echo showThumbImageDefault('trades_album',$val['s_image'],'no_image.jpg',100,100); ?></a></div>
                                                
                                                <?php
                                                    }
                                                } 
                                                ?>
                                                      <div class="spacer"></div>
                                                </div>
                                          </div>
										  <?php } ?>
                                          <!--2nd tab-->
                                          <!--3rd tab-->
                                          <div class="tsb_text02" id="tradesman" style="display:none;">
                                          <?php 
                                          if(!empty($feedback_contents))
                                          {
                                              foreach($feedback_contents as $val)
                                              {
                                          ?>
                                           <div class="main_faq">
                                                      <div class="faq_heading"><?php echo $val['s_job_title'] ; ?></div>
                                                      <div class="faq_contant">
                                                           <div class="feed_back width02">
                                                             <div class="left_feedback"><h5><img src="images/fe/dot1.png" alt="" /><?php echo $val['s_comments'] ; ?></h5>
                                                             <?php if($val['i_positive']==1)
                                                              {
                                                              ?>
                                                                    <h6><img src="images/fe/Positive.png" alt="" /><?php echo addslashes(t('Positive feedback')) ;?></h6>
                                                              <?php    
                                                              }
                                                              else
                                                              {
                                                              ?>
                                                                    <h6><img src="images/fe/Negetive.png" alt="" /><?php echo addslashes(t('Negetive feedback')) ;?></h6>
                                                              <?php    
                                                              }
                                                              ?>
                                                             
                                                             </div>
                                                             <div class="right_feedback">
                                                             <h6><?php echo $val['s_sender_user'] ; ?><br/><span><?php echo $val['dt_created_on'] ; ?></span></h6>
                                                             <?php echo show_star($val['i_rating']); ?>
                                                             </div>
                                                             <div class="spacer"></div>
                                                           </div>
                                                      </div>
                                           </div>
                                          <?php
                                              }
                                          }
                                          else
                                          {
                                              echo '<p>'.addslashes(t('No item found')).'</p>'; 
                                          }
                                          ?>
                                               
                                         </div>
                                          <!--3rd tab-->
                                    </div>
                              </div>
                              
							  <?php if(count($tradesman_history)>0) {  ?>
                              <h3><?php echo addslashes(t('History'))?> </h3>
                              <ul class="next06">
							  <?php if(count($tradesman_history)>0) {
							  		foreach($tradesman_history as $val)
									{
							   ?>
                              <li><?php echo $val['msg_str'] .' , '.time_ago($val['i_create_date'])?></li>
							  <?php } }  ?>
							  
                              </ul>
							  <?php } ?>
                        </div>
                        <div class="spacer"></div>

                        
                  </div>
                  <div class="spacer"></div>
            </div>
            <div class="spacer"></div>
            <div class="bottom_part"></div>
      </div>
      
<!--Invite lightbox-->
<div class="lightbox03 photo_zoom03"> 
<div class="close"><a href="javascript:void(0)" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
<h3><?php echo addslashes(t('Invite Tradesman')); ?></h3>
<p><?php echo addslashes(t('List of Active jobs for which you want to invite the Tradesman')); ?></p>

<form action="<?php echo base_url().'buyer/invite-tradesman' ?>" method="post" name="frm_invite_req" id="frm_invite_req">
<input type="hidden" value="1" name="tradesman_profile">
<div class="error_massage" style="display: none;" id="err_no_chk"></div>
<div id="job_listing"></div>

</form>
</div>
<!--Invite lightbox-->

<!--lightbox photo-->
 <?php if(!empty($info_album))
{
	foreach($info_album as $val)
	{ 
	$src_img = $val['s_image']?base_url().'uploaded/album/'.$val['s_image']:""; 
	$photo_id = (strlen($val['id'])>1)?$val['id']:"0".$val['id'];
?>
<div class="lightbox02 photo_zoom<?php echo $photo_id ?>">
  <div class="close"><a href="javascript:void()" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div> 
  <div class="photo_big"><img src="<?php echo $src_img ?>" alt="<?php echo $val['s_title'] ?>" width="250" height="235" /></div>
</div>
<?php } }?>
<!--lightbox photo-->