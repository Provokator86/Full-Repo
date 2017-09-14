<script src='<?php echo base_url()?>js/star/jquery.MetaData.js' type="text/javascript" ></script>

<script src='<?php echo base_url()?>js/star/jquery.rating.js' type="text/javascript" language="javascript"></script>

<script type="text/javascript" src="<?php echo base_url()?>js/ZeroClipboard/jquery.zclip.js"></script>

<link href='<?php echo base_url()?>js/star/jquery.rating.css' type="text/css" rel="stylesheet"/>



<script type="text/javascript">

/**************************For tooltip start*******************************/	

	function opentt(strtt)

	{

		//alert(strtt);

		document.getElementById(strtt).style.display='';

	}

	function closett(strtt)

	{

		document.getElementById(strtt).style.display='none';

	}

/**************************For tooltip end*******************************/

$(document).ready(function(){

	

	$('.rating-cancel').hide();

	$('.rating-cancel').css('display:none');

	$('div.star-rating a').click(function(){

		

		var rating = $(this).text();

		var store_id = $('#store_id').val();

		//alert (rating);

		//alert (store_id);

		var ip = $('#ip').val();

		

		if( rating!='' && rating!=null)

		{

		$.ajax({

					type: "POST",

					

					url: '<?php echo base_url()?>product_detail/add_vote',

					data: 'rating='+rating+'&store_id='+store_id+'&ip='+ip,

					

					success: function(msg){

							var n=msg.split("|");

						

							$("#no_of_vote").html($.trim(n[0]));

							$("#avg_rate").html($.trim(n[1]));

							$("#msg").html($.trim(n[2]));

							//window.location.reload();no_of_vote

						

					}

         	});

		}

		else 

		{

			alert ('please cast your vote');

		}

		

		});

	

	

});		

</script>



<script type="text/javascript">

var global_id='';

function open_coupn_details_page(coupon_id,store_url,coupon_url,merchant_url)

