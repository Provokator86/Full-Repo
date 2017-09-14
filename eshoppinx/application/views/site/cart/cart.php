<?php 
$this->load->view('site/templates/header.php');
$this->load->view('site/templates/popup_templates.php');
?>
<link rel="stylesheet" media="all" type="text/css" href="css/site/<?php echo SITE_COMMON_DEFINE ?>setting.css"> 
   
<?php if($flash_data != '') { ?>
		<div class="errorContainer" id="<?php echo $flash_data_type;?>">
			<script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 3000);</script>
			<p><span><?php echo $flash_data;?></span></p>
		</div>
		<?php } ?>
   <!-- Section_start -->
    
     	<section>
        
        	<div class="section_main" style="background:none;">
            
            	<div class="main2">
                <div class="main_box">    
                		<div class="tab_product">
                        
                        	<ul class="tab_box">
                            
                            	<li><a class="tab_active" href="cart"><?php if($this->lang->line('common_cart') != '') { echo stripslashes($this->lang->line('common_cart')); } else echo "Cart"; ?></a></li>	                                
                            
                            
                            </ul>
                            
                            
                           <!-- <ul class="right_tab">
                            
                            	<li><a class="find_btn" href="people"><?php if($this->lang->line('cart_find_people') != '') { echo stripslashes($this->lang->line('cart_find_people')); } else echo "Find People"; ?></a></li>
                                
                                <li><a class="find_btn" href="stores"><?php if($this->lang->line('cart_find_stores') != '') { echo stripslashes($this->lang->line('cart_find_stores')); } else echo "Find Stores"; ?></a></li>
                            
                            
                            </ul>-->
                        
                        
                        </div>
                </div>        
                        <div class="product_main" style="padding:0px; width:100%;">
                        	<div id="content" style=" border-radius: 0 0 0 0; box-shadow: none; padding: 0;">
	    <ol class="cart-order-depth">
	      <li class="depth1 current"><span>1</span><?php if($this->lang->line('cart_shop_cart') != '') { echo stripslashes($this->lang->line('cart_shop_cart')); } else echo "Shopping Cart"; ?></li>
	      <li class="depth2"><span>2</span><?php if($this->lang->line('cart_pay_mthd') != '') { echo stripslashes($this->lang->line('cart_pay_mthd')); } else echo "Payment Method"; ?></li>
	      <li class="depth3"><span>3</span><?php if($this->lang->line('cart_ord_confirm') != '') { echo stripslashes($this->lang->line('cart_ord_confirm')); } else echo "Order Confirmation"; ?></li>
	    </ol>
            <div class="cart-list">
              
	      
              <div id="invitation-reminder" class="rounded-4" style="display:none;">
		<a href="#invitation-reminder" class="icon close_"><?php if($this->lang->line('onboarding_close') != '') { echo stripslashes($this->lang->line('onboarding_close')); } else echo "Close"; ?></a>
		<i class="icon avatar_plus_"></i>
		<a href="#" class="bttn blue"><?php if($this->lang->line('onboarding_invite_frd') != '') { echo stripslashes($this->lang->line('onboarding_invite_frd')); } else echo "Invite Friends"; ?></a>
		<p>
		  <strong><?php if($this->lang->line('cart_cash_back') != '') { echo stripslashes($this->lang->line('cart_cash_back')); } else echo "Invite your friends and earn cash back"; ?>.</strong>
		  <?php echo $siteTitle;?><?php if($this->lang->line('cart_is_great') != '') { echo stripslashes($this->lang->line('cart_is_great')); } else echo " is great for you, but so much better with friends!"; ?>
		</p>
	      </div>
              
	      <h2></h2>
	      <?php echo $cartViewResults; ?>
	      
	      
	    </div>
	  </div>
                        
                        </div>
                
                </div>
            
            
            
            </div>
        
        	
        	
        
		</section>
        
        
   <!-- Section_end -->
   
<script type="text/javascript" src="js/site/jquery.validate.js"></script>
<script type="text/javascript" src="js/site/<?php echo SITE_COMMON_DEFINE ?>selectbox.js"></script>
<script type="text/javascript" src="js/site/<?php echo SITE_COMMON_DEFINE ?>shoplist.js"></script>
<script type="text/javascript" src="js/site/<?php echo SITE_COMMON_DEFINE ?>address_helper.js"></script>

<script>
	$("#shippingAddForm").validate();
	
	jQuery(function($) {
		var $select = $('.gift-recommend select.select-round');
		$select.selectBox();
		$select.each(function(){
			var $this = $(this);
			if($this.css('display') != 'none') $this.css('visibility', 'visible');
		});
	});
</script>
<script>
    //emulate behavior of html5 textarea maxlength attribute.
    jQuery(function($) {
        $(document).ready(function() {
            var check_maxlength = function(e) {
                var max = parseInt($(this).attr('maxlength'));
                var len = $(this).val().length;
                if (len > max) {
                    $(this).val($(this).val().substr(0, max));
                }
                if (len >= max) {
                    return false;
                }
            }
            $('textarea[maxlength]').keypress(check_maxlength).change(check_maxlength);
            
            
        });
    });
</script>
<?php 
     $this->load->view('site/templates/footer');
     ?>
