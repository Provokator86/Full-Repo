<div class="feature_store similar_store">
    <h2>Similar<span>Stores</span></h2>
    <ul>
        <?php 
            if(!empty($active_store))
            {
                foreach($active_store as $key=>$val)
                {
        ?>
        <li><a href="<?php echo base_url().$val['s_url']?>-coupons" onMouseOver="opentt('<?php echo $val['i_id']?>');" onMouseOut="closett('<?php echo $val['i_id']?>');"><img class="border1px" src="<?php echo $store_image_path.$val['s_store_logo'];?>"></a>
            <div id="<?php echo $val['i_id']?>" class="tooltip" style=" display:none;">
                <div class="tooltip1">&nbsp;</div>
                <div class="tooltip2">
                    <?php echo my_showtext($val['s_store_title'])?>
                </div>
                <div class="tooltip3">&nbsp;</div>
            </div>
        </li>
        <?php
                }
            }
        else
		{
			echo "<b>No similar store found</b>";
		}    
		
        ?>
        <div class="clear"></div>
        
    </ul>
    <a href="<?php echo base_url().'store';?>" class="view_all" style="">View all stores</a>
</div>