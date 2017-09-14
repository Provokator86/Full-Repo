<div class="clear"></div>
<div class="top_add_de"><img src="<?=base_url();?>images/ad_top.jpg"></div>
<div class="clear"></div>
<div class="content">
    <div class="account_section">
		<div class="pro">
            <div class="account_left">
				<!--<div class="pro_left_heading">My Account</div>-->
			<?php echo $this->load->view('elements/left_account_block_tpl.php');?>

			</div>
			<div class="account_right">
				<div class="account_box">				       
					<h1><?php echo $title; ?></h1>
					<div class="clear"></div>
				<div class="earn_details">
				
					<? foreach ($earningData as $earningKey => $earningMeta): ?>
			
						<div class="child_div">
							<span class="f_lft"><?= $earningKey ?></span>
							<span class="f_rt"><?= $earningMeta ?></span>
							<div class="clear"></div>
						</div>
					<? endforeach; ?>
					
					<?php /*?><div class="child_div">
						<span class="f_lft">Cashback Earnings:</span> 
						<span class="f_rt">Rs <?php echo $total_cashback_earn?$total_cashback_earn:"0.00";?></span>
						<div class="clear"></div>
					</div>
					
					<div class="child_div">
						<span class="f_lft">Paid Earnings:</span> 
						<span class="f_rt">Rs <?php echo $total_paid_earn?$total_paid_earn:"0.00";?></span>
						<div class="clear"></div>
					</div>
					
					<div class="child_div">
						<span class="f_lft">Referral Earnings:</span> 
						<span class="f_rt">Rs <?php echo $total_ref_earn?$total_ref_earn:"0.00";?></span>
						<div class="clear"></div>
					</div>
					
					<div class="child_div">
						<span class="f_lft">Available Earnings:</span> 
						<span class="f_rt">Rs <?php echo $total_pending_earn?$total_pending_earn:"0.00";?></span>
						<div class="clear"></div>
					</div><?php */?>
					
				</div>
					
					<div class="clear"></div>
						
					<div id="pay_tabs">
					  <ul>
						<li><a href="#tabs-1">Direct Earning</a></li>
						<li><a href="#tabs-2">Referral Earning</a></li>
						<li><a href="#tabs-3">Withdrawl</a></li>
					  </ul>
					  <!-- START TAB #1 -->
					  <div id="tabs-1">	
					  							
						<div class="list_box">
							<table>
								<tbody>
									<tr>
										<th class="myClickTH">Date</th>
										<!--<th class="myClickTH">Product</th>-->
										<th class="myClickTH">Store</th>
										<th class="myClickTH">Cashback</th>
										<th class="myClickTH">Status</th>
									</tr>
									<?php if($direct_earning) {
										
										foreach($direct_earning as $key=>$val)
											{								
									 ?>
									<tr class="oddEventr">
										<td><?php echo date('F d, Y',strtotime($val["dt_of_payment"])); ?></td>
										<?php /*?><td><?php echo $val["product_name"]; ?></td><?php */?>
										<td><?php echo ($val["s_merchant_name"]=='')?"Earned From Registration":$val["s_merchant_name"]; ?></td>
										<td>Rs <?php echo $val["cashback_amount"]; ?></td>
										<td><?php echo $val["i_status"]==1?"Approved":"Pending"; ?></td>
									</tr>
									<?php } } else {  ?>
									<tr class="oddEventr">
										<td colspan="4">No result found</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>	
						
					  </div>
					  <!-- END TAB #1 -->
					  
					  <!-- START TAB #2 -->
					  <div id="tabs-2">
					  							
						<div class="list_box">
							<table>
								<tbody>
									<tr>
										<th class="myClickTH">Date</th>
										<?php /*?><th class="myClickTH">Product</th><?php */?>										
										<th class="myClickTH">Store</th>
										<th class="myClickTH">Cashback</th>
										<th class="myClickTH">Status</th>
									</tr>
									<?php if($ref_earning) {
										foreach($ref_earning as $key=>$val)
											{								
									 ?>
									<tr class="oddEventr">
										<td><?php echo date('F d, Y',strtotime($val["dt_of_payment"])); ?></td>
										<?php /*?><td><?php echo $val["product_name"]; ?></td><?php */?>
										<td><?php echo $val["s_merchant_name"]; ?></td>
										<td>Rs <?php echo $val["cashback_amount"]; ?></td>
										<td><?php echo $val["i_status"]==1?"Approved":"Pending"; ?></td>
									</tr>
									<?php } } else {  ?>
									<tr class="oddEventr">
										<td colspan="4">No result found</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>	
							
					  </div>
					  <!-- END TAB #2 -->
					  
					  <!-- START TAB #3 -->
					  <div id="tabs-3">					  							
						<div class="list_box">
							<table>
								<tbody>
									<tr>
										<th class="myClickTH">Date</th>
										<th class="myClickTH">Mode</th>
										<th class="myClickTH">Withdrawl</th>
										<th class="myClickTH">Status</th>
									</tr>
									<?php if($withdrawl_list) {
										foreach($withdrawl_list as $key=>$val)
											{								
									 ?>
									<tr class="oddEventr">
										<td><?php echo date('F d, Y',strtotime($val["dt_of_payment"])); ?></td>
										<td><?php echo $val["s_pay_mode"]; ?></td>
										<td>Rs <?php echo $val["d_price"]; ?></td>
										<td><?php echo $val["i_status"]==1?"Approved":"Pending"; ?></td>
									</tr>
									<?php } } else {  ?>
									<tr class="oddEventr">
										<td colspan="4">No result found</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>								
					  </div>
					  <!-- END TAB #3 -->
					  
					</div>
					
				</div>
			</div>
			<div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>	

    <?php /*?><div class="right_pan">
            <div class="clear"></div>
        <?php echo $this->load->view('elements/subscribe.tpl.php');?>
        <?php echo $this->load->view('elements/facebook_like_box.tpl.php');?>
       	<?php //echo $this->load->view('elements/latest_deal.tpl.php');?>
        <?php echo $this->load->view('elements/forum.tpl.php');?>
        <?php echo $this->load->view('common/ad.tpl.php');?>
        <div class="clear"></div>
    </div><?php */?>	
    <div class="clear"></div>
</div>
<?php echo $this->load->view('common/social_box.tpl.php');?>
<div class="clear"></div>
<script type="text/javascript">
$(document).ready(function(){
	$( "#pay_tabs" ).tabs();	
});	
</script>