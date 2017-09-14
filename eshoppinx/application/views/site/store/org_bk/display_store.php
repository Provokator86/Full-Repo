<?php
$this->load->view('site/templates/header',$this->data);
//$this->load->view('site/templates/popup_product_detail.php',$this->data);

?>
<style>
.usersection_social {
	padding: 0 0 15px 0px;
	float: left;
}
.usersection_social li {
	float: left;
	width: 16px;
	height: 16px;
	overflow: hidden;
	white-space: nowrap;
	margin-right: 6px;
	line-height: 0px;
}
.usersection_social a {
	color: #3f6a9f;
}
.usersection_social a:hover {
	color: #41628a;
	text-decoration: none;
}
.social_media_icons{
	display: inline-block;
	vertical-align: middle;
	background-image: url(./images/site/user-icon.png) !important;
	background-repeat: no-repeat;
	background-size: 200px 200px;
	width: 16px;
	height: 16px;
}
.ic_fb{
	background-position: 0 -94px;
}
.ic_tw{
	background-position: -20px -94px;
}
.ic_go{
	background-position: -60px -94px;
}
.feed_link{
	background: url('images/site/user-icon.png') no-repeat -77px -95px;
	width: 19px;
	overflow: hidden;
	float: left;
	height: 12px;
	float: left;
	margin-top: 6px;
	margin-left: 5px;
}


.info_links {
	clear: both;
	width: 200px;
	/*position: absolute;
	top: 200px;
	left: -1px;*/
	height: 28px;
	padding: 10px;
	background: white;
	font-size: 12px;
	border-top: 1px solid #d4d4d4;
}
.product_main_thumb .info_links a {
	height: 13px;
}
.info_links > a > img {
	float: left;
	margin: 0 6px 0 0;
	width: 30px;
	height: 30px;
}
.info_links > a.collection_name {
	display: block;
	width: 135px;
	overflow: hidden;
	white-space: nowrap;
	text-overflow: ellipsis;
	margin: 0;
	line-height: 13px;
	color: #aaa;
	position: relative;
    top: -8px;
}
.info_links > a.info_uname {
	display: block;
	width: 135px;
	overflow: hidden;
	white-space: nowrap;
	text-overflow: ellipsis;
	margin: 0;
	font-weight: bold;
	line-height: 14px;
	color: #777;
	position: relative;
    top: -10px;
}


