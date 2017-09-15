<div class="feature_deal" >
<h1  style="border-bottom-width: 0px;">deals</h1>

<div id="examplePanel1" class="deal_body" >
<!--Deal search Box Start-->
<form action="" method="post" id="srch_deal_frm">
<div class="searching_box">
<label>Keyword</label> 
<input type="text" id="srch_keyword" name="keyword" value="<?php echo $search['keyword'] ?>"> 
<label>Category</label> 
<select name="category" id="category">
<option value="">Select Category</option>
<?php echo $deals_category_name; ?>
</select>
<div class="clear"></div>
<label>Location</label> 
<select name="location" id="location">
<option value="">Select Location</option>
<?php echo $deals_location_name; ?>
</select> 
<label>Type</label> 
<select name="type">
<option value="">Select Type</option>
<option value="1" <?php echo ($search['type']==1)?'selected="selected"':'' ?> >Online</option>
<option value="2" <?php echo ($search['type']==2)?'selected="selected"':'' ?> >Offline</option>
</select> 
<div class="clear"></div>
<div class="margin10"></div>
<input type="hidden" name="hdn_srch" value="srch"> 

<input type="submit" class="button_01" value="SEARCH" style="margin-right: 12px; float: right;">
<input type="button" class="button_03" value="CLEAR SEARCH" style="margin-right: 12px; float: right;" onclick="clr_select()">
<div class="clear"></div>
</div>
</form>
<!--Deal search Box End-->
<script type="text/javascript">
function clr_select()
{
    //$('#srch_keyword').val('');
    //$('#srch_deal_frm select option').removeAttr('selected');
    window.location.href = '<?php echo base_url()?>view_deals';
}
</script>



<div style="text-align: center; height: 15px; padding-top: 8px; "  id="show_loader"></div>

<div id="deals_listing">
<?php
    if($current_deals_count>0):
    $row_index = 0;
?>
<!--Deal Box Start-->
<?php
    foreach($current_deals as $deals_list):
        $details_url = base_url().'view_deals/details/'.$deals_list['id'];
        //pr($deals_list);
        $start_date_str = date('M d, Y', $deals_list['deal_start']);
        $end_date_str = date('M d, Y', $deals_list['deal_end']);
        //$image_url = (!isset($deals_list['small_image_url']))?prep_url($deals_list['small_image_url']):base_url().'images/front/no_image_small.jpg';
        $image_url = (!empty($deals_list['small_image_url']))?$deals_list['small_image_url']:base_url().'images/front/no_image_small.jpg';
?>
<div class="deal_box" <?php echo ($row_index&1)?'style="background: none repeat scroll 0% 0% rgb(243, 243, 243);"':'' ?> >
    <div class="cell_01">
    <a href="<?php echo $details_url ?>">
    <div style="overflow: hidden; height: 77px; width: 77px;" >
        <img alt="" src="<?php echo $image_url ?>" height="77" />
    </div>
    </a>
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
    <label>Value : <span> <img src="<?php  echo base_url()?>images/front/rs.png" alt="" style="vertical-align: middle;" /> <?php echo $actual_price?></span></label>
    <br />
    <label>Discount :<span style="font-weight: bold;"><?php echo $save_prcnt; ?> %</span></label>
    <br />
    <label>Your Price : <span><img src="<?php  echo base_url()?>images/front/rs.png" alt="" style="vertical-align: middle;" /> <?php echo $offer_price?></span></label>
    <br>
    <div class="button_box">
    <div class="left_part" onclick="window.open('<?php echo prep_url($deals_list['external_site_link']) ?>')"><input type="button" value="Buy now"></div>
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
</div>

<?php
    else:
?>
</div>
    <div class="deal_box">
        <div style="font-weight: bold; height: 100px; text-align: center; line-height: 100px;">
            No new deals are there...
        </div>
    </div>
<?php
    endif;
?>

</div>
</div>

<script type="text/javascript">
function slideToggle(id,imgid) {    
    $('#'+imgid).html('');
    if($('#'+id).css('display') == "block") {        
        $('#'+imgid).html('<img align="absmiddle" src="<?php echo base_url()?>images/front/close_btn.png" />');
    } else {
        $('#'+imgid).html('<img align="absmiddle" src="<?php echo base_url()?>images/front/expand_btn.png" />');
    }
    $('#'+id).slideToggle();
}

function showBusyScreen(divId)
{
    //$('#'+divId).show();
    $('#'+divId).html('<img src="' + base_url + 'images/front/ajax-loader.gif" alt=""/>');
}
function hideBusyScreen(divId)
{
    //$('#'+divId).hide();
    $('#'+divId).html('');
}
</script>
