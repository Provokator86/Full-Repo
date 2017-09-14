<?php // pr($store);?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript">

function open_coupn_details_page(coupon_id,store_url,coupon_url)

{

	var coupon_id=coupon_id;

	var store_url=base64_decode(store_url);

	var coupon_url=base64_decode(coupon_url);

	$.ajax({

					type: "POST",

					

					url: '<?php echo base_url()?>product_detail/get_coupon_code',

					data: 'coupon_id='+coupon_id,

					

					success: function(msg){

							//alert(msg);

							var n= msg.split('|');

							//alert (n[1]);

							$("#coupon_code"+coupon_id).html(n[0])

							

							setTimeout(function() {

								window.open('<?php echo base_url()?>product_land/index/'+store_url+'/'+coupon_url,'coupon',"height=auto,width=510,scrollbars=yes");

							}, 300);

							/*setTimeout(function() {

								window.open('hhtps://'+n[1]);

							}, 900);*/

							

							

							

						var reg=/(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;	

						if(reg.test(n[1]))

						{

							var url = n[1];

						} else {

							var url = 'http://'+n[1];

						}

							open_in_new_tab(url);

					}

         	});

	

	//window.location.href=""

}





function open_in_new_tab(url )

{

  window.open(url, '_blank');

  //chrome.tabs.create({url: 'http://pathToYourUrl.com'});

  window.focus();

  





}





</script>



<script type="text/javascript" src="<?php echo base_url()?>js/ZeroClipboard/jquery.zclip.js"></script>

<script type="text/javascript">

	$(document).ready(function() {

		/*$('[id^="copy"]').zclip({

			path:	'<?php //echo base_url()?>js/ZeroClipboard/ZeroClipboard.swf',

			copy:	function(){

				return $('#copy').text();

			}

			

		});*/

		

		$('[id^="get_code"]').zclip({

			path:	'<?php echo base_url()?>js/ZeroClipboard/ZeroClipboard.swf',

			copy:	function(){

				var id = $(this).attr('id');

				id = id.split('get_code').pop();

				return $('#code_of_coupon' + id).val();

			}

			

		});

	});

</script>



<script src="<?php echo base_url();?>js/fe/jquery.dd.js" type="text/javascript"></script>



<link href="<?php echo base_url();?>css/fe/style.css" rel="stylesheet" type="text/css">



<div id="body_container" class="product_land_popup">

            <div class="separator"></div>

        	<!--<div class="f_body">-->

            <div>

            	

            	

                <div class="middle_part_popup">

                <h2>Deal <span>Activated</span></h2>

                    <div class="coupon_codes2">

                    	<div class="product_active_coupon">

                        	<div class="det_offer">

                            	<div class="coupon_logo">

                                	<img src="<?php echo base_url().'uploaded/store/thumb/thumb_'.$top_coupons_list[0]['s_store_logo']?>" alt="logo"/>

                                </div>

                                <div class="offer">

                                <?php $coupon_id =  $current_coupon[0]['i_id'];?>

                                	<h3><a href="<?php echo make_valid_url($current_coupon[0]['s_url']);?>" target="_blank"><?php echo $current_coupon[0]['s_title']?></a></h3>

                                    <a class="offer_code" id="copy" href="<?php echo make_valid_url($current_coupon[0]['s_url']);?>" target="_blank" <?php /*?>onclick="copyToClipboard(this.rel)"<?php */?> rel="<?php if($current_coupon[0]['i_coupon_code']){echo $current_coupon[0]['i_coupon_code'];}else echo "The Deal is activated";?>"><?php if($current_coupon[0]['i_coupon_code']){echo $current_coupon[0]['i_coupon_code'];}else echo "The Deal is activated";?></a>

                                   <?php /*?> <span class="coupon_code" id="coupon_code<?php echo $val['i_id']?>" onclick="open_coupn_details_page('<?php echo $val['i_id']?>','<?php echo $val['store_url']?>','<?php echo $val['s_seo_url']?>','<?php echo $val['s_url']?>');">

								<?php if($val['i_coupon_type']==1){echo "Activate Deal";}else {echo "View Code";} ?>

									</span><?php */?>

                                    

                                    

                                    <p><?php echo strip_tags($current_coupon[0]['s_summary'],'<img><p><br></br>')?></p>

                                 </div>

                                

                                <div class="clear"></div>

                            </div>

                            

                            

                        </div>

                        

                    	

                    </div>

                    <div class="use_coupons">

                    <h2>How to use the deal</h2>

                    <p>1.  Deal does not require any coupon code.<br>

						2.  Simply add the products desired to your shopping cart.<br>

						3.  If the product page does not show the expected discount, 

     						go to the checkout page and the discount will be applied there.</p>

                            </div>

                    <div class="active_coupons active_coupons_popup">

                    	<h2>Other<span><?php echo $store[0]['s_store_title']?>Coupon</span></h2>

                        

                        <?php  if($top_coupons_list)

								{ 	if(count($top_coupons_list)>1){

									foreach ($top_coupons_list as $val)

										 {

											if($val['i_id']!=$coupon_id){?>

                        					<div class="product_active_coupon product_active_coupon_popup">

                        					<div class="det_offer">

                            				<div class="float_left">

                                			<img src="<?php echo base_url().'uploaded/store/thumb/thumb_'.$val['s_store_logo']?>" alt="logo"/>

                                			</div>

                                			<div class="offer">

                                			<h3><a href="#"><?php echo $val['s_title']?></a></h3>

                                    

                                   <?php /*?> <span class="image_like">  <iframe src="//www.facebook.com/plugins/like.php?href=<?php echo rawurlencode(base_url().'product_land/index/'.$val["s_url"].'/'.$val['s_seo_url']);?>&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:72px; height:21px;" allowTransparency="true"></iframe></span><div class="clear"></div><?php */?>

                                    

                                    		<div class="get_code">

                                            

                                            <a  id="get_code<?php echo $val['i_id']?>" href="javascript:void(0)" onclick="open_coupn_details_page('<?php echo $val['i_id']?>','<?php echo base64_encode($val['s_url'])?>','<?php echo base64_encode($val['s_seo_url'])?>');"><?php if($val['i_coupon_type']==2) {?>Click here to view code<?php } else {?>Click to activate deal <?php } ?></a> 

                                            

                                           

                                            </div>

                                            <input type="hidden" value="<?php echo $val['i_coupon_code']?>" id="code_of_coupon<?php echo $val['i_id'];?>" />

                                            <a class="offer_code" href="#"></a>

                                    		<p><?php echo $val['s_summary']?></p>

                                   			<a href="<?php echo base_url()?>product_detail/index/<?php echo $val['s_url']?>" class="spcl_land">View more from this store</a>

                                			</div>

                                

                               				<div class="clear"></div>

                            				</div>

                            				<div class="shared_comment">

                            				<div class="comnt">

                                			<span class="added_date">Added <?php echo date('d-m-y', strtotime($val['dt_of_live_coupons']));?>, Expires  <?php echo date('d-m-y', strtotime($val['dt_exp_date']));?> </span>

                                    		<span class="bg_right">&nbsp;</span>

                                    		<span class="image_like">  <iframe src="//www.facebook.com/plugins/like.php?href=<?php echo rawurlencode(base_url().'product_land/index/'.$val["s_url"].'/'.$val['s_seo_url']);?>&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:72px; height:21px;" allowTransparency="true"></iframe></span>

                                    

                                   			 <div class="clear"></div>

                                    

                                    

                               		 </div>

                            </div>

                            

                        </div>

                         <?php } } }else {echo "<h3 class='error_massage'>Sorry!!..No other coupon</h3>";}} ?>  <!--                    

                        <div class="product_active_coupon">

                        	<div class="det_offer">

                            	<div class="float_left">

                                	<img src="images/future_bazar_logo.png" alt="logo"/>

                                </div>

                                <div class="offer">

                                	<h3><a href="#">Upto 50% off on Puma Footwear</a></h3>

                                    <div class="get_code"><a href="#">Click here to view deal</a></div>

                                    <p>Get Upto 50% off on Puma footwear. Offer valid ONLY on products displayed 

                                    on the landing page. No coupon code required.</p>

                                    <a href="#" class="spcl_land">View more from this store</a>

                                </div>

                                

                                <div class="clear"></div>

                            </div>

                            <div class="shared_comment">

                            	<div class="comnt">

                                	<span>Added 12 Nov 2012, Expires 30 Feb 2013 </span>

                                    <span class="image_like"><a href="#"><img src="images/like.png" alt="like"></a></span>

                                    

                                    <div class="clear"></div>

                                    

                                    

                                </div>

                            </div>

                            

                        </div>

                        

                        <div class="product_active_coupon">

                        	<div class="det_offer">

                            	<div class="float_left">

                                	<img src="images/future_bazar_logo.png" alt="logo"/>

                                </div>

                                <div class="offer">

                                	<h3><a href="#">Upto 50% off on Puma Footwear</a></h3>

                                    <div class="get_code"><a href="#">Click here to view code</a></div><a class="offer_code" href="#">BSOFFER</a>

                                    <p>Get Upto 50% off on Puma footwear. Offer valid ONLY on products displayed 

                                    on the landing page. No coupon code required.</p>

                                    <a href="#" class="spcl_land">View more from this store</a>

                                </div>

                                

                                <div class="clear"></div>

                            </div>

                            <div class="shared_comment">

                            	<div class="comnt">

                                	<span>Added 12 Nov 2012, Expires 30 Feb 2013 </span>

                                    <span class="image_like"><a href="#"><img src="images/like.png" alt="like"></a></span>

                                    

                                    <div class="clear"></div>

                                    

                                    

                                </div>

                            </div>

                            

                        </div>

                        

                        <div class="product_active_coupon">

                        	<div class="det_offer">

                            	<div class="float_left">

                                	<img src="images/future_bazar_logo.png" alt="logo"/>

                                </div>

                                <div class="offer">

                                	<h3><a href="#">Upto 50% off on Puma Footwear</a></h3>

                                    <div class="get_code"><a href="#">Click here to view code</a></div><a class="offer_code" href="#"></a>

                                    <p>Get Upto 50% off on Puma footwear. Offer valid ONLY on products displayed 

                                    on the landing page. No coupon code required.</p>

                                    <a href="#" class="spcl_land">View more from this store</a>

                                </div>

                                

                                <div class="clear"></div>

                            </div>

                            <div class="shared_comment">

                            	<div class="comnt">

                                	<span>Added 12 Nov 2012, Expires 30 Feb 2013 </span>

                                    <span class="image_like"><a href="#"><img src="images/like.png" alt="like"></a></span>

                                    

                                    <div class="clear"></div>

                                    

                                    

                                </div>

                            </div>

                            

                        </div>

                                                

                        <div class="product_active_coupon">

                        	<div class="det_offer">

                            	<div class="float_left">

                                	<img src="images/future_bazar_logo.png" alt="logo"/>

                                </div>

                                <div class="offer">

                                	<h3><a href="#">Upto 50% off on Puma Footwear</a></h3>

                                    <div class="get_code"><a href="#">Click here to view deal</a></div>

                                    <p>Get Upto 50% off on Puma footwear. Offer valid ONLY on products displayed 

                                    on the landing page. No coupon code required.</p>

                                    <a href="#" class="spcl_land">View more from this store</a>

                                </div>

                                

                                <div class="clear"></div>

                            </div>

                            <div class="shared_comment">

                            	<div class="comnt">

                                	<span>Added 12 Nov 2012, Expires 30 Feb 2013 </span>

                                    <span class="image_like"><a href="#"><img src="images/like.png" alt="like"></a></span>

                                    

                                    <div class="clear"></div>

                                    

                                    

                                </div>

                            </div>

                            

                        </div>

                        

                        <div class="product_active_coupon">

                        	<div class="det_offer">

                            	<div class="float_left">

                                	<img src="images/future_bazar_logo.png" alt="logo"/>

                                </div>

                                <div class="offer">

                                	<h3><a href="#">Upto 50% off on Puma Footwear</a></h3>

                                    <div class="get_code"><a href="#">Click here to view code</a></div><a class="offer_code" href="#">BSOFFER</a>

                                    <p>Get Upto 50% off on Puma footwear. Offer valid ONLY on products displayed 

                                    on the landing page. No coupon code required.</p>

                                    <a href="#" class="spcl_land">View more from this store</a>

                                </div>

                                

                                <div class="clear"></div>

                            </div>

                            <div class="shared_comment">

                            	<div class="comnt">

                                	<span>Added 12 Nov 2012, Expires 30 Feb 2013 </span>

                                    <span class="image_like"><a href="#"><img src="images/like.png" alt="like"></a></span>

                                    

                                    <div class="clear"></div>

                                    

                                    

                                </div>

                            </div>

                            

                        </div>-->

                        

                        

                        

                        

                    </div>

                </div>

                

              <div class="clear">&nbsp;</div>  

            </div>

            </div>