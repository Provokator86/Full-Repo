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
<link rel="stylesheet" href="css/site/my-account.css" type="text/css" media="all"/>

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
<div>

  <div id='inline_example11' style='background:#fff;'>
  
  		<div class="popup_page">
        
        	
            
            
            <div class="detail_products">
            
            	<div class="detail_title">
                
                	<h1> <?php echo $productDetails->row()->product_name;?> </h1>
                    
                </div>
            
            
            
            
            
            <div class="left_detail">
            
            	 <link type="text/css" rel="stylesheet" href="css/site/jquery.galleryview-3.0-dev.css" />			
			<script type="text/javascript" src="js/site/jquery-ui-1.8.18.js"></script>
            <script type="text/javascript" src="js/site/jquery.timers-1.2.js"></script>
            <script type="text/javascript" src="js/site/jquery.easing.1.3.js"></script>
            <script type="text/javascript" src="js/site/jquery.galleryview-3.0-dev.js"></script>
            <script type="text/javascript">
            $(function(){
            	$('#myGallery').galleryView({
                	transition_speed: 0, 		//INT - duration of panel/frame transition (in milliseconds)
                    transition_interval: 0, 		//INT - delay between panel/frame transitions (in milliseconds)
                    easing: 'swing', 				//STRING - easing method to use for animations (jQuery provides 'swing' or 'linear', more available with jQuery UI or Easing plugin)
                    show_panels: true, 				//BOOLEAN - flag to show or hide panel portion of gallery
                    show_panel_nav: false, 			//BOOLEAN - flag to show or hide panel navigation buttons
                    enable_overlays: true, 			//BOOLEAN - flag to show or hide panel overlays
                                
                    panel_width: 550, 				//INT - width of gallery panel (in pixels)
                    panel_height: 500, 				//INT - height of gallery panel (in pixels)
                    panel_animation: 'none', 		//STRING - animation method for panel transitions (crossfade,fade,slide,none)
                    panel_scale: 'crop', 			//STRING - cropping option for panel images (crop = scale image and fit to aspect ratio determined by panel_width and panel_height, fit = scale image and preserve original aspect ratio)
                    overlay_position: 'bottom', 	//STRING - position of panel overlay (bottom, top)
                    pan_images: true,				//BOOLEAN - flag to allow user to grab/drag oversized images within gallery
                    pan_style: 'drag',				//STRING - panning method (drag = user clicks and drags image to pan, track = image automatically pans based on mouse position
                    pan_smoothness: 15,				//INT - determines smoothness of tracking pan animation (higher number = smoother)
                    start_frame: 1, 				//INT - index of panel/frame to show first when gallery loads
                    show_filmstrip: true, 			//BOOLEAN - flag to show or hide filmstrip portion of gallery
                    show_filmstrip_nav: false, 		//BOOLEAN - flag indicating whether to display navigation buttons
                    enable_slideshow: false,			//BOOLEAN - flag indicating whether to display slideshow play/pause button
                    autoplay: false,				//BOOLEAN - flag to start slideshow on gallery load
                    show_captions: false, 			//BOOLEAN - flag to show or hide frame captions	
                    filmstrip_size: 3, 				//INT - number of frames to show in filmstrip-only gallery
                    filmstrip_style: 'showall', 		//STRING - type of filmstrip to use (scroll = display one line of frames, scroll filmstrip if necessary, showall = display multiple rows of frames if necessary)
                    filmstrip_position: 'bottom', 	//STRING - position of filmstrip within gallery (bottom, top, left, right)
                    frame_width: 90, 				//INT - width of filmstrip frames (in pixels)
                    frame_height: 80, 				//INT - width of filmstrip frames (in pixels)
                    frame_opacity: 1, 			//FLOAT - transparency of non-active frames (1.0 = opaque, 0.0 = transparent)
                    frame_scale: 'crop', 			//STRING - cropping option for filmstrip images (same as above)
                    frame_gap: 5, 					//INT - spacing between frames within filmstrip (in pixels)
                    show_infobar: false,				//BOOLEAN - flag to show or hide infobar
                    infobar_opacity: 1<?php if($productDetails->row()->youtube_link !=''){ ?>,				//FLOAT - transparency for info bar
                    youtube_link: 1<?php }?>
            	});
			});
		</script>
        
          <div class="detail_show_img">
          
          	<ul id="myGallery">	
          
          		   <?php 
            foreach ($prodImgArr as $prodImgArrRow){
			if (file_exists('images/product/'.$prodImgArrRow)){
            ?>
            <li>
            
         	 <img src="images/product/<?php echo $prodImgArrRow;?>" />
          
          	</li>
            <?php 
			}
            }
            ?>
          
          	</ul>
          
          </div>
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
alert("Login required");
window.location = baseURL;
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
          
          	<div class="popup_detail_title">
            
            	<span class="detail_img_icon"><a href="user/<?php echo $userName;?>"><img src="images/users/<?php echo $userImg;?>" /></a></span>
                
                <div class="detail_title_right">
                
                	<h2><a href="user/<?php echo $userName;?>"><?php echo $fullName;?></a><?php if($this->lang->line('product_postedto') != '') { echo stripslashes($this->lang->line('product_postedto')); } else echo "posted this to"; ?> <?php echo $siteTitle;?></h2>
                    <div class="clear"></div>
                    
                    <p title="" class="timeago"><?php if($this->lang->line('settings_about') != '') { echo stripslashes($this->lang->line('settings_about')); } else echo "about"; ?> <?php $time_ago1 =strtotime($productDetails->row()->created); echo time_stamp($time_ago1); ?></p>
                
                </div>
            
            </div>
          
          		<div class="detail_save">
                
                	<a class="save_btn save <?php if ($loginCheck==''){echo 'sign_box';}?>" style="height:27px;" data-pid="<?php echo $productDetails->row()->seller_product_id;?>" href="javascript:void(0);"><?php if($this->lang->line('header_save') != '') { echo stripslashes($this->lang->line('header_save')); } else echo "Save"; ?></a>
                    
                    <div class="save_amount_box">
                    
                    	<span></span>
                        
                        <div class="save_amount"><?php echo $productDetails->row()->likes;?></div>
                    
                    </div>
                
                
                </div>
          
                <?php if ($productDetails->row()->quantity > 0){?>
                <div class="detail_save"> <input type="button" class="greencart buy_btn" name="addtocart" value="<?php if($this->lang->line('product_buy') != '') { echo stripslashes($this->lang->line('product_buy')); } else echo "Buy"; ?>" onclick="ajax_add_cart();" />
            <div class="buy_amount_box"> <span></span>
              <div class="buy_amount"><?php echo $currencySymbol.$productDetails->row()->sale_price;?></div>
              
              
               <input type="hidden" class="option number" name="product_id" id="product_id" value="<?php echo $productDetails->row()->id;?>">
                <input type="hidden" class="option number" name="sell_id" id="sell_id" value="<?php echo $productDetails->row()->user_id;?>">
                <input type="hidden" class="option number" name="price" id="price" value="<?php echo $productDetails->row()->sale_price;?>">
                <input type="hidden" class="option number" name="product_shipping_cost" id="product_shipping_cost" value="<?php echo $productDetails->row()->shipping_cost;?>"> 
                <input type="hidden" class="option number" name="product_tax_cost" id="product_tax_cost" value="<?php echo $productDetails->row()->tax_cost;?>">
                <input type="hidden" class="option number" name="attribute_values" id="attribute_values" value="">
				<input id="quantity" class="option quantity" type="hidden" value="1"  name="quantity">
				<div style="display: none;" class="menu-contain-cart after" id="cart_popup">
                <div id="MiniCartViewDisp" style="display: none;"></div>
				
                <!--<a class="buy_info example17" href="#"><img src="images/buy_info.jpg" /></a>--> </div>
          </div>
           <?php }else {?>
          <div class="detail_save"> <input style="opacity: 0.5;" type="button" class="greencart buy_btn" value="Sold Out" />
		<?php }?>     
               
                
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
	<div class="TabbedPanels" id="TabbedPanels1">
     	<ul class="TabbedPanelsTabGroup">
			<li tabindex="0" class="TabbedPanelsTab  TabbedPanelsTabSelected"><?php if($this->lang->line('item_details') != '') { echo stripslashes($this->lang->line('item_details')); } else echo "Item Details"; ?></li>
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
<div class="realted_product_main">
                <div class="realted_product_title">
                	<span class="realted_tag"><?php if($this->lang->line('product_morefrom') != '') { echo stripslashes($this->lang->line('product_morefrom')); } else echo "more from"; ?> <a href="user/<?php echo $userName;?>"><?php if ($fullName == ''){echo $userName;}else {echo $fullName;}?> </a></span>
                    
