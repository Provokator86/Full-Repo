<script type="text/javascript">
$(document).ready(function() {
  var param_str = '';
  var data_str = '';
	$(".link_accept").click(function() {
	param_str = $(this).attr('rel');
	$("#h_job_id").val(param_str);
	show_dialog('photo_zoom02');
	});
	
	$(".link_deny").click(function() {
	data_str = $(this).attr('rel');
	$("#h_data_id").val(data_str);
	show_dialog('photo_zoom05');
	});
	
	/* clicking on the submit button for job accept complete */
	$("#btn_accept").click(function() {
		var b_valid = true;
		
		if($.trim($("#s_comment").val())=="") //// For  name 
		{
			$("#err_s_comment").text('<?php echo addslashes(t('Please provide comment'))?>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#err_s_comment").slideUp('slow').text('<?php echo addslashes(t(''))?>');
		}
		
		var myRadio = $("input[name='i_rate']:checked").val();
		if(myRadio==1)
		{
			if($("#rating option:selected").val()<=2)
			{
				$("#err_rating").text('<?php echo addslashes(t('Please select rating greater than 2'))?>').slideDown('slow');
				b_valid  =  false;
			}
			else
			{
				$("#err_rating").slideUp('slow').text('<?php echo addslashes(t(''))?>');
			}
		}
		else
		{
			if($("#rating option:selected").val()>2)
			{
				$("#err_rating").text('<?php echo addslashes(t('Please select rating less than 3'))?>').slideDown('slow');
				b_valid  =  false;
			}
			else
			{
				$("#err_rating").slideUp('slow').text('<?php echo addslashes(t(''))?>');
			}
		}
		
		if(b_valid)
		{
			var i_job_id 	= $("#h_job_id").val();
			var s_comment 	= $("#s_comment").val();
			var i_rate		= $("#rating").val();
			var is_positive	= myRadio;
			
			$.ajax({
                        type: "POST",
                        async: false,
                        url: base_url+'buyer/confirm_job_complete',
                        data: "i_job_id="+i_job_id+"&s_comment="+s_comment+"&i_rating="+i_rate+"&is_positive="+is_positive,
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
		
	});
	/* clicking on the submit button for job accept complete */
	
	/* clicking on the submit button for deny job complete */
	$("#btn_deny").click(function() {
		var b_valid = true;
		
		if($.trim($("#ta_message").val())=="") //// For  name 
		{
			$("#err_ta_message").text('<?php echo addslashes(t('Please provide comment'))?>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#err_ta_message").slideUp('slow').text('<?php echo addslashes(t(''))?>');
		}
		
		if(b_valid)
		{
			var i_job_id 	= $("#h_data_id").val();
			var s_comment 	= $("#ta_message").val();
			var i_rate		= $("#ratting").val();
			
			$.ajax({
                        type: "POST",
                        async: false,
                        url: base_url+'buyer/deny_job_complete',
                        data: "i_job_id="+i_job_id+"&s_comment="+s_comment+"&i_rating="+i_rate,
                        success: function(data){
                            if(data)
                            {
								msg = data.split('|');
								var s_msg = msg[1];		
													
								if(msg[0]==1)
								{
									$('#div_err5').html('<div class="success_massage">'+s_msg+'<div>');
								}
								else
									$('#div_err5').html('<div class="error_massage">'+s_msg+'<div>');
							}
                        }
                    });
					
		setTimeout('window.location.reload()',2000);			
	
	
		}
		
	});
	/* clicking on the submit button for deny job complete */
	
});  // end document ready	
</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
            <div class="top_part"></div>
            <div class="midd_part height02">
                  <div class="username_box">
                        <div class="right_box03">
                              <h4><?php echo addslashes(t('Dashboard'))?> </h4>
                              <div class="div01">
                                    <p><?php echo addslashes(t('Welcome'))?> <span><?php echo ucfirst($name); ?></span></p>
									<p>									
									<?php echo addslashes(t('You have'))?> <a href="<?php echo base_url().'buyer/private-message-board' ?>"><span><?php echo $i_new_msg; ?>									
									</span><?php echo addslashes(t('new message(s)'))?></a> &nbsp;&nbsp;</p>
                                    <p>									
									<?php echo addslashes(t('You have'))?> <a href="<?php echo base_url().'buyer/all-quotes' ?>"><span><?php echo $i_new_quotes; ?>									
									</span><?php echo addslashes(t('new quote(s)'))?></a> &nbsp;&nbsp;</p>
                                    <p><?php echo addslashes(t('Local time is'))?> <span id="demo_clock"> &nbsp;<?php echo $dt_current_time ?> <!--Tuesday, 23-Aug-2011 4:37 EST--></span></p>
                                    <div class="spacer"></div>
                              </div>
                              <div class="div02">
                                    <h5><?php echo addslashes(t('My Open Jobs'))?></h5>
                                    <div class="find_box02">
                                          <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                      <tr>
                                                            <th width="55%" valign="middle" align="left"><?php echo addslashes(t('Job Details'))?></th>
                                                            <th valign="middle" align="center" class="margin00"><?php echo addslashes(t('Quote(s)'))?></th>
                                                            <th valign="middle" align="center" class="margin00" ><?php echo addslashes(t('Expiry Date'))?></th>
                                                            <th valign="middle" align="center" class="margin00"><?php echo addslashes(t('Option'))?></th>
                                                      </tr>
													   <?php if($open_jobs) { 
																$cnt = 1;
													  
															foreach($open_jobs as $val)
																{ 
                                                                    $job_url    =   make_my_url($val['s_title']).'/'.encrypt($val['id']) ;
																$class = ($cnt%2 == 0)?'class="bgcolor"':'';
													   ?>
													  
                                                      <tr <?php echo $class ?>>
														<td valign="middle" align="left" class="leftboder"><h5><a href="<?php echo base_url().'job-details/'.$job_url;?>" target="_blank"><?php echo string_part($val['s_title'],30) ?></a></h5>
															  <?php echo string_part($val['s_description'],100) ?>
															  <div class="spacer"></div>
															  <ul class=" spacer">
						  <li><?php echo addslashes(t('Highest quote'))?> <span><?php echo $val['max_quote'] ?> TL</span></li>
						  <li>|</li>
						  <li><?php echo addslashes(t('Average quote'))?>:<span> <?php echo $val['avg_quote'] ?> TL</span> </li>					   				      </ul> </td>
														<td valign="middle" align="center"><?php echo $val['i_quotes']?></td>
														<td valign="middle" align="center"><?php echo $val['dt_expired_date']?></td>
														<td valign="middle" align="center">
													   <a target="_blank" href="<?php echo base_url().'job-details/'.$job_url;?>" target="_blank"><img src="images/fe/view.png" alt="" onmouseover="this.src='images/fe/view-hover.png'" onmouseout="this.src='images/fe/view.png'" onclick="this.src='images/fe/view.png'" title="<?php echo addslashes(t('view'))?>" /></a>
														
														</td>
                                                      </tr>
													  <?php $cnt++; } } 
													  else { 
													  ?>
													  <tr>
														  <td>
															<p><?php echo addslashes(t('No item found')) ?></p>
														  </td>
														  <td align="left" valign="middle"></td>
														  <td align="right" valign="middle"  class="text02"></td>
														  <td align="center" valign="middle"></td>
														  
													  </tr>
													  <?php } ?>
                                                      
                                                </tbody>
                                          </table>
                                    </div>
                              </div>
                              
                              
                              <div class="div02">
                                    <h5><?php echo addslashes(t('Completion Alert of Jobs'))?></h5>
                                    <div class="find_box02">
                                          <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                      <tr>
                                                            <th valign="middle" align="left"><?php echo addslashes(t('Job Details'))?></th>
                                                            <th valign="middle" align="left"><?php echo addslashes(t('Assigned to'))?></th>
                                                            <th valign="middle" align="center" class="margin00" ><?php echo addslashes(t('Status'))?></th>
                                                            <th valign="middle" align="center" class="margin00"><?php echo addslashes(t('Option'))?></th>
                                                      </tr>
													  
													  <?php if($feedback_job_list) { 
																$cnt = 1;
													  
															foreach($feedback_job_list as $val)
																{ 
                                                                     $job_url    =   make_my_url($val['s_title']).'/'.encrypt($val['id']) ;
																$class = ($cnt%2 == 0)?'class="bgcolor"':'';
																
													   ?>
													  
                                                      <tr <?php echo $class ?>>
                                                            <td valign="middle" align="left" class="leftboder" ><h5><a href="<?php echo base_url().'job-details/'.$job_url;?>" target="_blank"> <?php echo string_part($val['s_title'],30)?></a></h5>
                                                                  <?php echo string_part($val['s_description'],100) ?></td>
                                                            <td valign="middle" align="left" width="18%"><h6><?php echo $val['s_username'] ?></h6></td>
                                                            <td valign="middle" align="center"><?php echo addslashes(t('Tradesman declared job as completed'))?> <br/>
                                                           <h4><a href="javascript:void(0);" rel="<?php echo encrypt($val['id']) ?>" class="link_accept"><?php echo addslashes(t('Accept'))?></a> | <a href="javascript:void(0);" rel="<?php echo encrypt($val['id']) ?>" class="link_deny"><?php echo addslashes(t('Deny'))?></a></h4></td>
                                                            <td valign="middle" align="center">
                                                           
                                                           <a target="_blank" href="<?php echo base_url().'job-details/'.$job_url;?>" target="_blank"><img src="images/fe/view.png" alt="" onmouseover="this.src='images/fe/view-hover.png'" onmouseout="this.src='images/fe/view.png'" onclick="this.src='images/fe/view.png'" title="<?php echo addslashes(t('view'))?>" /></a>
                                                            
                                                            </td>
                                                      </tr>
                                                      <?php $cnt++; } } 
													  else { 
													  ?>
													  <tr>
														  <td class="leftboder">
															<p><?php echo addslashes(t('No item found')) ?></p>
														  </td>
														  <td align="left" valign="middle"></td>
														  <td align="right" valign="middle"  class="text02"></td>
														  <td align="center" valign="middle"></td>
														  
													  </tr>
													  <?php } ?>
                                                      
                                                      
                                                </tbody>
                                          </table>
                                    </div>
                              </div>
                              
                        </div>
                       <?php include_once(APPPATH."views/fe/common/buyer_left_menu.tpl.php"); ?>
                        <div class="spacer"></div>
                  </div>
                  <div class="spacer"></div>
            </div>
            <div class="spacer"></div>
            <div class="bottom_part"></div>
      </div>
	  

<!--lightbox-->
<div class="lightbox04 photo_zoom02">
<div id="div_err1">
</div>
      <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
      <h3><?php echo addslashes(t('Are you sure to accept this job as complete'))?>?</h3>
      <div class="lable"><?php echo addslashes(t('Comments'))?>  :</div>
      <div class="textfell">
            <textarea name="s_comment" id="s_comment" ></textarea>
      </div>
      <div class="spacer"></div>
	  <div id="err_s_comment" class="err" style="margin-left:110px;"><?php echo form_error('s_comment') ?></div>
	  
      <div class="spacer"></div>
      <div class="lable"><?php echo addslashes(t('Rating'))?> :</div>
      <div class="textfell">
            <select id="rating" name="rating " style="width:269px;">
				  <option value="1">1 </option>
				  <option value="2">2 </option>
                  <option value="3">3 </option>
				  <option value="4">4 </option>
				  <option value="5">5 </option>
            </select>
			
			<div class="spacer"></div>
	  <div id="err_rating" class="err"><?php echo form_error('rating') ?></div>
            <script type="text/javascript">
	$(document).ready(function() {
	  $("#rating").msDropDown();
	  $("#rating").hide();
      $('#rating_msdd').css("background-image", "url(images/fe/select.png)");
	  $('#rating_msdd').css("background-repeat", "no-repeat");
	  $('#rating_msdd').css("width", "269px");
	  $('#rating_msdd').css("margin-top", "0px");
	  $('#rating_msdd').css("padding", "0px");
	  $('#rating_msdd').css("height", "38px");
						});
</script>
      </div>
	  
	  
      <div class="spacer"></div>
       <div class="lable"><?php echo addslashes(t('Positive'))?>  :</div>
      <div class="textfell">
            <input name="i_rate" id="i_positive" class="i_positive" type="radio" value="1" /> <?php echo addslashes(t('Yes'))?>   
			<input name="i_rate" id="i_negative" class="i_positive" type="radio" value="2" checked="checked" /> <?php echo addslashes(t('No'))?> 
      </div>
      <div class="spacer"></div>
      
      <div class="lable"></div>
      <div class="textfell">
	  		<input type="hidden" name="h_job_id" id="h_job_id" value="" />
            <input class="small_button margintop" id="btn_accept" value="<?php echo addslashes(t('Submit'))?>" type="button" />
      </div>
</div>
<!--lightbox-->

<!--lightbox-->
<div class="lightbox04 photo_zoom05">
<div id="div_err5">
</div>
      <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
     
	  <h3><?php echo addslashes(t('Why do you want to deny this job to be complete'))?>?</h3>
	   
      <div class="lable"><?php echo addslashes(t('Comments'))?>  :</div>
      <div class="textfell">
            <textarea name="ta_message" id="ta_message"></textarea>
      </div>
	  <div class="spacer"></div>
	  <div id="err_ta_message" class="err" style="margin-left:110px;"><?php echo form_error('ta_message') ?></div>
	  
	  <div class="spacer"></div>
      <div class="lable"><?php echo addslashes(t('Rating'))?> :</div>
      <div class="textfell">
            <select id="ratting" name="ratting " style="width:269px;">
				  <option value="1">1 </option>
				  <option value="2">2 </option>
            </select>
			
			<div class="spacer"></div>
	  <div id="err_ratting" class="err"><?php echo form_error('ratting') ?></div>
            <script type="text/javascript">
	$(document).ready(function() {
	  $("#ratting").msDropDown();
	  $("#ratting").hide();
      $('#ratting_msdd').css("background-image", "url(images/fe/select.png)");
	  $('#ratting_msdd').css("background-repeat", "no-repeat");
	  $('#ratting_msdd').css("width", "269px");
	  $('#ratting_msdd').css("margin-top", "0px");
	  $('#ratting_msdd').css("padding", "0px");
	  $('#ratting_msdd').css("height", "38px");
						});
</script>
      </div>
	  
      <div class="spacer"></div>      
      <div class="lable"></div>
      <div class="textfell">
		<input type="hidden" name="h_data_id" id="h_data_id" value="" />
		<input class="small_button margintop" id="btn_deny" value="<?php echo addslashes(t('Submit'))?>" type="button" />
      </div>
</div>
<!--lightbox-->	  