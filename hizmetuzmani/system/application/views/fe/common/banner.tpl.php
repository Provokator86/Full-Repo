<script type="text/javascript">
jQuery(function($){
	$(document).ready(function(){
		$("#btn_list").click(function(){
		var trade_srch = '<?php echo base_url().'find-tradesman' ?>';
		$("#form_job_post").attr("action",trade_srch);
	$("#form_job_post").submit();
		});
	});

});
function submit_job()
{
var where_srch = $("#where").val();
var what_srch = $("#service").val();
if((where_srch=='' && what_srch=='') || (what_srch=='<?php echo addslashes(t('What service do you need ?')) ?>' && where_srch=='<?php echo addslashes(t('Where ?')) ?>') ||(what_srch=='Hangi Hizmete Ihtiyaciniz Var ?' || where_srch=='Nerede ?'))
{
window.location.href="<?php echo base_url().'job/job-post' ?>";
}
else
{
$("#form_job_post").submit();
}
}
</script>
<div class="banner_sh">
  <div id="banner"><!-- no-repeat scroll right center transparent -->
    <ul class="tab6">
      <li><a href="JavaScript:void(0);" title="reviews" class="tab1 active1"><?php echo addslashes(t('I Need That'))?>.. </a></li>
      <li><a href="JavaScript:void(0);" title="certificatess" class="tab1 "><?php echo addslashes(t('I Am Tradesman'))?></a></li>
      <li><a href="JavaScript:void(0);" title="pictures" class="tab1 "><?php echo addslashes(t('How It  Works'))?></a></li>
    </ul>
    <div class="body_right_03_inner">
	<?php if($carousel_image) {
	
		$photo_image = $carousel_path.$carousel_image[0]['s_banner_file'];
		$photo_image_service = $carousel_path.$carousel_image[1]['s_banner_file'];
	 ?>
	<script>
	$(document).ready(function() {
	var imagUrl = '<?php echo $photo_image; ?>';
	$('#service_tab').css('background', '');
	$('#service_tab').css({'background': 'url("'+imagUrl+'") no-repeat right'}); 
		
	var imagUrl2 = '<?php echo $photo_image_service; ?>';
	$('#job_tab').css('background', 'none');
	$('#job_tab').css({'background': 'url("'+imagUrl2+'") no-repeat right'});
	
	});
	</script>
	<?php } ?>
	
      <!--1st tab-->
      <div class="tsb_text" id="reviews" style="display:block;">
	  <form name="form_job_post" id="form_job_post" method="post" action="<?php echo base_url().'freesearch'?>">
        <div class="tab01" id="service_tab">
          <h2><?php echo addslashes(t('The Better Way to Find Builders'))?></h2>
          <p><?php echo stripslashes(addslashes(t('Every day, thousands of people depend on MyBuilder\'s trusted review system to take the worry out of finding professional local builders &amp; tradesmen')))?>.</p>
          <div class="textfell">
            <input type="text" id="service" name="txt_service" value="<?php echo addslashes(t('What service do you need'))?> ?" size="35" onclick="if(this.value=='<?php echo addslashes(t('What service do you need'))?> ?')
 document.getElementById('service').value ='';" onblur="if(this.value=='') document.getElementById('service')
.value ='<?php echo addslashes(t('What service do you need'))?> ?';" />
          </div>
          <div class="spacer"></div>
          <div class="textfell02">
            <input type="text" id="where" name="txt_where" value="<?php echo addslashes(t('Where'))?> ?" size="35" onclick="if(this.value=='<?php echo addslashes(t('Where'))?> ?')
 document.getElementById('where').value ='';" onblur="if(this.value=='') document.getElementById('where')
