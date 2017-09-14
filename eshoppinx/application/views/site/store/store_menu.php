<?php
        
    $followClass = 'follow_btn';
    $followtext= stripslashes($this->lang->line('onboarding_follow'));
    if ($followtext == ''){
        $followtext = 'Follow';
    }
    if ($loginCheck != ''){
        $followingListArr = explode(',', $store_details->row()->followers);
        if (in_array($loginCheck, $followingListArr)){
            $followClass = 'following_btn';
            $followtext= stripslashes($this->lang->line('display_following'));
            if ($followtext == ''){
                $followtext = 'Following';
            }
        }
    }
?>


<div class="personal_dtls">
    <?php
    $fullName = character_limiter($store_details->row()->store_name,35);
    if (strlen($fullName)>35){
        $fullName = substr($fullName, 0,35).'..';
    }
    $storeImg = 'dummy_store_logo.png';
    if ($storelogoDetails->row()->store_logo != ''){
        $storeImg = $storelogoDetails->row()->store_logo;
    }
    ?>
    <div class="personal_dtls_lft">
        <!--<img src="images/site_new/profile_pic2.jpg" alt="">-->
        <?php if($storelogoDetails->row()->store_logo != '') { ?>
            <img alt="" class="avatar-image avatar-x200" src="images/store/<?php echo $storeImg;?>"/>
        <?php } else { ?>    
            <img alt="" class="avatar-image avatar-x200" src="images/store/<?php echo $storeImg;?>"/>
        <?php } ?>
    </div>
    
    <div class="personal_dtls_rht">
        <div class="personal_block">
            <h2><?php echo $fullName;?></h2>
            
            <?php if($storelogoDetails->row()->description!='') { ?>
                <div><p style="clear: both;"><?php echo $storelogoDetails->row()->description; ?></p></div>
                <div><p style="clear:both;"><?php echo $claimDetails->row()->country; ?>&nbsp;<a href="<?php echo prep_url($storelogoDetails->row()->store_url);?>" target="_blank"><?php echo $storelogoDetails->row()->store_url; ?></a></p></div>
            <?php } ?> 
            <?php 
            if ($store_details->row()->user_id == 0){
            ?>
            <p>
            <?php if ($loginCheck!='' && $checkReq->num_rows()>0){?>
            Requested
            <?php }else {?>
                <a title="<?php echo $store_details->row()->store_url;?>"
                    href="<?php echo base_url().'store/'.$store_details->row()->store_url.'/claim'?>"
                    class=""><?php if($this->lang->line('lg_own_this_claim') != '') { echo stripslashes($this->lang->line('lg_own_this_claim')); } else echo "Do you own this store? Claim it."; ?></a>
            <?php }?>
            </p>
            <?php }?>
            
                            
        </div>
        
        <div class="followers">
            <ul>
                
                <li>
                <a
                    class="edit_btn <?php echo $followClass.' '; if ($loginCheck==''){echo 'sign_box';}?>"
                    <?php if ($loginCheck != ''){?>
                    data-uid="<?php echo $store_details->row()->id;?>"
                    onclick="javascript:follow_store(this);" <?php }?>><?php echo $followtext;?>
                </a></li>
                
                <li><?php echo $store_details->row()->followers_count;?>                        
                <span><?php if($this->lang->line('display_followers') != '') { echo stripslashes($this->lang->line('display_followers')); } else echo "Followers"; ?>
                </span>
                </li>
                
                <?php //if($claimDetails->row()->store_id) { 
                    if($loginCheck!= '' && $loginCheck==$store_details->row()->user_id) {
                ?>
                    <li><a class="edit_claim" alt="Edit Claim" title="Edit Claim" href="site/store/claim_update/<?php echo $claimDetails->row()->store_id; ?>">Edit</a></li>
                <?php } ?>    
            </ul>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>