<?php
include_once 'application/views/site/user/make_user_link.php';
$make_user_link = new MyCallback($users_list);
$this->load->view('site/templates/header');
$this->load->view('site/templates/popup_product_detail.php',$this->data);
?>
<link rel="stylesheet" href="css/site/my-account.css" type="text/css" media="all"/>

<style>
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
.option_lbl{
	background: #009F23;
	text-align: center;
	border: none;
	border-radius: 1px 1px 1px 1px;
	color: #FFFFFF;
	float: left;
	font-family: Arial,Helvetica,sans-serif;
	font-size: 22px;
	letter-spacing: 1px;
	line-height: 1;
	margin: 0;
	font-weight: normal;
	outline: none;
	padding: 12px 37px;
	position: relative;
	text-decoration: none;
	text-transform: capitalize;
	margin-top: 3px;
	min-width: 85px;
}
#attr_name_id,#quantity{
	border: 1px solid #D1D3D9;
	width: 145px;
	background: #F5F4F4;
	color: #333333;
	height: 45px;
	padding: 0px 2px;
	line-height: 50px;
	float: left;
	font-size: 13px;
	min-width: 92px;
	margin: 3px 10px;
}
#quantity{
	width: 137px;
}
.social_share a{
	background: url('images/sprits_icon.png') no-repeat;
	float: left;
	margin: 10px 5px 0 0;
	text-indent: -9999px;
	width: 25px;
	height: 25px;
	background-position: -150px -148px;
	background-size: 1910%;
}
.social_share a.tw{
	background-position: -123px -148px;
}
.social_share a.gg{
	background-position: -121px -238px;
}
</style>

<script type="text/javascript" src="js/site/SpryTabbedPanels.js"></script>
<script type="text/javascript" src="js/site/jcarousellite_1.0.1.pack.js"></script>

<script type="text/javascript">
		$(function() {
    		$(".slider_1").jCarouselLite({
        		btnNext: ".prev_1",
        		btnPrev: ".next_1",
				auto: false,
				speed: 800,
        		visible:<?php echo sizeof($MoreProduct)-2;?>
    		});
		});
</script>
<!-- Section_start -->
<?php 
$current_user_img = 'default_user.jpg';
if ($loginCheck != ''){
	if ($userDetails->row()->thumbnail != ''){
		if (file_exists('images/users/'.$userDetails->row()->thumbnail)){
			$current_user_img = $userDetails->row()->thumbnail;
		}
	}
}
if ($productDetails->num_rows()==0){
?>
<div class="cnt_load"><?php if($this->lang->line('product_unavail') != '') { echo stripslashes($this->lang->line('product_unavail')); } else echo "Product details not available"; ?></div>
<?php 
}else {
	$userImg = 'default_user.jpg';
	if ($productDetails->row()->thumbnail != ''){
		if (file_exists('images/users/'.$productDetails->row()->thumbnail)){
			$userImg = $productDetails->row()->thumbnail;
		}
	}
	$prodImg = 'dummyProductImage.jpg';
	$prodImgArr = array_filter(explode(',', $productDetails->row()->image));
	if (count($prodImgArr)>0){
		foreach ($prodImgArr as $prodImgArrRow){
			if (file_exists('images/product/'.$prodImgArrRow)){
				$prodImg = $prodImgArrRow;
				break;
			}
		}
	}
	$userName = 'administrator';
    $fullName = 'administrator';
    if ($productDetails->row()->user_id > 0){
    	$userName = $productDetails->row()->user_name;
    	$fullName = $productDetails->row()->full_name;
    }
    if ($fullName == '') $fullName=$userName;
    $followClass = 'follow_btn';
	$followText  = 'Follow';
	if ($loginCheck != ''){
        $followingListArr = explode(',', $userDetails->row()->following);
        if (in_array($productDetails->row()->user_id, $followingListArr)){
        	$followClass = 'following_btn';
        	$followText = 'Following';
        }
	} 
?>
<section>
<?php if($flash_data != '') { ?>
		<div class="errorContainer" id="<?php echo $flash_data_type;?>">
			<script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 3000);</script>
			<p><span><?php echo $flash_data;?></span></p>
		</div>
		<?php } ?>
