<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="footer">
		<div class="ft_menu">
			<ul>
				<li><a href="<?php echo base_url().'about-us' ?>" title="About Us">About Us</a></li>
				<li class="mobile_no_display">|</li>
				<li><a href="<?php echo base_url().'terms-condition' ?>" title="Terms &amp; Conditions">Terms &amp; Conditions</a></li>
				<li class="mobile_no_display">|</li>
				<li><a href="<?php echo base_url().'privacy-policy' ?>" title="Privacy Plolicy">Privacy Policy</a></li>
				<li class="mobile_no_display">|</li>
				<li><a href="<?php echo base_url().'contact-us' ?>" title="Contact Us">Contact Us</a></li>
			</ul>
		</div>
		<div class="wrapper">
				<div class="footer_text"><?=$site_copyright?></div>
		</div>
		<div class="clear"></div>
</div>

</div>

        <?php /*?><div class="fade_inout" id="manu_bg_trans"></div><?php */?>
    <? //$this->load->view('elements/feedback.tpl.php');?>
    <?=$site_settings['s_google_analitics_deal']?> 
	

<script type="text/javascript">
 var base_url = '<?php echo base_url() ?>';
  $(document).ready(function() {
          $( "#tabs" ).tabs();
		  
		  $("#change_captcha").click(function(){
				$("#fld_captcha").attr('src','<?php echo base_url().'captcha'?>/index/'+Math.random());
			});
			
			$(".terms_chk").click(function(){
				if($(this).is(':checked')){		
					$('.termscond').attr('value',$(this).val());
				}else{		
					$('.termscond').attr('value','');
				}
			});
			
			
  });

    var $current_user_session = <?php if($current_user_session){ echo 'true';} else { echo 'false';}?>;
    function validate_signup_form_popup(){
            if(validate_form($('.signup_form_popup'),
            {

                beforeValidation : function(targetObject){
                  $(targetObject).parent().prev().css('color','#333333');
                },
                onValidationError : function (targetObject){
				if(targetObject.hasClass('termscond'))
				{
					$(".txt_terms_cond").css('color','red');
				}
                    $(targetObject).parent().prev().css('color','red');
                },

                captchaValidator :function (targetObject){return validate_captcha_popup(targetObject);},
                duplicateValidator :function (targetObject){return duplicate_check_popup(targetObject);}                

            })){

             ajax_signup_form_submit_popup($('.signup_form_popup'));
            }

    }

    

    function ajax_signup_form_submit_popup(targetForm){
        $.post($(targetForm).attr('action'), $(targetForm).serialize(), function(respData){
            //console.log($(targetForm).attr('action'));
            if(respData.status =='success'){
                window.location = '<?=  base_url()?>user/profile';
            } else {               

            }

        }, 'json');

    }

    function validate_captcha_popup(targetObject){

        var success=false;
        $.ajax({

          type: "POST",
          async: false,
          url: "<?=  base_url()?>user/captcha_check",
          dataType:'json',
          data: { captcha: $(targetObject).val()}
        })

      .done(function( respData ) {
          console.log(respData);
        if(respData.status=='success')
            success =  true;
        else
            success =  false;
        });

    return success;

    }

    function refresh_captcha_popup(){
        $.post('<?=  base_url()?>user/refresh_captcha', {data:'refresh'}, function(respData){
            $('.captchaContainer').html(respData);
        }, 'html');

    }

    function duplicate_check_popup(targetObject){

         var success=false;
        $.ajax({

          type: "POST",
          async: false,
          url: "<?=  base_url()?>user/duplicate_check",
          dataType:'json',
          data: { duplicate: $(targetObject).val()}

        })

      .done(function( respData ) {
          //console.log(respData);
        if(respData.status=='success')
            success =  true;
        else{
            alert(respData.message);
            success =  false;
        }
        });

        return success;

       // return false;

    }

    

    function validate_login_form_popup(){

            if(validate_form($('.signin_form_popup'),
            {
                beforeValidation : function(targetObject){
                  $(targetObject).css('color','#333333');
                },
                onValidationError : function (targetObject){
                    $(targetObject).css('color','red');
                }
            })){
             ajax_form_submit($('.signin_form_popup'));
            }

    }

    

    function ajax_form_submit_popup(targetForm){
        $.post($(targetForm).attr('action'), $(targetForm).serialize(), function(respData){
            //console.log($(targetForm).attr('action'));
            if(respData.status =='success'){
                window.location = '<?=  base_url()?>user/profile';
            } else {
            }

        }, 'json');

    }

    function favourite_deal(dealID){

        if($current_user_session){

            $.post('<?=  base_url()?>user/add_favourite',{
                choosen_deal_id:dealID,
                choosen_type:'fav'

            } ,function(respData){

                if(respData.status='success'){
                    alert(respData.message);
                }

            }, 'json');

        } else {

            $('.choosen_deal_id').val(dealID);
            $('.choosen_type').val('fav');
            $('.shadowWrapper').show();

        }

        

    }
	

    function subscribe_deal(dealID){

       if($current_user_session){

            $.post('<?=  base_url()?>user/add_subscribe',{

                choosen_deal_id:dealID,

                choosen_type:'sub'

            } ,function(respData){

                if(respData.status='success'){

                    alert(respData.message);

                }

            }, 'json');

        } else {

            $('.choosen_deal_id').val(dealID);

            $('.choosen_type').val('sub');

            $('.shadowWrapper').show();

        }

    }
	
	
	/* 1Apr 2014 , function called from top offers details page */
	function add_favourite_deal(dealID){
        if($current_user_session){
            $.post('<?=  base_url()?>user/add_favourite_deal',{
                choosen_deal_id:dealID,
                choosen_type:'fav'
            } ,function(respData){
                if(respData.status='success'){
                    alert(respData.message);
                }
            }, 'json');

        } else {
            $('.choosen_deal_id').val(dealID);
            $('.choosen_type').val('fav');
            $('.shadowWrapper').show();
        }
    }
	
	function add_subscribe_deal(dealID){

       if($current_user_session){
            $.post('<?=  base_url()?>user/add_subscribe_deal',{
                choosen_deal_id:dealID,
                choosen_type:'sub'
            } ,function(respData){
                if(respData.status='success'){
                    alert(respData.message);
                }
            }, 'json');
        } else {
            $('.choosen_deal_id').val(dealID);
            $('.choosen_type').val('sub');
            $('.shadowWrapper').show();
        }
    }
	
	/* 1Apr 2014 , function called from top offers details page */
	
    
	function chekForShop(storeLink)
	{
		if($current_user_session){
            if(storeLink!='')
			{
				window.open(storeLink,'_blank');
			}

        } else {
            //$('.choosen_deal_id').val(dealID);
            //$('.choosen_type').val('fav');
            $('.shadowWrapper').show();
        }
	}
	
	function chekForGrabOffer(storeLink)
	{
		if($current_user_session){
            if(storeLink!='')
			{
				window.open(storeLink,'_blank');
			}

        } else {
            //$('.choosen_deal_id').val(dealID);
            //$('.choosen_type').val('fav');
            $('.shadowWrapper').show();
			$('.grab_txt').attr('href',storeLink);
			//$('.grab_txt').html('Regiter/Login OR Click Here to proceed without cashback');
			//$('.grab_txt').parent('span').css({display:'block'});
			$('.grab_txt').parent('div').css({display:'block'});
        }
	}
	
	function showCashBackDetails(){
            $('.shadowWrapper2').show();      
    }
	
	function setPriceAlertDeal(dealID)
	{
		$('.shadowWrapperAlert').find('#price_img').attr('src','');
		$('.shadowWrapperAlert').find('.s_title').html('');
		//alert(dealID);
		<?php /*?>if($current_user_session){<?php */?>		
			$('.shadowWrapperAlert').show();  
			
			$.ajax({
					type: 'POST',
					url: '<?=  base_url()?>home/fetch_deal_detail',
					data: 'dealID='+dealID,
					dataType: 'json',
					success: function(result) {
						//console.log(result);
						var imgSrc = '';
						if(result.s_image_url!='')
						{
							<?php /*?>imgSrc = '<?php echo base_url().'uploaded/deal/' ?>'+result.s_image_url;<?php */?>
							imgSrc = result.s_image_url;
						}
						else
							imgSrc = '<?php echo base_url().'uploaded/deal/no-image.png' ?>';
						
						$("#price_img").attr('src',imgSrc);
						$(".s_title").html(result.s_title);
						$(".org_price").html(result.d_selling_price);
						var sellPrice = result.d_selling_price!=0?(result.d_selling_price-1):0;
						$(".less_price").val(sellPrice);
						$("#h_deal_id").val(dealID);
					}
				});
		<?php /*?>}
		else
		{
			$('.choosen_deal_id').val(dealID);
            $('.choosen_type').val('sub');
            $('.shadowWrapper').show();
		}<?php */?>
	}
	
	 function validate_price_alert(){

            if(validate_form($('.frm_alert'),
            {
                beforeValidation : function(targetObject){
                  $(targetObject).parent().prev().css('color','#333333');
                },
                onValidationError : function (targetObject){
                    $(targetObject).parent().prev().css('color','red');
                }
            
            }))
			{
             ajax_frm_alert_submit($('.frm_alert'));
            }

    }
	
	function ajax_frm_alert_submit(targetForm){
        $.post($(targetForm).attr('action'), $(targetForm).serialize(), function(respData){
            //console.log($(targetForm).attr('action'));
            if(respData.status =='success'){
                window.location = '<?=  base_url()?>';
            } else {
            }
        }, 'json');

    }
	
	/* call when click on tell a friend link header */
	 function open_login_frm(){
            $('.shadowWrapper').show();
     }
	 /* call when click on tell a friend link header */
	 
	 function shareProduct(productId)
	 {
	 	$('.shadowWrapperShare').find('#prod_img').attr('src','');
		$('.shadowWrapperShare').find('#s_title').html('');
	 	$('.shadowWrapperShare').show(); 
		$.ajax({
					type: 'POST',
					url: '<?=  base_url()?>home/fetch_deal_detail',
					data: 'dealID='+productId,
					dataType: 'json',
					success: function(result) {
						//console.log(result);
						var imgSrc = '';
						if(result.s_image_url!='')
						{
							<?php /*?>imgSrc = '<?php echo base_url().'uploaded/deal/' ?>'+result.s_image_url;<?php */?>
							imgSrc = result.s_image_url;
						}
						else
							imgSrc = '<?php echo base_url().'uploaded/deal/no-image.png' ?>';
							
						
						/*var fb_url = 'http://www.facebook.com/sharer.php?s=100&amp;p[title]='+result.s_title+'&amp;p[summary]='+
									result.s_title+'&amp;p[url]='+encodeURIComponent(result.s_url)+'&amp;p[images][0]='+imgSrc;*/
						
						var fb_url = 'http://www.facebook.com/sharer.php?u='+encodeURIComponent(result.s_url)+'&t='+escape(result.s_title);			
						
						var tw_url = 'http://twitter.com/home?status='+escape(result.s_title)+'+'+encodeURIComponent(result.s_url);
						var gp_url = 'https://plus.google.com/share?url='+encodeURIComponent(result.s_url);
						
						//console.log(fb_url);
						$("#ref_fb").attr('href',fb_url);
						$("#ref_tw").attr('href',tw_url);
						$("#ref_gp").attr('href',gp_url);
						
						$("#prod_img").attr('src',imgSrc);
						$("#s_title").html(result.s_title);
					}
				});
	 }
	 
	
	
