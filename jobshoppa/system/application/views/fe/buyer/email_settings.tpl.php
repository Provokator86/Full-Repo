<div id="banner_section">
    <?php
    include_once(APPPATH."views/fe/common/header_top.tpl.php");
    ?>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
    <?php
    include_once(APPPATH."views/fe/common/common_buyer_search.tpl.php");
    ?>
<!-- /SERVICES SECTION -->
<!-- CONTENT SECTION -->
<div id="content_section">
<div id="content">
    <?php
    //include_once(APPPATH."views/fe/common/message.tpl.php");
    ?>
     <div id="div_err">
         <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); 
            //show_msg("error");  
            echo validation_errors();
            //pr($posted);
        ?>
      </div>
        <div id="inner_container02">
            <div class="title">
                <h3><span>Email </span> Settings</h3>
            </div>
            <div class="clr"></div>
            <h6>&quot; You can control the emails you would like to receive by checking the boxes below &quot;</h6>
            <div class="clr"></div>
            <div id="account_container">
                <div class="account_left_panel">
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid" style="min-height:862px;">
                            <div id="form_box01">
                            <form name="email_setting_frm" id="email_setting_frm" action="" method="post">  
                                <div class="field05">
                                     <input name="chk_trade_place_quote" type="checkbox" value="tradesman_placed_quote" <?php if(!empty($email_key)) echo in_array('tradesman_placed_quote',$email_key) ? 'checked':''?> />
                                    New Quote Received</div>
                                <div class="field05">
                                   <input name="chk_trade_accept_reject_job" type="checkbox" value="tradesman_accepted_job_offer" <?php if(!empty($email_key)) echo in_array('tradesman_accepted_job_offer',$email_key) ? 'checked':''?>    />
                                    Service professional has accepted/rejected your offer</div>
                                <div class="field05">
                                    <input name="chk_trade_submit_msg" type="checkbox" value="tradesman_post_msg" <?php if(!empty($email_key)) echo in_array('tradesman_post_msg',$email_key) ? 'checked':''?>  />
                                    New private message received</div>
                                <div class="field05">
                                    <input name="chk_trade_asked_feedback" type="checkbox" value="tradesman_feedback" <?php if(!empty($email_key)) echo in_array('tradesman_feedback',$email_key) ? 'checked':''?>  />
                                    Job completion and feedback request</div>
                                <div class="field05">
                                    <input name="chk_admin_approved_reject_job" type="checkbox" value="admin_buyer_cancel_job" <?php if(!empty($email_key)) echo in_array('admin_buyer_cancel_job',$email_key) ? 'checked':''?>  />
                                    Your job has been approved/rejected by jobshoppa.</div>
								<div class="field05">
                                    <input name="chk_trade_review_rating" type="checkbox" value="tradesman_review_rating" <?php if(!empty($email_key)) echo in_array('tradesman_review_rating',$email_key) ? 'checked':''?>  />
                                    New review and rating received</div>	
                                <div class="field01">
                                    <input type="submit" value="Save" />
                                </div>
                                </form>
                            </div>
                        </div>
                        <div class="bot">&nbsp;</div>
                    </div>
                </div>
                <?php //
                    include_once(APPPATH."views/fe/common/buyer_left_menu.tpl.php");
                ?>
            </div>
            <div class="clr"></div>
        </div>         
        
        
        <div class="clr"></div>
</div>
</div>

