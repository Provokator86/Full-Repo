<script type="text/javascript">
/**************************For nivoslider start*******************************/	
	$(window).load(function()
	{	
		
		$('#slider').nivoSlider();
	});
/**************************For nivoslider end*******************************/	

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

	$(document).ready(function(e) {
        $("#bottom_part_l").hide();
    });
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url().'js/check_dd/jquery-ui-1.8.13.custom.css'?>">
 <link rel="stylesheet" type="text/css" href="<?php echo base_url().'js/check_dd/ui.dropdownchecklist.themeroller.css'?>">
<script type="text/javascript" src="<?php echo base_url().'js/check_dd/ui.dropdownchecklist.js'?>"></script>
<div class="banner_wrapper">
<div class="banner_select_cat">
                    <div class="slider">
                    	<div class="cotation-tab">
                        	<!--<h3>Get Upto 40% Disscount</h3>-->
                            <input type="button" class="getur-cod-btn"  value="" onclick="window.location.href='<?php echo base_url(); ?>new-coupon/'" />
                        </div>
                    	<div class="slider-wrapper theme-default">
                            <div id="slider" class="nivoSlider">
                            <?php
								if(!empty($home_banner))
								{
									foreach($home_banner as $key=>$val)
									{
										echo '<img style="width:592px; height:317px;" src="'.$home_banner_image_path.$val['s_image'].'" />';
									}
								}
							?>
                               
                            </div>
                        </div>
                    </div> 
                    <div class="select_cat">
                    
                        <h2>Select a<span> Category</span></h2>
                        <ul>
                        <?php 
							if(!empty($category))
							{
								foreach($category as $key=>$val)
									{
						?>
                                <li><a href="<?php echo base_url().'category/detail/'.$val['s_url']?>"><div class="item"><img src="<?php echo $category_image_path.$val['s_image']?>"><br><span><?php echo $val['s_category'];?></span></div></a></li>
    						<?php
									}
								}
							?>
    
                        </ul>
                    </div>
                   
                    <div class="clear">
            	
            		</div>     	
                </div>
                </div>