</script>


<!-- SIGN UP & LOGIN -->
    <div class="shadowWrapper" style="display: none">
         <div class="shadowWrapperContent">
             <img class="closeShadow" onclick="$('.shadowWrapper').hide();" src="<?=  base_url()?>images/close-wrapper.png">
            <div class="shadowWrapperContentBody">  
             <div id="tabs">
				<ul>
				  <li><a href="#tabs-1">Sign Up</a></li>
				  <li><a href="#tabs-2">Login</a></li>
				</ul>
            <div id="tabs-1"> 
				  <div style="max-height:420px; overflow-y:auto;">
					   <div class="input_fiela_box">
						<form action="<?=  base_url()?>user/signup" method="post" class="signup_form_popup" onsubmit="return false;">
							<input type="hidden" value="xxxx" name="choosen">
	
										<h1>Sign Up</h1>
										<?php /*?><span style="display:none;margin-bottom:15px;">Regiter/Login OR <a class="grab_txt" style="color:#F7681A;  font-weight:bold; cursor:pointer;" target="_blank" href="javascript:">Click Here</a> to proceed without cashback<div class="clear"></div></span><?php */?>
										<div style="display:none;margin-bottom:15px;">Register/Login OR <a class="grab_txt" style="color:#F7681A;  font-weight:bold; cursor:pointer;" target="_blank" href="javascript:">Click Here</a> to proceed without cashback</div><div class="clear"></div>
	
							
										
							<div class="form_box">
					
								<div class="in_clm">
							<div class="in_rw1">Full Name: <span class="red_star">*</span></div>
							<div class="in_rw2">
							<input name="name" type="text" class="in_rw_input" from-validation="required"></div>
							<div class="clear"></div>
						</div>
		
						<div class="clear"></div>
						<div class="in_clm">
							<div class="in_rw1">Email Address: <span class="red_star">*</span></div>
							<div class="in_rw2">
							<input name="email" type="text" class="in_rw_input" from-validation="required|email|duplicate"></div>
							<div class="clear"></div>
						</div>
		
						<div class="clear"></div>
						<div class="in_clm">
							<div class="in_rw1">Password: <span class="red_star">*</span></div>
							<div class="in_rw2">
							<input name="password" autocomplete="off" type="password" class="in_rw_input" from-validation="required|password"></div>
							<div class="clear"></div>
						</div>
		
						<div class="clear"></div>
						<div class="in_clm">
							<div class="in_rw1">Confirm Password: <span class="red_star">*</span></div>
							<div class="in_rw2">
							<input name="confirm" type="password" class="in_rw_input" from-validation="required|password|confirm"></div>
							<div class="clear"></div>
		
						</div>
		
						<div class="clear"></div>
						<div class="clear"></div>
							<div class="in_rw1">Captcha: <span class="red_star">*</span></div>
							<div class="in_rw2">
							   <?php /*?><div class="captchaContainer" style="float:left;width: 135px;height: 40px">
									<?=$captchaImage?>
							   </div>
									<img onclick="refresh_captcha_popup()" style="cursor: pointer;float:left;padding-left: 10px; height:30px;" src="<?=  base_url()?>images/refresh.png" alt="refresh"/><?php */?>
									<div class="captchaContainer" style="float:left;width: 135px;height:60px; padding:0 0 10px 0;">
										<img src="<?php echo base_url().'captcha'?>" id="fld_captcha" />
									</div>
									<img id="change_captcha" style="cursor: pointer;float:left;padding-left: 10px; height:30px;" src="<?= base_url() ?>images/refresh.png" alt="refresh"/>
									
							   <input name="confirm"  type="text" class="in_rw_input captcha_txt" from-validation="required|captcha">
		
							</div>
							<div class="clear"></div>
							<div class="in_clm" style=" margin:0 0 0;">
		
							
							<div class="in_rw2">
								<input class="termscond" name="agree" type="text" style="display:none" value="yes"  from-validation="required"  />
							</div>
		
							<input style="margin: 0 13px 0 0; float:left;" checked="checked" class="" name="" value="yes" onchange="if($(this).is(':checked')){$('.termscond').val($(this).val())}else{$('.termscond').val('')}" type="checkbox" />
		
		<div class="in_rw1 txt_terms_cond" style="width:auto; margin:0px; padding-bottom:20px;"> Agree <a href="<?php echo base_url().'terms-condition' ?>" target="_blank">Terms & Conditions</a></div>
						</div>
						
						
						<div class="clear"></div>
						<div class="in_clm">
							<div class="in_rw1" style=" margin:5px 0 0;">&nbsp;</div>
							<div class="in_rw2" >
								<input class="in_rw_submit2" style="margin-left:0px;" name="Submit" type="submit" onclick="validate_signup_form_popup()" value="Submit" />
							</div>
						</div>
						<div class="clear"></div>
						
							</div>
							
							<div class="separator"><div>OR</div></div>
							
							<div class="facebook">
								<div >
									<a href="javascript:void(0);">
									<img onclick='facebook_connect_init()' src="<?= base_url() ?>images/social-icon3.png" height="37" alt="social" />					
									</a>
								</div>
								<h2>Why Join Us ?</h2>
					
					<ol>
					<li>Free to join and use</li>
					<li>Get Rs 50 joining bonus</li>
					<li>Save &amp; Earn at 1,000+ top brands</li>
					<li>Refer and Earn 10% for life</li>
					</ol>
							</div>	
							<div class="clear"></div>						
								
						</form>
					 </div>
				 </div>
  			</div>

			<div id="tabs-2">
			   <div class="input_fiela_box">
				  <form action="<?=  base_url()?>user/login" method="post" class="signin_form_popup" onsubmit="return false;">
				  <h1>Sign In</h1>
				  <input class="choosen_deal_id" type="hidden" value="xxxx" name="choosen_deal_id">
				  <input class="choosen_type" type="hidden" value="xxxx" name="choosen_type">
				  		
						<div class="form_box">
						  
						  <div class="in_clm">
							  <div class="in_rw1">Email Address: <span class="red_star">*</span></div>
							  <div class="in_rw2">
							  <input name="email" type="text" class="in_rw_input" from-validation="required|email">
							  </div>
							  <div class="clear"></div>
						  </div>
						  <div class="clear"></div>
		
						  <div class="in_clm">
							  <div class="in_rw1">Password: <span class="red_star">*</span></div>
							  <div class="in_rw2">
							  <input name="password" autocomplete="off"  type="password" class="in_rw_input" from-validation="required">
							  </div>
							  <div class="clear"></div>
						  </div>
						  <div class="clear"></div>
		
						  <div class="in_clm">
							<div class="in_rw1">&nbsp;</div>
							<div class="in_rw2">
							  <input class="in_rw_submit2" style="margin-left:0px;" name="Submit" type="submit" onclick="validate_login_form_popup()" value="Submit" />
							  <div class="link"><a href="<?php echo base_url().'user/forget_password';?>">Forgot Your Password?</a></div>
							</div>
						  </div>
						  <div class="clear"></div>
						  
						</div>
						
						<div class="separator"><div>OR</div></div>
						
						  <div class="facebook">
							<div >
								<a href="javascript:void(0);">
								<img onclick='facebook_connect_init()' src="<?= base_url() ?>images/social-icon3.png" height="37" alt="social" />					
								</a>
							</div>
						</div>
						
						<div class="clear"></div>
										

	  				</form>
		
				</div>		
			</div>		
		  </div>
            </div>
         </div>
     </div>
	 <!-- SIGN UP & LOGIN -->

	<!-- CASHBACK DETAILS -->
   	<div class="shadowWrapper2" style="display: none">

         <div class="shadowWrapperContent">

             <img class="closeShadow" onclick="$('.shadowWrapper2').hide();" src="<?=  base_url()?>images/close-wrapper.png">

            <div class="shadowWrapperContentBody" style="padding:10px; min-height:150px;">  

			<h1>Cash Back Details</h1>
             <p style="line-height:20px;"><?php echo $store_details[0]['s_cash_back_details']?> </p>

            </div>

         </div>

     </div>
	 <!-- CASHBACK DETAILS -->
	 
	<!-- PRICE ALERT -->
	<div class="shadowWrapperAlert" style="display: none; ">
         <div class="shadowWrapperContent">
             <img class="closeShadow" onclick="$('.shadowWrapperAlert').hide();" src="<?=  base_url()?>images/close-wrapper.png">

            <div class="shadowWrapperContentBody" style="padding:15px; width:600px;">  
				 <h1>Set Price Alert</h1>
				 <div class="price_pic">
				 	<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
	<tr>
		<td height="100%" align="center" valign="middle"><img src="" id="price_img" alt="" /></td>
	</tr>
