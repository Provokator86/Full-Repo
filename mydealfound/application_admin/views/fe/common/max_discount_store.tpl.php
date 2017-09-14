<div class="max_dis">
<h2>Maximum <span>Discount Store </span></h2>
    <ul>
        <?php if($store_discount)
		{
            foreach($store_discount as $key=>$val)
            {
        ?>
        <li><a href="<?php echo base_url()?><?php echo $val['s_url']?>-coupons"><?php echo my_showtext($val['s_store_title']);?></a></li>
        <?php
            }
		}
        ?>
        </ul>
    
</div>