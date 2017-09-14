<script type="text/javascript">
// start document ready
$(document).ready(function() {


/******** validation for text box of GSM NUMBER, and FIRM PHONE to allow only numeric *******/
    
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




///////////Submitting the form/////////
$("#btn_save").click(function(){	
    var b_valid=true;
    var s_err="";	
	var contact_number       = /^(\d){7}$/;
	
	/*if($.trim($("#txt_contact").val())=="")
	{
		$("#err_txt_contact").text('<?php echo addslashes(t('Please provide conact number'))?>').slideDown('slow');
		b_valid  =  false;
	}	
    else
    {
        $("#err_txt_contact").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }*/
	if($.trim($("#txt_gsm").val())=="" || $.trim($("#opt_gsm").val())=="") //// For  name opt_city
	{
		$("#err_txt_gsm").text('<?php echo addslashes(t('Please provide contact number with code'))?>').slideDown('slow');
		b_valid  =  false;
	}
    else if(contact_number.test($("#txt_gsm").val())==false)
	{
	$("#err_txt_gsm").text('<?php echo addslashes(t('Please provide contact 7 digits number'))?>').slideDown('slow');
	b_valid  =  false;
	}
    else
    {
        $("#err_txt_gsm").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	
    /////////validating//////
    if(!b_valid)
    {
       // $.unblockUI();  
        $("#div_err").html(s_err).show("slow");
    }
    
	else
	{
	$("#contact_frm").submit();
	}
	return b_valid;
    
}); 

///////////end Submitting the form///////// 		


});
// end of document ready
</script>
<style>
.err{ margin-left:230px;}
</style>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
<div class="top_part"></div>
<div class="midd_part height02">
	  <div class="username_box">
		<div class="right_box03">
			<?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
			<div id="div_err">
					
			</div>	
		
		  <h4><?php echo addslashes(t('Contact Details'))?>  </h4>
		  <div class="div01">
				<p><?php echo addslashes(t('Please take a moment and fill the form out below'))?>.</p>
				<div class="required"><span>*</span> <?php echo addslashes(t('Required field'))?></div>
				<div class="spacer"></div>
			  
		  </div>
		  <form name="contact_frm" id="contact_frm" action="<?php echo base_url().'tradesman/contact-details/'?>" method="post">
		  <div class="div02">				
				<div class="lable06"><?php echo addslashes(t('Contact Number'))?> <span>*</span> </div>
				<div class="textfell10 nobg02">
				<select name="opt_gsm" id="opt_gsm" style="width:120px; float:left;">
				<option value=""><?php echo addslashes(t('Code'))?></option>
					<?php echo makeOptionGSMCode('',encrypt($gsm_code)) ?>
				
				</select>
				<script type="text/javascript">
	$(document).ready(function() {
	  $("#opt_gsm").msDropDown();
	   $("#opt_gsm").hide();
	   $('#opt_gsm_msdd').css("background-image", "url(images/fe/select-small03.png)");
	   $('#opt_gsm_msdd').css("background-repeat", "no-repeat");
	   $('#opt_gsm_msdd').css("width", "120px");
	   $('#opt_gsm_msdd').css("margin-top", "0px");
	   $('#opt_gsm_msdd').css("padding", "0px");
	   $('#opt_gsm_msdd').css("height", "38px");
	   $('#opt_gsm_msdd').css("margin-right", "10px");
	});

</script>
		  
		  <div class="smalltextfell">
		  	<input type="text"  name="txt_gsm" id="txt_gsm" value="<?php echo $gsm_no ?>" />
		  </div>
		  
				</div>
				<div class="spacer"></div>
				  <div id="err_txt_gsm" class="err"><?php echo form_error('txt_gsm') ?></div>
				<div class="spacer"></div>
				<!--<div class="textfell10">
				<input name="txt_contact" class="numeric_valid" id="txt_contact" type="text" value="<?php echo $contact_details['s_contact_no'] ?>" />
				</div>
				<div class="spacer"></div>
				  <div id="err_txt_contact" class="err"><?php echo form_error('txt_contact') ?></div>
				<div class="spacer"></div>-->
				
				<!--- social media options  -->
				 <div class="lable06"><?php echo addslashes(t('Social Media Options'))?></div>
				<div class="textfell10 nobg02">
				<select name="social_media" id="social_media" style="width:120px; float:left;">
				<option value="1" <?php if($contact_details['i_sm']==1) echo "selected='selected'" ?> title="images/fe/skype.png">Skype</option>
				<option value="2" <?php if($contact_details['i_sm']==2) echo "selected='selected'" ?>title="images/fe/msn.png">MSN</option>	
				<option value="3" <?php if($contact_details['i_sm']==3) echo "selected='selected'" ?> title="images/fe/facebook-small.png"> Facebook</option>
                <option value="4" <?php if($contact_details['i_sm']==4) echo "selected='selected'" ?> title="images/fe/gmail.png"> Gmail</option>
				
				</select>
				<script type="text/javascript">
	$(document).ready(function() {
	  $("#social_media").msDropDown();
	   $("#social_media").hide();
	   $('#social_media_msdd').css("background-image", "url(images/fe/select-small03.png)");
	   $('#social_media_msdd').css("background-repeat", "no-repeat");
	   $('#social_media_msdd').css("width", "120px");
	   $('#social_media_msdd').css("margin-top", "0px");
	   $('#social_media_msdd').css("padding", "0px");
	   $('#social_media_msdd').css("height", "38px");
	   $('#social_media_msdd').css("margin-right", "10px");
	});

</script>
		  
		  <div class="smalltextfell">
		  	<input type="text"  name="txt_sm" id="txt_sm" value="<?php echo $contact_details["s_sm"] ?>" />
		  </div>
		  
				</div>
				<div class="spacer"></div>
				<!--- social media option 2 -->				
				 <div class="lable06"></div>
				<div class="textfell10 nobg02">
				<select name="social_media2" id="social_media_2" style="width:120px; float:left;">
				<option value="" title="">Select</option>
				<option value="1" <?php if($contact_details['i_sm2']==1) echo "selected='selected'" ?> title="images/fe/skype.png">Skype</option>
				<option value="2" <?php if($contact_details['i_sm2']==2) echo "selected='selected'" ?>title="images/fe/msn.png">MSN</option>	
				<option value="3" <?php if($contact_details['i_sm2']==3) echo "selected='selected'" ?> title="images/fe/facebook-small.png"> Facebook</option>
                <option value="4" <?php if($contact_details['i_sm2']==4) echo "selected='selected'" ?> title="images/fe/gmail.png"> Gmail</option>
				
				</select>
				<script type="text/javascript">
	$(document).ready(function() {
	  $("#social_media_2").msDropDown();
	   $("#social_media_2").hide();
	   $('#social_media_2_msdd').css("background-image", "url(images/fe/select-small03.png)");
	   $('#social_media_2_msdd').css("background-repeat", "no-repeat");
	   $('#social_media_2_msdd').css("width", "120px");
	   $('#social_media_2_msdd').css("margin-top", "0px");
	   $('#social_media_2_msdd').css("padding", "0px");
	   $('#social_media_2_msdd').css("height", "38px");
	   $('#social_media_2_msdd').css("margin-right", "10px");
	});

</script>
		  
		  <div class="smalltextfell">
		  	<input type="text"  name="txt_sm2" id="txt_sm2" value="<?php echo $contact_details["s_sm2"] ?>" />
		  </div>
		  
				</div>				
				<!--- social media option 2 -->
				<div class="spacer"></div>
				<!--- social media option 2 -->				
				 <div class="lable06"></div>
				<div class="textfell10 nobg02">
				<select name="social_media3" id="social_media_3" style="width:120px; float:left;">
				<option value="" title="">Select</option>
				<option value="1" <?php if($contact_details['i_sm3']==1) echo "selected='selected'" ?> title="images/fe/skype.png">Skype</option>
				<option value="2" <?php if($contact_details['i_sm3']==2) echo "selected='selected'" ?>title="images/fe/msn.png">MSN</option>	
				<option value="3" <?php if($contact_details['i_sm3']==3) echo "selected='selected'" ?> title="images/fe/facebook-small.png"> Facebook</option>
                <option value="4" <?php if($contact_details['i_sm3']==4) echo "selected='selected'" ?> title="images/fe/gmail.png"> Gmail</option>
				
				
				</select>
				<script type="text/javascript">
	$(document).ready(function() {
	  $("#social_media_3").msDropDown();
	   $("#social_media_3").hide();
	   $('#social_media_3_msdd').css("background-image", "url(images/fe/select-small03.png)");
	   $('#social_media_3_msdd').css("background-repeat", "no-repeat");
	   $('#social_media_3_msdd').css("width", "120px");
	   $('#social_media_3_msdd').css("margin-top", "0px");
	   $('#social_media_3_msdd').css("padding", "0px");
	   $('#social_media_3_msdd').css("height", "38px");
	   $('#social_media_3_msdd').css("margin-right", "10px");
	});

</script>
		  
		  <div class="smalltextfell">
		  	<input type="text"  name="txt_sm3" id="txt_sm3" value="<?php echo $contact_details["s_sm3"] ?>" />
		  </div>
		  
				</div>				
				<!--- social media option 3 -->
				
				
				<div class="spacer"></div>				
				 <!--- social media options  -->
				 
				<div class="lable06"> </div>
				<div class="textfell11">
				<input class="small_button margintop0 fist" id="btn_save" type="button" value="<?php echo addslashes(t('Save'))?>" />
				</div>
				<div class="spacer"></div>
		  </div>
		   </form>               
						  
		</div>
		<?php include_once(APPPATH."views/fe/common/tradesman_left_menu.tpl.php"); ?>
		<div class="spacer"></div>
	  </div>
		<div class="spacer"></div>
	</div>
	<div class="spacer"></div>
	<div class="bottom_part"></div>
</div>