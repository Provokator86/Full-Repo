<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv='expires' content='-1' />
<meta http-equiv= 'pragma' content='no-cache' />
<meta name='robots' content='all' />
<meta name='author' content='AcumenCs' />
<meta name='description' content='<?=$site_meta_keywords?>' />
<meta name='keywords' content='<?=$site_meta_description?>' />
<meta name='tags' content='<?=$site_meta_tags?>' />

<meta property="og:title" content="<?php echo ($coupon_title)?$coupon_title:''; ?>" />
<meta property="og:description" content="<?php echo ($fb_description)?$fb_description:'';?>" />
<meta property="og:url" content="<?php echo ($url)?$url:''; ?>" />
<meta property="og:image" content="<?php echo ($deal_logo)?$deal_logo:''; ?>" />

<meta property="og:type" content="website" />
<meta property="og:site_name" content="My Deal Found" />

<meta name="OMG-Verify-V1" content="519376-6ef7ba51-3a7d-49b5-b9a5-97ed6335a08b" />

<link rel="stylesheet" href="<?=base_url()?>css/templatestyle.css" type="text/css" />
<link rel="stylesheet" href="<?=base_url()?>css/nivo-slider.css" type="text/css" />
<link rel="stylesheet" href="<?=base_url()?>css/style_slider.css" type="text/css" />
<link rel="stylesheet" href="<?=base_url()?>css/default.css" type="text/css" />
<link rel="stylesheet" href="<?=base_url()?>css/jquery.bxslider.css" type="text/css" />
<link rel="stylesheet" href="<?=base_url()?>css/jslider.css" type="text/css">
<link rel="stylesheet" href="<?=base_url()?>css/skin.css" type="text/css">
<link rel="stylesheet" href="<?=base_url()?>css/custom.css" type="text/css">

<!--[if lt IE 9]>
	<link href="<?=base_url()?>css/ie7.css" rel="stylesheet" type="text/css" />
<![endif]-->


<!--<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>-->
<script type="text/javascript" src="<?=base_url()?>js/jquery-1.9.0.min.js"></script>

<script type="text/javascript" src="<?=base_url()?>js/jquery.dd.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/tytabs.jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/scriptbreaker-multiple-accordion-1.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/fancyBox/source/jquery.fancybox.js?v=2.1.3"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery.cycle.all.js"></script>
<!--for price range slider start -->
<script type="text/javascript" src="<?=base_url()?>js/jshashtable-2.1_src.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery.numberformatter-1.2.3.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/tmpl.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery.dependClass-0.1.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/draggable-0.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  


<?php /*?><script type="text/javascript" src="<?=base_url()?>js/jquery.slider.js"></script><?php */?>

<!--for price range slider end -->
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />



<!--<script type="text/javascript" src="<?=base_url()?>js/jquery.bxslider.min.js"></script>
-->
<title><?=$site_title?></title>

<script type="text/javascript" src="<?=base_url()?>js/scriptbreaker-multiple-accordion-1.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/script.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/modernizr.2.5.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.jcarousel.min.js"></script>

<script type="text/javascript">

  $(document).ready(function(){
        $('.parent_li_cat').mouseover(function(){
				$('#submerchant1').show();
				$('#activecategory_dropbox1').children('a').css({background:' #fff url(<?php echo base_url();?>images/arrow_sans_right-16.png) no-repeat 210px'});
				//$('#activecategory_dropbox1').children('a').addClass('selected');
		}).mouseout(function(){
			$('#activecategory_dropbox1').children('a').css({background:'none'});
		});	
			
    });

</script>
</head> 

