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
<script type="text/javascript">
			$(document).ready(function(){
			
				//To switch directions up/down and left/right just place a "-" in front of the top/left attribute
				//Vertical Sliding
			
				$('.boxgrid.captionful').hover(function(){
				//	$(".cover1", this).stop().animate({top:'0px'},{queue:false,duration:750});
					 $(".cover", this).css({ 'display': 'block' });
				}, function() {
				//	$(".cover1", this).stop().animate({top:'295px'},{queue:false,duration:750});
					 $(".cover", this).css({ 'display': 'none' });
				});
				//Caption Sliding (Partially Hidden to Visible)
				
			});
		</script>
<!-- Section_start -->
    <section>
    <div class="section_main">
        
            <div class="main3">
                <div class="main_box">
    <?php $this->load->view('site/store/store_menu',$this->data); ?>
    <div class="profile_tab">
                    <div class="tab_product">
                        <ul class="tab_box">
                            <li><a href="<?php echo base_url();?>store/<?php echo $store_details->row()->store_url;?>"><strong></strong><span><?php if($this->lang->line('templates_products') != '') { echo stripslashes($this->lang->line('templates_products')); } else echo "Products"; ?></span></a></li>
                            <li><a href="<?php echo base_url();?>store/<?php echo $store_details->row()->store_url;?>/trending"><strong></strong><span><?php if($this->lang->line('trending_trend') != '') { echo stripslashes($this->lang->line('trending_trend')); } else echo "Trending"; ?></span></a></li>
                            <?php if($storelogoDetails->row()->user_id>0) { ?>
	                            <li><a href="<?php echo base_url();?>store/<?php echo $store_details->row()->store_url;?>/collections"><strong></strong><span><?php echo "Collections"; ?></span></a></li>
    	                        <li><a class="tab_active" href="<?php echo base_url();?>store/<?php echo $store_details->row()->store_url;?>/stories"><strong></strong><span><?php echo "Stories"; ?></span></a></li>
                            <?php } ?>    
                        </ul>
                    </div>
                    </div>
    <div class="activity-feed" style="width: 100%;">
              <div class="new-activity-feed-alert"> <a class="alert-body" href="#"><span></span> </a></div>
              <?php 
			 //  echo "<pre>"; print_r($stories_details->result());
			  if($stories_details->num_rows() > 0){
			  
			   foreach($stories_details->result() as $stories_details_row){

								$StoriesuserName = 'administrator';
                				$StoriesfullName = 'administrator';
                				if ($stories_details_row->user_id > 0){
                					$StoriesuserName = $stories_details_row->user_name;
                					$StoriesfullName = $stories_details_row->full_name;
                				}
                				if ($StoriesfullName == ''){
                					$StoriesfullName = $StoriesuserName;
                				}
								
								$userImg = 'default_user.jpg';
								if ($stories_details_row->thumbnail != ''){
									$userImg = $stories_details_row->thumbnail;
								} 
 ?>
              <div class="activity-feed-item story_con_<?php echo $stories_details_row->id;?>" style="position: relative;width: 91%">
              <?php if ($loginCheck>0 && $loginCheck==$stories_details_row->user_id){?>
	            <div class="actions_menu" style="position: absolute;right: 20px;">
	              	<a href="stories/<?php echo $stories_details_row->id;?>/edit?next=user/<?php echo $StoriesuserName;?>/stories" data-sid="<?php echo $stories_details_row->id;?>"><?php if($this->lang->line('shipping_edit') != '') { echo stripslashes($this->lang->line('shipping_edit')); } else echo "Edit"; ?></a>
	              	/ <a href="#" data-sid="<?php echo $stories_details_row->id;?>" onclick="return delete_story(this);"><?php if($this->lang->line('product_delte') != '') { echo stripslashes($this->lang->line('product_delte')); } else echo "Delete"; ?></a>
	            </div>
	          <?php }?> 
                <div class="alert-item" style="text-align: left;">
                  <div class="alerts-picture"> <a href="user/<?php echo $StoriesuserName; ?>/"><img width="45px" src="images/users/<?php echo $userImg;?>" class="avatar-image avatar-x45 " alt="sriram123"></a> </div>
                  <div class="alerts-info" style="width:90%;"> <span class="alerts-username"> <a href="user/<?php echo $StoriesuserName ?>/"><?php echo $StoriesuserName; ?></a> </span> <span class="alerts-text"> <?php if($this->lang->line('story_postedstory') != '') { echo stripslashes($this->lang->line('story_postedstory')); } else echo "posted a story"; ?> </span> <span class="follow-text"> </span>
                    <div>
                      <div class="alerts-date"> <abbr title="22 minutes ago" class="timeago">
                        <?php $time_ago1 =strtotime($stories_details_row->dateAdded); echo time_stamp($time_ago1); ?>
                        </abbr> </div>
                      <!--<div class="delete">
                                <a rel="nofollow" data-method="delete" href="#" data-remote="true"> delete</a>
                                </div>-->
                    </div>
                    <div class="alert-item-body"> <?php echo $stories_details_row->description; ?> </div>
                  </div>
                </div>
                <div class="activity-feed-products-container">
                  <div class="activity-feed-sub-image"> </div>
                  <div class="activity-feed-products products-thumbnails">
                    <ul class="product_main_thumb">
                      <?php
					  
					/*echo '<pre>';print_r($ProductDetails[$stories_details_row->id]['StoriesProduct']);
					print_r($ProductDetails[$stories_details_row->id]['StoriesUserProduct']);*/
					  
				if($ProductDetails[$stories_details_row->id]['StoriesProduct']!='' && count($ProductDetails[$stories_details_row->id]['StoriesProduct']) >0){
				
				
				
				foreach($ProductDetails[$stories_details_row->id]['StoriesProduct'] as $ProductDetailsRow ){ 
				
				
				
				
				
				$prodImg = 'dummyProductImage.jpg';
                				$prodImgArr = array_filter(explode(',', $ProductDetailsRow[0]->image));
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
                				if ($ProductDetailsRow[0]->user_id > 0){
                					$userName = $ProductDetailsRow[0]->user_name;
                					$fullName = $ProductDetailsRow[0]->full_name;
                				}
								if ($fullName == ''){
                					$fullName = $userName;
                				}
								$userImg = 'default_user.jpg';
								if ($ProductDetailsRow[0]->thumbnail != ''){
									$userImg = $ProductDetailsRow[0]->thumbnail;
								} 
								if (isset($ProductDetailsRow[0]->web_link)){
									$prod_link = 'user/'.$userName.'/things/'.$ProductDetailsRow[0]->seller_product_id.'/'.url_title($ProductDetailsRow[0]->product_name,'-');
								}else {
									$prod_link = 'things/'.$ProductDetailsRow[0]->PID.'/'.url_title($ProductDetailsRow[0]->product_name,'-');
								}
				?>
                      <li class="boxgrid captionful">
                      	<a href="<?php echo $prod_link;?>"><img style="position:absolute;top:0;bottom:0;margin:auto;left:0;right:0;z-index: 0;" src="images/product/<?php echo $prodImg;?>" /></a>
                        <div class="info_links">
                            <a href="user/<?php echo $userName; ?>"><img src="images/users/<?php echo $userImg;?>"></a>
                            <a class="info_uname" href="user/<?php echo $userName; ?>/"><?php echo $fullName; ?></a>
                            <a class="collection_name" href="<?php echo $prod_link;?>"><?php echo $ProductDetailsRow[0]->product_name; ?></a>
                        </div>
                        <div class="cover boxcaption" style="top:0px" >
                      <!-- <div class="deal_tag1">-->
                            <div class="tag <?php if ($loginCheck==''){echo 'sign_box';}else {echo 'tag_box';}?>" data-pid="<?php echo $ProductDetailsRow[0]->seller_product_id;?>"> <strong><?php if($this->lang->line('product_tag') != '') { echo stripslashes($this->lang->line('product_tag')); } else echo "Tag"; ?></strong> <span><?php if($this->lang->line('product_afreiend') != '') { echo stripslashes($this->lang->line('product_afreiend')); } else echo "a friend"; ?></span> </div>
                            <div class="save <?php if ($loginCheck==''){echo 'sign_box';}?>" data-pid="<?php echo $ProductDetailsRow[0]->seller_product_id;?>"> <strong><?php if($this->lang->line('header_save') != '') { echo stripslashes($this->lang->line('header_save')); } else echo "Save"; ?></strong> <span><?php echo $ProductDetailsRow[0]->likes;?> <?php if($this->lang->line('product_saves') != '') { echo stripslashes($this->lang->line('product_saves')); } else echo "saves"; ?></span> </div>
                            <div class="deal_tag_title">
                              <h2 style="padding-top:0;"> <a class="" data-pid="<?php echo $ProductDetailsRow[0]->seller_product_id;?>" href="<?php echo $prod_link;?>"><?php echo $ProductDetailsRow[0]->product_name; ?></a></h2>
                                                        <p><?php if($this->lang->line('story_postedby') != '') { echo stripslashes($this->lang->line('story_postedby')); } else echo "posted by"; ?> <a href="user/<?php echo $userName; ?>/"><?php echo $fullName; ?></a> | <span> $<?php echo $ProductDetailsRow[0]->price; ?> </span></p>
                             </div>
                          <!--</div>-->
                        </div>
                      </li>
                      <?php  }
				}?>
                
                <?php
				if($ProductDetails[$stories_details_row->id]['StoriesUserProduct']!='' && count($ProductDetails[$stories_details_row->id]['StoriesUserProduct']) >0){
				
				foreach($ProductDetails[$stories_details_row->id]['StoriesUserProduct'] as $ProductDetailsRow ){ 
						$prodImg = 'dummyProductImage.jpg';
                				$prodImgArr = array_filter(explode(',', $ProductDetailsRow[0]->image));
                				if (count($prodImgArr)>0){
                					foreach ($prodImgArr as $prodImgArrRow){
										if (file_exists('images/product/'.$prodImgArrRow)){
											$prodImg = $prodImgArrRow;
											break;	
										}
                					}
                				}
                				$userName = 'anonymous';
                				$fullName = 'Anonymous';
								//echo $ProductDetailsRow[0][0]->user_name;
                				if ($ProductDetailsRow[0]->user_id > 0){
                					$userName = $ProductDetailsRow[0]->user_name;
                					$fullName = $ProductDetailsRow[0]->full_name;
                					if ($userName==''){ 
                						$userName = 'anonymous';
                						$fullName = 'Anonymous';
                					}
                				}
								if ($fullName == ''){
                					$fullName = $userName;
                				}
								$userImg = 'default_user.jpg';
								if ($ProductDetailsRow[0]->thumbnail != ''){
									$userImg = $ProductDetailsRow[0]->thumbnail;
								} 
								if (isset($ProductDetailsRow[0]->web_link)){
									$prod_link = 'user/'.$userName.'/things/'.$ProductDetailsRow[0]->seller_product_id.'/'.url_title($ProductDetailsRow[0]->product_name,'-');
								}else {
									$prod_link = 'things/'.$ProductDetailsRow[0]->PID.'/'.url_title($ProductDetailsRow[0]->product_name,'-');
								}	
				?>
                      <li class="boxgrid captionful"><a href="<?php echo $prod_link;?>"><img style="position:absolute;top:0;bottom:0;margin:auto;left:0;right:0;z-index:0;" src="images/product/<?php echo $prodImg;?>" /></a>
                        <div class="info_links">
                            <a href="user/<?php echo $userName; ?>"><img src="images/users/<?php echo $userImg;?>"></a>
                            <a class="info_uname" href="user/<?php echo $userName; ?>/"><?php echo $fullName; ?></a>
                            <a class="collection_name" href="<?php echo $prod_link;?>"><?php echo $ProductDetailsRow[0]->product_name; ?></a>
                        </div>
                        <div class="cover boxcaption" style="top:0px;" >
                          <!--<div class="deal_tag1">-->
                            <div class="tag <?php if ($loginCheck==''){echo 'sign_box';}else {echo 'tag_box';}?>" data-pid="<?php echo $ProductDetailsRow[0]->seller_product_id;?>"> <strong><?php if($this->lang->line('product_tag') != '') { echo stripslashes($this->lang->line('product_tag')); } else echo "Tag"; ?></strong> <span><?php if($this->lang->line('product_afreiend') != '') { echo stripslashes($this->lang->line('product_afreiend')); } else echo "a friend"; ?></span> </div>
                            <div class="save <?php if ($loginCheck==''){echo 'sign_box';}?>" data-pid="<?php echo $ProductDetailsRow[0]->seller_product_id;?>"> <strong><?php if($this->lang->line('header_save') != '') { echo stripslashes($this->lang->line('header_save')); } else echo "Save"; ?></strong> <span><?php echo $ProductDetailsRow[0]->likes;?> <?php echo $products_list_row->likes;?> <?php if($this->lang->line('product_saves') != '') { echo stripslashes($this->lang->line('product_saves')); } else echo "saves"; ?></span> </div>
                            <div class="deal_tag_title">
                              <h2 style="padding-top:0;"> <a class="" data-pid="<?php echo $ProductDetailsRow[0]->seller_product_id;?>" href="<?php echo $prod_link;?>"><?php echo $ProductDetailsRow[0]->product_name; ?></a></h2>
                              <p><?php if($this->lang->line('story_postedby') != '') { echo stripslashes($this->lang->line('story_postedby')); } else echo "posted by"; ?> <a href="user/<?php echo $userName; ?>/"><?php echo $fullName; ?></a> | <span> $<?php echo $ProductDetailsRow[0]->price; ?> </span></p>
                            </div>
                         <!-- </div>-->
                        </div>
                      </li>
                      <?php  }
				}?>
                
                
                    </ul>
                  </div>
                  
               <div class="tweet_comments_main">
                  <?php 
    if ($storiesComment[$stories_details_row->id]->num_rows() > 0 && $storiesComment[$stories_details_row->id]!=''){
        foreach ($storiesComment[$stories_details_row->id]->result() as $cmtrow){
        	$cmt_uname = $cmtrow->full_name;
	        if ($cmt_uname==''){
	        	$cmt_uname = $cmtrow->UserName;
	        }
            if ($cmtrow->status == 'Active'){
                
        
    ?>
                  <div class="tweet_comment"> <span class="tweet_comment_avatar"><img src="images/users/<?php if($cmtrow->thumbnail!=''){ echo $cmtrow->thumbnail;}else{echo 'user-thumb.png';}?>" /></span>
                    <div class="comments_detail_content"> <a class="comments_detail_name" href="<?php echo base_url();?>user/<?php echo $cmtrow->UserName;?>"><?php echo ucfirst($cmt_uname);?></a> <p class="comments_detail_email cmt_cnt_<?php echo $cmtrow->id;?>">
                      <?php 
                      	$cmt = preg_replace_callback("/@(\w+)/", array($make_user_link, 'make_user_link'), $cmtrow->comments);
						echo preg_replace("/#(\w+)/", "<a target=\"_self\" href=\"".base_url()."tag/$1\">#$1</a>", $cmt);
                      ?>
                      </p> <span class="comments_detail_day">
                      <?php  $time_ago =strtotime($cmtrow->dateAdded);
echo time_stamp($time_ago); ?>
                      </span> </div>
                      <?php 
if ($loginCheck != '' && $loginCheck == $stories_details_row->user_id || $loginCheck != '' && $loginCheck == $cmtrow->CUID){
?>
<p style="float:left;width:100%;text-align:left;">
<?php if ($loginCheck == $cmtrow->CUID){?>
            <a style="font-size: 11px; color: #0033FF;cursor:pointer;" onclick="javascript:editStoryCmt(this);" data-uid="<?php echo $cmtrow->CUID;?>" data-tid="<?php echo $stories_details_row->id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('shipping_edit') != '') { echo stripslashes($this->lang->line('shipping_edit')); } else echo "Edit"; ?></a>
<?php }?>
            <a style="font-size: 11px; color: #f33;cursor:pointer;" onclick="javascript:deleteStoriesCmt(this);" data-tid="<?php echo $stories_details_row->id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('product_delte') != '') { echo stripslashes($this->lang->line('product_delte')); } else echo "Delete"; ?></a>
<?php ?>        </p>
<?php 
}
?>   
                  </div>
                  <?php 
            }else {
                if ($loginCheck  != '' && $loginCheck == $stories_details_row->user_id){
    ?>
                  <div class="tweet_comment"> <span class="tweet_comment_avatar"><img src="images/users/<?php if($cmtrow->thumbnail!=''){ echo $cmtrow->thumbnail;}else{echo 'user-thumb.png';}?>" /></span>
                    <div class="comments_detail_content"> <a class="comments_detail_name" href="<?php echo base_url();?>user/<?php echo $cmtrow->UserName;?>"><?php echo ucfirst($cmt_uname);?></a> <p class="comments_detail_email cmt_cnt_<?php echo $cmtrow->id;?>">
                      <?php 
                      	$cmt = preg_replace_callback("/@(\w+)/", array($make_user_link, 'make_user_link'), $cmtrow->comments);
						echo preg_replace("/#(\w+)/", "<a target=\"_self\" href=\"".base_url()."tag/$1\">#$1</a>", $cmt);
                      ?>
                      </p> <span class="comments_detail_day">
                      <?php  $time_ago =strtotime($cmtrow->dateAdded);
echo time_stamp($time_ago); ?>
                      </span> </div>
                    <p style="float:left;width:100%;text-align:left;"> 
                    <?php if ($loginCheck == $cmtrow->CUID){?>
		            <a style="font-size: 11px; color: #0033FF;cursor:pointer;" onclick="javascript:editStoryCmt(this);" data-uid="<?php echo $cmtrow->CUID;?>" data-tid="<?php echo $stories_details_row->id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('shipping_edit') != '') { echo stripslashes($this->lang->line('shipping_edit')); } else echo "Edit"; ?></a>
					<?php }?>
                    <a style="font-size: 11px; color: #188A0E;cursor:pointer;" onclick="javascript:approveStoryCmt(this);" data-uid="<?php echo $cmtrow->CUID;?>" data-tid="<?php echo $stories_details_row->id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('product_approve') != '') { echo stripslashes($this->lang->line('product_approve')); } else echo "Approve"; ?></a> 
                    <a style="font-size: 11px; color: #f33;cursor:pointer;" onclick="javascript:deleteStoriesCmt(this);" data-tid="<?php echo $stories_details_row->id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('product_delte') != '') { echo stripslashes($this->lang->line('product_delte')); } else echo "Delete"; ?></a> 
                    </p>
                  </div>
                  <?php 		
                }else {
                    if ($loginCheck != '' && $loginCheck == $cmtrow->CUID){
					
    ?>
                  <div class="tweet_comment"> <span class="tweet_comment_avatar"><img src="images/users/<?php if($cmtrow->thumbnail!=''){ echo $cmtrow->thumbnail;}else{echo 'user-thumb.png';}?>" /></span>
                    <div class="comments_detail_content"> <a class="comments_detail_name" href="<?php echo base_url();?>user/<?php echo $cmtrow->UserName;?>"><?php echo ucfirst($cmt_uname);?></a> <p class="comments_detail_email cmt_cnt_<?php echo $cmtrow->id;?>">
                      <?php 
                      	$cmt = preg_replace_callback("/@(\w+)/", array($make_user_link, 'make_user_link'), $cmtrow->comments);
						echo preg_replace("/#(\w+)/", "<a target=\"_self\" href=\"".base_url()."tag/$1\">#$1</a>", $cmt);
                      ?> 
                      </p> <span class="comments_detail_day">
                      <?php  $time_ago =strtotime($cmtrow->dateAdded);
echo time_stamp($time_ago); ?>
                      </span> </div>
                    <p style="float:left;width:100%;text-align:left;font-size: 11px; color: #188A0E; cursor:pointer;"> 
                    <?php if($this->lang->line('product_wait_appr') != '') { echo stripslashes($this->lang->line('product_wait_appr')); } else echo "Waiting for approval"; ?> 
                    <a style="font-size: 11px; color: #0033FF;cursor:pointer;" onclick="javascript:editStoryCmt(this);" data-uid="<?php echo $cmtrow->CUID;?>" data-tid="<?php echo $stories_details_row->id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('shipping_edit') != '') { echo stripslashes($this->lang->line('shipping_edit')); } else echo "Edit"; ?></a>
                    <a style="font-size: 11px; color: #f33;margin-left:10px" onclick="javascript:deleteStoriesCmt(this);" data-tid="<?php echo $stories_details_row->id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('product_delte') != '') { echo stripslashes($this->lang->line('product_delte')); } else echo "Delete"; ?></a> 
                    </p>
                  </div>
                  <?php 
                    }
                }
            }
        }
    }?>
    
    
    
    </div>
    
    
                  <div class="activity-feed-story-item-links">
                    <!--<span class="likes wnl-hidden">
                                <a data-remote="true" class="likes-modal-link" href="/s/267553/likes"><span class="likes-count">0</span>
                                <span class="likes-people">people</span>
                                </a><span class="likes-liked-this">
                                liked this
                                </span>
                                ·
                                </span>
                                <span class="reposts wnl-hidden">
                                <a data-remote="true" class="story-reposters-modal-link" href="/s/267553/reposts"><span class="reposts-count">0 reposts</span>
                                </a>·
                                </span>
                                <a resource="story" rel="nofollow" data-remote="true" data-method="post" data-disable-with="Like" class=" btn-like" href="/s/267553/like">Like</a>
                                <a resource="story" rel="nofollow" data-remote="true" data-method="delete" data-disable-with="Liked" class="wnl-hidden btn-unlike" href="/s/267553/like">Liked</a>
                                ·
                                <a href="http://wanelo.com/s/267553">Share</a>
                                <div class="pull-right embed-story-container">
                                <a data-toggle="popover" data-title="Copy this magic:" data-placement="bottom" data-id="267553" data-html="true" data-content="" class="story-embed-link" href="#">Embed</a>
                                </div>-->
                    <div class="activity-feed-story-item-comments">
                      <div class="comments">
                        <div class="comments-show-more-btn"> </div>
                      </div>
                      <div class="submit-comment">
                        <form action="#" method="post" class="new_comment" name="post<?php echo $stories_details_row->id;?>">
                          <div class="submit-comment-form-body">
                            <div class="submit-comment-avatar"> <img width="44px" src="images/users/<?php if($loginCheck != '' && $userDetails->row()->thumbnail!=''){ echo $userDetails->row()->thumbnail; }else{ echo 'default_user.jpg';}?>" /> </div>
                            <div class="submit-comment-error"></div>
                            <div class="submit-comment-textarea-container" style="width:80%;">
                              <textarea maxlength="750" cols="40" name="comments" placeholder="<?php if($this->lang->line('header_write_comment') != '') { echo stripslashes($this->lang->line('header_write_comment')); } else echo "Write a comment"; ?>..." id="comments<?php echo $stories_details_row->id;?>" class="autocomplete submit-comment-textarea story_txt"></textarea>
                            </div>
                          </div>
                          <input type="hidden" name="cproduct_id" id="cproduct_id<?php echo $stories_details_row->id;?>" value="<?php echo $stories_details_row->id;?>"/>
                          <input type="hidden" name="user_id" id="user_id" value="<?php echo $loginCheck ;?>"/>
                          <div class="submit-comment-form-actions">
                            <input type="submit" <?php if($loginCheck==''){ ?>require-login='true'<?php }?> class="button wb-primary large submit<?php echo $stories_details_row->id;?>" value="<?php if($this->lang->line('header_post_comment') != '') { echo stripslashes($this->lang->line('header_post_comment')); } else echo "Post"; ?>" />
                           
                          </div>
                        </form>
                      </div>
<?php 
if ($this->lang->line('lg_cmt_emt')!=''){
	$lg_cmt_emt = $this->lang->line('lg_cmt_emt');
}else {
	$lg_cmt_emt = 'Your comment is empty';
}
?>
<script type="text/javascript">
$(function() {

	$(".submit<?php echo $stories_details_row->id;?>").click(function() {
	
		var requirelogin = $(this).attr('require-login');
		var $submit = $(this);
		if(requirelogin){
			var thingURL = $(this).parent().next().find('a:first').attr('href');
			$(".sign_box:first").trigger('click');
			return false;
		}
		if($submit.hasClass('posting')) return false;
    	$submit.css('opacity',0.1).addClass('posting');
		var comments = $("#comments<?php echo $stories_details_row->id;?>").val();
		var product_id = $("#cproduct_id<?php echo $stories_details_row->id;?>").val();
		var dataString = '&comments=' + comments + '&cproduct_id=' + product_id;
		
		if(comments=='')
		{
			alert('<?php echo $lg_cmt_emt;?>');
			$submit.css('opacity',1).removeClass('posting');
		}
		else
		{
			$.ajax({
				type: "POST",
				url: baseURL+'site/stories/insert_stories_comment',
				data: dataString,
				cache: false,
				dataType:'json',
				success: function(json){
					if(json.status_code == 1){
						alert('Your comment is waiting for approval');
						window.location.reload();
					}
				
				},
				complete:function(){
					$submit.css('opacity',1).removeClass('posting');
				}
			});
		}
		return false;
	});
});
</script>
                    </div>
                  </div>
                </div>
              </div>
              <?php }}else{ ?>
<div class="activity-feed-item">
                
   <?php if($this->lang->line('story_notfound') != '') { echo stripslashes($this->lang->line('story_notfound')); } else echo "No Stories Found"; ?>.             
              </div>              
              <?php } ?>
            </div>
           </div>
          </div>
         </div>
    </section>
   
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
return "ago $seconds seconds";
}
//Minutes
else if($minutes <=60)
{
if($minutes==1)
{
return "ago 1 minute";
}
else
{
return "ago $minutes minutes";
}
}
//Hours
else if($hours <=24)
{
if($hours==1)
{
return "ago 1 hour";
}
else
{
return "ago $hours hours";
}
}
//Days
else if($days <= 7)
{
if($days==1)
{
return "yesterday";
}
else
{
return "ago $days days";
}
}
//Weeks
else if($weeks <= 4.3)
{
if($weeks==1)
{
return "ago 1 week";
}
else
{
return "ago $weeks weeks";
}
}
//Months
else if($months <=12)
{
if($months==1)
{
return "ago 1 month";
}
else
{
return "ago $months months";
}
}
//Years
else
{
if($years==1)
{
return "ago 1 year";
}
else
{
return "ago $years years";
}
}
}
?>    
    
<?php
$this->load->view('site/templates/footer');
?>