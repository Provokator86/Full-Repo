<script>
$(document).ready(function(){

	/*** generate upload file button ***/
		var max_allow_open = 5;
		var cnt = 1;
		$("#blue_link").click(function(){
			var str = '';			
			str += '<input type="file"  name="f_image_'+cnt+'" size="30"/>';
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
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide job title'))?>.</strong></span></div>';
		b_valid=false;
	}
	if($.trim($("#opd_category_id").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please select category'))?>.</strong></span></div>';
		b_valid=false;
	}
	if($.trim($("#opt_state").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please select province'))?>.</strong></span></div>';
		b_valid=false;
	}
	if($.trim($("#opt_city").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please select city'))?>.</strong></span></div>';
		b_valid=false;
	}
	if($.trim($("#opt_zip").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please select postal code'))?>.</strong></span></div>';
		b_valid=false;
	}
	if($.trim($("#txt_description").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please select description'))?>.</strong></span></div>';
		b_valid=false;
	}
	if($.trim($("#txt_keyword").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please select keyword'))?>.</strong></span></div>';
		b_valid=false;
	}
	if($.trim($("#opd_quoting_period_days").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please select quote period'))?>.</strong></span></div>';
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
					  // call_ajax_get_zipcode("ajax_change_zipcode_option",0,0,"parent_zip"); // to repopulate zip options

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
}
*/

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


</script>

<div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_buyer_search.tpl.php'); ?>
            </div>
			<?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
			<form name="frm_job_post" id="frm_job_post" method="post" action="<?php echo base_url().'job/job_post'?>" enctype="multipart/form-data">
            <div class="static_content">
				<div id="div_err">
				<?php
					echo validation_errors();
				?>
				</div>
                  <h1 style="float:left; margin-bottom:5px; "><?php echo get_title_string(t('Post a Job'))?> </h1>
                  <div style="float:right;"><?php echo t('Required fields are indicated with a')?> <span class="pink_txt">*</span></div>
                   <div class="spacer"></div>
                  <h4><?php echo t('Try to give tradesmen as much information as possible in order to get a reasonable amount of quality bids')?>.</h4>
                 <br />
                  <div class="shadow_medium" style="width:300px;">
                        <div class="right_box_all_inner" style="min-height:350px;">
                              <div class="lable02"><?php echo t('Job Title')?><span class="red_text"> * </span></div>
                              <div class="fld02">
                                    <input type="text"  name="txt_title" id="txt_title"  style="width:260px;" value="<?php echo $posted['txt_title']?>" />
                              </div>
                              <div class="lable02"><?php echo t('Category')?><span class="red_text"> * </span></div>
                              <div class="fld02">
                                   <select name="opd_category_id" id="opd_category_id" style="width:275px;">
                                          <option value=""><?php echo t('Category')?> </option>
										  <?php echo makeOptionCategory(" c.s_category_type='job' AND c.i_status=1 AND cc.i_lang_id =$i_lang_id",$posted['opd_category_id']) ?>
                                    </select>
                                   <!-- <script type="text/javascript">
										$(document).ready(function(arg) {
											$("#opd_category_id").msDropDown();
											$("#opd_category_id").hide();
										})
									</script>-->
									<div class="spacer">
								</div>
                              </div>
                              <h3><?php echo t('Job Location')?> </h3>
                               <div class="lable07"><?php echo t('Province')?> <span class="red_text"> * </span></div>
                              <div class="fld02" style="width:180px; float:left">
                                    <select id="opt_state" name="opt_state" style="width:192px;" onchange='call_ajax_get_city("ajax_change_city_option_auto_complete",this.value,"parent_city");'>
                                          <option value=""><?php echo t('Select a province')?> </option>
										  <?php echo makeOptionState('',decrypt($posted['opt_state'])) ?>
                                    </select>
                                    <!--<script type="text/javascript">
								$(document).ready(function(arg) {
									$("#opt_state").msDropDown();
									$("#opt_state").hide();
								})
							</script>-->
                              </div>
                              <div class="spacer"></div>
                                <div class="lable07"><?php echo t('City')?> <span class="red_text"> * </span></div>
                              <div class="fld02" style="width:180px; float:left">
							  <div id="parent_city">
                                   <!-- <select name="opt_city" id="opt_city" style="width:192px; ">
                                          <option value=""><?php //echo t('Select city')?> </option>
                                    </select>-->
                                    
                                     <select name="opt_city" id="opt_city" style="width:192px;" onchange='call_ajax_get_zipcode_list("ajax_change_zipcode_option_auto_complete",this.value,opt_state.value,"parent_zip");'>
                                                      <option value=""><?php echo t('Select city')?> </option>
                                                      <?php //echo makeOptionCity('',$posted['opt_city']) ?>
                                                </select>
							  </div>		
                              <!--<script type="text/javascript">
								$(document).ready(function(arg) {
									$("#opt_city").msDropDown();
									$("#opt_city").hide();
								})
							  </script>-->
                              </div>
                              <div class="spacer"></div>
                              <div class="lable07"><?php echo t('Postal code')?><span class="red_text"> * </span> </div>
                              <div class="fld02" style="width:180px; float:left">
							  <div id="parent_zip">
                              
                              <input type="text"  name="txt_zip" id="txt_zip" onkeyup="get_zipcode_name(this.value)" autocomplete="off" style="width:180px;"/>
                              
							  
							  
							  <?php   /*<select name="opt_zip" id="opt_zip" style="width:192px; ">
                                          <option value=""><?php echo t('Select postal code')?> </option>
                                    </select> */?>
                                    
                                    
                                    
                                    <input type="hidden" name="opt_zip" id="opt_zip" />
							  </div>
							  <!--<script type="text/javascript">
								$(document).ready(function(arg) {
									$("#opt_zip").msDropDown();
									$("#opt_zip").hide();
								})
							  </script>	-->	
                              
                               <div class="suggestionsBox" id="suggestionsSearch" style="display: none; overflow-x:hidden; position:absolute;">
								<div class="arrow_autocom"> &nbsp; </div>
								<div class="suggestionList" id="autoSuggestionsListSearch" style="height:130px; overflow:auto;"> &nbsp; </div>
			  
                              
                              
                              					  		
                              </div>
										  <?php echo t('Type 3 characters to get the Postal Code suggestion')?>
                                    </div>
                              
                              <div class="spacer"></div>
                            
                             
                              <h3>  <?php echo t('Material Provided By Buyer')?> <span class="red_text"> * </span></h3>
                              <div class="lable02">
                                    <input name="chk_supply_material" type="radio" value="1" <?php echo (!empty($posted['chk_supply_material']) && $posted['chk_supply_material']==1 ? 'checked="checked"' : '')?>  /> 
                                    <?php echo t('Yes')?> &nbsp;
                                    <input name="chk_supply_material" type="radio" value="2" <?php echo (!empty($posted['chk_supply_material']) && $posted['chk_supply_material']==2 ? 'checked="checked"' : '')?>/>
                                    <?php echo t('No')?> &nbsp;
                                    <input name="chk_supply_material" type="radio" value="0"  <?php echo (empty($posted['chk_supply_material']) ? 'checked="checked"' : '')?> />
                                    <?php echo t('Doesn\'t Matter')?></div>
                        </div>
                  </div>
                  <div class="shadow_medium" style="width:300px; margin-left:30px;">
                        <div class="right_box_all_inner" style="min-height:350px;">
                              <div class="lable02"><?php echo t('Description')?> <span class="red_text"> * </span></div>
                              <div class="fld02">
                                    <textarea name="txt_description" id="txt_description" cols="45" rows="5" style="width:260px; height:240px;"><?php echo $posted['txt_description']?></textarea>
                              </div>
                              <div class="lable02" style="width:270px;"><?php echo t('Keywords')?> <span class="red_text"> * </span></div>
                              <div class="fld02">
                                    <input type="text"  name="txt_keyword" id="txt_keyword" style="width:260px;" value="<?php echo $posted['txt_keyword']?>" /><br/>
									<span><?php echo t('For Example')?> : </span><?php echo t('windows, cleaning, glass')?>
                              </div>
                        </div>
                  </div>
                  <div class="shadow_medium" style="width:310px; float:right;">
                        <div class="right_box_all_inner" style="min-height:350px;">
                            <div style="min-height:300px;">  <div class="lable07" style="width:120px;"><?php echo t('Quoting Period')?> <span class="red_text"> * </span></div>
                              <div class="fld02" style="float:left">
                                    <select name="opd_quoting_period_days" id="opd_quoting_period_days" style="width:110px;">
									<?php
									for($i=1;$i<=60;$i++)
									{
									?>
                                          <option value="<?php echo $i;?>"><?php echo $i;?></option>
									<?php } ?>	  
                                    </select>
                                   <!-- <script type="text/javascript">
										$(document).ready(function(arg) {
											$("#opd_quoting_period_days").msDropDown();
											$("#opd_quoting_period_days").hide();
										})
									</script>-->
                                    <?php echo t('days')?></div>
                              <div class="spacer"></div>
                              <div class="lable07" style="width:130px;"><?php echo t('Budget if any')?>  <br /></div>
                              <div class="fld02" style="float:left; width:130px;">
                                   <input type="text"  name="txt_budget_price" id="txt_budget_price"  style="width:90px;"  value="<?php echo $posted['txt_budget_price']?>" /> <span class="black_txt"><?php echo t('CAD')?></span><br /> 
                                   </div>
                              <div class="spacer"></div>
                            
                              <h3 style="margin-bottom:0px;"><?php echo t('Attach Pictures/Files')?> </h3>
                              <div class="fld02"> <?php echo t('Permitted file formats:').$allow_ext;?> </div>
                              <div class="lable02" id="attch_div"> <input type="file" name="f_image_0" id="f_image"  size="30"/></div>
                              <div class="lable02"> <a href="javascript:void(0)" class="blue_link" id="blue_link"><?php echo t('Attach more file')?></a></div>
                              </div>
                             <div class="fld02"> <input  id="btn_job_post" class="button" type="submit" value="<?php echo t('Continue')?>"/></div>
                        </div>
                  </div>
                  <div class="spacer"></div>
            </div>
			 </form>
      </div>
	 