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
					<h1>My Referral Network</h1>	
					
					<div class="list_box">
						<table>
							<tbody>
								<tr>
									<th class="myClickTH">Invite Date</th>
									<th class="myClickTH">Friend Name</th>
									<th class="myClickTH">Status</th>
								</tr>
								<?php if($invites) {
									foreach($invites as $key=>$val)
										{								
								 ?>
								<tr class="oddEventr">
									<td><?php echo date('Y-m-d',strtotime($val["dt_invite"])); ?></td>
									<td><?php echo $val["s_name"]; ?></td>
									<td><?php echo $val["i_status"]==1?"Joined":"Invited"; ?></td>
								</tr>
								<?php } } else {  ?>
								<tr class="oddEventr">
									<td colspan="3">No result found</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
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

	
});	
</script>