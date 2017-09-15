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
  
  
///////////Submitting the form/////////
$(document).ready(function(){
	//$('#txt_quote').numeric();
	$('#btn_job_quote').click(function(){
		$("#frm_job_quote").submit();
	}); 
	
	$("#frm_job_quote").submit(function(){	
		var b_valid=true;
		var quote_val = /^[0-9]+$/;
		var s_err="";
	   // $("#div_err").hide("slow");     
		
		if($.trim($("#txt_quote").val())=="") 
		{
			s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please enter quote'))?>.</strong></span></div>';
			b_valid=false;
		}
		else if(quote_val.test($.trim($("#txt_quote").val()))==false)
		{
			s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please enter numeric value with no decimal point'))?>.</strong></span></div>';
			b_valid=false;
		}
	
		
		/////////validating//////
		if(!b_valid)
		{
		   // $.unblockUI();  
			$("#div_err").html(s_err).show("slow");
		}
		
		return b_valid;
	}); 
}); 

///////////end Submitting the form///////// 


  
</script>



<div id="div_container">
      <div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>
            </div>
			<div id="div_err">
				<?php
					echo validation_errors();
				?>
				</div>
			<?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
            <div class="body_left rightSidebar" >
                  <h1><?php echo t('Overview')?> </h1>
                  <div class="shadow_small">
                        <div class="left_box" style="line-height:25px; padding:5px 10px;">
                              <p><span class="blue_txt"><?php echo t('Job Poster')?> :</span>  <span class="pink_txt"><?php echo $job_details['s_buyer_name']?></span></p>
                              <p><span class="blue_txt"><?php echo t('Initial Price')?>:</span> <?php echo $job_details['s_budget_price']?></p>
                              <p><span class="blue_txt"><?php echo t('Posted On')?>:</span> <?php echo $job_details['dt_front_entry_date']?></p>
                              <p><span class="blue_txt"><?php echo t('Period Ends')?>:</span> <?php echo $job_details['dt_front_expire_date']?></p>
                              <p><span class="blue_txt"><?php echo t('Lowest Bid')?>:</span> <?php echo $job_details['s_lowest_quote']?> </p>
                              <div class="tsb_text" style="display:none" id="faq_tab">
                                    <ul class="category">
                                          <li><a href="job_poster_questions.html">Job Poster Questions</a></li>
                                          <li><a href="service_provider_question.html">Tradesman’s Question </a></li>
                                          <li><a href="contact_us.html">Contact Us</a></li>
                                          <li><a href="feedback.html">Feedback</a></li>
                                    </ul>
                              </div>
                        </div>
                  </div>
                  <h1><?php echo t('Location')?> </h1>
                  <div class="shadow_small">
                        <div class="left_box">
                              <div id="map">
                              </div>
                        </div>
                  </div>
                  <h1><?php echo t('Other')?> <span><?php echo t('Jobs')?></span></h1>
                  <div class="shadow_small">
                        <div class="left_box others_job">
						<?php
						if($other_jobs)
						{
							foreach($other_jobs as $val)
							{
								$s_title = (strlen($val['s_title']) > 10) ? substr($val['s_title'],0,10) : $val['s_title'];
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
                 
                        <h1><?php echo get_title_string(t('Place Quote'))?> </h1>
                        <div class="shadow_big">
                            <form name="frm_job_quote" id="frm_job_quote" method="post" action="">
                                    <div class="right_box_all_inner">
                                          <div class="lable01" style="padding-top:12px;"><?php echo t(' Quote Price ')?></div>
                                          <div class="fld01" style="line-height:19px;">
                                                <strong> <?php echo $this->config->item('default_currency') ?></strong> 
												<input  type="text"  name="txt_quote" id="txt_quote" style="width:180px; vertical-align:middle;"  />
                                          </div>
                                          <div class="spacer"></div>
                                         
                                        
                                          <div class="lable01"></div>
                                          <div class="fld01" style="padding-top:10px;">
                                                <input  class="button" type="button" value="<?php echo t('Submit')?>" id="btn_job_quote" style="margin-left:28px;"/>
                                          </div>
                                          <div class="spacer"></div>
                                    </div>
							</form>		
            
                        </div>
                
            </div>
            <div class="spacer"></div>
      </div>
</div>