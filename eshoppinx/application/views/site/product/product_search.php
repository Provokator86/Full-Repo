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
                        <li class="active"><a class="find_btn active" href="<?php echo base_url();?>shopby/all?q=<?php echo $this->input->get('q');?>"><span><?php echo count($productList).' ';?></span><?php if($this->lang->line('templates_products') != '') { echo stripslashes($this->lang->line('templates_products')); } else echo "Products"; ?></a></li>
                            
                        <li><a class="find_btn" href="search-people?q=<?php echo $this->input->get('q');?>"><span><?php if ($user_list){echo $user_list->num_rows().' ';}else {echo '0 ';}?></span><?php if($this->lang->line('onboarding_people') != '') { echo stripslashes($this->lang->line('onboarding_people')); } else echo "People"; ?></a></li>
                        
                        <li><a class="find_btn" href="search-stores?q=<?php echo $this->input->get('q');?>"><span><?php if ($sellers_list){echo $sellers_list->num_rows().' ';}else {echo '0 ';}?></span><?php if($this->lang->line('stores') != '') { echo stripslashes($this->lang->line('stores')); } else echo "Stores"; ?></a></li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
            
            
            
            <div class="brand_product panes odd" style="display:block;">
                <?php 
                if (count($productList) > 0){
                ?>
                <ul>
                <?php 
                foreach ($productList as $products_list_row){                            
                            
                    $prodImg = 'dummyProductImage.jpg';
                    $prodImgArr = array_filter(explode(',', $products_list_row->image));
                    if (count($prodImgArr)>0){
                        foreach ($prodImgArr as $prodImgArrRow){
                            if (file_exists('images/product/thumb/'.$prodImgArrRow)){
                                $prodImg = $prodImgArrRow;
                                break;    
                            }
                        }
                    }
                    $userName = 'administrator';
                    $fullName = 'administrator';
                    if ($products_list_row->user_id > 0){
                        $userName = $products_list_row->user_name;
                        if(!$userName) $userName = 'administrator';
                        $fullName = $products_list_row->full_name;
                        if(!$fullName) $fullName = $userName;
                    }
                    $userImg = 'default_user.jpg';
                    if ($products_list_row->thumbnail != ''){
                        $userImg = $products_list_row->thumbnail;
                    } 
                    if (isset($products_list_row->web_link)){
                        $prod_link = 'user/'.$userName.'/things/'.$products_list_row->seller_product_id.'/'.url_title($products_list_row->product_name,'-');
                    }else {
                        $prod_link = 'things/'.$products_list_row->id.'/'.url_title($products_list_row->product_name,'-');
                    }
                    ?>
                    <li>
                        <div class="main-box2">
                            <img src="images/product/thumb/<?php echo $prodImg;?>" alt="">
                            <div class="overlay">
                                <a href="<?php echo $prod_link;?>"><h3><span>&#8377;</span> <?php echo $products_list_row->price;?></h3></a>
                                <h4><a href="<?php echo $prod_link;?>"><?php echo $products_list_row->product_name;?></a> </h4> 
                            </div>
                        </div>
                        <div class="article2">
                            <h4><span><a href="user/<?php echo $userName;?>">By <?php echo $fullName;?></a></span>  </h4>
                              <span class="brand"><a href="javascript:">Arrow</a></span>
                        </div>
                    </li>
                    
                    
                    <?php } ?>
                </ul>
                <?php 
                }else {
               ?> 
                <h3><?php if($this->lang->line('product_noavail') != '') { echo stripslashes($this->lang->line('product_noavail')); } else echo "No products available"; ?></h3>
                <?php 
                }
                ?>                        
                <div class="clear"></div>
            </div>
            
            <div class="brand_product panes">
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
