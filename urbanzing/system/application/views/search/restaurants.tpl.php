<div class="club_pub">
	<div style="border-bottom:1px dotted #ccc; padding-bottom:5px;">
		<div style="width:400px; float:left">
			<h1 style=" border:none; padding:0px;">featured <?=$category_name?></h1>
		</div>
		<div style="width:200px; text-align:right; float:right">
			<input type="button" value="Clear search" onclick="window.location.href='<?=base_url().'search/clear_search'?>'" class="button_06">
		</div>
		<div style="width:100px; float:right;" id="restaurants_ajax_auto_load"></div>
		<div style="clear:both"></div>
	</div>

	<?php $this->load->view('admin/common/message_page.tpl.php'); ?>
	<div class="margin10"></div>

	<?php $this->load->view('search/leftcell.tpl.php'); ?>
	<div id="div_search_business_list"></div>

	<script type="text/javascript">
	autoload_ajax_search('<?=base_url().'search/search_business_list_ajax'?>', 'div_search_business_list');

	function business_type_search(type_id, type_name)
	{
		autoload_ajax_no_jsn('<?=base_url()?>search/search_business_list_ajax', 'div_search_business_list', 'business_type=' + type_id + '&business_type_text=' + type_name);
		document.getElementById('search_for').value = type_name;
	}

	function submit_short_business_page(val)
	{
		var j_data  = 'order_by=' + val + '';
		autoload_ajax_no_jsn('<?=base_url().'search/search_business_list_ajax'?>', 'div_search_business_list', j_data);
	}

	function request_coupon(id)
	{
		tb_show('Request coupon', '<?=base_url()?>ajax_controller/ajax_request_coupon/' + id + '?height=50&width=400');
		setTimeout('tb_remove()', 5000);
	}
	</script>
    
	<div class="clear"></div>
</div>