<div class="clear"></div>
<div class="sub-catog">
    <!--<h1>Clothing &amp; Accessories</h1>-->
    <h1><?php echo $categotyDetail->row()->cat_name; ?></h1>
    <?php if(!empty($sub_cat)){ ?>
    <ul>
        <li><h2>Sub Categories:</h2></li>
        <?php foreach($sub_cat as $sub_val) { ?>
        <li><a href="javascript:" rel="<?php echo $sub_val['seourl'] ?>" class="sub_cat" id="sub_cat_<?php echo $sub_val["id"] ?>"><?php echo $sub_val['cat_name'] ?></a></li>        
        <?php } ?>
        
        <!--<li><a href="#" class="active">All in Clothing &amp; Accessories</a></li>-->
        
    </ul>
    
<?php } ?>
</div>

<?php 

if (count($product_list) > 0 ){
?>

<div class="categories">
  <ul>
    <li>Price
        
        <ul class="select_drop">
            <li>
                <input type="checkbox" class="chck-all-price chk_box_price">
                <label class="text-chk-price">Select All</label>
            </li>
            <li class="blank">&nbsp;</li>
            <li class="chk_box_price">
                <input type="checkbox" name="prod_price[]" id="price_chk_0-100" value="0-100" class="checkbox chck-child-price">
                <label><span>&#8377;</span>0-<span>&#8377;</span>100</label>
            </li>
            
            <li class="chk_box_price">
                <input type="checkbox" name="prod_price[]" id="price_chk_101-500" value="101-500" class="checkbox chck-child-price">
                <label><span>&#8377;</span>101-<span>&#8377;</span>500</label>
            </li>
            
            <li class="chk_box_price">
                <input type="checkbox" name="prod_price[]" id="price_chk_501-1000" value="501-1000" class="checkbox chck-child-price">
                <label><span>&#8377;</span>501-<span>&#8377;</span>1000</label>
            </li>
            
            <li class="chk_box_price">
                <input type="checkbox" name="prod_price[]" id="price_chk_1001-2000" value="1001-2000" class="checkbox chck-child-price">
                <label><span>&#8377;</span>1001-<span>&#8377;</span>2000</label>
            </li>
            
            <li class="chk_box_price">
                <input type="checkbox" name="prod_price[]" id="price_chk_2001-5000" value="2001-5000" class="checkbox chck-child-price">
                <label><span>&#8377;</span>2001-<span>&#8377;</span>5000</label>
            </li>
            
            <li class="chk_box_price">
                <input type="checkbox" name="prod_price[]" id="price_chk_5001" value="5001" class="checkbox chck-child-price">
                <label>Above <span>&#8377;</span>5001</label>
            </li>
            
        </ul>
        
    </li>
    
    <?php /* ?>
    <li>Discount
        
        <ul class="select_drop">
            <li>
                <input type="checkbox" class="chck-all-discount">
                <label class="text-chk-discount">Select All</label>
            </li>
            <li class="blank">&nbsp;</li>
            <li>
                <input type="checkbox" class="checkbox chck-child-discount">
                <label>10%-50%</label>
            </li>
            <li>
                <input type="checkbox" class="checkbox chck-child-discount">
                <label>20%-50%</label>
            </li>
            <li>
                <input type="checkbox" class="checkbox chck-child-discount">
                <label>50%-80%</label>
            </li>
            <li>
                <input type="checkbox" class="checkbox chck-child-discount">
                <label>10%-25%</label>
            </li>
            <li>
                <input type="checkbox" class="checkbox chck-child-discount">
                <label>25%-35%</label>
            </li>
            <li>
                <input type="checkbox" class="checkbox chck-child-discount">
                <label>60%-80%</label>
            </li>
        </ul>
       
    </li>
    <?php */ ?>
    
    <?php if(!empty($allStores)){ ?>
    <li>Store
        
        <ul class="select_drop">
            <li>
                <input type="checkbox" class="chck-all-store chk_box_store">
                <label class="text-chk-store">Select All</label>
            </li>
            <li class="blank">&nbsp;</li>
            <?php foreach($allStores as $store_key=>$store_val){ ?>
            <li class="chk_box_store">
                <input type="checkbox" name="prod_store[]" id="store_chk_<?php echo $store_val->id ?>" value="<?php echo $store_val->id ?>" class="checkbox chck-child-store">
                <label><?php echo $store_val->store_name ?></label>
            </li>
            <?php } ?>            
        </ul>
        
    </li>
    <?php } ?>
    
    <?php if(!empty($allBrands)){ ?>
    <li>Brand
       
        <ul class="select_drop">
            <li>
                <input type="checkbox" class="chck-all-brand chk_box_brand">
                <label class="text-chk-brand">Select All</label>
            </li>
            <li class="blank">&nbsp;</li>
            <?php foreach($allBrands as $brand_key=>$brand_val){ ?>
            <li class="chk_box_brand">
                <input type="checkbox" name="prod_brand[]" id="brand_chk_<?php echo $brand_val["s_brand"] ?>" value="<?php echo $brand_val["s_brand"] ?>" class="checkbox chck-child-brand">
                <label><?php echo $brand_val["brand_name"] ?></label>
            </li>
            
            
            <?php } ?>
            <!--<li>
                <input type="checkbox" class="checkbox chck-child-brand">
                <label>Adidas</label>
            </li>
            <li>
                <input type="checkbox" class="checkbox chck-child-brand">
                <label>Park Avenue</label>
            </li>
            <li>
                <input type="checkbox" class="checkbox chck-child-brand">
                <label>Arrow</label>
            </li>
            <li>
                <input type="checkbox" class="checkbox chck-child-brand">
                <label>Allensolly</label>
            </li>
            <li>
                <input type="checkbox" class="checkbox chck-child-brand">
                <label>Russell</label>
            </li>
            <li>
                <input type="checkbox" class="checkbox chck-child-brand">
                <label>Holloway</label>
            </li>
            <li>
                <input type="checkbox" class="checkbox chck-child-brand">
                <label>POLO</label>
            </li>
            <li>
                <input type="checkbox" class="checkbox chck-child-brand">
                <label>GUESS</label>
            </li>
            <li>
                <input type="checkbox" class="checkbox chck-child-brand">
                <label>NextLevel</label>
            </li>
            <li>
                <input type="checkbox" class="checkbox chck-child-brand">
                <label>NIKE</label>
            </li>
            <li>
                <input type="checkbox" class="checkbox chck-child-brand">
                <label>Kati</label>
            </li>
            <li>
                <input type="checkbox" class="checkbox chck-child-brand">
                <label>VanHeusen</label>
            </li>
            <li>
                <input type="checkbox" class="checkbox chck-child-brand">
                <label>Soffe</label>
            </li>-->
        </ul>
        
        
    </li>
    <?php } ?>
    
  </ul>
  <div class="clear"></div>
</div>

<?php
}
?>


