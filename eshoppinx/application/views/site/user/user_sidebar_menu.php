<div id="sidebar">
    <dl class="set_menu">
        <dt><?php if($this->lang->line('referrals_account') != '') { echo stripslashes($this->lang->line('referrals_account')); } else echo "ACCOUNT"; ?></dt>
        <dd><a href="settings" <?php if($side_menu==1){ ?> class="current"<?php } ?>  ><i class="ic-user"></i> <?php if($this->lang->line('referrals_profile') != '') { echo stripslashes($this->lang->line('referrals_profile')); } else echo "Profile"; ?></a></dd>
        <dd><a href="settings/preferences" <?php if($side_menu==2){ ?> class="current"<?php } ?> ><i class="ic-pre"></i> <?php if($this->lang->line('referrals_preference') != '') { echo stripslashes($this->lang->line('referrals_preference')); } else echo "Preferences"; ?></a></dd>
        <dd><a href="settings/password" <?php if($side_menu==3){ ?> class="current"<?php } ?> ><i class="ic-pw"></i> <?php if($this->lang->line('signup_password') != '') { echo stripslashes($this->lang->line('signup_password')); } else echo "Password"; ?></a></dd>
        <dd><a href="settings/notifications" <?php if($side_menu==4){ ?> class="current"<?php } ?> ><i class="ic-noti"></i> <?php if($this->lang->line('referrals_notification') != '') { echo stripslashes($this->lang->line('referrals_notification')); } else echo "Notifications"; ?></a></dd>
    </dl>
    <dl class="set_menu">
        <dt><?php if($this->lang->line('referrals_shop') != '') { echo stripslashes($this->lang->line('referrals_shop')); } else echo "SHOP"; ?></dt>
        <dd><a href="purchases" <?php if($side_menu==5){ ?> class="current"<?php } ?>  ><i class="ic-pur"></i> <?php if($this->lang->line('referrals_purchase') != '') { echo stripslashes($this->lang->line('referrals_purchase')); } else echo "Purchases"; ?></a></dd>
        <?php if ($userDetails->row()->group == 'Seller'){?>
        <dd><a href="orders" <?php if($side_menu==6){ ?> class="current"<?php } ?> ><i class="ic-group"></i> <?php if($this->lang->line('referrals_orders') != '') { echo stripslashes($this->lang->line('referrals_orders')); } else echo "Orders"; ?></a></dd>
        <?php }?>
        <?php if ($userDetails->row()->group == 'Seller'){?>
         <dd><a href="credits" <?php if($side_menu==7){ ?> class="current"<?php } ?>  ><i class="ic-credit"></i> Earnings</a></dd>
         <?php }?>
<!--                 <dd><a href="fancyybox/manage"><i class="ic-sub"></i> <?php if($this->lang->line('referrals_subscribe') != '') { echo stripslashes($this->lang->line('referrals_subscribe')); } else echo "Subscriptions"; ?></a></dd>
-->                <dd><a href="settings/shipping" <?php if($side_menu==8){ ?> class="current"<?php } ?> ><i class="ic-ship"></i> <?php if($this->lang->line('referrals_shipping') != '') { echo stripslashes($this->lang->line('referrals_shipping')); } else echo "Shipping"; ?></a></dd>
    </dl>
    <?php /* ?>
    <dl class="set_menu">
        <dt><?php if($this->lang->line('referrals_sharing') != '') { echo stripslashes($this->lang->line('referrals_sharing')); } else echo "SHARING"; ?></dt>
            <!--<dd><a href="credits"><i class="ic-credit"></i> Credits</a></dd>-->     
                 
            <dd><a href="referrals/0"><i class="ic-refer"></i> <?php if($this->lang->line('referrals_common') != '') { echo stripslashes($this->lang->line('referrals_common')); } else echo "Referrals"; ?></a></dd>
            <?php 
            if ($this->config->item('giftcard_status') == 'Enable'){
            ?> 
            <!--<dd><a href="settings/giftcards"><i class="ic-gift"></i> <?php if($this->lang->line('referrals_giftcard') != '') { echo stripslashes($this->lang->line('referrals_giftcard')); } else echo "Gift Card"; ?></a></dd>-->  
                          
            <?php } if ($userDetails->row()->group == 'Seller'){?>
            <dd><a href="<?php echo base_url();?>site/feed/store/<?php echo $userDetails->row()->user_name;?>" target="_blank"><i class="ic-group"></i> <?php if($this->lang->line('referrals_feedurl') != '') { echo stripslashes($this->lang->line('referrals_feedurl')); } else echo "Store Feed URL"; ?></a></dd>
            <?php }?>
        
    </dl>
    <?php */ ?>
</div>