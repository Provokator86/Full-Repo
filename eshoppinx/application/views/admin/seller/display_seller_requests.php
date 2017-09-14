<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
<div id="content">
		<div class="grid_container">
			<?php 
				$attributes = array('id' => 'display_form');
				echo form_open('admin/seller/change_seller_status_global',$attributes) 
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading?></h6>
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
						</div>
					</div>
					<div class="widget_content">
						<table class="display display_tbl" id="seller_tbl">
						<thead>
						<tr>
							<th class="center">
								<input name="checkbox_id[]" type="checkbox" value="on" class="checkall">
							</th>
							<th class="tip_top" title="Click to sort">
								User Name
							</th>
							<th class="tip_top" title="Click to sort">
								Store Name
							</th>
							<th class="tip_top" title="Click to sort">
								Store Url
							</th>
							<th class="tip_top" title="Click to sort">
								Document
							</th>
							<th>
								Action
							</th>
						</tr>
						</thead>
						<tbody>
						<?php 
						if ($storeDetails->num_rows() > 0){
							foreach ($storeDetails->result() as $row){
						?>
						<tr>
							<td class="center tr_select ">
								<input name="checkbox_id[]" type="checkbox" value="<?php echo $row->id;?>">
							</td>
							<td class="center">
								<?php //echo $getuserDetails->row()->user_name; ?>
                                <?php //echo $row->user_id; ?>
                                <?php 
									$sql = "select * from ".USERS." where id='".$row->user_id."'";
									$query = $this->db->query($sql);
									$userResult = $query->row_array();
									echo $userResult['user_name'];
								?>
							</td>
							<td class="center">
								<?php echo $row->store_name;?>
							</td>
							<td class="center">
								<?php echo $row->store_url;?>
							</td>
							<td class="center">
								<a href="<?php echo base_url();?>store/<?php echo $row->document;?>"><?php echo $row->document;?></a>
							</td>
							<td class="center">
									<span class="action_link"><a class="p_reject tipTop" href="admin/seller/view_seller/<?php echo $row->id;?>" title="View">View</a></span>
									<span class="action_link"><a class="p_del tipTop" href="admin/seller/change_seller_request/0/<?php echo $row->id;?>" title="Reject">Reject</a></span>
									<!--<span class="action_link"><a class="p_approve tipTop" href="admin/seller/change_seller_request/1/<?php echo $row->id;?>" title="Approve">Approve</a></span>-->
                                    <span class="action_link"><a class="p_approve tipTop" href="admin/seller/change_seller_status/1/<?php echo $row->id;?>/<?php echo $row->store_id;?>" title="Approve">Approve</a></span>
							</td>
						</tr>
						<?php 
							}
						}
						?>
						</tbody>
						<tfoot>
						<tr>
							<th class="center">
								<input name="checkbox_id[]" type="checkbox" value="on" class="checkall">
							</th>
							<th>
								 User Name
							</th>
							<th>
								 Store Name
							</th>
							<th>
								Description
							</th>
							<th>
								Status
							</th>
							<th>
								 Action
							</th>
						</tr>
						</tfoot>
						</table>
					</div>
				</div>
			</div>
			<input type="hidden" name="statusMode" id="statusMode"/>
		</form>	
			
		</div>
		<span class="clear"></span>
	</div>
</div>
<?php 
$this->load->view('admin/templates/footer.php');
?>