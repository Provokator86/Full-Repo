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
function send_msg(param)
{
	$('#opd_job').val(param);
	$('#frm_msg').submit();
}
</script>
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
<div id="banner_section">
    <?php
	include(APPPATH."views/fe/common/header_top.tpl.php");
	?>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
    <?php
	include_once(APPPATH.'views/fe/common/common_buyer_search.tpl.php');
	?>
<!-- /SERVICES SECTION -->
<!-- CONTENT SECTION -->
<div id="content_section">
<div id="content">
     <div id="div_err">
             <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>   
                     <?php
                        //show_msg("error");  
                        echo validation_errors();
                        //pr($posted);
                    ?>
             </div>
        <div id="inner_container02">
             <div class="title">
                <h3><span>Job </span>Details </h3>
            </div>
            <div class="clr"></div>
          
            <div class="clr"></div>
            <div id="account_container">
                <div class="account_left_panel">
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid" style="min-height:878px;">
                            <!--<div class="heading_box">Job Overview</div>-->
                            <div class="job_box">
                                <div class="left" style="width:430px">
                                    <p class="blue_txt18"><?php echo $job_details['s_title']?></p>
                                    <p class="grey_txt12">Posted on : <?php echo $job_details['dt_entry_date']?></p>
                                    <p>&nbsp;</p>
                                    <p><span class="blue_txt">Location:</span> <?php echo $job_details['s_state']?>, <?php echo $job_details['s_city']?>,  <?php echo $job_details['s_postal_code']?></p>
                                	<p><span class="blue_txt">Time left:</span> <?php echo $job_details['s_days_left']?>    &nbsp;&nbsp;|&nbsp;&nbsp; <span class="blue_txt">Budget:</span> £<?php echo $job_details['d_budget_price']?> </p>
                                	<p><span class="blue_txt">Interested:</span> <?php echo $job_details['i_interested']?>    &nbsp;&nbsp;|&nbsp;&nbsp; <span class="blue_txt">Quotes:</span> <?php echo $job_details['i_quotes']?> </p>
                                    <p><?php echo $job_details['s_description']?></p>
                                    <p></p>
                                </div>
                                <div class="right">
								
								<div id="map" style="width:250px; height:250px;">
                        		</div> 
								
								</div>
                            </div>
                            <div class="title">
                                <h5><span>View </span> Quotes</h5>
                            </div>
                            <div class="heading_box">Total No. of quotes placed: <?php echo $job_details['i_quotes']?> </div>
							<?php
							if($job_quote_details)
							{
								//pr($job_quote_details);
								foreach($job_quote_details as $val)
								{
							?>
							
                            <div class="job_box">
                                <div class="left_content_box">
                                    <p class="grey_txt12">Quoted on: <?php echo $val['dt_entry_date']?></p>
                                    <p><span class="blue_txt">Quoted Price :</span> £ <?php echo $val['d_quote']?></p>
                                    <p><span class="blue_txt">Professional Name  :</span> <?php echo $val['s_username']?></p>
                                    <p><span class="blue_txt">City  :</span> <?php echo $val['s_city']?></p>
                                    <p>&nbsp;</p>
                                    <p>
									<?php echo show_star($val['i_feedback_rating'])?>
									<!--<img src="images/fe/star-mark01.png" alt="" width="105" height="20" />--></p>
                                    <p class="grey_txt12">Rating - <?php echo $val['f_positive_feedback_percentage']?>% Positive</p>
                                </div>
                                <div class="right_content_box">
                                    <div class="top_c">&nbsp;</div>
                                    <div class="mid_c">
                                        <ul>
											<?php
												if($job_details['i_tradesman_id'] == $val['i_tradesman_id'])
													echo '<li><img src="images/fe/icon-49.png" alt="" /> Assigned</li>';
												else
												if($job_details['i_is_active']==8 && $job_details['i_tradesman_id'])	
													echo '';
												elseif(empty($job_details['i_tradesman_id']) && $job_details['i_is_active']==1)
												{	
												?>
                                            <li><a href="<?php echo base_url().'buyer/confirm_job_assign/'.encrypt($val['i_tradesman_id']).'/'.encrypt($job_details['id']).'/'.encrypt($val['id'])?>" class="lightbox1_main"><img src="images/fe/icon-49.png" alt="" /> Accept Quote</a></li>
												<?php } ?>
											<li>											
											<a href="<?php echo base_url().'tradesman_profile/'.encrypt($val['i_tradesman_id'])?>" target="_blank"><img src="images/fe/icon-36.png" alt=""   style="margin:5px 5px 0px 5px;" /> Professional Profile</a>
											</li>
                                            <li class="last">
											<a href="<?php
													echo base_url().'private_message/private_msg_land_buyer/'.encrypt($job_details['id']).'/'.encrypt($val['i_tradesman_id'])
												?>" ><img src="images/fe/icon-43.png" alt="" /> PMB</a></li>
                                        </ul>
                                    </div>
                                    <div class="bot_c">&nbsp;</div>
                                </div>
                            </div>
							<?php
								}
							} else 
								echo '<div class="job_box">No quote posted</div>';
							?>							
                            <div class="clr"></div>
                            <div class="paging_box">
                                <?php echo $pagination;?>
                            </div>
                            <div class="clr"></div>
                        </div>
                        <div class="bot">&nbsp;</div>
                    </div>
                </div>
                <?php include_once(APPPATH.'views/fe/common/buyer_left_menu.tpl.php'); ?>
				
            </div>
            <div class="clr"></div>
        </div>
		
		
        <div class="clr"></div>
</div>
</div>
