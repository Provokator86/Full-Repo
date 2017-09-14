<?php 
$this->load->view('site/templates/header',$this->data);
?> 

  <!-- Section_start -->
    
     	<section>
        
        	<div class="section_main">
            
            	<div class="main2">
                
                	<div class="main_box">
                    
                    	<h2><?php if($this->lang->line('shop_topstoreson') != '') { echo stripslashes($this->lang->line('shop_topstoreson')); } else echo "Top stores on"; ?> <?php echo $siteTitle;?></h2>
                
                		<div class="tab_product">
                        
                            
                        
                        </div>
                        
                        <div class="product_main">
<?php 
if (count($topStores)>0 && $topStores['store_lists']->num_rows()>0){
	foreach ($topStores['store_lists']->result() as $store_list){
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
                                      if ($topStores['prodDetails'][$store_list->id]->num_rows()>0){
                                      	$limitCount = 0;
                                      	foreach ($topStores['prodDetails'][$store_list->id]->result() as $store_products){
											if ($limitCount==8)break;$limitCount++;
											$prodImg = 'dummyProductImage.jpg';
											$prodImgArr = array_filter(explode(',', $store_products->image));
											if (count($prodImgArr)>0){
												foreach ($prodImgArr as $prodImgArrRow){
													if (file_exists('images/product/thumb/'.$prodImgArrRow)){
														$prodImg = $prodImgArrRow;
														break;
													}
												}
											}
                                      ?>
                                                
                                            <li><a href="things/<?php echo $store_products->id;?>/<?php echo url_title($store_products->product_name,'-');?>"><img src="images/product/thumb/<?php echo $prodImg;?>" /></a></li>
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
<!--                               
                            <div class="page-links">
  
                                  <ul>
                                    <li class="wnl-page active"><a href="#">1</a></li><li class="wnl-page"><a rel="next" href="#">2</a></li><li class="wnl-page"><a href="#">3</a></li><li class="wnl-page"><a href="#">4</a></li><li class="wnl-page"><a href="#">5</a></li></ul>
                                    <div class="page-links-buttons">
                                      <a rel="prev" href="#" class="page-link-disabled prev">Previous</a>
                                
                                      <a rel="next" href="#" class="next">Next</a>
                                
                                    </div>
                                </div>
 -->                            	
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