 <script type="text/javascript">
                        $(document).ready(function() {
                            $('#btn_msg').click(function(){
                               
                                var b_valid =   true ;
                                if($.trim($('#ta_comment').val())=='')
                                {
                                    b_valid  =   false;
                                    $("#err_ta_comment").text('Message field can not be empty.').show('slow'); 
                                }
                               
                                if(b_valid)
                                {
                                    $("#frm_msg").submit();
                                    
                                }
                                
                            });
                        });
 </script>
<div class="job_categories">
            <div class="top_part"></div>
            <div class="midd_part height02">
                  <div class="username_box">
                        <div class="right_box03">
                          <?php include_once(APPPATH.'views/fe/common/message.tpl.php');  ?> 
                              <h4><?php echo addslashes(t('My Private Message Board')); ?></h4>
                              <div class="filter_option_box">
                                   <h3><?php echo addslashes(t('Comment')); ?></h3>
                                   <form name="frm_msg" id="frm_msg"  action="" method="post">
                              <textarea name="ta_comment" id="ta_comment" cols="" rows=""></textarea>
                              
                              
                              <div class="spacer"></div>
                              <span class="err" id="err_ta_comment" style="display: none;"></span>
                              <div class="spacer"></div>
                              
                              <input class="small_button" id="btn_msg" type="button" value="<?php echo addslashes(t('Submit')); ?>" />
                              </form>
                              </div>
                              <div class="div01 noboder">
                              <?php
                               if(!empty($pmb_details))
                               {
                              
                                   foreach($pmb_details as $val)
                                   {
                              ?>
                                    <div class="inner_box" <?php echo ($val['i_receiver_view_status']==0 && decrypt($loggedin['user_id'])==$val['i_receiver_id'])?'style="background: #FFF2E6"':''; ?>>
                                        <h2><?php echo $val['s_sender_name']; ?> <?php echo addslashes(t('to')); ?> <span><?php echo $val['s_receiver_name']; ?></span></h2>
                                        <div class="date"><?php echo $val['s_days_diff']; ?></div>
                                        <div class="spacer"></div>
                                        <!--<p>Asish, </p>
                                        <p>when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                                        <p>Thanks <br/>
    John </p>-->
                                        <p><?php echo $val['s_content']; ?></p>
                                        <div class="spacer"></div>
                                            </div>
                                         <?php         
                                   }
                               }
                              ?>
   
                               </div>
                              <div class="spacer"></div>
                              
                        </div>
                        <?php include_once(APPPATH."views/fe/common/buyer_left_menu.tpl.php"); ?>
                        <div class="spacer"></div>
                  </div>
                  <div class="spacer"></div>
            </div>
            <div class="spacer"></div>
            <div class="bottom_part"></div>
      </div>
