<div class="p_rt_bxe">
    <div class="rate_rating_box">
        <div class="rating_logo"><img src="<?= base_url(); ?>uploaded/store/<?= $dealMeta['s_store_logo'] ?>" /></div>
        <div class="rating_logo_details">
            <div><?= $dealMeta['s_about_us'] ?></div>
            <div class="rte_btm">
                <div id="modal" style="display:none;">
                    <a class="close" onclick="hide_modal();">&times;</a>
                    <div id="content">
                        <div class="modal_wize">
                            <div class="shop_1_left rateit"   data-rateit-step="1" data-rateit-value="<?= $dealMeta['rateit_status']['average'] ?>" data-rateit-resetable="false" data-productid="<?= $dealMeta['i_id'] ?>">
                                <? /* <img src="<?= base_url(); ?>images/star.png" />
                                  <img src="<?= base_url(); ?>images/star.png" />
                                  <img src="<?= base_url(); ?>images/star.png" />
                                  <img src="<?= base_url(); ?>images/star.png" />
                                  <img src="<?= base_url(); ?>images/star.png" /> */ ?>
                            </div>
                            <div class="shop_1_right totalCountRating" data-total="<?= $dealMeta['rateit_status']['total'] ?>" >Out of <?= $dealMeta['rateit_status']['total'] ?></div>
                        </div>
                        <div class="wize_details">
                            <div>Based on 120 reviews (3 sources) </div>
                            <div class="wize_best">Best for <a href="#">Work</a>, <a href="#">Alarm</a>, <a href="#">Athletes</a>, <a href="#">Wrist</a>, <a href="#">Seniors</a></div>
                            <div>
                                <div class="av_rate_img">

                                    <div class="str_rt_box">
                                        <div class="str_rt_box1">5 Stars</div>
                                        <div class="str_rt_box2">
                                            <div class="orange_bar color_rate"></div>
                                        </div>
                                        <div class="str_rt_box3" data-rel="<?= $dealMeta['rateit_status']['data'][5] ?>">(<?= $dealMeta['rateit_status']['data'][5] ?>)</div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="str_rt_box">
                                        <div class="str_rt_box1">4 Stars</div>
                                        <div class="str_rt_box2">
                                            <div class="orange_bar color_rate1"></div>
                                        </div>
                                        <div class="str_rt_box3" data-rel="<?= $dealMeta['rateit_status']['data'][4] ?>">(<?= $dealMeta['rateit_status']['data'][4] ?>)</div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="str_rt_box">
                                        <div class="str_rt_box1">3 Stars</div>
                                        <div class="str_rt_box2">
                                            <div class="orange_bar color_rate2"></div>
                                        </div>
                                        <div class="str_rt_box3" data-rel="<?= $dealMeta['rateit_status']['data'][3] ?>">(<?= $dealMeta['rateit_status']['data'][3] ?>)</div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="str_rt_box">
                                        <div class="str_rt_box1">2 Stars</div>
                                        <div class="str_rt_box2">
                                            <div class="orange_bar color_rate3"></div>
                                        </div>
                                        <div class="str_rt_box3" data-rel="<?= $dealMeta['rateit_status']['data'][2] ?>">(<?= $dealMeta['rateit_status']['data'][2] ?>)</div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="str_rt_box">
                                        <div class="str_rt_box1">1 Stars</div>
                                        <div class="str_rt_box2">
                                            <div class="orange_bar color_rate4"></div>
                                        </div>
                                        <div class="str_rt_box3" data-rel="<?= $dealMeta['rateit_status']['data'][1] ?>">(<?= $dealMeta['rateit_status']['data'][1] ?>)</div>
                                        <div class="clear"></div>
                                    </div>

                                    <div class="clear"></div>                                     
                                </div>

                            </div>
                            <div class="clear"></div>  
                            <div id="wize_slider">
                                <div class="wize_slider">
                                    <p class="wize_slider_strong"><strong class="orange_color">wize_review</strong> , Jul 8, 2010 <br /></p>
                                    <strong class="wize_slider_strong">Terriffic Watch</strong><br />

                                    "...great durable watch that has to endure a lot of punishment at work.can't wear anything too fancy that would only get scratched or broken...this watch fits the bill..."<br/>
                                    <div class="clear"></div>

                                </div>
                                <div class="wize_slider">
                                    <p class="wize_slider_strong"><strong class="orange_color">wize_review</strong> , Jul 8, 2010 <br /></p>
                                    <strong class="wize_slider_strong">Terriffic Watch12</strong><br />

                                    "...great durable watch that has to endure a lot of punishment at work.can't wear anything too fancy that would only get scratched or broken...this watch fits the bill..."<br/>
                                    <div class="clear"></div>

                                </div>
                                <div class="wize_slider">
                                    <p class="wize_slider_strong"><strong class="orange_color">wize_review</strong> , Jul 8, 2010 <br /></p>
                                    <strong class="wize_slider_strong">Terriffic Watch23</strong><br />

                                    "...great durable watch that has to endure a lot of punishment at work.can't wear anything too fancy that would only get scratched or broken...this watch fits the bill..."<br/>
                                    <div class="clear"></div>

                                </div>
                                <div class="wize_slider">
                                    <p class="wize_slider_strong"><strong class="orange_color">wize_review</strong> , Jul 8, 2010 <br /></p>
                                    <strong>Terriffic Watch34</strong><br />

                                    "...great durable watch that has to endure a lot of punishment at work.can't wear anything too fancy that would only get scratched or broken...this watch fits the bill..."<br/>
                                    <div class="clear"></div>

                                </div>
                                <div class="wize_slider">
                                    <p class="wize_slider_strong"><strong class="orange_color">wize_review</strong> , Jul 8, 2010 <br /></p>
                                    <strong class="wize_slider_strong">Terriffic Watch56</strong><br />

                                    "...great durable watch that has to endure a lot of punishment at work.can't wear anything too fancy that would only get scratched or broken...this watch fits the bill..."<br/>
                                    <div class="clear"></div>

                                </div>
                                <div class="wize_slider">
                                    <p class="wize_slider_strong"><strong class="orange_color">wize_review</strong> , Jul 8, 2010 <br /></p>
                                    <strong>Terriffic Watch78</strong><br />

                                    "...great durable watch that has to endure a lot of punishment at work.can't wear anything too fancy that would only get scratched or broken...this watch fits the bill..."<br/>
                                    <div class="clear"></div>

                                </div>
                                <div class="clear"></div>
                            </div>

                            <div class="wize_review"><a href="#">See reviews</a></div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="av_rating">
                    <div class="shop_1" id="top_btn_currency" >
                        <div class="shop_1_left rateit"  data-rateit-step="1" data-rateit-value="<?= $dealMeta['rateit_status']['average'] ?>" data-rateit-resetable="false" data-productid="<?= $dealMeta['i_id'] ?>">
                            <? /*  <img src="<?= base_url(); ?>images/star.png">
                              <img src="<?= base_url(); ?>images/star.png">
                              <img src="<?= base_url(); ?>images/star.png">
                              <img src="<?= base_url(); ?>images/star.png">
                              <img src="<?= base_url(); ?>images/star.png"> */ ?>
                        </div>
                        <div class="shop_1_right" onclick="show_rate()">Out of  <?= $dealMeta['rateit_status']['total'] ?></div>
                    </div>
                    <p class="all_re" onclick="show_rate()" style="cursor: pointer">All Reviews</p>
                    <p class="wr_re"><a href="javascript:void(0)" onclick="$('#rate_box').show('slow');">Write a Review</a></p>
                </div>
                <div class="av_rate_img">

                    <div class="str_rt_box">
                        <div class="str_rt_box1">5 Stars</div>
                        <div class="str_rt_box2">
                            <div class="orange_bar color_rate"></div>
                        </div>
                        <div class="str_rt_box3" data-rel="<?= $dealMeta['rateit_status']['data'][5] ?>">(<?= $dealMeta['rateit_status']['data'][5] ?>)</div>
                        <div class="clear"></div>
                    </div>
                    <div class="str_rt_box">
                        <div class="str_rt_box1">4 Stars</div>
                        <div class="str_rt_box2">
                            <div class="orange_bar color_rate1"></div>
                        </div>
                        <div class="str_rt_box3" data-rel="<?= $dealMeta['rateit_status']['data'][4] ?>">(<?= $dealMeta['rateit_status']['data'][4] ?>)</div>
                        <div class="clear"></div>
                    </div>
                    <div class="str_rt_box">
                        <div class="str_rt_box1">3 Stars</div>
                        <div class="str_rt_box2">
                            <div class="orange_bar color_rate2"></div>
                        </div>
                        <div class="str_rt_box3" data-rel="<?= $dealMeta['rateit_status']['data'][3] ?>">(<?= $dealMeta['rateit_status']['data'][3] ?>)</div>
                        <div class="clear"></div>
                    </div>
                    <div class="str_rt_box">
                        <div class="str_rt_box1">2 Stars</div>
                        <div class="str_rt_box2">
                            <div class="orange_bar color_rate3"></div>
                        </div>
                        <div class="str_rt_box3" data-rel="<?= $dealMeta['rateit_status']['data'][2] ?>">(<?= $dealMeta['rateit_status']['data'][2] ?>)</div>
                        <div class="clear"></div>
                    </div>
                    <div class="str_rt_box">
                        <div class="str_rt_box1">1 Stars</div>
                        <div class="str_rt_box2">
                            <div class="orange_bar color_rate4"></div>
                        </div>
                        <div class="str_rt_box3" data-rel="<?= $dealMeta['rateit_status']['data'][1] ?>">(<?= $dealMeta['rateit_status']['data'][1] ?>)</div>
                        <div class="clear"></div>
                    </div>

                    <div class="clear"></div>                                     
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div> 
    <div class="rt_pro" id="rate_box" style="display:none;">
        <a class="close" onclick="$('#rate_box').hide('slow');">&times;</a>
        <div class="q_heading">Quick Rate this Product</div>
        <div class="q_rate_sub">Tell us how you liked it</div>
        <div class="clear"></div>
        <div class="rate_bg">
            <div class="for_rate rateit"   data-rateit-step="1" data-rateit-value="<?= $dealMeta['rateit_status']['average'] ?>" data-rateit-resetable="false" data-productid="<?= $dealMeta['i_id'] ?>">
                <? /* <img src="<?= base_url(); ?>images/star.png" />
                  <img src="<?= base_url(); ?>images/star.png" />
                  <img src="<?= base_url(); ?>images/star.png" />
                  <img src="<?= base_url(); ?>images/star.png" />
                  <img src="<?= base_url(); ?>images/star.png" /> */ ?>
            </div>
            <div class="rate_comt">Rate It</div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div class="view_review">
            <? /* <div class="view_review_1"><a href="#">View 1 Review</a></div>
              <div class="view_review_2"><a href="#">Write a Review</a></div> */ ?>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div class="rate_clm">
            Enter an optional quick review.<br />
            <textarea class="rate_input" name="" ></textarea>
        </div>
        <div><input class="show_more" name="Saved" type="button" value="Saved" /></div>

        <div class="btm_arw"><img src="<?= base_url(); ?>images/btm_arrow.png" /></div>
    </div>
