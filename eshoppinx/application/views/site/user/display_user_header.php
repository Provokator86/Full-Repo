<?php

$userImg = 'default-user.png';
if ($userProfileDetails->row()->thumbnail != ''){
	if (file_exists('images/users/'.$userProfileDetails->row()->thumbnail)){
		$userImg = $userProfileDetails->row()->thumbnail;
	}
}
$followClass = 'follow_btn';
$followtext= stripslashes($this->lang->line('onboarding_follow'));
if ($followtext == ''){
	$followtext = 'Follow';
}
if ($loginCheck != ''){
	$followingListArr = explode(',', $userDetails->row()->following);
	if (in_array($followingUserDetails->row()->id, $followingListArr)){
		$followClass = 'following_btn';
		$followtext= stripslashes($this->lang->line('display_following'));
        if ($followtext == ''){
			$followtext = 'Following';
		}
	}
}
?>

<div class="personal_dtls">
    <div class="personal_dtls_lft">
        <img style="max-height: 149px;" src="images/users/<?php echo $userImg;?>" alt="">
    </div>
    <?php
        if ($userProfileDetails->row()->full_name != ''){
            $fullName = character_limiter($userProfileDetails->row()->full_name,35);
            if (strlen($fullName)>35){
                $fullName = substr($fullName, 0,35).'..';
            }
        }else {
            $fullName = $userProfileDetails->row()->user_name;
        }
    ?>
    <div class="personal_dtls_rht">
        <div class="personal_block">
            <h2>@<?php echo $userProfileDetails->row()->user_name;?></h2>
            <p><?php echo $fullName;?></p>
            <div class="personal_dtls_social">
                <?php 
                if ($userProfileDetails->row()->facebook != ''){
                    $fb_link = $userProfileDetails->row()->facebook;
                    if (substr($fb_link, 0,4) != 'http') $fb_link = 'http://'.$fb_link;
                ?>
                <a href="<?php echo $fb_link;?>" target="_blank"><img src="images/site_new/facebook2.png" alt=""></a>
                <?php } ?>
                <?php 
                if ($userProfileDetails->row()->twitter != ''){
                    $tw_link = $userProfileDetails->row()->twitter;
                    if (substr($tw_link, 0,4) != 'http') $tw_link = 'http://'.$tw_link;
                ?>
                <a href="<?php echo $tw_link;?>" target="_blank"><img src="images/site_new/twitter2.png" alt=""></a>
                <?php } ?>
                
                <?php 
                if ($userProfileDetails->row()->pinterest != ''){
                    $pin_link = $userProfileDetails->row()->pinterest;
                    if (substr($pin_link, 0,4) != 'http') $pin_link = 'http://'.$pin_link;
                ?>
                <a href="<?php echo $pin_link;?>" target="_blank"><img src="images/site_new/pinterest2.png" alt=""></a>
                <?php } ?>
                
                
                
                <div class="clear"></div>
            </div>
            
             <?php 
                if ($userProfileDetails->row()->twitter != ''){
                    $tw_link = $userProfileDetails->row()->twitter;
                    if (substr($tw_link, 0,4) != 'http') $tw_link = 'http://'.$tw_link;
                ?>
                <span>lame</span>
                <a href="<?php echo $tw_link;?>" target="_blank"><?php echo $tw_link;?></a>
             <?php } ?>
        </div>
        
        <div class="followers">
            <ul>
                <!--<li><a href="#">Follow</a></li>-->

                <?php if($loginCheck !='' && $userProfileDetails->row()->id==$loginCheck){ ?>
                <li><a class="edit_btn" href="settings"><?php if($this->lang->line('display_edit_prof') != '') { echo stripslashes($this->lang->line('display_edit_prof')); } else echo "Edit"; ?>
                </a></li>
                <?php }else{ ?>
                <li><a
                    class="edit_btn <?php echo $followClass.' '; if ($loginCheck==''){echo 'sign_box';}?>"
                    <?php if ($loginCheck != ''){?>
                    data-uid="<?php echo $userProfileDetails->row()->id;?>"
                    onclick="javascript:store_follow(this);" <?php }?>><?php echo $followtext;?>
                </a></li>
                <?php } ?>
                
                <!--<li><?php echo $userProfileDetails->row()->following_count;?> <span><?php if($this->lang->line('stores') != '') { echo stripslashes($this->lang->line('stores')); } else echo "Stores"; ?></span>
                </li>-->
                <li><strong><?php echo $tot_store_follow;?></strong><a class="prof-link" href="user/<?php echo $userProfileDetails->row()->user_name;?>/stores"> <span><?php if($this->lang->line('stores') != '') { echo stripslashes($this->lang->line('stores')); } else echo "Stores"; ?></span></a>
                </li>
                
                <li><?php echo $userProfileDetails->row()->following_count;?> <a class="prof-link"  href="user/<?php echo $userProfileDetails->row()->user_name;?>/following"><span><?php if($this->lang->line('display_following') != '') { echo stripslashes($this->lang->line('display_following')); } else echo "Following"; ?></span></a>
                </li>
                
                <li><?php echo $userProfileDetails->row()->followers_count;?> <a class="prof-link"  href="user/<?php echo $userProfileDetails->row()->user_name;?>/followers"><span><?php if($this->lang->line('display_followers') != '') { echo stripslashes($this->lang->line('display_followers')); } else echo "Followers"; ?></span></a>
                </li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>