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
                    
                        <li><a class="find_btn" href="search-people?q=<?php echo $this->input->get('q');?>"><span><?php if ($user_list){echo $user_list->num_rows().' ';}else {echo '0 ';}?></span><?php if($this->lang->line('onboarding_people') != '') { echo stripslashes($this->lang->line('onboarding_people')); } else echo "People"; ?></a></li>
                        
                        <li class="active"><a class="find_btn active" href="javascript:void(0);"><span><?php if ($sellers_list){echo $sellers_list->num_rows().' ';}else {echo '0 ';}?></span><?php if($this->lang->line('stores') != '') { echo stripslashes($this->lang->line('stores')); } else echo "Stores"; ?></a></li>
                            
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
            
            
            
            
            <div class="brand_product panes">
                <div class="clear"></div>
            </div>
            
            <div class="brand_product panes">
                <div class="clear"></div>
            </div>
            
            <div class="trading_people panes odd" style="display:block;">
<?php 
if ($sellers_list!='' && $sellers_list->num_rows()>0){
    foreach ($sellers_list->result() as $store_list){
        $store_name = $store_list->store_name;
        $followClass = 'follow_btn';
        $followText= stripslashes($this->lang->line('onboarding_follow'));
        if ($followText == ''){
            $followText = 'Follow';
        }
        if ($loginCheck != ''){
            $followingListArr = explode(',', $store_list->followers);
            if (in_array($loginCheck, $followingListArr)){
                $followClass = 'following_btn';
                $followText= stripslashes($this->lang->line('display_following'));
                if ($followText == ''){
                    $followText = 'Following';
                }
            }
        }
        
        $storeImg = 'dummy_store_logo.png';
        if ($store_list->store_logo != ''){
            $storeImg = $store_list->store_logo;
        }
?>                        

                <div class="box">
                    <div class="box_head">
                        
                        <a href="store/<?php echo $store_list->store_url;?>">
                        <span class="follow_icon">
                        <img src="images/store/<?php echo $storeImg;?>" alt="">
                        </span>
                        </a>
                        <a href="store/<?php echo $store_list->store_url;?>"><h2><?php echo $store_name;?></h2></a>
                        <span><?php echo $store_list->followers_count;?> <?php if($this->lang->line('display_followers') != '') { echo stripslashes($this->lang->line('display_followers')); } else echo "Followers"; ?></span>
                        
                        <a class="<?php echo $followClass.' '; if ($loginCheck==''){echo 'sign_box';}?>" <?php if ($loginCheck != ''){?>data-uid="<?php echo $store_list->id;?>" onclick="javascript:follow_store(this);"<?php }?> ><?php echo $followText;?></a>
                    </div>
                    <div class="box_body">
                        <div class="brand_product trading_product">
                            <ul>
                              <?php 
                              if ($prodDetails[$store_list->id]!='' && $prodDetails[$store_list->id]->num_rows()>0){
                                  $limitCount = 0;
                                  foreach ($prodDetails[$store_list->id]->result() as $store_products){
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
                                    
                                    $prod_uname = $store_products->user_name;
                                    if ($prod_uname=='') $prod_uname='anonymous';
                                        
                                    if (isset($store_products->web_link)){
                                        $prod_link = 'user/'.$prod_uname.'/things/'.$store_products->seller_product_id.'/'.url_title($store_products->product_name,'-');
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
                                            <a href="user/<?php echo $prod_uname;?>/things/<?php echo $store_products->seller_product_id;?>/<?php echo url_title($store_products->product_name,'-');?>"><h3><span>&#8377;</span> <?php echo $store_products->price ?></h3></a>
                                            <h4><a href="user/<?php echo $prod_uname;?>/things/<?php echo $store_products->seller_product_id;?>/<?php echo url_title($store_products->product_name,'-');?>"><?php echo $store_products->product_name ?></a> </h4>
                                        </div>
                                    </div>    
                                    <div class="article2">
                                        <span><a href="user/<?php echo $prod_uname; ?>">By <?php echo $prod_uname; ?></a></span>
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