<?php 
    if ($loginCheck==''){
    ?>
    <div class="join-banner">
    	<div class="main2">
        	<h2>Find and buy the most amazing products online.</h2>
            <div class="join-butons">
            	<a class="banner_join_btn log_box" href="#">Join</a>
                <a class="banner_sign_btn banner_join_btn sign_box " href="#">Sign In</a>
            </div>
        </div>
    </div>
    <div class="main2">
    	<div class="detail_products" style="margin-top:120px;">
    		<div class="product-attribution-container yellow" style="background:#FFF; float: left; width: 40%; margin:0 0 0 80px;">
      <div class="container">
        <div class="inner-container">
          <div class="product-attribution-container-user-avatar"> <a href="user/<?php echo $userName;?>"><!--<img src="images/users/default_user.jpg"  class="avatar-image avatar-x200 "/>--><img src="images/users/<?php echo $userImg;?>"  class="avatar-image avatar-x200 "/></a> </div>
          <div class="product-attribution-container-info">
            <div class="product-attribution-container-info-message">
            <h2><a href="user/<?php echo $userName;?>" class="products-show-poster-details-username"><?php echo $fullName;?></a> <?php if($this->lang->line('product_postedto') != '') { echo stripslashes($this->lang->line('product_postedto')); } else echo "posted this to"; ?> <?php echo $siteTitle;?></h2>
            <!--<div class="clear" style="height: 10px;"></div>-->
            <abbr title="" class="timeago"><?php if($this->lang->line('settings_about') != '') { echo stripslashes($this->lang->line('settings_about')); } else echo "about"; ?> <?php $time_ago1 =strtotime($productDetails->row()->created); echo timespan($time_ago1); ?></abbr>
           </div>
            <div class="product-attribution-container-info-savers">
              <div class="products-show-more-savers">
              </div>
            </div>
          </div>
        </div>
        <div class="product-attribution-show-triangle"></div>
      </div>
    </div>
    <div class="savers-attribution">
        <div class="products-show-more-savers-text">
        	<a href="saved-peoples/<?php echo $productDetails->row()->seller_product_id; ?>"><?php echo $seller_prod->num_rows(); ?> peoples</a> saved this from 
            <a class="products-show-poster-details-username" href="user/<?php echo $userName;?>"><?php echo $fullName;?></a>
        </div>
        <div class="saver-grid">
            <?php foreach ($user_image->result() as $cmtrow) { ?>
	            <a href="user/<?php echo $cmtrow->user_name; ?>"><img src="images/users/<?php if($cmtrow->thumbnail!=''){ echo $cmtrow->thumbnail;}else{echo 'user-thumb1.png';}?>" /></a>
            <?php } ?>    
        </div>
    </div>
    <div class="product-description">
    	<div class="product-description-left">
        	<!--<a href="#"><img src="images/x354.jpg" /></a>-->
            <a href="#"><img src="images/product/<?php echo $prodImg;?>" /></a>
        </div>
        <div class="product-description-right">
        	<!--<h1>Small Round Chevron Pet Bed</h1>-->
            <h1><?php echo $productDetails->row()->product_name;?></h1>
            <div class="price-tag">
				<span class="minimal"><?php echo $currencySymbol?><span class="price-tag-text"><?php echo $productDetails->row()->price;?></span></span>
				from
				<!--<a href="#">Dogccessories</a>-->
                <a href="user/<?php echo $userName;?>"><?php echo $fullName;?></a>
			</div>
            <a href="#" class="sign-save sign_box">Sign in to save or buy this product</a>
        </div>
        
        </div>
    </div>
    
       <div class="TabbedPanels" id="TabbedPanels1">
     	<ul class="TabbedPanelsTabGroup">
			<li tabindex="0" class="TabbedPanelsTab  TabbedPanelsTabSelected"><?php if($this->lang->line('item_details') != '') { echo stripslashes($this->lang->line('item_details')); } else echo "Item Details"; ?></li>
            <li tabindex="0" class="TabbedPanelsTab">
                <div class="rating_star">
					<?php foreach($product_feedback as $feedbacks) { $totals = $totals+$feedbacks['rating']; }  $totalratingstars = $totals/count($product_feedback); ?>
                    <!--<div class="rat_star1" style="width:<?php echo round($totalratingstars) * 20; ?>%"></div>-->
                    <div class="rat_star1" style="width:<?php echo ($totalratingstars) * 20; ?>%"></div>
                </div>
                (<?php  echo $rownum = count($product_feedback); ?>)
            </li>
			<li tabindex="0" class="TabbedPanelsTab"><?php if($this->lang->line('shipping_policies') != '') { echo stripslashes($this->lang->line('shipping_policies')); } else echo "Shipping & Policies"; ?></li>
			<li tabindex="0" class="TabbedPanelsTab"><?php if($this->lang->line('xchange_policy') != '') { echo stripslashes($this->lang->line('xchange_policy')); } else echo "Exchange Policy"; ?></li>
			<li tabindex="0" class="TabbedPanelsTab"><?php if($this->lang->line('payment_details') != '') { echo stripslashes($this->lang->line('payment_details')); } else echo "Payment Details"; ?></li>
		</ul>
		<div class="TabbedPanelsContentGroup">
			<div class="TabbedPanelsContent  TabbedPanelsContentVisible" style="display: block;">
				<?php 
		      		echo $productDetails->row()->description;
		      	?>
			</div>
            <div class="TabbedPanelsContent" style="display: none;">
                           <?php  
                           $rownum = count($product_feedback); 
						   
                           if ($rownum>0){
                           foreach($product_feedback as $feedback) { 
                           	$pimg = 'dummyproductimage.jpg';
                           	$pimg_arr = array_filter(explode(',', $feedback['image']));
                           	if (count($pimg_arr)>0){
                           		foreach ($pimg_arr as $pimg_row){
                           			if (file_exists('images/product/'.$pimg_row)){
                           				$pimg = $pimg_row;break;
                           			}
                           		}
                           	}
                           	$total = $total+$feedback['rating'];?>
                            <div class="tabbed_review">
                            	<div class="tabbed_left">
                                	<a href="user/<?php echo $feedback['user_name']; ?>"><img src="images/users/<?php if($feedback['thumbnail']!='') { echo $feedback['thumbnail']; } else { echo 'user-thumb1.png'; } ?>" width="30px" height="30px" /></a>
                                    <span><?php if($this->lang->line('reviewed_by') != '') { echo stripslashes($this->lang->line('reviewed_by')); } else echo "Reviewed By"; ?></span>
                                    <p><a href="user/<?php echo $feedback['user_name']; ?>"><?php echo $feedback['full_name']; ?></a></p>
                                </div>
                                <div class="tabbed_right">
                                	<div class="tabbed_top">
                                		<div class="rating_star">
                                            <div class="rat_star1" style="width:<?php echo $feedback['rating']*20; ?>%"></div>
                                        </div>
                                   		<span class="date"><?php echo date("M d Y", strtotime($feedback['dateAdded'])); ?></span>
                                    </div>    
                                    <span class="tab_rev_title"><?php echo $feedback['title']; ?></span>
                                    <!--<a style="float: left;margin: 0px 0 0 20px;width: 30px;" href="things/<?php echo $feedback['product_id']; ?>/<?php echo url_title($feedback['product_name'],'-');?>">
                                    	<img src="images/product/<?php echo $pimg; ?>" width="30px" />
                                    </a>-->
                                    <span class="tab_rev_txt">
                                    	<a style="float: left;margin: 0px 0 0 15px;width: 30px;" href="things/<?php echo $feedback['product_id']; ?>/<?php echo url_title($feedback['product_name'],'-');?>">
                                    		<img src="images/product/<?php echo $pimg; ?>" width="30px" />
                                    	</a>&nbsp;
									<?php echo $feedback['description']; ?> </span>
                                </div>
                            </div>
                            <?php } }else {?>
                            <p></p>
                            <?php }?>
                          </div>
			<div class="TabbedPanelsContent" style="display: none;">
				<?php 
		      		echo $productDetails->row()->shipping_policies;
		      	?>
			</div>
			<div class="TabbedPanelsContent" style="display: none;">
				<?php 
		      		echo $productDetails->row()->xchange_policy;
		      	?>
				<div class="clear"></div>
			</div>
			<div class="TabbedPanelsContent" style="display: none;">
				<?php 
		      		echo stripslashes($this->config->item('payment_details'));
		      	?>
				<div class="clear"></div>
			</div>
			<script type="text/javascript" class="" style="display: none;">
			var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
			</script>
		</div>
	</div>
    
		</div>
        
        
    <div class="tweet_comments_main" style="padding-left:80px;"> <a class="tweet_seemore" href="javascript:void(0);"><?php if($this->lang->line('product_comments') != '') { echo stripslashes($this->lang->line('product_comments')); } else echo "Comments"; ?></a>   
        
        
    <?php 
    if ($productComment->num_rows() > 0){
        foreach ($productComment->result() as $cmtrow){
	    	$cmt_uname = $cmtrow->full_name;
	        if ($cmt_uname==''){
	        	$cmt_uname = $cmtrow->user_name;
	        }
            if ($cmtrow->status == 'Active'){
                
        
    ?>
    <div class="tweet_comment"> <span class="tweet_comment_avatar"><img src="images/users/<?php if($cmtrow->thumbnail!=''){ echo $cmtrow->thumbnail;}else{echo 'user-thumb.png';}?>" /></span>
<div class="comments_detail_content"> <a class="comments_detail_name" href="<?php echo base_url();?>user/<?php echo $cmtrow->user_name;?>"><?php echo ucfirst($cmt_uname);?></a> 
<p class="comments_detail_email cmt_cnt_<?php echo $cmtrow->id;?>"><!--<a href="#">@keels54</a>--> 
<?php 
                      	$cmt = preg_replace_callback("/@(\w+)/", array($make_user_link, 'make_user_link'), $cmtrow->comments);
						echo preg_replace("/#(\w+)/", "<a target=\"_self\" href=\"".base_url()."tag/$1\">#$1</a>", $cmt);
                      ?>
</p> <span class="comments_detail_day"><?php  $time_ago =strtotime($cmtrow->dateAdded);
echo time_stamp($time_ago); ?> </span> </div>
<?php 
if ($loginCheck != '' && $loginCheck == $productDetails->row()->user_id || $loginCheck != '' && $loginCheck == $cmtrow->CUID){
?>
<p style="float:left;width:100%;text-align:left;">
<?php if ($loginCheck == $cmtrow->CUID){?>
            <a style="font-size: 11px; color: #0033FF;cursor:pointer;" onclick="javascript:editCmt(this);" data-uid="<?php echo $cmtrow->CUID;?>" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('shipping_edit') != '') { echo stripslashes($this->lang->line('shipping_edit')); } else echo "Edit"; ?></a>
<?php }?>
            <a style="font-size: 11px; color: #f33;cursor:pointer;" onclick="javascript:deleteCmt(this);" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('product_delte') != '') { echo stripslashes($this->lang->line('product_delte')); } else echo "Delete"; ?></a>
<?php ?>        </p>
<?php 
}
?>        
</div>
    <?php 
            }else {
                if ($loginCheck != '' && $loginCheck == $productDetails->row()->user_id){
    ?>
    <div class="tweet_comment"> <span class="tweet_comment_avatar"><img src="images/users/<?php if($cmtrow->thumbnail!=''){ echo $cmtrow->thumbnail;}else{echo 'user-thumb.png';}?>" /></span>
<div class="comments_detail_content"> <a class="comments_detail_name" href="<?php echo base_url();?>user/<?php echo $cmtrow->user_name;?>"><?php echo ucfirst($cmt_uname);?></a> 
<p class="comments_detail_email cmt_cnt_<?php echo $cmtrow->id;?>"> 
<?php 
                      	$cmt = preg_replace_callback("/@(\w+)/", array($make_user_link, 'make_user_link'), $cmtrow->comments);
						echo preg_replace("/#(\w+)/", "<a target=\"_self\" href=\"".base_url()."tag/$1\">#$1</a>", $cmt);
                      ?> 
</p> <span class="comments_detail_day"><?php  $time_ago =strtotime($cmtrow->dateAdded);
echo time_stamp($time_ago); ?> </span> </div>
<p style="float:left;width:100%;text-align:left;">
            <a style="font-size: 11px; color: #188A0E;cursor:pointer;" onclick="javascript:approveCmt(this);" data-uid="<?php echo $cmtrow->CUID;?>" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('product_approve') != '') { echo stripslashes($this->lang->line('product_approve')); } else echo "Approve"; ?></a>
            <?php if ($loginCheck == $cmtrow->CUID){?>
            <a style="font-size: 11px; color: #0033FF;cursor:pointer;" onclick="javascript:editCmt(this);" data-uid="<?php echo $cmtrow->CUID;?>" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('shipping_edit') != '') { echo stripslashes($this->lang->line('shipping_edit')); } else echo "Edit"; ?></a>
			<?php }?>
            <a style="font-size: 11px; color: #f33;cursor:pointer;" onclick="javascript:deleteCmt(this);" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('product_delte') != '') { echo stripslashes($this->lang->line('product_delte')); } else echo "Delete"; ?></a>
        </p>
