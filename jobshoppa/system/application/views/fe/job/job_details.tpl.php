<script type="text/javascript"
	src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>

<script type="text/javascript">
  var map;
  function initialize() {
  	 var myLatlng = new google.maps.LatLng(<?php echo $job_details['s_latitude'];?>, <?php echo $job_details['s_longitude'];?>)
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
        title:"<?php echo $job_details['s_title'];?>"
    }); 		
  }

  google.maps.event.addDomListener(window, 'load', initialize);

function send_msg(param)
{
	//alert(param);
	$("#frm_msg_tra input[name=opd_job]").val(param)
	//$('#frm_msg_tra:input').val(param);
	$('#frm_msg_tra').submit();
}
</script>
<script>
jQuery(document).ready(function() {
		$(".lightbox1_main").fancybox({
			'titlePosition'		: 'inside',
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'showCloseButton'	: true
		});
		//console.log($(".lightbox1_main"));
});
</script>

<div id="banner_section">
    <?php
	include_once(APPPATH."views/fe/common/header_top.tpl.php");
	?>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
    <?php
	include_once(APPPATH."views/fe/common/common_search.tpl.php");
	?>
<!-- /SERVICES SECTION -->
<!-- CONTENT SECTION -->
<div id="content_section">
<div id="content">
    <?php
	//include_once(APPPATH."views/fe/common/message.tpl.php");
	?>
     <div id="div_err">
             <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>   
                     <?php
					// pr($job_details);
                        //show_msg("error");  
                        echo validation_errors();
                        //pr($posted);
                    ?>
             </div>
        	<div id="inner_container02">
            <div id="right_section">
                <div class="title">
                    <h3><span>Job </span> Details</h3>
                </div>
                <div class="job_details">
				<h6>&nbsp;</h6>
                    <div class="top">&nbsp;</div>
                    <div class="mid">
                        <div class="job_box">
                            <p class="blue_txt18"><?php echo $job_details['s_title'];?></p>
                            <p class="grey_txt12">Posted on: <?php echo $job_details['dt_entry_date'];?></p>
                            <p>&nbsp;</p>
                            <p><span class="blue_txt">Category:</span> <?php echo $job_details['s_category'];?>    &nbsp;&nbsp;|&nbsp;&nbsp; <span class="blue_txt">Status:</span> <?php echo $job_details['s_is_active'];?>    &nbsp;&nbsp;|&nbsp;&nbsp; <span class="blue_txt">Project Creator:</span> <a href="<?php echo base_url().'user/buyer_profile/'.encrypt($job_details['i_buyer_user_id'])?>" class="lightbox1_main"><strong><?php echo $job_details['s_buyer_name'];?></strong></a> &nbsp;&nbsp;|&nbsp;&nbsp; <span class="blue_txt">Approved By Admin:</span> <?php echo $job_details['dt_front_approval_date'];?> </p>
                            <p><span class="blue_txt">Bidding Ends:</span> <?php echo $job_details['dt_expire_date'];?>(<?php echo $job_details['s_days_left'];?> left)    &nbsp;&nbsp;|&nbsp;&nbsp; <span class="blue_txt">Budget:</span> <?php echo $job_details['d_budget_price'];?> (VAT  included)</p>
                            <p>&nbsp;</p>
                            <p><?php echo $job_details['s_description'];?></p>
                            <p>&nbsp;</p>
                            <!--<p><span class="blue_txt">Professional(s) interested in this job:</span> 7 &nbsp;&nbsp;|&nbsp;&nbsp; <span class="blue_txt">Quote(s) placed in this job:</span> 5</p>-->
                            <p><span class="blue_txt">Professional will provide material :</span> <?php echo $job_details['s_supply_material'];?> &nbsp;&nbsp;|&nbsp;&nbsp; <span class="blue_txt">Tags: </span> <?php echo $job_details['s_keyword'];?></p>
                            <p>&nbsp;</p>
							<p><span class="blue_txt">Work needs to be done by :</span>
							<?php if($job_details['i_available_option']==1) 
							{ 
							if($job_details['s_available_time']==1)
							 echo 'Next few days';
							else if($job_details['s_available_time']==2) 
							 echo 'Next few weeks';
							else echo 'Any time';
							} else {
							if($job_details['i_available_option']==2) 
							echo $job_details['s_available_time'];
							} ?></p>
							<p>&nbsp;</p>
							
                            <p><span class="blue_txt left" style="width:90px;">Attached File:</span> 
							<span class="left"> 
							  <?php
							  if($job_details['job_files'])
							  {
							  	$i=1;
									foreach($job_details['job_files'] as $val)
									{ 
							  ?>
								
								File <?php echo $i++;?>  &nbsp;&nbsp; <a href="<?php echo base_url().'job/download_job_files/'.encrypt($val['s_file_name']);?>" class="orng_link">Download</a><br />
                                 
							<?php
									}							
							}	
							else 
								echo 'No attachment available.';
							  ?>	
							</span>
							
								</p>
                            <div class="clr"></div>
                            <p>&nbsp;</p>
                            <div class="bottom">
                               <?php 
								if(decrypt($loggedin['user_type_id'])==2 && $job_details['i_is_active']!=6)
								{
								?>
								<div class="link_box08">
								<?php
								if(!empty($loggedin))
								{
									if($subscribe_flag)
									{
								?>								
									<a href="<?php echo base_url().'user/subscription/'?>">
								<?php } else {?>
								<a href="<?php echo base_url().'job/watch_list/'.encrypt($job_details['id'])?>" class="lightbox1_main">
								<?php } ?>	
								<?php } else { ?>
									<a href="<?php echo base_url().'user/login'?>">
								<?php } ?>	
								Add to Watch List</a>
								</div>
								
								<?php }														
								if($job_details['i_is_active']!=6) { 
									if(decrypt($loggedin['user_type_id'])==2)
									{
								?>
                                <div class="link_box09">
								<?php
								if($subscribe_flag)
								{
								?>
								<a href="<?php echo base_url().'user/subscription/'?>">
								<?php } else {?>
								<a href="<?php echo base_url().'private_message/private_msg_land/'.encrypt($job_details['id'])?>">
								<?php } ?>
								Personal Message Board
								</a>
								</div>
								<?php } } 
								if(decrypt($loggedin['user_type_id'])==2 && $job_details['i_is_active']==1)
								{
								?>
                                <div class="link_box10">
								<?php
								if($subscribe_flag)
								{
								?>
								<a href="<?php echo base_url().'user/subscription/'?>">
								<?php } else {?>
								<a href="<?php echo base_url().'job/quote_job/'.encrypt($job_details['id']);?>" class="lightbox1_main">
								<?php } ?>
								Place Quote
								</a>
								</div>
								<?php } ?>
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="bot">&nbsp;</div>
                </div>
                <div class="clr"></div>
                <div class="job_details">
                    <h6>Job location : <?php echo $job_details['s_state'];?>, <?php echo $job_details['s_city'];?></h6>
                    <div class="top">&nbsp;</div>
                    <div class="mid"  >
                        <div id="map" style="width:975px; height:200px;">
                        </div>
                    </div>
                    <div class="bot">&nbsp;</div>
                </div>
                <div class="clr"></div>
                <div class="job_details">
                    <h6>Interests and Quotes</h6>
                    <div class="top">&nbsp;</div>
                    <div class="mid" >
                        <p>Professional(s) interested in this job:<span class="blue_txt"><strong> <?php echo $job_details['i_interested'];?></strong></span></p>
                        <p>Quote(s) placed in this job:<span class="blue_txt"><strong> <?php echo $job_details['i_quotes'];?></strong></span></p>
                    </div>
                    <div class="bot">&nbsp;</div>
                </div>
                <div class="clr"></div>
            </div>
        </div>
		
		
		
        <div class="clr"></div>
</div>
</div>
