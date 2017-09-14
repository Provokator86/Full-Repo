<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
<div id="content">
		<div class="grid_container">
			<?php 
				$attributes = array('id' => 'display_form');
				echo form_open('admin/brands/change_seller_status_global',$attributes) 
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading?></h6>
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
						<?php 
						if ($allPrev == '1' || in_array('3', $seller)){
						?>
							<!--<div class="btn_30_light" style="height: 29px;">
								<a href="javascript:void(0)" onclick="return checkBoxValidationAdmin('Delete','<?php echo $subAdminMail; ?>');" class="tipTop" title="Select any checkbox and click here to delete records"><span class="icon cross_co"></span><span class="btn_link">Delete</span></a>
							</div>-->
						<?php }?>
						</div>
					</div>
					<div class="widget_content">
						<table class="display" id="storelist_tbl">
						<thead>
						<tr>
							<th class="center">
								<input name="checkbox_id[]" type="checkbox" value="on" class="checkall">
							</th>
							<th class="tip_top" title="Click to sort">
								Brand Name
							</th>
							<th class="tip_top" title="Click to sort">
								Brand Url
							</th>
							<th>
								Followers
							</th>
							<th class="tip_top" title="Click to sort">
								Products
							</th>
							<th>
								Action
							</th>
						</tr>
						</thead>
						<tbody>
						<?php 
						if ($sellersList->num_rows() > 0){
							foreach ($sellersList->result() as $row){
						?>
						<tr>
							<td class="center tr_select ">
								<input name="checkbox_id[]" type="checkbox" value="<?php echo $row->i_id;?>">
							</td>
							<td class="center">
								<?php echo $row->brand_name;?>
							</td>
							<td class="center">
								<?php echo $row->brand_url;?>
							</td>
							<td class="center">
								<?php echo $row->followers_count;?>
							</td>
							<td class="center">
								<?php echo $row->products_count;?>
							</td>
							<td class="center">
								<?php if ($allPrev == '1' || in_array('2', $seller)){?>
                                    <span><a class="action-icons c-edit" href="admin/brands/edit_brand_form/<?php echo $row->i_id;?>" title="Edit">Edit</a></span>
                                <?php }?>
                                    <span><a class="action-icons c-suspend" href="admin/brands/view_brand/<?php echo $row->i_id;?>" title="View">View</a></span>
                                <?php if ($allPrev == '1' || in_array('3', $seller)){?>	
                                    <span><a class="action-icons c-delete" href="javascript:confirm_delete('admin/brands/delete_brand/<?php echo $row->i_id;?>')" title="Delete">Delete</a></span>
								<?php }?>
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
								Brand Name
							</th>
							<th>
								Brand Url
							</th>
							<th>
								Followers
							</th>
							<th>
								Products
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
			<input type="hidden" name="SubAdminEmail" id="SubAdminEmail"/>
		</form>	
			
		</div>
		<span class="clear"></span>
	</div>
</div>
<script type="text/javascript">
$('#storelist_tbl').dataTable({   
	 "aoColumnDefs": [
						{ "bSortable": false, "aTargets": [ 0 , 5 ] }
					],
					"aaSorting": [[1, 'asc']],
	"sPaginationType": "full_numbers",
	"iDisplayLength": 100,
	"oLanguage": {
       "sLengthMenu": "<span class='lenghtMenu'> _MENU_</span><span class='lengthLabel'>Entries per page:</span>",	
   },
	 "sDom": '<"table_top"fl<"clear">>,<"table_content"t>,<"table_bottom"p<"clear">>'
	 
	});
</script>
<style>
#storelist_tbl tr td, #storelist_tbl tr th{
	border-right:1px solid #ccc;
}
</style>
<?php 
$this->load->view('admin/templates/footer.php');
?>