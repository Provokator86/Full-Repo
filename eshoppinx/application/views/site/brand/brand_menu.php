<?php
        
    $followClass = 'follow_btn';
    $followtext= stripslashes($this->lang->line('onboarding_follow'));
    if ($followtext == ''){
        $followtext = 'Follow';
    }
    if ($loginCheck != ''){
        $followingListArr = explode(',', $brand_details->row()->followers);
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
    $fullName = character_limiter($brand_details->row()->brand_name,35);
    if (strlen($fullName)>35){
        $fullName = substr($fullName, 0,35).'..';
    }
    $storeImg = 'dummy_store_logo.png';
    if ($brandlogoDetails->row()->brand_logo != ''){
        $storeImg = $brandlogoDetails->row()->brand_logo;
    }
    ?>
    <div class="personal_dtls_lft">
        <!--<img src="images/site_new/profile_pic2.jpg" alt="">-->
        <?php if($brandlogoDetails->row()->brand_logo != '') { ?>
            <img alt="" class="avatar-image avatar-x200" src="images/brand/<?php echo $storeImg;?>"/>
        <?php } else { ?>    
            <img alt="" class="avatar-image avatar-x200" src="images/brand/<?php echo $storeImg;?>"/>
        <?php } ?>
    </div>
    
    <div class="personal_dtls_rht">
            <div class="personal_block">
                <h2><?php echo $fullName;?></h2>
                
                <?php if($brandlogoDetails->row()->description!='') { ?>
                    <p><?php echo $brandlogoDetails->row()->description; ?></p>
                <?php } ?> 
                
                <div class="personal_dtls_social">
                    <a href="javascript:"><img src="images/site_new/facebook2.png" alt=""></a>
                    <a href="javascript:"><img src="images/site_new/twitter2.png" alt=""></a>
                    <a href="javascript:"><img src="images/site_new/pinterest2.png" alt=""></a>
                    <div class="clear"></div>
                </div>
                        
            </div>
            
            <div class="followers">
                <ul>                    
                    <li>
                    <a
                        class="edit_btn <?php echo $followClass.' '; if ($loginCheck==''){echo 'sign_box';}?>"
                        <?php if ($loginCheck != ''){?>
                        data-uid="<?php echo $brand_details->row()->id;?>"
                        onclick="javascript:follow_brand(this);" <?php }?>><?php echo $followtext;?>
                    </a></li>
                    
                    <li><?php echo $brandStores->num_rows;?>                        
                    <span>Stores</span>
                    </li>
                    
                    <li><?php echo $brand_details->row()->followers_count;?>                        
                    <span><?php if($this->lang->line('display_followers') != '') { echo stripslashes($this->lang->line('display_followers')); } else echo "Followers"; ?>
                    </span>
                    </li>
                    
                    
                </ul>
                <div class="clear"></div>
            </div>            
            
            <div class="clear"></div>
            <!--<div class="top_conti">
                <a href="javascript:"><img src="images/site_new/contributors1.jpg" alt=""></a>
                <a href="javascript:"><img src="images/site_new/contributors2.jpg" alt=""></a>
                <a href="javascript:"><img src="images/site_new/contributors3.jpg" alt=""></a>
                <a href="javascript:"><img src="images/site_new/contributors4.jpg" alt=""></a>
                <a href="javascript:"><img src="images/site_new/contributors5.jpg" alt=""></a>
                <span>Top <br> Contributors</span>
                <div class="clear"></div>
            </div>-->
            
                            
        </div>       
        
    <div class="clear"></div>
</div>