</table>

					
					
					
				 </div>
				 <div class="price_content">
					 <h1 class="s_title"></h1>
					  <h3 >Rs. <span class="org_price"></span></h3>
				
						 <form name="frm_alert" id="frm_alert" class="frm_alert" action="<?=  base_url()?>home/save_price_alert" method="post" onsubmit="return false;">		
						 <input type="hidden" name="h_deal_id" id="h_deal_id"	 /> 
							
							<div class="in_rw1" >Price:</div>	
							
							<input type="text" value="" class="less_price in_rw_input" name="less_price" id="less_price" from-validation="required|less_price"/>
							
								<div class="clear"></div>	
							<div class="in_rw1" >&nbsp;</div>	<span>Notify me when the price drops to or below</span>
							<div class="clear"></div>	
						
							
						
							<div class="in_rw1" >Email Address:</div>	
					
							<input name="email" type="text" class="in_rw_input" value="" from-validation="required|email">
						
							<div class="clear"></div>	
							
							
							<div class="clear"></div>
							<input class="in_rw_submit2" name="btn_alert" type="button" onclick="validate_price_alert()" value="Submit" />
							
							<!--<div class="in_clm">			
							<div class="in_rw1">&nbsp;</div>			
							<div class="in_rw2">			
							<input class="in_rw_submit" name="btn_alert" type="button" onclick="validate_price_alert()" value="Submit" />
							</div>			
							</div>			
							<div class="clear"></div>-->
						 </form>
			
				 </div>
				 
				 <div class="clear"></div>
            </div>
         </div>
     </div>
	<!-- PRICE ALERT -->
	 
	<!-- FACEBOOK , TWITTER , GOOGLE+ SHARE -->
	<div class="shadowWrapperShare" style="display: none; ">
         <div class="shadowWrapperContent">
             <img class="closeShadow" onclick="$('.shadowWrapperShare').hide();" src="<?=  base_url()?>images/close-wrapper.png">

            <div class="shadowWrapperContentBody" style="padding:15px; width:600px; min-height:400px;">  
				 <h1>Share Box</h1>
				 <div style="float:left; width:195px; margin-top:10px;">
				 	<img src="" id="prod_img" />
				 </div>
				 <div style="float:left; width:355px; margin-left:10px; margin-top:10px; ">
					 <h1 id="s_title"></h1>
					 
					 <div class="follw" style="margin-bottom:10px;">                            
						<a id="ref_fb" target="_blank"  href="" onclick="javascript:window.open(this.href, 'sharer', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600'); return false;">
