<?php 
$this->load->view('site/templates/header',$this->data);
$this->load->view('site/templates/popup_product_detail.php',$this->data);
?>  
   <!-- Section_start -->
        
    <div id="mid-panel">
        <div class="wrapper">
           
           <div class="present products-grid-title-container">
                <h1>
                    <span><?php if($this->lang->line('search_results_for') != '') { echo stripslashes($this->lang->line('search_results_for')); } else echo "Search results for"; ?></span>
                    <span class="search-keywords">
                    "<?php echo $this->input->get('q');?>"
                    </span>
                </h1>
            </div>
           <div class="clear"></div>
                
            <div class="trending">
                <div class="trending_lft">
                    <ul class="tabs">
                        <li><a class="find_btn" href="shopby/all?q=<?php echo $this->input->get('q');?>"><span><?php echo count($productList).' ';?></span><?php if($this->lang->line('templates_products') != '') { echo stripslashes($this->lang->line('templates_products')); } else echo "Products"; ?></a></li>
                            
                        <li class="active"><a class="find_btn active" href="javascript:void();"><span><?php if ($user_list){echo $user_list->num_rows().' ';}else {echo '0 ';}?></span><?php if($this->lang->line('onboarding_people') != '') { echo stripslashes($this->lang->line('onboarding_people')); } else echo "People"; ?></a></li>
                        
                        <li><a class="find_btn" href="search-stores?q=<?php echo $this->input->get('q');?>"><span><?php if ($sellers_list){echo $sellers_list->num_rows().' ';}else {echo '0 ';}?></span><?php if($this->lang->line('stores') != '') { echo stripslashes($this->lang->line('stores')); } else echo "Stores"; ?></a></li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
            
            
            
            
            <div class="brand_product panes">
                <div class="clear"></div>
            </div>
            
            <div class="trading_people panes odd" style="display:block;">
                
<?php 
if ($user_list!='' && $user_list->num_rows()>0){
    foreach ($user_list->result() as $store_list){
        $userImg = 'default_user.jpg';
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
                        
                        <a href="user/<?php echo $store_list->user_name;?>">
                        <span class="follow_icon">
                        <img src="images/users/<?php echo $userImg;?>" alt="">
                        </span>
                        </a>
                        <a href="user/<?php echo $store_list->user_name;?>"><h2><?php echo $store_name;?></h2></a>
                        <span><?php echo $store_list->followers_count;?> <?php if($this->lang->line('display_followers') != '') { echo stripslashes($this->lang->line('display_followers')); } else echo "Followers"; ?></span>
                        
                        <a class="<?php echo $followClass.' '; if ($loginCheck==''){echo 'sign_box';}?>" <?php if ($loginCheck != ''){?>data-uid="<?php echo $store_list->id;?>" onclick="javascript:store_follow(this);"<?php }?> ><?php echo $followText;?></a>
                    </div>
                    <div class="box_body">
                        <div class="brand_product trading_product">
                            <ul>
                                <?php 
                                  if (count($prodDetails[$store_list->id])>0){
                                      $limitCount = 0;
                                      foreach ($prodDetails[$store_list->id] as $store_products){
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
                                        if (isset($store_products->web_link)){
                                            $userName = $store_products->user_name?$store_products->user_name:"administrator";
                                            $fullName = $store_products->full_name?$store_products->full_name:"administrator";
                                            $prod_link = 'user/'.$userName.'/things/'.$store_products->seller_product_id.'/'.url_title($store_products->product_name,'-');
                                        }else {
                                            $prod_link = 'things/'.$store_products->id.'/'.url_title($store_products->product_name,'-');
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
                                            <a href="user/<?php echo $userName;?>/things/<?php echo $store_products->seller_product_id;?>/<?php echo url_title($store_products->product_name,'-');?>"><h3><span>&#8377;</span> <?php echo $store_products->price ?></h3></a>
                                            <h4><a href="user/<?php echo $userName;?>/things/<?php echo $store_products->seller_product_id;?>/<?php echo url_title($store_products->product_name,'-');?>"><?php echo $store_products->product_name ?></a> </h4>
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
                                     <!-- <img src="images/product/thumb/<?php echo $prodImg;?>" alt="">  -->
                                      
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
                
           <?php } 
            }else { 
            ?>
                  <p><?php if($this->lang->line('shop_nostoresavail') != '') { echo stripslashes($this->lang->line('shop_nostoresavail')); } else echo "No Stores available"; ?></p>
            <?php 
            }
            ?>                     
                <div class="clear"></div>
            </div>
            
            <div class="brand_product panes">
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    

        
        
   <!-- Section_end -->
<?php 
$this->load->view('site/templates/footer',$this->data);
?>
