<div class="feature_deal">
<h1>
<span onclick="window.location='<?php echo prep_url($deal_details['external_site_link']) ?>'" style="cursor: pointer;">
<?php echo $deal_details['headline']; /* ?>Today's deal<?php */ ?> </span>
<div class="back_btn"><a href="<?php echo base_url()?>view_deals/">Back</a></div></h1>
<?php /*
<h2 style="font-size: 19.4px;"><?php echo $deal_details['headline']; ?></h2>
*/ ?>
<div class="margin10"></div>
<div class="deal_details">
<div class="details_left">
<div class="btn_box" id="buy_now_div">

<?php 
// Price calculation ............[start]
$offer_price = intval($deal_details['offer_price']);
$actual_price = intval($deal_details['actual_price']);
$save_prc = $deal_details['actual_price'] - $deal_details['offer_price'];
$save_prcnt = $save_prc/$deal_details['actual_price']*100;
// Price calculation ............[end]
?>

<div class="btn_left">
    <?php echo $offer_price;?>
</div>
<div class="btn_right" style="cursor: pointer;" onclick="window.open('<?php echo prep_url($deal_details['external_site_link']) ?>')"><input type="button" value="Buy now"></div>
<br>
</div>
<div class="value_box">
<div class="box_01" style="text-align: center;">
    <h3>Value <br> 
        <span>
            <img src="<?php  echo base_url()?>images/front/rs.png" alt="" style="vertical-align: middle;" /> 
            <?php echo number_format($actual_price, 2);?>
        </span>
    </h3>
</div>
<div class="box_02" style="text-align: center;">
    <h3>Discount <br> 
        <span>
            <?php echo number_format($save_prcnt,0);?>%
        </span>
    </h3>
</div>
<div class="box_02" style="text-align: center;">
    <h3>You save <br> 
        <span>
            <img src="<?php  echo base_url()?>images/front/rs.png" alt="" style="vertical-align: middle;" /> 
            <?php echo number_format($save_prc, 2);?>
        </span>
    </h3>
</div>
<br>
</div>
<?php
  $end_date_time = date('m/d/Y H:i', $deal_details['deal_end'])
?>

<div class="time_to_buy">
<h4>Time Left To Buy</h4>
<h3 id="show_clock"><div id="clock1">[clock1]</div>
<script type="text/javascript">
StartCountDown("clock1","<?php echo $end_date_time; ?>");
</script>
</h3>
</div>

<div class="margin10"></div>
<?php if(!empty($deal_details['source_name'])): ?>
<h5>Source : <span><?php echo $deal_details['source_name']; ?></span></h5>
<?php endif;?>
<h5>Category : <span><?php echo $deal_details['category']; ?></span> </h5>

</div>
<div class="details_right">
<img alt="" src="<?php echo (!empty($deal_details['big_image_url']))?$deal_details['big_image_url']:base_url().'images/front/no_image.jpg'?>">
<br>
<div class="pub_details">
<div class="left_section">
<?php
    if($deal_details['type']):
?>
<h4>
<a href="<?php echo prep_url($deal_details['website_url']); ?>" target="_blank"><?php echo $deal_details['website_url']; ?></a></h4>
<?php
    else:
    
    // ADDRESS MAKING
    $address = '';
    $address = (isset($deal_details['street_address']))?$deal_details['street_address'].'<br />':'';
    $address .= (isset($deal_details['city']))?$deal_details['city'].'<br />':'';
    $address .= (isset($deal_details['state']))?$deal_details['state'].', ':'';
    $address .= (isset($deal_details['country']))?$deal_details['country']:'';
?>
<p><strong>Address:</strong><?php echo $address; ?></p>
<?php 
endif;
if(isset($deal_details['phone'])):
?>
<p><strong>Phone:</strong>  <?php echo $deal_details['phone']?></p>
<?php
    endif;
    
    $facebook_url = urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    
?>

<div class="flike">
<a href="http://facebook.com/share.php?u=<?=$facebook_url?>"  target="_blank" style="text-decoration: none;"><img src="<?=base_url()?>images/front/face_book_icon.png" alt="" /> Share</a>
</div>
<div class="margin10"></div>
</div>
<div class="right_section">
<?php
    if(!$deal_details['type']):
?>
<a onclick="tb_show('Location','<?=base_url()?>ajax_controller/ajax_show_map/deals/<?=$deal_details['id']?>?height=250&width=400&KeepThis=true&TB_iframe=true');" href="javascript:void(0)" class="map_link" style="float: right;"><img align="absmiddle" alt="" src="<?php echo base_url()?>images/front/map_icon.png">&nbsp;View map</a>
<?php
    endif;
?>
<br>
<div class="flike" style="word-wrap:wrap-word; width: 200px;">
<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo $facebook_url; ?>&amp;layout=standard&amp;show_faces=true&amp;width=450&amp;action=like&amp;show_faces=false&amp;colorscheme=light&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:40px;" allowTransparency="true"></iframe>


</div>
</div>
<br>
</div>
</div>
<br>
</div>
<h2>Description</h2>
<p><?php echo html_entity_decode($deal_details['deal_description']); ?></p>
<?php
if(!empty($deal_details['fine_prints'])):
?>
<h2>The Fine Print</h2>
<p><?php echo html_entity_decode($deal_details['fine_prints']); ?></p>
<?php
    endif;
?>
</div>                             

<script type="text/javascript">
<!--
var dialog = null;

function show_dialog (id)
{
    if(!dialog) dialog = null;
    dialog = new ModalDialog ("#"+id);
    dialog.show();
}

function hide_dialog ()
{
    dialog.hide();
    if(!dialog) dialog = null;
}
function hide_dialog1 ()
{
    dialog.hide();
    if(!dialog) dialog = null;
    window.location.reload(true);
}
//-->
</script>

<div id="view-map" class="view_map_box">
<a href="#" onclick="hide_dialog()" style="color:#0000FF">x</a>
<img src="<?php echo base_url()?>images/front/map_img.jpg" />
</div>

<div id="view_error" class="view_map_box">
<a href="#" onclick="hide_dialog1()" style="color:#0000FF">X</a>
<div style="height:10px;"></div>
<div style="text-align: center;">
It seems that your connection with server has been lost...
please reload the page...
</div>
</div>

<script type="text/javascript">
function callAjaxEndTime(id)
{
    $.ajax({
        url:"<?php echo base_url() ?>view_deals/getEndTimeAJAX/<?php echo $deal_details['id']; ?>",
        type:"GET",
        dataType:"json",
        success:function(msg)
        {
            StartCountDown("clock1",msg.deal_end_time);
        },
        error:function()
        {
            //alert('ok');
            show_dialog("view_error");
        }
    });
}
setInterval('callAjaxEndTime()', 10000);
</script>