<div class="nav-2">
  <div class="nav-wrapper">
      <div class="navigation2">
      <?php if(!empty($MainCategoryList)){ ?>
        <ul>
            <?php 
            foreach($MainCategoryList as $cat_val){ 
                $cls = ($parent_cat_url==$cat_val["seourl"])?"active":"";
            ?>
            <li><a class="<?php echo $cls ?>" href="<?php echo base_url('category').'/'.$cat_val["seourl"] ?>"><?php echo $cat_val["cat_name"] ?></a></li>
            <?php } ?>
          <!--<li><a href="javascript:">Christmas</a></li>
          <li><a href="javascript:">Halloween</a></li>
          <li><a href="javascript:">Gifts</a></li>
          <li><a href="javascript:">Home &nbsp; Lifestyle</a></li>
          <li><a href="javascript:">Food &nbsp; Drink</a></li>
          <li><a href="javascript:">Gadgets</a></li>
          <li><a href="javascript:">Men</a></li>
          <li><a href="javascript:">Women</a></li>
          <li><a href="javascript:">Toys &nbsp; Games</a></li>
          <li><a href="javascript:">Books</a></li>
          <li><a href="javascript:">Last Chance</a></li>-->
        </ul>
        <?php } ?>
    </div>
  </div>
</div>