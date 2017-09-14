<script type="text/javascript" src="<?=base_url()?>js/star/jquery.MetaData.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/star/jquery.rating.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/star/easyResponsiveTabs.js"></script>

<link rel="stylesheet" href="<?=base_url()?>js/star/jquery.rating.css" type="text/css" />
<link rel="stylesheet" href="<?=base_url()?>js/star/easy-responsive-tabs.css" type="text/css" />

<style type="text/css">
        .demo {
            /*width: 980px;*/
            margin: 0px auto;
        }
        .demo h1 {
                margin:33px 0 25px;
            }
        .demo h3 {
                margin: 10px 0;
            }
        pre {
            background: #fff;
        }
        @media only screen and (max-width: 780px) {
        .demo {
                margin: 5%;
                width: 90%;
         }
        .how-use {
                float: left;
                width: 300px;
                display: none;
            }
        }
        #tabInfo {
            display: none;
        }
    </style>


<script>

$(document).ready(function(){

        $('.rating-cancel').hide();
        $('.rating-cancel').css('display:none');
        $('div.star-rating a').click(function(){
            var rating = $(this).text();
            var store_id = $('#store_id').val();
            if( rating!='' && rating!=null)
                {
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url()?>home/add_vote',
                    data: 'rating='+rating+'&store_id='+store_id,
                    dataType:'JSON',
                    success: function(data){
                        if(data.status=="success"){
                            $('#rateusStars').css('visibility','hidden');
                            $("#no_of_vote,#totalVote").html(data.total);
                            $("#avg_rate,#avgRate").html(data.avg);
                            $('#rateusMsg').html(data.msg);
                        } 
                        if(data.status=="error"){
                            $('#rateusMsg').html(data.msg);
                        }
                    }
                });
            } else {
                alert ('please cast your vote');
            }
        });
    });

</script>


<script type="text/javascript">
    $(document).ready(function () {
        $('#horizontalTab').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion           
            width: 'auto', //auto or any width like 600px
            fit: true,   // 100% fit in a container
            closed: 'accordion', // Start closed if in accordion view
            activate: function(event) { // Callback function if tab is switched
                var $tab = $(this);
                var $info = $('#tabInfo');
                var $name = $('span', $info);

                $name.text($tab.text());

                $info.show();
            }
        });

        $('#verticalTab').easyResponsiveTabs({
            type: 'vertical',
            width: 'auto',
            fit: true
        });
    });
</script>

<script>
    var current_comment_on = 0;
    var current_comment_type = '';

    function setCurrentComment(param1,param2){
        current_comment_on = param1;
        current_comment_type = param2;
    }
    $(document).ready(function() {

        $("[id^='comnt_but_store_']").click(function(){
							   
		var name        = 	$.trim($('#s_store_user_name').val());
		var comments    =	$.trim($('#s_store_user_comments').val());
		
		if(name=='' || comments=='')
		{
			$("#store_comment_err").html('<div style="color:#f00; margin-left:150px;">Please provide the mandatory fields.</div>');
		}
		else
		{
			        $.ajax({
                                type : 'POST',
                                data : 'name='+escape(name)+'&comment='+escape(comments)+'&id='+escape(current_comment_on)+'&type='+escape(current_comment_type),
                                url  :	'<?php echo base_url()?>home/comment_post2',
								//dataType : 'json',
                                success	:function(data){
                                    if(data.trim() == 'ok')
                                    {
										$(".comment_msg_success").html('<div style="color:green; margin-bottom:30px;">Your thoughts are valuable to us.We are impatient to display it, Just awaiting admin\'s approval</div>');
                                        $('.comment_msg_err').hide();
                                        $('.comment_msg_success').show();
										setTimeout(function(){
											 $('.comment_msg_success').hide();
											},5000);
										
										$('.comment_msg_err').hide();	
										$('#s_store_user_name').val('');
										$('#s_store_user_comments').val('');
                                       
                                    } else {
                                        $('#comment_msg_err').html('Sorry!!.Something went wrong.');                              
                                    }
                                }
                            })			
                    }		
			})
    
		<?php /*?>$(".view_det").click(function(e){
			$("#dialog").dialog({					
			width: 400
			});
		});<?php */?>
	
	});	
	
	var $current_user_session = <?php if($current_user_session){ echo 'true';} else { echo 'false';}?>;
	
	
	
	
