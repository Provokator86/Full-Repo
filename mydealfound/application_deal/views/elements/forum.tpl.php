<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="clear"></div>
<div class="right_pan3">
    <div>
        <div class="prodct_heading_rght">Latest from the Forums</div>
<?php $feedData = forum_feeds();?>

<?php foreach($feedData as $feedMeta):?>

        <div class="right_product_box">
         <div class="right_product_details">
                 <div class="right_product"><img src="<?=base_url()?>images/forum.jpg" alt="" /></div>
                         <div class="right_product_info"><a href="<?=$feedMeta['link'];?>"><?=html_entity_decode($feedMeta['title']);?><br/><?=$feedMeta['content'];?></a></div>
         <div class="clear"></div>
         </div>
         <div class="clear"></div>
    </div>
<?php endforeach;?>
    </div>
</div>
<div class="clear"></div>