</div>
    
    <?php 		
                }else {
                    if ($loginCheck == $cmtrow->CUID){
    ?>
    
    <div class="tweet_comment"> <span class="tweet_comment_avatar"><img src="images/users/<?php if($cmtrow->thumbnail!=''){ echo $cmtrow->thumbnail;}else{echo 'user-thumb.png';}?>" /></span>
<div class="comments_detail_content"> <a class="comments_detail_name" href="<?php echo base_url();?>user/<?php echo $cmtrow->user_name;?>"><?php echo ucfirst($cmt_uname);?></a> 
<p class="comments_detail_email cmt_cnt_<?php echo $cmtrow->id;?>">
<?php 
                      	$cmt = preg_replace_callback("/@(\w+)/", array($make_user_link, 'make_user_link'), $cmtrow->comments);
						echo preg_replace("/#(\w+)/", "<a target=\"_self\" href=\"".base_url()."tag/$1\">#$1</a>", $cmt);
                      ?>
</p> <span class="comments_detail_day"><?php  $time_ago =strtotime($cmtrow->dateAdded);
echo time_stamp($time_ago); ?> </span> </div>
<p style="float:left;width:100%;text-align:left;font-size: 11px; color: #188A0E; cursor:pointer;">
            <?php if($this->lang->line('product_wait_appr') != '') { echo stripslashes($this->lang->line('product_wait_appr')); } else echo "Waiting for approval"; ?>
            <a style="font-size: 11px; color: #0033FF;cursor:pointer;" onclick="javascript:editCmt(this);" data-uid="<?php echo $cmtrow->CUID;?>" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('shipping_edit') != '') { echo stripslashes($this->lang->line('shipping_edit')); } else echo "Edit"; ?></a>
            <a style="font-size: 11px; color: #f33;margin-left:10pxcursor:pointer;" onclick="javascript:deleteCmt(this);" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('product_delte') != '') { echo stripslashes($this->lang->line('product_delte')); } else echo "Delete"; ?></a>
        </p>
</div>
    
    <?php 
                    }
                }

            }
        }
    }?>
    
<!--<div class="tweet_comment" style="background: none repeat scroll 0 0 #FAFAFA;"> <span class="tweet_comment_avatar"><img src="images/users/<?php echo $current_user_img;?>" /></span>
<div class="comments_detail_content"><form action="#" method="post" style="margin:0px;">
<input type="hidden" name="cproduct_id" id="cproduct_id" value="<?php echo $productDetails->row()->seller_product_id;?>"/>
<input type="hidden" name="user_id" id="user_id" value="<?php echo $loginCheck ;?>"/>
<textarea name="comments" placeholder="<?php if($this->lang->line('header_write_comment') != '') { echo stripslashes($this->lang->line('header_write_comment')); } else echo "Write a comment"; ?>..." id="comments" class="tweet_comments_links1"></textarea>

