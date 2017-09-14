 <?php include_once(APPPATH."views/fe/common/banner.tpl.php"); ?>  
 <!--body-->
  <div class="body_part02">
    <div class="box01">
      <h2><?php echo addslashes(t('Have a job to be done'))?>?</h2>
      <ul>
        <li><?php echo addslashes(t('Leave the hard work to us'))?></li>
        <li><?php echo addslashes(t('Receive multiple quotes into your inbox'))?>.</li>
        <li><?php echo addslashes(t('Its Completely free'))?></li>
        <li><?php echo addslashes(t('Review Feedback and Ratings'))?></li>
        <li><?php echo addslashes(t('Choose the Pro that suits you'))?></li>
      </ul>
	  <?php if(decrypt($loggedin['user_type_id'])!=2) { ?>
      <input class="button02 marginleft"  type="button" value="<?php echo addslashes(t('Post your job for FREE'))?>" onclick="window.location.href='<?php echo base_url().'job/job-post/' ?>'" />
	  <?php } ?>
    </div>
    <div class="box01">
      <h2 class="org_text"><?php echo addslashes(t('Are you a Tradesman'))?>?</h2>
      <ul>
        <li><?php echo addslashes(t('Create your profile'))?></li>
        <li><?php echo addslashes(t('Receive job offers from clients'))?></li>
        <li><?php echo addslashes(t('Grow your business'))?></li>
        <li><?php echo addslashes(t('Make more money'))?>!!</li>
      </ul>
	  <?php if(decrypt($loggedin['user_type_id'])!=1) { ?>
      <input class="button marginleft"  type="button" value="<?php echo addslashes(t('Create your profile NOW'))?>"  onclick="window.location.href='<?php echo base_url().'user/registration/TWlOaFkzVT0=' ?>'" />
	  <?php } ?>
    </div>
    <div class="box03"><img src="images/fe/add.png" alt="" /></div>
    <div class="spacer"></div>
  </div>
  <!--body-->
     
<?php include_once(APPPATH."views/fe/common/home_job_category.tpl.php"); ?>

