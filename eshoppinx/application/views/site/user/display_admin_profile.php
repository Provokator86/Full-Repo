<?php
$this->load->view('site/templates/header',$this->data);
$this->load->view('site/templates/popup_product_detail.php',$this->data);

?>
<!-- Section_start -->
    <section>
    
        <div class="section_main">
        
            <div class="main2">
            
                <div class="main_box">
                <?php 
        $userImg = 'default-user.png';
        $followClass = 'follow_btn';
		$followText  = 'Follow';
		if ($loginCheck != ''){
	        $followingListArr = explode(',', $userDetails->row()->following);
	        if (in_array($userProfileDetails->row()->id, $followingListArr)){
	        	$followClass = 'following_btn';
	        	$followText = 'Following';
	        }
        }   
        ?>
                    <div class="profile_main">
                    
                        <div class="profile_left">
                        
                            <span class="profile_left_avatar"><img src="images/users/<?php echo $userImg;?>" /></span>
                            <?php if ($loginCheck != '' && $userDetails->row()->id == $userProfileDetails->row()->id){?>
           	<a title="Edit Profile Image" style="display: none;" class="btn-edit tooltip" onclick="$.dialog('change-photo').open();return false;" href="#">
          	<i class="ic-pen"></i>
          	<span><?php if($this->lang->line('display_edit_img') != '') { echo stripslashes($this->lang->line('display_edit_img')); } else echo "Edit Profile Image"; ?><b></b></span>
          	</a>
          <?php }?>	
                        
                            <h1><?php echo '@administrator';?></h1>
                            
                        </div>
                        
                        <div class="profile_right">
                        
                            <ul class="profile_right_links">
                                
                            </ul>
                            
                            
                        
                        </div>
                    
                    
                    </div>
                    
                    <div class="profile_tab">
            
                    <div class="tab_product">
                    
                       
                        
                    
                    </div>
                    
                    </div>
                    
                    <div class="product_main">
                    
                        <p>This profile is private</p>
                    
                    </div>
                    
                  </div>
            
            </div>
        
        
        
        </div>
    
        
        
    
    </section>
<?php
$this->load->view('site/templates/footer');
?>