<input type="submit" <?php if($loginCheck==''){ ?>require-login='true'<?php }?> class="post_btn1 submit button" value="<?php if($this->lang->line('header_post_comment') != '') { echo stripslashes($this->lang->line('header_post_comment')); } else echo "Post"; ?>" />
</form>
</div> 
</div>-->
</div>
<div class="main2">
    <div class="relevant-products-container">
	    <h2 class="relevant-products-title">People who saved this product also saved </h2>
        <div class="relevant-products-grid">
            <div class="product_main">
            <?php if (count($products_list) > 0) { ?>
            	<ul class="product_main_thumb">
                	<?php 
							//$query = $query->result_array();
							//echo count($products_list);
							$products_list=$products_list->result_array();
                			foreach ($products_list as $products_list_row){
                				$prodImg = 'dummyProductImage.jpg';
                				$prodImgArr = array_filter(explode(',', $products_list_row['image']));
                				if (count($prodImgArr)>0){
                					foreach ($prodImgArr as $prodImgArrRow){
										if (file_exists('images/product/thumb/'.$prodImgArrRow)){
											$prodImg = $prodImgArrRow;
											break;	
										}
                					}
                				}
								$userName = 'administrator';
                				$fullName = 'administrator';
                				if ($products_list_row['user_id'] > 0){
									$sql = "select * from ".USERS." where id='".$products_list_row['user_id']."'";
									$query = $this->db->query($sql);
									$sliderResult = $query->row_array();
                					$userName = $sliderResult['user_name'];
                					$fullName = character_limiter($sliderResult['full_name'],20);
                					if (strlen($fullName)>20){
                						$fullName = substr($fullName, 0,20).'..';	
                					}
									$userImg = $sliderResult['thumbnail'];
                				}
								
                				if ($fullName == ''){
                					$fullName = $userName;
                				}
								
                				if ($userImg==''){
									$userImg = 'default_user.jpg';
                				}
								
								/*if(isset($products_list_row['web_link'])){
									$prod_link = 'user/'.$userName.'/things/'.$products_list_row['seller_product_id'].'/'.url_title($products_list_row['product_name'],'-');
								}else {
									$prod_link = 'things/'.$products_list_row['id'].'/'.url_title($products_list_row['product_name'],'-');
								}*/
								
								if($products_list_row['web_link'] != 'None'){
									$prod_link = 'user/'.$userName.'/things/'.$products_list_row['seller_product_id'].'/'.url_title($products_list_row['product_name'],'-');
								}else {
									$prod_link = 'things/'.$products_list_row['id'].'/'.url_title($products_list_row['product_name'],'-');
								}
                			?>
                                        <li class="boxgrid captionfull">
                                        <!--<a href="<?php echo $prod_link;?>"><img src="images/product/thumb/<?php echo $prodImg;?>" /></a>-->
                                        <a href="<?php echo $prod_link;?>"><img src="images/product/thumb/<?php echo $prodImg;?>" /></a>
                                        <div class="info_links">
                                        	<a href="user/<?php echo $userName;?>"><img src="images/users/<?php echo $userImg;?>"/></a>
                                        	<a class="info_uname" href="user/<?php echo $userName;?>"><?php echo $fullName;?></a>
                                            <a class="collection_name" href="<?php echo $prod_link;?>"><?php echo $products_list_row['product_name'];?></a>
                                        </div>
                                        	<div class="cover boxcaption">
<div id ="<?php echo $products_list_row['id'].'/'.$products_list_row['product_name'];?>" class="tag <?php if ($loginCheck==''){echo 'sign_box';}else {echo 'tag_box';}?>" data-pid="<?php echo $products_list_row['seller_product_id'];?>">
                           	                           		<strong><?php if($this->lang->line('product_tag') != '') { echo stripslashes($this->lang->line('product_tag')); } else echo "Tag"; ?></strong>
                                                            <span><?php if($this->lang->line('product_afreiend') != '') { echo stripslashes($this->lang->line('product_afreiend')); } else echo "a friend"; ?></span>
                                                      </div>
                                                      
                                                      <div class="save <?php if ($loginCheck==''){echo 'sign_box';}?>" data-pid="<?php echo $products_list_row['seller_product_id'];?>">
                                                      
                           	                           		<strong><?php if($this->lang->line('header_save') != '') { echo stripslashes($this->lang->line('header_save')); } else echo "Save"; ?></strong>
                                                            
                                                            <span><?php echo $products_list_row['likes'];?> <?php if($this->lang->line('product_saves') != '') { echo stripslashes($this->lang->line('product_saves')); } else echo "saves"; ?></span>
                                                      
                                                      </div>
                                                      
                                                      <div class="deal_tag_title">
                                                      
                                                      	<h2 class="mobile-detail" style="padding-top:0px;"> <a data-pid="<?php echo $products_list_row['seller_product_id'];?>" href="<?php echo $prod_link;?>"><?php echo character_limiter($products_list_row['product_name'],25);?></a></h2>
                                                        <h2 class="non-mobile-detail" style="padding-top:0px;"> <a class="" data-pid="<?php echo $products_list_row['seller_product_id'];?>" href="<?php echo $prod_link;?>"><?php echo character_limiter($products_list_row['product_name'],25);?></a></h2>
                                                        
                                                        <p><?php if($this->lang->line('story_postedby') != '') { echo stripslashes($this->lang->line('story_postedby')); } else echo "posted by"; ?> <a href="user/<?php echo $userName;?>"><?php echo $fullName;?></a> <span> | <?php if (!isset($products_list_row['web_link'])){echo $currencySymbol;?><?php echo $products_list_row['sale_price'];}else {if ($products_list_row['price']>0){echo $currencySymbol;?><?php echo $products_list_row['price'];}}?> </span></p>
                                                        
                                                      </div>
                                                      
                                                      
                                                   
                                             </div>
                                        
                                        </li>
                         <?php 
                			}
                         ?>
                </ul>
                <?php } else { ?>
                	<h3><?php if($this->lang->line('product_noavail') != '') { echo stripslashes($this->lang->line('product_noavail')); } else echo "No products available"; ?></h3>
                <?php } ?>
            </div>            
        </div>
    </div>
    </div>
    </div>
    <?php 
    } else { 
    ?>
			
  <div class="section_main" style="background:#FFF">
  
    <div class="main2">
    
    
      <div class="detail_products" style="margin:30px 0 0">
      	<div class="detail-top">
        	<div class="detail-top-left">
            	<a href="user/<?php echo $userName;?>" class="detail-profile"><img src="images/users/<?php echo $userImg;?>"  class="avatar-image avatar-x200 "/></a>
                <span class="detail-top-name"><a href="user/<?php echo $userName;?>"><?php echo $fullName;?></a> <?php if($this->lang->line('product_postedto') != '') { echo stripslashes($this->lang->line('product_postedto')); } else echo "posted this to"; ?> <?php echo $siteTitle;?><br /><abbr><?php if($this->lang->line('settings_about') != '') { echo stripslashes($this->lang->line('settings_about')); } else echo "about"; ?> <?php $time_ago1 =strtotime($productDetails->row()->created); echo timespan($time_ago1); ?></abbr></span>
            </div>
            <div class="detail-top-right">
            	<div class="products-show-more-savers-text">
                    <a href="saved-peoples/<?php echo $productDetails->row()->seller_product_id; ?>"><?php echo $seller_prod->num_rows(); ?> peoples</a> saved this from 
                    <a class="products-show-poster-details-username" href="user/<?php echo $userName;?>"><?php echo $fullName;?></a>
                </div>
                 <div class="saver-grid">
                    <?php foreach ($user_image->result() as $cmtrow) { ?>
                        <a href="user/<?php echo $cmtrow->user_name; ?>"><img src="images/users/<?php if($cmtrow->thumbnail!=''){ echo $cmtrow->thumbnail;}else{echo 'user-thumb1.png';}?>" /></a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="detail_title">
          <h1> <?php echo $productDetails->row()->product_name;?> </h1>
          From <!--<a href="#">Hammacher Schlemmer</a>--><a href="user/<?php echo $userName;?>"><?php echo $fullName;?></a>
        </div>
        <div class="left_detail">
        
       	   <link type="text/css" rel="stylesheet" href="css/site/jquery.galleryview-3.0-dev.css" />			
			<script type="text/javascript" src="js/site/jquery-ui-1.8.18.js"></script>
            <script type="text/javascript" src="js/site/jquery.timers-1.2.js"></script>
            <script type="text/javascript" src="js/site/jquery.easing.1.3.js"></script>
        
          <div class="detail_show_img">
          
          
          	<?php 
          	$prod_Img = 'dummyproductimage.jpg';
            foreach ($prodImgArr as $prodImgArrRow){
				if (file_exists('images/product/'.$prodImgArrRow)){
		          	$prod_Img = $prodImgArrRow;break;
				}
            }
            ?>
         	 <img style="visibility: visible; width: 888.8888888888889px; height: 500px; top: 0px; left: -169px;" src="images/product/<?php echo $prod_Img;?>" />
          
          
          </div>
          
          <!-- Social sharings start -->
          <div class="social_share">
		  <?php $split = array_filter(explode('.',$this->config->item('twitter_link')));
				$split_twitter = array_filter(explode('/',$split[1]));
				if($split_twitter[1]!=''){
					$twitterName = $split_twitter[1];
				}else{
					$twitterName = $siteTitle;
				}
		  ?>
          <?php 
          $fb_share = "http://www.facebook.com/sharer.php?u=".urlencode(current_url());
          $tw_share = "http://twitter.com/share?text=".urlencode($productDetails->row()->product_name)."&url=".urlencode(current_url());
          $gg_share = "https://plus.google.com/share?url=".urlencode(current_url());
          if ($loginCheck != ''){
	          $fb_share .= '?ref='.$userDetails->row()->user_name.'&via='.$siteTitle;
	          $tw_share .= '?ref='.$userDetails->row()->user_name.'&via='.$twitterName;
	          $gg_share .= '?ref='.$userDetails->row()->user_name.'&via='.$siteTitle;
          }else {
       	  	  $fb_share .= '?via='.$siteTitle;
          	  $tw_share .= '?via='.$twitterName;
          	  $gg_share .= '?via='.$siteTitle;
          }
          ?>
          	<a class="fb" href="<?php echo $fb_share;?>" target="_blank">Facebook</a>
          	<a class="tw" href="<?php echo $tw_share;?>" target="_blank">Twitter</a>
          	<a class="gg" href="<?php echo $gg_share;?>" target="_blank">Google</a>
          </div>
          <!-- Social sharings end -->
          
             <?php if ($loginCheck != ''  && ($userDetails->row()->id == $productDetails->row()->user_id)){?>
						
                             <a id="edit-details" href="things/<?php echo $productDetails->row()->seller_product_id;?>/edit"><?php if($this->lang->line('product_edit_dtls') != '') { echo stripslashes($this->lang->line('product_edit_dtls')); } else echo "Edit details"; ?></a>
                                
                               
                             <a style="font-size: 11px; color: #f33;" uid="<?php echo $productDetails->row()->user_id;?>" thing_id="<?php echo $productDetails->row()->seller_product_id;?>" ntid="7220865" class="remove_new_thing" href="things/<?php echo $productDetails->row()->seller_product_id;?>/delete"><?php if($this->lang->line('shipping_delete') != '') { echo stripslashes($this->lang->line('shipping_delete')); } else echo "Delete"; ?></a>
                                
						<?php }?> 
                        
        <script type="text/javascript">
$(function() {

$(".submit").click(function() {
var requirelogin = $(this).attr('require-login');

if(requirelogin){
var thingURL = $(this).parent().next().find('a:first').attr('href');
$(".sign_box:first").trigger('click');
return false;
}
var comments = $("#comments").val();
var product_id = $("#cproduct_id").val();
var dataString = '&comments=' + comments + '&cproduct_id=' + product_id;

if(comments=='')
{
alert('Your comment is empty');
}
else
{
$("#flash").show();
$("#flash").fadeIn(400).html('<img src="images/ajax-loader.gif" align="absmiddle">&nbsp;<span class="loading">Loading Comment...</span>');
$.ajax({
type: "POST",
url: baseURL+'site/order/insert_product_comment',
data: dataString,
cache: false,
dataType:'json',
success: function(json){
if(json.status_code == 1){
alert('Your comment is waiting for approval');
window.location.reload();
}
document.getElementById('comments').value='';
$("#flash").hide();

}
});
}
return false;
});



});
</script>               
             </div>
        
        <div class="right_detail">
        
        
    
          <div class="detail_save"> <a class="save_btn save <?php if ($loginCheck==''){echo 'sign_box';}?>" style="height:27px;" data-pid="<?php echo $productDetails->row()->seller_product_id;?>" href="javascript:void(0);"><?php if($this->lang->line('header_save') != '') { echo stripslashes($this->lang->line('header_save')); } else echo "Save"; ?></a>
            <div class="save_amount_box"> <span></span>
              <!--<div class="save_amount"><?php echo $productDetails->row()->likes; ?></div>-->
              <div class="save_amount"><?php echo $seller_prod->num_rows(); ?></div>
            </div>
          </div>
          <?php if ($productDetails->row()->quantity > 0){?>
          		<input type="hidden" id="original_sale_price" value="<?php echo $productDetails->row()->sale_price;?>"/>	
<!-- 				<label for="quantity" class="option_lbl"><?php if($this->lang->line('header_quant_Avail') != '') { echo stripslashes($this->lang->line('header_quant_Avail')); } else echo "Quantity ( Available"; ?> : <?php echo $productDetails->row()->quantity;?> )</label> -->
				<label for="quantity" class="option_lbl"><?php if($this->lang->line('product_quantity') != '') { echo stripslashes($this->lang->line('product_quantity')); } else echo "Quantity"; ?></label>
				<span style="display: inline-block; position: relative;" class="input-number">
					<input name="quantity" id="quantity" data-mqty="<?php echo $productDetails->row()->quantity;?>" class="option quantity" value="1" min="1" type="text">
					<a style="position: absolute; top: 5px; right: 0px; height: 11px; padding: 0px 7px;" class="btn-up" onclick="javascript:increaseQty();" href="javascript:void(0);"><span></span></a>
					<a style="position: absolute; top: 17px; right: 0px; height: 11px; padding: 0px 7px;" class="btn-down" onclick="javascript:decreaseQty();" href="javascript:void(0);"><span></span></a>
				</span>
				<div style="color:#FF0000;clear: both;" id="QtyErr"></div>
					<?php  
                   	$attrValsSetLoad = ''; //echo '<pre>'; print_r($PrdAttrVal->result_array()); 
					if($PrdAttrVal->num_rows>0){ 
						$attrValsSetLoad = $PrdAttrVal->row()->pid; 
					?>
                   <label for="attr_name_id" class="option_lbl"><?php if($this->lang->line('options') != '') { echo stripslashes($this->lang->line('options')); } else echo "Options"; ?></label>
                   	<select name="attr_name_id" id="attr_name_id" class="option  selectBox" onchange="ajaxCartAttributeChange(this.value,'<?php echo $productDetails->row()->id; ?>');" >
                        <option value="0">------- <?php if($this->lang->line('checkout_select') != '') { echo stripslashes($this->lang->line('checkout_select')); } else echo "Select"; ?> -------</option>
                        <?php foreach($PrdAttrVal->result_array() as $Prdattrvals ){ ?>
                        <option value="<?php echo $Prdattrvals['pid']; ?>"><?php echo $Prdattrvals['attr_type'].'/'.$Prdattrvals['attr_name']; ?></option>
                        <?php } ?>
                        </select>
				<div style="color:#FF0000;clear: both;" id="AttrErr"></div>
				<div id="loadingImg_<?php echo $productDetails->row()->id; ?>"></div>
              <?php } ?>
					<div style="color:#FF0000;clear: both;" id="ADDCartErr"></div>
          <div class="detail_save"> <input type="button" class="greencart buy_btn" name="addtocart" value="<?php if($this->lang->line('product_buy') != '') { echo stripslashes($this->lang->line('product_buy')); } else echo "Buy"; ?>" onclick="ajax_add_cart('<?php echo $PrdAttrVal->num_rows; ?>');" />
            <div class="buy_amount_box"> <span></span>
              <div class="buy_amount" id="SalePrice"><?php echo $currencySymbol;?><?php echo $productDetails->row()->sale_price;?></div>
               <input type="hidden" class="option number" name="product_id" id="product_id" value="<?php echo $productDetails->row()->id;?>">
               <input type="hidden" class="option number" name="cateory_id" id="cateory_id" value="<?php echo $productDetails->row()->category_id;?>">  
                <input type="hidden" class="option number" name="sell_id" id="sell_id" value="<?php echo $productDetails->row()->user_id;?>">
                <input type="hidden" class="option number" name="price" id="price" value="<?php echo $productDetails->row()->sale_price;?>">
                <input type="hidden" class="option number" name="product_shipping_cost" id="product_shipping_cost" value="<?php echo $productDetails->row()->shipping_cost;?>"> 
                <input type="hidden" class="option number" name="product_tax_cost" id="product_tax_cost" value="<?php echo $productDetails->row()->tax_cost;?>">
                <input type="hidden" class="option number" name="attribute_values" id="attribute_values" value="<?php echo $attrValsSetLoad; ?>">
				<input id="quantity" class="option quantity" type="hidden" value="1" name="quantity">
				<div style="display: none;" class="menu-contain-cart after" id="cart_popup">
                <div id="MiniCartViewDisp" style="display: none;"></div>
                <!--<a class="buy_info example17" href="#"><img src="images/buy_info.jpg" /></a>--> </div>
          </div>
		<?php }else {?>
          <div class="detail_save"> <input style="opacity: 0.5;" type="button" class="greencart buy_btn" value="Sold Out" />
		<?php }?>
          
        </div>
        <div class="detail_save"> <input style="opacity: 1;" type="button" class="buy_btn <?php if ($loginCheck==''){echo 'sign_box';}else{?>contact_seller_btn<?php }?>" value="Contact Seller" /><span style="width: 50%;float: right;position: relative;bottom: 55px; left:40px;"><a href="#" class="report_popup report_pop"><img src="images/report.png" /></a></span></div>
        
        <div class="realted_product_title">

           <span class="realted_tag"><?php if($this->lang->line('product_morefrom') != '') { echo stripslashes($this->lang->line('product_morefrom')); } else echo "more from"; ?> <a href="user/<?php echo $userName;?>"><?php echo $fullName;?> </a></span>
			<?php /*?><a href="#" class="follow-btn">FOLLOW</a>  <?php */?>         
                    
			<div class="" style="float:left">
            <ul class="realted_product">
           		<?php 
            	$moreid=0;
            	foreach ($MoreProduct as $MoreFrom){  
            		if ($MoreFrom->seller_product_id != $productDetails->row()->seller_product_id){
            		$prodImg1= 'dummyProductImage.jpg';
            		$prodImgArr1 = array_filter(explode(',', $MoreFrom->image));
					$moreid=$moreid+1;
            		if(count($prodImgArr1) > 0){
            			$prodImg1=$prodImgArr1[0];
            		}
            		if (isset($MoreFrom->web_link)){
						$prod_link = 'user/'.$MoreFrom->user_name.'/things/'.$MoreFrom->seller_product_id.'/'.url_title($MoreFrom->product_name,'-');
					}else {
						$prod_link = 'things/'.$MoreFrom->id.'/'.url_title($MoreFrom->product_name,'-');
					}
				?>
                    	<li><a href="<?php echo $prod_link; ?>"><img src="images/product/thumb/<?php echo $prodImg1;?>" /></a></li>
                  <?php $prodImg='';} }  ?>  
                    </ul>
               </div>

			</div>
        <?php  
	  
		if($productDetails->row()->youtube!=''){ 
		
        	$youtube_link = $productDetails->row()->youtube;
			$video_id = substr($youtube_link,strpos($youtube_link,'?v=')+3);
			$embed_link = 'http://www.youtube.com/embed/'.$video_id; ?>
        <div class="you_link">
			<iframe title="<?php echo $productDetails->row()->product_name;?>" class="youtube-player" type="text/html" width="485" height="297" src="<?php echo $embed_link;?>" frameborder="0" allowFullScreen></iframe>
		</div>
        <?php }?>        
      </div>
      
      
    </div>
      
    <!--<div class="description_text"><?php echo $productDetails->row()->excerpt; ?></div>-->
      
      <div class="TabbedPanels" id="TabbedPanels1">
     	<ul class="TabbedPanelsTabGroup">
			<li tabindex="0" class="TabbedPanelsTab  TabbedPanelsTabSelected"><?php if($this->lang->line('item_details') != '') { echo stripslashes($this->lang->line('item_details')); } else echo "Item Details"; ?></li>
            <li tabindex="0" class="TabbedPanelsTab">
                <div class="rating_star">
					<?php foreach($product_feedback as $feedbacks) { $totals = $totals+$feedbacks['rating']; }  $totalratingstars = $totals/count($product_feedback); ?>
                    <!--<div class="rat_star1" style="width:<?php echo round($totalratingstars) * 20; ?>%"></div>-->
                    <div class="rat_star1" style="width:<?php echo ($totalratingstars) * 20; ?>%"></div>
                </div>
                (<?php  echo $rownum = count($product_feedback); ?>)
            </li>
			<li tabindex="0" class="TabbedPanelsTab"><?php if($this->lang->line('shipping_policies') != '') { echo stripslashes($this->lang->line('shipping_policies')); } else echo "Shipping & Policies"; ?></li>
			<li tabindex="0" class="TabbedPanelsTab"><?php if($this->lang->line('xchange_policy') != '') { echo stripslashes($this->lang->line('xchange_policy')); } else echo "Exchange Policy"; ?></li>
			<li tabindex="0" class="TabbedPanelsTab"><?php if($this->lang->line('payment_details') != '') { echo stripslashes($this->lang->line('payment_details')); } else echo "Payment Details"; ?></li>
		</ul>
		<div class="TabbedPanelsContentGroup">
			<div class="TabbedPanelsContent  TabbedPanelsContentVisible" style="display: block;">
				<?php 
		      		echo $productDetails->row()->description;
		      	?>
			</div>
            <div class="TabbedPanelsContent" style="display: none;">
		   <?php  
           $rownum = count($product_feedback); 
           
           if ($rownum>0){
           foreach($product_feedback as $feedback) { 
            $pimg = 'dummyproductimage.jpg';
            $pimg_arr = array_filter(explode(',', $feedback['image']));
            if (count($pimg_arr)>0){
                foreach ($pimg_arr as $pimg_row){
                    if (file_exists('images/product/'.$pimg_row)){
                       $pimg = $pimg_row;break;
                    }
                }
            }
            $total = $total+$feedback['rating'];?>
            <div class="tabbed_review">
                <div class="tabbed_left">
                    <a href="user/<?php echo $feedback['user_name']; ?>"><img src="images/users/<?php if($feedback['thumbnail']!='') { echo $feedback['thumbnail']; } else { echo 'user-thumb1.png'; } ?>" width="30px" height="30px" /></a>
                    <span><?php if($this->lang->line('reviewed_by') != '') { echo stripslashes($this->lang->line('reviewed_by')); } else echo "Reviewed By"; ?></span>
                    <p><a href="user/<?php echo $feedback['user_name']; ?>"><?php echo $feedback['full_name']; ?></a></p>
                </div>
                <div class="tabbed_right">
                    <div class="tabbed_top">
                        <div class="rating_star">
                            <div class="rat_star1" style="width:<?php echo $feedback['rating']*20; ?>%"></div>
                        </div>
                        <span class="date"><?php echo date("M d Y", strtotime($feedback['dateAdded'])); ?></span>
                    </div>    
                    <span class="tab_rev_title"><?php echo $feedback['title']; ?></span>
                    <!--<a style="float: left;margin: 0px 0 0 20px;width: 30px;" href="things/<?php echo $feedback['product_id']; ?>/<?php echo url_title($feedback['product_name'],'-');?>">
                        <img src="images/product/<?php echo $pimg; ?>" width="30px" />
                    </a>-->
                    <span class="tab_rev_txt">
                        <a style="float: left;margin: 0px 0 0 15px;width: 30px;" href="things/<?php echo $feedback['product_id']; ?>/<?php echo url_title($feedback['product_name'],'-');?>">
                            <img src="images/product/<?php echo $pimg; ?>" width="30px" />
                        </a>&nbsp;
                    <?php echo $feedback['description']; ?> </span>
                </div>
            </div>
            <?php } }else {?>
            <p></p>
            <?php }?>
          </div>
			<div class="TabbedPanelsContent" style="display: none;">
				<?php 
		      		echo $productDetails->row()->shipping_policies;
		      	?>
			</div>
			<div class="TabbedPanelsContent" style="display: none;">
				<?php 
		      		echo $productDetails->row()->xchange_policy;
		      	?>
				<div class="clear"></div>
			</div>
			<div class="TabbedPanelsContent" style="display: none;">
				<?php 
		      		echo stripslashes($this->config->item('payment_details'));
		      	?>
				<div class="clear"></div>
			</div>
			<script type="text/javascript" class="" style="display: none;">
			var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
			</script>
		</div>
	</div>
      
      <?php if(sizeof($MoreProduct) > 0){
      	if ($MoreProduct[0]->seller_product_id != $productDetails->row()->seller_product_id){
      	?>
      
        <?php }}?>  
          <div class="tweet_comments_main"> <a class="tweet_seemore" href="javascript:void(0);"><?php if($this->lang->line('product_comments') != '') { echo stripslashes($this->lang->line('product_comments')); } else echo "Comments"; ?></a>   
        
        
    <?php 
    if ($productComment->num_rows() > 0){
        foreach ($productComment->result() as $cmtrow){
        	$cmt_uname = $cmtrow->full_name;
        	if ($cmt_uname==''){
	        	$cmt_uname = $cmtrow->user_name;
        	}
            if ($cmtrow->status == 'Active'){
                
        
    ?>
    <div class="tweet_comment"> <span class="tweet_comment_avatar"><img src="images/users/<?php if($cmtrow->thumbnail!=''){ echo $cmtrow->thumbnail;}else{echo 'user-thumb.png';}?>" /></span>
<div class="comments_detail_content"> <a class="comments_detail_name" href="<?php echo base_url();?>user/<?php echo $cmtrow->user_name;?>"><?php echo ucfirst($cmt_uname);?></a> 
<p class="comments_detail_email cmt_cnt_<?php echo $cmtrow->id;?>">
<?php 
                      	$cmt = preg_replace_callback("/@(\w+)/", array($make_user_link, 'make_user_link'), $cmtrow->comments);
						echo preg_replace("/#(\w+)/", "<a target=\"_self\" href=\"".base_url()."tag/$1\">#$1</a>", $cmt);
                      ?>
</p> <span class="comments_detail_day"><?php  $time_ago =strtotime($cmtrow->dateAdded);
echo time_stamp($time_ago); ?> </span> </div>
<?php 
if ($loginCheck != '' && $loginCheck == $productDetails->row()->user_id || $loginCheck != '' && $loginCheck == $cmtrow->CUID){
?>
<p style="float:left;width:100%;text-align:left;">
<?php if ($loginCheck == $cmtrow->CUID){?>
            <a style="font-size: 11px; color: #0033FF;cursor:pointer;" onclick="javascript:editCmt(this);" data-uid="<?php echo $cmtrow->CUID;?>" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('shipping_edit') != '') { echo stripslashes($this->lang->line('shipping_edit')); } else echo "Edit"; ?></a>
<?php }?>
            <a style="font-size: 11px; color: #f33;cursor:pointer;" onclick="javascript:deleteCmt(this);" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('product_delte') != '') { echo stripslashes($this->lang->line('product_delte')); } else echo "Delete"; ?></a>
<?php ?>        </p>
<?php 
}
?>  
</div>
    <?php 
            }else {
                if ($loginCheck != '' && $loginCheck == $productDetails->row()->user_id){
    ?>
    <div class="tweet_comment"> <span class="tweet_comment_avatar"><img src="images/users/<?php if($cmtrow->thumbnail!=''){ echo $cmtrow->thumbnail;}else{echo 'user-thumb.png';}?>" /></span>
<div class="comments_detail_content"> <a class="comments_detail_name" href="<?php echo base_url();?>user/<?php echo $cmtrow->user_name;?>"><?php echo ucfirst($cmt_uname);?></a> 
<p class="comments_detail_email cmt_cnt_<?php echo $cmtrow->id;?>">
<?php 
                      	$cmt = preg_replace_callback("/@(\w+)/", array($make_user_link, 'make_user_link'), $cmtrow->comments);
						echo preg_replace("/#(\w+)/", "<a target=\"_self\" href=\"".base_url()."tag/$1\">#$1</a>", $cmt);
                      ?>
</p> <span class="comments_detail_day"><?php  $time_ago =strtotime($cmtrow->dateAdded);
echo time_stamp($time_ago); ?> </span> </div>
<p style="float:left;width:100%;text-align:left;">
            <a style="font-size: 11px; color: #188A0E;cursor:pointer;" onclick="javascript:approveCmt(this);" data-uid="<?php echo $cmtrow->CUID;?>" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('product_approve') != '') { echo stripslashes($this->lang->line('product_approve')); } else echo "Approve"; ?></a>
            <?php if ($loginCheck == $cmtrow->CUID){?>
            <a style="font-size: 11px; color: #0033FF;cursor:pointer;" onclick="javascript:editCmt(this);" data-uid="<?php echo $cmtrow->CUID;?>" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('shipping_edit') != '') { echo stripslashes($this->lang->line('shipping_edit')); } else echo "Edit"; ?></a>
			<?php }?>
            <a style="font-size: 11px; color: #f33;cursor:pointer;" onclick="javascript:deleteCmt(this);" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('product_delte') != '') { echo stripslashes($this->lang->line('product_delte')); } else echo "Delete"; ?></a>
        </p>
