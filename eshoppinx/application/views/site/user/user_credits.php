<?php
$this->load->view('site/templates/header');
?>
	<section>
        	<div class="section_main" style="background:none;">
            	<div class="main2">     
            	<div class="main_box">     
                <div class="container set_area" style="padding:30px 0 20px">
		 <?php 
	   		$credits_mine = str_replace("{SITENAME}",$siteTitle,$this->lang->line('credit_mine'));
			$credit_earn_credit = str_replace("{SITENAME}",$siteTitle,$this->lang->line('credit_earn_credit'));
	   ?>
       
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
	            <dd><a href="orders"><i class="ic-group"></i> <?php if($this->lang->line('referrals_orders') != '') { echo stripslashes($this->lang->line('referrals_orders')); } else echo "Orders"; ?></a></dd>
	            <?php }?>
	            <?php if ($userDetails->row()->group == 'Seller'){?>
 	            <dd><a href="credits" class="current"><i class="ic-credit"></i><?php if($this->lang->line('user_earning') != '') { echo stripslashes($this->lang->line('user_earning')); } else echo "Earnings"; ?> </a></dd>
 	            <?php }?>
<!-- 	            <dd><a href="fancyybox/manage"><i class="ic-sub"></i> <?php if($this->lang->line('referrals_subscribe') != '') { echo stripslashes($this->lang->line('referrals_subscribe')); } else echo "Subscriptions"; ?></a></dd>
 -->	            <dd><a href="settings/shipping"><i class="ic-ship"></i> <?php if($this->lang->line('referrals_shipping') != '') { echo stripslashes($this->lang->line('referrals_shipping')); } else echo "Shipping"; ?></a></dd>
	        </dl>
			<dl class="set_menu">
				<dt><?php if($this->lang->line('referrals_sharing') != '') { echo stripslashes($this->lang->line('referrals_sharing')); } else echo "SHARING"; ?></dt>
	            <dd><a href="referrals/0"><i class="ic-refer"></i> <?php if($this->lang->line('referrals_common') != '') { echo stripslashes($this->lang->line('referrals_common')); } else echo "Referrals"; ?></a></dd>
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

<!-- 		<h2 class="ptit"><?php if($this->lang->line('credit_mine') != '') { echo $credits_mine; } else echo "My".$siteTitle."Credits"; ?></h2> -->
		<h2 class="ptit"><?php if($this->lang->line('user_earnings') != '') { echo stripslashes($this->lang->line('user_earnings')); } else echo "My Earnings"; ?></h2>
		<div class="section credit">
<!-- 			<p class="status"><?php if($this->lang->line('credit_availble') != '') { echo stripslashes($this->lang->line('credit_availble')); } else echo "Available Credits"; ?><br> -->
			<p class="status"><?php if($this->lang->line('credit_totearn') != '') { echo stripslashes($this->lang->line('credit_totearn')); } else echo "Total Earned"; ?><br>
			<b><?php echo $currencySymbol;?><?php echo number_format($except_refunded,2);?> <?php echo $currencyType;?></b><br>
			</p>
<!-- 			<h3><?php if($this->lang->line('credit_summary') != '') { echo stripslashes($this->lang->line('credit_summary')); } else echo "Credit Summary"; ?></h3>
			<p><?php echo $siteTitle;?> <?php if($this->lang->line('credit_purchase_checkout') != '') { echo stripslashes($this->lang->line('credit_purchase_checkout')); } else echo "Credits can be applied on your purchases during checkout."; ?></p>
 -->			<ul class="credit-step">
<!-- 				<li><b><?php echo $currencySymbol;?>0.00</b> <?php if($this->lang->line('credit_totearn') != '') { echo stripslashes($this->lang->line('credit_totearn')); } else echo "Total Earned"; ?></li>
				<li><b><?php echo $currencySymbol;?>0.00</b> <?php if($this->lang->line('credit_availsoon') != '') { echo stripslashes($this->lang->line('credit_availsoon')); } else echo "Available Soon"; ?> [<span class="tooltip">?<small><b></b><strong><?php if($this->lang->line('credit_creavailsoon') != '') { echo stripslashes($this->lang->line('credit_creavailsoon')); } else echo "Credits Available Soon"; ?></strong><br><?php if($this->lang->line('credit_aftership_order') != '') { echo stripslashes($this->lang->line('credit_aftership_order')); } else echo "Credits are applied to your account 30 days after the order ships."; ?></small></span>]</li>
				<li><b><?php echo $currencySymbol;?>0.00</b> <?php if($this->lang->line('credit_earned_refer') != '') { echo stripslashes($this->lang->line('credit_earned_refer')); } else echo "Earned via Referral"; ?></li>
				<li><b><?php echo $currencySymbol;?>0.00</b> <?php if($this->lang->line('credit_via_invites') != '') { echo stripslashes($this->lang->line('credit_via_invites')); } else echo "Earned via Invites"; ?></li>
