<?php
#if(!empty($product_list)) {
if($product_list) {
?>

<?php 
if (count($product_list) > 0){
?>
<div class="product_box">

    <div id="owl-demo" class="test"> 
        
        <?php 
        foreach ($product_list as $products_list_row){
            $prodImg = 'dummyProductImage.jpg';
            $prodImgArr = array_filter(explode(',', $products_list_row["image"]));
            if (count($prodImgArr)>0){
                foreach ($prodImgArr as $prodImgArrRow){
                    if (file_exists('images/product/thumb/'.$prodImgArrRow)){
                        $prodImg = $prodImgArrRow;
                        break;    
                    }
                }
            }
            $userName = 'admin';
            $fullName = 'admin';
            if ($products_list_row["user_id"] > 0){
                /*$userName = $products_list_row->user_name;
                $fullName = character_limiter($products_list_row->full_name,20);*/
                $userName = $products_list_row['user_name']?$products_list_row['user_name']:$userName;
                $fullName = $products_list_row['full_name']?character_limiter($products_list_row['full_name'],20):$fullName;
        
                if (strlen($fullName)>20){
                    $fullName = substr($fullName, 0,20).'..';    
                }
            }
            if ($fullName == ''){
                $fullName = $userName;
            }
            $userImg = 'default_user.jpg';
            if ($products_list_row['thumbnail'] != ''){
                $userImg = $products_list_row['thumbnail'];
            } 
            if (isset($products_list_row['web_link'])){
                $prod_link = 'user/'.$userName.'/things/'.$products_list_row['seller_product_id'].'/'.url_title($products_list_row['product_name'],'-');
            }else {
                $prod_link = 'things/'.$products_list_row['id'].'/'.url_title($products_list_row['product_name'],'-');
            }
        ?>
        <div class="main-box">
            <div class="article-square item-rec">
              <a href="<?php echo $prod_link;?>"><h3><span>&#8377;</span> <?php echo $products_list_row['price'];?></h3></a>
              <h4><a href="<?php echo $prod_link;?>"><?php echo character_limiter($products_list_row['product_name'],40);?></a></h4>
              
              <a href="<?php echo $prod_link;?>" class="cover"><!--  --></a>
              <!--<img src="images/product/thumb/<?php echo $prodImg;?>" alt="" style="left:0px;" />-->
              <img src="images/product/thumb/<?php echo $prodImg;?>" alt="" style="left:0px;" />
            </div>
            
            <div class="article">
                <span><a href="user/<?php echo $userName;?>">By <?php echo character_limiter($fullName,7);?></a></span>
                <?php if($products_list_row['s_brand']!=''){ ?>
                <div class="brand"><a href="brand/<?php echo $products_list_row['brand_url'];?>"><?php echo character_limiter($products_list_row['s_brand'],10);?></a></div>
                <?php }else { ?>
                <div class="brand"><a href="javascript:"><?php echo 'N/A';?></a></div>
                <?php } ?>
            </div>
        </div>
         <?php 
            }
         ?>               
    </div>
    
</div>   
<?php 
}
?> 

<div id="page-nav-index" class="page-nav">
    <a href="<?php echo base_url() ?>category/<?php echo $category_id_src ?>/ajax_pagination_product_list/page/<?php echo $next_record_pointer ?>">&nbsp;</a>
</div>
<div class="clear"></div>

<?php
    } else {
?>
    <p>No product found.</p>
<?php } ?>

<input type="hidden" id="category_src" value="<?php echo $category_id_src ?>" />