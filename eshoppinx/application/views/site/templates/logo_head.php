<?php
$current_user_img = 'default_user.jpg';

if ($loginCheck != ''){

    if ($userDetails->row()->thumbnail != ''){
        if (file_exists('images/users/'.$userDetails->row()->thumbnail)){
            $current_user_img = $userDetails->row()->thumbnail;
        }
    }
}
?>
<div class="top-social">
<p class="social-media"> <span><a href="javascript:" class="facebook">Facebook</a></span> <span><a href="javascript:" class="twitter">Twitter</a></span> <span><a href="javascript:" class="pinterest">Pinterest</a></span> </p>
</div>


<div class="row-top">
  <div class="wrapper"> 
  
    <?php if ($loginCheck != ''){ 
       
        ?>
    <div class="header_post">
        <ul>
            <!--<li><a class="fancybox" href="#popup1"><span>POST +</span></a></li>-->
            <li><a class="fancybox <?php if ($loginCheck==''){echo 'sign_box';}else {echo 'box_post';}?>" href="#"><span><?php if($this->lang->line('header_post_comment') != '') { echo stripslashes($this->lang->line('header_post_comment')); } else echo "POST"; ?> +</span></a></li>
            <li><a href="<?php echo 'user/'.$userDetails->row()->user_name;?>"><img style="max-height: 51px; max-width: 51px;" src="images/users/<?php echo $current_user_img; ?>" alt=""></a>
            <div class="arrow"><img src="images/site_new/arrow1.png" alt=""></div>
            <ul>
                <li><a href="<?php echo 'user/'.$userDetails->row()->user_name;?>">Profile</a></li>
                <li><a href="javascript:">Find Your Friends</a></li>
                <li><a href="<?php echo base_url('bookmarklets') ?>">Get the Bookmarklet</a></li>
                <li><a href="javascript:">Your Orders</a></li>
                <li><a href="<?php echo base_url('settings');?>">Settings</a></li>
                <li><a href="<?php echo base_url('logout') ?>">Sign Out</a></li>
            </ul>
          </li>
          <li><a class="post_no" href="javascript:">0</a></li>
            <!--<li><a class="post_no notifination gnb-notification" href="<?php echo base_url('notifications');?>">0</a>
                <ul class="feed-notification notification_sub" style="text-indent: 0px;">
                       <li><span class="arrow_icon2"><img src="images/drop_arrow.png"/></span></li> 
                       <li class="loading res-load"><?php if($this->lang->line('display_loading') != '') { echo stripslashes($this->lang->line('display_loading')); } else echo "Loading"; ?>...</li>
                </ul>
            </li>-->
        </ul>
        <div class="clear"></div>
    </div>
    <?php } else { ?>
             
    <ul class="link-login">
        <li><a href="<?php echo base_url('login') ?>">Login</a></li>
        <li><a href="<?php echo base_url('signup') ?>">Registration</a></li>
    </ul>    
    <?php } ?>
    
    <div id="logo"><a href="<?php echo base_url() ?>"><img src="images/site_new/logo.jpg" alt="" /></a></div>
     
  </div>
  
</div>   