<?php if ($productDetails->row()->user_id != $loginCheck){?><a class="right <?php if ($loginCheck==''){echo 'sign_box';}?>  <?php echo $followClass;?>" href="javascript:void(0);" <?php if ($loginCheck != ''){?>data-uid="<?php echo $productDetails->row()->user_id;?>" onclick="javascript:store_follow(this);"<?php }?>><?php echo $followText;?></a><?php }?> </div>
                       <div class="prev_1"><img src="images/prev-arrow.png" alt="prev" /></div>
      <div class="slider_1">
                
                	<ul class="realted_product">
					<?php 
						
						$moreid=0;
						foreach ($MoreProduct as $MoreFrom){  $prodImg1= 'dummyProductImage.jpg';
						if ($MoreFrom->seller_product_id != $productDetails->row()->seller_product_id){$moreid=$moreid+1;
						$prodImgArr1 = array_filter(explode(',', $MoreFrom->image));

						//$prodImg1=$prodImgArr1[0];

						if($prodImgArr1[0] != ''){
							$prodImg1=$prodImgArr1[0];
						}

						if (isset($MoreFrom->web_link)){
							$prod_link = 'user/'.$MoreFrom->user_name.'/things/'.$MoreFrom->seller_product_id.'/'.url_title($MoreFrom->product_name,'-');
						}else {
							$prod_link = 'things/'.$MoreFrom->id.'/'.url_title($MoreFrom->product_name,'-');
						}
					?>
                    	<li><a href="<?php echo $prod_link; ?>"><img src="images/product/thumb/<?php echo $prodImg1;?>" /></a></li>
                    <?php $prodImg='';}} ?>
                          
                    
                    
                    </ul>
                    
                                    </div>
            
            <div class="next_1"><img src="images/next-arrow.png" alt="next" /></div>
                
                
                </div>
