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
</style> 
<section>
    
        <div class="section_main">
        
            <div class="main2">
            
                <div class="main_box">
                <?php 
        $userImg = 'default-user.png';
        if ($userProfileDetails->row()->thumbnail != ''){
	        $userImg = $userProfileDetails->row()->thumbnail;
        } 
       $followClass1 = 'follow_btn';
        $followtext1 = 'Follow';
        if ($loginCheck != ''){
	        $followingListArr1 = explode(',', $userDetails->row()->following);
	        if (in_array($userProfileDetails->row()->id, $followingListArr1)){
	        	$followClass1 = 'following_btn';
	        	$followtext1 = 'Following';
	        }
        }  
        ?>
                    <div class="profile_main">
                    
                        <div class="profile_left">
                        
                            <span class="profile_left_avatar"><a href="user/<?php echo $userProfileDetails->row()->user_name;?>" ><img src="images/users/<?php echo $userImg;?>" /></a></span>
                            <?php if ($loginCheck != '' && $userDetails->row()->id == $userProfileDetails->row()->id){?>
           	<a title="Edit Profile Image" style="display: none;" class="btn-edit tooltip" onclick="$.dialog('change-photo').open();return false;" href="javascript:void(0);">
          	<i class="ic-pen"></i>
          	<span><?php if($this->lang->line('display_edit_img') != '') { echo stripslashes($this->lang->line('display_edit_img')); } else echo "Edit Profile Image"; ?><b></b></span>
          	</a>
          <?php }?>	
                        
                            <div style="float: left;">
	                            <?php 
	                        	if ($userProfileDetails->row()->full_name != ''){
		                        	$fullName = character_limiter($userProfileDetails->row()->full_name,35);
	    	                    	if (strlen($fullName)>35){
	        	                		$fullName = substr($fullName, 0,35).'..';
	            	            	}
	                        	}else {
	                        		$fullName = $userProfileDetails->row()->user_name;
	                        	}
	                        	?>
	                            <h1><?php echo $fullName;?></h1>
    	                        <p style="clear:left;margin-bottom:5px;"><?php echo '@'.$userProfileDetails->row()->user_name;?></p>
    	                        <p style="width:280px;clear:left;margin-bottom:3px;"><?php echo $userProfileDetails->row()->about;?></p>
    	                        <ul class="usersection_social">
    	                        <?php if ($userProfileDetails->row()->facebook != ''){
    	                        	$fb_link = $userProfileDetails->row()->facebook;
    	                        	if (substr($fb_link, 0,4) != 'http') $fb_link = 'http://'.$fb_link;
    	                        ?>
			                      	<li><a href="<?php echo $fb_link;?>" target="_blank"><span class="social_media_icons ic_fb"></span> Facebook</a></li>
    	                        <?php }?>
    	                        <?php if ($userProfileDetails->row()->twitter != ''){
    	                        	$tw_link = $userProfileDetails->row()->twitter;
    	                        	if (substr($tw_link, 0,4) != 'http') $tw_link = 'http://'.$tw_link;
    	                        ?>
						            <li><a href="<?php echo $tw_link;?>" target="_blank"><span class="social_media_icons ic_tw"></span> Twitter</a></li>
    	                        <?php }?>
    	                        <?php if ($userProfileDetails->row()->google != ''){
    	                        	$gg_link = $userProfileDetails->row()->google;
    	                        	if (substr($gg_link, 0,4) != 'http') $gg_link = 'http://'.$gg_link;
    	                        ?>
						            <li><a href="<?php echo $gg_link;?>" target="_blank"><span class="social_media_icons ic_go"></span> Google+</a></li>
    	                        <?php }?>
					          </ul>
                        	</div>
                            
                        </div>
                        
                        <div class="profile_right">
                        
                            <ul class="profile_right_links">
                            
                                <li><a href="user/<?php echo $userProfileDetails->row()->user_name;?>/followers" ><strong><?php echo $userProfileDetails->row()->followers_count;?></strong> <span><?php if($this->lang->line('display_followers') != '') { echo stripslashes($this->lang->line('display_followers')); } else echo "Followers"; ?></span></a></li>
            					
                                <li><a href="user/<?php echo $userProfileDetails->row()->user_name;?>/following" ><strong><?php echo $userProfileDetails->row()->following_count;?></strong> <span><?php if($this->lang->line('display_following') != '') { echo stripslashes($this->lang->line('display_following')); } else echo "Following"; ?></span></a></li>
                                
                                
                               <?php if($loginCheck !='' && $userProfileDetails->row()->id==$loginCheck){ ?>
                                <li><a class="edit_btn" href="settings">Edit Profile</a></li>
                                <?php }else{ ?>
                                 <li><a class="edit_btn <?php echo $followClass1.' '; if ($loginCheck==''){echo 'sign_box';}?>" <?php if ($loginCheck != ''){?>data-uid="<?php echo $userProfileDetails->row()->id;?>" onclick="javascript:store_follow(this);"<?php }?> ><?php echo $followtext1;?></a></li>
                                <?php } ?>
                                
                            </ul>
                            
                           <!-- <a class="find_btn_icon" href="#">Find <?php echo $userProfileDetails->row()->user_name;?> a</a>-->
                            
                        
                        </div>
                    
                    
                    </div>
            
                    <div class="tab_product">
                    
                        <ul class="tab_box">
                        
                            <!--<li><a href="user/<?php echo $userProfileDetails->row()->user_name;?>"><strong></strong><span>Saved</span></a></li>
                            <li><a href="user/<?php echo $userProfileDetails->row()->user_name;?>/added"><strong></strong><span>Added</span></a></li>
                            
                            <li><a class="" href="user/<?php echo $userProfileDetails->row()->user_name;?>/lists"><strong></strong><span>Collections</span></a></li> 	
                            <li><a class="tab_active" href="javascript:void(0);"><strong></strong><span>Category</span></a></li>-->
                            <!--<li><a href="addedstories"><strong></strong><span>Stories</span></a></li>-->
                        
                        </ul>
                        
                    
                    </div>
                    
                    <div class="product_main">
