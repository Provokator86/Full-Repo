<script>
jQuery(function($){
$(document).ready(function(){
  
  $(".numeric_valid").keydown(function(e){
		if(e.keyCode==8 || e.keyCode==9 || e.keyCode==46)
		{
			return true; 
		}    
		if($(this).val().length>9) // check for more than 7 digit
		{
			return false;
		}
		 
		 return (e.keyCode>=48 && e.keyCode<=57 || e.keyCode>=96 && e.keyCode<=105) //Only 0-9 digits are allowed

})  ;
/******** validation for text box to allow only numeric *******/ 
  
    
/*** generate upload file button ***/
		var max_allow_open = 5;
		var cnt = 1;
		$("#blue_link").click(function(){
			var str = '';			
			str += '<input type="file"  name="f_image_'+cnt+'" class="width05"/>';
			
			$("#attch_div").append(str);
			cnt++;
			if(cnt>=max_allow_open)
			{
				$("#blue_link").remove();
			}
		});
/*** end generate upload file button ***/

		// onblur content for descriptio of job section
	
	var var1 = '<?php echo t('Let the users know about ,\nthe job ,\ntype of job ,\nso increase your chance to win more bids...\n\nNever type any contact information, email or website, it will cause you loose your membership.')?>';
	
	$("#txt_description").val(var1).css({'opacity':'0.5'});
	$("#txt_description").focus(function() {
		if ($(this).attr("value")==var1) 
			{
			   $(this).val('');
			}  
		
			});
	
	$("#txt_description").blur(function() {
		if ($(this).attr("value")=="") 
			{
			   //$(this).val(var1).css({'color': "#666", 'font-style': 'italic', 'font-weight': 'normal'});
			   $(this).val(var1).css({'opacity':'0.5'});
			}  
		
			});
	


///////////Submitting the form/////////
$("#btn_job_post").click(function(){	
    var b_valid=true;
    var s_err="";
	var keys = $.trim($("#txt_keyword").val());
	var key_len = keys.split(',');
	
	var file_type   = $("#f_icon").val();
	
	if($.trim($("#txt_title").val())=="") //// For  name 
	{
		$("#err_txt_title").text('<?php echo addslashes(t('Please provide job title'))?>').slideDown('slow');
		b_valid  =  false;
	}
    else
    {
        $("#err_txt_title").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }	
	
	if($.trim($("#opd_category_id").val())=="") 
	{
		$("#err_opd_category_id").text('<?php echo addslashes(t('Please select category'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else
    {
        $("#err_opd_category_id").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	
	if($.trim($("#txt_address").val())=="") //// For  name 
	{
		$("#err_txt_address").text('<?php echo addslashes(t('Please provide job address'))?>').slideDown('slow');
		b_valid  =  false;
	}
    else
    {
        $("#err_txt_address").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	
	if($.trim($("#opt_state").val())=="") 
	{
		$("#err_opt_state").text('<?php echo addslashes(t('Please select province'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else
    {
        $("#err_opt_state").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	
	if($.trim($("#opt_city").val())=="") 
	{
		$("#err_opt_city").text('<?php echo addslashes(t('Please select city'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else
    {
        $("#err_opt_city").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	
	/*if($.trim($("#opt_zip").val())=="") 
	{
		$("#err_opt_zip").text('<?php echo addslashes(t('Please select zip code'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else
    {
        $("#err_opt_zip").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }*/
	
	if($.trim($("#txt_description").val())=="" || $.trim($("#txt_description").val())==var1) 
	{
		$("#err_txt_description").text('<?php echo addslashes(t('Please select description'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else
    {
        $("#err_txt_description").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	
	if($.trim($("#txt_keyword").val())=="") 
	{
		$("#err_txt_keyword").text('<?php echo addslashes(t('Please select keyword'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else if(key_len.length>8 || key_len.length<4)
	{
		 $("#err_txt_keyword").text('<?php echo addslashes(t('Please provide at least 4 keywords and maximum 8 keywords'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else
    {
        $("#err_txt_keyword").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	
	if($.trim($("#opd_quoting_period_days").val())=="") 
	{
		$("#err_quote_period").text('<?php echo addslashes(t('Please select quoting period'))?>').slideDown('slow');
		b_valid  =  false;
	}	
	else
    {
        $("#err_quote_period").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	
    /////////validating//////
    if(!b_valid)
    {
       // $.unblockUI();  
        $("#div_err").html(s_err).show("slow");
    }
    
	else
	{
	$("#frm_job_post").submit();
	}
	return b_valid;
    
}); 


///////////end Submitting the form///////// 


});   // end document.ready 
});

// Ajax call to populate province options
function call_ajax_get_province(ajaxURL,item_id,cngDv)
{
		document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
		$.ajax({
				type: "POST",
				url: base_url+'ajax_fe/'+ajaxURL,
				data: "city_id="+item_id,
				success: function(msg){
				   if(msg!='')
				   {
					   document.getElementById(cngDv).innerHTML = msg;
					   $("#opt_state").msDropDown();
					   $("#opt_state").hide();
					   $('#opt_state_msdd').css("background-image", "url(images/fe/select.png)");
					   $('#opt_state_msdd').css("background-repeat", "no-repeat");
					   $('#opt_state_msdd').css("width", "269px");
					   $('#opt_state_msdd').css("margin-top", "0px");
					   $('#opt_state_msdd').css("padding", "0px");
					   $('#opt_state_msdd').css("height", "38px");
					   

				   }   
				}
			});
		
}

function call_ajax_get_zipcode(ajaxURL,item_id,city_id,cngDv)
{
	jQuery.noConflict();///$ can be used by other prototype which is not jquery
	jQuery(function($) {
		document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
		$.ajax({
				type: "POST",
				url: base_url+'ajax_fe/'+ajaxURL,
				data: "state_id="+item_id+"&city_id="+city_id,
				success: function(msg){
				   if(msg!='')
					   document.getElementById(cngDv).innerHTML = msg;
                       $("#opt_zip").msDropDown();
                       $("#opt_zip").hide();
                       $('#opt_zip_msdd').css("background-image", "url(images/fe/select.png)");
                       $('#opt_zip_msdd').css("background-repeat", "no-repeat");
                       $('#opt_zip_msdd').css("width", "269px");
                       $('#opt_zip_msdd').css("margin-top", "0px");
                       $('#opt_zip_msdd').css("padding", "0px");
                       $('#opt_zip_msdd').css("height", "38px");
				}
			});
	});	
}

/*function get_zipcode_name(inputString) {
		var p = $("#txt_zip");
		var offset = p.offset();
		
		if(inputString.length>1) {	
			var opt_state = $("#opt_state").val();
			var opt_city = $("#opt_city").val();
			var txt_zip = $("#txt_zip").val();
			
			$.post("<?=base_url()?>ajax_fe/ajax_autocomplete_zipcode/"+opt_city+"/"+ opt_state+"/"+txt_zip, {queryString: "" + inputString + ""}, function(data){
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
		
	}*/


</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
            <div class="top_part"></div>
			
			<form name="frm_job_post" id="frm_job_post" method="post" action="<?php echo base_url().'job/job-post'?>" enctype="multipart/form-data">
            <div class="midd_part">
                  <p class="required"><?php echo addslashes(t('Required fields are indicated with a'))?> <span>*</span></p>
                  <h2><?php echo addslashes(t('Post a Job'))?></h2>
                  <div class="margin10"></div>
                  <p><?php echo addslashes(t('Try to give tradesmen as much information as possible in order to get a reasonable amount of quality bids'))?>.</p>
                  <div class="margin10"></div>
                  <!--box-->
                  <div class="box02">
                        <div class="part_top"></div>
                        <div class="part_midd">
                              <label><?php echo addslashes(t('Job Title'))?> <span>*</span> </label>
                              <div class="spacer"></div>
                              <div class="textfell">
                                   <input type="text"  name="txt_title" id="txt_title" value="<?php echo $posted['txt_title']?>" />
								  
                              </div>
							  <div id="err_txt_title" class="err"><?php echo form_error('txt_title') ?></div>
							  
                              <div class="spacer"></div>
                              <label><?php echo addslashes(t('Category'))?> <span>*</span> </label>
                              <div class="spacer"></div>
                             
							  <select name="opd_category_id" id="opd_category_id" style="width:269px;">
								  <option value=""><?php echo addslashes(t('Category'));?> </option>
								  <?php echo makeOptionCategory(" c.i_status=1 ",$posted['opd_category_id']) ?>
                                </select>
                                
                              <script type="text/javascript">
						$(document).ready(function() {
						  $("#opd_category_id").msDropDown();
						   $("#opd_category_id").hide();
						   $('#opd_category_id_msdd').css("background-image", "url(images/fe/select.png)");
						   $('#opd_category_id_msdd').css("background-repeat", "no-repeat");
						   $('#opd_category_id_msdd').css("width", "269px");
						   $('#opd_category_id_msdd').css("margin-top", "0px");
						   $('#opd_category_id_msdd').css("padding", "0px");
						    $('#opd_category_id_msdd').css("height", "38px");
						});
					
					</script>
						<div id="err_opd_category_id" class="err"><?php echo form_error('opd_category_id') ?></div>
						
                              <div class="spacer"></div>
                              <h2><?php echo addslashes(t('Job Location'))?> </h2>
                              <div class="margin10"></div>
							  <!-- job address -->
							  <label><?php echo addslashes(t('Address'))?> <span>*</span> </label>
                              <div class="spacer"></div>
                              <div class="textfell">
                             <input type="text" name="txt_address" id="txt_address" value="<?php echo $posted['txt_address']?>" />
								  
                              </div>
							  <div id="err_txt_address" class="err"><?php echo form_error('txt_address') ?></div>
							  <!-- job address -->
							  
							  <div class="spacer"></div>
                              <label><?php echo addslashes(t('City'))?> <span>*</span> </label>
                              <div class="spacer"></div>
							  <select name="opt_city" id="opt_city" style="width:269px;" onchange='call_ajax_get_province("ajax_change_province_option_auto_complete",this.value,"parent_state");'>
								  <option value=""><?php echo addslashes(t('Select city'));?> </option>
								  <?php echo makeOptionCity('',$posted['opt_city_id']) ?>
							</select>
							
                              <script type="text/javascript">
						$(document).ready(function() {
						  $("#opt_city").msDropDown();
						   $("#opt_city").hide();
						   $('#opt_city_msdd').css("background-image", "url(images/fe/select.png)");
						   $('#opt_city_msdd').css("background-repeat", "no-repeat");
						   $('#opt_city_msdd').css("width", "269px");
						   $('#opt_city_msdd').css("margin-top", "0px");
						   $('#opt_city_msdd').css("padding", "0px");
						    $('#opt_city_msdd').css("height", "38px");
						});
					
					</script>
					<div id="err_opt_city" class="err"><?php echo form_error('opt_city') ?></div>
					 <div class="spacer"></div>
					  <label><?php echo addslashes(t('Province'))?> <span>*</span> </label>
					  <div class="spacer"></div>
						  <div id="parent_state">
						  <select id="opt_state" name="opt_state" style="width:269px;" onchange='call_ajax_get_zipcode("ajax_change_zipcode_option",this.value,"<?php echo $posted['opt_city'] ?>","parent_zip");'>
							  <option value=""><?php echo addslashes(t('Select province'));?> </option>
							  <?php  echo makeOption($arr_province,$posted['opt_state']) ?>
						 </select>
						 </div>
					 
					  <script type="text/javascript">
						$(document).ready(function() {
						  $("#opt_state").msDropDown();
						   $("#opt_state").hide();
						   $('#opt_state_msdd').css("background-image", "url(images/fe/select.png)");
						   $('#opt_state_msdd').css("background-repeat", "no-repeat");
						   $('#opt_state_msdd').css("width", "269px");
						   $('#opt_state_msdd').css("margin-top", "0px");
						   $('#opt_state_msdd').css("padding", "0px");
						    $('#opt_state_msdd').css("height", "38px");
						});
					
					</script>
						<div id="err_opt_state" class="err"><?php echo form_error('opt_state') ?></div>
					 
                              <div class="spacer"></div>
                              <label><?php echo addslashes(t('Zipcode'))?> <span></span></label>
                              <div class="spacer"></div>
							  
                          <?php /*?>    <div class="textfell">
							  	<div id="parent_zip">
                                    <input type="text"  name="txt_zip" id="txt_zip" onkeyup="get_zipcode_name(this.value)" autocomplete="off" style="width:180px;"/>
									<input type="hidden" name="opt_zip" id="opt_zip" />
								</div>
								
								
                 <div class="suggestionsBox" id="suggestionsSearch" style="display: none; overflow-x:hidden; position:absolute;">
				 <div class="arrow_autocom"> &nbsp; </div>
				 <div class="suggestionList" id="autoSuggestionsListSearch" style="height:100px; overflow:auto;"> &nbsp; </div>
				 </div>
							
							  	
                              </div><?php */?>
							  
							  <!-- zipcode dropdown-->
							  <div id="parent_zip">
						  <select id="opt_zip" name="opt_zip" style="width:269px;" >
							  <option value=""><?php echo addslashes(t('Select zipcode'));?> </option>
							  <?php echo makeOption($arr_zipcode,$posted['opt_zip']) ?>
						 </select>
					   </div>
					   <script type="text/javascript">
						$(document).ready(function() {
						  $("#opt_zip").msDropDown();
						   $("#opt_zip").hide();
						   $('#opt_zip_msdd').css("background-image", "url(images/fe/select03.png)");
						   $('#opt_zip_msdd').css("background-repeat", "no-repeat");
						   $('#opt_zip_msdd').css("width", "269px");
						   $('#opt_zip_msdd').css("height", "38px");
						   $('#opt_zip_msdd').css("margin-top", "10px");
						   $('#opt_zip_msdd').css("padding", "0px");
						  
						});
					
					</script>
							  <!-- dropdown -->
							  <div id="err_opt_zip" class="err"><?php echo form_error('opt_zip') ?></div>
							   <div class="spacer"></div>
							   
                             <div class="mass"><?php //echo addslashes(t('Type 2 characters to get the Zipcode suggestion'))?> </div>
                              <label><?php echo addslashes(t('Material Provided By Buyer'))?> <span>*</span> </label>
                              <div class="spacer"></div>
                              <!--<div class="mass margin0">-->
							  <div class="mass05">
							  		<input name="chk_supply_material" type="radio" value="1" <?php echo (!empty($posted['chk_supply_material']) && $posted['chk_supply_material']==1 ? 'checked="checked"' : '')?>  /> 
                                    <?php echo addslashes(t('Yes'));?> &nbsp;
                                    <input name="chk_supply_material" type="radio" value="2" <?php echo (!empty($posted['chk_supply_material']) && $posted['chk_supply_material']==2 ? 'checked="checked"' : '')?>/>
                                    <?php echo addslashes(t('No'));?> &nbsp;
                                    <input name="chk_supply_material" type="radio" value="0"  <?php echo (empty($posted['chk_supply_material']) ? 'checked="checked"' : '')?> />
                                    <?php echo t('Doesn\'t Matter')?>
							  
                                  </div>
                              <div class="spacer"></div>
                        </div>
                        <div class="part_bottom"></div>
                  </div>
                  <!--box-->
                  <!--box-->
                  <div class="box02">
                        <div class="part_top"></div>
                        <div class="part_midd">
                              <label><?php echo addslashes(t('Description'))?> <span>*</span>  
                              <a href="javascript:void(0);" title="Your text" class="masterTooltip"><img src="images/fe/question_icon.gif" alt="" /></a>
					</label>
                              <div class="spacer"></div>
                               <textarea name="txt_description" class="txt_description" id="txt_description"><?php echo $posted['txt_description']?></textarea>
							   <div id="err_txt_description" class="err"><?php echo form_error('txt_description') ?></div>
							   <div class="spacer"></div>
							   
                              <label><?php echo addslashes(t('Keywords'))?> <span>*</span> <a href="javascript:void(0);" title="Your text" class="masterTooltip"><img src="images/fe/question_icon.gif" alt="" /></a> </label>
                              <div class="spacer"></div>
                              <div class="textfell">
                                    <input type="text"  name="txt_keyword" id="txt_keyword" class="tTip" title="<?php echo addslashes(t('keywords will help you appear more on search results.At least 4 keywords required.'))?>" value="<?php echo $posted['txt_keyword']?>" />
                              </div>
							  <div id="err_txt_keyword" class="err"><?php echo form_error('txt_keyword') ?></div>
									<div class="spacer"></div>
									
                              <div class="mass"><?php echo addslashes(t('For Example'));?> : </span><?php echo addslashes(t('windows, cleaning, glass'));?> </div>
                              <div class="spacer"></div>
                        </div>
                        <div class="part_bottom"></div>
                  </div>
                  <!--box-->
                  <!--box-->
                  <div class="box02 lastbox">
                        <div class="part_top"></div>
                        <div class="part_midd">
                              <label><?php echo addslashes(t('Quoting Period'))?> <span>*</span> </label>
                              <div class="spacer"></div>
                               <select name="opd_quoting_period_days" id="opd_quoting_period_days" style="width:269px;">
								<?php
								for($i=1;$i<=4;$i++)
								{
								?>
									  <option value="<?php echo $i;?>"><?php echo $i.' '.addslashes(t('Weeks'));?></option>
								<?php } ?>	  
							 </select>
									<div id="err_quote_period" class="err"></div>
                              <script type="text/javascript">
						$(document).ready(function() {
						  $("#opd_quoting_period_days").msDropDown();
						   $("#opd_quoting_period_days").hide();
						   $('#opd_quoting_period_days_msdd').css("background-image", "url(images/fe/select.png)");
						   $('#opd_quoting_period_days_msdd').css("background-repeat", "no-repeat");
						   $('#opd_quoting_period_days_msdd').css("width", "269px");
						   $('#opd_quoting_period_days_msdd').css("margin-top", "0px");
						   $('#opd_quoting_period_days_msdd').css("padding", "0px");
						    $('#opd_quoting_period_days_msdd').css("height", "38px");
						});
					
					</script>
                              <div class="spacer"></div>
                              <label><?php echo addslashes(t('Budget if any'))?> </label>
                              <div class="spacer"></div>
                              <div class="textfell02">
                                   <input type="text"  name="txt_budget_price" class="numeric_valid" id="txt_budget_price"  value="<?php echo $posted['txt_budget_price']?>" /> 
                              </div>
                              <label class="margintop">TL</label>
                              <div class="spacer"></div>
							
							  <div class="spacer"></div>
                              <h2><?php echo addslashes(t('Attach Pictures/Files'))?> </h2>
                              <div class="mass"><?php echo addslashes(t('Permitted file formats:')).$allow_ext;?> </div>
							  <div id="err_f_image" class="err"><?php echo form_error('f_image'); ?></div>
                              <!--<input type="file"  id="BrowserHidden" class="width05" />-->
							  <div id="attch_div">
							  <input type="file" name="f_image_0" id="f_image" class="width05"/>
							  </div>
                              <h3><a href="javascript:void(0)" class="blue_link" id="blue_link"><?php echo addslashes(t('Attach more file'));?></a></h3>
                              <!--<input class="small_button" value="Continue" type="button" />-->
							  <input  id="btn_job_post" class="small_button" type="button" value="<?php echo addslashes(t('Continue'));?>"/>
                              <div class="spacer"></div>
                        </div>
                        <div class="part_bottom"></div>
                  </div>
                  <!--box-->
                  <div class="spacer"></div>
            </div>
			</form>
			
            <div class="spacer"></div>
            <div class="bottom_part"></div>
      </div>