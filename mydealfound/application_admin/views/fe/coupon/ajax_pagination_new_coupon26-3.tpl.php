
<script type="text/javascript" src="<?php echo base_url()?>js/ZeroClipboard/jquery.zclip.js"></script>
<script type="text/javascript">
var global_id='';
function open_coupn_details_page(coupon_id,store_url,coupon_url,merchant_url)
{	
	//global_id='';
										//alert(global_id);
	
	var merchant_url=base64_decode(merchant_url);
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
							//alert (n[0]);
							$("[id^=code_paste]").html("");
							
							$('[id^=tooltip]').css('display','none');
							$("#code_paste"+coupon_id).html(n[0]);
							setTimeout(function() {
										window.open('<?php echo base_url()?>product_land/index/'+store_url+'/'+coupon_url,"coupon","height=600px,width=582px,scrollbars=yes,top=10, left=560");
										
									}, 2000);
							if(n[0]!='The deal is activated')
							{		
									$('[id^=copied_coupon_code]').html("Click here to copy code");
									//global_id='';
									/*$("[id^=code_paste]").html("");
									$('[id^=copied_coupon_code]').html("Click here to copy code");
									$('[id^=tooltip]').css('display','none');
									$("#code_paste"+coupon_id).html(n[0]);*/
									$('#tooltip'+coupon_id).css("display","block");
									$('#copied_coupon_code'+coupon_id).html("The code is copied")
									
									/*setTimeout(function() {
										global_id='';
										//alert(global_id);
										$("#code_paste"+coupon_id).html("");
										$('#copied_coupon_code'+coupon_id).html("Click here to copy code");
										$('#tooltip'+coupon_id).css('display','none')
										
									}, 10000);*/
									
										
									if(/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(n[1]))
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
								$('[id^=copied_coupon_code]').html("Click here to activate deal");
								$('#tooltip'+coupon_id).css("display","none");
							}//open_in_new_tab(url);
							/*setTimeout(function() {
								window.open('hhtps://'+n[1]);
							}, 900);*/
							//open_in_new_tab('https://'+n[1]);
					}
         	});
			
			
			if(/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(merchant_url))  {
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
			path:'<?php echo base_url()?>js/ZeroClipboard/ZeroClipboard.swf',
			copy:function(){
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

                    
                   <!-- <div class="active_coupons top_coupons">
                    	<h2>New<span> Coupons</span></h2>-->
                        
                        <?php if($new_coupons){
							foreach($new_coupons as $val) { 
							
						?>
							
							
                         <a href="" id="<?php echo $val['s_seo_url']?>"></a>
                        <div class="product_active_coupon">
                        	<div class="det_offer">
                            	<div class="float_left">
                                	<a href="<?php echo base_url()?>product-detail/<?php echo $val['s_url']?>"><img src="<?php echo base_url().'uploaded/store/thumb/thumb_'.$val['s_store_logo']?>" alt="logo" class="border1px" title="<?php  echo $val['s_store_title']?>"/></a>
                                </div>
                                <div class="offer">
                                	<h3><a href="<?php //echo make_valid_url($val['coupon_url'])?>javascript:void(0)" ><?php echo $val['s_title']?></a></h3>
                                    
                                    <div class="clear"></div>
                                    <div class="get_code">
									<?php /*?><a id="copy" target="_blank" href="<?php echo make_valid_url($val['coupon_url'])?>"  onclick="open_coupn_details_page('<?php echo $val['i_id']?>','<?php echo $val['s_url']?>','<?php echo $val['s_seo_url']?>');"><?php if($val['i_coupon_type']==2) { echo 'Click here to view code';}else 
									{echo 'Click to activate Deal';}?></a><?php */?>
                                    
                                    <span class="coupon_code" id="coupon_code<?php echo $val['i_id']?>" onclick="open_coupn_details_page('<?php echo $val['i_id']?>','<?php echo base64_encode($val['s_url'])?>','<?php echo base64_encode($val['s_seo_url'])?>','<?php echo base64_encode($val['coupon_url'])?>');">
										<?php if($val['i_coupon_type']==1){echo "Activate Deal";}else {echo "View Code";} ?>
									</span>
                                    
									</div>
                                    <input type="hidden" value="<?php echo $val['i_coupon_code']; ?>" id="copycode_coupon_code<?php echo $val['i_id']?>" />
									<a class="offer_code" href="javascript:void(0)" id="code_paste<?php echo $val['i_id'] ?>"  >
                                    	
                                    
                                    </a>
                                    
                                    
						<?php      if($val['i_coupon_type']==2)
                              { ?>
                                    <div id="tooltip<?php echo $val['i_id'] ?>" class="tooltip-2" style="float:right;display:block">
                                            <div class="tooltip1-2">&nbsp;</div>
                                            <div class="tooltip2-2" id="copied_coupon_code<?php echo $val['i_id']?>">
                                                Click to copy the code
                                            </div>
                                            <div class="tooltip3-2">&nbsp;</div>
                                        </div>
                                      
                         <?php }?>
                         
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
                         
                         
								    <p><?php echo $val['s_summary'];?></p>
                                    <a href="<?php echo base_url()?>product-detail/<?php echo $val['s_url']?>" class="spcl_land">View more from this store</a>
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
                                                
                    <?php }
						}?>    
                        
                        
                        <ul class="pagination">
                        	<!--<li><a href="#"><<</a></li>
                        	<li><a href="#" class="first">1</a></li>
                            <li><a href="#">2</a></li>
                            
                            
                            javascript:window.open('<?php //echo base_url().'product_land/index/'.$val['s_url']?>','mywindowtitle','width=500,height=150,scrollbars=yes')
                            
                            
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">>></a></li>-->
                            <?php echo $page_links;?>
                        </ul>
                        
                      <!--  <div class="clear"></div>  
                    </div>-->
					
