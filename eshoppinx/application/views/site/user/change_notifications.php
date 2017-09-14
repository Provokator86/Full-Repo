<?php
$this->load->view('site/templates/header');
?>    
    <!-- Section_start -->
    <div id="mid-panel">
        <div class="wrapper">        
            <div class="container set_area" style="padding:30px 0 20px">
		        <?php if($flash_data != '') { ?>
		        <div class="errorContainer" id="<?php echo $flash_data_type;?>">
			        <script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 3000);</script>
			        <p><span><?php echo $flash_data;?></span></p>
		        </div>
                <div class="clear"></div>
		        <?php } ?>	
                            
                <?php $this->load->view('site/user/user_sidebar_menu'); ?>                

                <div id="content">
            <h2 class="ptit"><?php if($this->lang->line('referrals_notification') != '') { echo stripslashes($this->lang->line('referrals_notification')); } else echo "Notifications"; ?></h2>
            <div style="display:none" class="notification-bar"></div>
            <form method="post" action="site/user_settings/update_notifications">                
            <div class="section notification">
                <h3 class="stit"><?php if($this->lang->line('referrals_email') != '') { echo stripslashes($this->lang->line('referrals_email')); } else echo "Email"; ?></h3>
                <fieldset class="frm">
                    <label><?php if($this->lang->line('notify_email_sett') != '') { echo stripslashes($this->lang->line('notify_email_sett')); } else echo "Email settings"; ?></label>
                    <?php 
                    $emailNoty = explode(',', $userDetails->row()->email_notifications);
                    if (is_array($emailNoty)){
                	    $emailNotifications = $emailNoty;
                    }
                    ?>
                    <ul>
                        <li><input type="checkbox" <?php if (in_array('following', $emailNotifications)){echo 'checked="checked"';}?> name="following"><label class="label" for="following"><?php if($this->lang->line('notify_some_follu') != '') { echo stripslashes($this->lang->line('notify_some_follu')); } else echo "When someone follows you"; ?></label></li>
    <!--                     <li><input type="checkbox" <?php if (in_array('invited', $emailNotifications)){echo 'checked="checked"';}?> name="invited" ><label class="label" for="invited">When someone accepts your invitation joins</label></li>
                        <li><input type="checkbox" <?php if (in_array('shown_to_me', $emailNotifications)){echo 'checked="checked"';}?> name="shown_to_me"><label class="label" for="shown_to_me">When someone shows you something on <?php echo $siteTitle;?></label></li>
     -->                    <li><input type="checkbox" <?php if (in_array('comments_on_fancyd', $emailNotifications)){echo 'checked="checked"';}?> name="comments_on_fancyd"><label class="label" for="comments_on_fancyd"><?php if($this->lang->line('notify_comm_things') != '') { echo stripslashes($this->lang->line('notify_comm_things')); } else echo "When someone comments on a thing you"; ?> <?php echo LIKED_BUTTON;?></label></li>
    <!--                    <li><input type="checkbox" <?php if (in_array('featured', $emailNotifications)){echo 'checked="checked"';}?> name="featured" ><label class="label" for="featured"><?php if($this->lang->line('notify_thing_feature') != '') { echo stripslashes($this->lang->line('notify_thing_feature')); } else echo "When one of your things is featured"; ?></label></li>
                         <li><input type="checkbox" <?php if (in_array('mentions_me', $emailNotifications)){echo 'checked="checked"';}?> name="mentions_me" ><label class="label" for="mentions_me">When someone mentions you</label></li>
     -->            	<li><input type="checkbox" name="comments" <?php if (in_array('comments', $emailNotifications)){echo 'checked="checked"';}?>><label class="label" for="comments"><?php if($this->lang->line('user_whensomeone') != '') { echo stripslashes($this->lang->line('user_whensomeone')); } else echo "When someone comments on your thing"; ?></label></li>    
 				    </ul>
                </fieldset>
            </div>
            <div class="section notification">
                <h3 class="stit"><?php if($this->lang->line('referrals_notification') != '') { echo stripslashes($this->lang->line('referrals_notification')); } else echo "Notifications"; ?></h3>
                <fieldset class="frm">
                    <label><?php if($this->lang->line('notify_web_sett') != '') { echo stripslashes($this->lang->line('notify_web_sett')); } else echo "Web settings"; ?> </label>
                    <small class="comment"><?php if($this->lang->line('notify_notify_showup') != '') { echo stripslashes($this->lang->line('notify_notify_showup')); } else echo "The web notifications show up in the topbar of the"; ?> <?php echo $siteTitle;?> <?php if($this->lang->line('settings_website') != '') { echo stripslashes($this->lang->line('settings_website')); } else echo "website"; ?>. </small>
                    <label><?php if($this->lang->line('notify_active_involves') != '') { echo stripslashes($this->lang->line('notify_active_involves')); } else echo "Activity that involves you"; ?></label>
                    <?php 
                    $noty = explode(',', $userDetails->row()->notifications);
                    if (is_array($noty)){
                	    $notifications = $noty;
                    }
                    ?>
                    <ul>
                        <li><input type="checkbox" name="wmn-follow" <?php if (in_array('wmn-follow', $notifications)){echo 'checked="checked"';}?> ><label class="label" for="wmn-follow"><?php if($this->lang->line('notify_some_follu') != '') { echo stripslashes($this->lang->line('notify_some_follu')); } else echo "When someone follows you"; ?></label></li>
    <!--                     <li><input type="checkbox" name="wmn-mentioned_in_comment" <?php if (in_array('wmn-mentioned_in_comment', $notifications)){echo 'checked="checked"';}?>><label class="label" for="wmn-mentioned_in_comment">When someone mentions you</label></li>
     -->                    <li><input type="checkbox" name="wmn-comments_on_fancyd" <?php if (in_array('wmn-comments_on_fancyd', $notifications)){echo 'checked="checked"';}?>><label class="label" for="wmn-comments_on_fancyd"><?php if($this->lang->line('notify_comm_things') != '') { echo stripslashes($this->lang->line('notify_comm_things')); } else echo "When someone comments on a thing you"; ?> <?php echo LIKED_BUTTON;?></label></li>
                        <li><input type="checkbox" name="wmn-fancyd" <?php if (in_array('wmn-fancyd', $notifications)){echo 'checked="checked"';}?>><label class="label" for="wmn-fancyd"><?php if($this->lang->line('notify_when_some') != '') { echo stripslashes($this->lang->line('notify_when_some')); } else echo "When someone"; ?> <?php echo LIKE_BUTTON;?> <?php if($this->lang->line('notify_ur_thing') != '') { echo stripslashes($this->lang->line('notify_ur_thing')); } else echo "one of your things"; ?></label></li>
                    </ul>
    <!--                 <ul>
                        <li><input type="checkbox" name="wmn-shown_to_me" <?php if (in_array('wmn-shown_to_me', $notifications)){echo 'checked="checked"';}?>><label class="label" for="wmn-shown_to_me">When someone shows you something on <?php echo $siteTitle;?></label></li>
                        <li><input type="checkbox" name="wmn-join" <?php if (in_array('wmn-join', $notifications)){echo 'checked="checked"';}?>><label class="label" for="wmn-join">When someone accepts your invitation joins</label></li>
                    </ul>
     -->                <ul class="last">
    <!--                    <li><input type="checkbox" name="wmn-featured" <?php if (in_array('wmn-featured', $notifications)){echo 'checked="checked"';}?>><label class="label" for="wmn-featured"><?php if($this->lang->line('notify_thing_feature') != '') { echo stripslashes($this->lang->line('notify_thing_feature')); } else echo "When one of your things is featured"; ?></label></li>
                         <li><input type="checkbox" name="wmn-deal" <?php if (in_array('wmn-deal', $notifications)){echo 'checked="checked"';}?>><label class="label" for="wmn-deal">When you unlock a deal</label></li>
                        <li><input type="checkbox" name="wmn-promotion" <?php if (in_array('wmn-promotion', $notifications)){echo 'checked="checked"';}?>><label class="label" for="wmn-promotion">When you earn a promotion</label></li>
     -->                	<li><input type="checkbox" name="wmn-comments" <?php if (in_array('wmn-comments', $notifications)){echo 'checked="checked"';}?>><label class="label" for="wmn-comments"><?php if($this->lang->line('user_whensomeone') != '') { echo stripslashes($this->lang->line('user_whensomeone')); } else echo "When someone comments on your thing"; ?></label></li>
 					    </ul>
     <!--                <label>Friends activity</label>
                    <ul>
                        <li><input type="checkbox" name="wmn-followed_add_person" <?php if (in_array('wmn-followed_add_person', $notifications)){echo 'checked="checked"';}?>><label class="label" for="wmn-followed_add_person">When a friend follows someone</label></li>
                        <li><input type="checkbox" name="wmn-followed_add_store" <?php if (in_array('wmn-followed_add_store', $notifications)){echo 'checked="checked"';}?>><label class="label" for="wmn-followed_add_store">When a friend follows a store</label></li>
                        <li><input type="checkbox" name="wmn-followed_commented" <?php if (in_array('wmn-followed_commented', $notifications)){echo 'checked="checked"';}?>><label class="label" for="wmn-followed_commented">When a friend posts a comment</label></li>
                        <li><input type="checkbox" name="wmn-followed_earned_deal" <?php if (in_array('wmn-followed_earned_deal', $notifications)){echo 'checked="checked"';}?>><label class="label" for="wmn-followed_earned_deal">When a friend unlocks a deal</label></li>
                        <li><input type="checkbox" name="wmn-followed_promoted" <?php if (in_array('wmn-followed_promoted', $notifications)){echo 'checked="checked"';}?>><label class="label" for="wmn-followed_promoted">When a friend earns a promotion</label></li>
                    </ul>
     -->            </fieldset>
            </div>
            <div class="section notification">
                <h3 class="stit"><?php if($this->lang->line('notify_update') != '') { echo stripslashes($this->lang->line('notify_update')); } else echo "Updates"; ?></h3>
                <fieldset class="frm">
                    <label><?php if($this->lang->line('notify_update_from') != '') { echo stripslashes($this->lang->line('notify_update_from')); } else echo "Updates from"; ?> <?php echo $siteTitle;?></label>
                    <ul>
                        <li><input type="checkbox" <?php if ($userDetails->row()->updates == '1'){echo 'checked="checked"';}?> id="updates" name="updates"><label class="label" for="updates"><?php if($this->lang->line('notify_send_news') != '') { echo stripslashes($this->lang->line('notify_send_news')); } else echo "Send news about"; ?> <?php echo $siteTitle;?></label></li>
                    </ul>
                </fieldset>
            </div>
            <div class="btn-area">
                <button id="save_notifications" class="btn-save"><?php if($this->lang->line('notify_save_change') != '') { echo stripslashes($this->lang->line('notify_save_change')); } else echo "Save Changes"; ?></button>
			    <span style="display:none" class="checking"><i class="ic-loading"></i></span>
            </div>
            </form>
        </div>
		    
		     </div>   
        </div>
    </div>
    <div class="clear"></div>
    <!-- Section_end -->
<?php 
$this->load->view('site/templates/footer');
?>