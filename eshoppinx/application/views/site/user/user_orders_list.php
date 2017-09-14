<?php $this->load->view('site/templates/header');?>

	<section>
        
        	<div class="section_main" style="background:none;">
            
            	<div class="main2">          
            	<div class="main_box">
                <div class="container set_area" style="padding:30px 0 20px">   	

		<?php if($flash_data != '') { ?>
		<div class="errorContainer" id="<?php echo $flash_data_type;?>">
			<script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 4000);</script>
			<p><span><?php echo $flash_data;?></span></p>
		</div>
		<?php } ?>
        
        <div id="sidebar">
			<dl class="set_menu">
				<dt><?php if($this->lang->line('referrals_account') != '') { echo stripslashes($this->lang->line('referrals_account')); } else echo "ACCOUNT"; ?></dt>
				<dd><a href="settings"><i class="ic-user"></i> <?php if($this->lang->line('referrals_profile') != '') { echo stripslashes($this->lang->line('referrals_profile')); } else echo "Profile"; ?></a></dd>
	            <dd><a href="settings/preferences"><i class="ic-pre"></i> <?php if($this->lang->line('referrals_preference') != '') { echo stripslashes($this->lang->line('referrals_preference')); } else echo "Preferences"; ?></a></dd>
				<dd><a href="settings/password"><i class="ic-pw"></i> <?php if($this->lang->line('signup_password') != '') { echo stripslashes($this->lang->line('signup_password')); } else echo "Password"; ?></a></dd>
				<dd><a href="settings/notifications"><i class="ic-noti"></i> <?php if($this->lang->line('referrals_notification') != '') { echo stripslashes($this->lang->line('referrals_notification')); } else echo "Notifications"; ?></a></dd>
			</dl>
			<dl class="set_menu">
				<dt><?php if($this->lang->line('referrals_shop') != '') { echo stripslashes($this->lang->line('referrals_shop')); } else echo "SHOP"; ?></dt>
	            <dd><a href="purchases" ><i class="ic-pur"></i> <?php if($this->lang->line('referrals_purchase') != '') { echo stripslashes($this->lang->line('referrals_purchase')); } else echo "Purchases"; ?></a></dd>
	            <?php if ($userDetails->row()->group == 'Seller'){?>
	            <dd><a href="orders" class="current"><i class="ic-group"></i> <?php if($this->lang->line('referrals_orders') != '') { echo stripslashes($this->lang->line('referrals_orders')); } else echo "Orders"; ?></a></dd>
	            <?php }?>
	            <?php if ($userDetails->row()->group == 'Seller'){?>
 	            <dd><a href="credits"><i class="ic-credit"></i> <?php if($this->lang->line('user_earning') != '') { echo stripslashes($this->lang->line('user_earning')); } else echo "Earnings"; ?></a></dd>
 	            <?php }?>
<!-- 	            <dd><a href="fancyybox/manage"><i class="ic-sub"></i> <?php if($this->lang->line('referrals_subscribe') != '') { echo stripslashes($this->lang->line('referrals_subscribe')); } else echo "Subscriptions"; ?></a></dd>
 -->	            <dd><a href="settings/shipping"><i class="ic-ship"></i> <?php if($this->lang->line('referrals_shipping') != '') { echo stripslashes($this->lang->line('referrals_shipping')); } else echo "Shipping"; ?></a></dd>
	        </dl>
			<dl class="set_menu">
				<dt><?php if($this->lang->line('referrals_sharing') != '') { echo stripslashes($this->lang->line('referrals_sharing')); } else echo "SHARING"; ?></dt>
<!-- 	            <dd><a href="credits"><i class="ic-credit"></i> Credits</a></dd>
	  -->           <dd><a href="referrals/0"><i class="ic-refer"></i> <?php if($this->lang->line('referrals_common') != '') { echo stripslashes($this->lang->line('referrals_common')); } else echo "Referrals"; ?></a></dd>
