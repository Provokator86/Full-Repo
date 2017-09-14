<?php 
if (count($products_list) > 0){
?>
    <div id="owl-demo"> 
        
        <?php 
        foreach ($products_list as $products_list_row){
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
                /*$userName = $products_list_row->user_name;
                $fullName = character_limiter($products_list_row->full_name,20);*/
                $userName = $products_list_row->user_name?$products_list_row->user_name:$userName;
                $fullName = $products_list_row->full_name?character_limiter($products_list_row->full_name,20):$fullName;
        
                if (strlen($fullName)>20){
                    $fullName = substr($fullName, 0,20).'..';    
                }
            }
            if ($fullName == ''){
                $fullName = $userName;
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
        <div class="main-box">
            <div class="article-square item-rec">
              <a href="<?php echo $prod_link;?>"><h3><span>&#8377;</span> <?php echo $products_list_row->price;?></h3></a>
              <h4><a href="<?php echo $prod_link;?>"><?php echo $products_list_row->product_name;?></a></h4>
              
              <a href="<?php echo $prod_link;?>" class="cover"><!--  --></a>
              <img src="images/product/thumb/<?php echo $prodImg;?>" alt="" style="left:0px;" />
            </div>
            
            <div class="article">
                <span><a href="user/<?php echo $userName;?>">By <?php echo $fullName;?></a></span>
                <div class="brand"><a href="javascript:">Arrow</a></div>
            </div>
        </div>
         <?php 
            }
         ?>               
    </div>
    
    
<?php 
}else {
?> 
<h3><?php if($this->lang->line('product_noavail') != '') { echo stripslashes($this->lang->line('product_noavail')); } else echo "No products available"; ?></h3>
<div class="clear"></div>
<?php 
}
?>  