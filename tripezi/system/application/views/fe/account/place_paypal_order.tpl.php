<div id="main_container">
  <div id="container">
    <div id="wrapper">
	<!--header-->
	<?php
		// include header view-file...
		//include_once(APPPATH.'views/frontend/header.tpl.php');
	?>
	<!--header-->
      <div id="white_div">
		<div style="height:21px; clear:both;">
			<div class="white_l">
			</div>
			<div class="white_mid">
			</div>
			<div class="white_r">
			</div>
		</div>
		<div class="white_middle">
		<div class="IPN_style">
			<?php
				# paypal custom field validation...
				$CUSTOM_FLD = '';
			
				# 1st, to check the cart-status (empty or not)...
				//if( $this->cart->total_items() ) :
				
					//$paypal_obj->add_field('business', $paypal_account);
					#$paypal_obj->add_field('return', base_url() .'thank-you-page.html');
					$paypal_obj->add_field('return', base_url() .'booking/booking_successful/'.$s_booking_id);
					$paypal_obj->add_field('notify_url', base_url() .'booking/ipn_successful');
					$paypal_obj->add_field('cancel_return', base_url() .'booking/booking_failed');    
					$paypal_obj->add_field('image_url', base_url().'images/fe/logo.jpg');
                    
                    
                    /*$page_name['return']            =   base_url().'book-hotel-room/booking-success-paypal/'.$hotel_booking_detail['success_booking_unique_key'];
                    $page_name['cancel_return']     =   base_url().'book-hotel-room/booking-success';
                    $page_name['notify_url']        =   base_url().'book-hotel-room/paypal-ipn/'.$hotel_booking_detail['success_booking_unique_key'];
                                                    */
                    
                    
                    
                    
                    
                    
					
					$INDEX = 1;
					$ITEM_QTY = 1;
					$ITEM_ID_STR = '';
/*					foreach($cart_contents as $items)
					{
						# fixing paypal HTML variables one-by-one...
						$ITEM_PRICE = $items['price'];
						$ITEM_ID = $items['id'];
						$ITEM_NAME = $items['name'];
						$ITEM_QTY = $items['quantity'];
						
						$ITEM_ID_STR .= ( !empty($ITEM_ID_STR) )? '#'. $ITEM_ID: $ITEM_ID;
						
						$paypal_obj->add_field('item_name_'.$INDEX, $ITEM_NAME);
						$paypal_obj->add_field('amount_'.$INDEX, $ITEM_PRICE);
						$paypal_obj->add_field('quantity_'.$INDEX, $ITEM_QTY);
						
						$INDEX++;
						
					}*/
					$paypal_obj->add_field('item_name_'.$INDEX, $item_name);
					$paypal_obj->add_field('amount_'.$INDEX, $total_charge);
					$paypal_obj->add_field('quantity_'.$INDEX, $ITEM_QTY);
					
					$paypal_obj->add_field('shipping_'. ($INDEX-1), $shipping_charge);
					$paypal_obj->add_field('currency_code', $currency);
                   
					
				
				//endif;	// end of outermost if...
				
				$paypal_obj->submit_paypal_post(); // submit the fields to paypal
			?>
		</div>
		</div>
	  
		<div class="white_l1">
		</div>

		<div style="clear:both;">
		</div>
	  </div>