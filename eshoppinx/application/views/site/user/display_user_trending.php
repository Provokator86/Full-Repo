<?php
$this->load->view('site/templates/header',$this->data);
$this->load->view('site/templates/popup_product_detail.php',$this->data);

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
</style> 
<!-- Section_start -->
    <section>
    
        <div class="section_main">
        
            <div class="main3">
            
                <div class="main_box">
                <?php 
                $this->data['followingUserDetails'] = $userProfileDetails;
		       	$this->load->view('site/user/display_user_header',$this->data);
		        ?>
                   
                <div class="tab_product">
                    <ul class="tab_box">
                        <li><a href="user/<?php echo $userProfileDetails->row()->user_name;?>"><strong></strong><span><?php if($this->lang->line('user_saved') != '') { echo stripslashes($this->lang->line('user_saved')); } else echo "Saved"; ?></span></a></li>
                        <li><a href="user/<?php echo $userProfileDetails->row()->user_name;?>/added"><strong></strong><span><?php if($this->lang->line('display_added') != '') { echo stripslashes($this->lang->line('display_added')); } else echo "Added"; ?></span></a></li>
                        <li><a href="user/<?php echo $userProfileDetails->row()->user_name;?>/lists"><strong></strong><span><?php if($this->lang->line('user_collections') != '') { echo stripslashes($this->lang->line('user_collections')); } else echo "Collections"; ?></span></a></li> 	
                        <li><a href="user/<?php echo $userProfileDetails->row()->user_name;?>/stories"><strong></strong><span><?php if($this->lang->line('story_stores') != '') { echo stripslashes($this->lang->line('story_stores')); } else echo "Stories"; ?></span></a></li> 
                        <?php if($userProfileDetails->row()->group=='Seller') { ?>
                            <li><a class="tab_active" href="user/<?php echo $userProfileDetails->row()->user_name;?>/trending"><strong></strong><span>Trending</span></a></li>
                        <?php } ?>
                    </ul>
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
            					if ($productLikeDetailsRow->web_link != 'None'){
            						$prod_link = 'user/'.$productLikeDetailsRow->user_name.'/things/'.$productLikeDetailsRow->seller_product_id.'/'.url_title($productLikeDetailsRow->product_name,'-');
            					}else {
            						$prod_link = 'things/'.$productLikeDetailsRow->id.'/'.url_title($productLikeDetailsRow->product_name,'-');
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
							?>

                                    <li class="boxgrid captionfull add-page"><a class="" data-pid="<?php echo $productLikeDetailsRow->seller_product_id;?>" href="<?php echo $prod_link;?>"><img src="images/product/thumb/<?php echo $imgName;?>" /></a>
                                    
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
                                                    
                                                    <p><?php if($this->lang->line('story_postedby') != '') { echo stripslashes($this->lang->line('story_postedby')); } else echo "posted by"; ?> <a href="<?php if ($productLikeDetailsRow->user_name == ''){echo 'user/administrator';}else {echo 'user/'.$productLikeDetailsRow->user_name;}?>"><?php echo $fullName;?></a> | <span> <?php if (!isset($productLikeDetailsRow->web_link)){echo $currencySymbol.$productLikeDetailsRow->sale_price;}else {echo $currencySymbol;?><?php echo $productLikeDetailsRow->price;}?> </span></p>
                                                    
                                                  </div>
                                                  
                                                  
                                                
                                         </div>
                                    
                                    </li>
             <?php }?>                       
                            </ul>
                  		<?php }else {?>
                        <div class="no-result">
                        <?php 
                        if ($userProfileDetails->row()->products>0){
                        ?>
                        <b><?php echo $products_list_row->likes;?> <?php if($this->lang->line('product_unavail') != '') { echo stripslashes($this->lang->line('product_unavail')); } else echo "Product details not available"; ?></b>
                        <?php }else {
                        $userName = $userProfileDetails->row()->full_name;
                        if ($userName == ''){
	                        $userName = $userProfileDetails->row()->user_name;
                        }
                        ?>
                        <b><?php echo $userName;?></b> <?php if($this->lang->line('display_has_not') != '') { echo stripslashes($this->lang->line('display_has_not')); } else echo "has not"; ?> <?php echo 'added';?> <?php if($this->lang->line('display_any_yet') != '') { echo stripslashes($this->lang->line('display_any_yet')); } else echo "anything yet"; ?>.
                        <?php }?>
                        </div>
                        <?php }?>
                    
                    </div>
                    
                  </div>
            
            </div>
        
        

        
        </div>
    
        
        
    
    </section>
<!-- Section_end -->
<script type="text/javascript">
$('.example16').click(function(){
	$('#inline_example11 .popup_page').html('<div class="cnt_load"><img src="images/ajax-loader.gif"/></div>');
	var pid = $(this).data('pid');
	var pname = $(this).text();
	var purl = baseURL+$(this).attr('href');
	$.ajax({
		type:'get',
		url:baseURL+'site/product/get_product_popup',
		data:{'pid':pid},
		dataType:'html',
		success:function(data){
			window.history.pushState({"html":data,"pageTitle":pname},"", purl);
			$('#inline_example11 .popup_page').html(data);
		}
	});
});
</script>
<?php
$this->load->view('site/templates/footer');
?>