</div>
    
    <?php 		
                }else {
                    if ($loginCheck == $cmtrow->CUID){
    ?>
    
    <div class="tweet_comment"> <span class="tweet_comment_avatar"><img src="images/users/<?php if($cmtrow->thumbnail!=''){ echo $cmtrow->thumbnail;}else{echo 'user-thumb.png';}?>" /></span>
<div class="comments_detail_content"> <a class="comments_detail_name" href="<?php echo base_url();?>user/<?php echo $cmtrow->user_name;?>"><?php echo ucfirst($cmt_uname);?></a> 
<p class="comments_detail_email cmt_cnt_<?php echo $cmtrow->id;?>">
<?php 
                      	$cmt = preg_replace_callback("/@(\w+)/", array($make_user_link, 'make_user_link'), $cmtrow->comments);
						echo preg_replace("/#(\w+)/", "<a target=\"_self\" href=\"".base_url()."tag/$1\">#$1</a>", $cmt);
                      ?>
</p> <span class="comments_detail_day"><?php  $time_ago =strtotime($cmtrow->dateAdded);
echo time_stamp($time_ago); ?> </span> </div>
<p style="float:left;width:100%;text-align:left;font-size: 11px; color: #188A0E; cursor:pointer;">
            <?php if($this->lang->line('product_wait_appr') != '') { echo stripslashes($this->lang->line('product_wait_appr')); } else echo "Waiting for approval"; ?>
            <a style="font-size: 11px; color: #0033FF;cursor:pointer;" onclick="javascript:editCmt(this);" data-uid="<?php echo $cmtrow->CUID;?>" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('shipping_edit') != '') { echo stripslashes($this->lang->line('shipping_edit')); } else echo "Edit"; ?></a>
            <a style="font-size: 11px; color: #f33;margin-left:10pxcursor:pointer;" onclick="javascript:deleteCmt(this);" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('product_delte') != '') { echo stripslashes($this->lang->line('product_delte')); } else echo "Delete"; ?></a>
        </p>
