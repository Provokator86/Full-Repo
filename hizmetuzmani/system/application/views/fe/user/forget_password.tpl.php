<script>
$(document).ready(function(){
	
	
///////////Submitting the form/////////
$("#forget_pass_form").submit(function(){	
    var b_valid=true;
    var s_err="";
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    var address = $.trim($("#txt_email").val());
	
	if($.trim($("#txt_user_name").val())=="") //// For  name 
	{
		$("#err_txt_user_name").text('<?php echo addslashes(t('Please provide username'))?>').slideDown('slow');
		b_valid  =  false;
	}
    else
    {
        $("#err_txt_user_name").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	
	if(address== '') //// For  name 
	{
		$("#err_txt_email").text('<?php echo addslashes(t('Please provide email'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else if(reg.test(address) == false) 
	{
		$("#err_txt_email").text('<?php echo addslashes(t('Please provide proper email'))?>').slideDown('slow');
		b_valid  =  false;
	}
    else
    {
        $("#err_txt_email").slideUp('slow').text('<?php echo addslashes(t(''))?>');
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
</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
<div class="top_part"></div>
<div class="midd_part height02">
<?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
	  <div class="spacer"></div>
	  <h2><?php echo addslashes(t('Forget Password'))?> </h2> 
	  <div class="margin10"></div>
	  <p class="required"><span>*</span> <?php echo addslashes(t('Required field'))?></p>
	  <div class="spacer"></div>	 
	  
	  <form name="forget_pass_form" id="forget_pass_form" action="<?php echo base_url().'forget-password' ?>" method="post">
	  <div class="registration_box">
	   
	  <div class="lable"><?php echo addslashes(t('Username'))?>: <span>*</span></div>
	  <div class="textfell06">
			<input type="text"  name="txt_user_name" id="txt_user_name" />
	  </div>
	   <div class="spacer"></div>
	  <div id="err_txt_user_name" class="err" style="margin-left:230px;"><?php echo form_error('txt_user_name') ?></div>	
	  
	  <div class="spacer"></div>
	   <div class="lable"><?php echo addslashes(t('Email'))?>:<span>*</span></div>
	  <div class="textfell06">
			<input type="text"  name="txt_email" id="txt_email"   />
	  </div>
	  <div class="spacer"></div>
	 <div id="err_txt_email" class="err" style="margin-left:230px;"><?php echo form_error('txt_email') ?></div>
	  
	  <div class="spacer"></div>
	  <div class="lable"></div>
	 <div class="textfell07">
			<input name="submit" type="submit" value="<?php echo t('Submit')?>"  class="small_button" />
	 </div>
	 
	  	<div class="spacer"></div>
	
			</div>
	  </form>
	  		
	   <div class="spacer"></div>
	  </div>
	<div class="spacer"></div>
	<div class="bottom_part"></div>	 
	 <div class="spacer"></div>
</div>