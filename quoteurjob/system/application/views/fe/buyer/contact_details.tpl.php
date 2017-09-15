<script src="js/jquery/jquery.maskedinput-1.3.min.js" type="text/javascript"></script>
<script language="javascript">
//jQuery.noConflict();///$ can be used by other prototype which is not jquery
//jQuery(function($) {
$(document).ready(function(){
$("#txt_contact").mask("(999) 999-9999");
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
       $("#contact_form").submit();
	   //check_duplicate();
   }); 
});    


///////////Submitting the form/////////
$("#contact_form").submit(function(){
    var b_valid=true;
    var s_err="";
	var reg_contact =  /^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/;
    $("#div_err").hide("slow"); 

    
	 if($.trim($("#txt_contact").val())=="") 
		{
		   s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide contact number'))?>.</strong></span></div>';
			b_valid=false;
		}	
	else if(reg_contact.test($.trim($("#txt_contact").val())) == false) 
		{
			s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide valid contact number'))?>.</strong></span></div>';
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

})
//});
</script>

<div class="body_bg">
	
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_buyer_search.tpl.php'); ?>
            </div>
			<?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
				<div id="div_err">
			 		<?php
						show_msg("error");  
						echo validation_errors();
					?>
				</div>	
			
            <?php include_once(APPPATH.'views/fe/common/buyer_left_menu.tpl.php'); ?>
            <div class="body_right">

                        <h1><img src="images/fe/account.png" alt="" /> <?php echo get_title_string(t('Contact Details'))?> </h1>
                        <div class="shadow_big">
						    <div class="right_box_all_inner">
							  
							  <form name="contact_form" id="contact_form" action="<?php echo base_url().'buyer/set_contact_details/'?>" method="post">
                                    <div class="left_txt"><span>*</span><?php echo t('Required field')?></div>
                                    <div class="brd"><?php echo t('Please take a moment and fill the form out below.')?></div>
                                    <div class="lable01"><?php echo t('Contact Number')?><span class="red_text"> * </span></div>
                                    <div class="fld01">
                                          <input type="text"  name="txt_contact" id="txt_contact" value="<?php echo $contact_details['s_contact_no'] ?>" /><br/>
									[<?php echo t('Example ').': '.'(999) 999-9999' ?>]
                                    </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"><?php echo t('Skype IM')?>  &nbsp;  </div>
                                    <div class="fld01">
                                          <input type="text"  name="txt_skype" id="txt_skype"  value="<?php echo $contact_details['s_skype_id'] ?>" />
                                    </div>
                                    <div class="spacer"></div>   
                                    <div class="lable01"><?php echo t('YAHOO IM')?> &nbsp;  </div>
                                    <div class="fld01">
                                          <input type="text"  name="txt_yahoo" id="txt_yahoo" value="<?php echo $contact_details['s_yahoo_id'] ?>"   />
                                    </div>
                                    <div class="spacer"></div>
                                      <div class="lable01"><?php echo t('MSN IM')?>  &nbsp; </div>
                                    <div class="fld01">
                                          <input type="text"  name="txt_msn" id="txt_msn"  value="<?php echo $contact_details['s_msn_id'] ?>"   />
                                    </div>
                                    <div class="spacer"></div>
                                   
                           
                                    <div class="lable01"></div>
                                    <div class="fld01" style="padding-top:10px;">
                                          <input  class="button" type="button" name="btn_save" id="btn_save" value="<?php echo t('Save')?>"/>
                                          <input  class="button" type="button" name="btn_cancel" id="btn_cancel" value="<?php echo t('Cancel')?>"/>
                                    </div>
                                    <div class="spacer"></div>
									<form>
									
                              </div>
                        </div>
   
            </div>
            <div class="spacer"></div>
      </div>