<?php 
$this->load->view('site/templates/header.php');
?>
<?php if($flash_data != '') { ?>
		<div class="errorContainer" id="<?php echo $flash_data_type;?>">
			<script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 3000);</script>
			<p><span><?php echo $flash_data;?></span></p>
		</div>
		<?php } ?>
   <!-- Section_start -->
    
     	<section>
        
        	<div class="section_main" style="background: none;">
            
            	<div class="main2">
                
                		<div class="tab_product">
                        
                        	<ul class="tab_box">
                            
                            	<li><a class="tab_active" href="javascript:void(0);"><?php if($this->lang->line('cart_ord_confirm') != '') { echo stripslashes($this->lang->line('cart_ord_confirm')); } else echo "Order Confirmation"; ?></a></li>	                                
                            
                            
                            </ul>
                            
                        
                        </div>
                        
                        <div class="product_main" style="padding:0px; width:100%;">
                        	<div id="content" style=" border-radius: 0 0 0 0; box-shadow: none; padding: 0;">
        <ol class="cart-order-depth">
	      <li class="depth1"><span>1</span><?php if($this->lang->line('cart_shop_cart') != '') { echo stripslashes($this->lang->line('cart_shop_cart')); } else echo "Shopping Cart"; ?></li>
	      <li class="depth2"><span>2</span><?php if($this->lang->line('cart_pay_mthd') != '') { echo stripslashes($this->lang->line('cart_pay_mthd')); } else echo "Payment Method"; ?></li>
	      <li class="depth3 current"><span>3</span><?php if($this->lang->line('cart_ord_confirm') != '') { echo stripslashes($this->lang->line('cart_ord_confirm')); } else echo "Order Confirmation"; ?></li>
	    </ol>
            <div class="cart-list chept2" style="text-align:center;">
					
			<?php if($Confirmation =='Success'){ ?>                    
					<div class="cart-payment-wrap card-payment new-card-payment">
						<strong><?php if($this->lang->line('order_tran_sucss') != '') { echo stripslashes($this->lang->line('order_tran_sucss')); } else echo "Your Transaction Success"; ?></strong>
                        <div class="payment_success"><img src="images/site/success_payment.png" /></div>
					</div>
                    
            <?php
			 $this->output->set_header('refresh:5;url='.base_url().'purchases'); 
			 }elseif($Confirmation =='Failure'){ ?>        
            
            					<div class="cart-payment-wrap card-payment new-card-payment">
				<strong><?php if($this->lang->line('order_tran_failure') != '') { echo stripslashes($this->lang->line('order_tran_failure')); } else echo "Your Transaction Failure"; ?></strong>
                <div class="payment_success"><b><?php echo urldecode($errors); ?></b></div>
                        <div class="payment_success"><img src="images/site/failure_payment.png" /></div>
					</div>

            
            <?php
			 $this->output->set_header('refresh:5;url='.base_url().'cart'); 
			 } 
			 
			 if($this->uri->segment(3) == 'subscribe'){
			 	$this->output->set_header('refresh:5;url='.base_url().'fancyybox/manage'); 
			 }elseif($this->uri->segment(3) == 'gift'){
			 	$this->output->set_header('refresh:5;url='.base_url().'settings/giftcards'); 
			 }elseif($this->uri->segment(3) == 'cart'){
			 	$this->output->set_header('refresh:5;url='.base_url().'purchases'); 
			 }
			  ?>
            



				</div> 
             </div>
                        
                        </div>
                
                </div>
            
            
            
            </div>
        
        	
        	
        
		</section>
        
        
   <!-- Section_end -->
   

<?php 
     $this->load->view('site/templates/footer');
     ?>

	 