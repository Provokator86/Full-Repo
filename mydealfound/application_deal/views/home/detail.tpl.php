<div class="clear"></div>
<div class="top_add_de"><img src="<?= base_url(); ?>images/ad_top.jpg"></div>
<div class="clear"></div>

<div class="content">
    <div class="product_section">
        <div class="prodct1">
            <div class="p_deatils_box">
                <div class="details_heading_box">
                    <div class="p_heaing"><?= $dealMeta['s_title'] ?></div>
                    <p class="p_sub_heading"><? echo $CategoryPath; //echo getCategoryPath($dealMeta['i_parent_id'],$dealMeta['s_category']); //echo $dealMeta['s_category'] ?></p>

                </div>

                <div class="de_in">

                    <div>   

                        <div class="p_de_left">

                            <?= htmlspecialchars_decode($dealMeta['s_summary']); ?>
							<p>&nbsp;</p>
							<p>&nbsp;</p>
							<?php if(!empty($attributes)) {
							
									foreach($attributes as $key=>$val)
										{
											
							 ?>
							 	<?php if($deal_store_id==318)
											{ ?>
							 	<p><span style="font-weight:bold;"><?php echo ucfirst($key) //echo $val->Name ?> :</span> <?php echo ucfirst($val)//echo $val->Value ?></p>
								<?php } else { ?>
								<p><span style="font-weight:bold;"><?php echo $val->Name ?> :</span> <?php echo $val->Value ?></p>
								
								<?php } ?>
							
							<?php    
											
									}
							
								}
							 ?>
							 <p><span style="font-weight:bold;">Valid Till :</span> <?php echo date("d M Y",strtotime($dealMeta["dt_exp_date"]) )?></p>
							<div style="float:left; margin-top:262px;">
								<img  style="" src="<?=base_url().'uploaded/store/'.$dealMeta['s_store_logo'] ?>" alt="" />
							</div>
                        </div>

                        <div class="p_de_right">

                            <div class="image_details">

                                <div class="look">

                                    <div class="look_off">

                                        <p>LIST PRICE</p>

                                        <p class="font30 line_thr"><?= number_format($dealMeta['d_list_price']); ?></p>

                                    </div>

                                    <div class="look_price">

                                        <p>OFF</p>

                                        <p class="font30"><?= $dealMeta['d_discount']; ?>%</p>

                                    </div>

                                    <div class="look_price">

                                        <p>PRICE</p>

                                        <p class="font30"><?= number_format($dealMeta['d_selling_price']); ?></p>

                                    </div>

                                    <div class="clear"></div>

                                </div>

                                <div class="p_de_right_img">

                                   <?php /*?> <img  style="height:300px;" src="<?= base_url(); ?>uploaded/deal/<?= $dealMeta['s_image_url'] ?>" alt="" /><?php */?>
								    <img  style="height:300px;" src="<?= $dealMeta['s_image_url'] ?>" alt="" />

                                </div>

                            </div>

                            <div class="clear"></div>

                            <div class="de_link">

                                <div class="de_link_left"><img onclick="favourite_deal(<?= $dealMeta['i_id'] ?>)" src="<?= base_url(); ?>images/like.png" alt="" />Add to Favorites</div>

                                <div class="de_link_right"><img onclick="subscribe_deal(<?= $dealMeta['i_id'] ?>)" src="<?= base_url(); ?>images/watch.png" alt="" /><a href="#inline_set_price" class="fancybox">Set Price Alert</a></div>

                                <div class="clear"></div>
                            </div>
                            <div class="share_link">
								
							
                                <div class="share_link_heading">Share This link</div>

                                <? $this->load->view('elements/addThis.tpl.php'); ?>
                            </div>
							
							<?php
							$loggedin = $this->session->userdata('current_user_session');
							if($loggedin[0]["i_id"]>0)	
							{						
							?>

                            <a style="text-align: center;margin: 64px" target="_blank" href="<?= base_url() . 'track/' . ($dealMeta['i_id']) ?>"><img src="<?= base_url() ?>images/grab.png" onmouseover="this.src='<?= base_url() ?>images/grabhover.png';" onmouseout="this.src='<?= base_url() ?>images/grab.png';" /></a>
							
							<?php } else { ?>
							
							<a style="text-align: center;margin: 64px" href="javascript:void(0);"><img onclick="chekForGrabOffer('<?php echo $dealMeta['s_url'];?>')" src="<?= base_url() ?>images/grab.png" onmouseover="this.src='<?= base_url() ?>images/grabhover.png';" onmouseout="this.src='<?= base_url() ?>images/grab.png';" /></a>
							<?php } ?>
                            
                        </div>

                        <div class="clear"></div>

                    </div>
                    
                    <div class="video_cls">
                    	<?php echo htmlspecialchars_decode($dealMeta['s_video']);?>
                    </div>

                    <? //$this->load->view('elements/rating_box.tpl.php'); ?>

                    <? //$this->load->view('elements/related_offer_box.tpl.php'); ?>

                </div>

            </div>

        </div>

        <? $this->load->view('common/social_box.tpl.php'); ?>

        <div class="clear"></div>

    </div>

    <div class="right_pan">

        <div class="clear"></div>

        <? $this->load->view('elements/subscribe.tpl.php'); ?>

        <? $this->load->view('elements/facebook_like_box.tpl.php'); ?>

        <? $this->load->view('elements/latest_deal.tpl.php'); ?>

        <? $this->load->view('elements/forum.tpl.php'); ?>

        <? $this->load->view('common/ad.tpl.php'); ?>

        <div class="clear"></div>

    </div>
    <div class="clear"></div>

</div>

<div class="clear"></div>


<script type="text/javascript">

    $(window).load(function() {

  

        $('#wize_slider')

        .after("<div class='ban_btm'><div id='pager'></div></div>")

        .cycle({ 

            fx:      'fade', 

            timeout:  900,

            pager:    '#pager'

        });
    });

</script>