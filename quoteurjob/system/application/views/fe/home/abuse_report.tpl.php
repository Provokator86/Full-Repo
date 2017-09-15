<script>
$(document).ready(function(){
	
	
///////////Submitting the form/////////
$("#detail_form").submit(function(){	
    var b_valid=true;
    var s_err="";
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    var address = $.trim($("#txt_email").val());
	
	if($.trim($("#txt_fname").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide firstname'))?>.</strong></span></div>';
		b_valid=false;
	}
	if($.trim($("#txt_lname").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide lastname'))?>.</strong></span></div>';
		b_valid=false;
	}
	if($.trim($("#txt_contact").val())== '')
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide contact number'))?>.</strong></span></div>';
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
	
	if($.trim($("#txt_msg").val())== '')
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide your comments'))?>.</strong></span></div>';
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
	/*$('#btn_reg').click(function(){
		$("#form_buyer_reg").submit();
	}); */

});
</script>
<div class="body_bg">
           <?php if(decrypt($loggedin['user_type_id'])==2){ ?>
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>
            </div>
          <?php } else if(decrypt($loggedin['user_type_id'])==1) { ?>
		  <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_buyer_search.tpl.php'); ?>
            </div>
			<?php } else {?>
			<div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>
            </div>
			<?php } ?>
          
            <div class="static_content">
                	<div id="div_err">
					<?php
						echo validation_errors();
					?>
					</div>
                        <h1><?php echo get_title_string(t('Abuse Report'))?> </span></h1>
                        <div class="shadow_big">
						<form id="detail_form" action="" method="post"  >
                              <div class="right_box_all_inner">
                                       <div class="left_txt"><span>*</span> <?php echo t('Required field')?></div>
                                    <div class="brd"><?php echo t('Please take a moment and fill the form out below.')?></div>
                                    
                                   <div class="lable01"><?php echo t('First Name')?><span class="red_text"> * </span>:</div>
                                    <div class="fld01">
                                          <input type="text" name="txt_fname" id="txt_fname" value="<?php echo $_POST["txt_fname"] ?>"/>
										  <?php /*?><span id="txt_fname_error" style="color: #FF0000;"><?php echo form_error('txt_fname'); ?></span><?php */?>
                                    </div>
                                    <div class="spacer"></div>
                                     <div class="lable01"><?php echo t('Last Name')?><span class="red_text"> * </span>:</div>
                                    <div class="fld01">
                                          <input type="text" name="txt_lname" id="txt_lname" value="<?php echo $_POST["txt_lname"] ?>"/>
										  <?php /*?><span id="txt_lname_error" style="color: #FF0000;"><?php echo form_error('txt_lname'); ?></span><?php */?>
                                    </div>
                                    <div class="spacer"></div>
                                     <div class="lable01"><?php echo t('Contact No')?><span class="red_text"> * </span>:</div>
                                    <div class="fld01">
                                          <input type="text" name="txt_contact" id="txt_contact" value="<?php echo $_POST["txt_contact"] ?>"/>
										  <?php /*?><span id="txt_contact_error" style="color: #FF0000;"><?php echo form_error('txt_contact'); ?></span><?php */?>
                                    </div>
                                    <div class="spacer"></div>
                                     <div class="lable01"><?php echo t('Email Address')?><span class="red_text"> * </span>:</div>
                                    <div class="fld01">
                                          <input type="text" name="txt_email" id="txt_email" value="<?php echo $_POST["txt_email"] ?>"/>
										  <?php /*?><span id="txt_email_error" style="color: #FF0000;"><?php echo form_error('txt_email'); ?></span><?php */?>
                                    </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"><?php echo t('Please provide your comments')?> <span class="red_text"> * </span>:</div>
                                    <div class="fld01">
                                          <textarea  name="txt_msg" id="txt_msg"  cols="45" rows="5" class="small_tx" style="width:290px; height:100px;"><?php echo $_POST["txt_msg"] ?></textarea>
                                    	  
                                    </div>
                                    <div class="spacer"></div>
                                 
                                    <div class="lable01"></div>
                                    <div class="fld01" style="padding-top:10px;">
                                          <input  class="button" type="submit" value="<?php echo t('Submit')?>"/>
                     
                                    </div>
                                    <div class="spacer"></div>
                              </div>
							  </form>
                        </div>
                
            </div>
        
      </div>
	  
<!--<script type="text/javascript">   

   
        function chk_page()
        {
            //alert($("#txt_name").val());
            var flag = 1;
            
            jQuery("#txt_fname_error").html('');
			jQuery("#txt_lname_error").html('');
            jQuery("#txt_email_error").html('');
            jQuery("#txt_msg_error").html('');
			jQuery("#txt_contact_error").html('');
            
            if(jQuery.trim(jQuery("#txt_fname").val())== '')
            {
                jQuery("#txt_fname_error").html('<br /><label  style="height: 2px;">&nbsp;</label>Please provide Firstname.');
                flag = 0;
            }   
			if(jQuery.trim(jQuery("#txt_lname").val())== '')
            {
                jQuery("#txt_lname_error").html('<br /><label  style="height: 2px;">&nbsp;</label>Please provide Lastname.');
                flag = 0;
            } 
			 
            
            var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            var address = jQuery.trim(jQuery("#txt_email").val());
            
            if(address== '')
            {
                jQuery("#txt_email_error").html('<br /><label  style="height: 2px;">&nbsp;</label>Please provide an Email.');
                flag = 0;
            }
            else if(reg.test(address) == false) 
            {
                jQuery("#txt_email_error").html('<br /><label  style="height: 2px;">&nbsp;</label>The Email field must contain a valid email address.');
                flag = 0;
            }
			if(jQuery.trim(jQuery("#txt_contact").val())== '')
            {
                jQuery("#txt_contact_error").html('<br /><label style="height: 2px;">&nbsp;</label>Please provide Contact No.');
                flag = 0;
            }
            if(jQuery.trim(jQuery("#txt_msg").val())== '')
            {
                jQuery("#txt_msg_error").html('<br /><label style="height: 2px;">&nbsp;</label>Please provide Your Comments.');
                flag = 0;
            }
			
            // alert(flag);
            if(flag==1)
                return true;
            
            return false;
        }
        
          
    
</script>	-->  
	  