<body>


	<div class="top_header">
		<div class="wrapper">
			<div class="top_left">
				<ul>
					<li><a class="twittr" target="_blank" href="<?=$site_settings['s_twitter_url']?>"></a></li>
					<li><a class="facebk" target="_blank" href="<?=$site_settings['s_facebook_url']?>"></a></li>
					<li><a class="ggle" target="_blank" href="<?=$site_settings['s_google_plus_url']?>"></a></li>
					<li><a class="pin" target="_blank" href="<?=$site_settings['s_pinterest_url']?>"></a></li>
				</ul>
			</div>
			<div class="top_right">
				<ul class="topnav">
					<li class="tell"><a href="#">Tell A Friend</a></li>
					<li class="deal"><a href="<?php echo base_url()?>home/submit_a_deal">Submit A Deal</a></li>
					<li><a href="<?=base_url()?>blog">Blog</a></li>
                                        <? if($this->session->userdata('current_user_session')):?>
                                            <li><a href="<?=  base_url()?>user/profile">Hi,<?
                                            $current_user_session = $this->session->userdata('current_user_session');
                                            echo $current_user_session[0]['s_name'] ?></a></li>
                                            <li><a href="<?=  base_url()?>user/logout">Sign Out</a></li>
                                          
                                        <? else:?>
                                             <li><a href="#">Login</a>
                                                <ul>
                                                    <li>
                                                      <img src="<?=base_url()?>images/login_arr.png" alt="" class="login_arr" />
                                                      <form class="login_form" method="post" action="<?=  base_url()?>user/login" onsubmit="return false">
                                                              <input name="email" title="email" placeholder="email" type="text" class="input" from-validation="required|email" />
                                                              <input name="password" title="password"  placeholder="password" type="password" class="input" from-validation="required"   />
                                                              <a style="padding:10px;" href="<?=  base_url()?>user/forget_password">Forget Password</a>
															  <a style="padding:10px;" href="<?=  base_url()?>user/forget_password">Sign Up</a>
                                                              <input class="sub" name="Submit" type="button" value="Submit" onclick="validate_login_form();" />
                                                      </form>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li><a href="<?=base_url()?>user/signup">Sign Up</a></li>
                                        <? endif;?>
				</ul>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	
            

	<div class="wrapper">
            <div class="mid_header">
                    <div class="logo">
                            <a href="<?=base_url()?>"><img src="<?=base_url()?>images/logo_deal.png" alt="" /></a>
                    </div>
                    <div class="mid_right">
                     <? $this->load->view('elements/header_search.tpl.php');?>
                    </div>
                    <div class="clear"></div>
            </div>
            <div class="clear"></div>	
            	
            <div class="nav">

        <ul>
        	
            <li><a href="<?=base_url()?>" class="active home"></a></li>
            
          <li class="parent_cat">
            <div class="categories_button"> <a href="javascript:void(0)" class="parent_li_cat" id="categories">Categories</a>
                <div class="category_dropbox" id="categorylist" style="display: none;">
                  <ul>                  	
                      <? foreach($categoryData as $k=>$categoryMeta):?>
                      <li  id="activecategory_dropbox<?=($k+1)?>"  onmouseover="$('#submerchant<?=($k+1)?>').show();" onmouseout="$('#submerchant<?=($k+1)?>').hide();">
                          <a href="<?php echo base_url().'category/'.$categoryMeta['s_url'] ?>" >
                              <img height="20" width="20" src="<?=base_url();?>uploaded/category/thumb/thumb_<?=$categoryMeta['s_thumb']?>" />
                                <?=$categoryMeta['s_category']?>
                          </a>
                        
						
				
						
                    </li>
                      <? endforeach;?>
                    <!--start new dropdown 1/10/12-->
                  </ul>
				  
				<? foreach($categoryData as $k=>$categoryMeta):?>
				
				  <div class="dropchild  dropwidth" rel="rel_<?=($k+1)?>" id="submerchant<?=($k+1)?>" style="display: none;"  onmouseover="$('#submerchant<?=($k+1)?>').show();" onmouseout="$('#submerchant<?=($k+1)?>').hide();">
                           
						  
						  <div class="nav_child">
						  <h5>List of Categories</h5>
						    <ul>   
								<?php 
									if(!empty($categoryMeta['sub_cat']))
									{
										foreach($categoryMeta['sub_cat'] as $sk=> $sv) { 
								?>
								<li><a href="<?php echo base_url().'category/'.$categoryMeta['s_url'].'?subcat='.$sv['i_id'].'' ?>"><?php echo $sv["s_category"] ?></a></li> 
								<?php 
										} 
									}
								?>                        
                            </ul>
							
							<h5>Price</h5>
							<ul>   
								<!--<li><input type="radio" name="price-range" value="0-700">below Rs. 700 </li>
								<li><input type="radio" name="price-range" value="700-1000"> Rs. 700 - Rs. 1000 </li>				
								<li><input type="radio" name="price-range" value="1001-2000"> Rs. 1001 - Rs. 2000 </li>
								<li><input type="radio" name="price-range" value="2001-2500"> Rs. 2001 - Rs. 2500 </li>
								<li><input type="radio" name="price-range" value="2501"> above Rs. 2500 </li>-->
								<li><a href="<?php echo base_url().'category/'.$categoryMeta['s_url'].'?price=0-700' ?>">below Rs. 700 </a></li>
								<li><a href="<?php echo base_url().'category/'.$categoryMeta['s_url'].'?price=700-1000' ?>">Rs. 700 - Rs. 1000 </a></li>				
								<li><a href="<?php echo base_url().'category/'.$categoryMeta['s_url'].'?price=1001-2000' ?>">Rs. 1001 - Rs. 20000 </a></li>
								<li><a href="<?php echo base_url().'category/'.$categoryMeta['s_url'].'?price=2001-2500' ?>">Rs. 2001 - Rs. 2500 </a></li>
								<li><a href="<?php echo base_url().'category/'.$categoryMeta['s_url'].'?price=2501' ?>">above Rs. 2500 </a></li>
                            </ul>
                            
						  </div> 
							 <div class="nav_child">
							 <h5>Popular Store</h5>
							<ul>     
								<?php 
									if(!empty($categoryMeta['popular_store']))
									{
										foreach($categoryMeta['popular_store'] as $sk=> $sv) { 
								?>
								<li><a href="<?php echo base_url().'category/'.$categoryMeta['s_url'].'?store='.$sv['i_id'].'' ?>"><?php echo $sv["s_store_title"] ?></a></li> 
								<?php 
										} 
									}
								?>                                
                            </ul>
							
							<h5>Popular Brand</h5>
							<ul>   
								<?php 
									if(!empty($categoryMeta['popular_brand']))
									{
										foreach($categoryMeta['popular_brand'] as $sk=> $sv) { 
								?>
								<li><a href="<?php echo base_url().'category/'.$categoryMeta['s_url'].'?brand='.addslashes($sv['s_brand_name']).'' ?>"><?php echo $sv["s_brand_name"] ?></a></li> 
								<?php 
										} 
									}
								?>                           
                            </ul>
                           </div>
                            
                      <div class="disc_child"> 
					  <h5>Discount</h5>
					  
					  <ul>
					  
					  <li><a href="<?php echo base_url().'category/'.$categoryMeta['s_url'].'?brand='.addslashes($sv['s_brand_name']).'' ?>"><?php echo $sv["s_brand_name"] ?></a></li>
					  </ul>
					     
					  <?php if($categoryMeta['s_image']!='') { ?>
						  <div class="nav_pic">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" height="100%">
								<tr>
									<td align="center" valign="middle" height="100%">									
									<img src="<?=base_url()?>uploaded/category/right_image/right_image_<?=$categoryMeta['s_image']?>" alt="" />
									</td>
								</tr>
							</table>							
						</div>
						<?php } ?>
					  </div>
							<div class="clearfix"></div>
                        </div>
						
				<? endforeach;?>
						<div class="clearfix"></div>
				
                  <?php /*?><a href="#" class="all_cat">See All
                    Categories</a><?php */?> </div>
            </div>
          </li>
		  
          <li><a href="<?=base_url()?>store">Cash Back Stores</a></li>
            <li><a href="<?=base_url()?>top-deals">Top Deals</a></li>
            <?php /*?><li><a href="<?=base_url()?>daily-deals">Daily Deals</a></li><?php */?>            
            <li><a href="<?=base_url()?>popular-deals">Popular Deals</a></li>
            <li><a href="<?=base_url()?>coupons">Coupons</a></li>
            <li><a href="<?=base_url()?>forum">Forums</a></li>
        </ul>
      </div>
<script>
    function validate_login_form(){
            if(validate_form($('.login_form'),
            {
                beforeValidation : function(targetObject){
                  $(targetObject).css('color','#333333');
                },
                onValidationError : function (targetObject){
                    $(targetObject).css('color','red');
                }
            })){
             ajax_form_submit($('.login_form'));
            }
    }
    
    function ajax_form_submit(targetForm){
        $.post($(targetForm).attr('action'), $(targetForm).serialize(), function(respData){
            //console.log($(targetForm).attr('action'));
            if(respData.status =='success'){
                window.location = '<?=  base_url()?>user/profile';
            } else {
                
            }
        }, 'json');
    }
</script>
