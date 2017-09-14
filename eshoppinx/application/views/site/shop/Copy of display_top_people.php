<?php 
$this->load->view('site/templates/header',$this->data);
?> 
  <!-- Section_start -->    
    <div id="mid-panel">
        <div class="wrapper">
            <div class="trading_people">
            <?php 
            if (count($topPeople)>0 && $topPeople['store_lists']->num_rows()>0){
                foreach ($topPeople['store_lists']->result() as $store_list){
                    $userImg = 'default_user.jpg';
                    /*echo '<pre>';
                    print_r($store_list);*/
                    if ($store_list->thumbnail != ''){
                        if (file_exists('images/users/'.$store_list->thumbnail)){
                            $userImg = $store_list->thumbnail;
                        }
                    }
                    $store_name = $store_list->full_name;
                    if ($store_name == '')$store_name = $store_list->user_name;
                    $followClass = 'follow_btn';
                    $followText  = 'Follow';
                    if ($loginCheck != ''){
                        $followingListArr = explode(',', $userDetails->row()->following);
                        if (in_array($store_list->id, $followingListArr)){
                            $followClass = 'following_btn';
                            $followText = 'Following';
                        }
                    } 
            ?> 
                <div class="box">
                    <div class="box_head">
                        
                        <a href="user/<?php echo $store_list->user_name;?>"><span class="follow_icon"><img src="images/users/<?php echo $userImg;?>" alt=""></span></a>
                        <a href="user/<?php echo $store_list->user_name;?>"><h2><?php echo $store_name;?></h2></a>
                        <span><?php echo $store_list->followers_count;?> <?php if($this->lang->line('display_followers') != '') { echo stripslashes($this->lang->line('display_followers')); } else echo "Followers"; ?></span>
                        <!--<a href="#" class="follow">Follow</a>-->
                        <a class="<?php echo $followClass.' '; if ($loginCheck==''){echo 'sign_box';}?>" <?php if ($loginCheck != ''){?>data-uid="<?php echo $store_list->id;?>" onclick="javascript:store_follow(this);"<?php }?> ><?php echo $followText;?></a>
                    </div>
                    <div class="box_body">
                        <div class="brand_product trading_product">
                            <ul>
                                <?php 
                                  if ($topPeople['prodDetails'][$store_list->id]->num_rows()>0){
                                      $limitCount = 0;
                                      foreach ($topPeople['prodDetails'][$store_list->id]->result() as $store_products){
                                        if ($limitCount==3)break;$limitCount++;
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
                                        $product_name = $store_products->product_name;
                                        /*echo '<pre>';
                                        print_r($store_products);*/
                                  ?>
                                  <li>
                                    <img src="images/product/thumb/<?php echo $prodImg;?>" alt="">
                                    <div class="overlay">
                                        <a href="user/<?php echo $store_list->user_name;?>/things/<?php echo $store_products->seller_product_id;?>/<?php echo url_title($store_products->product_name,'-');?>"><h3><span>&#8377;</span> 499</h3></a>
                                        <h4><a href="user/<?php echo $store_list->user_name;?>/things/<?php echo $store_products->seller_product_id;?>/<?php echo url_title($store_products->product_name,'-');?>"><?php echo $product_name ?></a> <span><a href="user/<?php echo $store_list->user_name;?>">By <?php echo $store_name;?></a></span> </h4>
          <span class="brand"><a href="javascript:">Arrow</a></span>
                                        <!--<div class="butn-overlay"> SAVE <span>743  saves</span></div>-->
                                        <div class="butn-overlay save <?php if ($loginCheck==''){echo 'sign_box';}?>" data-pid="<?php echo $store_products->seller_product_id;?>">
                                                      
                                              <strong><?php if($this->lang->line('header_save') != '') { echo stripslashes($this->lang->line('header_save')); } else echo "Save"; ?></strong>
                                                
                                                <span><?php echo $store_products->likes;?> <?php if($this->lang->line('product_saves') != '') { echo stripslashes($this->lang->line('product_saves')); } else echo "saves"; ?></span>                          
                                          </div>
                                    </div>
                                </li>
                                
                                <li>
                                    <img src="images/product/thumb/<?php echo $prodImg;?>" alt="">
                                    <div class="overlay">
                                        <a href="user/<?php echo $store_list->user_name;?>/things/<?php echo $store_products->seller_product_id;?>/<?php echo url_title($store_products->product_name,'-');?>"><h3><span>&#8377;</span> 499</h3></a>
                                        <h4><a href="user/<?php echo $store_list->user_name;?>/things/<?php echo $store_products->seller_product_id;?>/<?php echo url_title($store_products->product_name,'-');?>"><?php echo $product_name ?></a> <span><a href="user/<?php echo $store_list->user_name;?>">By <?php echo $store_name;?></a></span> </h4>
                                    </div>
                                    <span class="brand"><a href="javascript:">Arrow</a></span>
                                </li>
                                
                                  <?php 
                                      }
                                  } else {
                                  ?>     
                                  <li>
                                  <img src="images/product/thumb/<?php echo $prodImg;?>" alt="">
                                  </li>
                                  <?php } ?>             
                                
                            </ul>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                
           <?php } 
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