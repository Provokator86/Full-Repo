<script>
$(document).ready(function(){

$("input[name='txt_time']").datepicker({dateFormat: 'yy-M-dd',
                                               changeYear: true,
											   //yearRange: "-100:+0",
                                               changeMonth:true,
											    minDate: 0,												
												beforeShow: function(input, inst) {$('#ui-datepicker-div div').show()}
                                              });//DOB    


$('#ui-datepicker-div').hide();


	/*** generate upload file button ***/
		var max_allow_open = 5;
		var cnt = 1;
		$("#blue_link").click(function(){
			var str = '';			
			str += '<input type="file"  name="f_image_'+cnt+'" size="40"/>';
			$("#attch_div").append(str);
			cnt++;
			if(cnt>=max_allow_open)
			{
				$("#blue_link").remove();
			}
		});
	/*** end generate upload file button ***/
	

	
	
///////////Submitting the form/////////
$("#frm_job_post").submit(function(){	
    var b_valid=true;
    var s_err="";
   // $("#div_err").hide("slow");     
	//alert( typeof( $( 'frm_job_post' )));

	if($.trim($("#txt_title").val())=="") 
	{
		s_err +='<div class="error_massage"><strong>Please provide a job title.</strong>.</div>';
		b_valid=false;
	}
	if($.trim($("#opd_category_id").val())=="") 
	{
		s_err +='<div class="error_massage"><strong>Please select a category.</strong></div>';
		b_valid=false;
	}
	if($.trim($("#opt_state").val())=="") 
	{
		s_err +='<div class="error_massage"><strong>Please select a county.</strong></div>';
		b_valid=false;
	}
	if($.trim($("#opt_city").val())=="") 
	{
		s_err +='<div class="error_massage"><strong>Please select a City/Town.</strong></div>';
		b_valid=false;
	}
	if($.trim($("#opt_zip").val())=="") 
	{
		s_err +='<div class="error_massage"><strong>Please select a post code.</strong></div>';
		b_valid=false;
	}
	if($.trim($("#txt_description").val())=="") 
	{
		s_err +='<div class="error_massage"><strong>Please provide a description of your job in the work required section.</strong></div>';
		b_valid=false;
	}
	if($.trim($("#txt_keyword").val())=="") 
	{
		s_err +='<div class="error_massage"><strong>Please provide keywords for your job.</strong></div>';
		b_valid=false;
	}
	if($.trim($("#opd_quoting_period_days").val())=="") 
	{
		s_err +='<div class="error_massage"><strong>Please select a quoting period.</strong></div>';
		b_valid=false;
	}	
	if($.trim($("#txt_budget_price").val())=="") 
	{
		s_err +='<div class="error_massage"><strong>Please provide a Starting Price.</strong></div>';
		b_valid=false;
	}	
	if($('#rd_available_time2').is(':checked') && $.trim($("#txt_time").val())=="")
	{
		s_err +='<div class="error_massage"><strong>Please select date.</strong></div>';
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


///////////end Submitting the form///////// 
	$('#btn_job_post').click(function(){
		$("#frm_job_post").submit();
	}); 

});

// Ajax call to populate city options
function call_ajax_get_city(ajaxURL,item_id,cngDv)
{
	//jQuery.noConflict();///$ can be used by other prototype which is not jquery
	//jQuery(function($) {
		document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
		$.ajax({
				type: "POST",
				url: base_url+'home/'+ajaxURL,
				data: "state_id="+item_id,
				success: function(msg){
				   if(msg!='')
				   {
					   document.getElementById(cngDv).innerHTML = msg;
					   //$("#opt_city").msDropDown();
					   //call_ajax_get_zipcode("ajax_change_zipcode_option",0,0,"parent_zip"); // to repopulate zip options

				   }   
				}
			});
	//});	
}

/*function call_ajax_get_zipcode(ajaxURL,item_id,state_id,cngDv)
{
	//jQuery.noConflict();///$ can be used by other prototype which is not jquery
	//jQuery(function($) {
		document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';	
		$.ajax({
				type: "POST",
				url: base_url+'home/'+ajaxURL,
				data: "city_id="+item_id+"&state_id="+state_id,
				success: function(msg){
				   if(msg!='')
					   document.getElementById(cngDv).innerHTML = msg;
					   //$("#opt_zip").msDropDown();
				}
			});
	//});	
}*/

function call_ajax_get_zipcode_list(ajaxURL,item_id,state_id,cngDv)
{
	//jQuery.noConflict();///$ can be used by other prototype which is not jquery
	//jQuery(function($) {
	//alert(decrypt(state_id));
		//document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';	
		$.ajax({
				type: "POST",
				url: base_url+'home/'+ajaxURL,
				data: "city_id="+item_id+"&state_id="+state_id,
				success: function(msg){
				   if(msg!='')
				   {}	
				   		$('#txt_zip').val('');
						$('#opt_zip').val('');
						$('#suggestionsSearch').hide();
				   
					   //document.getElementById(cngDv).innerHTML = msg;
					   //$("#opt_zip").msDropDown();
				}
			});
	//});	
}


function get_zipcode_name(inputString) {
		var p = $("#txt_zip");
		var offset = p.offset();
		
		if(inputString.length>2) {	
			var opt_state = $("#opt_state").val();
			var opt_city = $("#opt_city").val();
			var txt_zip = $("#txt_zip").val();
			
			$.post("<?=base_url()?>home/ajax_autocomplete_zipcode/"+opt_city+"/"+ opt_state+"/"+txt_zip, {queryString: "" + inputString + ""}, function(data){
					if(data.length >0) {
					
						$('#suggestionsSearch').show();
						$('#autoSuggestionsListSearch').html(data);
						$('#suggestionsSearch').css('left',offset.left);
					}
					else
					{
						$('#suggestionsSearch').hide();
					}
				});
			}
			else
				$('#suggestionsSearch').hide();	
	} // lookup

	function business_fill(thisValue) {
		var b=new Array();
		b["&amp;"]="&";
		b["&quot;"]='"';
		b["&#039;"]="'";
		b["&lt;"]="<";
		b["&gt;"]=">";
		var r;
		for(var i in b){
			r=new RegExp(i,"g");
			thisValue = thisValue.replace(r,b[i]);
		}
		var prop_val = thisValue.split('^');
		$('#txt_zip').val(prop_val[0]);
		$('#opt_zip').val(prop_val[1]);
		$('#suggestionsSearch').hide();
		
	}




function select_available(param)
{
	if(param==1)
	{
		$("#show_specific").hide();
		$("#show_flexi").show();
	}	
	else
	{
		$("#show_flexi").hide();
		$("#show_specific").show();
	}
			
	
}

</script>

<div id="banner_section">
	<?php
	include_once(APPPATH."views/fe/common/header_top.tpl.php");
	?>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
<?php
	include_once(APPPATH."views/fe/common/common_buyer_search.tpl.php");
	?>
<!-- /SERVICES SECTION -->
<!-- CONTENT SECTION -->
<div id="content_section">
	<div id="content">
		<div id="div_err">
			<?php
			echo validation_errors();
		?>
		</div>
		<form name="frm_job_post" id="frm_job_post" method="post" action="<?php echo base_url().'job/job_post'?>" enctype="multipart/form-data">
			<div id="inner_container02">
				<div class="title">
					<h3><span>Post</span> a Job</h3>
				</div>
				<div class="clr"></div>
				<h6>Try to give service providers as much information as possible in order to get a reasonable amount of quality bids.</h6>
				<p style="text-align:right;">&nbsp;</p>
				<p style="text-align:right;"><span class="red_txt">*</span> Required field</p>
				<p style="text-align:right;">&nbsp;</p>
				<div class="section">
					<div class="top">&nbsp;</div>
					<div class="mid">
						<div class="label01">Job Title <span class="red_txt">*</span> :</div>
						<div class="field01">
							<input type="text"  name="txt_title" id="txt_title"  value="<?php echo $posted['txt_title']?>" />
						</div>
						<div class="clr"></div>
						<div class="label01">Category <span class="red_txt">*</span> :</div>
						<div class="field01">
							<select name="opd_category_id" id="opd_category_id" style="width:275px;">
								<option value="">Select category</option>
								<?php echo makeOptionCategory(" s_category_type='job'",$posted['opd_category_id']) ?>
							</select>
						</div>
						<div class="clr"></div>
						<div class="label01"><strong>Where do you need the job done</strong> <span class="red_txt">*</span> :</div>
						<div class="clr"></div>
						<div class="label02">County :</div>
						<div class="field02">
							<select id="opt_state" name="opt_state" style="width:192px;" onchange='call_ajax_get_city("ajax_change_city_option_auto_complete",this.value,"parent_city");'>
								<option value="">Select county</option>
								<?php echo makeOptionState() ?>
							</select>
						</div>
						<div class="clr"></div>
						<div class="label02">City/Town :</div>
						<div class="field02">
							<div id="parent_city">
								<select name="opt_city" id="opt_city" style="width:192px; " onchange='call_ajax_get_zipcode_list("ajax_change_zipcode_option_auto_complete",this.value,opt_state.value,"parent_zip");'>
									<option value="">Select city </option>
								</select>
							</div>
						</div>
						<div class="clr"></div>
						<div class="label02">Postal Code :</div>
						<div class="field02">
						
							<div id="parent_zip">
                              
                              <input type="text"  name="txt_zip" id="txt_zip" onkeyup="get_zipcode_name(this.value)" autocomplete="off" style="width:180px;"/>
                              
							  
							  
							  <?php   /*<select name="opt_zip" id="opt_zip" style="width:192px; ">
                                          <option value=""><?php echo t('Select postal code')?> </option>
                                    </select> */?>
                                    
                                    
                                    
                                    <input type="hidden" name="opt_zip" id="opt_zip" />
							  </div>
							  
							  <div class="suggestionsBox" id="suggestionsSearch" style="display: none;  position:absolute;">
								<div class="arrow_autocom"> &nbsp; </div>
								<div class="suggestionList" id="autoSuggestionsListSearch" style="height:130px; width:190px; overflow:auto;"> &nbsp; </div>
                              </div>
							  <p>Type 3 characters.</p>
						</div>
						<div class="clr"></div>
						<div class="label01">Should Professional Provide Materials? <span class="red_txt">*</span> :</div>
						<div class="clr"></div>
						<div class="field03">
							<input name="chk_supply_material" type="radio" value="1" <?php echo (!empty($posted['chk_supply_material']) && $posted['chk_supply_material']==1 ? 'checked="checked"' : '')?>  />
							Yes
							<input name="chk_supply_material" type="radio" value="2" <?php echo (!empty($posted['chk_supply_material']) && $posted['chk_supply_material']==2 ? 'checked="checked"' : '')?>/>
							No
							<input name="chk_supply_material" type="radio" value="0"  <?php echo (empty($posted['chk_supply_material']) ? 'checked="checked"' : '')?> />
							Doesn't Matter </div>
						<div class="clr"></div>
						<div class="label01">Keywords <span class="red_txt">*</span> :</div>
						<div class="field01">
							<input type="text"  name="txt_keyword" id="txt_keyword" style="width:260px;" value="<?php echo $posted['txt_keyword']?>" />
						</div>
						<div class="clr"></div>
					</div>
					<div class="bot">&nbsp;</div>
				</div>
				<div class="section" style="margin:0 20px;">
					<div class="top">&nbsp;</div>
					<div class="mid">
						<div class="label01">What work is required <span class="red_txt">*</span> :</div>
						<div class="field01">
							<textarea name="txt_description" id="txt_description" ><?php echo $posted['txt_description']?></textarea>
						</div>
						<div class="clr"></div>
						<div class="label01">Quoting Period <span class="red_txt">*</span> :</div>
						<div class="field04">
							<select name="opd_quoting_period_days" id="opd_quoting_period_days" style="width:110px;">
								<?php
							for($i=1;$i<=60;$i++)
							{
							?>
								<option value="<?php echo $i;?>"><?php echo $i;?></option>
								<?php } ?>
							</select>
							day(s)</div>
						<div class="clr"></div>
						<div class="label01">Budget <span class="red_txt">*</span> : (incl. VAT)</div>
						<div class="field04">
							<input type="text"  name="txt_budget_price" id="txt_budget_price"  style="width:90px;"  value="<?php echo $posted['txt_budget_price']?>" />
							£</div>
						<div class="clr"></div>
					</div>
					<div class="bot">&nbsp;</div>
				</div>
				<div class="section">
					<div class="top">&nbsp;</div>
					<div class="mid" style="min-height:380px;">
						<div class="label01"><strong>Work needs to be done by :</strong></div>
						<div class="clr"></div>
						<div class="label07" style="width:120px;">
							<input name="rd_available_time" id="rd_available_time1" type="radio" value="1"  style="margin-right:10px;" onclick="select_available(1);" checked="checked"/>
							I'm Flexible:</div>
						<div id="show_flexi">
							<div class="field07">
								<div><span class="field07">
									<select name="opd_available_time" style="width:160px;">
										<?php echo makeOptionAvailableTime() ?>
									</select>
									</span></div>
							</div>
						</div>
						<div class="clr"></div>
						<div class="label01">
							<input name="rd_available_time"  id="rd_available_time2" type="radio" value="2"  style="margin-right:10px;" onclick="select_available(2);"/>
							At a specific date and time:</div>
						<div class="clr"></div>
						<div id="show_specific" style="display:none;">
							<div class="field01" style="width:280px;">
								<table width="100%" cellspacing="0" cellpadding="0">
									<tr>
										<td width="59%"><input type="text" name="txt_time" id="txt_time"  style="width:250px; margin-right:5px;"/></td>
										<td width="21%"><img src="images/fe/Calender.png" alt="" id="show_calender" /></td>
										
									</tr>
								</table>
							</div>
							<div class="clr"></div>
							<div class="field01" style="width:300px;margin-top:10px;">
								<table width="" cellspacing="0" cellpadding="0">
									<tr><td width="30"><p>from</p></td>
										<td width="113"><select  name="txt_time_from" style="width:100px;">
												<?php
												$j=1;
												$m = '  am';
												for($i=1;$i<=24;$i++)
												{
													if($i==13)
													{
														$j = 1;
														$m = '  pm';
													}
												?>
												<option value="<?php echo $j.$m;?>"><?php echo $j.$m;?></option>
												<?php 
													$j++;
												} ?>
											</select></td>
										<td width="20"><p>to</p></td>
									
										<td width="120"><select name="txt_time_to" style="width:100px;">
												<?php
												$j=1;
												$m = '  am';
												for($i=1;$i<=24;$i++)
												{
													if($i==13)
													{
														$j = 1;
														$m = '  pm';
													}
												?>
												<option value="<?php echo $j.$m;?>"><?php echo $j.$m;?></option>
												<?php 
													$j++;
												} ?>
											</select>
										</td>
									</tr>
								</table>
							</div>
						</div>
						<div class="clr"></div>
						<div class="label01"><strong>Attach Pictures/Files :</strong><br />
							Permitted file formats: .jpg, .gif, .png, .pdf, .doc.</div>
						<div class="clr"></div>
						<div class="field01" id="attch_div">
							<input type="file" name="f_image_0"  size="30"/>
						</div>
						<div class="clr"></div>
						<div class="label01"><a href="javascript:void(0)" id="blue_link">Attach more files</a></div>
						<div class="clr"></div>
						<div class="field01">
							<input type="submit" id="btn_job_post" value="Continue" />
						</div>
						<div class="clr"></div>
					</div>
					<div class="bot">&nbsp;</div>
				</div>
				<div class="clr"></div>
			</div>
		</form>
		<div class="clr"></div>
	</div>
	<div class="clr"></div>
</div>
