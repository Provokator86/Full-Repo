<script>
$(document).ready(function(){
	
///////////Submitting the form/////////
$("#btn_abuse").click(function(){	
    var b_valid=true;
    var s_err="";
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    var address = $.trim($("#txt_email").val());
	var contact_no = /^\d{10}$/;
	
	if($.trim($("#txt_fname").val())=="") //// For  name 
	{
		$("#err_txt_fname").text('<?php echo addslashes(t('Please provide your firstname'))?>').slideDown('slow');
		b_valid  =  false;
	}
    else
    {
        $("#err_txt_fname").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	
	
	if($.trim($("#txt_contact").val())== '')
	{
		$("#err_txt_contact").text('<?php echo addslashes(t('Please provide your contact number'))?>').slideDown('slow');
		b_valid  =  false;
	} 
	else if(contact_no.test($.trim($("#txt_contact").val())) == false) 
	{
		$("#err_txt_contact").text('<?php echo addslashes(t('Please provide 10 digit contact number'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else
    {
        $("#err_txt_contact").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	if(address== '')
	{
		$("#err_txt_email").text('<?php echo addslashes(t('Please provide your email'))?>').slideDown('slow');
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
	
	if($.trim($("#txt_msg").val())== '')
	{
		$("#err_txt_msg").text('<?php echo addslashes(t('Please provide message'))?>').slideDown('slow');
		b_valid  =  false;
	}
    else
    {
        $("#err_txt_msg").slideUp('slow').text('<?php echo addslashes(t(''))?>');    
        
    }	
	
    /////////validating//////
    if(!b_valid)
    {
       // $.unblockUI();  
        $("#div_err").html(s_err).show("slow");
    }
	else
	{
	$("#abuse_form").submit();
	}
    
    
}); 


});
</script>

<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
<div id="div_err">
<?php
	//echo validation_errors();
?>
</div>
<div class="top_part"></div>
<div class="midd_part height02">
	  <h2><?php echo addslashes(t('Abuse Report'))?></h2>
	  <div class="margin10"></div>
	  <p class="required"><span>*</span> <?php echo addslashes(t('Required field'))?></p>
	  <p><?php echo addslashes(t('Please take a moment and fill the form out below.'))?></p>
		  <div class="contact_box abuse_report">
			  <form id="abuse_form" action="<?php echo base_url().'abuse-report/' ?>" method="post"  >
			 <div class="lable04"><?php echo addslashes(t('First Name'))?><span>*</span></div> 
			 <div class="textfell05">
			 <input type="text" name="txt_fname" id="txt_fname" value="<?php echo $_POST["txt_fname"] ?>"/>
			 </div>
			 <div id="err_txt_fname" class="err" style="margin-left:195px;"><?php echo form_error('txt_fname'); ?></div>
			 <div class="spacer"></div>
		  <div class="lable04"><?php echo addslashes(t('Last Name'))?></div> 
			 <div class="textfell05">
			 <input type="text" name="txt_lname" id="txt_lname" value="<?php echo $_POST["txt_lname"] ?>"/>
			 </div>               
			 <div id="err_txt_lname" class="err" style="margin-left:195px;"><?php echo form_error('txt_lname'); ?></div>  
			 <div class="spacer"></div>
			   <div class="lable04"><?php echo addslashes(t('Contact No'))?><span>*</span></div> 
			 <div class="textfell05">
			 <input type="text" name="txt_contact" id="txt_contact" value="<?php echo $_POST["txt_contact"] ?>"/>
			 </div>
			 <div id="err_txt_contact" class="err" style="margin-left:195px;"><?php echo form_error('txt_contact'); ?></div>  
			 <div class="spacer"></div>
			   <div class="lable04"><?php echo addslashes(t('Email Address'))?> <span>*</span></div> 
			 <div class="textfell05">
			 <input type="text" name="txt_email" id="txt_email" value="<?php echo $_POST["txt_email"] ?>"/>
			 </div>
			 <div id="err_txt_email" class="err" style="margin-left: 195px; "><?php echo form_error('txt_email'); ?></div>
			  <div class="spacer"></div>
			   <div class="lable04"><?php echo addslashes(t('Please provide your comments'))?> <span>*</span></div> 
			   <textarea  name="txt_msg" id="txt_msg"  cols="45" rows="5"><?php echo $_POST["txt_msg"] ?></textarea>
			   <div id="err_txt_msg" class="err" style="margin-left: 195px; "><?php echo form_error('txt_msg'); ?></div>
			   <div class="spacer"></div>
				<div class="lable04"></div> 
				<!--<input  class="small_button" type="button" value="Submit"/>-->
				 <input id="btn_abuse" class="small_button" type="button" value="<?php echo addslashes(t('Submit'))?>"/>
				<div class="spacer"></div>
				</form>
		  </div>
                 
		  <div class="spacer"></div>
		  
	</div>
	<div class="spacer"></div>
	<div class="bottom_part"></div>
</div>