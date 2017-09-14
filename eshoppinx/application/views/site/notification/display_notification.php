<?php
$this->load->view('site/templates/header',$this->data);
?>
<style>
.notify-list img{
	width:90px;
	height:90px;
}

.activity-feed {
float: left;
margin-right: 10px;
width: 68%;
background: #fff;
padding: 10px;
}
.tab-tle { float:left;}
.tab-tle li {
 float:left;
background:none!important;
}
.tab-tle .active {
background:#fff !important;
}

.suggestion-strip .suggestion-strip-products a img {
max-width: 80px;
width: 60px;
}

.suggestion-strip {
width: 96%;
background: #f2f2f2;
padding: 5px;
}
.suggestion-strips .header {
margin-bottom: 0px;
}
</style>
<div id="container-wrapper" >
<section>
<div class="section_main">
<div class="main2" >
	<div class="container notify">
		
<div class="main_box" style="margin:0px 0px;">

	<div id="content" style="float:left; margin:0px 0 0;">
		
		<div class="notifications altered">
			<!--<h2><?php if($this->lang->line('referrals_notification') != '') { echo stripslashes($this->lang->line('referrals_notification')); } else echo "Notifications"; ?></h2>-->
            <div id="activity-feed-tabs">
            <div class="nav-basic-tab">
              <ul class="nav nav-tabs tab-tle">
                <li ><a href="stories"><?php if($this->lang->line('story_stores') != '') { echo stripslashes($this->lang->line('story_stores')); } else echo "Featured on";echo ' '.$siteTitle; ?></a></li>
                <li class="active" ><a href="notifications">Notification</a></li>
              </ul>
            </div>
            <div id="activity-feed-nav"> <a class="button wb-primary small publish-story-button" href="<?php echo base_url(); ?>stories/new"><?php if($this->lang->line('story_poststory') != '') { echo stripslashes($this->lang->line('story_poststory')); } else echo "Post a Story"; ?></a> </div>
          </div>
			 <div class="activity-feed">
			<?php 
			echo $notyList;
			?>
			</div>
            
            <div class="activity-feed-suggestions" style="width: 28.2%;">
              <div class="activity-feed-user-suggestions">
                <div class="suggestion-strips user-suggestions">
                  <div class="header">
                    <h4><?php if($this->lang->line('story_pepletofoll') != '') { echo stripslashes($this->lang->line('story_pepletofoll')); } else echo "People to follow"; ?></h4>
                    <a class="suggestions-view-all" href="<?php echo base_url(); ?>people/"><?php if($this->lang->line('story_viewall') != '') { echo stripslashes($this->lang->line('story_viewall')); } else echo "View all"; ?></a> </div>
                  <?php 
