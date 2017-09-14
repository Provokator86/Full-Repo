<script>
$(document).ready(function(){	
	
///////////Submitting the form/////////
$("#btn_contact").click(function(){
    var b_valid=true;
    var s_err="";
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    var address = $.trim($("#txt_email").val());	
	
	if($.trim($("#txt_name").val())=="") //// For  name 
	{
		$("#err_txt_name").text('<?php echo addslashes(t('Please provide your name'))?>').slideDown('slow');
		b_valid  =  false;
	}
    else
    {
        $("#err_txt_name").slideUp('slow').text('<?php echo addslashes(t(''))?>');
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
	
	if($.trim($("#txt_subject").val())== '')
	{
		$("#err_txt_subject").text('<?php echo addslashes(t('Please provide subject'))?>').slideDown('slow');
		b_valid  =  false;
	} 
    else
    {
        $("#err_txt_subject").slideUp('slow').text('<?php echo addslashes(t(''))?>');    
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
	$("#contact_form").submit();
	}
    
    return b_valid;
}); 


///////////end Submitting the form///////// 
	

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
		  <h2><?php echo addslashes(t('Contact Us'))?></h2>
		  <div class="margin10"></div>
		  <p class="required"><span>*</span> <?php echo addslashes(t('Required field'))?></p>
		  <p><?php echo addslashes(t('Please take a moment and fill the form out below'))?>.</p>
		  <div class="contact_box">
			  <div class="form_box">
			  <form id="contact_form" action="<?php echo base_url().'contact-us/' ?>" method="post" >
				 <div class="lable03"><?php echo addslashes(t('Name'))?> <span>*</span></div> 
				 <div class="textfell05">
				 	<input type="text" name="txt_name" id="txt_name" value="<?php echo $_POST["txt_name"] ?>" />	
				 </div>
				 <div class="spacer"></div>
                 <div id="err_txt_name" class="err" style="margin-left:72px;"><?php echo form_error('txt_name'); ?></div>
				 
				 <div class="spacer"></div>
			  	<div class="lable03"><?php echo addslashes(t('User Name'))?> </div> 
				 <div class="textfell05">
				 <input type="text"  name="txt_username" id="txt_username" value="<?php echo $_POST["txt_username"] ?>"  />
				 </div>              
				 <div class="spacer"></div>
				   <div class="lable03"><?php echo addslashes(t('Email'))?> <span>*</span></div> 
				 <div class="textfell05">
				 <input type="text" name="txt_email" id="txt_email" value="<?php echo $_POST["txt_email"] ?>"/>
				 </div>
				 <div class="spacer"></div>
                  <div id="err_txt_email" class="err" style="margin-left: 72px; "><?php echo form_error('txt_email'); ?></div>
				 <div class="spacer"></div>
				   <div class="lable03"><?php echo addslashes(t('Subject'))?> <span>*</span></div> 
				 <div class="textfell05">
				 <input type="text"  name="txt_subject" id="txt_subject" value="<?php echo $_POST["txt_subject"] ?>" />
				 </div>
				 <div class="spacer"></div>
                 <div id="err_txt_subject" class="err" style="margin-left: 72px; "><?php echo form_error('txt_subject'); ?></div>   
				  <div class="spacer"></div>
				   <div class="lable03"><?php echo addslashes(t('Message'))?> <span>*</span></div> 
				   <textarea  name="txt_msg" id="txt_msg"  cols="40" rows="5"><?php echo $_POST["txt_msg"] ?></textarea>
				   <div class="spacer"></div>
                   <div id="err_txt_msg" class="err" style="margin-left: 72px; "><?php echo form_error('txt_msg'); ?></div>  
				   <div class="spacer"></div>
					<div class="lable03"></div> 
					 <input  class="small_button" id="btn_contact" type="button" value="<?php echo addslashes(t('Submit'))?>"/>
				  	<!--<input  class="small_button" type="button" value="Submit"/>-->
				   <div class="spacer"></div>
			   </form>	   
			  </div>
		 
		  <div class="spacer"></div>
		  </div>
                  
            </div>
	<div class="spacer"></div>
	<div class="bottom_part"></div>
</div>