.product_main{
background:#fff;
}
.tab_product{
background: #fff;
border: 1px solid #dadada;
}
.tab_box {
float: left;
width: 100%;
}
.boxgrid{height:220px;}
</style> 
<!-- Section_start -->
    <section>
    
        <div class="section_main">
        
            <div class="main3">
                <div class="main_box">
            <?php if($flash_data != '') { ?>
		<div class="errorContainer" id="<?php echo $flash_data_type;?>">
			<script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 3000);</script>
			<p><span><?php echo $flash_data;?></span></p>
		</div>
		<?php } ?>
		        
					<?php $this->load->view('site/store/store_menu',$this->data); ?>
                    
                    <div class="profile_tab">
                    <div class="tab_product">
                        <ul class="tab_box">
                            <li><a class="tab_active"><strong></strong><span><?php if($this->lang->line('templates_products') != '') { echo stripslashes($this->lang->line('templates_products')); } else echo "Products"; ?></span></a></li>
                            <li><a href="<?php echo base_url();?>store/<?php echo $store_details->row()->store_url;?>/trending"><strong></strong><span><?php if($this->lang->line('trending_trend') != '') { echo stripslashes($this->lang->line('trending_trend')); } else echo "Trending"; ?></span></a></li>
                            <?php if($storelogoDetails->row()->user_id>0) { ?>
                            	<li><a href="<?php echo base_url();?>store/<?php echo $store_details->row()->store_url;?>/collections"><strong></strong><span><?php echo "Collections"; ?></span></a></li>
                            	<li><a href="<?php echo base_url();?>store/<?php echo $store_details->row()->store_url;?>/stories"><strong></strong><span><?php echo "Stories"; ?></span></a></li>
                            <?php } ?>     
                        </ul>
                    </div>
                    </div>
                    
                    <div class="product_main">
                       <?php if($product_details->num_rows()>0){?>
                            <ul class="product_main_thumb">
            				<?php 
            				foreach ($product_details->result() as $productLikeDetailsRow){
            					$imgName = 'dummyProductImage.jpg';
            					$imgArr = explode(',', $productLikeDetailsRow->image);
            					if (count($imgArr)>0){
            						foreach ($imgArr as $imgRow){
            							if ($imgRow!=''){
            								if (file_exists('images/product/thumb/'.$imgRow)){
	            								$imgName = $imgRow;
    	        								break;
            								}
            							}
            						}
            					}
            					$fancyClass = 'fancy';
            					$fancyText = LIKE_BUTTON;
            					if (count($likedProducts)>0 && $likedProducts->num_rows()>0){
            						foreach ($likedProducts->result() as $likeProRow){
            							if ($likeProRow->product_id == $productLikeDetailsRow->seller_product_id){
            								$fancyClass = 'fancyd';$fancyText = LIKED_BUTTON;break;
            							}
            						}
            					}
            					$userImg = 'default_user.jpg';
								if ($productLikeDetailsRow->thumbnail != ''){
									$userImg = $productLikeDetailsRow->thumbnail;
								} 
            					if (isset($productLikeDetailsRow->web_link)){
            						$prod_link = 'user/'.$productLikeDetailsRow->user_name.'/things/'.$productLikeDetailsRow->seller_product_id.'/'.str_replace(' ','-',$productLikeDetailsRow->product_name);
            					}else {
            						$prod_link = 'things/'.$productLikeDetailsRow->id.'/'.str_replace(' ','-',$productLikeDetailsRow->product_name);
            					}
            					if ($productLikeDetailsRow->user_name == ''){
	            					$fullName = 'administrator';
            					}else {
            						$fullName = $productLikeDetailsRow->full_name;
            						if ($fullName == ''){
            							$fullName = $productLikeDetailsRow->user_name;
            						}else {
            							$fullName = character_limiter($fullName,20);
            							if (strlen($fullName)>20){
											$fullName = substr($fullName, 0,20).'..';
            							}
            						}
            					}
								
								$userName = $productLikeDetailsRow->user_name;
								if($userName == ''){
								$userName = 'administrator';
								}
								
							?>

                                    <!--<li class="boxgrid captionfull"><a class="example16" data-pid="<?php echo $productLikeDetailsRow->seller_product_id;?>" href="things/<?php echo $productLikeDetailsRow->seller_product_id;?>/<?php echo str_replace(' ','-',$productLikeDetailsRow->product_name);?>"><img src="images/product/thumb/<?php echo $imgName;?>" /></a>-->
                                    
                                    
                                    <li class="boxgrid captionfull">
                                    <a data-pid="<?php echo $productLikeDetailsRow->seller_product_id;?>" href="<?php echo $prod_link;?>"><img src="images/product/thumb/<?php echo $imgName;?>" /></a>
                                    
                                     <!--<div class="info_links">
                                        	<a href="user/<?php echo $userName;?>"><img src="images/users/<?php echo $userImg;?>"/></a>
                                        	<a class="info_uname" href="user/<?php echo $userName;?>"><?php echo $fullName;?></a>
                                        	<a class="collection_name" href="<?php echo $prod_link;?>"><?php echo $productLikeDetailsRow->product_name;?></a>
                                        </div>-->
                                    
                                        <div class="cover boxcaption">
                                                
                                                  
                                                 <div class="tag <?php if ($loginCheck==''){echo 'sign_box';}else {echo 'tag_box';}?>" data-pid="<?php echo $productLikeDetailsRow->seller_product_id;?>">
                                                      
                                                        <strong><?php if($this->lang->line('product_tag') != '') { echo stripslashes($this->lang->line('product_tag')); } else echo "Tag"; ?></strong>
                                                        
                                                        <span><?php if($this->lang->line('product_afreiend') != '') { echo stripslashes($this->lang->line('product_afreiend')); } else echo "a friend"; ?></span>
                                                  
                                                  </div>
                                                  
                                                    <div class="save <?php if ($loginCheck==''){echo 'sign_box';}?>" data-pid="<?php echo $productLikeDetailsRow->seller_product_id;?>">
                                                      
                                                        <strong><?php if($this->lang->line('header_save') != '') { echo stripslashes($this->lang->line('header_save')); } else echo "Save"; ?></strong>
                                                        
                                                        <span><?php echo $productLikeDetailsRow->likes;?> <?php if($this->lang->line('product_saves') != '') { echo stripslashes($this->lang->line('product_saves')); } else echo "saves"; ?></span>
                                                  
                                                  </div>
                                                  
                                                  <div class="deal_tag_title">
                                                  
                                                    <h2 style="padding-top: 0px;"> <a class="" data-pid="<?php echo $productLikeDetailsRow->seller_product_id;?>" href="<?php echo $prod_link;?>"><?php echo character_limiter($productLikeDetailsRow->product_name,25);?></a></h2>
                                                    <?php 
                                                    
                                                    ?>
                                                    <p><?php if($this->lang->line('story_postedby') != '') { echo stripslashes($this->lang->line('story_postedby')); } else echo "posted by"; ?> <a href="<?php if ($productLikeDetailsRow->user_name == ''){echo 'user/administrator';}else {echo 'user/'.$productLikeDetailsRow->user_name;}?>"><?php echo $fullName;?></a> | <span> <?php if (!isset($productLikeDetailsRow->web_link)){echo $currencySymbol.$productLikeDetailsRow->sale_price;}else {echo $currencySymbol;?><?php echo $productLikeDetailsRow->price;}?> </span></p>
                                                    
                                                  </div>
                                                  
                                            
                                         </div>
                                    
                                    </li>
             <?php }?>                       
                            </ul>
                  		<?php }else {?>
                        <div class="no-result">
                        <b style="padding: 20px;float: left;text-align: right;width: 97%;"><?php if($this->lang->line('product_noavail') != '') { echo stripslashes($this->lang->line('product_noavail')); } else echo "No products available"; ?></b>
                        </div>
                        <?php }?>
                    
                    </div>
                    
                  </div>
            
            </div>
        
        
        
        </div>
    
        
        
    
    </section>
<!-- Section_end -->
<?php
$this->load->view('site/templates/footer');
?>