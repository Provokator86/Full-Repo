<script language="javascript">

$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>";//controller Path 
 

    
$('input[id^="btn_submit"]').each(function(i){
   $(this).click(function(){
       $("#reply_frm").submit();
   }); 
});    


///////////Submitting the form/////////
$("#reply_frm").submit(function(){
    var b_valid=true;
    var s_err="";
    //$("#div_err").hide("slow"); 

    
	 if($.trim($("#txt_comment").val())=="") 
		{
		   s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide comment'))?>.</strong></span></div>';
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
                  <h1><img src="images/fe/msg_board.png" alt="" /> <?php echo get_title_string(t('My Private Message Board'))?></h1>
                  <div class="shadow_big" >
                        <div class="right_box_all_inner" style="padding:0px;">
						
						<form name="reply_frm" id="reply_frm" action="<?php echo base_url().'private_message/private_message_details/'.encrypt($msg_id);?>" method="post">
                              <div class="rply_div">
                                    <h3><?php echo t('Comment')?></h3>
                                    <textarea name="txt_comment" id="txt_comment" cols="" rows=""></textarea>
                                    <br />
                                    <input name="submit" id="btn_submit" type="submit" class="button" value="<?php echo t('Submit')?>" />
                              </div>
						</form>	  
							  
							  
							  <?php
									if($pmb_details){
											
											foreach($pmb_details as $val)
										{ //echo $val['dt_reply_on'];
										$arr	=	explode('-',$val['dt_reply_on']);
										//print_r($d);
										$date	=	date('M d',mktime(0,0,0,$arr[0],$arr[1],$arr[2]));
										
										//echo $val['s_days_diff'];
																
									?>
                              <div class="email_content">
							   
                                    <div class="email_user_name"><img src="images/fe/star_white.png" alt="" /> <span><?php echo $val['s_sender_name'] ?></span> to <?php echo $val['s_receiver_name'] ?> </div>
                                    <div class="email_detail"><?php echo $date; ?> 
									<?php 
									if($val['s_days_diff'] > 0) {
									echo '('.$val['s_days_diff'].' ago)'; 
									} 
									?> 
									</div>
                                    <div class="spacer"></div>
                                    <div class="email_area"> <?php //echo $val['s_receiver_name'] ?>
                                          <p><?php echo ($val['s_content']) ?></p>
                                         <?php /*?> <?php echo t('Thanks')?><br />
                                          <?php echo $val['s_sender_name'] ?><?php */?> </div>
										  
                              </div>  
							  <?php }
									 } else {
										echo '<div class="email_content " style="padding:5px;">'.t('No record found').'</div>';
									} ?>                           
                             
                        </div>
                  </div>
                  <div class="spacer"></div>
            </div>
            <div class="spacer"></div>
      </div>