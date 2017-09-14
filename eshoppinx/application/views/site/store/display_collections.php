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
.left_follow{
	width:auto;
	text-align:left;
}
</style> 
<!-- Section_start -->
    <section>
    	
        <div class="section_main">
        
            <div class="main3">
                <div class="main_box">
        
        <?php $this->load->view('site/store/store_menu',$this->data); ?>
    
        <!--<div class="product_main">-->
        <div class="profile_tab">
                    <div class="tab_product">
                        <ul class="tab_box">
                            <li><a href="<?php echo base_url();?>store/<?php echo $store_details->row()->store_url;?>"><strong></strong><span><?php if($this->lang->line('templates_products') != '') { echo stripslashes($this->lang->line('templates_products')); } else echo "Products"; ?></span></a></li>
                            <li><a href="<?php echo base_url();?>store/<?php echo $store_details->row()->store_url;?>/trending"><strong></strong><span><?php if($this->lang->line('trending_trend') != '') { echo stripslashes($this->lang->line('trending_trend')); } else echo "Trending"; ?></span></a></li>
                            <?php if($storelogoDetails->row()->user_id>0) { ?>
	                            <li><a class="tab_active" href="<?php echo base_url();?>store/<?php echo $store_details->row()->store_url;?>/collections"><strong></strong><span><?php echo "Collections"; ?></span></a></li>
    	                        <li><a href="<?php echo base_url();?>store/<?php echo $store_details->row()->store_url;?>/stories"><strong></strong><span><?php echo "Stories"; ?></span></a></li>
                            <?php } ?>     
                        </ul>
                    </div>
                    </div>
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

                        
                            <div class="store_list" style="background-color:#FFF; width:591px;">
                            
                            	<div class="follow_main" style="height: 435px;">
                
                                    <div class="left_follow" style="width:300px;">
                                    
                                      
                                        <a href="collections/<?php echo $userProfileDetails->row()->user_name;?>/<?php echo url_title($listDetails->name,'-');?>" class="follow_icon_links" style="width:75%;overflow:hidden;height:20px;"><?php echo $listDetails->name;?></a>
                                        
                                        <span class="follow_count" style="width: 75%;"><?php echo $listDetails->followers_count;?> <?php if($this->lang->line('display_followers') != '') { echo stripslashes($this->lang->line('display_followers')); } else echo "Followers"; ?></span>
                                    
                                    
                                    </div>
                    
                                        <div class="right_follow">
                                        
                                            <a class="<?php echo $followClass.' '; if ($loginCheck==''){echo 'sign_box';}?>" <?php if ($loginCheck != ''){?>data-uid="<?php echo $listDetails->id;?>" onclick="javascript:list_follow(this);"<?php }?> ><?php echo $followtext;?></a>
                                                      	</div>	
                    
                    
                                      <ul class="store_list_follow">
                                      <?php 
									  if($prodDetails[$listDetails->id] != '' && count($prodDetails[$listDetails->id])>0){
                                      	$limitCount = 0;
										foreach ($prodDetails[$listDetails->id] as $listDcetailsvals){
											if ($limitCount==6)break;$limitCount++;
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
<p><?php if($this->lang->line('no_collections') != '') { echo stripslashes($this->lang->line('no_collections')); } else echo "No collections available"; ?></p>
<?php 
}
?>                   
                        <!--</div>-->
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