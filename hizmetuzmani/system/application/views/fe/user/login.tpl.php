<script>
$(document).ready(function(){
	
///////////Submitting the form/////////
$("#login_form").submit(function(){	
    var b_valid=true;
    var s_err="";	
    var pass	=	$.trim($("#txt_password").val());
	
	if($.trim($("#txt_user_name").val())=="") //// For  name 
	{
		$("#err_txt_user_name").text('<?php echo addslashes(t('Please provide username'))?>').slideDown('slow');
		b_valid  =  false;
	}
    else
    {
        $("#err_txt_user_name").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	
	if(pass== '') //// For  name 
	{
		$("#err_txt_password").text('<?php echo addslashes(t('Please provide password'))?>').slideDown('slow');
		b_valid  =  false;
	}
    else
    {
        $("#err_txt_password").slideUp('slow').text('<?php echo addslashes(t(''))?>');
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
	/*$('#btn_reg').click(function(){
		$("#form_buyer_reg").submit();
	}); */

});

</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
            <div class="top_part"></div>
	<div class="midd_part height02">
		<?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
		  <div class="spacer"></div>
		  <h2><?php echo addslashes(t('Login'))?> </h2> 
		  <div class="margin10"></div>
		  <p class="required"><span>*</span> <?php echo addslashes(t('Required field'))?></p>
		  <div class="spacer"></div>	
		  
		  <form name="login_form" id="login_form" action="<?php echo base_url().'user/login/TVNOaFkzVT0'?>" method="post">
				<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>">  	  
		  <div class="registration_box">  			                  
			  <div class="lable"><?php echo addslashes(t('Username'))?>: <span>*</span></div>
			  <div class="textfell06">
				   <input type="text" id="txt_user_name"  name="txt_user_name" value="<?php echo $posted['txt_user_name'] ?>"  autocomplete="off" />
			  </div>
			  <div class="spacer"></div>
			  <div id="err_txt_user_name" class="err" style="margin-left:230px;"><?php echo form_error('txt_user_name') ?></div>
			  
			  <div class="spacer"></div>
			   <div class="lable"><?php echo addslashes(t('Password'))?>:<span>*</span></div>
			  <div class="textfell06">
					<input type="password" id="txt_password"  name="txt_password" autocomplete="off" />
			  </div>
			   <div class="spacer"></div>
			  <div id="err_txt_password" class="err" style="margin-left:230px;"><?php echo form_error('txt_password') ?></div>
			  <div class="spacer"></div>
			   <div class="lable"></div>			  
					<p><a style="color:#F0650A; margin-left:5px;" href="<?php echo base_url().'forget-password'?>"><?php echo addslashes(t('Forgot your Password'))?></a></p>
			  <div class="spacer"></div>
			  <div class="lable"></div>
			 <div class="textfell07">
			
			 <input name="submit" type="submit" value="<?php echo t('Login')?>"  class="small_button" />
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