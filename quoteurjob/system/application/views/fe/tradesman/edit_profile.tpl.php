<script type="text/javascript">
$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>";//controller Path 

$('input[id^="btn_cancel"]').each(function(i){
   $(this).click(function(){
       //$.blockUI({ message: 'Just a moment please...' });
       window.location.href=g_controller;
   }); 
});      
    
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
      //$.blockUI({ message: 'Just a moment please...' });
       $("#frm_edit_profile").submit();
	   //check_duplicate();
   }); 
});    

/*** generate category dropdown ***/
		var max_allow_open = parseInt(4-<?php echo $counter_cat ?>);
		
		var cnt = 1;
		
		$("#red_link").click(function(){
			var str = '';
			if(<?php echo $counter_cat ?>!=1)
			{
				cnt++;
			}
			
			str += '<select style="width:300px;margin-top:5px;" name="opd_category'+cnt+'" id="opd_category'+cnt+'"><option value="">select category</option>'+"<?php echo makeOptionCategory(" c.s_category_type='job' AND c.i_status=1 AND cc.i_lang_id =$i_lang_id",""); ?>"+'</select>';
			
			$("#parent_category").append(str);
			//$("#opd_category"+cnt).msDropDown();
			//$("#opd_category"+cnt).hide();			
			
			
			if(<?php echo $counter_cat ?>==1)
			{
				cnt++;
			}
			
			
			if(cnt>=max_allow_open)
			{
				$("#red_link").remove();
			}
		});
	/*** end generate category ***/
	
	
