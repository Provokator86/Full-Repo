<script type="text/javascript">
// start document ready
jQuery(function($) {
$(document).ready(function() {
    
   
   

/******** validation for text box of GSM NUMBER, and FIRM PHONE to allow only numeric *******/
    
	$(".numeric_valid").keydown(function(e){
            if(e.keyCode==8 || e.keyCode==9 || e.keyCode==46)
            {
                return true; 
            }    
            if($(this).val().length>6) // check for more than 7 digit
            {
                return false;
            }
             
             return (e.keyCode>=48 && e.keyCode<=57 || e.keyCode>=96 && e.keyCode<=105) //Only 0-9 digits are allowed

    })  ;
    /******** validation for text box to allow only numeric *******/ 
	$('.pwd').keypress(function( e ) {
    if(e.which === 32) 
        return false;
	});
	
	

var trades_type = '';
var type_id = '';
// Change cpatcha image
	$("#change_image").click(function(){
		$("#captcha").attr('src','<?php echo base_url().'captcha'?>/index/'+Math.random());
	});
	
//// check whether firm / freelancer is selected 
$("input[name='i_trades_type']").click(function(){
    tradesman_type();
   
});


var tradesman_type  =   function()
{
    var id = $("input[name=i_trades_type]:checked").attr('id');
    var radio_id = id.split('_').pop();
    if(radio_id==2)
    {
        $("#freelancer_div").css('display','none');
        $("#firm_div").css('display','block');
		$("#tax_div").css('display','block');
    }
    if(radio_id==1)
    {
    $("#firm_div").css('display','none');
	$("#tax_div").css('display','none');  
    $("#freelancer_div").css('display','block');  
    }
}

tradesman_type();

//// end check whether firm / freelancer is selected



// Global variable
var username_valid  =   false ;
var email_valid     =   false ;
var captcha_valid   =   false ;

///////////Submitting the form/////////



$("#btn_reg").click(function(){	
   
    
    var b_valid=true;
    var s_err="";
	var reg_email     = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/; 
	var email_address = $("#txt_email").val();
	var confirm_email =	$("#txt_con_email").val();
	var pass		  = $("#txt_password").val();
	var conf_pass	  = $("#txt_con_password").val();	
	var file_type 	  = $("#f_address").val();
	
	 var contact_number       = /^(\d){7}$/;
	
	 trades_type   	  = $("input[name=i_trades_type]:checked").attr('id');	 
	 type_id 	  	  = trades_type.split('_').pop();
	
	
	if(!$("input[name='i_trades_type']:checked").val())
	{
		$("#err_i_trades_type").text('<?php echo addslashes(t('Please select one of tradesman type first'))?>').slideDown('slow');
		b_valid  =  false;
	}
	if(email_address=="") //// For  email 
	{
		$("#err_txt_email").text('<?php echo addslashes(t('Please provide your email'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else if(reg_email.test(email_address) == false)
	{
		$("#err_txt_email").text('<?php echo addslashes(t('Please provide proper email'))?>').slideDown('slow');
		b_valid  =  false;
	}
    else
    {
        $("#err_txt_email").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	if(confirm_email=="") //// For  email 
	{
		$("#err_txt_con_email").text('<?php echo addslashes(t('Please provide your confirm email'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else if(reg_email.test(confirm_email) == false)
	{
		$("#err_txt_con_email").text('<?php echo addslashes(t('Please provide proper confirm email'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else if(confirm_email != email_address)
	{
		$("#err_txt_con_email").text('<?php echo addslashes(t('Please provide confirm email same as your email'))?>').slideDown('slow');
		b_valid  =  false;
	}
    else
    {
        $("#err_txt_con_email").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }	
	
	/* START LOGIN DETAILS VALIDATION */
	if($.trim($("#txt_username").val())=="") //// For  username 
	{
		$("#err_txt_username").text('<?php echo addslashes(t('Please provide your username'))?>').slideDown('slow');
		b_valid  =  false;
	}
    else
    {
        $("#err_txt_username").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	if(pass=="") //// For  name 
	{
		$("#err_txt_password").text('<?php echo addslashes(t('Please provide your password'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else if(pass.length<6)
	{
		$("#err_txt_password").text("<?php echo addslashes(t('Password should be at least 6 characters'));?>").slideDown('slow');
		b_valid  =  false;
	}
	else if(pass.length>15)
	{
		$("#err_txt_password").text("<?php echo addslashes(t('Password should be maximum 15 characters'));?>").slideDown('slow');
		b_valid  =  false;
	}
    else
    {
        $("#err_txt_password").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	if(conf_pass=="") //// For  name 
	{
		$("#err_txt_con_password").text('<?php echo addslashes(t('Please provide your confirm password'))?>').slideDown('slow');
		b_valid  =  false;
	}
    else
    {
        $("#err_txt_con_password").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
    if(pass!=conf_pass)
    {
        $("#err_txt_con_password").text('<?php echo addslashes(t('Please both password should match'))?>').slideDown('slow');
        b_valid  =  false;
        
    }
    else
    {
        $("#err_txt_con_password").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	
	/* END LOGIN DETAILS VALIDATION  */
	
	
	/* START ADDRESS DETAILS VALIDATION  */
	
	if($.trim($("#opt_city").val())=="") //// For  name opt_city
	{
		$("#err_opt_city").text('<?php echo addslashes(t('Please provide your city'))?>').slideDown('slow');
		b_valid  =  false;
	}
    else
    {
        $("#err_opt_city").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	if($.trim($("#opt_state").val())=="") //// For  name opt_city
	{
		$("#err_opt_state").text('<?php echo addslashes(t('Please provide your province'))?>').slideDown('slow');
		b_valid  =  false;
	}
    else
    {
        $("#err_opt_state").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	if($.trim($("#opt_zip").val())=="") //// For  name opt_city
	{
		$("#err_opt_zip").text('<?php echo addslashes(t('Please provide your zip code'))?>').slideDown('slow');
		b_valid  =  false;
	}
    else
    {
        $("#err_opt_zip").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	
	/* END ADDRESS DETAILS VALIDATION  */
	if($.trim($("#txt_trade_name").val())=="") //// For  name opt_city
	{
		$("#err_txt_trade_name").text('<?php echo addslashes(t('Please provide name'))?>').slideDown('slow');
		b_valid  =  false;
	}
    else
    {
        $("#err_txt_trade_name").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	
	if($.trim($("#txt_gsm").val())=="" || $.trim($("#opt_gsm").val())=="") //// For  name opt_city
	{
		$("#err_txt_gsm").text('<?php echo addslashes(t('Please provide gsm number'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else if(contact_number.test($("#txt_gsm").val())==false)
	{
	$("#err_txt_gsm").text('<?php echo addslashes(t('Please provide contact number properly'))?>').slideDown('slow');
	b_valid  =  false;
	}
    else
    {
        $("#err_txt_gsm").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	
	/* START CAPTCHA VALIDATION  */
	if($.trim($("#txt_captcha").val())=="") //// For  name opt_city
	{
		$("#err_txt_captcha").text('<?php echo addslashes(t('Please provide proper security code'))?>').slideDown('slow');
		b_valid  =  false;
	}
    else
    {
        $("#err_txt_captcha").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	
	/* END CAPTCHA VALIDATION  */
	
	/* FREELANCER VALIDATION */
	if(type_id == 1)
	{
		if($.trim($("#txt_ssn").val())=="") //// For  name opt_city
		{
			$("#err_txt_ssn").text('<?php echo addslashes(t('Please provide ssn number'))?>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#err_txt_ssn").slideUp('slow').text('<?php echo addslashes(t(''))?>');
		}
		
		/*if($.trim($("#f_address").val())=="") //// For  name opt_city
		{
			$("#err_f_address").text('<?php echo addslashes(t('Please upload your address proof'))?>').slideDown('slow');
			b_valid  =  false;
		}*/
		if($.trim($("#f_address").val())!="" && (!file_type.match(/(?:pdf|jpg|jpeg|png)$/)))
		{
			$("#err_f_address").text('<?php echo addslashes(t('Please upload proper address proof file'))?>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#err_f_address").slideUp('slow').text('<?php echo addslashes(t(''))?>');
		}
	}
	
	/* END FREELANCER VALIDATION */
	/* START FIRM VALIDATION */
	if(type_id == 2)
	{
		if($.trim($("#txt_firm_name").val())=="") //// For  name opt_city
		{
			$("#err_txt_firm_name").text('<?php echo addslashes(t('Please provide firm name'))?>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#err_txt_firm_name").slideUp('slow').text('<?php echo addslashes(t(''))?>');
		}
		
		if($.trim($("#txt_firm_phone").val())=="" || $.trim($("#opt_firm_phone").val())=="") //// For  name opt_city
		{
			$("#err_txt_firm_phone").text('<?php echo addslashes(t('Please provide firm phone number with code'))?>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#err_txt_firm_phone").slideUp('slow').text('<?php echo addslashes(t(''))?>');
		}
		if($.trim($("#ta_firm_add1").val())=="") //// For  name opt_city
		{
			$("#err_ta_firm_add1").text('<?php echo addslashes(t('Please provide firm address1'))?>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#err_ta_firm_add1").slideUp('slow').text('<?php echo addslashes(t(''))?>');
		}
		if($.trim($("#txt_tax_office").val())=="") //// For  name opt_city
		{
			$("#err_txt_tax_office").text('<?php echo addslashes(t('Please provide tax office name'))?>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#err_txt_tax_office").slideUp('slow').text('<?php echo addslashes(t(''))?>');
		}
		if($.trim($("#txt_tax_number").val())=="") //// For  name opt_city
		{
			$("#err_txt_tax_number").text('<?php echo addslashes(t('Please provide tax office number'))?>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#err_txt_tax_number").slideUp('slow').text('<?php echo addslashes(t(''))?>');
		}
	}
	
	/* END FIRM VALIDATION */
	 if(!$("input[name=i_accept_terms]:checkbox").is(":checkbox:checked"))
    {
        $("#err_i_accept_terms").text('<?php echo addslashes(t('Please accept our terms & conditions'))?>').slideDown('slow');
        b_valid  =  false;
    }
    else
    {
        $("#err_i_accept_terms").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	
	
    /////////validating//////
  
    
	if(b_valid && username_valid && email_valid && captcha_valid)
	{
	    $('form#form_trade_reg').submit();
	}
    else
    {
		$('html, body').stop().animate({
			scrollTop: 0 //160
		   }, 2000,'easeInOutExpo');
   
   		 $("#txt_captcha").val('');  
        $("#captcha").attr('src','<?php echo base_url().'captcha'?>/index/'+Math.random());  
		captcha_valid = false; 
    }
	return b_valid;
    
}); 

///////////end Submitting the form///////// 

	/************** START CHECK USER EXIST ************/ 
	$("#txt_username").blur(function(){
	var txt_username =     $.trim($(this).val());
	if(txt_username!="")
	{
			
			$.ajax({
					type: "POST",
					async: false,
					url: base_url+'ajax_fe/ajax_check_username_exist',
					data: "s_username="+txt_username,
					success: function(msg){
						if(msg)
						{
						   if(msg=='error_pattern')
						   {
								$("#err_txt_username").show().text("<?php echo addslashes(t('Username must be at least 5 characters'));?>");
								username_valid=false;                        
						   } 
						 
						   else if(msg=='error')
						   {
							   $("#err_txt_username").show().text("<?php echo addslashes(t('This Username already exist, Try again!'));?>");
								username_valid=false;                        
						   }
						   else
						   {
								$("#err_txt_username").hide();
								username_valid =  true;
						   } 
					   }
					}
				});
	}
});
	 /************** END CHECK USER EXIST ************/ 


	/************** START CHECK EMAIL EXIST ************/ 
	$("#txt_email").blur(function(){
	var txt_email =     $.trim($(this).val());
	
	if(txt_email!="")
	{
			
			$.ajax({
					type: "POST",
					async: false,
					url: base_url+'ajax_fe/ajax_check_email_exist',
					data: "s_email="+txt_email,
					success: function(msg){
						if(msg)
						{
						   if(msg=='error_pattern')
						   {
								$("#err_txt_email").show().text("<?php echo addslashes(t('Please provide a valid email address'))?>");
								email_valid =   false;                        
						   } 
						 
						   else if(msg=='error')
						   {
							   $("#err_txt_email").show().text("<?php echo addslashes(t('This Email already exist, Try again!'))?>");
								email_valid =   false;                        
						   }
						   else
						   {
								$("#err_txt_email").hide();
								email_valid =   true;
						   } 
					   }
					}
				});
	}
}) ;
	/************** END CHECK EMAIL EXIST ************/ 
	
	
	/************** START CHECK CAPTCHA ************/ 
	$("#txt_captcha").blur(function(){
	var txt_captcha =     $.trim($(this).val());
	if(txt_captcha!="")
	{
			var txt_captcha =     $.trim($("#txt_captcha").val());                
			$.ajax({
					type: "POST",
					async: false,
					url: base_url+'ajax_fe/ajax_check_captcha',
					data: "txt_captcha="+txt_captcha,
					success: function(msg){
				   if(msg=='error')
				   { 
						$("#err_txt_captcha").show().text("<?php echo addslashes(t('Please provide the correct security code'));?>");											 			
						captcha_valid=false;
						//Recaptcha.reload();
				   } 
				   else
				   {
					   $("#err_txt_captcha").hide();
					   captcha_valid    =   true;
				   }
					   
					}
				});                
		}	
		
});	

	/************** END CHECK CAPTCHA ************/ 	
			


});
});
// end of document ready

// Ajax call to populate province options
function call_ajax_get_province(ajaxURL,item_id,cngDv)
{
		jQuery.noConflict();///$ can be used by other prototype which is not jquery
		jQuery(function($) {
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
					   $('#opt_state_msdd').css("margin-left", "5px");
					   $('#opt_state_msdd').css("padding", "0px");
					   $('#opt_state_msdd').css("height", "38px");
					   

				   }   
				}
			});
			
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
					   $('#opt_zip_msdd').css("margin-left", "5px");
                       $('#opt_zip_msdd').css("padding", "0px");
                       $('#opt_zip_msdd').css("height", "38px");
				}
			});
	});	
}

</script>

<style>
.err{ margin-left:230px;}
.mass{ margin-left:230px; font-size:11px;}
</style>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
            <div class="top_part"></div>
			<div id="err">
			</div>
			 <!-- START OF DIV midd_part height02-->
            <div class="midd_part height02">
			<?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
			<div id="err">
			</div>
			<form action="" method="post" enctype="multipart/form-data" name="form_trade_reg" id="form_trade_reg">
                  <div class="spacer"></div>
                  <h2><?php echo addslashes(t('Tradesman Registration'))?> </h2> 
                  <div class="margin10"></div>
                  <p class="required"><span>*</span> <?php echo addslashes(t('Required field'))?></p>
                  <p><?php echo addslashes(t('Please take a moment and fill the form out below'))?>.</p>
                 
                  
                  <div class="registration_box">
                  <h5><?php echo addslashes(t('Membership Information'))?></h5>
                  <div class="lable"><?php echo addslashes(t('Email'))?>: <span>*</span></div>
                  <div class="textfell06">
					<input type="text" name="txt_email" id="txt_email" value="<?php echo $posted["txt_email"] ?>"/>
				  </div>
				  <div class="spacer"></div>
				  <div id="err_txt_email" class="err"><?php echo form_error('txt_email') ?></div>                  
                  <div class="spacer"></div>
                  <div class="lable"><?php echo addslashes(t('Confirm Email'))?>:<span>*</span></div>
                  <div class="textfell06">
					<input type="text" name="txt_con_email" id="txt_con_email" value="<?php echo $posted["txt_con_email"] ?>"/>
				  </div>
				  <div class="spacer"></div>
				  <div id="err_txt_con_email" class="err"><?php echo form_error('txt_con_email') ?></div>
                  
                  <div class="spacer"></div>
                   <div class="lable"><?php echo addslashes(t('Username'))?>: <span>*</span></div>
                  <div class="textfell06">
					<input type="text"  name="txt_username" id="txt_username" value="<?php echo $posted["txt_username"] ?>" autocomplete="off" />
				  </div>
				  <div class="spacer"></div>
				  <div id="err_txt_username" class="err"><?php echo form_error('txt_username') ?></div>
                  
                  
                  <div class="spacer"></div>
                   <div class="lable"><?php echo addslashes(t('Password'))?>: <span>*</span></div>
                  <div class="textfell06">
					<input type="password"  name="txt_password" id="txt_password" class="pwd" value="<?php echo $posted["txt_password"] ?>" autocomplete="off" />
				  </div>
				  <div class="spacer"></div>
				  <div id="err_txt_password" class="err"><?php echo form_error('txt_password') ?></div>
                  
                  
                  <div class="spacer"></div>
                   <div class="lable"><?php echo addslashes(t('Confirm Password'))?>: <span>*</span></div>
                  <div class="textfell06">
					<input type="password"  name="txt_con_password" id="txt_con_password" class="pwd" value="<?php echo $posted["txt_con_password"] ?>" autocomplete="off" />
				  </div>
				  <div class="spacer"></div>
				  <div id="err_txt_con_password" class="err"><?php echo form_error('txt_con_password') ?></div>
                  
                    <div class="spacer"></div>
                   <div class="lable"><?php echo addslashes(t('Tradesman Type'))?>:<span>*</span></div>
                  <div class="textfell07">
				  <input name="i_trades_type" id="i_trades_type_1" type="radio"  value="1" checked="checked" <?php if($posted['i_trades_type']==1) echo 'checked="checked"'; ?> /><?php echo addslashes(t('Freelancer'))?> 
				  <input name="i_trades_type" id="i_trades_type_2" type="radio" value="2" <?php if($posted['i_trades_type']==2) echo 'checked="checked"'; ?>/><?php echo addslashes(t('Firm'))?>
				  </div>
                  <div class="spacer"></div>
				  <div id="err_i_trades_type" class="err"><?php echo form_error('i_trades_type') ?></div>
                  
                  <div class="spacer"></div>
                  <div class="border"></div>

                  <h5><?php echo addslashes(t('Firm / Freelancer Information'))?> </h5>
                  <div class="spacer"></div>
                  
                  <div class="lable"><?php echo addslashes(t('Name'))?>:<span>*</span></div>
                  <div class="textfell06">
				<input type="text"  name="txt_trade_name" id="txt_trade_name" value="<?php echo $posted["txt_trade_name"] ?>" />
                  </div>
				  <div class="spacer"></div>
				  <div id="err_txt_trade_name" class="err"><?php echo form_error('txt_trade_name') ?></div>
                 
                  
                  <div class="spacer"></div>
                   <div class="lable"><?php echo addslashes(t('GSM Number'))?>:<span>*</span></div>
                 
				  <!-- <div class="textfell09">-->
				   <select id="opt_gsm" name="opt_gsm" style="width:120px;">
				   	<option value=""><?php echo addslashes(t('Code'))?></option>
					<?php echo makeOptionGSMCode('',$posted['opt_gsm']) ?>
				   </select>
				   <script type="text/javascript">
					$(document).ready(function() {
					  $("#opt_gsm").msDropDown();
					   $("#opt_gsm").hide();
					   $('#opt_gsm_msdd').css("background-image", "url(images/fe/select-small03.png)");
					   $('#opt_gsm_msdd').css("background-repeat", "no-repeat");
					   $('#opt_gsm_msdd').css("width", "120px");
					   $('#opt_gsm_msdd').css("margin-top", "5px");
					   $('#opt_gsm_msdd').css("padding", "0px");
					   $('#opt_gsm_msdd').css("height", "38px");
					   $('#opt_gsm_msdd').css("margin-right", "10px");
					   $('#opt_gsm_msdd').css("margin-left", "5px");
					});
				
				</script>
				   <!--</div>-->
				   
			   <div class="smalltextfell">
			 <input type="text"  name="txt_gsm" id="txt_gsm" class="numeric_valid"  value="<?php echo $posted["txt_gsm"] ?>" />
			  </div>
				  
				  <div class="spacer"></div>
				  <div id="err_txt_gsm" class="err"><?php echo form_error('txt_gsm') ?></div>
                  
                  <div class="spacer"></div>
                   <?php /*?><div class="lable">Skype IM:</div>
                   <div class="textfell06">
                        <input type="text" class="tTip" title="Please provide a daytime telephone number in case we cannot reach you by Skype IM."  name="txt_skype" id="txt_skype" value="<?php echo $posted["txt_skype"] ?>"/>	
                  </div><?php */?>
				  <div class="lable"><?php echo addslashes(t('Social Media Options'))?></div>
		   <!--START SOCIAL MEDIA OPTIONS -->
				<!--<div class="textfell10 nobg02">-->
				<select name="social_media" id="social_media" style="width:120px; float:left;">
				<option value="" ><?php echo addslashes(t('Select'))?></option>
				<option value="1" title="images/fe/skype.png"><?php echo addslashes(t('Skype'))?></option>
				<option value="2" title="images/fe/msn.png"><?php echo addslashes(t('MSN'))?></option>				
				</select>
		  <script type="text/javascript">
			$(document).ready(function() {
			  $("#social_media").msDropDown();
			   $("#social_media").hide();
			   $('#social_media_msdd').css("background-image", "url(images/fe/select-small03.png)");
			   $('#social_media_msdd').css("background-repeat", "no-repeat");
			   $('#social_media_msdd').css("width", "120px");
			   $('#social_media_msdd').css("margin-top", "5px");
			   $('#social_media_msdd').css("padding", "0px");
			   $('#social_media_msdd').css("height", "38px");
			   $('#social_media_msdd').css("margin-right", "10px");
			   $('#social_media_msdd').css("margin-left", "5px");
			});
		
		</script>
				  
		  <div class="smalltextfell">
		  <input type="text"  name="txt_sm" id="txt_sm" value="<?php echo $posted["txt_sm"] ?>" />
		  </div>          
           <!-- </div>-->
		   <!--END SOCIAL MEDIA OPTIONS -->
				  <div class="spacer"></div>
				  <!-- THIS DIV WILL APPEAR IF FIRM IS SELECTED -->
				  <div id="firm_div" class="firm_div" style="display:none;">
				   <div class="spacer"></div>
                   <div class="lable"><?php echo addslashes(t('Firm Name'))?>:<span> *</span></div>
                   <div class="textfell06">
                        <input type="text" name="txt_firm_name" id="txt_firm_name"  value="<?php echo $posted["txt_firm_name"] ?>"/>	
                  </div>
				  <div class="spacer"></div>
				  <div id="err_txt_firm_name" class="err"><?php echo form_error('txt_firm_name') ?></div>
                  
                  <div class="spacer"></div>
                   <div class="lable"><?php echo addslashes(t('Firm Telephone'))?>:<span>*</span></div>
                   
				   <!--<div class="textfell09">-->
				   <select id="opt_firm_phone" name="opt_firm_phone" style="width:120px;">
				   	<option value=""><?php echo addslashes(t('Code'))?></option>
					<?php echo makeOptionAreaCode('',$posted['opt_firm_phone']) ?>
				   </select>
				   <script type="text/javascript">
					$(document).ready(function() {
					  $("#opt_firm_phone").msDropDown();
					   $("#opt_firm_phone").hide();
					   $('#opt_firm_phone_msdd').css("background-image", "url(images/fe/select-small03.png)");
					   $('#opt_firm_phone_msdd').css("background-repeat", "no-repeat");
					   $('#opt_firm_phone_msdd').css("width", "120px");
					   $('#opt_firm_phone_msdd').css("margin-top", "5px");
					   $('#opt_firm_phone_msdd').css("padding", "0px");
					   $('#opt_firm_phone_msdd').css("height", "38px");
					   $('#opt_firm_phone_msdd').css("margin-right", "10px");
					   $('#opt_firm_phone_msdd').css("margin-left", "5px");
					});
				
				</script>				   
				   <!--</div>-->
				   
                   <div class="smalltextfell">
                    <input type="text" name="txt_firm_phone" id="txt_firm_phone" class="numeric_valid" value="<?php echo $posted["txt_firm_phone"] ?>"/>	
                  </div>
				   <div class="spacer"></div>
				  <div id="err_txt_firm_phone" class="err"><?php echo form_error('txt_firm_phone') ?></div>
                  
                  
                  <div class="spacer"></div>
                   <div class="lable"><?php echo addslashes(t('Firm Address1'))?>: <span>*</span></div>
                   <div class="textfell06">                   
				   <input type="text" name="ta_firm_add1" id="ta_firm_add1" value="<?php echo $posted["ta_firm_add1"] ?>"/>	
                   </div>
                  <div class="spacer"></div>
				  <div id="err_ta_firm_add1" class="err"><?php echo form_error('ta_firm_add1') ?></div>
                    
                  <div class="spacer"></div>
                   <div class="lable"><?php echo addslashes(t('Firm Address2'))?>:</div>
                   <div class="textfell06">                    
					<input type="text" name="ta_firm_add2" id="ta_firm_add2" value="<?php echo $posted["ta_firm_add2"] ?>"/>	
                  </div>
				  
				  <div class="spacer"></div>
                 
				  
				  </div>
				  
				   <!--END OF FIRM DIV  WHICH WILL APPEAR IF FIRM IS SELECTED -->
                  
                  <div class="spacer"></div>
                   <div class="lable"><?php echo addslashes(t('City'))?>:<span>*</span></div>
                   <select name="opt_city" id="opt_city" style="width:269px;" onchange='call_ajax_get_province("ajax_change_province_option_auto_complete",this.value,"parent_state");'>
				  <option value=""><?php echo addslashes(t('Select city'));?> </option>
				  <?php echo makeOptionCity('',$posted['opt_city']) ?>
			 	  </select>
			   <script type="text/javascript">

				$(document).ready(function() {
				  $("#opt_city").msDropDown();
				   $("#opt_city").hide();
				   $('#opt_city_msdd').css("background-image", "url(images/fe/select03.png)");
				   $('#opt_city_msdd').css("background-repeat", "no-repeat");
				   $('#opt_city_msdd').css("width", "269px");
				   $('#opt_city_msdd').css("height", "38px");
				   $('#opt_city_msdd').css("margin-top", "10px");
					$('#opt_city_msdd').css("margin-left", "5px");
				   $('#opt_city_msdd').css("padding", "0px");
				  
				});
			
			</script>
			<div class="spacer"></div>
			<div id="err_opt_city" class="err"><?php echo form_error('opt_city') ?></div>
                  
                  
                   <div class="spacer"></div>
                   <div class="lable"><?php echo addslashes(t('Province'))?>:<span>*</span></div>
                  <div id="parent_state">
				  <select id="opt_state" name="opt_state" style="width:269px;" onchange='call_ajax_get_zipcode("ajax_change_zipcode_option",this.value,"<?php echo $posted['opt_city'] ?>","parent_zip");'>
					  <option value=""><?php echo addslashes(t('Select province'));?> </option>
					  <?php  echo makeOption($posted['arr_province'],$posted['opt_state']) ?>
				 </select>
			   </div>
			   <script type="text/javascript">
				$(document).ready(function() {
				  $("#opt_state").msDropDown();
				   $("#opt_state").hide();
				   $('#opt_state_msdd').css("background-image", "url(images/fe/select03.png)");
				   $('#opt_state_msdd').css("background-repeat", "no-repeat");
				   $('#opt_state_msdd').css("width", "269px");
				   $('#opt_state_msdd').css("height", "38px");
				   $('#opt_state_msdd').css("margin-top", "10px");
					$('#opt_state_msdd').css("margin-left", "5px");
				   $('#opt_state_msdd').css("padding", "0px");
				  
				});
			
			</script>
			<div class="spacer"></div>
			<div id="err_opt_state" class="err"><?php echo form_error('opt_state') ?></div>
                  
                  
                  <div class="spacer"></div>
                   <div class="lable"><?php echo addslashes(t('Zipcode'))?>:<span>*</span></div>
                   <div id="parent_zip">
				  <select id="opt_zip" name="opt_zip" style="width:269px;" >
					  <option value=""><?php echo addslashes(t('Select zipcode'));?> </option>
					  <?php echo makeOption($posted['arr_zipcode'],$posted['opt_zip']) ?>
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
					$('#opt_zip_msdd').css("margin-left", "5px");
				   $('#opt_zip_msdd').css("padding", "0px");
				  
				});
			
			</script>
				  <div class="spacer"></div>
                  <div id="err_opt_zip" class="err"><?php echo form_error('opt_zip') ?></div>
                  
				  
				  <!-- TAX DIV -->
				  <div id="tax_div" class="tax_div">
				  <div class="spacer"></div>
				  <div class="lable"><?php echo addslashes(t('TAX Office Name'))?>:<span>*</span></div>
                   <div class="textfell06">
                     <input type="text" name="txt_tax_office" id="txt_tax_office" value="<?php echo $posted["txt_tax_office"] ?>"/>	
                  </div>
				  <div class="spacer"></div>
				  <div id="err_txt_tax_office" class="err"><?php echo form_error('txt_tax_office') ?></div>
                  
                  
                   <div class="spacer"></div>
                   <div class="lable"><?php echo addslashes(t('TAX Number'))?>:<span>*</span></div>
                   <div class="textfell06">
                    <input type="text" name="txt_tax_number" id="txt_tax_number" value="<?php echo $posted["txt_tax_number"] ?>"/>	
                  </div>
				  <div class="spacer"></div>
				  <div id="err_txt_tax_number" class="err"><?php echo form_error('txt_tax_number') ?></div>
				  <div class="spacer"></div>
				  </div>
                   <!-- TAX DIV -->
                  <!-- THIS DIV WILL APPEAR IF FREELANCER IS SELECTED -->
                  <div id="freelancer_div" class="freelancer_div" >
                   <div class="spacer"></div>
                   <div class="lable"><?php echo addslashes(t('SSN'))?>:<span>*</span></div>
                   <div class="textfell06">
                     <input type="text" name="txt_ssn" id="txt_ssn" value="<?php echo $posted["txt_ssn"] ?>"/>	
                  </div>
				  <div class="spacer"></div>
				  <div id="err_txt_ssn" class="err"><?php echo form_error('txt_ssn') ?></div>
                  
                   <div class="spacer"></div>
                   <div class="lable"><?php echo addslashes(t('Address Proof'))?>:<span></span></div>
                   <div class="textfell07">
                       <input type="file" name="f_address" id="f_address" class="brows"  />
                  </div> 
				   <div class="spacer"></div>
				  <div id="err_f_address" class="err"><?php echo form_error('f_address') ?></div>
				   <div class="spacer"></div>
				  <div class="mass">(<?php echo addslashes(t('Permitted file formats'))?>:jpg, png, pdf )</div>
                                 
                  <div class="spacer"></div>
				  </div>
				  <!-- THIS DIV WILL APPEAR IF FREELANCER IS SELECTED -->
				  <div class="spacer"></div>
			  <div class="lable"><?php echo addslashes(t('Profile Photo / Logo'))?> <span></span></div>
				 <div class="textfell07"> 
				  <input type="file" name="f_image" id="f_image" class="brows"  />
				  <br/>
			  [<?php echo addslashes(t('upload file type only jpg,jpeg,png')) ?>]
			  <?php  
				if(!empty($posted["f_image"]))
				{
					echo '<img src="'.base_url().'uploaded/user/thumb/thumb_'.$posted["f_image"].'"/></br></br>';
					echo '<input type="hidden" name="h_image_name" id="h_image_name" value="'.$posted["f_image"].'" />';
				}								
				?>
				 </div>
				 <div id="err_f_image" class="err"><?php echo form_error('f_image') ?></div>
				  
				  
				  <!-- CAPTCHA CODE -->
				  <div class="spacer"></div>
				  <div class="lable"><?php echo addslashes(t('Security Code'))?>  <span>*</span></div>
				 <div class="textfell06">	
				 <input id="txt_captcha" name="txt_captcha" type="text" />
				 </div>
				 <div class="spacer"></div>
				 <div id="err_txt_captcha" class="err"><?php echo form_error('txt_captcha') ?></div>
				 <div class="spacer"></div>
				  <div class="lable"></div>
				 <div class="textfell07">
				 
					<?php echo addslashes(t("Type the characters you see in the picture below"))?>.<br />
					<img src="<?php  echo base_url().'captcha'?>" id="captcha" />
					<a href="javascript:void(0);" id="change_image" >
						<img src="images/fe/ajax-refresh-icon.gif" alt="<?php echo addslashes(t('Change Text')) ?>" title="<?php echo addslashes(t('Change Text')) ?>" />
					</a><br /><br />
				  <div class="spacer"></div>
				 </div>
				  <div class="spacer"></div>
		   <!-- CAPTCHA CODE -->
				  <div class="lable"></div>
		   <div class="textfell07"> 
		   <!--<input type="checkbox" name="checkbox"  />-->
		   <input name="i_inform_news" type="checkbox" value="1" <?php echo (!empty($posted["i_inform_news"]) && $posted["i_inform_news"]==1) ?'checked="checked"' : '';?> />
		   <?php echo addslashes(t('Please inform me about latest saving tips and important news'))?>.
		
				</div>
		   <div class="spacer"></div>
			<div class="lable"></div>
		   <div class="textfell07"> 
			   <!--<input type="checkbox" name="checkbox" />-->
			   <input name="i_accept_terms" id="i_accept_terms" type="checkbox" value="1" <?php echo (!empty($posted["i_accept_terms"]) && $posted["i_accept_terms"]==1) ?'checked="checked"' : '';?>/>
				<?php echo addslashes(t('I accept the'))?> <a href="javascript:void(0);" onclick="show_dialog('photo_zoom02')" ><?php echo addslashes(t('Terms &amp; Conditions'))?></a> <?php echo addslashes(t('and the'))?> 
				<a href="javascript:void(0);" onclick="show_dialog('photo_zoom08')"><?php echo addslashes(t('Privacy Policy'))?></a> . *                        
			</div>
			<div id="err_i_accept_terms" class="err"><?php echo form_error('i_accept_terms') ?></div>
				 <div class="spacer"></div>
				  
				  
                  <div class="lable"></div>
                 <div class="textfell07">
				 <!--<input class="small_button" type="button" value="Register" />-->
				 <input name="btn_reg" id="btn_reg" type="button" value="<?php echo addslashes(t('Register'))?>"  class="small_button" />
				 </div>
                  <div class="spacer"></div>
                
                        </div>
                   <div class="spacer"></div>
				   </form>
                   <!-- End of form -->
                  </div>
				  <!-- END OF DIV midd_part height02-->
                      <div class="spacer"></div>
            <div class="bottom_part"></div>
                 
                 
                  <div class="spacer"></div>
                  </div>

<!--lightbox-->
<div class="lightbox05 photo_zoom02" style="width:600px; height:400px;">
      <div class="close">
	  <a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" />
	  </a></div>
      <h3 style="border-bottom:none;"><?php echo $terms_condition[0]['s_title'] ?></h3>
      <div class="htstory_box" style="border-bottom:none;">
            <p><?php echo $terms_condition[0]['s_desc_full'] ?> </p>
      </div>
</div>

<div class="lightbox05 photo_zoom08" style="width:600px; height:400px;">
      <div class="close">
	  <a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" />
	  </a></div>
      <h3 style="border-bottom:none;"><?php echo $privacy_policy[0]['s_title'] ?></h3>
      <div class="htstory_box" style="border-bottom:none;">
            <p><?php echo $privacy_policy[0]['s_desc_full'] ?> </p>
      </div>
</div>
<!--lightbox-->				  