</script>

<?php //echo '<pre>';print_r($store_details[0]);echo '</pre>'; 
if(stristr($store_details[0]['s_store_url'],"http://"))
{
	$store_url = $store_details[0]['s_store_url'];
}
else if(stristr($store_details[0]['s_store_url'],"https://"))
{
	$store_url = $store_details[0]['s_store_url'];
}
else
	$store_url = 'http://'.$store_details[0]['s_store_url'];
?>
<div class="clear"></div>
<div class="lst_vw">

<div class="hd_ar">
	<?php echo $store_details[0]['s_store_title']?> <!--<span>Coupons, Sales &amp; Deals</span>-->
</div>

<div class="wrapper_inner_banner">
	<div class="left_box">
    	<div class="l_area"><a href="<?php echo $store_url;  ?>" target="_blank">
		<img src="<?=base_url()?>uploaded/store/<?php echo $store_details[0]['s_store_logo']?>" alt="" />
		</a></div>
        <div class="l_hd_dl"><a href="#"><img src="<?=base_url()?>images/save.png" alt="" /></a> <?php echo $store_details[0]['s_cash_back']?></div>
        <div class="l_des">
        	<p>
            <?php echo $store_details[0]['s_about_us']?>
            </p>
        </div>
        
        
        <div class="rate_it">

                        <img src="<?php echo base_url();?>images/star_1.png" alt="star"/>

                        <span><span id="no_of_vote">&nbsp;<?php echo $total_no_of_votes;?></span>&nbsp;votes</span>

                        <div class="rate_product" id="rate">

                            <a>Rate this store</a>

                        </div>



                        <div class="hreview-aggregate" >

                            <span class="item">

                                <span class="fn"><?php echo $store_details[0]['s_store_title']?></span>

                            </span>

                            <span class="rating">

                                <span id="avgRate" class="average"><?php echo $avg_rate;?></span> out of

                                <span class="best">5</span>

                            </span>

                            based on

                            <span class="votes" id="totalVote"><?php echo $total_no_of_votes;?></span> ratings.

                        </div>

						<input type="hidden" value="<?php echo $store_details[0]['i_id']?>" id="store_id" />

                        <?php if(!$isRated){?>
                            <div class="rate_us" id="rateusStars">
                                <div id="rate1" class="rating">&nbsp;</div>

                                <input name="star1" type="radio" class="star" value="1" <?php if($avg_rate==1) echo 'checked="checked"'?>/>

                                <input name="star1" type="radio" class="star" value="2" <?php if($avg_rate==2) echo 'checked="checked"'?>/>

                                <input name="star1" type="radio" class="star" value="3" <?php if($avg_rate==3) echo 'checked="checked"'?>/>

                                <input name="star1" type="radio" class="star" value="4" <?php if($avg_rate==4) echo 'checked="checked"'?>/>

                                <input name="star1" type="radio" class="star" value="5" <?php if($avg_rate==5) echo 'checked="checked"'?>/>



                                <span>&nbsp;Rate us (current average rating <span id="avg_rate"><?php echo $avg_rate;?></span> )</span>

                                <div class="clear"></div>

                            </div>
                            <div class="rate_us" style="font-size:10px" id="rateusMsg"></div>
                            <?php } else {?>
                            <div class="rate_us" style="font-size:10px" id="rateusMsg">
                                <div>You have already rated it!</div>
                            </div>
                            <?php } ?>
                    </div>
					<div>
						<div style="float:left; margin-left:15px; ">
							<a href="javascript:void(0);" onclick="showCashBackDetails();" style="color:##003366; font-weight:bold; cursor:pointer;" class="view_det">Cashback Details</a>
							<?php if(!empty($loggedin_details)) { 
								$s_uid = $loggedin_details[0]['s_uid'];
								$chk_url = $store_details[0]['s_store_url']."&UID=$s_uid";
							?>
							<input class="in_rw_submit" name="Submit" type="submit" onclick="chekForShop('<?php echo $chk_url;?>')" value="Shop Now" />
							
							<?php } else { ?>
							<input class="in_rw_submit" name="Submit" type="submit" onclick="chekForShop('<?php echo $store_details[0]['s_store_url']?>')" value="Shop Now" />
							<?php } ?>
							
						</div>
						<div class="share_exp_div">
							Review <?php echo $store_details[0]['s_store_title']?>
						</div>
					</div>
                    <?php /*?><div class="share_exp_div">
                    	Review <?php echo $store_details[0]['s_store_title']?>
                	</div><?php */?>
                    <span class="add_comment_part">
                            <a href="#hc" class="share_exp open_comment_experiance comments">
                            <span>
							<?php //echo gettotalstorecomment($store_details[0]['i_id']) ?>
                            </span> reviews</a>							
                        </span>
                        <div class="clear"></div>
    </div>
    <div class="right_box">
    
    <div class="demo">
        <!--Horizontal Tab-->
        <div id="horizontalTab">
            <ul class="resp-tabs-list">
                <li>Popular Store</li>
                <li>Top Store</li>
                <li>Max Discounted</li>
            </ul>
            <div class="resp-tabs-container">
                <div>
                	<div class="tab_row_two"><a href="<?php echo base_url()?>store">View All Store</a></div>
                    <?php
						foreach($popular_store as $popular_key=>$popular_val)
						{
							if($popular_val['deal_count']>1)
								$number_txt	= ' deals and coupons found';
							else
								$number_txt	= ' deal and coupon found';
					?>
                           <div class="tab_row">
                                <div class="col_1"><a href="<?php echo base_url().$popular_val['s_url']?>"><img src="<?=base_url()?>uploaded/store/<?php echo $popular_val['s_store_logo']?>" alt="" /></a></div>
                                <div class="col_2"><?php echo ($popular_val['deal_count']>0)?$popular_val['deal_count'].$number_txt:'';?><br/> <?php echo ($popular_val['s_cash_back']!='')?$popular_val['s_cash_back']:'';?></div>
                               
                                <br clear="all" />
                           </div>
                   <?php
				   		}
				   ?>
                   
                </div>
                <div>
                <div class="tab_row_two"><a href="<?php echo base_url()?>store">View All Store</a></div>
                <?php
						foreach($top_store as $top_key=>$top_val)
						{
							if($popular_val['deal_count']>1)
								$number_txt	= ' deals and coupons found';
							else
								$number_txt	= ' deal and coupon found';
				?>
                           <div class="tab_row">
                                <div class="col_1"><a href="<?php echo base_url().$top_val['s_url']?>"><img src="<?=base_url()?>uploaded/store/<?php echo $top_val['s_store_logo']?>" alt="" /></a></div>
                                <div class="col_2"><?php echo ($top_val['deal_count']>0)?$top_val['deal_count'].$number_txt:'';?><br/> <?php echo ($top_val['s_cash_back']!='')?$top_val['s_cash_back']:'';?></div>
                               
                                <br clear="all" />
                           </div>
                  <?php
				  		}
				  ?>              
                   
                </div>
                <div>
                <div class="tab_row_two"><a href="<?php echo base_url()?>store">View All Store</a></div>
                <?php
					foreach($max_discount_store as $max_key=>$max_val)
					{
						if($popular_val['deal_count']>1)
							$number_txt	= ' deals and coupons found';
						else
							$number_txt	= ' deal and coupon found';
				?>
                            <div class="tab_row">
                                <div class="col_1"><a href="<?php echo base_url().$max_val['s_url']?>"><img src="<?=base_url()?>uploaded/store/<?php echo $max_val['s_store_logo']?>" alt="" /></a></div>
                                <div class="col_2"><?php echo ($max_val['deal_count']>0)?$max_val['deal_count'].$number_txt:'';?><br/><?php echo ($max_val['s_cash_back']!='')?$max_val['s_cash_back']:'';?></div>
                               
                                <br clear="all" />
                           </div>
                <?php
				  	}
				?>                 
                </div>
            </div>
        </div>
       <br />
	</div>    
    <!--<a href="#"><img src="<?=base_url()?>images/lenovo_screen.jpg" alt="" /></a>--></div>
    <br clear="all" />