-->				<li><b><?php echo $total_orders;?></b><?php if($this->lang->line('user_total_orders') != '') { echo stripslashes($this->lang->line('user_total_orders')); } else echo "Total Orders"; ?> </li>
				<li><b><?php echo $currencySymbol;?><?php echo number_format($total_amount,2);?></b><?php if($this->lang->line('user_total_amount') != '') { echo stripslashes($this->lang->line('user_total_amount')); } else echo "Total Amount"; ?> </li>
				<li><b><?php echo $currencySymbol;?><?php echo number_format($userDetails->row()->refund_amount,2);?></b> <?php if($this->lang->line('user_refunded_amount') != '') { echo stripslashes($this->lang->line('user_refunded_amount')); } else echo "Refunded Amount"; ?></li>
				<li><b><?php echo $currencySymbol;?><?php echo number_format($except_refunded,2);?></b><?php if($this->lang->line('user_except_refunded') != '') { echo stripslashes($this->lang->line('user_except_refunded')); } else echo "Except Refunded"; ?> </li>
			</ul>
			<ul class="credit-step">
				<li><b><?php echo $currencySymbol;?><?php echo number_format($commission_to_admin,2);?></b> <?php if($this->lang->line('user_commission_to') != '') { echo stripslashes($this->lang->line('user_commission_to')); } else echo "Commission to"; ?><?php echo $siteTitle;?></li>
				<li><b><?php echo $currencySymbol;?><?php echo number_format($amount_to_vendor,2);?></b><?php if($this->lang->line('user_except_commission') != '') { echo stripslashes($this->lang->line('user_except_commission')); } else echo "Except Commission"; ?> </li>
				<li><b><?php echo $currencySymbol;?><?php echo number_format($paid_to,2);?></b> <?php if($this->lang->line('user_received_amount') != '') { echo stripslashes($this->lang->line('user_received_amount')); } else echo "Received Amount"; ?></li>
				<li><b><?php echo $currencySymbol;?><?php echo number_format($paid_to_balance,2);?></b><?php if($this->lang->line('user_pending_amount') != '') { echo stripslashes($this->lang->line('user_pending_amount')); } else echo "Pending Amount"; ?> </li>
			</ul>
<!-- 			<h4><?php if($this->lang->line('credit_history') != '') { echo stripslashes($this->lang->line('credit_history')); } else echo "Credits History"; ?></h4> -->
			<h4><?php if($this->lang->line('user_received_history') != '') { echo stripslashes($this->lang->line('user_received_history')); } else echo "Received History"; ?></h4>
			<table class="simple">
				<colgroup>
					<col width="110">
					<col width="300">
					<col>
					<col width="90">
				</colgroup>
				<thead>
					<tr>
						<th><?php if($this->lang->line('user_transaction_id') != '') { echo stripslashes($this->lang->line('user_transaction_id')); } else echo "Transaction Id"; ?></th>
<!-- 						<th><?php if($this->lang->line('credit_type') != '') { echo stripslashes($this->lang->line('credit_type')); } else echo "Type"; ?></th> -->
						<th><?php if($this->lang->line('user_payment_type') != '') { echo stripslashes($this->lang->line('user_payment_type')); } else echo "Payment Type"; ?></th>
						<th><?php if($this->lang->line('order_date') != '') { echo stripslashes($this->lang->line('order_date')); } else echo "Date"; ?></th>
						<th><?php if($this->lang->line('credit_amount') != '') { echo stripslashes($this->lang->line('credit_amount')); } else echo "Amount"; ?></th>
					</tr>
				</thead>
				<tbody>
<?php 
if ($paidDetailsList->num_rows()>0){
	foreach ($paidDetailsList->result() as $paidDetailsListRow){
?>
					<tr>
						<td>#<?php echo $paidDetailsListRow->transaction_id;?></td>
						<td><?php echo $paidDetailsListRow->payment_type;?></td>
						<td><?php echo $paidDetailsListRow->date;?></td>
						<td><?php echo $paidDetailsListRow->amount;?></td>
					</tr>				
<?php 
	}
}else {
?>                    
                    <tr>
                        <td colspan="4" class="no-data"><?php if($this->lang->line('credit_no_history') != '') { echo stripslashes($this->lang->line('credit_no_history')); } else echo "No history found."; ?></td>
                    </tr>
<?php 
}
?>                    
				</tbody>
			</table>
		</div>
	</div>

        </div>      
         	 </div>
         </div>
         </div>
	</section>
<?php 
$this->load->view('site/templates/footer');
?>