///////////Submitting the form/////////
$("#frm_edit_profile").submit(function(){	
    var b_valid=true;
    var s_err="";
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	
	var file_type = $("#f_image").val();
    var address = $.trim($("#txt_email").val());
	
	
	
	if($.trim($("#txt_name").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide name'))?>.</strong></span></div>';
		b_valid=false;
	}
	if($.trim($("#f_image").val())!="" && (!file_type.match(/(?:jpg|jpeg|png)$/)))
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please select proper image file type'))?> .</strong></span></div>';
		b_valid=false;
	}
	if(address== '')
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide email'))?>.</strong></span></div>';
		b_valid=false;
	}
	else if(reg.test(address) == false) 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide valid email'))?>.</strong></span></div>';
		b_valid=false;
	}	
	
	if($.trim($("#txt_address").val())== '')
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide address'))?>.</strong></span></div>';
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
	if($.trim($("#txt_about_me").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide about me'))?>.</strong></span></div>';
		b_valid=false;
	}
	if($.trim($("#txt_skills").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide skills'))?>.</strong></span></div>';

		b_valid=false;
	}
	if($.trim($("#txt_qualification").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide qualification'))?>.</strong></span></div>';
		b_valid=false;
	}
	if($.trim($("#txt_business_name").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide business name'))?>.</strong></span></div>';
		b_valid=false;
	}
	if($.trim($("#opd_category0").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please select category'))?>.</strong></span></div>';
		b_valid=false;
	}	
	
	/*if(!$("input[name=i_accept_terms]:checkbox").is(":checkbox:checked"))
	{
		s_err +='<div class="error"><span class="left"><strong>Please accept terms & conditions.</strong></span></div>';
		b_valid=false;
	}	*/
    /////////validating//////
    if(!b_valid)
    {
       // $.unblockUI();  
        $("#div_err").html(s_err).show("slow");
    }
    
    return b_valid;
}); 


///////////end Submitting the form///////// 
	/*$('#btn_reg').click(function(){
		$("#form_buyer_reg").submit();
	}); */

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


</script>


<div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>
            </div>
			<?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
			<div id="div_err">
			 		<?php
						show_msg("error");  
						echo validation_errors();
					?>
				</div>	
            <?php include_once(APPPATH.'views/fe/common/tradesman_left_menu.tpl.php'); ?>
			
			<form name="frm_edit_profile" id="frm_edit_profile" enctype="multipart/form-data" action="<?php echo base_url().'tradesman/edit_profile'?>" method="post">
            <div class="body_right">
                  <h1><img src="images/fe/account.png" alt="" /> <?php echo get_title_string(t('Edit My Profile'))?></h1>
                 <div class="shadow_big"> <div class="right_box_all_inner">
				 
				 
                               <div class="left_txt"><span>*</span> <?php echo t('Required field')?></div>
                                    <div class="brd"><?php echo t('Please take a moment and fill the form out below.')?></div>
                                    
                                    <div class="lable01"> <?php echo t('Name')?><span class="red_text"> * </span></div>
                                    <div class="fld01">
                                          <input type="text"  name="txt_name" id="txt_name" value="<?php echo $info['s_name']; ?>" />
                                    </div>
                                    <div class="spacer"></div>
                                 
                                 
                                    <div class="lable01"><?php echo t('Email')?> <span class="red_text"> * </span></div>
                                    <div class="fld01">
                                          <input type="text"  name="txt_email" id="txt_email"  value="<?php echo $info['s_email'] ?>"  />
                                    </div>
                                    <div class="spacer"></div>
                                     <br />
                              <h3><?php echo t('Address')?> </h3>
                                  
                                    <div class="lable01"><?php echo t('Address')?> <span class="red_text"> * </span></div>
                                    <div class="fld01">
                                          <textarea  name="txt_address" id="txt_address"  cols="45" rows="5" style="width:290px; height:100px;"><?php echo $info['s_address'] ?></textarea>
										  
                                    </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"><?php echo t('Province')?> <span class="red_text"> * </span></div>
                                    <div class="fld01">
                                          <select id="opt_state" name="opt_state" style="width:192px;" onchange='call_ajax_get_city("ajax_change_city_option_auto_complete",this.value,"parent_city");'>
                                          <option value=""><?php echo t('Select a province')?> </option>
										   <?php echo makeOptionState('',$info['opt_state']) ?>
                                    </select>
                                    <!--<script type="text/javascript">
										$(document).ready(function(arg) {
											$("#opt_state").msDropDown();
											$("#opt_state").hide();
										})
									</script>-->
                                    </div>
                                    <div class="spacer"></div>
                                     <div class="lable01"><?php echo t('City')?><span class="red_text"> * </span></div>
                                    <div class="fld01">
                                         <div id="parent_city">
                                   
                                     <select name="opt_city" id="opt_city" style="width:192px;" onchange='call_ajax_get_zipcode_list("ajax_change_zipcode_option_auto_complete",this.value,opt_state.value,"parent_zip");'>
                                                      <option value=""><?php echo t('Select city')?> </option>
                                  <?php echo makeOptionCity(' state_id="'.$info['opt_state'].'" ',encrypt($info['opt_city'])) ?>                   
                                                </select>
									  </div>		
									 <!-- <script type="text/javascript">
										$(document).ready(function(arg) {
											$("#opt_city").msDropDown();
											$("#opt_city").hide();
										})
									  </script>-->
                              </div>
                              <div class="spacer"></div>
                              <div class="lable01"><?php echo t('Postal code')?> <span class="red_text"> * </span>  </div>
                              <div class="fld01">
                                     <div id="parent_zip">
                                           <input type="text"  name="txt_zip" id="txt_zip" onkeyup="get_zipcode_name(this.value)" autocomplete="off" style="width:180px;" value="<?php echo $info['s_postal_code'];?>"/>
                              
							  
												<!--<select name="opt_zip" id="opt_zip" style="width:192px; ">
													  <option value=""><?php// echo t('Select postal code')?> </option>-->
													  <?php //echo makeOptionZip(' state_id="'.$info['opt_state'].'" AND city_id="'.$info['opt_city'].'" ',$info['opt_zip']) ?>
												</select>
                                                  <input type="hidden" name="opt_zip" id="opt_zip" value="<?php echo encrypt($info['opt_zip']);?>" />
										  </div>
										  <!--<script type="text/javascript">
											$(document).ready(function(arg) {
												$("#opt_zip").msDropDown();
												$("#opt_zip").hide();
											})
										  </script>	-->	
                                          
                                           <div class="suggestionsBox" id="suggestionsSearch" style="display: none;  overflow-x:hidden; position:absolute;">
                                                <div class="arrow_autocom"> &nbsp; </div>
                                                <div class="suggestionList" id="autoSuggestionsListSearch" style="height:130px; overflow:auto;"> &nbsp; </div>
                              
                              
                                          	
                              </div></div>
                              <div class="spacer"></div>
                              <br />
                              <h3><?php echo t('Trade profile')?> </h3>
                        <div class="lable01"><?php echo t('Profile photo')?> &nbsp;  </div>
                              <div class="fld01">
                                     <?php if($info['s_user_image']) {   ?>
									<div class="photo" style="margin-bottom:10px;">
									<img src="<?php echo base_url().'uploaded/user/thumb/thumb_'.$info["s_user_image"]?>" alt="" width="100px" height="75px" />
									<?php 									
									echo '<input type="hidden" name="h_image_name" id="h_image_name" value="'.$info["s_user_image"].'" />';
									 ?>
									</div> 
									<?php } else {?>
                                          <div class="photo" style="margin-bottom:10px;"><img src="images/fe/img.png" alt="" /></div> 
									<?php } ?>	  
                                          <div class="spacer"></div>
                                          <input type="file" name="f_image" id="f_image" value="1" size="30"/><br/>
							  			[<?php echo t('upload file type only jpg,jpeg,png') ?>]
                              </div>
                              
							  
							  <div class="spacer"></div>
                              <div class="lable01"><?php echo t('Website')?> &nbsp;</div>
                              <div class="fld01" style="width:380px;">
                                    <input type="text"  name="txt_website" id="txt_website" value="<?php echo $info['s_website']; ?>"/>
                                    <a href="javascript:void(0);" style="margin-top:8px;" class="help"><img src="images/fe/help.png" alt="" /><span><?php echo t('Help text')?></span></a> </div>
                              <div class="spacer"></div>
                              <div class="lable01"><?php echo t('About me')?> <span class="red_text"> * </span></div>
                              <div class="fld01" style="width:380px;">
                                    <textarea name="txt_about_me" id="txt_about_me" cols="" rows="" style="width:285px; height:100px;"><?php echo $info['s_about_me'] ?></textarea>
                              </div>
                              <div class="spacer"></div>
                              <div class="lable01"><?php echo t('Skills')?> <span class="red_text"> * </span></div>
                              <div class="fld01" style="width:380px;">
                                    <input type="text"  name="txt_skills" id="txt_skills" value="<?php echo $info['s_skills']; ?>"/>
                              </div>
                              <div class="spacer"></div>
                              <div class="lable01"><?php echo t('Qualification')?> <span class="red_text"> * </span></div>
                              <div class="fld01" style="width:380px;">
                                    <textarea name="txt_qualification" id="txt_qualification" cols="" rows="" style="width:285px; height:100px;"><?php echo $info['s_qualification'] ?></textarea>
                              </div>
                              <div class="spacer"></div>
                              <br />
                              <h3><?php echo t('Job Details')?></h3>
                              <div class="lable01"><?php echo t('Business Name')?> <span class="red_text"> * </span></div>
                              <div class="fld01" style="width:380px;">
                                    <input type="text"  name="txt_business_name" id="txt_business_name" value="<?php echo $info['s_business_name'] ?>" />
                              </div>
                              <div class="spacer"></div>
                              <div class="lable01"><?php echo t('Category')?> <span class="red_text"> * </span></div>
                              <div class="fld01" style="width:380px;">
							  
							  <?php if(count($cat>0)){
									foreach($cat as $key=>$value){ 
									?>
                                    <div style="padding-bottom:5px;">									
									
										<div id="parent_category">
                                          <select name="opd_category<?php echo $key ?>" id="opd_category<?php echo $key ?>" style="width:300px;">
                                                <option value=""> <?php echo t('select category')?></option>
                                                <?php echo makeOptionCategory(" c.s_category_type='job' AND c.i_status=1 AND cc.i_lang_id =$i_lang_id",encrypt($value['id'])) ?>
                                          </select>
										 </div> 
									 
                                         <!-- <script type="text/javascript">
                                                $(document).ready(function(arg) {
                                                    $("#opd_category0").msDropDown();
                                                    $("#opd_category0").hide();
                                                })
                                            </script>-->
                                          <!--<a href="javascript:void(0);"><img src="images/fe/close.png" alt="" style="margin-top:8px;"/></a>-->
                                          <div class="spacer"></div>
                                    </div><?php } }?>
                                   <?php if($counter_cat<3) { ?>
                                    <a href="javascript:void(0);" class="red_link" id="red_link"><?php echo t('Add another Category')?> </a> 
									<?php } ?>
									</div>
                              <div class="spacer"></div>
                              <div class="lable01"><?php echo t('What payment types do you accept?')?> <span class="red_text"> * </span></div>
                              <div class="fld01" style="width:380px; padding-top:8px; ">
                                   
                              		 <input type="radio" name="RadioGroup1" value="1" id="RadioGroup1_0" <?php echo (!empty($info['i_payment_type']) && $info['i_payment_type']==1 ? 'checked="checked"' : '')?> />
                                    <?php echo t('Credit card')?> &nbsp;
                                    <input type="radio" name="RadioGroup1" value="2" id="RadioGroup1_1" <?php echo (!empty($info['i_payment_type']) && $info['i_payment_type']==2 ? 'checked="checked"' : '')?> />
                                    <?php echo t('Cheque')?> &nbsp;
                                    <input type="radio" name="RadioGroup1" value="0" id="RadioGroup1_2" <?php echo (empty($info['i_payment_type']) ? 'checked="checked"' : '')?> />
                                    <?php echo t('Cash')?> <a href="javascript:void(0);" class="help"><img src="images/fe/help.png" alt="" /><span><?php echo t('Help text')?></span></a></div>
							  <div class="spacer"></div>
                              <div class="lable01"><?php echo t('Would you like to Travel?')?> <span class="red_text"> * </span></div>
                              <div class="fld01" style="width:380px; padding-top:8px; ">
                                    <input type="radio" name="RadioGroup2" value="1" id="RadioGroup1_0" <?php echo (!empty($info['i_like_travel']) && $info['i_like_travel']==1 ? 'checked="checked"' : '')?> />
                                    <?php echo t('Yes')?> &nbsp;
                                    <input type="radio" name="RadioGroup2" value="0" id="RadioGroup1_1" <?php echo (empty($info['i_like_travel']) ? 'checked="checked"' : '')?> />
                                    <?php echo t('No')?> <a href="javascript:void(0);" class="help"><img src="images/fe/help.png" alt="" /><span><?php echo t('Help text')?></span></a> </div>
                              <div class="spacer"></div>
                              
                              
                              <div class="lable01"> </div>
                                    <div class="fld01" style="line-height:25px;">
                                          <input name="chk_newletter" id="chk_newsletter" type="checkbox" value="1" <?php echo (!empty($info["chk_newsletter"]) && $info["chk_newsletter"]==1) ?'checked="checked"' : '';?> />
                                         <?php echo t('I would like to receive Newsletter')?> </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"></div>
                              <div class="fld01" style="padding-top:10px;">
                                    <input  class="button" type="button" id="btn_save" value="<?php echo t('Save')?>"/>
                                    <input  class="button" type="button" id="btn_cancel" value="<?php echo t('Cancel')?>"/>
                              </div>
                              <div class="spacer"></div>
                              
                              
                        </div></div>
                  <div class="spacer"></div>
            </div>
            <div class="spacer"></div>
			</form>  
      </div>
	