</div>

<?=$dealList?>

</div>
<!-- start of review coupons -->
<div class="clear"></div>
<div class="active_coupons">
    <a name=hc></a>
    <h2 style="padding:10px 0 0 15px;">Review <span><?php echo $store_details[0]['s_store_title']?> </span>Store</h2>
    <p style="padding-left: 16px;">(Know and Share your experience with this store.)</p>
    <div class="product_active_coupon">
        <div class="">
            <ul>
                <?php  $store_comment    =    get_commnets_for_this_store($store_details[0]['i_id']) ; //pr($store_comment);?>

                <?php if($store_comment)
                    { 
                        foreach($store_comment as $st_cm)
                        {        
                        ?>
                        <li class="revw">

                            <div class="rev">

                                <div class="rev_left"> <img src="<?php echo base_url()?>images/no-img.jpg" alt=""></div>
                                <div class="rev_right"><?php echo $st_cm['s_comments'];?></div>

                            </div>


                            <!--<img src="<?php echo base_url()?>/images/fe/no-img.jpg" alt="">
                            <span>
                            <?php echo $st_cm['s_comments'];?>
                            </span>-->
                            <span class="comment_date">
                                <?php echo $st_cm['s_commented_by_email'].' posted on '.date('d M Y h:i',strtotime($st_cm['dt_entry_date']));?>
                            </span>
                        </li>
                        <?php
                        }
                    }
                ?>

            </ul>
        </div>
    </div>
    <span style="padding-left:18px; font-weight:bold; color:#003366;">Review this store here:</span><br />
    <br />
    <div id="store_comment_err" class="comment_msg_err" style="margin-bottom:10px;"></div>
    <div id="store_comment_err" class="comment_msg_success"></div>
    <form id="comment_<?php echo $store_details[0]['i_id']?>s" method="post" action="" name="">


        <table width="390" border="0" cellpadding="0" cellspacing="0" style="margin-left:18px;">
            <tr>
                <td width="115px" valign="top">Name<span class="color_red">*</span>:</td>
                <td width="275px" valign="top"><input name="s_name" id="s_store_user_name" type="text" class="revinpt" style="margin-bottom:10px;" /></td>
            </tr>
            <tr>
                <td width="115px" valign="top" style="padding-top:15px;">Post Message<span class="color_red">*</span>:</td>
                <td width="275px" valign="top"><textarea name="s_comments" id="s_store_user_comments" class="txtare"></textarea></td>
            </tr>
            <tr>
                <td width="115px" valign="top">&nbsp;</td>
                <input type="hidden" id="cpn_<?php echo $store_details[0]['i_id']?>s" name="cpn_id_cmnt" />
                <td width="275px" valign="top">
                    <input id="comnt_but_store_<?php echo $store_details[0]['i_id']?>s" type="button" value="Post" class="rvsbt" onclick="setCurrentComment(<?php echo $store_details[0]['i_id']?>,'store')" ></td>
            </tr>
        </table>
    </form>

</div>
            <!-- end of review coupons -->

<div class="clear"></div>

<?php /*?> Dialog box cash back details<?php */?>
<?php /*?><div id="dialog" title="Cash Back Details" style="display:none;">
	<p><?php echo $store_details[0]['s_cash_back_details']?></p>
</div><?php */?>
<?php /*?><div class="shadowWrapper" id="shadowWrapperCashBack" style="display: none">
	<div class="shadowWrapperContent">
		<img class="closeShadow" onclick="$('.shadowWrapper2').hide();" src="<?=  base_url()?>images/close-wrapper.png">
		<div class="shadowWrapperContentBody"> 
			<div id="tabs">
				<ul>
				  <li><a href="#tabs-1">Cash Back Details</a></li>
				</ul>
				<div id="tabs-1"> 
					<div>                     
						<div class="input_fiela_box">
							<p><?php echo $store_details[0]['s_cash_back_details']?></p>
						</div>
					</div>
				</div>
  		</div>
		</div>
	</div>
</div><?php */?>
<?php /*?> end Dialog box cash back details<?php */?>

<?php $this->load->view('common/social_box.tpl.php'); ?>

