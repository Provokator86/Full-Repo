<?php
$this->load->view('site/templates/header',$this->data);
$this->load->view('site/templates/popup_product_detail.php',$this->data);
?>
<!-- Section_start -->
    <div id="mid-panel">
        <div class="wrapper">
        <?php 
            $this->data['followingUserDetails'] = $userProfileDetails;
            $this->load->view('site/user/display_user_header',$this->data);
        ?>
            <?php /* ?>
            <div class="trending">
                <div class="trending_lft">
                    <ul class="tabs">                        
                        <li class="active"><a style="width:100%;" href="user/<?php echo $userProfileDetails->row()->user_name;?>"><?php if ($userProfileDetails->row()->full_name!=''){echo $userProfileDetails->row()->full_name;}else {echo $userProfileDetails->row()->user_name;}?> / Followers</a></li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
            <?php */ ?>
            
            <!--<div class="brand_product panes odd" style="display:block;">-->               
            <div class="trading_people"> 
            <?php 
            if ($store_lists->num_rows() > 0){
                foreach ($store_lists->result() as $listDetails){
                    /*echo '<pre>';
                    print_r($listDetails);*/
                    $storeImg = 'dummy_store_logo.png';
                    if ($listDetails->store_logo != ''){
                        $storeImg = $listDetails->store_logo;
                    }
                    $store_name = $listDetails->store_name;
                   //if ($store_name == '')$store_name = $store_list->user_name;
                    $followClass = 'follow_btn';
                    $followText= stripslashes($this->lang->line('onboarding_follow'));
                    if ($followText == ''){
                        $followText = 'Follow';
                    }
                    if ($loginCheck != ''){
                        $followingListArr = explode(',', $listDetails->followers);
                        if (in_array($loginCheck, $followingListArr)){
                            $followClass = 'following_btn';
                            $followText= stripslashes($this->lang->line('display_following'));
                            if ($followText == ''){
                                $followText = 'Following';
                            }
                        }
                    }    
            ?>                 
                
                <div class="box">
                    <div class="box_head">
                        <a href="store/<?php echo $listDetails->store_url;?>"><span class="follow_icon"><img src="images/store/<?php echo $storeImg;?>" /></span></a>
                        <a href="store/<?php echo $listDetails->store_url;?>"><h2><?php echo $store_name;?></h2></a>
                        <span class="follow_count"><?php echo $listDetails->followers_count;?> <?php if($this->lang->line('display_followers') != '') { echo stripslashes($this->lang->line('display_followers')); } else echo "Followers"; ?></span>
                        <!--<a class="follow" href="#">Follow</a>-->
                        <a class="<?php echo $followClass.' '; if ($loginCheck==''){echo 'sign_box';}?>" <?php if ($loginCheck != ''){?>data-uid="<?php echo $listDetails->id;?>" onclick="javascript:follow_store(this);"<?php }?> ><?php echo $followText;?></a>
                        
                    </div>
                    <div class="box_body">
                        <div class="brand_product trading_product">
                            <ul>
                                <?php 
                                /*echo '<pre>';
                                print_r($prodDetails[$listDetails->id]);*/
                                  if($prodDetails[$listDetails->id] != '' && $prodDetails[$listDetails->id]->num_rows()>0){
                                      $limitCount = 0;
                                    foreach ($prodDetails[$listDetails->id]->result() as $listDcetailsvals){
                                        if ($limitCount==3)break;$limitCount++;
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
                                        
                                        if ($listDcetailsvals->web_link!='None'){
                                            $prod_link = 'user/'.$listDcetailsvals->user_name.'/things/'.$listDcetailsvals->seller_product_id.'/'.url_title($listDcetailsvals->product_name,'-');
                                        }else {
                                            $prod_link = 'things/'.$listDcetailsvals->id.'/'.url_title($listDcetailsvals->product_name,'-');
                                        }
                                        
                                        
                                  ?>
                                                                  
                                
                                                                  
                                <li>
                                    <div class="main-box2">
                                        <div class="brandPic">
                                            <table  cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td valign="middle" align="center">
                                                        <img src="images/product/thumb/<?php echo $prodImg;?>" alt="">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="overlay">
                                            <a href="user/<?php echo $followingUserRow->user_name;?>/things/<?php echo $listDcetailsvals->seller_product_id;?>/<?php echo url_title($listDcetailsvals->product_name,'-');?>"><h3><span>&#8377;</span> <?php echo $listDcetailsvals->price; ?></h3></a>
                                            <h4><a href="user/<?php echo $followingUserRow->user_name;?>/things/<?php echo $listDcetailsvals->seller_product_id;?>/<?php echo url_title($listDcetailsvals->product_name,'-');?>"><?php echo $listDcetailsvals->product_name ?></a> </h4>
                                        </div>
                                    </div>    
                                    <div class="article2">
                                        <div class="brand"><a href="javascript:">Arrow</a></div>
                                    </div>
                                </li>                                
                                  <?php 
                                      }
                                  } else {
                                  ?>     
                                  <li>
                                    
                                    <div class="brandPic">
                                            <table  cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td valign="middle" align="center">
                                                        <img src="images/product/thumb/dummyProductImage.jpg" alt="">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div> 
                                    <div class="article2">
                                        <div class="brand"><a href="javascript:">&nbsp;</a></div>
                                    </div>
                                  </li>
                                  <?php } ?>             
                                
                            </ul>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>                                                  
                                
                <?php 
                    }
                }else {
               ?> 
                
                <p>0 <?php if($this->lang->line('shop_nostoresavail') != '') { echo stripslashes($this->lang->line('shop_nostoresavail')); } else echo "No stores available"; ?></p>
                <?php 
                }
                ?>                   
                         
                <div class="clear"></div>
            </div>
            
        </div>
    </div>
    <div class="clear"></div>
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