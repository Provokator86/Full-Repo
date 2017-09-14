<?php 
$this->load->view('site/templates/header',$this->data);
?> 

  <!-- Section_start -->
    
     	<section>
        
        	<div class="section_main">
            
            	<div class="main2">
                
                	<div class="main_box">
                    
                    	<div class="page-folloers" style="float: left;width: 97.4%;">
           <div class="follow-people" style="margin: 30px 0px;">
         <?php  
		 
	if (isset($likeSingleImage->row()->web_link)){
    $prod_link = 'user/'.$likeSingleImage->row()->user_name.'/things/'.$likeSingleImage->row()->seller_product_id.'/'.str_replace(' ','-',$likeSingleImage->row()->product_name);
    }else {
     $prod_link = 'things/'.$likeSingleImage->row()->id.'/'.str_replace(' ','-',$likeSingleImage->row()->product_name);
    }
		 
		 $likedImg = explode(',', $likeSingleImage->row()->image);?>
			<a href="<?php echo $prod_link?>">
				<img src="images/product/<?php echo $likedImg[0];?>" style="float:left;margin:0 20px 20px 0; width:100px; height:100px;" />
			</a>
          <h1 style="padding-top: 5px;color: #434343;font-size: 32px;line-height: 32px;"><?php echo $likeSingleImage->row()->product_name;?></h1>
          <h2 style="line-height: 32px;margin: 0 0;float: none;padding: 0;"> <?php if($this->lang->line('saved_by') != '') { echo stripslashes($this->lang->line('saved_by')); } else echo "saved by"; ?> <?php echo $likeSingleImage->row()->likes;?> <?php if($this->lang->line('onboarding_people') != '') { echo stripslashes($this->lang->line('onboarding_people')); } else echo "people"; ?></h2>
         </div> 
                
                        
                        <div class="product_main" style="background-color: #fff;">
<?php 
if ($userProfileDetails->num_rows()>0){
	foreach ($userProfileDetails->result() as $store_list){
		$userImg = 'default_user.jpg';
		if ($store_list->thumbnail != ''){
			if (file_exists('images/users/'.$store_list->thumbnail)){
				$userImg = $store_list->thumbnail;
			}
		}
		$store_name = $store_list->full_name;
		if ($store_name == '')$store_name = $store_list->user_name;
		$followClass = 'follow_btn';
		$followText= stripslashes($this->lang->line('onboarding_follow'));
		if ($followText == ''){
			$followText = 'Follow';
		}
		if ($loginCheck != ''){
	        $followingListArr = explode(',', $userDetails->row()->following);
	        if (in_array($store_list->id, $followingListArr)){
	        	$followClass = 'following_btn';
	        	$followText= stripslashes($this->lang->line('display_following'));
		        if ($followText == ''){
					$followText = 'Following';
				}
	        }
        } 
?>                        
                        
                            <div class="store_list">
                            
                            	<div class="follow_main" style="height: 330px;padding-left: 0;">
                
                                    <div class="left_follow" style="width:300px;">
                                    
                                        <span class="follow_icon"><img src="images/users/<?php echo $userImg;?>" /></span>
                                        
                                        <a class="follow_icon_links" href="user/<?php echo $store_list->user_name;?>" style="width:75%;overflow:hidden;height:20px;float: right;"><?php echo $store_name;?></a>
                                        
                                        <span class="follow_count"><?php echo $store_list->followers_count;?> <?php if($this->lang->line('display_followers') != '') { echo stripslashes($this->lang->line('display_followers')); } else echo "Followers"; ?></span>
                                    
                                    
                                    </div>
                    
                                        <div class="right_follow">
                                        
                                            <a class="<?php echo $followClass.' '; if ($loginCheck==''){echo 'sign_box';}?>" <?php if ($loginCheck != ''){?>data-uid="<?php echo $store_list->id;?>" onclick="javascript:store_follow(this);"<?php }?> ><?php echo $followText;?></a>
                                                      	</div>	
                    
                    
                                      <ul class="store_list_follow">
                                      <?php 
                                      if (count($prodDetails[$store_list->id])>0){
                                      	$limitCount = 0;
                                      	foreach ($prodDetails[$store_list->id] as $store_products){
											if ($limitCount==6)break;$limitCount++;
											$prodImg = 'dummyProductImage.jpg';
											$prodImgArr = array_filter(explode(',', $store_products->image));
											if (count($prodImgArr)>0){
												foreach ($prodImgArr as $prodImgArrRow){
													if (file_exists('images/product/'.$prodImgArrRow)){
														$prodImg = $prodImgArrRow;
														break;
													}
												}
											}
                                      	if (isset($store_products->web_link)){
										
		            						$prod_link = 'user/'.$store_products->user_name.'/things/'.$store_products->seller_product_id.'/'.str_replace(' ','-',$store_products->product_name);
		            					}else {
											$prod_link = 'things/'.$store_products->id.'/'.str_replace(' ','-',$store_products->product_name);
		            					}
                                      ?>
                                                
                                            <li style="width: 131px;"><a href="<?php echo $prod_link;?>"><img src="images/product/thumb/<?php echo $prodImg;?>" /></a></li>
                                      <?php 
                                      	}
                                      }
                                      ?>                  
                                  </ul>
                
               				 </div>
                            
                            
                            </div>
<?php 
	}

}else {
?>    
<p style="padding: 20px;">
<?php 
if($this->lang->line('no_sav') != '') {
	echo stripslashes($this->lang->line('no_sav')); 
} else { 
	echo "No one saved this product"; 
}
?>
</p>
<?php 
}
?>                   
                        </div>
                        
                      </div>
                
                </div>
            
            
            
            </div>
        
        	
        	
        
		</section>
        
        
   <!-- Section_end -->
<?php 
$this->load->view('site/templates/footer',$this->data);
?>   