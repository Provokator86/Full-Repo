<script type="text/javascript"
	src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>

<script type="text/javascript">
  var map;
  function initialize() {
  	 var myLatlng = new google.maps.LatLng(<?php echo $job_details['s_buyer_latitide'];?>, <?php echo $job_details['s_buyer_longitude'];?>)
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

<div id="div_container">
      <div class="body_bg">
            <div class="banner">
                    <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>
            </div>
			<?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
            <div class="body_left rightSidebar" >
                  <h1><?php echo get_title_string(t('Location'))?></h1>
                  <div class="shadow_small">
                        <div class="left_box">
                              <div id="map">
                              </div>
                        </div>
                  </div>
                  <h1><?php echo get_title_string(t('Other Job'))?></h1>
                  <div class="shadow_small">
                        <div class="left_box others_job">
						<?php
						if($other_jobs)
						{
							foreach($other_jobs as $val)
							{
								$s_title = (strlen($val['s_title']) > 10) ? substr($val['s_title'],0,15) : $val['s_title'];
								
						?>
                              <p><a class="blue_link" href="<?php echo base_url().'job/job_details/'.encrypt($val['id'])?>"><?php echo $s_title.'...'?></a><?php echo $val['s_city']?></p>
						<?php
							}
						}
						else echo t('<p>No Record Found</p>');
						?>	  
                        </div>
                  </div>
            </div>
<div class="body_right">
	  <h1><?php echo get_title_string(t('Job Details'))?> </h1>
	  <h4><span><?php echo $job_details['s_title'];?> </span></h4>
	  
	  <div class="shadow_big" style="position:relative;"> <div id="status_div"><?php echo t('Status')?> <span><?php echo $job_details['s_is_active'];?> </span></div>
			<div class="right_box_all_inner" style="padding-top:0px;">
				 <?php /*?> <div class="heading01"><?php echo t('Status')?> </div>
				  <div class="heading_detail01" style="font-weight:bold; color:red;"> <?php echo $job_details['s_is_active'];?> </div>
				  <div class="spacer"></div><?php */?>
				  <div class="heading01"><?php echo t('Approved By Admin')?> </div>
				  <div class="heading_detail01"> <?php echo $job_details['dt_front_approval_date'];?> </div>
				  <div class="spacer"></div>
				  <?php if($job_details['i_is_active']==1) { ?>
				  <div class="heading01"><?php echo t('Bidding Ends')?>  </div>
				  <div class="heading_detail01"> <?php echo $job_details['dt_front_expire_date'];?> (<?php echo $job_details['s_days_left'];?> <?php echo t('left')?>) </div>
				  <div class="spacer"></div>
				  <?php } ?>
				  <div class="heading01"><?php echo t('Job Creator')?>  </div>
				  <div class="heading_detail01"> <a style="font-size:14px;" class="blue_link lightbox_main" href="#job_creator_div"><strong><?php echo $job_details['s_buyer_name'];?></strong> </a></div>
				  <div style="display: none;">
					   <div id="job_creator_div" class="lightbox">
							  <h1><?php echo t('Job Creator')?></h1>
							  <div class="heading01"> <?php echo t('Buyer')?>  </div>
							  <div class="heading_detail01" style="width:300px;">
									<div class="photo" style="margin-bottom:10px;">
									<?php
									$filename = $user_url_path.'thumb_'.$user_details['image'][0]['s_user_image'];
									if(file_exists($user_path.'thumb_'.$user_details['image'][0]['s_user_image']))
									{
									?>
										<img src="<?php echo $filename?>" alt="" width="65" height="65" />
									<?php } else { ?>
										<img src="images/fe/img.png" alt="" />
									<?php }?>	
									</div>
									<div class="spacer"></div>
									<span class="blue_txt"><strong><?php echo $user_details['s_name']?></strong> </span> </div>
							  <div class="spacer"></div>
							  <div class="heading01"> <?php echo t('Member since')?> </div>
							  <div class="heading_detail01" style="width:300px;"> 
							  <?php echo $user_details['dt_created_on']?></div>
							  <div class="spacer"></div>
							  <div class="heading01">  <?php echo t('Total job(s) posted')?> </div>
							  <div class="heading_detail01" style="width:300px;"> 
							  <?php echo $user_details['i_job_post']?></div>
							  <div class="spacer"></div>
				
							  <div class="heading01">  <?php echo t('Total job(s) awarded')?> </div>
							  <div class="heading_detail01" style="width:300px;"> 
							  <?php echo $i_total_awarded_job?></div>
							  <div class="spacer"></div>
							 
						</div>
				  </div>
				  <div class="spacer"></div>
				  <div class="heading01"> <?php echo t('Budget')?> </div>
				  <div class="heading_detail01"> <?php if($job_details['s_budget_price']!=0) echo $job_details['s_budget_price']; else echo t('None');?> <em> <span style="color:#b8b8b8"></span> </em></div>
				  <div class="spacer"></div>
				  <div class="heading01"> <?php echo t('Description')?> </div>
				  <div class="heading_detail01" style="width:500px;"> <?php echo strip_tags($job_details['s_description']);?> </div>
				  <div class="spacer"></div>
				  <div class="heading01"> <?php echo t('Buyer will provide material')?>  </div>
				  <div class="heading_detail01">  <?php echo $job_details['s_supply_material'];?> </div>
				  <div class="spacer"></div>
				  <div class="heading01"> <?php echo t('Tags')?>  </div>
				  <div class="heading_detail01"> <?php echo ($job_details['s_keyword'])?$job_details['s_keyword']:'-' ;?> </div>
				  <div class="spacer"></div>
				  <div class="heading01"> <?php echo t('Quotes')?>   </div>
				  <div class="heading_detail01"><?php echo $job_details['i_quotes'];?> </div>
				  <div class="spacer"></div>
		
				  <?php
				  if($job_details['job_files'])
				  {
					$i=1;
				  ?>
				  <div class="heading01"> <?php echo t('Attached File')?> </div>
				  <div class="heading_detail01">
				  <?php foreach($job_details['job_files'] as $val){ ?>
						<div style="width:100px;" class="left"><?php echo 'File '.$i++;?> </div>
						<a href="<?php echo base_url().'job/download_job_files/'.encrypt($val['s_file_name']).'/'.encrypt($job_details['id']);?>" class="grey_link_line"><?php echo t('Download')?></a> <br />
				  <?php }?>
				  </div>							  	
				  <?php 
				  }
				  ?>	
						
				  <div class="spacer"></div>
				  <div class="heading01"><?php echo t('Job Location')?> </div>
				  <div class="heading_detail01"><?php echo $job_details['s_state'];?>,  <?php echo $job_details['s_city'];?>, <?php echo $job_details['s_postal_code'];?> </div>
				  <div class="spacer"></div>
				  <br />
				  <?php if($job_details['i_is_active']!=6) { ?>
				  <input name="" type="button" class="button3" value="<?php echo t('Private Messages Board')?>"  href="javascript:void(0);" onclick="window.location.href='<?php echo base_url().'private_message/private_msg_land/'.encrypt($job_details['id'])?>'"  style="font-size:13px;"/>
				  &nbsp;
				 	<?php } ?>
				  <?php
				   if(decrypt($loggedin['user_type_id'])!=1)
				  {
				  if($job_details['i_is_active']==1)
				  {
				  ?>
				  <input name="" type="button" class="pink_button06" value="<?php echo t('Quote Now')?>"  onclick="window.location.href='<?php echo base_url().'job/quote_job/'.encrypt($job_details['id'])?>'" />
				  <?php							  
				  }
				  }
				  ?>
			</div>
	  </div>
</div>
            <div class="spacer"></div>
      </div>
</div>