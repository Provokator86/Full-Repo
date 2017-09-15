<div class="right_cell">
	<div class="club_header">
		<p>Cannot find the business you are looking for?
			<?php if($this->session->userdata('user_id') != '') { ?>
			<a style="cursor: pointer;" href="<?=base_url().'business/add'?>">Add it here</a>
			<?php } else { ?>
			<a style="cursor: pointer; text-decoration:underline;" onclick="tb_show('Login', '<?=base_url()?>ajax_controller/ajax_show_login/add_new_business?height=250&width=400');">Add it here</a>
			<?php } ?>
		</p>
		<div class="clear"></div>
	</div>

	<div class="club_header" style="padding-top:2px;">
		<h3><?php echo $rows[0]['tot_row']?> results found</h3>
		<div class="sorting_box">Sort Results By :
			<select id="short_by" name="short_by" onchange="submit_short_business_page(this.value);">
				<option value="b.name"<?php echo ($order_by == 'b.name') ? ' selected' : ''?>>Name (A-Z)</option>
				<option value="b.avg_review"<?php echo ($order_by == 'b.avg_review') ? ' selected' : ''?>>Rating</option>
				<?php if($business_category == 1) { ?><option value="p.price_from"<?php echo ($order_by == 'p.price_from') ? ' selected' : ''?>>Price</option><?php } ?>
			</select>
		</div>
		<div class="clear"></div>
	</div>
	
	<?php //if($business_category > 0 || !empty($search_for)) { ?>
	<div class="club_header">
		<h3 style="text-transform:none;"><?php echo $result_text?></h3>
		<div class="clear"></div>
	</div>
	<?php //} ?>

	<?php
	if($rows[0]['tot_row']) {
		foreach($rows as $k => $v) {
			$bgstyle = '';
			
			if($k % 2 != 0)
				$bgstyle = ' style="background:#f3f3f3"';
	?>
	<div class="club_result"<?php echo $bgstyle?>>
		<div class="cell_04">
			<a href="<?=base_url().'business/'.$v['id'].'/'.str_replace(' ', '_',$v['name'])?>">
				<?php if(isset($v['img_name']) && !empty($v['img_name'])) { ?>
				<img src="<?=base_url()?>images/uploaded/business/thumb/<?=$v['img_name']?>" width="77" height="77" alt="" />
				<?php } else { ?>
				<img src="<?=base_url()?>images/front/img_03.jpg" alt="" />
				<?php } ?>
			</a>
		</div>
		
		<div class="cell_05">
			<h3><a href="<?=base_url().'business/'.$v['id'].'/'.str_replace(' ', '_',$v['name'])?>"><?=$v['name']?></a></h3>
			<p>
				<?php if($general_search_factor) { ?><strong>Business Type:</strong> <?php echo $v['bt_name']; ?><br/><?php } ?>
				<?php echo $v['address']?><br/>
				<?php echo $v['ct_name']?> - <?php echo $v['zipcode']?>
			</p>
			<h6>
				<?php
				if($business_category == 1 || ($general_search_factor && $v['business_category'] == 1)) {
					if(isset($v['menu_list']) && count($v['menu_list'])) {
				?>
				<script type="text/javascript">
					$(function() {
						$('#gallery_menu<?php echo $k; ?> a').lightBox();
					});
				</script>
				<span id="gallery_menu<?php echo $k; ?>">
                                    <a href="<?php echo $this->config->item('view_image_folder_biz').$this->config->item('image_folder_view').$v['menu_list'][0]['img_name']?>" title="<?php echo $v['menu_list'][0]['full_name']?>">View Menu</a>
					<?php
					foreach($v['menu_list'] as $k1 => $v1) {
						if($k1 > 0) {
					?>
					<div style="display: none; float: left;" class="thumb_menu">
						<a href="<?php echo $this->config->item('view_image_folder_biz').$this->config->item('image_folder_view').$v1['img_name']?>" title="<?php echo $v['menu_list'][0]['full_name']?>"></a>
					</div>
					<?php } } ?>
				</span>

				&nbsp;|&nbsp;
				
				<?php
					}
					else {
						if($this->session->userdata('user_id') != '') {
				?>
				<a style="cursor: pointer;" onclick="tb_show('Upload menu', '<?=base_url()?>ajax_controller/ajax_show_upload_menu/upload_menu/<?=$v['id']?>?height=250&width=450');">Upload Menu</a>
				&nbsp;|&nbsp;
						<?php
						}
						else {
						?>
				<a style="cursor: pointer;" onclick="tb_show('Login', '<?=base_url()?>ajax_controller/ajax_show_login/upload_menu/<?=$v['id']?>?height=250&width=400');">Upload Menu</a>
				&nbsp;|&nbsp;
				<?php
						}
					}
				}
				if($this->session->userdata('user_id') != '') {
				?>
				<a style="cursor: pointer;" onclick="request_coupon('<?=$v['id']?>');">Request Coupon</a>
				<a rel="imgtip[0]" href="#" style="padding-left:7px;"><img align="absmiddle" alt="" src="<?=base_url()?>images/front/icon_06.png" /></a>
				<?php } else { ?>
				<a style="cursor: pointer;" onclick="tb_show('Login', '<?=base_url()?>ajax_controller/ajax_show_login/request_coupon/<?=$v['id']?>?height=250&width=400');">Request Coupon</a>
				<a rel="imgtip[0]" href="#" style="padding-left:7px;"><img align="absmiddle" alt="" src="<?=base_url()?>/images/front/icon_06.png" /></a>
				<?php } ?>
			</h6>
		</div>
		
		<div class="cell_06">
			<?php for($i = 1; $i <= $v['avg_review']; $i++) { ?>
			<img src="<?=base_url()?>images/front/star.png" alt=""/>
			<?php } ?>
			<em>(Based on <?=$v['tot_review']?> reviews)</em>
			<div class="margin15"></div>
			
			<?php if($v['business_category'] == 1) { ?>
			<p>Avg. Entree Price: <?=$v['price_from']?> - <?=$v['price_to']?></p>
			<?php } ?>
			<p>Locality: <?=$v['place']?></p>
			<p>Phone: <?=$v['phone_number']?></p>
		</div>
		<div class="clear"></div>
	</div>
		<?php
		}

		if($rows[0]['tot_row'] > $toshow) {
		?>
	<div class="paging">
		<table border="0" cellspacing="0" cellpadding="0" style=" margin:auto;" width="50%">
			<tr>
				<td align="center" width="10%">
					<?php if($page) { ?>
					<a onclick='autoload_ajax("<?=base_url().'search/search_business_list_ajax'?>", "div_search_business_list", <?=$jsnArr?>, "page", "<?=($page-1)?>");' style="cursor:pointer;">
						<!--<img alt="" src="<?=base_url()?>images/front/arrow_left.png" style="vertical-align: middle;"/>-->
					</a>
					<?php } ?>
				</td>
				<td align="center"  valign="top">
					<?=($page+1)?> / <?=ceil($rows[0]['tot_row'] / $toshow)?>
				</td>
				<td align="center" width="10%">
					<?php if( $toshow<$rows[0]['tot_row'] && (($page + 1) * $toshow) < $rows[0]['tot_row']) { ?>
					<a onclick='autoload_ajax("<?=base_url().'search/search_business_list_ajax'?>", "div_search_business_list", <?=$jsnArr?>, "page", "<?=($page+1)?>");' style="cursor:pointer;">
						<!--<img alt="" src="<?=base_url()?>images/front/arrow_right.png" style="vertical-align: middle;"/>-->
					</a>
					
					<?php } ?>
				</td>
			</tr>
			
		</table>
		
		<table>
		
		<tr>
			
			<td> 
				<?php if($page) {?>
				<a onclick='autoload_ajax("<?=base_url().'search/search_business_list_ajax'?>", "div_search_business_list", <?=$jsnArr?>, "page", "0");' style="cursor:pointer;">First</a><?php } else {?> First <?php }?></td>
			<td> 
			<td> 
				<?php if($page < ceil($rows[0]['tot_row'] / $toshow)-1) {?>
				<a onclick='autoload_ajax("<?=base_url().'search/search_business_list_ajax'?>", "div_search_business_list", <?=$jsnArr?>, "page", "<?=($page+1)?>");' style="cursor:pointer;">Next</a><?php } else {?> Next <?php }?>
				</td>
			<td> 
			<td> 
				<?php if($page >0 ) {?>
				<a onclick='autoload_ajax("<?=base_url().'search/search_business_list_ajax'?>", "div_search_business_list", <?=$jsnArr?>, "page", "<?=($page-1)?>");' style="cursor:pointer;">Previous</a> <?php } else {?> Previous <?php }?></td>
			<td>
				<?php if($page != ceil($rows[0]['tot_row'] / $toshow)-1) {?>
				<a onclick='autoload_ajax("<?=base_url().'search/search_business_list_ajax'?>", "div_search_business_list", <?=$jsnArr?>, "page", "<?=ceil($rows[0]['tot_row'] / $toshow)-1?>");' style="cursor:pointer;">Last</a>
				<?php } else {?> Last <?php }?>
			</td>
			<td>
			Page: <select name="pageNo" id="pageNo" onchange="changePageNo();">
					<?php for($i=1;$i<=ceil($rows[0]['tot_row'] / $toshow);$i++) {
						$sel = ($i == $page+1) ? 'selected' : '';
					?>
					
					<option value="<?php echo $i;?>" <?=$sel?>> <?php echo $i;?></option>
					<?php }?>
					</select>
					
			
			</td>	
			
			</tr>
			
		</table>
		
	</div>
	<?php
		}
	} // End of "if($rows[0]['tot_row'])"
	else {
	?>
	<div>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<h1 style="border-bottom:0px;">No Matches Found</h1>
		<?php /*
		<p>Cannot find the business you are looking for?
		<?php if($this->session->userdata('user_id') != '') { ?>
		<a style="cursor: pointer;" href="<?=base_url().'business/add'?>">Add it here</a>
		<?php } else { ?>
		<a style="cursor: pointer;" onclick="tb_show('Login', '<?=base_url()?>ajax_controller/ajax_show_login/add_new_business?height=250&width=400');">Add it here</a>
		<?php } ?>
		</p>
		*/ ?>
	</div>
	<?php } ?>
</div>

<script type="text/javascript">
function changePageNo()
{
	var pageNo = $("#pageNo").val()-1;
	autoload_ajax("<?=base_url().'search/search_business_list_ajax'?>", "div_search_business_list", <?=$jsnArr?>, "page", pageNo);
	

}
</script>