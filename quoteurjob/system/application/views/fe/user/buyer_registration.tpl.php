<script src="js/jquery/jquery.maskedinput-1.3.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){


	$("#txt_contact").mask("(999) 999-9999");
	//$("#txt_address").alphanumeric({});
///////////Submitting the form/////////
$("#form_buyer_reg").submit(function(){	

    var b_valid=true;
    var s_err="";
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;	
	var reg_contact =  /^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/;
	//var reg_contact = /^[(\[]?\d{3}[)-\.\] ]*\d{3}[-\. ]?\d{4}$/;
	var file_type = $("#f_image").val();
    var address = $.trim($("#txt_email").val());
	var con_address	=	$.trim($("#txt_con_email").val());
   // $("#div_err").hide("slow");     
   var pass	=	$.trim($("#txt_password").val());
   var con_pass	=	$.trim($("#txt_con_password").val());
	
	if($.trim($("#txt_name").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide name'))?>.</strong></span></div>';
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
	/*confirm email validation*/
	if(con_address== '')
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide confirm email'))?>.</strong></span></div>';
		b_valid=false;
	}
	else if(reg.test(con_address) == false) 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide valid confirm email'))?>.</strong></span></div>';
		b_valid=false;
	}
	else if(con_address != address)
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please give both email same'))?>.</strong></span></div>';
		b_valid=false;
	}
	else
	{
		//var txt_username = 	$.trim($("#txt_username").val());	
		$.ajax({
				type: "POST",
				async: false,
				url: base_url+'user/check_email_exist',
				data: "s_email="+address,
				success: function(msg){
				   if(msg=='error')
				   {
						s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Email already exist'))?></strong></span></div>';
						b_valid=false;						
				   } 
				   
				}
			});	
	}
	
	
	/*confirm email validation*/
	
	if($.trim($("#txt_username").val())== '')
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide username'))?>.</strong></span></div>';
		b_valid=false;
	}
	if($.trim($("#txt_username").val())!= '')
	{
		var txt_username = 	$.trim($("#txt_username").val());	
		$.ajax({
				type: "POST",
				async: false,
				url: base_url+'user/check_username_exist',
				data: "s_username="+txt_username,
				success: function(msg){
					if(msg)
					{
					   if(msg=='error_pattern')
					   {
							s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Plaese provide minimum six character for username'))?></strong></span></div>';
							b_valid=false;						
					   } 
					
					   if(msg=='error')
					   {
							s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Username already exist'))?></strong></span></div>';
							b_valid=false;						
					   } 
				   }
				}
			});	
			
		}	
	
	
	if(pass== '')
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide password'))?>.</strong></span></div>';
		b_valid=false;
	}
	else if(pass!='' && pass.length<6)
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide password with minimum 6 characters'))?>.</strong></span></div>';
		b_valid=false;
	}
	
	if(con_pass== '')
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide confirm password'))?>.</strong></span></div>';
		b_valid=false;
	}
	else if(pass != con_pass)
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide both password same'))?>.</strong></span></div>';
		b_valid=false;
	}
	
	if($.trim($("#txt_contact").val())== '')
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide contact number'))?>.</strong></span></div>';
		b_valid=false;
	} 
	else if(reg_contact.test($.trim($("#txt_contact").val())) == false) 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide valid contact number'))?>.</strong></span></div>';
		b_valid=false;
	}
	
	if($.trim($("#txt_address").val())== '')
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide address'))?>.</strong></span></div>';
		b_valid=false;
	}	
	
	if($.trim($("#opt_state").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please select province.'))?></strong></span></div>';
		b_valid=false;
	}
	if($.trim($("#opt_city").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please select city.'))?></strong></span></div>';
		b_valid=false;
	}
	if($.trim($("#txt_zip").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please select postal code.'))?></strong></span></div>';
		b_valid=false;
	}
	if($.trim($("#f_image").val())!="" && (!file_type.match(/(?:jpg|jpeg|png)$/)))
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please select proper image file type.'))?></strong></span></div>';
		b_valid=false;
	}
	
	if($.trim($("#recaptcha_response_field").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide security code.'))?></strong></span></div>';
		b_valid=false;
	}
	
	if($.trim($("#recaptcha_response_field").val())!="")
	{	
		var recaptcha_response_field = 	$.trim($("#recaptcha_response_field").val());	
		var recaptcha_challenge_field= 	$.trim($("#recaptcha_challenge_field").val());	
		$.ajax({
				type: "POST",
				async: false,
				url: base_url+'user/check_recapcha',
				data: "recaptcha_response_field="+recaptcha_response_field+'&recaptcha_challenge_field='+recaptcha_challenge_field,
				success: function(msg){
				   if(msg=='error')
				   {
						s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide valid capcha'))?></strong></span></div>';
						b_valid=false;
						//Recaptcha.reload();
				   } 
				   
				}
			});				
	}
	
	
	
	if(!$("input[name=i_accept_terms]:checkbox").is(":checkbox:checked"))
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please accept terms & conditions.'))?></strong></span></div>';
		b_valid=false;
	}
		
	
	
    /////////validating//////
    if(!b_valid)
    {
       // $.unblockUI();  
	   Recaptcha.reload();
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
	//alert(decrypt(state_id));
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
<script type="text/javascript">
    var RecaptchaOptions = {
        theme : 'custom'
    };
</script>

<div id="div_container">
      <div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_buyer_search.tpl.php'); ?>
            </div>
            <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
            <div class="static_content">
                  <div id="div_err">
                        <?php
						//show_msg("error");  
						echo validation_errors();
						//pr($posted);
					?>
                  </div>
                  <?php /*?><div class="shadow_medium" style="width:290px;">
                        <h1><?php echo t('Login')?> <span><?php echo t('Here')?></span></h1>
                        <div id="login" class="right_box_all_inner">
						<?php show_msg("error") ?>
						<form name="login_form" action="<?php echo base_url().'user/login/TVNOaFkzVT0'?>" method="post">
						<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
                              <div class="lable01" style="width:80px;"><?php echo t('Username')?><span class="red_text"> * </span></div>
                              <div class="fld01" style="width:165px;">
                                    <input type="text"  name="txt_user_name" value="<?php echo $posted['txt_user_name'] ?>"  style="width:162px;" autocomplete="off" />
                              </div>
                              <div class="spacer"></div>
                              <div class="lable01" style="width:80px;"><?php echo t('Password')?> <span class="red_text"> * </span></div>
                              <div class="fld01" style="width:165px;">
                                    <input type="password"  name="txt_password"  style="width:162px;" />
                              </div>
                              <div class="spacer"></div>
                              <div class="lable01" style="width:80px;"></div>
                              <div class="fld01" style="width:145px; padding-top:0px;"> <a href="<?php echo base_url().'user/forget_password'?>" class="red_link"><?php echo t('Forget Password')?></a> </div>
                              <div class="spacer"></div>
                              <div class="lable01" style="width:80px;"></div>
                              <div class="fld01" style="width:165px;">
                                    <input name="submit" type="submit" value="<?php echo t('Login')?>"  class="button" />
                              </div>
                              <div class="spacer"></div>
							  </form>
                        </div>
                  </div><?php */?>
                  <div class="shadow_big">
                        <h1><?php echo t('Register')?> </h1>
                        <div class="right_box_all_inner">
                              <form id="form_buyer_reg" action="<?php echo base_url().'user/registration/TVNOaFkzVT0'?>" method="post" enctype="multipart/form-data" >
                                    <div class="left_txt"><span>*</span> <?php echo t('Required field')?></div>
                                    <div class="brd"><?php echo t('Please take a moment and fill the form out below.')?></div>
                                    <div class="lable01"> <?php echo t('Name')?> <span class="red_text"> * </span></div>
                                    <div class="fld01" style="width:300px;">
                                          <input type="text" name="txt_name" id="txt_name" value="<?php echo $posted["txt_name"] ?>"/>
                                    </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"> <?php echo t('Email Address')?> <span class="red_text"> * </span></div>
                                    <div class="fld01" style="width:300px;">
                                          <input type="text" name="txt_email" id="txt_email" value="<?php echo $posted["txt_email"] ?>"/>
                                    </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"><?php echo t('Confirm Email Address')?> <span class="red_text"> *</span>: </div>
                                    <div class="fld01" style="width:300px;">
                                          <input type="text" name="txt_con_email" id="txt_con_email" value="<?php echo $posted["txt_con_email"] ?>"/>
                                    </div>
                                    <div class="spacer"></div>
                                    <br />
                                    <h3><?php echo t('Login Details')?> </h3>
                                    <div class="lable01"> <?php echo t('Username')?> <span class="red_text"> * </span></div>
                                    <div class="fld01" style="width:300px;">
                                          <input type="text"  name="txt_username" id="txt_username" value="<?php echo $posted["txt_username"] ?>" autocomplete="off" />
                                    </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"> <?php echo t('Password')?> <span class="red_text"> *</span> </div>
                                    <div class="fld01" style="width:300px;">
                                          <input type="password"  name="txt_password" id="txt_password" value="<?php echo $posted["txt_password"] ?>" autocomplete="off" />
                                    </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"> <?php echo t('Confirm Password')?> <span class="red_text"> * </span></div>
                                    <div class="fld01" style="width:300px;">
                                          <input type="password"  name="txt_con_password" id="txt_con_password" value="<?php echo $posted["txt_con_password"] ?>" autocomplete="off" />
                                    </div>
                                    <div class="spacer"></div>
                                    <br />
                                    <h3><?php echo t('Contact Details')?></h3>
                                    <div class="lable01"><?php echo t('Contact Number')?> <span class="red_text"> *</span>: </div>
                                    <div class="fld01" style="width:300px;">
                                          <input type="text" name="txt_contact" id="txt_contact" value="<?php echo $posted["txt_contact"] ?>"/>
                                          <br/>
                                          [<?php echo t('Example ').': '.'(999) 999-9999' ?>] </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"><?php echo t('Skype IM')?> &nbsp;</div>
                                    <div class="fld01" style="width:300px;">
                                          <input type="text" name="txt_skype" id="txt_skype" value="<?php echo $posted["txt_skype"] ?>"/>
                                    </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"><?php echo t('MSN IM')?> &nbsp;</div>
                                    <div class="fld01" style="width:300px;">
                                          <input type="text" name="txt_msn" id="txt_msn" value="<?php echo $posted["txt_msn"] ?>"/>
                                    </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"><?php echo t('YAHOO IM')?> &nbsp;</div>
                                    <div class="fld01" style="width:300px;">
                                          <input type="text" name="txt_yahoo" id="txt_yahoo" value="<?php echo $posted["txt_yahoo"] ?>"/>
                                    </div>
                                    <div class="spacer"></div>
                                    <br />
                                    <h3><?php echo t('Address')?> </h3>
                                    <div class="lable01"><?php echo t('Address')?> <span class="red_text"> *</span>: </div>
                                    <div class="fld01" style="width:300px;">
                                          <input type="text" name="txt_address" id="txt_address" value="<?php echo $posted["txt_address"] ?>"/>
                                    </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"><?php echo t('Province')?> <span class="red_text"> * </span></div>
                                    <div class="fld01" style="width:300px;">
                                          <select id="opt_state" name="opt_state" style="width:192px;" onchange='call_ajax_get_city("ajax_change_city_option_auto_complete",this.value,"parent_city");'>
                                                <option value=""><?php echo t('Select a province')?> </option>
                                                <?php echo makeOptionState('',decrypt($posted['opt_state'])) ?>
                                          </select>
                                          <!-- <script type="text/javascript">
								$(document).ready(function(arg) {
									$("#opt_state").msDropDown();
									$("#opt_state").hide();
								})
							</script>-->
                                    </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"><?php echo t('City')?> <span class="red_text"> * </span></div>
                                    <div class="fld01" style="width:300px;">
                                          <div id="parent_city">
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
                                    <div class="lable01"><?php echo t('Postal code')?> <span class="red_text"> * </span></div>
                                    <div class="fld01" style="width:300px;">
                                          <div id="parent_zip">
                                                <input type="text"  name="txt_zip" id="txt_zip" style="width:180px;" onkeyup="get_zipcode_name(this.value)" autocomplete="off"/>
                                                <?php /*?><select name="opt_zip" id="opt_zip" style="width:192px; ">
                                          <option value=""><?php echo t('Select postal code')?> </option>	
										  <?php echo makeOptionZip(' city_id="'.decrypt($posted['opt_city']).'"',decrypt($posted['opt_zip'])) ?>									 
                                    </select><?php */?>
                                                <input type="hidden" name="opt_zip" id="opt_zip" />
                                          </div>
										  
                                          <div class="suggestionsBox" id="suggestionsSearch" style="display: none; height:160px; overflow-x:hidden;  position:absolute;">
                                                <div class="arrow_autocom"> &nbsp; </div>
                                                <div class="suggestionList" id="autoSuggestionsListSearch"> &nbsp; </div>
                                          </div>
										  <?php echo t('Type 3 characters to get the Postal Code suggestion')?>
                                    </div>
                                    <div class="spacer"></div>
                                    <br />
                                    <h3><?php echo t('Buyer Profile')?></h3>
                                    <div class="lable01"><?php echo t('Profile Photo')?> &nbsp;</div>
                                    <div class="fld01" style="width:300px;">
                                          <input type="file" name="f_image" id="f_image" size="34"/>
                                          <br/>
                                          [<?php echo t('upload file type only jpg,jpeg,png') ?>]
                                          <?php  
								if(!empty($posted["f_image"]))
								{
									echo '<img src="'.base_url().'uploaded/user/thumb/thumb_'.$posted["f_image"].'" width="50" height="50"  border="0"/><br><br>';
									echo '<input type="hidden" name="h_image_name" id="h_image_name" value="'.$posted["f_image"].'" />';
								}								
								?>
                                    </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"><?php echo t('Security Code')?> <span class="red_text"> * </span></div>
                                    <div class="fld01" style="width:300px;">
                                          <!--<p><a href="javascript:Recaptcha.reload()" title="Regenerate Image"><img src="images/fe/captcha.png" alt="" /></a></p>
                                    <input type="text"  name="s_captcha" id="s_captcha" style="width:115px;"  />-->
                                          <div id="recaptcha_container">
                                                <label for="recaptcha_response_field"><?php echo t('Enter the two words below:')?></label>
                                                <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" class="text" />
                                                <div id="recaptcha_image" style="margin-top:5px; margin-bottom:5px; border:1px solid #D1D1D1;"></div>
                                                <!--<p>Choose captcha format: <a href="javascript:Recaptcha.switch_type('image');">Image</a> or <a href="javascript:Recaptcha.switch_type('audio');">Audio</a> </p>-->
                                                <input type="button" id="recaptcha_reload_btn" value="<?php echo t('Get new words')?>" onclick="Recaptcha.reload();" />
                                          </div>
                                          <script type="text/javascript" src="http://api.recaptcha.net/challenge?k=6LfC88gSAAAAAO2J7lo91pEgVje83SWy29brEsml">
									</script>
                                    </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"> </div>
                                    <div class="fld01" style="width:395px; line-height:25px;">
                                          <input name="i_inform_news" type="checkbox" value="1" <?php echo (!empty($posted["i_inform_news"]) && $posted["i_inform_news"]==1) ?'checked="checked"' : '';?> />
                                          <?php echo t('Please inform me about latest saving tips and important news.')?><br />
                                          <input name="i_accept_terms" id="i_accept_terms" type="checkbox" value="1" <?php echo (!empty($posted["i_accept_terms"]) && $posted["i_accept_terms"]==1) ?'checked="checked"' : '';?>/>
                                          <?php echo t('I accept the')?> <a href="#terms_condition_div" class="lightbox_main red_link"><?php echo t('Terms &amp; Conditions')?></a> <?php echo t('and the')?> <a href="#privacy_policy_div" class="red_link lightbox_main"><?php echo t('Privacy Policy')?> </a>. <span class="red_text">* </span> </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"></div>
                                    <div class="fld01" style="padding-top:10px;width:300px;">
                                          <input name="submit" id="reg_buton" type="submit" value="<?php echo t('Register')?>"  class="button" />
                                    </div>
                                    <div class="spacer"></div>
                                    <div style="display: none;">
                                          <div id="terms_condition_div" class="lightbox" style=" width:600px; ">
                                                <h1><?php echo $pre ?> <span style="color:#000000;"><?php echo $next ?> </span></h1>
                                                <div style="height:300px; overflow:auto;">
                                                      <?php foreach($terms_condition as $val) { ?>
                                                      <p><?php echo $val['s_full_description'] ?></p>
                                                      <?php } ?>
                                                </div>
                                          </div>
                                    </div>
                                    <div style="display: none;">
                                          <div id="privacy_policy_div" class="lightbox" style=" width:600px; ">
                                                <h1><?php echo $pre1 ?> <span style="color:#000000;"><?php echo $next1 ?> </span></h1>
                                                <div style="height:300px; overflow:auto;">
                                                      <?php foreach($policy as $val) { ?>
                                                      <p><?php echo $val['s_full_description'] ?></p>
                                                      <?php } ?>
                                                </div>
                                          </div>
                                    </div>
                              </form>
                        </div>
                  </div>
                  <div class="spacer"></div>
            </div>
      </div>
      <div class="spacer"></div>
</div>