<?php 
if (count($listDetails) > 0){
	foreach ($listDetails->result() as $listDetails){
	$followClass = 'follow_btn';
        $followtext = 'Follow';
        if ($loginCheck != ''){
	        $followingListArr = explode(',', $userDetails->row()->following_user_lists);
	        if (in_array($listDetails->id, $followingListArr)){
	        	$followClass = 'following_btn';
	        	$followtext = 'Following';
	        }
        }	
?>                        
                        
                            <div class="store_list1">
                            
                            	<div class="follow_main" style="min-height: 360px;">
                
                                    <div class="left_follow" style="width:300px;">
                                    
                                      
                                       <a href="user/<?php echo $userProfileDetails->row()->user_name;?>/lists" class="follow_icon_links" >Collections /</a><a href="collections/<?php echo $userProfileDetails->row()->user_name;?>/<?php echo url_title($listDetails->name,'-');?>" class="follow_icon_links"><?php echo $listDetails->name;?></a>
                                        
                                        <span class="follow_count" style="width: 75%;"><?php echo $listDetails->followers_count;?> followers</span>
                                    
                                    
                                    </div>
                    
                                        <div class="right_follow">
                                        
                                            <a class="<?php echo $followClass.' '; if ($loginCheck==''){echo 'sign_box';}?>" <?php if ($loginCheck != ''){?>data-uid="<?php echo $listDetails->id;?>" onclick="javascript:list_follow(this);"<?php }?> ><?php echo $followtext;?></a>
                                                      	</div>	
                    
                    
                                      <ul class="store_list_follow">
                                      <?php 
									  if($prodDetails[$listDetails->id] != '' && count($prodDetails[$listDetails->id])>0){
                                      	//$limitCount = 0;
										foreach ($prodDetails[$listDetails->id] as $listDcetailsvals){
											//if ($limitCount==8)break;$limitCount++;
											$prodImg = 'dummyProductImage.jpg';
											$prodImgArr = array_filter(explode(',', $listDcetailsvals->image));
											if (count($prodImgArr)>0){
												foreach ($prodImgArr as $prodImgArrRow){
													if (file_exists('images/product/thumb/'.$prodImgArrRow)){
														$prodImg = $prodImgArrRow;
														break;
													}
												}
											}
											
											if (isset($listDcetailsvals->web_link)){
            						$prod_link = 'user/'.$listDcetailsvals->user_name.'/things/'.$listDcetailsvals->seller_product_id.'/'.url_title($listDcetailsvals->product_name,'-');
            					}else {
            						$prod_link = 'things/'.$listDcetailsvals->id.'/'.url_title($listDcetailsvals->product_name,'-');
            					}
											
											
                                      ?>
                                                
                                            <li><a href="<?php echo $prod_link;?>"><img src="images/product/thumb/<?php echo $prodImg;?>" /></a></li>
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
<p>No Stores available</p>
<?php 
}
?>                   
                        </div>
                  </div>
            
            </div>
        
        
        
        </div>
    
        
        
    
    </section>
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