<div id="body_container">
            <div class="separator"></div>
        	<div class="f_body">
            	
                <div class="fav_brand_store">
                	<div class="fav_brand">
                    <h2>Favourite<span>Brands</span></h2>
                    	<ul>
                        	<?php 
								if(!empty($brand))
								{
									foreach($brand as $key=>$val)
									{
							?>
                        			<li><a href="<?php echo base_url()?>brand/detail/<?php echo $val['s_url']?>" onMouseOver="opentt('<?php echo $val['i_id']?>');" onMouseOut="closett('<?php echo $val['i_id']?>');"><img class="border1px" src="<?php echo $brand_image_path.$val['s_brand_logo']?>"  ></a>
                                        <div id="<?php echo $val['i_id']?>" class="tooltip" style=" display:none;">
                                            <div class="tooltip1">&nbsp;</div>
                                            <div class="tooltip2">
                                                <?php echo my_showtext($val['s_brand_title'])?>
                                            </div>
                                            <div class="tooltip3">&nbsp;</div>
                                        </div>
                                    
                                    </li>
                                    
                            <?php
									}
								}
							?>
                            <div class="clear"></div>
                            <a href="<?php echo base_url().'brand'?>" class="view_all width_ie">View all Brands</a>
                        </ul>
                    </div>
                    
                    <div class="feature_store">
                    	<h2>Featured<span>Stores</span></h2>
                    	<ul>
                        	<?php 
								if(!empty($store))
								{
									foreach($store as $key=>$val)
									{
							?>
                        			<li><a href="<?php echo base_url()?>product-detail/<?php echo $val['s_url']?>" onMouseOver="opentt('<?php echo "stores". $val['i_id']?>');" onMouseOut="closett('<?php echo "stores". $val['i_id']?>');"><img class="border1px" src="<?php echo $store_image_path.$val['s_store_logo']?>" ></a>
                                    <div id="<?php echo "stores". $val['i_id']?>" class="tooltip" style=" display:none;">
                                            <div class="tooltip1">&nbsp;</div>
                                            <div class="tooltip2">
                                                <?php echo my_showtext($val['s_store_title'])?>
                                            </div>
        									<div class="tooltip3">&nbsp;</div>
   									</div>                                    
                                    </li>                                    
                            <?php
							
									}
								}
							?>
                            
                           <div class="clear"></div> 
                        <a href="<?php echo base_url().'store'?>" class="view_all">View all Stores</a>                           
                        </ul>
                         
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="coupons_add">
                	<div class="left_panel">
                    	<h2>Top<span>Coupons</span></h2>
                        <ul>
                        <?php //pr($top_coupons);
							if(!empty($top_coupons))
							{
								foreach($top_coupons as $key=>$val)
								{
						?>
                        	<li><div class="c_logo"><a href="<?php echo base_url()?>product-detail/<?php echo $val['s_url']?>" ><img src="<?php echo $top_coupons_store_image_path.$val['s_store_logo']?>" alt="9eras" title="<?php  echo $val['s_store_title']?>"></a>
                            </div><div>			
                            <a href="<?php echo make_valid_url($val['coupon_url'])?>" target="_blank" onclick="open_coupn_details_page('<?php echo $val['i_id']?>','<?php echo $val['s_url']?>','<?php echo $val['s_seo_url']?>');"><span class="coupon_code" id="coupon_code<?php echo $val['i_id']?>"><?php if($val['i_coupon_type']==1){echo "Activate Deal";}else {echo "View Code";} ?></span></a></div>
                            <div class="off"><a ><?php echo substr($val['s_title'],0,60)?></a></div>
                            <div class="all_same_coup"><a href="<?php echo base_url()?>product-detail/<?php echo $val['s_url']?>">See all <?php echo my_showtext($val['s_store_title'])?> coupons</a></div>
                            </li>
                            <?php
								}
							}
							?>
                            
                            
                        </ul>
                        <div class="clear"></div>
                        <a href="<?php echo base_url()?>top-coupon" class="view_all margin-right20">View all Top Coupons</a>
                        <div class="clear"></div>
                        <h2>Latest<span>Coupons</span></h2>
                        <ul>
                        	<?php //pr($latest_coupons);
							if(!empty($latest_coupons))
							{
								foreach($latest_coupons as $key=>$val)
								{
						?>
                        		<li><div class="c_logo"><a href="<?php echo base_url()?>product-detail/<?php echo $val['s_url']?>" ><img src="<?php echo $latest_coupons_store_image_path.$val['s_store_logo']?>" alt="9eras" title="<?php  echo $val['s_store_title']?>"></a>
                            </div><div>			
                            <a href="<?php echo make_valid_url($val['coupon_url'])?>"  target="_blank" onclick="open_coupn_details_page('<?php echo $val['i_id']?>','<?php echo $val['s_url']?>','<?php echo $val['s_seo_url']?>');"><span class="coupon_code" id="coupon_code<?php echo $val['coupon_id']?>"><?php if($val['i_coupon_type']==1){echo "Activate Deal";}else {echo "View Code";} ?></span></a></div>
                            <div class="off"><a><?php echo $val['s_title']?></a></div>
                            <div class="all_same_coup"><a href="<?php echo base_url()?>product-detail/<?php echo $val['s_url']?>">See all <?php echo my_showtext($val['s_store_title'])?> coupons</a></div>
                            </li>
                            <?php
								}
							}
							?>                          
                            
                        </ul>
                        <div class="clear"></div>
                            
                        <a href="<?php echo base_url();?>new-coupon" class="view_all margin-right20">View all Latest Coupons</a>
                        <div class="clear"></div>
                    </div>
                    <div class="right_panel">
                     <!--JOIN US-->
     				 <?php include_once(APPPATH."views/fe/common/right_panel_join_us.tpl.php"); ?>
    				 <!--JOIN US-->
                       
                        <div class="fav_coup">
                        	<a href="javascript:" onclick="openlightbox();">Let us guess Your Favourite Coupons</a>
                        </div>
                        <?php include_once(APPPATH."views/fe/common/common_subscribe.tpl.php"); ?>
                        <!--<div class="subscribe" >
                        	<h2>Subscribe for<span>good deals</span></h2>
                            <div id="msg"></div>
                            <form name="newsletter_subscribe" action="" id="newsletter_subscribe" method="post">
                            	<input type="text" value="Provide Your Email Address"  id="email_id" onclick="if(this.value=='Provide Your Email Address')this.value='';" onblur="if(this.value=='')this.value='Provide Your Email Address';"/>
                               
                            	<input type="button" value="submit" onclick="subscribe('newsletter_subscribe')"/>
                            </form>
                            <div class="clear"></div>
                        </div>-->
                        
                        <div class="max_dis">
                       <h2>Maximum <span>Discount Store </span></h2>
                            <ul>
                            	<?php 
								if(!empty($store_discount))
								{
									foreach($store_discount as $key=>$val)
									{
								?>
                            	<li><a href="<?php echo base_url()?>product-detail/<?php echo $val['s_url']?>"><?php echo my_showtext($val['s_store_title']);?></a></li>
                                <?php
									}
								}
								?>
                            </ul>
                        	
                        </div>
                       <div class="ad2">
                        	
                        </div>
                        <div class="ad2">
                        	
                        </div>
                        
                         <?php if($banner){ foreach($banner as $val) {?>
                    	<div class="ad">
                        	<a href="<?php echo make_valid_url($val['s_url']);?>" target="_blank"><img src="<?php echo base_url().'uploaded/banner/'.$val['s_image']; ?>" alt="advertisement"/></a>
                        
                        </div>
                        
                        <?php } ?><?php }?>
                    </div>
                    <div class="clear">
                    	
                    </div>
                    
                </div>
               
            </div>
            </div>
            
            
