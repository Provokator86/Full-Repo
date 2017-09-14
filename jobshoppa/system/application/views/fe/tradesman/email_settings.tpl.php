<div id="banner_section">
    <?php
    include_once(APPPATH."views/fe/common/header_top.tpl.php");
    ?>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
    <?php
    include_once(APPPATH."views/fe/common/common_search.tpl.php");
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
            <p> You can control the emails you would like to receive by checking the boxes below </p>
			<p>&nbsp;</p>
            <div class="clr"></div>
            <div id="account_container">
                <div class="account_left_panel">
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid" style="min-height:918px;">
                            <div id="form_box01">
                            <form name="email_setting_frm" id="email_setting_frm" action="" method="post">   
                                <div class="field05">
                                    <input name="chk_job_ivitations" type="checkbox" value="job_invitation" <?php if(!empty($email_key)) echo in_array('job_invitation',$email_key) ? 'checked':''?>  />
                                    Job invitations from clients</div>
                                <div class="field05">
                                    <input name="chk_buyer_posted_msg" type="checkbox" value="buyer_post_msg" <?php if(!empty($email_key)) echo in_array('buyer_post_msg',$email_key) ? 'checked':''?>  />
                                    Private Messages</div>
                                <div class="field05">
                                    <input name="chk_job_radar_search" type="checkbox" value="job_match_criteria" <?php if(!empty($email_key)) echo in_array('job_match_criteria',$email_key) ? 'checked':''?>  />
                                    Radar Job Alerts</div>
                                <div class="field05">
                                    <input name="chk_buyer_awarded_job" type="checkbox" value="buyer_awarded_job" <?php if(!empty($email_key)) echo in_array('buyer_awarded_job',$email_key) ? 'checked':''?>  />
                                    Winning a job</div>
                                <div class="field05">
                                   <input name="chk_buyer_provide_feedback" type="checkbox" value="buyer_provided_feedback" <?php if(!empty($email_key)) echo in_array('buyer_provided_feedback',$email_key) ? 'checked':''?>  />
                                    New rating and review</div>
                                <div class="field05">
                                     <input name="chk_buyer_terminate_job" type="checkbox" value="buyer_terminate_job" <?php if(!empty($email_key)) echo in_array('buyer_terminate_job',$email_key) ? 'checked':''?>  />
                                    Jobs terminated by clients</div>
                                <div class="field05">
                                    <input name="chk_buyer_cancel_job" type="checkbox" value="buyer_cancell_job" <?php if(!empty($email_key)) echo in_array('buyer_cancell_job',$email_key) ? 'checked':''?>  />
                                    Jobs cancelled by clients</div>
                                
                                <div class="field01">
                                    <input type="submit" value="Save" />
                                </div>
                                </form>
                            </div>
                        </div>
                        <div class="bot">&nbsp;</div>
                    </div>
                </div> 
                <?php
                    include_once(APPPATH."views/fe/common/tradesman_right_menu.tpl.php");
                ?>            
                 </div>
            <div class="clr"></div>
        </div>       
        
        
        <div class="clr"></div>
</div>
</div>

