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

.product_main {
background:#fff;
}
.main3 {
text-align: left;
}

.follow_main {
width:97%;
}
.store_list_follow {
	overflow: hidden;
	height: 374px;
}
.store_list_follow li {
display: inline-block;
margin-bottom: 7px;
min-height: 115px;
position: relative;
width: 121px;
margin-left:0px;
}
</style> 
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
		$followtext= stripslashes($this->lang->line('onboarding_follow'));
		if ($followtext == ''){
			$followtext = 'Follow';
		}
        if ($loginCheck != ''){
	        $followingListArr = explode(',', $userDetails->row()->following_user_lists);
	        if (in_array($listDetails->id, $followingListArr)){
	        	$followClass = 'following_btn';
	        	$followtext= stripslashes($this->lang->line('display_following'));
		        if ($followtext == ''){
					$followtext = 'Following';
				}
	        }
        }	
?>                        
                        
                            <div class="store_list1">
                            
                            	<div class="follow_main" style="min-height: 360px;">
                
                                    <div class="left_follow" style="width:300px;">
                                    
                                      
                                       <a href="user/<?php echo $userProfileDetails->row()->user_name;?>/lists" class="follow_icon_links" ><?php if($this->lang->line('user_collections') != '') { echo stripslashes($this->lang->line('user_collections')); } else echo "Collections"; ?> /&nbsp;</a><a href="collections/<?php echo $userProfileDetails->row()->user_name;?>/<?php echo url_title($listDetails->name,'-');?>" class="follow_icon_links"><?php echo ucfirst($listDetails->name);?></a>
                                        
                                        <span class="follow_count" style="width: 75%;"><?php echo $listDetails->followers_count;?> <?php if($this->lang->line('display_followers') != '') { echo stripslashes($this->lang->line('display_followers')); } else echo "Followers"; ?></span>
                                    
                                    
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