</div>
<link href="<?= base_url() ?>js/rateit.css" rel="stylesheet" type="text/css">

<script src="<?= base_url() ?>js/jquery.rateit.js" type="text/javascript"></script>
<script type ="text/javascript">
    $(document).ready(function(){
        $('.orange_bar').each(function(){
            $dataCount = $(this).parent().next().attr('data-rel'); 
            $dataTotalCount = $('.totalCountRating').attr('data-total'); 
            $(this).width(($dataCount/$dataTotalCount)*100+'%');
        });
    });
    //we bind only to the rateit controls within the products div
    $('.rateit').bind('rated reset', function (e) {
        var ri = $(this);
 
        //if the use pressed reset, it will get value: 0 (to be compatible with the HTML range control), we could check if e.type == 'reset', and then set the value to  null .
        var value = ri.rateit('value');
        $('.rateit').rateit('value',value);
        var productID = ri.data('productid'); // if the product id was in some hidden field: ri.closest('li').find('input[name="productid"]').val()
 
        //maybe we want to disable voting?
        $('.rateit').rateit('readonly', true);
        if(value<=2){
            $('.rate_comt').html('Poor');
        }
        if(value>2&&value<=3){
            $('.rate_comt').html('Good');
        }
        if(value>3&&value<=4.5){
            $('.rate_comt').html('Good');
        }
        if(value==5){
            $('.rate_comt').html('Best');
        }
 
        $.ajax({
            url: '<? base_url() ?>home/rateit', //your server side script
            data: { id: productID, value: value }, //our data
            type: 'POST',
            success: function (data) {
                //window.location.reload();
                //$('#response').append('<li>' + data + '</li>');
            },
            error: function (jxhr, msg, err) {
                //$('#response').append('<li style="color:red">' + msg + '</li>');
            }
        });
    });
</script>
