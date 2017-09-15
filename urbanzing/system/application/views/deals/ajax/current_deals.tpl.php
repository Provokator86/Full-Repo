<!--Deal Box Start-->

<?php
    foreach($current_deals as $deals_list):
        $details_url = base_url().'view_deals/details/'.$deals_list['id'];
        //pr($deals_list);
        $start_date_str = date('M d, Y', $deals_list['deal_start']);
        $end_date_str = date('M d, Y', $deals_list['deal_end']);
        $image_url = (!isset($deals_list['small_image_url']))?prep_url($deals_list['small_image_url']):base_url().'images/front/no_image_small.jpg';
?>
<div class="deal_box" <?php echo ($row_index&1)?'style="background: none repeat scroll 0% 0% rgb(243, 243, 243);"':'' ?> >
    <div class="cell_01">
    <a href="<?php echo $details_url ?>">
        <img alt="" src="<?php echo $image_url ?>" /></a>
    </div>
    <div class="cell_02">
    <h5><a href="<?php echo $details_url ?>">
        <?php echo isset($deals_list['headline'])?$deals_list['headline']:'';?>
    </a></h5>
    <h6>
        <?php echo isset($deals_list['street_address'])?$deals_list['street_address'].'-':'';?> 
        <?php echo isset($deals_list['city'])?$deals_list['city'].'-':'';?>  
        <?php echo isset($deals_list['state'])?$deals_list['state']:'';?>
    </h6>
    <h6><span>Source: <?php echo isset($deals_list['source_name'])?$deals_list['source_name']:'';?></span></h6>
    <h6><?php echo $start_date_str?> - <?php echo $start_date_str?></h6>
    <p><?php echo isset($deals_list['deal_description'])?word_limiter(html_entity_decode($deals_list['deal_description']), 20):'';?></p>
    </div>
    <div class="cell_03">
    <?php
        // Price calculation ............[start]
        $offer_price = number_format($deals_list['offer_price'],2);
        $actual_price = number_format($deals_list['actual_price'],2);
        $save_prc = number_format(($deals_list['actual_price'] - $deals_list['offer_price']), 2);
        $save_prcnt = number_format($save_prc/$deals_list['actual_price']*100,0);
        // Price calculation ............[end]
    ?>
    <label>Value : <span><img src="<?php  echo base_url()?>images/front/rs.png" alt="" style="vertical-align: middle;" /> <?php echo $actual_price?></span></label>
    <br />
    <label>Discount : <span style="font-weight: bold;"><?php echo $save_prcnt; ?> %</span></label>
    <br />
    <label>Your Price : <span><img src="<?php  echo base_url()?>images/front/rs.png" alt="" style="vertical-align: middle;" /> <?php echo $offer_price?></span></label>
    <br>
    <div class="button_box">
    <div class="left_part"><input type="button" onclick="window.open('<?php echo prep_url($deals_list['external_site_link']) ?>')" value="Buy now"></div>
    <div class="right_part" style="font-size: smaller;"><?php echo isset($deals_list['offer_price'])?intval($deals_list['offer_price']):'';?></div>
    <br>
    </div>
    </div>
    <br>
</div>
<?php
    $row_index++;
    endforeach;
?>
<!--Deal Box End-->
<div class="clear"></div>
<!--Deal paginition Start-->
<?php
    if(!empty($page_links)): 
?>
    <div class="paging" style="font-size: 12px;">
    <?php echo $page_links; ?>
    </div>
<?php
    endif;
?>
<div class="clear"></div>
<!--Deal paginition End-->