</div>
    
    <?php 
                    }
                }


            }
        }
    }?>
    
<div class="tweet_comment" style="background: none repeat scroll 0 0 #FAFAFA;"> <span class="tweet_comment_avatar"><img src="images/users/<?php echo $current_user_img;?>" /></span>
<div class="comments_detail_content">
<form action="#" method="post" style="margin:0px;">
<input type="hidden" name="cproduct_id" id="cproduct_id" value="<?php echo $productDetails->row()->seller_product_id;?>"/>
<input type="hidden" name="user_id" id="user_id" value="<?php echo $loginCheck ;?>"/>
<textarea name="comments" placeholder="<?php if($this->lang->line('header_write_comment') != '') { echo stripslashes($this->lang->line('header_write_comment')); } else echo "Write a comment"; ?>..." id="comments" class="tweet_comments_links1"></textarea>

<input type="submit" <?php if($loginCheck==''){ ?>require-login='true'<?php }?> class="post_btn1 submit button" value="<?php if($this->lang->line('header_post_comment') != '') { echo stripslashes($this->lang->line('header_post_comment')); } else echo "Post"; ?>" />
</form>
</div>
</div> 
<div class="main2">
    <div class="relevant-products-container">
	    <h2 class="relevant-products-title">People who saved this product also saved </h2>
        <div class="relevant-products-grid">
            <div class="product_main">
            <?php if (count($products_list) > 0) { ?>
            	<ul class="product_main_thumb">
                	<?php 
							//$query = $query->result_array();
							//echo count($products_list);
							//echo "<pre>";print_r($products_list->result());die;
							$products_list=$products_list->result_array();
                			foreach ($products_list as $products_list_row){
                				$prodImg = 'dummyProductImage.jpg';
                				$prodImgArr = array_filter(explode(',', $products_list_row['image']));
                				if (count($prodImgArr)>0){
                					foreach ($prodImgArr as $prodImgArrRow){
										if (file_exists('images/product/thumb/'.$prodImgArrRow)){
											$prodImg = $prodImgArrRow;
											break;	
										}
                					}
                				}
								$userName = 'administrator';
                				$fullName = 'administrator';
                				if ($products_list_row['user_id'] > 0){
									$sql = "select * from ".USERS." where id='".$products_list_row['user_id']."'";
									$query = $this->db->query($sql);
									$sliderResult = $query->row_array();
                					$userName = $sliderResult['user_name'];
                					$fullName = character_limiter($sliderResult['full_name'],20);
                					if (strlen($fullName)>20){
                						$fullName = substr($fullName, 0,20).'..';	
                					}
									$userImg = $sliderResult['thumbnail'];
                				}
								
                				if ($fullName == ''){
                					$fullName = $userName;
                				}
								
                				if ($userImg==''){
									$userImg = 'default_user.jpg';
                				}
								
								/*if(isset($products_list_row['web_link'])){
									$prod_link = 'user/'.$userName.'/things/'.$products_list_row['seller_product_id'].'/'.url_title($products_list_row['product_name'],'-');
								}else {
									$prod_link = 'things/'.$products_list_row['id'].'/'.url_title($products_list_row['product_name'],'-');
								}*/
								
								if($products_list_row['web_link'] != 'None'){
									$prod_link = 'user/'.$userName.'/things/'.$products_list_row['seller_product_id'].'/'.url_title($products_list_row['product_name'],'-');
								}else {
									$prod_link = 'things/'.$products_list_row['id'].'/'.url_title($products_list_row['product_name'],'-');
								}
                			?>
                                        <li class="boxgrid captionfull">
                                        <!--<a href="<?php echo $prod_link;?>"><img src="images/product/thumb/<?php echo $prodImg;?>" /></a>-->
                                        <a href="<?php echo $prod_link;?>"><img src="images/product/thumb/<?php echo $prodImg;?>" /></a>
                                        <div class="info_links">
                                        	<a href="user/<?php echo $userName;?>"><img src="images/users/<?php echo $userImg;?>"/></a>
                                        	<a class="info_uname" href="user/<?php echo $userName;?>"><?php echo $fullName;?></a>
                                        	<!--<a class="collection_name" href="<?php echo $prod_link;?>"><?php echo $products_list_row['product_name'];?></a>-->
                                            <a class="collection_name" href="<?php echo $prod_link;?>"><?php echo $products_list_row['product_name'];?></a>
                                        </div>
                                        	<div class="cover boxcaption">
<div id ="<?php echo $products_list_row['id'].'/'.$products_list_row['product_name'];?>" class="tag <?php if ($loginCheck==''){echo 'sign_box';}else {echo 'tag_box';}?>" data-pid="<?php echo $products_list_row['seller_product_id'];?>">
                           	                           		<strong><?php if($this->lang->line('product_tag') != '') { echo stripslashes($this->lang->line('product_tag')); } else echo "Tag"; ?></strong>
                                                            <span><?php if($this->lang->line('product_afreiend') != '') { echo stripslashes($this->lang->line('product_afreiend')); } else echo "a friend"; ?></span>
                                                      </div>
                                                      
                                                      <div class="save <?php if ($loginCheck==''){echo 'sign_box';}?>" data-pid="<?php echo $products_list_row['seller_product_id'];?>">
                                                      
                           	                           		<strong><?php if($this->lang->line('header_save') != '') { echo stripslashes($this->lang->line('header_save')); } else echo "Save"; ?></strong>
                                                            
                                                            <span><?php echo $products_list_row['likes'];?> <?php if($this->lang->line('product_saves') != '') { echo stripslashes($this->lang->line('product_saves')); } else echo "saves"; ?></span>
                                                      
                                                      </div>
                                                      
                                                      <div class="deal_tag_title">
                                                      
                                                      	<h2 class="mobile-detail" style="padding-top:0px;"> <a data-pid="<?php echo $products_list_row['seller_product_id'];?>" href="<?php echo $prod_link;?>"><?php echo character_limiter($products_list_row['product_name'],25);?></a></h2>
                                                        <h2 class="non-mobile-detail" style="padding-top:0px;"> <a class="" data-pid="<?php echo $products_list_row['seller_product_id'];?>" href="<?php echo $prod_link;?>"><?php echo character_limiter($products_list_row['product_name'],25);?></a></h2>
                                                        
                                                        <p><?php if($this->lang->line('story_postedby') != '') { echo stripslashes($this->lang->line('story_postedby')); } else echo "posted by"; ?> <a href="user/<?php echo $userName;?>"><?php echo $fullName;?></a> <span> | <?php if (!isset($products_list_row['web_link'])){echo $currencySymbol;?><?php echo $products_list_row['sale_price'];}else {if ($products_list_row['price']>0){echo $currencySymbol;?><?php echo $products_list_row['price'];}}?> </span></p>
                                                        
                                                      </div>
                                                      
                                                      
                                                   
                                             </div>
                                        
                                        </li>
                         <?php 
                			}
                         ?>
                </ul>
                <?php } else { ?>
                	<h3><?php if($this->lang->line('product_noavail') != '') { echo stripslashes($this->lang->line('product_noavail')); } else echo "No products available"; ?></h3>
                <?php } ?>
            </div>            
        </div>
    </div>
    </div>
