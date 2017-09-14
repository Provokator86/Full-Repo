<?php
include_once 'application/views/site/user/make_user_link.php';
$make_user_link = new MyCallback($users_list);
$this->load->view('site/templates/header',$this->data);
$this->load->view('site/templates/popup_product_detail.php',$this->data);
?>
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

<?php if($productDetails->num_rows()==0) { ?>
	<?php if($this->lang->line('product_unavail') != '') { echo stripslashes($this->lang->line('product_unavail')); } else echo "Product details not available"; ?>
<?php } else { 
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
    if ($productUserDetails->num_rows() > 0){
    	$userName = $productUserDetails->row()->user_name;
    	$fullName = $productUserDetails->row()->full_name;
    	if ($fullName == '')$fullName=$userName;
    }
	$userImg = 'default_user.jpg';
	if ($productUserDetails->row()->thumbnail != ''){
		if (file_exists('images/users/'.$productUserDetails->row()->thumbnail)){
			$userImg = $productUserDetails->row()->thumbnail;
		}
	}
?>
<?php } ?>
<?php 
    if ($loginCheck==''){ 
    ?>
    <div class="join-banner">
    	<div class="main2">
        	<h2>Find and buy the most amazing products online.</h2>
            <div class="join-butons">
            	<a class="banner_join_btn log_box" href="#">Join</a>
                <a class="banner_sign_btn banner_join_btn sign_box" href="#">Sign In</a>
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
        	<a href="saved-peoples/<?php echo $productDetails->row()->seller_product_id; ?>"><?php echo $seller_prod->row()->count; ?> peoples</a> saved this from 
            <a href="store/<?php echo $productDetails->row()->store_name;?>"> <?php echo $productDetails->row()->store_name;?></a>
        </div>
        <div class="saver-grid">
            <?php foreach ($user_image->result() as $cmtrow) { ?>
	            <a href="user/<?php echo $cmtrow->user_name; ?>"><img src="images/users/<?php if($cmtrow->thumbnail!=''){ echo $cmtrow->thumbnail;}else{echo 'user-thumb1.png';}?>" /></a>
            <?php } ?>    
        </div>
    </div>
    <div class="product-description">
    	<div class="product-description-left">
            <img src="images/product/<?php echo $prodImg;?>" />
        </div>
        <div class="product-description-right">
        	<!--<h1>Small Round Chevron Pet Bed</h1>-->
            <h1><?php echo $productDetails->row()->product_name;?></h1>
            <div class="price-tag">
				<span class="minimal"><?php echo $currencySymbol;?><span class="price-tag-text"><?php echo $productDetails->row()->price;?></span></span>
				from
				<a href="store/<?php echo $productDetails->row()->store_name;?>"> <?php echo $productDetails->row()->store_name;?></a>
			</div>
            <a href="#" class="sign-save sign_box">Sign in to save or buy this product</a>
        </div>
    </div>
    
    <!--<div class="tweet_comments_main" style="margin:0 0 0 80px">
    	<div class="tweet_comment" style="background:#FFF">
        	<span class="tweet_comment_avatar"><img src="images/users/watch.jpg" /></span>
            <div class="comments_detail_content">
            	<a href="#" class="comments_detail_name">Murali</a>
                <p class="comments_detail_email cmt_cnt_16">chevron, for your new dog</p>
                <span class="comments_detail_day">2 days ago </span>
            </div>
        </div>
    </div>-->
    
    <?php 
		if ($productComment->num_rows() > 0){
		foreach ($productComment->result() as $cmtrow){
		if ($cmtrow->status == 'Active'){
	?>
        <div class="tweet_comments_main" style="margin:0 0 0 80px">
            <div class="tweet_comment" style="background:#FFF">
                <span class="tweet_comment_avatar"><img src="images/users/<?php if($cmtrow->thumbnail!=''){ echo $cmtrow->thumbnail;}else{echo 'user-thumb.png';}?>" /></span>
                <div class="comments_detail_content">
                    <a href="<?php echo base_url();?>user/<?php echo $cmtrow->user_name;?>" class="comments_detail_name"><?php echo ucfirst($cmtrow->user_name);?></a>
                    <p class="comments_detail_email cmt_cnt_16">
                    <?php
                    $cmt = preg_replace_callback("/@(\w+)/", array($make_user_link, 'make_user_link'), $cmtrow->comments);
                    echo preg_replace("/#(\w+)/", "<a target=\"_self\" href=\"".base_url()."tag/$1\">#$1</a>", $cmt);
                    ?>
                    </p>
                    <span class="comments_detail_day"><?php  $time_ago =strtotime($cmtrow->dateAdded); echo time_stamp($time_ago); ?> </span>
                </div>
            </div>
        </div>
	<?php } } } ?>        
    
		</div>
    </div>
    <?php 
    }
    else { 
    ?>
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
	if ($productUserDetails->row()->thumbnail != ''){
		if (file_exists('images/users/'.$productUserDetails->row()->thumbnail)){
			$userImg = $productUserDetails->row()->thumbnail;
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
    if ($productUserDetails->num_rows() > 0){
    	$userName = $productUserDetails->row()->user_name;
    	$fullName = $productUserDetails->row()->full_name;
    	if ($fullName == '')$fullName=$userName;
    }
    $followClass = 'follow_btn';
	$followText  = 'Follow';
	if ($loginCheck != ''){
        $followingListArr = explode(',', $userDetails->row()->following);
        if (in_array($productUserDetails->row()->id, $followingListArr)){
        	$followClass = 'following_btn';
        	$followText = 'Following';
        }
	} 
			$web_link = $productDetails->row()->web_link;
			if ($web_link != ''){
				if (substr($web_link, 0,4) != 'http'){
					$web_link = 'http://'.$web_link;	
				}
				if ($productDetails->row()->affiliate_code!=''){
					$separator = (parse_url($web_link, PHP_URL_QUERY) == NULL) ? '?' : '&';
   					$web_link .= $separator . str_replace('"', "'", $productDetails->row()->affiliate_code);
				}
			}
          ?>
<section>

			
  <div class="section_main" style="background:#f2f2f2">
  <div class="main2">
    	<?php if($flash_data != '') { ?>
		<div class="errorContainer" id="<?php echo $flash_data_type;?>">
			<script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 3000);</script>
			<p><span><?php echo $flash_data;?></span></p>
		</div>
		<?php } ?>
      <!--<div class="product-attribution-container-info-message">
            <h2><a href="user/<?php echo $userName;?>" class="products-show-poster-details-username"><?php echo $fullName;?></a> <?php if($this->lang->line('product_postedto') != '') { echo stripslashes($this->lang->line('product_postedto')); } else echo "posted this to"; ?> <?php echo $siteTitle;?></h2>
          
            <abbr title="" class="timeago"><?php if($this->lang->line('settings_about') != '') { echo stripslashes($this->lang->line('settings_about')); } else echo "about"; ?> <?php $time_ago1 =strtotime($productDetails->row()->created); echo timespan($time_ago1); ?></abbr>
      </div>-->
    
      <div class="detail_products" style="margin:30px 0 0">
      	<div class="detail-top">
        	<div class="detail-top-left">
            	<a href="user/<?php echo $userName;?>" class="detail-profile"><img src="images/users/<?php echo $userImg;?>"  class="avatar-image avatar-x200 "/></a>
                <span class="detail-top-name"><a href="user/<?php echo $userName;?>"><?php echo $fullName;?></a> <?php if($this->lang->line('product_postedto') != '') { echo stripslashes($this->lang->line('product_postedto')); } else echo "posted this to"; ?> <?php echo $siteTitle;?><br /><abbr><?php if($this->lang->line('settings_about') != '') { echo stripslashes($this->lang->line('settings_about')); } else echo "about"; ?> <?php $time_ago1 =strtotime($productDetails->row()->created); echo timespan($time_ago1); ?></abbr></span>
            </div>
            <div class="detail-top-right">
            	<div class="products-show-more-savers-text">
        			<a href="saved-peoples/<?php echo $productDetails->row()->seller_product_id; ?>"><?php echo $seller_prod->row()->count; ?> peoples</a> saved this from 
                    <a href="store/<?php echo $productDetails->row()->store_name;?>"> <?php echo $productDetails->row()->store_name;?></a>
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
          <?php if ($productDetails->row()->store_name != ''){?>
          <?php if($this->lang->line('from') != '') { echo stripslashes($this->lang->line('from')); } else echo "From"; ?>
					<a href="store/<?php echo $productDetails->row()->store_name;?>"> <?php echo $productDetails->row()->store_name;?>
					</a>
          <?php }else {?>
          <?php if($this->lang->line('from') != '') { echo stripslashes($this->lang->line('from')); } else echo "From";?> <a href="user/<?php echo $userName;?>"><?php echo $fullName;?></a>
          <?php }?>
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
         	 <a href="<?php echo $web_link;?>" target="_blank"><img src="images/product/<?php echo $prod_Img;?>" /></a>
          
          
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
        
	        <?php 
			if ($loginCheck!='' && $productDetails->row()->user_id == $loginCheck){
			?>
<!-- 			<div class="detail_save"> 
				<a ntid="<?php echo $productDetails->row()->seller_product_id;?>" class="sell buy_btn" href="javascript:void(0)" onclick="sell_click(this)"><?php if($this->lang->line('product_want_sell') != '') { echo stripslashes($this->lang->line('product_want_sell')); } else echo "I want to sell it"; ?></a>
			</div>
 -->			<?php 
			}
			?>
          <div class="detail_save"> <a class="save_btn save <?php if ($loginCheck==''){echo 'sign_box';}?>" style="height:27px;" data-pid="<?php echo $productDetails->row()->seller_product_id;?>" href="javascript:void(0);"><?php if($this->lang->line('header_save') != '') { echo stripslashes($this->lang->line('header_save')); } else echo "Save"; ?></a>
            <div class="save_amount_box"> <span></span>
              <!--<div class="save_amount"><?php echo $productDetails->row()->likes;?></div>-->
              <div class="save_amount"><?php echo $seller_prod->row()->count; ?></div>
            </div>
          </div>
          <?php 
			$web_link = $productDetails->row()->web_link;
			if ($web_link != ''){
				if (substr($web_link, 0,4) != 'http'){
					$web_link = 'http://'.$web_link;	
				}
				if ($productDetails->row()->affiliate_code!=''){
					$separator = (parse_url($web_link, PHP_URL_QUERY) == NULL) ? '?' : '&';
   					$web_link .= $separator . str_replace('"', "'", $productDetails->row()->affiliate_code);
				}
          ?>
          <div class="detail_save"> <a href="<?php echo $web_link;?>" target="_blank"><input type="button" class="greencart buy_btn" value="<?php if($this->lang->line('product_buy') != '') { echo stripslashes($this->lang->line('product_buy')); } else echo "Buy it"; ?>"/></a>
            <div class="buy_amount_box"> <span></span>
            <div class="buy_amount"><?php echo $currencySymbol.$productDetails->row()->price;?></div>
          </div>
          <?php }?>
          <a href="#" class="report_popup report_pop"><img src="images/report.png" /></a>
        </div>
   	
   				<?php
				if ($moreStoreProducts != '' && $moreStoreProducts->num_rows()>0){
					$followClass = 'follow_btn';
					$followText  = 'Follow';
					if ($this->lang->line('onboarding_follow') != ''){
						$followText  = $this->lang->line('onboarding_follow');
					}
					if ($loginCheck != ''){
						$followingListArr = explode(',', $store_details->row()->followers);
						if (in_array($loginCheck, $followingListArr)){
							$followClass = 'following_btn';
							$followText = 'Following';
							if ($this->lang->line('display_following') != ''){
								$followText  = $this->lang->line('display_following');
							}
						}
					}
					?>
    		<div class="realted_product_main"> 
      
      	<div class="realted_product_title">

           <span class="realted_tag"><?php if($this->lang->line('product_morefrom') != '') { echo stripslashes($this->lang->line('product_morefrom')); } else echo "more from"; ?> 
           	<a href="store/<?php echo $store_details->row()->store_name;?>"><?php echo $store_details->row()->store_name;?></a>
           </span>
			<?php /*?><a href="#" class="follow-btn">FOLLOW</a>  <?php */?>         
                    
		<a
			class="right <?php if ($loginCheck==''){echo 'sign_box';}?>  <?php echo $followClass;?>"
			href="javascript:void(0);" <?php if ($loginCheck != ''){?>
			data-uid="<?php echo $store_details->row()->id;?>"
			onclick="javascript:follow_store(this);" <?php }?>><?php echo $followText;?>
		</a>

			</div>
            
      <div class="" style="float:left">
            <ul class="realted_product">
           		<?php 
				$i = 0;
					foreach ($moreStoreProducts->result() as $MoreFrom){
						if($productDetails->row()->seller_product_id != $MoreFrom->seller_product_id){
							$prodImg1= 'dummyProductImage.jpg';
							$prodImgArr1 = array_filter(explode(',', $MoreFrom->image));
							if(count($prodImgArr1)){
								$prodImg1=$prodImgArr1[0];
								if ($i++ == 6) break;
							}
							if (isset($MoreFrom->web_link)){
								$prod_link = 'user/'.$MoreFrom->user_name.'/things/'.$MoreFrom->seller_product_id.'/'.str_replace(' ','-',$MoreFrom->product_name);
							}else {
								$prod_link = 'things/'.$MoreFrom->id.'/'.str_replace(' ','-',$MoreFrom->product_name.'/'.$MoreFrom->seller_product_id);
							}
				?>
                    	<li><a href="<?php echo $prod_link; ?>"><img src="images/product/thumb/<?php echo $prodImg1;?>" /></a></li>
                  <?php $prodImg='';} }  ?>  
                    </ul>
               </div>
            
         
            
          </div>
    	<?php }?>
      </div>
      
      <div class="description_text">
      
      	<?php 
      //	echo $productDetails->row()->excerpt;
      	?>
      
      </div>
      
      
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
</div>
          
    </div>
  </div>
</section>
<?php 
}
?>
 <?php 
    }
    ?>
    
    <div class="product_dtls_btm">
        <h2>shoutout to my boyscouts out there </h2>
        
        <div class="brand_product odd">
            <ul>
                <li>
                    <img src="images/site_new/brand1.jpg" alt="">
                    <div class="overlay">
                        <a href="product_details.html"><h3><span class="WebRupee">Rs.</span> 499</h3></a>
                        <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
                          <span class="brand"><a href="brand_details.html">Arrow</a></span>
                        <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                    </div>
                </li>
                <li>
                    <img src="images/site_new/brand2.jpg" alt="">
                    <div class="overlay">
                        <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                        <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
                          <span class="brand"><a href="brand_details.html">Arrow</a></span>
                        <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                    </div>
                </li>
                <li>
                    <img src="images/site_new/brand3.jpg" alt="">
                    <div class="overlay">
                        <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                        <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
                          <span class="brand"><a href="brand_details.html">Arrow</a></span>
                        <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                    </div>
                </li>
                <li>
                    <img src="images/site_new/brand4.jpg" alt="">
                    <div class="overlay">
                        <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                        <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
                          <span class="brand"><a href="brand_details.html">Arrow</a></span>
                        <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                    </div>
                </li>
                <li>
                    <img src="images/site_new/brand5.jpg" alt="">
                    <div class="overlay">
                        <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                        <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
                          <span class="brand"><a href="brand_details.html">Arrow</a></span>
                        <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                    </div>
                </li>
                <li>
                    <img src="images/site_new/brand6.jpg" alt="">
                    <div class="overlay">
                        <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                        <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
                          <span class="brand"><a href="brand_details.html">Arrow</a></span>
                        <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                    </div>
                </li>
                
                <li>
                    <img src="images/site_new/brand1.jpg" alt="">
                    <div class="overlay">
                        <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                        <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
                          <span class="brand"><a href="brand_details.html">Arrow</a></span>
                        <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                    </div>
                </li>
                <li>
                    <img src="images/site_new/brand2.jpg" alt="">
                    <div class="overlay">
                        <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                        <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
                          <span class="brand"><a href="brand_details.html">Arrow</a></span>
                        <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                    </div>
                </li>
                <li>
                    <img src="images/site_new/brand3.jpg" alt="">
                    <div class="overlay">
                        <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                        <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
                          <span class="brand"><a href="brand_details.html">Arrow</a></span>
                        <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                    </div>
                </li>
                <li>
                    <img src="images/site_new/brand4.jpg" alt="">
                    <div class="overlay">
                        <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                        <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
                          <span class="brand"><a href="brand_details.html">Arrow</a></span>
                        <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                    </div>
                </li>
                <li>
                    <img src="images/site_new/brand5.jpg" alt="">
                    <div class="overlay">
                        <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                        <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
                          <span class="brand"><a href="brand_details.html">Arrow</a></span>
                        <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                    </div>
                </li>
                <li>
                    <img src="images/site_new/brand6.jpg" alt="">
                    <div class="overlay">
                        <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                        <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
                          <span class="brand"><a href="brand_details.html">Arrow</a></span>
                        <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                    </div>
                </li>
            </ul>
            <div class="clear"></div>
        </div>
    </div>
    
    <!-- Section_end -->
<?php 
if ($productDetails->row()->affiliate_script != ''){
echo $productDetails->row()->affiliate_script;
}
?>
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