<div class="let_fav_coup">
    	<div class="lightbox-inner">
    	<h2>Let us guess Your <span>Favourite Coupons</span></h2>
        <div style="float:right; position:absolute;left:97%;top:-7%"> <a href="javascript:" onclick="coselightbox();"><img src="<?php echo base_url();?>images/fe/close_lightbox.png" alt="close"/></a></div>
        <div  class="clear"></div>
        <div class="fav">
        <form action="<?php echo base_url().'home/fav-coupon'?>" method="post" id="fav">
        	<div class="lb-left-side">
            	<h3>Your favourite Category:</h3>
                <select id="fev_select" name="search_cat" onchange="get_store_id(this.value)" >
                	<option value="">Select</option>
                	<?php echo makeOptionNoEncrypt($category_for_dd);?>	
                </select>
                
            </div>
            <div class="clear"></div>
           <div class="bottom_part_l" style="display:none;">
            <div class="lb-right-side">
            	<h3>Your favourite store:</h3>
                <!--<div id="fav_store_select">
                <select id="fev_select2" name="search_brand">
                	<option value="">Select</option>
                	<?php //echo makeOptionNoEncrypt($brand_for_dd);?>
                </select>
                </div>-->
                <ul id="fav_store_select">
                	<!--<li>
                    	<input type="checkbox"><span>Jabong</span>
                    </li>
                    <li>
                    	<input type="checkbox"><span>Jabong</span>
                    </li>
                    <li>
                    	<input type="checkbox"><span>Jabong</span>
                    </li>
                    <li>
                    	<input type="checkbox"><span>Jabong</span>
                    </li>
                    <li>
                    	<input type="checkbox"><span>Jabong</span>
                    </li>
                    <li>
                    	<input type="checkbox"><span>Jabong</span>
                    </li>-->
                    
                </ul>
            </div>
           
            <div class="clear"></div>
            <div style="text-align:center; margin-top:25px; margin-right:55px;">
            	<input type="button" class="lb-submit-btn" value="Submit" onclick="frm_submit_search(fav)" />
            </div> 
            
            </div>
            <div class="clear"></div>
            </form>
        </div>
        
        </div>
    </div>
    <div class="lightbox-cover" onclick="coselightbox();"></div>
    
    
     <script language="javascript">
 
 function get_store_id(cat_id)
 {
	 //alert(cat_id);
	 $.ajax({
							type: 'POST',
							url : '<?php echo base_url()?>home/get_store_id_drop_down',
							data: 'cat_id='+cat_id,
							dataType: 'text',
							success: function(msg)
							{	
								$('#fav_store_select').html(msg);
								//$("#fev_select2").msDropDown();//(engineSize)=select tab ID;
								$(".bottom_part_l").css("display","block");
								//$('#fev_select2_msdd').css("width", "210px");
								//$('#fev_select2_child').css("width", "210px");
								//$("#fev_select2").dropdownchecklist();
								
							}			
						});
	 
 }
 
 
 
 function frm_submit_search(fav)
 {
	//alert(fav); 
	//return false;
	var i=0;
	var a= new Array();
	$("input:checked").each(function(){ 
        var test=$(this).val();
        a[i]=test; 
		i++;   
    });
	//alert(a);
	 //var a=$('id^=').val();
	 var b=$('#fev_select').val();
	 //alert(a);
	 //alert(b);
	 if(a!='' && b!='' && a!=null && b!=null)
	 {
		 $(fav).submit();
	 }
	 else
	 {
	 alert('Please select both category and store');
	 return false
	 }
 }
 
 
 
 
 </script>
