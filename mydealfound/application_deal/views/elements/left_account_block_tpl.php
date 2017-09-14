<div class="ac_info" style="border:none;">
    <div class="er_1st" style="border-bottom:none;">
        <?php /*?><div class="ac_sub_heading">My Activity</div>
        <? foreach ($earningData as $earningKey => $earningMeta): ?>

            <div class="earning">
                <div class="earning_left"><?= $earningKey ?></div>
                <div class="earning_right" style="font-size:12px;"><?= $earningMeta ?></div>
                <div class="clear"></div>
            </div>
        <? endforeach; ?><?php */?>
		<div class="account_panel">
			<div class="boxes">
				<h3>Account Settings</h3>
				<div class="boxes_content">
					<ul>
						<li><a <?php if($lft_mnu==1){?> class="active" <?php } ?> href="<?php echo base_url().'user/details';?>">Personal Details</a></li>
						<li><a <?php if($lft_mnu==2){?> class="active" <?php } ?>  href="<?php echo base_url().'user/payment';?>">Payment Settings</a></li>
						<li><a <?php if($lft_mnu==3){?> class="active" <?php } ?>  href="<?php echo base_url().'user/password';?>">Change Password</a></li>
					</ul>
				</div>
			</div>
			
			<div class="boxes">
				<h3>My Earning</h3>
				<div class="boxes_content">
					<ul>
						<li><a <?php if($lft_mnu==4){?> class="active" <?php } ?>  href="<?php echo base_url().'user/earning';?>">Earning</a></li>
						<li><a  <?php if($lft_mnu==5){?> class="active" <?php } ?>  href="<?php echo base_url().'user/withdraw';?>">Withdraw Money</a></li>
					</ul>
				</div>
			</div>
			
			<?php /*?><div class="boxes">
				<h3>My Payment</h3>
				<div class="boxes_content">
					<ul>
						<li><a <?php if($lft_mnu==6){?> class="active" <?php } ?>  href="<?php echo base_url().'user/mypayment';?>">Payment</a></li>
					</ul>
				</div>
			</div><?php */?>
			
			<div class="boxes">
				<h3>Refer Friends</h3>
				<div class="boxes_content">
					<ul>
						<li><a <?php if($lft_mnu==7){?> class="active" <?php } ?>  href="<?php echo base_url().'user/invite';?>">Refer Friends</a></li>
						<li><a <?php if($lft_mnu==8){?> class="active" <?php } ?>  href="<?php echo base_url().'user/referrals';?>">My Referrals</a></li>
					</ul>
				</div>
			</div>
			
			<div class="boxes">
				<h3>My Deals</h3>
				<div class="boxes_content">
					<ul>
						<li><a <?php if($lft_mnu==9){?> class="active" <?php } ?>  href="<?php echo base_url().'user/favouritelist';?>">Favourite Deals</a></li>
						<?php /*?><li><a <?php if($lft_mnu==10){?> class="active" <?php } ?>  href="<?php echo base_url().'user/subscribedeals';?>">Subscribed Deals</a></li>
						<li><a href="javascript:void(0);">Tracked</a></li><?php */?>
					</ul>
				</div>
			</div>
			
		</div>
		
		 	<?php /*?> Below New menus added 18Mar 2014<?php */?>
			<?php /*?><div class="ac_sub_heading">Account Settings</div>
            <div class="earning">
                <div class="earning_left"><a href="<?php echo base_url().'user/details';?>">Personal Details</a></div>
                <div class="clear"></div>
            </div>
			<div class="earning">
                <div class="earning_left"><a href="javascript:">Payment Settings</a></div>
                <div class="clear"></div>
            </div>
			<div class="earning">
                <div class="earning_left"><a href="<?php echo base_url().'user/password';?>">Change Password</a></div>
                <div class="clear"></div>
            </div>
			
			<div class="ac_sub_heading">My Earning</div>
            <div class="earning">
                <div class="earning_left"><a href="javascript:">My Earning</a></div>
                <div class="clear"></div>
            </div>
			
			<div class="ac_sub_heading">Payment</div>
			<div class="earning">
                <div class="earning_left"><a href="javascript:">Payment</a></div>
                <div class="clear"></div>
            </div>
			<div class="ac_sub_heading">Refer Friends</div>
			<div class="earning">
                <div class="earning_left"><a href="javascript:">Refer Friends</a></div>
                <div class="clear"></div>
            </div>
			
			<div class="ac_sub_heading">Deals</div>
            <div class="earning">
                <div class="earning_left"><a href="<?php echo base_url().'user/favouritedeals';?>">Favourite Deals</a></div>
                <div class="clear"></div>
            </div>
			<div class="earning">
                <div class="earning_left"><a href="<?php echo base_url().'user/subscribedeals';?>">My Subscribed Deals</a></div>
                <div class="clear"></div>
            </div>
			<div class="earning">
                <div class="earning_left"><a href="<?php echo base_url().'user/trackdeals';?>">Tracked</a></div>
                <div class="clear"></div>
            </div><?php */?>
			
			<?php /*?>Below New menus added 18Mar 2014<?php */?>
        
    </div>

    <?php /*?><div class="er_1st">
        <div class="ac_sub_heading"><?php echo $earningCms['s_title'] ?></div>
        <div class="earning"><?php cho $earningCms['s_description'] ?></div>
    </div><?php */?>
	

	
</div>