</div>
          
    </div>
  <?php } ?>
</section>
<?php 
}
?>
<!-- Section_end -->
<?php
//Php Time_Ago Script v1.0.0
//Scripted by D.Harish Kumar@TYSON567
function time_stamp($time_ago)
{
$cur_time=time();
$time_elapsed = $cur_time - $time_ago;
$seconds = $time_elapsed ;
$minutes = round($time_elapsed / 60 );
$hours = round($time_elapsed / 3600);
$days = round($time_elapsed / 86400 );
$weeks = round($time_elapsed / 604800);
$months = round($time_elapsed / 2600640 );
$years = round($time_elapsed / 31207680 );
// Seconds
if($seconds <= 60)
{
echo "$seconds seconds ago";
}
//Minutes
else if($minutes <=60)
{
if($minutes==1)
{
echo "one minute ago";
}
else
{
echo "$minutes minutes ago";
}
}
//Hours
else if($hours <=24)
{
if($hours==1)
{
echo "an hour ago";
}
else
{
echo "$hours hours ago";
}
}
//Days
else if($days <= 7)
{
if($days==1)
{
echo "yesterday";
}
else
{
echo "$days days ago";
}
}
//Weeks
else if($weeks <= 4.3)
{
if($weeks==1)
{
echo "a week ago";
}
else
{
echo "$weeks weeks ago";
}
}
//Months
else if($months <=12)
{
if($months==1)
{
echo "a month ago";
}
else
{
echo "$months months ago";
}
}
//Years
else
{
if($years==1)
{
echo "one year ago";
}
else
{
echo "$years years ago";
}
}
}
?>
<?php
$this->load->view('site/templates/footer');
?>