<script language="javascript">
$(document).ready(function(){
var g_controller="<?php echo $pathtoclass;?>";//controller Path  

$('.pwd').keypress(function( e ) {
    if(e.which === 32) 
        return false;
	});

///////////Submitting the form/////////
$("#btn_save").click(function(){
    var b_valid=true;
    var s_err="";
    $("#div_err").hide("slow"); 
	var new_pass = $("#txt_new_password").val();
	
	if($.trim($("#txt_password").val())=="")
	{
		$("#err_txt_password").text('<?php echo addslashes(t('Please provide your existing password'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else
    {
        $("#err_txt_password").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	if($.trim($("#txt_new_password").val())=="")
	{
		$("#err_txt_new_password").text('<?php echo addslashes(t('Please provide your new password'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else if(new_pass.length<6)
	{
		$("#err_txt_new_password").text("<?php echo addslashes(t('Password should be at least 6 characters'));?>").slideDown('slow');
		b_valid  =  false;
	}
	else if(new_pass.length>15)
	{
		$("#err_txt_new_password").text("<?php echo addslashes(t('Password should be maximum 15 characters'));?>").slideDown('slow');
		b_valid  =  false;
	}
	else
    {
        $("#err_txt_new_password").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	if($.trim($("#txt_confirm_password").val())=="")
	{
		$("#err_txt_confirm_password").text('<?php echo addslashes(t('Please provide confirm password'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else if($.trim($("#txt_new_password").val()) != $.trim($("#txt_confirm_password").val()))
	{
		$("#err_txt_confirm_password").text('<?php echo addslashes(t('Confirm password should be same as new password'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else
    {
        $("#err_txt_confirm_password").slideUp('slow').text('<?php echo addslashes(t(''))?>');
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

})
//});
</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>   
<div class="job_categories">
	<div class="top_part"></div>
    <div class="midd_part height02">
	  <div class="username_box">
	  <form name="contact_form" id="contact_form" action="<?php echo base_url().'buyer/change-password/'?>" method="post">
		<div class="right_box03">
			<?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
			<div id="div_err">
					
			</div>
			  <h4><?php echo addslashes(t('Change Password'))?> </h4>
			  <div class="div01">
				   
					<div class="required"><span>*</span> <?php echo addslashes(t('Required field'))?></div>
					<div class="spacer"></div>
				  
			  </div>
			  <div class="div02">
					
					<div class="lable06"><?php echo addslashes(t('Existing Password'))?> <span>*</span> </div>
					<div class="textfell10">
					<input type="password"  name="txt_password" id="txt_password"  class="pwd"/>
					</div>
					<div class="lable06"></div>
					<div id="err_txt_password" class="err"><?php echo form_error('txt_password'); ?></div>
					<div class="spacer"></div>
					
					
					 <div class="lable06"><?php echo addslashes(t('New Password'))?><span>*</span> </div>
					<div class="textfell10">
					<input type="password"  name="txt_new_password" id="txt_new_password" class="pwd" />
					</div>
					<div class="lable06"></div>
					<div id="err_txt_new_password" class="err"><?php echo form_error('txt_new_password'); ?></div>
					<div class="spacer"></div>
					
					
					<div class="lable06"><?php echo addslashes(t('Confirm New Password'))?><span>*</span> </div>
					<div class="textfell10">
					<input type="password"  name="txt_confirm_password" id="txt_confirm_password" class="pwd" />
					</div>
					<div class="lable06"></div>
					<div id="err_txt_confirm_password" class="err"><?php echo form_error('txt_confirm_password'); ?></div>
					<div class="spacer"></div>
					
					 
					<div class="lable06"> </div>
					<div class="textfell11">					
					<input  class="small_button margintop0 fist" type="button" id="btn_save" value="<?php echo addslashes(t('Save'))?>"/>
					</div>
					<div class="spacer"></div>
			  </div>
	   </div>
	  </form> 
			  
			<?php include_once(APPPATH."views/fe/common/buyer_left_menu.tpl.php"); ?>
			<div class="spacer"></div>
	  </div>
                  <div class="spacer"></div>
            </div>
	<div class="spacer"></div>
	<div class="bottom_part"></div>
</div>