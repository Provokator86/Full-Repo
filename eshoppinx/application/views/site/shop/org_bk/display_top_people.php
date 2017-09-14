<?php 
$this->load->view('site/templates/header',$this->data);
?> 

  <!-- Section_start -->
    
     	<section>
        
        	<div class="section_main">
            
            	<div class="main2">
                
                	<div class="main_box">
                    
                    	<h2 style="margin-bottom: 20px;"><?php if($this->lang->line('shop_toppeple') != '') { echo stripslashes($this->lang->line('shop_toppeple')); } else echo "Top people on "; ?> <?php echo $siteTitle;?></h2>
                
                        
                        <div class="product_main" style="background-color: #fff;">
<?php 
if (count($topPeople)>0 && $topPeople['store_lists']->num_rows()>0){
	foreach ($topPeople['store_lists']->result() as $store_list){
		$userImg = 'default_user.jpg';
		if ($store_list->thumbnail != ''){
			if (file_exists('images/users/'.$store_list->thumbnail)){
				$userImg = $store_list->thumbnail;
			}
		}
		$store_name = $store_list->full_name;
		if ($store_name == '')$store_name = $store_list->user_name;
		$followClass = 'follow_btn';
		$followText  = 'Follow';
		if ($loginCheck != ''){
	        $followingListArr = explode(',', $userDetails->row()->following);
	        if (in_array($store_list->id, $followingListArr)){
	        	$followClass = 'following_btn';
	        	$followText = 'Following';
	        }
        } 
?>                        
                        
                            <div class="store_list">
                            
                            	<div class="follow_main" style="height: 360px;">
                
                                    <div class="left_follow" style="width:300px;">
                                    
                                        <span class="follow_icon"><img src="images/users/<?php echo $userImg;?>" /></span>
                                        
                                        <a class="follow_icon_links" href="user/<?php echo $store_list->user_name;?>" style="width:75%;overflow:hidden;height:20px;"><?php echo $store_name;?></a>
                                        
                                        <span class="follow_count"><?php echo $store_list->followers_count;?> <?php if($this->lang->line('display_followers') != '') { echo stripslashes($this->lang->line('display_followers')); } else echo "Followers"; ?></span>
                                    
                                    
                                    </div>
                    
                                        <div class="right_follow">
                                        
                                            <a class="<?php echo $followClass.' '; if ($loginCheck==''){echo 'sign_box';}?>" <?php if ($loginCheck != ''){?>data-uid="<?php echo $store_list->id;?>" onclick="javascript:store_follow(this);"<?php }?> ><?php echo $followText;?></a>
                                                      	</div>	
                    
                    
                                      <ul class="store_list_follow">
                                      <?php 
                                      if ($topPeople['prodDetails'][$store_list->id]->num_rows()>0){
                                      	$limitCount = 0;
                                      	foreach ($topPeople['prodDetails'][$store_list->id]->result() as $store_products){
											if ($limitCount==8)break;$limitCount++;
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
                                      ?>
                                                
                                            <li><a href="user/<?php echo $store_list->user_name;?>/things/<?php echo $store_products->seller_product_id;?>/<?php echo url_title($store_products->product_name,'-');?>"><img src="images/product/thumb/<?php echo $prodImg;?>" /></a></li>
                                      <?php 
                                      	}
                                      }
                                      ?>                  
                                  </ul>
                
               				 </div>
                            
                            
                            </div>
<?php 
	}
?>                            
                           	
<?php 
}else {
?>     
<p><?php if($this->lang->line('shop_nostoresavail') != '') { echo stripslashes($this->lang->line('shop_nostoresavail')); } else echo "No Stores available"; ?></p>
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