<?php 
if ($this->config->item('giftcard_status') == 'Enable'){
?> 
<!-- 				<dd><a href="settings/giftcards"><i class="ic-gift"></i> <?php if($this->lang->line('referrals_giftcard') != '') { echo stripslashes($this->lang->line('referrals_giftcard')); } else echo "Gift Card"; ?></a></dd>
 -->				<?php }
				if ($userDetails->row()->group == 'Seller'){?>
	            <dd><a href="<?php echo base_url();?>site/feed/store/<?php echo $userDetails->row()->user_name;?>" target="_blank"><i class="ic-group"></i> <?php if($this->lang->line('referrals_feedurl') != '') { echo stripslashes($this->lang->line('referrals_feedurl')); } else echo "Store Feed URL"; ?></a></dd>
	            <?php }?>
	        </dl>
		</div>
        
        <div id="content">
                <h2 class="ptit"><?php echo $heading;?></h2>
                <?php 
                if($ordersList->num_rows()>0){
                ?>	
                 <div class=" section gifts">
            <h3><?php if($this->lang->line('order_history') != '') { echo stripslashes($this->lang->line('order_history')); } else echo "Order history for your products"; ?>.</h3>
                	<div class="chart-wrap">
                    
                    	
                    
                    
            <table class="chart" id="orderListTable">
                <thead>
                    <tr>
                        <th class="shipping_default"><?php if($this->lang->line('purchases__invoice') != '') { echo stripslashes($this->lang->line('purchases__invoice')); } else echo "Invoice"; ?></th>
                        <th><?php if($this->lang->line('purchases__paystatus') != '') { echo stripslashes($this->lang->line('purchases__paystatus')); } else echo "Payment Status"; ?></th>
                        <th class="shipping_phone"><?php if($this->lang->line('purchases_shipstatus') != '') { echo stripslashes($this->lang->line('purchases_shipstatus')); } else echo "Shipping Status"; ?></th>
<!--                         <th><?php if($this->lang->line('purchases_total') != '') { echo stripslashes($this->lang->line('purchases_total')); } else echo "Total"; ?></th> -->
                        <th><?php if($this->lang->line('purchases_orddate') != '') { echo stripslashes($this->lang->line('order_date')); } else echo "Date"; ?></th>
                        <th><?php if($this->lang->line('purchases_option') != '') { echo stripslashes($this->lang->line('purchases_option')); } else echo "Option"; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ordersList->result() as $row){?>
                    <tr>
                        <td  class="shipping_default">#<?php echo $row->dealCodeNumber;?></td>
                        <td><?php echo $row->status;?></td>
                        
                        <td  class="shipping_default">
                        <select onchange="javascript:changeShipStatus(this.value,'<?php echo $row->dealCodeNumber;?>','<?php echo $row->sell_id;?>')">
                        	<option <?php if ($row->shipping_status == 'Pending'){echo 'selected="selected"';}?> value="Pending"><?php if($this->lang->line('order_pending') != '') { echo stripslashes($this->lang->line('order_pending')); } else echo "Pending"; ?></option>
                        	<option <?php if ($row->shipping_status == 'Processed'){echo 'selected="selected"';}?> value="Processed"><?php if($this->lang->line('order_processed') != '') { echo stripslashes($this->lang->line('order_processed')); } else echo "Processed"; ?></option>
                        	<option <?php if ($row->shipping_status == 'Delivered'){echo 'selected="selected"';}?> value="Delivered"><?php if($this->lang->line('order_delivered') != '') { echo stripslashes($this->lang->line('order_delivered')); } else echo "Delivered"; ?></option>
                        	<option <?php if ($row->shipping_status == 'Returned'){echo 'selected="selected"';}?> value="Returned"><?php if($this->lang->line('order_returnred') != '') { echo stripslashes($this->lang->line('order_returnred')); } else echo "Returned"; ?></option>
                        	<option <?php if ($row->shipping_status == 'Re-Shipped'){echo 'selected="selected"';}?> value="Re-Shipped"><?php if($this->lang->line('order_reshipp') != '') { echo stripslashes($this->lang->line('order_reshipp')); } else echo "Re-Shipped"; ?></option>
                        	<option <?php if ($row->shipping_status == 'Cancelled'){echo 'selected="selected"';}?> value="Cancelled"><?php if($this->lang->line('order_cancelled') != '') { echo stripslashes($this->lang->line('order_cancelled')); } else echo "Cancelled"; ?></option>
                        </select>
                        <img alt="Loading" style="display: none;" class="status_loading_<?php echo $row->dealCodeNumber;?>" src="images/site/ajax-loader.gif"/>
                        </td>
<!--                         <td><?php echo $row->TotalPrice;?></td>
      -->                   
                        <td><?php echo $row->created;?></td>
                        <td>
<!--                         <a target="_blank" href="view-order/<?php echo $row->sell_id;?>/<?php echo $row->dealCodeNumber;?>"><?php if($this->lang->line('purchases_view') != '') { echo stripslashes($this->lang->line('purchases_view')); } else echo "View"; ?></a> -->
                        <a style="color:green;" target="_blank" href="view-order/<?php echo $row->sell_id;?>/<?php echo $row->dealCodeNumber;?>"><?php if($this->lang->line('user_view_invoice') != '') { echo stripslashes($this->lang->line('user_view_invoice')); } else echo "View Invoice"; ?></a><br/>
                        <a style="color:red;" href="order-review/<?php echo $row->user_id;?>/<?php echo $row->sell_id;?>/<?php echo $row->dealCodeNumber;?>"><?php if($this->lang->line('user_buyer_discus') != '') { echo stripslashes($this->lang->line('user_buyer_discus')); } else echo "Buyer Discussion"; ?></a>
                        </td>
                    </tr>
                    <?php }?>
                    
                </tbody>
            </table>
			</div>
			</div>
                 <?php	
                }else {
                ?>
                <div class=" section purchases no-data">
                        <span class="icon"><i class="ic-gifts"></i></span>
                        <p><?php if($this->lang->line('order_no_products') != '') { echo stripslashes($this->lang->line('order_no_products')); } else echo "No orders on your products."; ?></p>
                </div>
                <?php 
                }
                ?>
        </div>

		
		</div>      
         </div>
            </div>
            </div>
		</section>
	
<?php $this->load->view('site/templates/footer');?>