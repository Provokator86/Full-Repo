<script type="text/javascript">

// start document ready
jQuery(function($) {
$(document).ready(function() {
        
        $("#btn_msg").click(function(){
          
            var b_valid =   true ;
            
            if($.trim($("#txt_subject").val())=='')
            {
                $("#txt_subject").parent().next(".err").html('<strong>Please provide subject.</strong>').slideDown('slow');
                b_valid =   false ;
                
            }
            else
            {
                  $("#txt_subject").parent().next(".err").slideUp('slow').html('');
            }
            if($.trim($("#ta_message").val())=='')
            {
                $("#ta_message").next(".err").html('<strong>Please provide message.</strong>').slideDown('slow');
                b_valid =   false ;
            }
            else
            {
                $("#ta_message").next(".err").slideUp('slow').html(''); 
            }
            
            if(b_valid)
            {
                $("#frm_msg").submit();
            }
        });
    });
});
</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="container-box">
<?php include_once(APPPATH."views/fe/common/message.tpl.php"); ?>
<?php include_once(APPPATH."views/fe/common/account_left_menu.tpl.php"); ?>
                        <div class="right-part02">
                              <div class="text-container">
                                    <div class="inner-box03">
                                          <div class="page-name02 margin00">New Message</div>
                                          <div class="spacer">&nbsp;</div>
                                          
                                         <div class="message-box">
                                           <form action="" method="post" name="frm_msg" id="frm_msg"  >
                                         <label class="label03">To</label>
                                         <label class="label02">Property <span> <br/><?php echo $posted['s_property_name'];; ?></span></label>
                                         <div class="spacer">&nbsp;</div>
                                         <div class="big-text-fell02"><input name="txt_receiver_name" id="txt_receiver_name" value="<?php echo $posted['txt_receiver_name']; ?>" readonly="readonly" type="text" /></div>
                                         
                                         
                                         <label class="label03">Subject</label>
                                         <br class="spacer" />
                                         <div class="big-text-fell02">
                                         <input name="txt_subject" id="txt_subject" type="text" value="<?php echo $posted['txt_subject'];  ?>" />
                                         
                                         </div>
                                           <div class="err" style="margin-bottom: 15px; margin-top: -5px;"></div>
                                           <div class="spacer"></div>
                                         
                                         <textarea name="ta_message" id="ta_message" cols="" rows=""><?php echo $posted['ta_message'];  ?></textarea>
                                         <div class="err" style="margin-top: -5px;"></div>
                                         
                                         <input type="hidden" name="h_booking_id" id="h_booking_id" value="<?php echo $posted['s_booking_id'] ; ?>">
                                         <input type="hidden" name="h_receiver_id" id="h_receiver_id" value="<?php echo $posted['h_receiver_id'] ; ?>">
                                         <input type="hidden" name="h_property_name" id="h_property_name" value="<?php echo $posted['s_property_name'] ; ?>">
                                        <div class="spacer"></div> 
                                         <input class="button-blu" value="Send" id="btn_msg" type="button" />
                                         </form>
                                         
                                         </div> 

                                         
                                          <div class="spacer">&nbsp;</div>
                                    </div>
                              </div>
                        </div>
                        <br class="spacer" />
                  </div>
