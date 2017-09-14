<script type="text/javascript"
	src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>

<script type="text/javascript">
  var map;
  function initialize() {
  	 var myLatlng = new google.maps.LatLng('<?php echo $job_details['s_job_lattitude'];?>', '<?php echo $job_details['s_job_longitude'];?>')
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

	
	/**
    * This function use to show fetch buyer profile details.
    */
    function show_buyer_profile(buyer_id)
    {
         $.ajax({
                        type: "POST",
                        async: false,
                        url: base_url+'job/ajax_fetch_buyer_profile',
                        data: "buyer_id="+buyer_id,
                        success: function(msg){
                            if(msg!='error')
                            {
                                $("#buyer_profile").html($.trim(msg));
                                show_dialog('photo_zoom09');   
                            }
                        }
         });
    }
</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
<div class="top_part"></div>
	<div class="midd_part height02">
			<?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
			
		  <div class="spacer"></div>		  
		  <div class="spacer"></div>
		  <?php //pr($job_details,1); ?>
		  <div class="hedline"><?php echo $job_details['s_title']?> <span><?php echo $job_details['s_city'] ?> </span> </div>
		  <div class="week"><?php echo ($job_details['i_is_active']!=6)?$job_details['s_days_left']:"0 day ";?> <?php echo addslashes(t('left'))?></div>
		  <div class="left_part02"><div class="details_about_job">
		  <h3><?php echo addslashes(t('Details about job'))?></h3>
		  <ul>
		  <li><em><?php echo addslashes(t('Location'))?> </em><span><?php echo $job_details['s_province'] ?></span></li>
		  <li><em><?php echo addslashes(t('Job create date'))?></em> <span><?php echo $job_details['dt_front_entry_date'] ?></span>	</li>
		  <li><em><?php echo addslashes(t('Job listing duration'))?></em><span><?php echo time_ago($job_details['i_approval_date']) ?></span></li>
		  <li><em><?php echo addslashes(t('Current status of job'))?></em><span><strong><?php echo $job_details['s_is_active'];?></strong></span></li>
		  </ul>		  
		  <ul>
		  <li><em><?php echo addslashes(t('Expected budget'))?> </em>
		  <span><?php echo $job_details['s_budget_price'];?> </span></li>
		 <!-- <li><em>Expected complete time</em> <span>3 days</span></li>
		  <li><em>Payment</em><span>End of work </span></li>
		  <li><em>Payment method</em><span>cash</span></li>-->
		  </ul>
		  
		 <?php if(!empty($job_details['job_files'])) { ?>
		  <ul>
		  <li><em><?php echo addslashes(t('Job Files'))?> </em>
		   <?php //if(!empty($job_details['job_files'])) {
		  	$cnt = 1;
			foreach($job_details['job_files'] as $val)
				{
		   ?>
		  <span style="margin-right:8px;"> <a href="<?php echo base_url().'job/download_job_files/'.encrypt($val['s_file_name']); ?>"><?php echo $cnt.'. '.$val['s_file_name'] ?></a></span>
		  <?php $cnt++;}  ?>
		  
		  </li>
		  </ul>
		  <?php } ?>
		  
		  <input class="button flote05" type="button" onclick="show_dialog('photo_zoom06');" value="<?php echo addslashes(t('Get contact info'))?>" />
          <?php if(decrypt($loggedin['user_type_id'])==1) 
          {
          ?>
         
		  <a href=<?php echo base_url().'buyer/pmb_landing/'.encrypt($job_id) ; ?>><input class="small_button02" type="button" value="<?php echo addslashes(t('Ask question'))?>" /></a>
		  
          <?php 
          }
          else
          {
          ?>
          <a href=<?php echo base_url().'tradesman/pmb_landing/'.encrypt($job_id) ; ?>><input class="small_button02" type="button" value="<?php echo addslashes(t('Ask question'))?>" /></a>
          <?php    
          }
          ?>
          <div class="spacer"></div>  
		  <div class="margin10"></div>
		  <div class="verified"><!--<img src="images/fe/Verified.png" alt="" />--></div>
		  <ul>
		  <li><em><?php echo addslashes(t('Job poster'))?> </em>
		  <span><strong>
		  <a href="javascript:void(0);" onclick="show_buyer_profile('<?php echo encrypt($job_details['i_buyer_user_id']) ;?>');"><?php echo $job_details['s_buyer_name'] ?></a>
		  </strong></span>
		  </li>
		 <!-- <li><em><?php echo addslashes(t('Member status'))?></em> <span>Verified   </span>	</li>
		  <li><em>Raiting</em><span>%99,4  </span></li>
		  <li><em><?php echo addslashes(t('Last access'))?></em><span>Today</span></li>-->
		  </ul>
		  <div class="spacer"></div>
		  
		  <!-- SHOW MAP HERE -->
		  <div class="map" id="map">
		  
		  </div>
		  <!-- END SHOW MAP HERE -->
		  
		  </div><div class="details_about_job">
		  <h3><?php echo addslashes(t('Similar jobs'))?></h3>
		  <?php if(count($similar_jobs)>0) {
		  
		  		foreach($similar_jobs as $value)
					{
                         $job_url    =   make_my_url($value['s_title']).'/'.encrypt($value['id']) ; 
		   ?>
		  <ul>
		  <li><img src="images/fe/arrow04.png" alt="" />
		  <a href="<?php echo base_url().'job-details/'.$job_url; ?>" target="_blank"><?php echo string_part($value['s_title'],50) ?>
		  </a>
		   </li>		  
		  </ul>
		  <?php } } else { ?>
		  <ul>
		  <li><img src="images/fe/arrow04.png" alt="" />
		  <a href="javascript:void(0);"><?php echo addslashes(t('No item found')) ?></a>
		   </li>		  
		  </ul>
		  <?php } ?>
		  </div></div>
		  <div class="right_part02">
		  <div class="job_description05">
		  <div class="job_description">
			<h3><?php echo addslashes(t('Job description'))?></h3>
			<p><?php echo $job_details['s_description'] ?></p>
			<!-- AddThis Button BEGIN addons-->
			<?php /*?><div class="addthis">
			<div class="addthis_toolbox addthis_default_style">
			
			<div class="fb-like" data-href="http://www.acumencs.com/hizmetuzmani/job-details/TkRnallXTjE=" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="arial"></div>
			
			<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
			<a class="addthis_button_tweet"></a>
			<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
			<a class="addthis_counter addthis_pill_style"></a>
			</div>
			<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4fa7696c6e47224f">
			</script>
			</div><?php */?>
			<!-- AddThis Button END addons-->
			
			<!-- AddThis Button BEGIN -->
			<div class="addthis">
			<!-- For facebook like button @ script written in main.tpl.php after body tag-->
			<div style="float:left; width:80px !important;" class="fb-like" data-href="http://www.acumencs.com/hizmetuzmani/job-details/TkRnallXTjE=" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="arial"></div>
			<!-- end For facebook like button-->
			 <!-- For Twietter share button-->
			<div style="float:left;">
		<a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</div>
			
					<!-- End -->
			</div>
			<div class="spacer"></div>
			<!-- AddThis Button END -->
			
			<h3><?php echo addslashes(t('Keywords'))?> </h3>

			<?php
             if($job_details['s_keyword']!='') { 
			$keys = explode(',',$job_details['s_keyword']); 
			$i = 1;
			$cnt = count($keys);
			
			?>
			<ul class="keyword">
			<?php foreach($keys as $val) { ?>
					  <li> <a href="javascript:void(0);"><?php echo $val ?></a></li>
					  <?php if($cnt!=$i) { ?><li>,</li> <?php } ?>
			<?php $i++; } ?>		  
					 
			</ul>
			<?php } ?>
			</div>
		   </div>
		   <?php if($job_details['i_is_active']==1) { ?>
			<input class="big_button" value="<?php echo addslashes(t('Quote on this job'))?>" type="button" onclick="show_dialog('photo_zoom02')" />
			 <?php } ?>
			<div class="spacer"></div>
			<div class="job_description">
			<?php if(count($latest_quotes)>0) {
					foreach($latest_quotes as $value)
						{
						if($val['i_verified'] && ($val['i_ssn_verified'] || $val['i_address_verified'] || $val['i_mobile_verified'] || $val['i_tax_no_verified']))
						{
						$class = "class='blue_text'";
						}
						else
						{
						$class ='';
						}
			 ?>
			<div class="box01">
			<p class="nexttext"><strong><a <?php echo $class ?> href="<?php echo base_url().'tradesman-profile/'.encrypt($value['i_tradesman_id']) ?>"><?php echo $value['s_username'] ?> ( <?php echo $value['i_jobs_won'] ?> )</a></strong> -  <?php echo $value['s_comment'] ?> - <em><?php echo $value['s_quote'] ?></em></p>
			</div>
			<?php } } else { ?>
			<div class="box01">
			<p class="nexttext"><strong><?php echo addslashes(t('No item found'))?></strong><em></em> </p>
			</div>
			<?php } ?>			
			<!--<div class="box01 last_box">
			<p class="nexttext"><strong><a href="tradesman_profile.html">Myspecialist ( 23 ) </a></strong> - i will do this job in 5 days, you will supply painting  - <em>350 TL</em></p>
			</div>-->
			</div>
			
			</div>
			
		  
		  <div class="spacer"></div>
		  
		
		  <div class="spacer"></div>
	</div>
	<div class="spacer"></div>
	<div class="bottom_part"></div>
</div>

<form name="ajax_frm_job_confirm" id="ajax_frm_job_confirm" method="post" action="<?php echo base_url().'job/save_quote_job'?>">
<!--lightbox-->
<div class="lightbox02 photo_zoom02 width04">
<div id="div_err1">
</div>
      <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
      <h3><?php echo addslashes(t('Place Quote'))?></h3>
      <div class="lable04"><?php echo addslashes(t('Your bid'))?> :</div>
      <div class="textfell">
            <input type="hidden" name="h_job_id" id="h_job_id" value="<?php echo $job_details['id']?>" />
            <input name="txt_quote" id="txt_quote" type="text" />
      </div>  <div class="lable03">TL</div>
	  <div class="spacer"></div>
	  <div id="err_txt_quote" class="err" style="margin-left:130px;"><?php echo form_error('txt_quote') ?></div>
      <div class="spacer"></div>
       <div class=" lable04"><?php echo addslashes(t('Message'))?> :</div>
      <div class="textfell06">
          <textarea name="ta_message" id="ta_message"></textarea>
      </div>
	  <div class="spacer"></div>
	  <div id="err_ta_message" class="err" style="margin-left:130px;"><?php echo form_error('ta_message') ?></div>
      <div class="spacer"></div>
      <div class="lable04"></div>
      <input class="small_button" type="button" id="confirm_quote" value="<?php echo addslashes(t('Submit'))?>" />
</div>
<!--lightbox-->
</form>

<!--lightbox buy contact -->
<div class="lightbox04 photo_zoom06">
      <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
<h3><?php echo addslashes(t('Are you sure get the contact info')).'?' ; ?></h3>
<div id="lightbox_msg"></div>
<div class="buttondiv">
<input type="hidden" value="<?php echo encrypt($job_details['i_buyer_user_id']) ; ?>" name="h_buyer_id" id="h_buyer_id"  />
<input type="hidden" value="" name="h_tradesman_id" id="h_tradesman_id" />
<input class="login_button flote02" type="button" value="<?php echo addslashes(t('Yes'))?>" />
<input class="login_button flote02" type="button" value="<?php echo addslashes(t('No'))?>" />
</div>
</div>
<!--lightbox  buy contact -->

<!--Buyer details -->
<div class="lightbox04 photo_zoom09">
      <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
      <h3><?php echo addslashes(t('Buyer details'))?> </h3>
	  <div id="buyer_profile">
      </div>
   
      <div class="spacer"></div>
</div>
<!--Buyer details -->
<script type="text/javascript">
    $(document).ready(function() {
	$("#confirm_quote").click(function() { 
		var b_valid = true;
		var quote_val = /^[0-9]+$/;
		if($.trim($("#txt_quote").val())=="") //// For  name 
		{
			$("#err_txt_quote").text('<?php echo addslashes(t('Please provide your bid'))?>').slideDown('slow');
			b_valid  =  false;
		}
		else if(quote_val.test($.trim($("#txt_quote").val()))==false)
		{
			$("#err_txt_quote").text('<?php echo addslashes(t('Please provide numeric value with no decimal point'))?>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#err_txt_quote").slideUp('slow').text('<?php echo addslashes(t(''))?>');
		}
		if($.trim($("#ta_message").val())=="") //// For  name 
		{
			$("#err_ta_message").text('<?php echo addslashes(t('Please provide message'))?>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#err_ta_message").slideUp('slow').text('<?php echo addslashes(t(''))?>');
		}
		 if(!b_valid)
		{
		   // $.unblockUI();  
			$("#div_err").html(s_err).show("slow");
		}
		
		else
		{
		//$("#ajax_frm_job_confirm").submit();
		var quote 	= $("#txt_quote").val();
		var comment = $("#ta_message").val();
		var job_id = $("#h_job_id").val();
		 		$.ajax({
                        type: "POST",
                        async: false,
                        url: base_url+'job/save_quote_job',
                        data: "txt_quote="+quote+"&ta_message="+comment+"&h_job_id="+job_id,
                        success: function(msg){
                            if(msg)
                            {
								msg = msg.split('|');
								var s_msg = msg[1];								
								if(msg[0]==1)
								{
									$('#div_err1').html('<div class="success_massage">'+s_msg+'<div>');
								}
								else
									$('#div_err1').html('<div class="error_massage">'+s_msg+'<div>');
							}
                        }
                    });
			setTimeout('window.location.reload()',2000);		
		}
		return false;
	});
    
    var sending_times   =   1;
    $(".login_button").click(function(){
        
        var action  =   $(this).val();
        if(action=='No')
        {
            hide_dialog();
            
        }
        else if(action=='Yes')
        {
            var buyer_id    =   $("#h_buyer_id").val() ;
            if(sending_times==1)
            {
                
                $.ajax({
                            type: "POST",
                            async: false,
                            url: base_url+'job/ajax_buy_contact',
                            data: "buyer_id="+buyer_id,
                            success: function(msg){
                                if(msg=='login_error')
                                {
                                    $("#lightbox_msg").removeClass('success_massage error_massage').addClass('error_massage').text('<?php echo addslashes(t('Please login as tradesman')); ?>').show().delay(1000).slideUp(1000) ;
                                    
                                   
                                }
                                else if(msg=='error_exist')
                                {
                                    $("#lightbox_msg").removeClass('success_massage error_massage').addClass('error_massage').text('<?php echo addslashes(t('You have this contact info already.')); ?>').show().delay(1000).slideUp(1000) ; 
                                }
                                else if(msg=='no_left_error')
                                {
                                    $("#lightbox_msg").removeClass('success_massage error_massage').addClass('error_massage').text('<?php echo addslashes(t('You have to buy this contact Info press yes for payment.')); ?>').show() ;
                                    sending_times   =   2;
                                }
                                else if(msg=='ok')
                                {
                                    $("#lightbox_msg").removeClass('success_massage error_massage').addClass('success_massage').text('<?php echo addslashes(t('Successfull you got this contact Info.')); ?>').show() ; 
                                   
								   
                                }
                                setTimeout('window.location.reload()',2000);
                                
                            }
                        });
						
					
            }
            else
            {
                window.location.href = '<?php echo base_url().'job/payment_tradesman_contactlist/'; ?>'+buyer_id ;
            }
           
            
            
            
        }
        
    });
	
	});	
</script>


