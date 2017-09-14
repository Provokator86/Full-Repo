<?php
$this->load->view('site/templates/header');
?>
<link rel="stylesheet" href="css/site/setting.css" type="text/css" media="all"/>
	<section>
        	<div class="section_main">
            	<div class="main2">     
            	<div class="main_box">     
                <div class="container set_area" style="padding:30px 0 20px">
<div id="content">
		<h2 class="ptit"><?php if($this->lang->line('giftcard_cards') != '') { echo stripslashes($this->lang->line('giftcard_cards')); } else echo "Gift Cards"; ?></h2>
<?php 
                if($giftcardsList->num_rows()>0){
                ?>	
                 <div class=" section gifts">
            <h3><?php if($this->lang->line('giftcard_urlist') != '') { echo stripslashes($this->lang->line('giftcard_urlist')); } else echo "Your giftcards list"; ?>.</h3>
                	<div class="chart-wrap">
            <table class="chart">
                <thead>
                    <tr>
                        <th><?php if($this->lang->line('giftcard_code') != '') { echo stripslashes($this->lang->line('giftcard_code')); } else echo "Code"; ?></th>
                        <th><?php if($this->lang->line('giftcard_sendername') != '') { echo stripslashes($this->lang->line('giftcard_sendername')); } else echo "Sender Name"; ?></th>
                        <th><?php if($this->lang->line('giftcard_sender_mail') != '') { echo stripslashes($this->lang->line('giftcard_sender_mail')); } else echo "Sender Mail"; ?></th>
                        <th><?php if($this->lang->line('giftcard_price') != '') { echo stripslashes($this->lang->line('giftcard_price')); } else echo "Price"; ?></th>
                        <th><?php if($this->lang->line('giftcard_expireson') != '') { echo stripslashes($this->lang->line('giftcard_expireson')); } else echo "Expires on"; ?></th>
                        <th><?php if($this->lang->line('giftcard_card_stats') != '') { echo stripslashes($this->lang->line('giftcard_card_stats')); } else echo "Card Status"; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($giftcardsList->result() as $row){
                    	$status = $row->card_status;
                    	if ($status == 'not used'){
                    		$expDate = strtotime($row->expiry_date);
                    		if ($expDate<time()){
                    			$status = 'expired';
                    		}
                    	}
                    ?>
                    <tr>
                        <td><?php echo $row->code;?></td>
                        <td><?php echo $row->sender_name;?></td>
                        <td><?php echo $row->sender_mail;?></td>
                        <td><?php echo $row->price_value;?></td>
                        <td><?php echo $row->expiry_date;?></td>
                        <td><?php echo ucwords($status);?></td>
                    </tr>
                    <?php }?>
                    
                </tbody>
            </table>
			</div>
            <p>
				<a href="gift-cards"><?php if($this->lang->line('giftcard_send') != '') { echo stripslashes($this->lang->line('giftcard_send')); } else echo "Send a Gift Card"; ?></a>
<!-- 				<span>or</span>
				<a href="gift-card/redeem">Redeem a Gift Card</a>
 -->			</p>
			</div>
                <?php	
                }else {
                ?>
		<div class="section giftcard no-data">
			
			<span class="icon"><i class="ic-card"></i></span>
			<p>
				<?php if($this->lang->line('giftcard_not_receive') != '') { echo stripslashes($this->lang->line('giftcard_not_receive')); } else echo "You haven't received any gift cards yet"; ?>.
				<br>
				<a href="gift-cards"><?php if($this->lang->line('giftcard_send') != '') { echo stripslashes($this->lang->line('giftcard_send')); } else echo "Send a Gift Card"; ?></a>
<!-- 				<span>or</span>
				<a href="gift-card/redeem">Redeem a Gift Card</a>
	 -->		</p>
			
		</div>
		 <?php 
                }
                ?>
	</div>
<div id="sidebar">
			<dl class="set_menu">
				<dt><?php if($this->lang->line('referrals_account') != '') { echo stripslashes($this->lang->line('referrals_account')); } else echo "ACCOUNT"; ?></dt>
				<dd><a href="settings"><i class="ic-user"></i> <?php if($this->lang->line('referrals_profile') != '') { echo stripslashes($this->lang->line('referrals_profile')); } else echo "Profile"; ?></a></dd>
	            <dd><a href="settings/preferences"><i class="ic-pre"></i> <?php if($this->lang->line('referrals_preference') != '') { echo stripslashes($this->lang->line('referrals_preference')); } else echo "Preferences"; ?></a></dd>
				<dd><a href="settings/password" ><i class="ic-pw"></i> <?php if($this->lang->line('signup_password') != '') { echo stripslashes($this->lang->line('signup_password')); } else echo "Password"; ?></a></dd>
				<dd><a href="settings/notifications" ><i class="ic-noti"></i> <?php if($this->lang->line('referrals_notification') != '') { echo stripslashes($this->lang->line('referrals_notification')); } else echo "Notifications"; ?></a></dd>
			</dl>
			<dl class="set_menu">
				<dt><?php if($this->lang->line('referrals_shop') != '') { echo stripslashes($this->lang->line('referrals_shop')); } else echo "SHOP"; ?></dt>
	            <dd><a href="purchases"><i class="ic-pur"></i> <?php if($this->lang->line('referrals_purchase') != '') { echo stripslashes($this->lang->line('referrals_purchase')); } else echo "Purchases"; ?></a></dd>
	            <?php if ($userDetails->row()->group == 'Seller'){?>
	            <dd><a href="orders"><i class="ic-group"></i> <?php if($this->lang->line('referrals_orders') != '') { echo stripslashes($this->lang->line('referrals_orders')); } else echo "Orders"; ?></a></dd>
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
<!-- 				<dd><a href="settings/giftcards" class="current"><i class="ic-gift"></i> <?php if($this->lang->line('referrals_giftcard') != '') { echo stripslashes($this->lang->line('referrals_giftcard')); } else echo "Gift Card"; ?></a></dd>
 -->				<?php }
				if ($userDetails->row()->group == 'Seller'){?>
	            <dd><a href="<?php echo base_url();?>site/feed/store/<?php echo $userDetails->row()->user_name;?>" target="_blank"><i class="ic-group"></i> <?php if($this->lang->line('referrals_feedurl') != '') { echo stripslashes($this->lang->line('referrals_feedurl')); } else echo "Store Feed URL"; ?></a></dd>
	            <?php }?>
	        </dl>
		</div>
</div>      
         	 </div>
         </div>
         </div>
	</section>		
<?php 
$this->load->view('site/templates/footer');
?>