<?php }}?>
<div class="tweet_comments_main"> <a class="tweet_seemore" href="javascript:void(0);"><?php if($this->lang->line('product_comments') != '') { echo stripslashes($this->lang->line('product_comments')); } else echo "Comments"; ?></a>   
        
        
    <?php 
    if ($productComment->num_rows() > 0){
        foreach ($productComment->result() as $cmtrow){
            if ($cmtrow->status == 'Active'){
                
        
    ?>
    <div class="tweet_comment"> <span class="tweet_comment_avatar"><img src="images/users/<?php if($cmtrow->thumbnail!=''){ echo $cmtrow->thumbnail;}else{echo 'user-thumb.png';}?>" /></span>
<div class="comments_detail_content"> <a class="comments_detail_name" href="<?php echo base_url();?>user/<?php echo $cmtrow->user_name;?>"><?php echo ucfirst($cmtrow->user_name);?></a> <strong class="comments_detail_email"><!--<a href="#">@keels54</a>--> <?php echo $cmtrow->comments;?> </strong> <span class="comments_detail_day"><?php  $time_ago =strtotime($cmtrow->dateAdded);
echo time_stamp($time_ago); ?> </span> </div>
</div>
    <?php 
            }else {
                if ($loginCheck != '' && $loginCheck == $productDetails->row()->user_id){
    ?>
    <div class="tweet_comment"> <span class="tweet_comment_avatar"><img src="images/users/<?php if($cmtrow->thumbnail!=''){ echo $cmtrow->thumbnail;}else{echo 'user-thumb.png';}?>" /></span>
<div class="comments_detail_content"> <a class="comments_detail_name" href="<?php echo base_url();?>user/<?php echo $cmtrow->user_name;?>"><?php echo ucfirst($cmtrow->user_name);?></a> <strong class="comments_detail_email"><!--<a href="#">@keels54</a>--> <?php echo $cmtrow->comments;?> </strong> <span class="comments_detail_day"><?php  $time_ago =strtotime($cmtrow->dateAdded);
echo time_stamp($time_ago); ?> </span> </div>
<p style="float:left;width:100%;text-align:left;">
            <a style="font-size: 11px; color: #188A0E;cursor:pointer;" onclick="javascript:approveCmt(this);" data-uid="<?php echo $cmtrow->CUID;?>" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('product_approve') != '') { echo stripslashes($this->lang->line('product_approve')); } else echo "Approve"; ?></a>
            <a style="font-size: 11px; color: #f33;cursor:pointer;" onclick="javascript:deleteCmt(this);" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('product_delte') != '') { echo stripslashes($this->lang->line('product_delte')); } else echo "Delete"; ?></a>
        </p>
</div>
    
    <?php 		
                }else {
                    if ($loginCheck == $cmtrow->CUID){
    ?>
    
    <div class="tweet_comment"> <span class="tweet_comment_avatar"><img src="images/users/<?php if($cmtrow->thumbnail!=''){ echo $cmtrow->thumbnail;}else{echo 'user-thumb.png';}?>" /></span>
<div class="comments_detail_content"> <a class="comments_detail_name" href="<?php echo base_url();?>user/<?php echo $cmtrow->user_name;?>"><?php echo ucfirst($cmtrow->user_name);?></a> <strong class="comments_detail_email"><!--<a href="#">@keels54</a>--> <?php echo $cmtrow->comments;?> </strong> <span class="comments_detail_day"><?php  $time_ago =strtotime($cmtrow->dateAdded);
echo time_stamp($time_ago); ?> </span> </div>
<p style="float:left;width:100%;text-align:left;font-size: 11px; color: #188A0E; cursor:pointer;">
            <?php if($this->lang->line('product_wait_appr') != '') { echo stripslashes($this->lang->line('product_wait_appr')); } else echo "Waiting for approval"; ?>
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
<div class="comments_detail_content"><form action="#" method="post" style="margin:0px;">
<input type="hidden" name="cproduct_id" id="cproduct_id" value="<?php echo $productDetails->row()->seller_product_id;?>"/>
<input type="hidden" name="user_id" id="user_id" value="<?php echo $loginCheck ;?>"/>
<textarea name="comments" placeholder="<?php if($this->lang->line('header_write_comment') != '') { echo stripslashes($this->lang->line('header_write_comment')); } else echo "Write a comment"; ?>..." id="comments" class="tweet_comments_links1" ></textarea>

<input type="submit" <?php if($loginCheck==''){ ?>require-login='true'<?php }?> class="post_btn1 submit button" value="<?php if($this->lang->line('header_post_comment') != '') { echo stripslashes($this->lang->line('header_post_comment')); } else echo "Post"; ?>" />
</form>
</div> 
</div></div>

</div>

</div>

<?php 
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
<script type="text/javascript">
$('.save').unbind("click").bind("click",function(event){
	if(!$(this).hasClass('sign_box')){
		var pid = $(this).data('pid');
		if($(this).hasClass('saving'))return;
		$(this).addClass('saving');
		$('#inline_example19 .select-list-inner ul').html('Loading...');
		$('#inline_example19 .select-list-inner ul').attr('tid',pid);
		$('#inline_example19 .save_done').data('pid',pid);
		$.ajax({
			type:'POST',
			url:baseURL+'site/user/add_list_when_fancyy',
			data:{tid:pid},
			dataType:'json',
			success:function(response){
				if(response.status_code == 1){
//					$('#inline_example19 .select-list').text(response.firstCatName);
					$('#inline_example19 .select-list-inner ul').html(response.listCnt);
//					if(response.wanted == 1){
//						$('.btn-want').addClass('wanted').find('b').text('Wanted');
//					}
				}
			}
		});
		var save_url = baseURL+'site/user/add_fancy_item';
		$.ajax({
			type:'POST',
			url:save_url,
			data:{tid:pid},
			dataType:'json',
			success:function(response){
				if(response.status_code == '1'){
//					$this.find('strong').text(likedTXT);
					$(this).find('strong').text('Saved');
				}
			}
		});
		$(".save").colorbox({inline:true, href:"#inline_example19"});
		$('#colorbox').show();
		$(this).removeClass('saving');
		$('.save_done').unbind('click').bind('click',function(){
			window.location.reload();
		});
	}
});
</script>