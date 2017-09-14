<script>
	$(document).ready(function() {
	$('.faq_contant').hide();
	$('.faq_heading').click(function(){
		if( $(this).parents('.main_faq02').find(".faq_contant" ).css('display') == 'none' ) {
			$('.faq_contant').slideUp('slow');
			$('.faq_heading').removeClass("sel");
			$(this).parents('.main_faq02').find(".faq_contant" ).slideDown('slow');
			$(this).addClass("sel");
		}
		else {
			$(this).parents('.main_faq02').find(".faq_contant" ).slideUp('slow');
			$(this).removeClass("sel");
		}
	});

});	
</script>
<?php if($tradesman_list) { 
        $cnt = 1;
    foreach($tradesman_list as $val)
        {
        $class = ($cnt%2!=0)?"find_tradesman_box":"find_tradesman_box hover_box";
 ?>
<div class="<?php echo $class ?>">
     <div class="left_photo"><?php echo showThumbImageDefault('user_profile',$val['s_image'],'no_image.jpg',65,65,'photo') ; ?>
      <?php if($val['i_ssn_verified']==1 || $val['i_address_verified']==1 || $val['i_mobile_verified']==1 || $val['i_verified']==1)  { ?>
      <div class="verified_icon"><img src="images/fe/Verified.png" alt="" /><p><?php echo addslashes(t('Verified'))?></p></div>
      <?php } ?>
     
     </div>
                    
                     
     <div class="right_content width02">
           <div class="member_box">
           <div class="membername"><a href="<?php echo base_url().'tradesman-profile/'.encrypt($val['id']) ?>"><?php echo $val['s_username'] ?> </a> <br/><em><?php echo $val['s_city'] ?></em></div>
           <div class="invite">
           <div class="div01">
           
           <a href="javascript:void(0);" onclick="show_active_tradesman('<?php echo encrypt($val['id']); ?>');"><?php echo addslashes(t('Invite'))?></a>  |<a href="<?php echo base_url().'tradesman-profile/'.encrypt($val['id']) ?>"> <?php echo addslashes(t('View Profile'))?></a>
           </div>
<div class="spacer"></div>                                
<em><?php echo addslashes(t('Member since'))?> <?php echo $val['dt_created_on'] ?></em>                                  
           </div>
           <div class=" spacer"></div>
          
           </div>
           <div class=" spacer"></div>
           
           
           <div class="trades">
           <h3><?php echo addslashes(t('Main Skills'))?> &amp; <?php echo addslashes(t('Trades'))?>:</h3>
         
		   <p><?php echo $val['category'] ?></p>
          
           </div>
           
           <div class="won_job"><?php echo $val['i_jobs_won'] ?> <?php echo addslashes(t('jobs won'))?><br/> 
           <?php echo show_star($val['i_feedback_rating']) ?>
           </div>
           <div class="spacer"></div>

           <div class="main_faq02">
              <div class="faq_heading faq_heading02">
              <p><?php echo $val['i_feedback_received']?> <?php echo addslashes(t('Feedback reviews'))?> 
              <?php if($val['f_positive_feedback_percentage']>0) { ?>
              <span>, <?php echo $val['f_positive_feedback_percentage']?>% <?php echo addslashes(t('positive'))?>
              </span>
              <?php } ?>
              </p>
              </div>
              <?php if($val['i_feedback_received']>0) { 
                    $feedback = $val['feedback'];
                ?>    
              <div class="faq_contant">
                   <div class="feed_back width02" style="width:560px;">
                     <div class="left_feedback"><h5><img src="images/fe/dot1.png" alt="" />
                     <?php echo $feedback['s_comments']?></h5>
                     <?php if($feedback['i_positive'] == 1) {?> 
                     <h6><img src="images/fe/Positive.png" alt="" /><?php echo addslashes(t('Positive feedback'))?></h6>
                     <?php } else { ?>
					 <h6><img src="images/fe/Negetive.png" alt="" /><?php echo addslashes(t('Negative feedback'))?></h6>
					 <?php } ?>
                     </div>
                     <div class="right_feedback">
                     <h6><?php echo $feedback['s_sender_user']?><br/><span><?php echo $feedback['dt_created_on']?></span></h6>
                     <?php echo show_star($feedback['i_rating']) ?>
                     </div>
                 <div class="spacer"></div>
                </div>
              </div>
               <?php 
                 } else 
                 {
                echo '<div class="faq_contant"><div class="feed_back" style="width:560px;">'.addslashes(t('No feedback rating yet')).'</h5></div></div>';                                      
                 }
                 ?> 
              
        </div>
           
           
           
     </div>
     <div class="spacer"></div>
</div>
<?php $cnt++; } } else {?>
<div class="find_tradesman_box">
    <div class="left_photo"></div>
    <div class="right_content"><div class="trades">
    <p> <?php echo addslashes(t('no item found'))?></p>
    </div></div>
</div>
<?php } ?>
<!-- End find tradesman box div -->               
                
<div class=" spacer"></div>
<div class="page">
    <?php echo $page_links ?>
</div>