<img src="<?php echo base_url().'images/fbshare.jpg' ?>" alt=""/></a>
                     </div>
					 
					 <div class="follw" style="margin-bottom:10px;">                            
						<a id="ref_tw" href=""  onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false;"><img src="<?php echo base_url().'images/twshare.jpg' ?>" alt=""/></a>
                     </div>
					 
					 <div class="follw" style="margin-bottom:10px;">                            
						<a id="ref_gp" href=""
onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false"><img src="<?php echo base_url().'images/gpshare.jpg' ?>" alt=""/></a>
                     </div>
					 
				 </div>
            </div>
         </div>
     </div>
	<!-- FACEBOOK , TWITTER , GOOGLE+ SHARE -->

<!-- ############ Loading Section [Start] ########### -->
    <?php /*?><div id="loading_dialog" class="modal_dialog" style="width:auto;padding:20px; background:transparent;border:none; display:none;"> <img src="<?= base_url() ?>images/loading_big.gif" width="50"/> </div><?php */?>
	<div id="loading_dialog" class="modal_dialog" style="height: 80px;
   width: 300px;
   background:#cfcabe;border:none; 
   position: absolute;
   z-index: 1000;
   left: 50%;
   border-radius:5px;
   top: 0%;text-align:center;display:none;"> <img style="margin: 15px 0px 0px 50px;" align="left" src="<?= base_url() ?>images/loading.gif" height="50" width="50"/> <span style="display: inline-block; float: left; margin: 30px 0px 0px; width: 150px; font-family: arial; font-size: 17px;">Please Wait</span></div>
<!-- ############ Loading Section [End] ########### -->

<?php include_once(APPPATH."views/common/facebook_js.php"); ?> 
</body>

</html>