<script language="javascript">

function subscribe(frmid)
{
	var frm_data	= $('#'+frmid).serialize();
	var email_id= $('#email_id').val();
	if(email_id!='')
	{
			var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
				if(reg.test($.trim($("#email_id").val())) == false) 
					{
						$("#msg").html('<div class="error_massage">Please provide proper email</div>');	
					}
				else
					{		
					$.ajax({
							type: 'POST',
							url : '<?php echo base_url()?>home/newsletter_subscribe',
							data: 'email_id='+email_id,
							dataType: 'text',
							success: function(msg)
							{
								$("#msg").html(msg);
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

<!--<div id="tooltip" style="display:none; position:absolute; top:60px; left:25px; color:#fff;">
    	<div class="tooltip1" style="background:url(images/img1_01.png) no-repeat; float:left; height:30px;">&nbsp;</div>
        <div class="tooltip2" style="background:url(images/img1_02.png) no-repeat; float:left; height:30px; line-height:36px; font-size:15px; font-weight:bold;">
        	Nike
        
        </div>
        <div class="tooltip3" style="background:url(images/img1_03.png) no-repeat; float:left; width:6px; height:30px;">&nbsp;</div>
    </div>-->
    
    
<script type="text/javascript">
function open_coupn_details_page(coupon_id,store_url,coupon_url)
{
	var coupon_id=coupon_id;
	var store_url=store_url;
	var coupon_url=coupon_url;
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
								window.open('<?php echo base_url()?>product_land/index/'+store_url+'/'+coupon_url,'coupon',"height=600px,width=380px,scrollbars=yes");
							}, 300);
							/*setTimeout(function() {
								window.open('hhtps://'+n[1]);
							}, 900);*/
							
							
							
						if(/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(n[1])){
							var url = n[1];
						} else {
							var url = 'http://'+n[1];
						}
							//open_in_new_tab(url);
					}
         	});
	
	//window.location.href=""
}


function open_in_new_tab(url )
{
  window.open(url, '_blank');
  //chrome.tabs.create({url: 'http://pathToYourUrl.com'});
 // window.focus();
  


}


</script>