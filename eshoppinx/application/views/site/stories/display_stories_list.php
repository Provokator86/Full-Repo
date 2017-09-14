<?php
include_once 'application/views/site/user/make_user_link.php';
$make_user_link = new MyCallback($users_list);
$this->load->view('site/templates/header',$this->data);
$this->load->view('site/templates/popup_product_detail.php',$this->data);
?>

<style>
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

.captionfull1 .boxcaption1 {
	height: 0px;
}
.info_links {
	clear: both;
	width: 200px;
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

<section>
  <div class="section_main">
    <div class="main2">
      <div id="outer" class="container push-body" style="margin-top: 5px;">
        <div id="inner" style="margin-top:0px;">
      <?php if($flash_data != '') { ?>
      <div class="errorContainer" id="<?php echo $flash_data_type;?>">
        <script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 3000);</script>
        <p><span><?php echo $flash_data;?></span></p>
      </div>
      <?php } ?>
          <div id="activity-feed-tabs">
            <div class="nav-basic-tab">
              <ul class="nav nav-tabs tab-tle">
                <li class="active"><a href="stories"><?php if($this->lang->line('story_stores') != '') { echo stripslashes($this->lang->line('story_stores')); } else echo "Stories"; ?></a></li>
                <li ><a href="<?php if ($loginCheck==''){echo 'login';}else{?>notifications<?php }?>">Notification</a></li>
              </ul>
            </div>
            <div id="activity-feed-nav"> <a class="button wb-primary small publish-story-button" href="<?php echo base_url(); ?>stories/new"><?php if($this->lang->line('story_poststory') != '') { echo stripslashes($this->lang->line('story_poststory')); } else echo "Post a Story"; ?></a> </div>
          </div>
          <div class="clearfix"></div>
          <div class="activity-feed-container" style="float:left">
            <div class="activity-feed">
              <div class="new-activity-feed-alert"> <a class="alert-body" href="#"><span></span> </a></div>
              <?php 
			  
			  if($stories_details->num_rows() > 0){
			  
			   foreach($stories_details->result() as $stories_details_row){

								$StoriesuserName = 'administrator';
                				$StoriesfullName = 'administrator';
                				if ($stories_details_row->user_id > 0){
                					$StoriesuserName = $stories_details_row->user_name;
                					$StoriesfullName = $stories_details_row->full_name;
                				}
								
								$userImg = 'default_user.jpg';
								if ($stories_details_row->thumbnail != ''){
									$userImg = $stories_details_row->thumbnail;
								} 
 ?>
              <div class="activity-feed-item story_con_<?php echo $stories_details_row->id;?>" style="position: relative;">
              <?php if ($loginCheck>0 && $loginCheck==$stories_details_row->user_id){?>
	            <div class="actions_menu" style="position: absolute;right: 20px;">
	              	<a href="stories/<?php echo $stories_details_row->id;?>/edit?next=stories" data-sid="<?php echo $stories_details_row->id;?>"><?php if($this->lang->line('shipping_edit') != '') { echo stripslashes($this->lang->line('shipping_edit')); } else echo "Edit"; ?></a>
	              	/ <a href="#" data-sid="<?php echo $stories_details_row->id;?>" onclick="return delete_story(this);"><?php if($this->lang->line('product_delte') != '') { echo stripslashes($this->lang->line('product_delte')); } else echo "Delete"; ?></a>
	            </div>
	          <?php }?> 
                <div class="alert-item">
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
                              <h2> <a class="" data-pid="<?php echo $ProductDetailsRow[0]->seller_product_id;?>" href="<?php echo $prod_link;?>"><?php echo $ProductDetailsRow[0]->product_name; ?></a></h2>
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
                				$userName = 'administrator';
                				$fullName = 'administrator';
								//echo $ProductDetailsRow[0][0]->user_name;
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
                              <h2> <a class="" data-pid="<?php echo $ProductDetailsRow[0]->seller_product_id;?>" href="<?php echo $prod_link;?>"><?php echo $ProductDetailsRow[0]->product_name; ?></a></h2>
                              <p><?php if($this->lang->line('story_postedby') != '') { echo stripslashes($this->lang->line('story_postedby')); } else echo "posted by"; ?> <a href="user/<?php echo $userName; ?>/"><?php echo $fullName; ?></a> | <span> $<?php echo $ProductDetailsRow[0]->price; ?> </span></p>
                            </div>
                         <!-- </div>-->
                        </div>
                      </li>
                      <?php  }
				}?>
                
                
                    </ul>
                  </div>
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
                    <div class="comments_detail_content"> <a class="comments_detail_name" href="<?php echo base_url();?>user/<?php echo $cmtrow->UserName;?>"><?php echo ucfirst($cmt_uname);?></a> 
                    <p class="comments_detail_email cmt_cnt_<?php echo $cmtrow->id;?>">
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
                  <div class="activity-feed-story-item-links">
                    <!--<span class="likes wnl-hidden">
                                <a data-remote="true" class="likes-modal-link" href="/s/267553/likes"><span class="likes-count">0</span>
                                <span class="likes-people">people</span>
                                </a><span class="likes-liked-this">
                                liked this
                                </span>
                                �
                                </span>
                                <span class="reposts wnl-hidden">
                                <a data-remote="true" class="story-reposters-modal-link" href="/s/267553/reposts"><span class="reposts-count">0 reposts</span>
                                </a>�
                                </span>
                                <a resource="story" rel="nofollow" data-remote="true" data-method="post" data-disable-with="Like" class=" btn-like" href="/s/267553/like">Like</a>
                                <a resource="story" rel="nofollow" data-remote="true" data-method="delete" data-disable-with="Liked" class="wnl-hidden btn-unlike" href="/s/267553/like">Liked</a>
                                �
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
                      <script type="text/javascript">
$(function() {

$(".submit<?php echo $stories_details_row->id;?>").click(function() {

var requirelogin = $(this).attr('require-login');

if(requirelogin){
var thingURL = $(this).parent().next().find('a:first').attr('href');
$(".sign_box:first").trigger('click');
//alert("Login required");
//window.location = baseURL;
return false;
}
var comments = $("#comments<?php echo $stories_details_row->id;?>").val();
var product_id = $("#cproduct_id<?php echo $stories_details_row->id;?>").val();
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
url: baseURL+'site/stories/insert_stories_comment',
data: dataString,
cache: false,
dataType:'json',
success: function(json){
/*if(json.status_code == 1){
alert('Your comment is waiting for approval');
window.location.reload();
}*/
document.getElementById('comments<?php echo $stories_details_row->id;?>').value='';
$("#flash").hide();

}
});
alert('Your comment is waiting for approval');
window.location.reload();
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
            <div class="activity-feed-suggestions">
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
                      <div class="suggestion-strip-description"> <a class="preview-strip-description-avatar" href="user/<?php echo $store_list->user_name;?>"><img width="45px" src="images/users/<?php echo $userImg;?>" class="avatar-image avatar-x45 " alt=""></a>
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
            <div class="clearfix"></div>
          </div>
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
