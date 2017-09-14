<script type="text/javascript">
(function($){    
$(document).ready(function()
{
	$("#firstpane div.menu_head").css({background:"url(images/fe/next.png) no-repeat right"}); 
 	$("#firstpane div.menu_head").click(function() {
	
		$("#firstpane div.menu_head").css({background:"url(images/fe/next.png) no-repeat right"})		
		if(($(this).next().css('display'))=='none') {
			$(this).css({background:"url(images/fe/down.png) no-repeat right"});
		}
		else {
			$(this).css({background:"url(images/fe/next.png) no-repeat right"});
		}
		
  		$(this).next("div.menu_body").slideToggle(300).siblings("div.menu_body").slideUp("slow");		
	});
 
});
})(jQuery); 
</script>
<?php if($feedbacks) { 
		foreach($feedbacks as $val)
			{
				$job_url	=	make_my_url($val['s_job_title']).'/'.encrypt($val['i_job_id']) ;
 ?>
<div id="firstpane">
	<div class="menu_head">
		<p><?php echo $val['s_job_title'] ?> <a href="<?php echo base_url().'job-details/'.$job_url ; ?>" target="_blank"><img title="edit" onclick="this.src='images/fe/view.png'" onmouseout="this.src='images/fe/view.png'" onmouseover="this.src='images/fe/view-hover.png'" alt="" src="images/fe/view.png"></a></p>
		<span><?php echo addslashes(t('rating')).' - ' ?><!--Bricklaying<img src="images/fe/blue-star.png" alt="" class="left" />
		<img src="images/fe/blue-star.png" alt="" /><img src="images/fe/blue-star.png" alt="" />
		<img src="images/fe/blue-star.png" alt="" /><img src="images/fe/gry-star.png" alt="" />-->
		<?php echo show_star($val['i_rating']) ?>
		</span> 
		<div class="spacer"></div>
	</div>
	
<div class="menu_body" style="display:none">
<p><?php echo $val['s_comments'] ?> <span>
<strong>- <?php echo $val['s_sender_user']?></strong><br/>
<?php echo $val['dt_created_on'] ?></span></p>
<?php if($val['i_positive']==1) { ?>
<div class="positive"><img src="images/fe/Positive.png" alt="" /> <?php echo addslashes(t('Positive Feedback'))?></div>
<?php } else { ?>
<div class="positive"><img src="images/fe/Negetive.png" alt="" /> <?php echo addslashes(t('Negative Feedback'))?></div>
<?php } ?>
</div>
<div class="spacer"></div>

<div class="spacer"></div>
</div>  
<?php } } else { ?>	
<p><?php echo addslashes(t('No item found'))?> 
<?php } ?>
<!-- end div firstpane-->	
	  
  <div class="spacer"></div>
  <div class="page">
		<?php echo $page_links ?>
  </div>