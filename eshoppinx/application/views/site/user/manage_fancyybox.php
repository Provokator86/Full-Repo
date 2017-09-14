<?php
$this->load->view('site/templates/header');
?>
	<section>
        	<div class="section_main">
            	<div class="main2">  
            	<div class="main_box">        
                <div class="container set_area" style="padding:30px 0 20px">

        <div id="content">
                <h2 class="ptit"><?php if($this->lang->line('referrals_subscribe') != '') { echo stripslashes($this->lang->line('referrals_subscribe')); } else echo "Subscriptions"; ?></h2>
                <?php 
                if($subscribeList->num_rows()>0){
                ?>	
                 <div class=" section gifts">
            <h3><?php if($this->lang->line('manage_subsc_list') != '') { echo stripslashes($this->lang->line('manage_subsc_list')); } else echo "Your subscriptions list."; ?></h3>
                	<div class="chart-wrap">
            <table class="chart">
                <thead>
                    <tr>
                        <th><?php if($this->lang->line('purchases__invoice') != '') { echo stripslashes($this->lang->line('purchases__invoice')); } else echo "Invoice"; ?></th>
                        <th><?php if($this->lang->line('manage_subsname') != '') { echo stripslashes($this->lang->line('manage_subsname')); } else echo "Subscription Name"; ?></th>
                        <th><?php if($this->lang->line('purchases_total') != '') { echo stripslashes($this->lang->line('purchases_total')); } else echo "Total"; ?></th>
                        <th><?php if($this->lang->line('order_date') != '') { echo stripslashes($this->lang->line('order_date')); } else echo "Date"; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subscribeList->result() as $row){?>
                    <tr>
                        <td>#<?php echo $row->invoice_no;?></td>
                        <td><?php echo $row->name;?></td>
                        <td><?php echo $row->total;?></td>
                        
                        <td><?php echo $row->created;?></td>
                    </tr>
                    <?php }?>
                    
                </tbody>
            </table>
			</div>
			</div>
                <?php	
                }else {
                ?>
                <div class=" section subscription no-data">
		            <span class="icon"><i class="ic-sub"></i></span>
 		            <p><?php if($this->lang->line('manage_not_subs') != '') { echo stripslashes($this->lang->line('manage_not_subs')); } else echo "You haven't subscribed to anything yet."; ?><!--<br><a href="#">See the amazing Fancy Box</a>--></p> 
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
 	            <dd><a href="credits"><i class="ic-credit"></i> Earnings</a></dd>
 	            <?php }?>
<!-- 	            <dd><a href="fancyybox/manage" class="current"><i class="ic-sub"></i> <?php if($this->lang->line('referrals_subscribe') != '') { echo stripslashes($this->lang->line('referrals_subscribe')); } else echo "Subscriptions"; ?></a></dd>
 -->	            <dd><a href="settings/shipping"><i class="ic-ship"></i> <?php if($this->lang->line('referrals_shipping') != '') { echo stripslashes($this->lang->line('referrals_shipping')); } else echo "Shipping"; ?></a></dd>
	        </dl>
			<dl class="set_menu">
				<dt>SHARING</dt>
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
		 </div>      
         	 </div>
         </div>
         </div>
	</section>
<?php 
$this->load->view('site/templates/footer');
?>