if (count($topPeople)>0 && $topPeople['store_lists']->num_rows()>0){
$peoplecount='0';
	foreach ($topPeople['store_lists']->result() as $store_list){
	$peoplecount=$peoplecount+1;
	if($peoplecount < 4){
		$userImg = 'default_user.jpg';
		if ($store_list->thumbnail != ''){
			if (file_exists('images/users/'.$store_list->thumbnail)){
				$userImg = $store_list->thumbnail;
			}
		}
		$store_name = $store_list->full_name;
		if ($store_name == '')$store_name = $store_list->user_name;
		$followClass1 = 'follow_btn1';
		$followText1= stripslashes($this->lang->line('onboarding_follow'));
		if ($followText1 == ''){
			$followText1 = 'Follow';
		}
		if ($loginCheck != ''){
	        $followingListArr = explode(',', $userDetails->row()->following);
	        if (in_array($store_list->id, $followingListArr)){
	        	$followClass1 = 'following_btn1';
	        	$followText1= stripslashes($this->lang->line('display_following'));
		        if ($followText1 == ''){
					$followText1 = 'Following';
				}
	        }
        } 
?>
                  <div class="suggestion-strip-container"  style="height:auto;">
                    <div class="suggestion-strip followable-resource">
                      <div class="suggestion-strip-description"> <a class="preview-strip-description-avatar" href="user/<?php echo $store_list->user_name;?>"><img width="45px" src="images/users/<?php echo $userImg;?>" class="avatar-image avatar-x45 " alt="jadenkenneth"></a>
                        <div class="suggestion-strip-description-text"> <a title="jadenkenneth" class="name" href="user/<?php echo $store_list->user_name;?>">@<?php echo $store_name;?></a>
                          <div class="suggestion-strip-actions"> 
                          
                          <!--<a resource="User" rel="nofollow" data-remote="true" data-method="post" class="suggestion-follow-link <?php if ($loginCheck==''){echo 'sign_box';}?>" <?php if ($loginCheck != ''){?>data-uid="<?php echo $store_list->id;?>" onclick="javascript:store_follow1(this);"<?php }?> ><?php echo $followText;?></a>-->
                          
                          <a class="<?php echo $followClass1.' '; if ($loginCheck==''){echo 'sign_box';}?>" <?php if ($loginCheck != ''){?>data-uid="<?php echo $store_list->id;?>" onclick="javascript:store_follow1(this);"<?php }?> ><?php echo $followText1;?></a>
                          
                          
                          
                           </div>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="suggestion-strip-products">
                        <?php 
                                      if ($topPeople['prodDetails'][$store_list->id]->num_rows()>0){
                                      	$limitCount = 0;
                                      	foreach ($topPeople['prodDetails'][$store_list->id]->result() as $store_products){
											if ($limitCount==4)break;$limitCount++;
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
                        <a href="things/<?php echo $store_products->PID;?>/<?php echo url_title($store_products->product_name,'-');?>"><img src="images/product/thumb/<?php echo $prodImg;?>" itemprop="image" class="product-image product-x110" alt="<?php echo $store_products->product_name; ?>"></a>
                        <?php 
                                      	}
                                      }
                                      ?>
                      </div>
                    </div>
                  </div>
                  <?php 
	}}
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
              <div class="activity-feed-store-suggestions">
                <div class="suggestion-strips store-suggestions">
                  <div class="header">
                    <h4><?php if($this->lang->line('story_to_follow') != '') { echo stripslashes($this->lang->line('story_to_follow')); } else echo "Stores to follow"; ?></h4>
                    <a class="suggestions-view-all" href="<?php echo base_url(); ?>stores/"><?php if($this->lang->line('story_viewall') != '') { echo stripslashes($this->lang->line('story_viewall')); } else echo "View all"; ?></a> </div>
                  <?php 
if (count($topStores)>0 && $topStores['store_lists']->num_rows()>0){
$topStorescount='0';
	foreach ($topStores['store_lists']->result() as $store_list){
	$topStorescount=$topStorescount+1;
	if($topStorescount < 4){
		$userImg = 'dummy_store_logo.png';
		if ($store_list->store_logo != ''){
			if (file_exists('images/store/'.$store_list->store_logo)){
				$userImg = $store_list->store_logo;
			}
		}
		$store_name = $store_list->store_name;
//		if ($store_name == '')$store_name = $store_list->user_name;
		$followClass2 = 'follow_btn2';
		$followText2= stripslashes($this->lang->line('onboarding_follow'));
		if ($followText2 == ''){
			$followText2 = 'Follow';
		}
		if ($loginCheck != ''){
			$followingListArr = explode(',', $store_list->followers);
			if (in_array($loginCheck, $followingListArr)){
	        	$followClass2 = 'following_btn2';
	        	$followText2= stripslashes($this->lang->line('display_following'));
		        if ($followText2 == ''){
					$followText2 = 'Following';
				}
	        }
        } 
		
	
		
?>
                  <div class="suggestion-strip-container"  style="height:auto;">
                    <div class="suggestion-strip followable-resource">
                      <div class="suggestion-strip-description"> <a class="preview-strip-description-avatar" href="store/<?php echo $store_list->store_url;?>"><img width="45px" src="images/store/<?php echo $userImg;?>" class="avatar-image avatar-x45 " alt=""></a>
                        <div class="suggestion-strip-description-text"> <a title="<?php echo $store_list->store_name;?>" class="name" href="store/<?php echo $store_list->store_name;?>"><?php echo $store_list->store_name;?></a>
                          <div class="suggestion-strip-actions"> 
                          
                          
                          
                          <a class="<?php echo $followClass2.' '; if ($loginCheck==''){echo 'sign_box';}?>" <?php if ($loginCheck != ''){?>data-uid="<?php echo $store_list->id;?>" onclick="javascript:follow_store1(this);"<?php }?> ><?php echo $followText2;?></a>
                          
                          
                          
                           </div>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="suggestion-strip-products">
                        <?php 
                                      if ($topStores['prodDetails'][$store_list->id]->num_rows()>0){
                                      	$limitCount = 0;
                                      	foreach ($topStores['prodDetails'][$store_list->id]->result() as $store_products){
											if ($limitCount==4)break;$limitCount++;
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
											$prod_uname = $store_products->user_name;
											if ($prod_uname=='') $prod_uname='anonymous';
                                      ?>
                        <a href="user/<?php echo $prod_uname;?>/things/<?php echo $store_products->seller_product_id;?>/<?php echo str_replace(' ','-',$store_products->product_name);?>"><img src="images/product/thumb/<?php echo $prodImg;?>" itemprop="image" class="product-image product-x110" alt="<?php echo $store_products->product_name; ?>"></a>
                        <?php 
                                      	}
                                      }
                                      ?>
                      </div>
                    </div>
                  </div>
                  <?php 
	}}
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
		
	</div>
   		
	</div>
	</div>
    
    </div>
    
 </div>  
 </section>
	<!-- / container -->
</div>






<?php
$this->load->view('site/templates/footer',$this->data);
?>