.value ='<?php echo addslashes(t('Where'))?> ?';" />
          </div>
          <!--<input class="button" type="button" onclick="submit_job()" value="<?php echo addslashes(t('Post Your Job for free'))?>" />			-->
		  <input class="button" type="button" id="btn_list" value="<?php echo addslashes(t('List'))?>" />			
		  <span><a href="javascript:void(0);" style="font-size:12px; font-weight:bold; color:#027AD1;" onclick="submit_job()"><?php echo addslashes(t('Post Your Job for free'))?></a></span>
		 
        </div>
	  </form>	
      </div>
      <!--1st tab-->
      <!--2nd tab-->
      <div class="tsb_text" id="certificatess" style="display:none; ">
	  <form name="frm_indx_job_src" method="post" action="<?php echo base_url().'job/find-job'?>">
     <div class="tab01 tab02" id="job_tab">
     <h2><?php echo addslashes(t('What job are you looking for'))?></h2>
     <p><?php echo stripslashes(addslashes(t('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.')))?>.
 </p>
 		<div class="textfell">
            <input type="text" id="job" name="txt_fulltext_src" value="<?php echo addslashes(t('What job do you need'))?> ?" size="35" onclick="if(this.value=='<?php echo addslashes(t('What job do you need'))?> ?')
 document.getElementById('job').value ='';" onblur="if(this.value=='') document.getElementById('job')
.value ='<?php echo addslashes(t('What job do you need'))?> ?';" />
          </div>
 
     <div class="textfell02">	 		
            <input type="text" id="dgr" name="txt_fulladd_src" value="<?php echo addslashes(t('Where ?'))?>" size="35" onclick="if(this.value=='<?php echo addslashes(t('Where ?'))?>')
 document.getElementById('dgr').value ='';" onblur="if(this.value=='') document.getElementById('dgr')
.value ='<?php echo addslashes(t('Where ?'))?>';" />
         </div> 
          <input class="button" type="submit" value="<?php echo addslashes(t('Search'))?>" />
	
     </div>
       </form>
      </div>
      <!--2nd tab-->
      <!--3rd tab-->
      <div class="tsb_text" id="pictures" style="display:none;">
        <div class="tab01 tab03">
        <h2><?php echo addslashes(t('Benefits for users'))?></h2>
        <div class="left_part"><h3><?php echo addslashes(t('Benefits for tradesman'))?></h3>
        <div class=" spacer"></div>
        <p><?php echo addslashes(t('Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for lorem ipsum will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)'))?>.</p></div>
         <div class="left_part"><h4><?php echo addslashes(t('Reating profile is for free'))?> </h4>

 <ul>
 <li><?php echo addslashes(t('No listing fees'))?></li>
 <li><?php echo addslashes(t('No membership fees for users'))?></li>
 <li><?php echo addslashes(t('Low comissions for tradesmen'))?></li>
 <li><?php echo addslashes(t('Membership not a'))?> "<strong><?php echo addslashes(t('must'))?></strong>"  </li>
 <li><?php echo addslashes(t('Open quotes to see actual bids'))?> </li>
 </ul></div>
        
 <?php if(empty($loggedin)) { ?>
  <input class="button" type="button" value="<?php echo addslashes(t('Join us'))?> " onclick="show_dialog('photo_zoom')" />
  <?php } ?>
 
        </div>
      </div>
      <!--3rd tab-->
    </div>
    <div class="join_us">
      <input class="join_us_button" type="button" value=""   onclick="show_dialog('photo_zoom')"/>
      <div class="spacer"></div>
      <div class="icon"> <a href="https://twitter.com/#!/hizmet_uzmani" target="_blank"><img src="images/fe/tw.png" alt="" onmouseover="this.src='images/fe/tw-hover.png'" onmouseout="this.src='images/fe/tw.png'" /></a> <a href="https://www.facebook.com/hizmetuzmani" target="_blank"><img src="images/fe/facebook.png" alt="" onmouseover="this.src='images/fe/facebook-hover.png'" onmouseout="this.src='images/fe/facebook.png'" /></a> <a href="<?php echo base_url().'feeds'?>" target="_blank"><img src="images/fe/rss.png" alt="" onmouseover="this.src='images/fe/rss-hover.png'" onmouseout="this.src='images/fe/rss.png'" /></a> </div>
    </div>
  </div>
  </div>
  
  <!--bar-->
  <div class="bar">
    <ul>
      <li class="margin02"><span>1.</span><?php echo addslashes(t('Post a Job'))?></li>
      <li><span>2.</span><?php echo addslashes(t('Get Quotes'))?></li>
      <li class="margin03"><span>3.</span><?php echo addslashes(t('Hire a Tradesman'))?></li>
      <li class="marginright"><span>4.</span><?php echo addslashes(t('Leave FeedBack'))?></li>
    </ul>
  </div>
 
  <!--bar-->