<div class="body_part03">
    <div class="left_part">
      <!--featured_tradesmen-->
      <div class="featured_tradesmen">
        <h3><?php echo addslashes(t('Featured Tradesmen'))?></h3>
        <div class="small_box_top"></div>
        <div class="small_box_midd">
          <ul>
		  <?php if(count($tradesman_list)>0) {
		  		foreach($tradesman_list as $val)
					{
					$img = (!empty($val["s_image"])&&file_exists($image_up_path."thumb_".trim($val["s_image"])))?" <img src='".$image_path."thumb_".$val["s_image"]."' width='78' height='69'  />":" <img src='images/fe/man.png' width='78' height='69'/>";
		   ?>
            <li class="tradesmen">
              <div class="left_box"><a href="<?php echo base_url().'tradesman-profile/'.encrypt($val['id']) ?>"><?php echo $img ?></a></div>
              <div class="right_box">
                <h5><a href="<?php echo base_url().'tradesman-profile/'.encrypt($val['id']) ?>"><?php echo $val['s_username'] ?></a>-</h5>
                <div class="star"><?php echo show_star($val['i_feedback_rating']) ?></div>
                <h6><?php echo addslashes(t('Main Skills'))?> &amp; <?php echo addslashes(t('Trades'))?>: </h6>
                <?php if(!empty($val['category'])) { 
				$cnt =1;
				foreach($val['category'] as $v)
				{  
					if($cnt<3)
					{
			   ?>
			   <p><?php echo $v['s_category_name'] ?></p>
			   <?php $cnt++;} } } ?>
              </div>
            </li>
           <?php } } else { ?>
		   <li class="tradesmen">
		   <p><?php echo addslashes(t('No item found')) ?>. </p>
		   </li>
		   <?php } ?>
          </ul>
          <div class="spacer"></div>
        </div>
        <div class="small_box_bottom"></div>
        
      </div>
      <!--featured_tradesmen-->
      <!--Jobs New Added-->
      <div class="featured_tradesmen marginleft">
        <h3 class="blue_text"><?php echo addslashes(t('Jobs New Added'))?></h3>
        <div class="small_box_top"></div>
        <div class="small_box_midd">
          <ul>
		  <?php if($new_jobs) {
		  		foreach($new_jobs as $val)
					{
                        $make_url   =   make_my_url($val['s_category_name']).'/'.encrypt($val['i_category_id']) ;
                        $job_url    =   make_my_url($val['s_title']).'/'.encrypt($val['id']) ; 
                           
					$img = (!empty($val['s_icon']))?$icon_path.$val['s_icon']:"images/fe/icon03.png";
		   ?>
            <li class="job_add">
              <h4><a href="<?php echo base_url().'job-details/'.$job_url; ?>" target="_blank"><?php echo string_part($val['s_title'],38) ?></a></h4>
             
              <p><img src="<?php echo $img ?>" alt="" height="39" width="63" /><?php echo string_part($val['s_description'],90) ?></p>
              <div class="spacer"></div>
              <h5><a href="<?php echo base_url().'job/find-job/'.$make_url; ?>"><?php echo $val['s_category_name'] ?></a> </h5>
              <h6> <?php echo addslashes(t('Posted on'))?>:<span> <?php echo time_ago($val['i_entry_date']); ?></span></h6>
            </li>
           <?php } } else { ?>
            <li class="job_add">
			<p><?php echo addslashes(t('No item found'))?>.</p>
			</li>
			<?php } ?>
          </ul>
        </div>
        <div class="small_box_bottom"></div>
        <div class="more"><a href="<?php echo base_url().'job/find-job/'; ?>"><?php echo addslashes(t('More'))?> &gt;&gt;</a></div>
      </div>
      <!--Jobs New Added-->
      <div class="spacer"></div>
      <div class="midd_box">
        <div class="midd_top"></div>
        <div class="midd_bg">
          <h2><?php echo addslashes(t('Just searched on hizmetuzmani'))?></h2>
        
		  <!-- tag cloud search -->
		  <div id="tag_cloud">
		  
		  </div>
		  <form name="srch_by_key" id="srch_by_key" action="<?php echo base_url().'job/find-job/';?>" method="post">
		  <input type="hidden" id="h_keyword" name="h_keyword" value="" />
		  </form>
		  <!-- tag cloud search -->
		  
          <div class="spacer"></div>
        </div>
        <div class="midd_bottom"></div>
      </div>
      <div class="midd_box">
        <div class="midd_top"></div>
        <div class="midd_bg">
		<?php if($what_we_do) { 
		foreach($what_we_do as $val) {  
		?>
          <h2><?php echo $val['s_title'] ?></h2>
          <?php echo $val['s_desc_full'] ?>
		  <?php } } ?>
          <div class="spacer"></div>
		  
        </div>
        <div class="midd_bottom"></div>
      </div>
    </div>
    <div class="right_part">
      <div class="featured_tradesmen">
        <h3 class="gry_text"><?php echo addslashes(t('News'))?></h3>
        
        <div class="spacer"></div>
        <div class="small_box_top margintop"></div>
        <div class="small_box_midd">
          <div class="newsticker">
            <ul>
				<?php if($news_list) {
					foreach($news_list as $val)
						{
				 ?>
              <li class="body_left_03_inner">
                <h2><a href="<?php echo base_url().'news/'.encrypt($val['id']) ?>"><?php echo string_part($val['s_title'],32) ?></a> <span>- <em><?php echo $val['fn_created_on'] ?></em></span></h2>
                <p><?php echo string_part($val['s_description'],45) ?></p>
              </li>
             	<?php } } ?>
            </ul>
          </div>
        </div>
        <div class="small_box_bottom"></div>
      </div>
      <div class="spacer"></div>
	  
      <div class="featured_tradesmen">
        <h3 class="blue_text"><?php echo addslashes(t('Client Testimonials'))?></h3>
        <div class="small_box_top"></div>
        <div class="small_box_midd">
          <div class="testimonial">
            <ul>
				<?php if($testimonial_list) {
					foreach($testimonial_list as $val)
						{
				 ?>
              <li class="body_left_03_inner02"> <img src="images/fe/dot1.png" alt="" class="left" />
                <p> <a href="<?php echo base_url().'testimonial-details/'.encrypt($val['id']) ?>" class="grey_link"><?php echo string_part($val['s_large_content'],150) ?></a></p>
                <h2>- <?php echo $val['s_person_name']?><br />
                  <span><?php echo $val['fn_entry_date']?></span></h2>
              </li>
              <?php } } ?>
            </ul>
          </div>
        </div>
        <div class="small_box_bottom"></div>
      </div>
      <div class="spacer"></div>
      <!--<div class="facebook"><img src="images/fe/facebook-link.png" alt="" /> </div>-->
	  <!-- FACEBOOK LIKE BOX -->
	 
	  <div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=102053853267823";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
	</script>
	  <div class="facebook">
	  <div class="fb-like-box" data-href="<?php echo $this->s_facebook_link ?>" data-width="320" data-height="294" data-show-faces="true" data-stream="false" data-header="true"></div>
	   </div>
	  <!-- FACEBOOK LIKE BOX -->
    </div>
    <div class="spacer"></div>
  </div>
  
 <script type="text/javascript">
 $(document).ready(function(){
 //Tag Cloud
		$(function() {
					//get tag feed
					$.getJSON("<?php echo base_url()?>home/tag_cloud?callback=?", function(data) {
					
						//create list for tag links
						$("<ul>").attr("id", "cloud").appendTo("#tag_cloud");
						
						//create tags
						$.each(data.tags, function(i, val) {
							
							//create item
							var li = $("<li>");
							
							//create link
							
								$("<a>")
								.text(val.tag)
								.attr({title:"<?php echo addslashes(t('See all jobs keyword with'))?> " + val.tag, 
								href:"javascript:void(0)"
								}).bind('click', function(){
							search_job_by_tag_cloud(val.tag);
						}).appendTo(li);
							
							//set tag size
							li.children().css("fontSize", (val.freq / 10 < 1) ? val.freq / 10 + 1 + "em": (val.freq / 10 > 2) ? "2em" : val.freq / 10 + "em");
							
							//add to list
							li.appendTo("#cloud");
							
						});
					});
				});
		
		function search_job_by_tag_cloud(tag)
		{
			$("#h_keyword").val(tag);
			$('#srch_by_key').submit();
		}
		
		
});
 </script> 
 <style>
 #cloud li {float:left !important; height:25px; font-family:Tahoma;}
 </style>