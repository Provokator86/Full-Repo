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
float: left;
margin-bottom: 25px;
width: 96.1%;
padding:0px;
background:#fff;
}

.follow_main {
display: inline-block;
background: #f2f2f2;
padding: 10px;
margin: 10px 0px;
width: 93%;
}
.follow_main { 
text-align:left;
}

.store_list_follow li {
display: inline-block;
margin-bottom: 7px;
margin-left: 7px;
min-height: 115px;
position: relative;
width: 129px;
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
<?php
				
				$followClass = 'follow_btn';
				$followtext= stripslashes($this->lang->line('onboarding_follow'));
				if ($followtext == ''){
					$followtext = 'Follow';
				}
				if ($loginCheck != ''){
					$followingListArr = explode(',', $store_details->row()->followers);
					if (in_array($loginCheck, $followingListArr)){
						$followClass = 'following_btn';
						$followtext= stripslashes($this->lang->line('display_following'));
				        if ($followtext == ''){
							$followtext = 'Following';
						}
					}
				}
				?>
					<!--<div class="profile_main">
					
					
						<div class="profile_left">
					
							<div class="profile_left_title_txt">
							<?php
							$fullName = character_limiter($store_details->row()->store_name,35);
							if (strlen($fullName)>35){
								$fullName = substr($fullName, 0,35).'..';
							}
							?>
								<h1 style="margin-left: 20px;">
								<?php echo $fullName;?>
								</h1>
								<p style="clear: left; margin-bottom: 5px;clear: both;margin: 10px 0 0 20px;text-align: left;float: left;">
									<a title="<?php echo $fullName;?>"
										href="<?php echo prep_url($fullName);?>"
										target="_blank" class=""><?php if($this->lang->line('visit_store') != '') { echo stripslashes($this->lang->line('visit_store')); } else echo "Visit Store"; ?></a>
								</p>
							</div>
					
						</div>
					
						<div class="profile_right" style="width: auto;">
					
							<ul class="profile_right_links">
					
								<li><a
									href="store/<?php echo $store_details->row()->store_name;?>/followers"><strong><?php echo $store_details->row()->followers_count;?>
									</strong> <span><?php if($this->lang->line('display_followers') != '') { echo stripslashes($this->lang->line('display_followers')); } else echo "Followers"; ?>
									</span> </a></li>
					
					
								<li><a
									class="edit_btn <?php echo $followClass.' '; if ($loginCheck==''){echo 'sign_box';}?>"
									<?php if ($loginCheck != ''){?>
									data-uid="<?php echo $store_details->row()->id;?>"
									onclick="javascript:follow_store(this);" <?php }?>><?php echo $followtext;?>
								</a></li>
					
							</ul>
					
					
					
						</div>
					
					</div>-->
                    <?php $this->load->view('site/store/store_menu',$this->data); ?>
                		<div class="tab_product">
                        
                        	<ul class="tab_box">
                            
                            	<li><a style="width:100%;" href="store/<?php echo $store_details->row()->store_url;?>"><?php echo $store_details->row()->store_name;?> / <?php if($this->lang->line('display_followers') != '') { echo stripslashes($this->lang->line('display_followers')); } else echo "Followers"; ?></a></li>
                                
                             
                            
                            
                            </ul>
                            
                            
                            <!--<ul class="right_tab">
                            
                            	<li><a class="find_btn" href="people">Find People</a></li>
                                
                                <li><a class="find_btn" href="stores">Find Stores</a></li>
                            
                            
                            </ul>-->
                        
                        
                        </div>
                        
                        <div class="product_main">
<?php 
    if($follower_details!= '' && $follower_details->num_rows()>0){
    	foreach ($follower_details->result() as $followingUserRow){
		//print_r($followingUserRow);
    		$userImg = 'user-thumb1.png';
	        if ($followingUserRow->thumbnail != ''){
	        	if (file_exists('images/users/'.$followingUserRow->thumbnail)){
			        $userImg = $followingUserRow->thumbnail;
	        	}
	        } 
	        $followClass = 'follow_btn';
	        $followText = 'Follow';
	        if ($loginCheck != ''){
		        $followingListArr = explode(',', $userDetails->row()->following);
		        if (in_array($followingUserRow->id, $followingListArr)){
		        	$followClass = 'following_btn';
		        	$followText = 'Following';
		        }
	        } 
    ?>                       
                        
                            <div class="store_list">
                            
                            	<div class="follow_main" style="height: 327px;">
                
                                    <div class="left_follow" style="width:300px;">
                                    
                                        <span class="follow_icon"><a href="user/<?php echo $followingUserRow->user_name;?>" ><img src="images/users/<?php echo $userImg;?>" /></a></span>
                                      
                                        <a class="follow_icon_links" href="user/<?php echo $followingUserRow->user_name;?>" style="width:75%;overflow:hidden;height:20px;"><?php echo $followingUserRow->user_name;?></a>
                                        
                                        <span class="follow_count"><?php echo $followingUserRow->followers_count;?> <?php if($this->lang->line('display_followers') != '') { echo stripslashes($this->lang->line('display_followers')); } else echo "Followers"; ?></span>
                                    
                                    
                                    </div>
                    
                                        <div class="right_follow">
                                        
                                            <a class=" <?php echo $followClass.' '; if ($loginCheck==''){echo 'sign_box';}?>" <?php if ($loginCheck != ''){?>data-uid="<?php echo $followingUserRow->id;?>" onclick="javascript:store_follow(this);"<?php }?> ><?php echo $followText;?></a>
                                                      	</div>
                    
                    
                                      <ul class="store_list_follow">
                                       <?php 
                                       if (count($follower_product_details[$followingUserRow->id])>0){
                                       	$limitCount = 0;
                                       	foreach ($follower_product_details[$followingUserRow->id] as $likeProdRow){
                                       		 if ($limitCount>7)break;$limitCount++;
                                       		$img = 'dummyProductImage.jpg';
                                       		$imgArr = explode(',', $likeProdRow->image);
                                       		if (count($imgArr)>0){
                                       			foreach ($imgArr as $imgRow){
                                       				if ($imgRow != ''){
                                       					if (file_exists('images/product/thumb/'.$imgRow)){
                                       						$img = $imgRow;
                                       						break;
                                       					}
                                       				}
                                       			}
                                       		}
                                       		if (isset($likeProdRow->web_link)){
												$prod_link = 'user/'.$followingUserRow->user_name.'/things/'.$likeProdRow->seller_product_id.'/'.str_replace(' ','-',$likeProdRow->product_name);
                                       		}else{
												$prod_link = 'things/'.$likeProdRow->id.'/'.str_replace(' ','-',$likeProdRow->product_name);
                                       		}
                                       		?>
                                                
                                            <li><a href="<?php echo $prod_link;?>"><img src="images/product/thumb/<?php echo $img;?>" /></a></li>
                                       <?php 
	    	}
	    }
	    ?>                
                                  </ul>
                
               				 </div>
                            
                            
                            </div>
                           
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
    	}
    }else {
   ?> 
    
    <p style="float: left;padding: 20px;width:100%;">0 <?php if($this->lang->line('display_followers') != '') { echo stripslashes($this->lang->line('display_followers')); } else echo "Followers"; ?></p>
    <?php 
    }
    ?>                   
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
$this->load->view('site/templates/footer',$this->data);
?>
