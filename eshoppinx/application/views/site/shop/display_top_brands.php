<?php 
$this->load->view('site/templates/header',$this->data);
?> 

  <!-- Section_start -->
    <div id="mid-panel">
        <div class="wrapper">
            <div class="trading_people">
<?php 
if (count($topStores)>0 && $topStores['brand_lists']->num_rows()>0){
    foreach ($topStores['brand_lists']->result() as $brand_list){
        /*$userImg = 'default_user.jpg';
        if ($brand_list->thumbnail != ''){
            if (file_exists('images/users/'.$brand_list->thumbnail)){
                $userImg = $brand_list->thumbnail;
            }
        }*/
        
        $storeImg = 'dummy_store_logo.png';
        if ($brand_list->brand_logo != ''){
            $storeImg = $brand_list->brand_logo;
        }
        $store_name = $brand_list->brand_name;
       //if ($store_name == '')$store_name = $brand_list->user_name;
        $followClass = 'follow_btn';
        $followText= stripslashes($this->lang->line('onboarding_follow'));
        if ($followText == ''){
            $followText = 'Follow';
        }
        if ($loginCheck != ''){
            $followingListArr = explode(',', $brand_list->followers);
            if (in_array($loginCheck, $followingListArr)){
                $followClass = 'following_btn';
                $followText= stripslashes($this->lang->line('display_following'));
                if ($followText == ''){
                    $followText = 'Following';
                }
            }
        }
        
        if ($topStores['prodDetails'][$brand_list->i_id] != '' && $topStores['prodDetails'][$brand_list->i_id]->num_rows()>0){
?>                          

                <div class="box">
                    <div class="box_head">
                        <a href="brand/<?php echo $brand_list->brand_url;?>"><span class="follow_icon"><img src="images/brand/<?php echo $storeImg;?>" /></span></a>
                        <a href="brand/<?php echo $brand_list->brand_url;?>"><h2><?php echo $store_name;?></h2></a>
                        <span class="follow_count"><?php echo $brand_list->followers_count;?> <?php if($this->lang->line('display_followers') != '') { echo stripslashes($this->lang->line('display_followers')); } else echo "Followers"; ?></span>
                        <!--<a class="follow" href="#">Follow</a>-->
                        <a class="<?php echo $followClass.' '; if ($loginCheck==''){echo 'sign_box';}?>" <?php if ($loginCheck != ''){?>data-uid="<?php echo $brand_list->i_id;?>" onclick="javascript:follow_brand(this);"<?php }?> ><?php echo $followText;?></a>
                        
                    </div>
                    <div class="box_body">
                        <div class="brand_product trading_product">
                            <ul>
                                <?php 
                                if ($topStores['prodDetails'][$brand_list->i_id] != '' && $topStores['prodDetails'][$brand_list->i_id]->num_rows()>0){
                                  $limitCount = 0;
                                  foreach ($topStores['prodDetails'][$brand_list->i_id]->result() as $store_products){
                                    if ($limitCount==3)break;$limitCount++;
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
                                    if (isset($store_products->web_link)){
                                        $prod_uname = $store_products->user_name;
                                        if ($prod_uname=='') $prod_uname='anonymous';
                                        $prod_link = 'user/'.$prod_uname.'/things/'.$store_products->seller_product_id.'/'.str_replace(' ','-',$store_products->product_name);
                                    }else {
                                        $prod_link = 'things/'.$store_products->id.'/'.str_replace(' ','-',$store_products->product_name);
                                    }
                                    /*echo '<pre>';
                                    print_r($store_products);*/
                                ?>                                
                                
                                <li>
                                    <div class="main-box2">
                                        <!--<img src="images/product/thumb/<?php echo $prodImg;?>" alt="">  -->
                                        <div class="brandPic">
                                            <table  cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td valign="middle" align="center">
                                                        <!--<img src="images/product/thumb/<?php echo $prodImg;?>" alt="">-->
                                                        <img src="images/product/thumb/<?php echo $prodImg;?>" alt="">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="overlay">
                                            <a href="<?php echo $prod_link;?>"><h3><span>&#8377;</span> <?php echo $store_products->price; ?></h3></a>
                                            <h4><a href="<?php echo $prod_link;?>"><?php echo $store_products->product_name; ?></a> </h4>
                                        </div>
                                    </div>    
                                    <div class="article2">
                                        <span><a href="user/<?php echo $prod_uname; ?>">By <?php echo $prod_uname; ?></a></span>
                                        <!--<div class="brand"><a href="javascript:">Arrow</a></div>-->
                                    </div>
                                </li>
                                
                                
                                <?php 
                                      }
                                  }
                                  ?>                 
                            </ul>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                          

<?php } }
}else {
?>     
<p><?php if($this->lang->line('shop_nostoresavail') != '') { echo stripslashes($this->lang->line('shop_nostoresavail')); } else echo "No Stores available"; ?></p>
<?php 
}
?> 
                <div class="clear"></div>
            </div>
        </div>
    </div>
        
    <div class="clear"></div> 
   <!-- Section_end -->
<?php 
$this->load->view('site/templates/footer',$this->data);
?>   