{

	var coupon_id=coupon_id;

	var store_url=base64_decode(store_url);

	var coupon_url=base64_decode(coupon_url);

	var merchant_url=base64_decode(merchant_url);

	//alert(merchant_url);

	$.ajax({

					type: "POST",

					

					url: '<?php echo base_url()?>product_detail/get_coupon_code',

					data: 'coupon_id='+coupon_id,

					

					success: function(msg){

							//alert(msg);

							var n= msg.split('|');

							//alert (n[1]);

							$("[id^=code_paste]").html("");

							

							$('[id^=tooltip]').css('display','none');

							$("#code_paste"+coupon_id).html(n[0]);

							//$('#tooltip'+coupon_id).css("display","block");

							setTimeout(function() {

								window.open('<?php echo base_url()?>product_land/index/'+store_url+'/'+coupon_url,"coupon","height=600px,width=582px,scrollbars=yes,top=10, left=560");

								//open_in_new_tab('https://'+n[1]);

							}, 300);

							

							

							if(n[0]!='The deal is activated')

							{

									$('[id^=copied_coupon_code]').html("Click here to copy code");

									$('#tooltip'+coupon_id).css("display","block");

									$('#copied_coupon_code'+coupon_id).html("The code is copied")

									

									/*setTimeout(function() {

										global_id='';

										//alert(global_id);

										$("#code_paste"+coupon_id).html("");

										$('#copied_coupon_code'+coupon_id).html("Click here to copy code");

										$('#tooltip'+coupon_id).css('display','none')

										

									}, 10000);*/

									

										

									//if(/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(n[1]))

									var reg=/(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

									if(reg.test(n[1]))

										{

											var url = n[1];

										}

									 else 

										{

											var url = 'http://'+n[1];

										}

								

							}

							else

							{

								global_id='';

								$('#tooltip'+coupon_id).css("display","none");

							}

							/*setTimeout(function() {

								window.open('hhtps://'+n[1]);

							}, 900);*/

							//open_in_new_tab('https://'+n[1]);

							//if(/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(n[1]))

						var reg=/(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

						if(reg.test(n[1]))

						{

							var url = n[1];

						}

						 else 

						{

							var url = 'http://'+n[1];

						}

							//open_in_new_tab(url);

							

							

					}

         	});

			var reg=/(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

				if(reg.test(merchant_url))

			//if(/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(merchant_url)) 

				 {

					var murl = merchant_url;

				} else {

					var murl = 'http://'+merchant_url;

				}

				window.open(murl,'_blank');

			

	

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

		

		$('[id^="coupon_code"]').zclip({

			path:	'<?php echo base_url()?>js/ZeroClipboard/ZeroClipboard.swf',

			copy:	function(){

				var id =$(this).attr('id');

				copied_id=id.split("coupon_code");

				global_id=copied_id[1];

				return $('#copycode_'+id).val()

			}

			

		

		});

		

	$("[id^=tooltip]").hide();

		$("[id^=zclip-ZeroClipboard]").mouseover(function(){

			

			var id=($(this).prev().attr('id'));

			

			id=id.split("coupon_code");

			//alert(id[1]);			

			$('#tooltip'+id[1]).show();

		});

		

		$('[id^=zclip-ZeroClipboard]').mouseout(function(){

			var id=($(this).prev().attr('id'));

			id=id.split("coupon_code");

			console.log(global_id);

			console.log(id[1]);

			if(id[1]!=global_id)

			{

				$('#tooltip'+id[1]).hide();	

			}

		});	

		

		

		

	});

</script>







<?php $ip=$_SERVER['REMOTE_ADDR']; //pr($store)?>

<input type="hidden" value="<?php echo $ip;?>" id="ip" />

<input type="hidden" value="<?php echo $store[0]['i_id']?>" id="store_id" />

<div id="body_container">

            <div class="separator"></div>

        	<div class="f_body">

            	<div class="fixed_banner">

                	<img src="<?php echo base_url();?>images/fe/fixed_banner.png" alt="banner"/> 

                </div>

            	<div class="clear">&nbsp;</div>

                <div class="left_part">

                    <div class="coupon_codes">

                    	<div class="about_comp">

                        	<h2><span><?php echo $store[0]['s_store_title']?></span></h2>

                            <p><?php echo nl2br($store[0]['s_about_us']);?>.</p>

                           <!-- <a href="#" class="view_all"><?php //echo $store[0]['s_store_title']?></a>-->

                            

                            <div class="rate_it">

                            	<img src="<?php echo base_url();?>images/fe/star.png" alt="star"/>

                                <span><span id="no_of_vote">&nbsp;<?php echo $total_no_of_votes;?></span>&nbsp;votes</span>

                                <div class="rate_product" id="rate">

								<!--<a href="javascript:void(0)" id="rate_anc">Rate this store<?php //echo $store[0]['s_store_title']?></a>--><a>Rate this store</a>

								</div>

                        

								

                                <div class="hreview-aggregate" >

                                <span class="item">

                                <span class="fn"><?php echo $store[0]['s_store_title']?></span>

                                </span>

                                <span class="rating">

                                <span class="average"><?php echo $avg_rate;?></span> out of

                                <span class="best">5</span>

                                </span>

                                based on

                                <span class="votes"><?php echo $total_no_of_votes;?></span> ratings.

                            	</div>

                                

                                                        

                        

                        

                        

                                <div class="rate_us">

                                

                                <div id="msg" style="font-size:10px"></div>

                                

                                	<div id="rate1" class="rating">&nbsp;</div>

									<input name="star1" type="radio" class="star" value="1" <?php if($avg_rate==1) echo 'checked="checked"'?>/>

									<input name="star1" type="radio" class="star" value="2" <?php if($avg_rate==2) echo 'checked="checked"'?>/>

									<input name="star1" type="radio" class="star" value="3" <?php if($avg_rate==3) echo 'checked="checked"'?>/>

									<input name="star1" type="radio" class="star" value="4" <?php if($avg_rate==4) echo 'checked="checked"'?>/>

									<input name="star1" type="radio" class="star" value="5" <?php if($avg_rate==5) echo 'checked="checked"'?>/>



                                    <span>&nbsp;Rate us (current average rating <span id="avg_rate"><?php echo $avg_rate;?></span> )</span>

                                    <div class="clear"></div>

                                </div>

                            </div>

                            <div class="clear"></div>

                        </div>

                        <div class="comp_logo">

                        	<a href="<?php echo base_url()?><?php echo $store[0]['s_url']?>-coupons"><img class="border1px" src="<?php echo base_url().'uploaded/store/main_thumb/thumb_'.$store[0]['s_store_logo']?>" alt="product_logo"></a>	

                            <a class="avail_coup"><span><?php echo $total_coupons;?></span> Coupon shared</a>

                        </div>

                        

                        

                        

                        

                        

                        <div class="clear"></div>

                    	

                    </div>

                    <div class="active_coupons">

                    	<h2>Active<span>Coupons</span></h2>

                        <?php //pr($top_coupons_list);

							if(!empty($top_coupons_list))

							{

								foreach($top_coupons_list as $key=>$val)

								{

						?>

                        			<div class="product_active_coupon">

                        	<div class="det_offer">

                            	<div class="float_left">

                                	<img class="border1px" src="<?php echo $top_coupons_store_image_path.$val['s_store_logo']?>" alt="logo"/>

                                </div>

                                <div class="offer">

                                	<h3><a ><?php echo my_showtext($val['s_title']);?></a></h3>

                                    

                                    <?php /*?><span class="image_like"><iframe src="//www.facebook.com/plugins/like.php?href=<?php echo rawurlencode(base_url().'product_land/index/'.$val["s_url"].'/'.$val['s_seo_url']);?>&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:72px; height:21px;" allowTransparency="true"></iframe></span><?php */?><div class="clear"></div>

                                    

                                    <div class="get_code">

                                    <?php /*?><a id="copy" target="_blank" href="<?php echo make_valid_url($val['coupon_url'])?>" onclick="open_coupn_details_page('<?php echo $val['i_id']?>','<?php echo $val['s_url']?>','<?php echo $val['s_seo_url']?>');"><?php if($val['i_coupon_type']==2) { echo 'Click here to view code';}else 

									{echo 'Click to activate Deal';}?>

                                    </a><?php */?>

                                    

                                    <span class="coupon_code" id="coupon_code<?php echo $val['i_id']?>" onclick="open_coupn_details_page('<?php echo $val['i_id']?>','<?php echo base64_encode($val['s_url'])?>','<?php echo base64_encode($val['s_seo_url'])?>','<?php echo base64_encode($val['coupon_url'])?>');">

								<?php if($val['i_coupon_type']==1){echo "Activate Deal";}else {echo "View Code";} ?>

									</span>

                                    

                                    </div>

                                    <a class="offer_code"  id="code_paste<?php echo $val['i_id'] ?>"></a>	

                                    <input type="hidden" value="<?php echo $val['i_coupon_code']; ?>" id="copycode_coupon_code<?php echo $val['i_id']?>" />

                                    

                              <?php  if($val['i_coupon_type']==2)

                                        {	?>

                                       <div id="tooltip<?php echo $val['i_id'] ?>" class="tooltip-2" style="float:right;display:none">

                                            <div class="tooltip1-2">&nbsp;</div>

                                            <div class="tooltip2-2" id="copied_coupon_code<?php echo $val['i_id']?>">

                                                Click here to copy code

                                            </div>

                                            <div class="tooltip3-2">&nbsp;</div>

                                        </div> 

                             <?php       } ?>

                                       

                       <?php      if($val['i_coupon_type']==1)

									 { ?>

											<div id="tooltip<?php echo $val['i_id'] ?>" class="tooltip-2" style="float:right;display:block">

												<div class="tooltip1-2">&nbsp;</div>

												<div class="tooltip2-2" id="">

													Click to activate deal

												</div>

												<div class="tooltip3-2">&nbsp;</div>

											</div>

										  

								<?php }?>

                                       

                                       

                                    <p><?php //echo exclusive_strip_tags($val['s_summary'])?><?php echo $val['s_summary'];?></p>

                                   

                                </div>

                                

                                <div class="clear"></div>

                            </div>

                            <div class="shared_comment">

                            	<div class="comnt">

                                	<span class="added_date">Added <?php echo date('d M Y', strtotime($val['dt_of_live_coupons']));?>, Expires <?php echo date('d M Y', strtotime($val['dt_exp_date']));?> </span>

                                    <span class="bg_right">&nbsp;</span>

                                    <span class="image_like"><iframe src="//www.facebook.com/plugins/like.php?href=<?php echo rawurlencode(base_url().'product_land/index/'.$val["s_url"].'/'.$val['s_seo_url']);?>&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:72px; height:21px;" allowTransparency="true"></iframe></span>

                                    

                                    <div class="clear"></div>

                                    

                                    

                                </div>

                            </div>

                            

                        </div>

                        <?php 

								}

							}

							else

							echo "<p><b class='error_massage'>Sorry!!.Currently there is no coupon under this store </b></p>"

						?>

                       </div>

                </div>

                <div class="right_part">

                	

                    <div class="clear"></div>

                     <!--JOIN US-->

                	 <?php include_once(APPPATH."views/fe/common/right_panel_join_us.tpl.php"); ?>

                	 <!--JOIN US-->

                     <!--similar store-->

                	 <?php include_once(APPPATH."views/fe/common/similar_store.tpl.php"); ?>

                	 <!--similar store-->

                     

                     <!--Store Banner-->

                      <?php if($store[0]['s_store_banner']) {?>

                    	<div class="ad ad_store">

                        <a ><img src="<?php echo $store_image_path.$store[0]['s_store_banner']?>" alt="advertisement"/>

                        

                        

                        </a>

                        <span class="add_url"><a href="<?php echo make_valid_url($store[0]['s_store_url']);?>" target="_blank">Go to Page Url</a></span>

                    </div>

					  <?php } else {?>

                      

                      <div class="ad">

                        <a href="<?php echo make_valid_url($store[0]['s_store_url']);?>" target="_blank"><img src="<?php echo base_url().'images/fe/1click1call.png'?>" alt="advertisement"/></a>

                    </div>

                    <?php }?>

                     <!--Store Banner-->   

                     

                    <div class="subscribe">

                        	<h2>Subscribe for<span><?php echo $store[0]['s_store_title']?></span></h2>

                            <div id="msg1"></div>

                            <form name="newsletter_subscribe" id="newsletter_subscribe" method="post">

                            	<input type="text" value="Provide Your Email Address" onclick="if(this.value=='Provide Your Email Address')this.value='';" onblur="if(this.value=='')this.value='Provide Your Email Address';" name="email_id" id="email_id"/>

                                <input type="hidden" value="<?php echo $store[0]['i_id']?>" name="store_id" id="store_id_of_nsltr_subscribe" />

                            	<input type="button" value="submit" onclick="subscribe('newsletter_subscribe')" />

                            </form>

                        </div>  

                        

                    <?php if($google_adds){?>

                       <div class="google_ad">

                        	<?php echo $google_adds[0]['s_description'];?>

                        </div>

                        <?php }?>

                        

                     <?php if($banner){ foreach($banner as $val) {?>

                    	<div class="ad">

                        	<a href="<?php echo make_valid_url($val['s_url']);?>" target="_blank"><img src="<?php echo base_url().'uploaded/banner/thumb/thumb_'.$val['s_image']; ?>" alt="advertisement"/></a>

                        

                        </div>

                        

                        <?php } ?><?php }?>

                       

                        

                </div>

                  

              <div class="clear">&nbsp;</div>  

            </div>

            </div>

            

<script >



function subscribe(frmid)

{

	var frm_data	= $('#'+frmid).serialize();

	var email_id= $('#email_id').val();

	var store_id_nsltr= $('#store_id_of_nsltr_subscribe').val();

	//alert (email_id);

	//alert(store_id_nsltr);

	if(email_id!='')

	{

			var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

				if(reg.test($.trim($("#email_id").val())) == false) 

					{

						$("#msg1").html('<div class="error_massage">Please provide proper email</div>');	

					}

				else

					{		

					$.ajax({

							type: 'POST',

							url : '<?php echo base_url()?>store/newsletter_subscribe_storewise',

							data: 'email_id='+email_id+'&store_id='+store_id_nsltr,

							dataType: 'text',

							success: function(msg1)

							{

								$("#msg1").html(msg1);

								$("#email_id").val("");

							}			

						});

					}

	}

	else

	{

		$("#msg").html('<div class="error_massage">Please provide your email</div>');

	}

}



</script>