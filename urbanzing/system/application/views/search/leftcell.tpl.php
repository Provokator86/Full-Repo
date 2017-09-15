<script type="text/javascript">
	$(document).ready(function()
	{
		$(".message_list .message_body_business_type:gt(0)").hide();
		$(".message_list .message_body_price_range:gt(0)").hide();
		$(".message_list .message_body_area_list:gt(0)").hide();
		$(".message_list .message_body_cuisine_list:gt(0)").hide();

		$(".message_list div:gt(4)").hide();

		$(".message_head_business_type").click(function(){
			$(this).next(".message_body_business_type").slideToggle(500);
			return false;
		});
		$(".message_head_price_range").click(function(){
			$(this).next(".message_body_price_range").slideToggle(500);
			return false;
		});
		$(".message_head_area_list").click(function(){
			$(this).next(".message_body_area_list").slideToggle(500);
			return false;
		});
		$(".message_head_cuisine_list").click(function(){
			$(this).next(".message_body_cuisine_list").slideToggle(500);
			return false;
		});

		$(".collpase_all_message").click(function(){
			$(".message_body_business_type").slideUp(500);
			return false;
		});
		$(".collpase_all_message").click(function(){
			$(".message_body_price_range").slideUp(500);
			return false;
		});
		$(".collpase_all_message").click(function(){
			$(".message_body_area_list").slideUp(500);
			return false;
		});
		$(".collpase_all_message").click(function(){
			$(".message_body_cuisine_list").slideUp(500);
			return false;
		});
		$(".show_all_message").click(function(){
			$(this).hide();
			$(".show_recent_only").show();
			$(".message_list div:gt(4)").slideDown();
			return false;
		});
		$(".show_recent_only").click(function(){
			$(this).hide();
			$(".show_all_message").show();
			$(".message_list div:gt(4)").slideUp();
			return false;
		});
	});

	$(document).ready(function() {
		$('form#frm_serach_ck').ajaxForm({
			//dataType:  'script'
			beforeSubmit: post_own_wall_before_ajaxform,
			success:      post_own_wall_after_ajaxform
		});

		$('form#frm_serach_ck').submit(function() {
			// inside event callbacks 'this' is the DOM element so we first
			// wrap it in a jQuery object and then invoke ajaxSubmit
			//$(this).ajaxSubmit();

			// !!! Important !!!
			// always return false to prevent standard browser submit and page navigation
			return false;
		});
	});

	function post_own_wall_before_ajaxform()
	{
		if(document.getElementById('restaurants_ajax_auto_load'))
			document.getElementById('restaurants_ajax_auto_load').innerHTML = '<img src="'+base_url+'images/front/ajax-loader.gif" alt=""/>';
	}

	function post_own_wall_after_ajaxform(responseText)
	{
		window.location.reload();
/*		document.getElementById('div_search_business_list').innerHTML = responseText;
		close_all_div();
		
		if(document.getElementById('restaurants_ajax_auto_load'))
			document.getElementById('restaurants_ajax_auto_load').innerHTML = '';*/
	}

	function close_all_div()
	{
		var business_category = <?=$business_category?>;
		document.getElementById('message_div_business_type').style.display = 'none';
		document.getElementById('message_div_area_list').style.display = 'none';
		if(business_category == 1){
			document.getElementById('message_div_price_range').style.display = 'none';
			document.getElementById('message_body_cuisine_list').style.display = 'none';
		}
	}
	

</script>
<div class="left_cell">
	<form id="frm_serach_ck" name="frm_serach_ck" class="frm_serach_ck" method="post" action="<?=base_url().'search/search_submit_ck'?>">
		<h2>BROWSE BY:</h2>
	<?php if($business_category == 1) { ?>
		<h3>Menu</h3>
		<ul>
		<?php
			if(isset($search_session_value['menu']) && $search_session_value['menu']!='' && $search_session_value['menu']!='-1')
			{
		?>
			<li>
			Places w/ menu (<?=$business_menu?>)
			<a rel="imgtip[2]" style='cursor:pointer;' onclick="business_search_remove_session(<?=$search_session_value['menu']?> , 'menu');">
			<img  src='<?=base_url()?>images/front/small_close.png' ></a></li>
		<?php } else {?>
			<li><a  style='cursor:pointer;' onclick="autoload_ajax_no_jsn('<?=base_url()?>search/search_business_list_ajax','div_search_business_list','menu=1');">Places w/ menu</a> (<?=$business_menu?>)</li>
			<?php } ?>
		</ul>
	
	
		<h3>Cuisine</h3>
		<ul>
			<?php echo $cuisine_list['type_out']?>
		</ul>
		<?php
		if(isset($search_session_value['cuisine_id']) && empty($search_session_value['cuisine_id']))
		{  
		?>
		<h6 class="message_head_cuisine_list"><a href="#" onclick="close_all_div();">+ View all</a></h6>
		<?php } ?>
		<div class="flyout_box message_body_cuisine_list" id="message_body_cuisine_list" style="display:none; position:absolute; z-index:120; top:350px; left:70px;">
			<div class="fly_header">
				<div class="cell_01">
					<h1 style="border:none">Cuisine</h1>
				</div>
				<div style="width: 250px;padding-top: 20px;float: left;">
					<input class="button_06" onclick="$('#frm_serach_ck').submit();" type="button" value="Update my search" />
				</div>
				<div class="cell_03">
					<a style="cursor: pointer;" onclick="close_all_div();"><img src="<?=base_url()?>images/front/lightbox_close.png" alt="" /></a>
				</div>
				<br />
			</div>
			<div class="fly_content">
				<div class="inner_part">
					<input type="checkbox" name="allCuisine" id="allCuisine" value="ALL" onClick="checkAll('allCuisine', 'ck_cuisine_list')"> All<br/>
					<?php echo $cuisine_list['type_in']?>
					<div class="clear"></div>
				</div>
			</div>
		</div>

		
		<?php } // End of "if($business_category == 1)" ?>		
		
		
		
		<h3>User Rating</h3>
		<ul>
			<?php echo $avg_review['type_out']?>
		</ul>
		<!-- End Ratiing-->
		
		
		<h3>Type</h3>
		<ul>
			<?php echo $business_type['type_out']?>
		</ul>
		<?php
		if(isset($search_session_value['business_type_id']) && empty($search_session_value['business_type_id']))
		{  
		?>
		<h6 class="message_head_business_type"><a href="#" onclick="close_all_div();">+ View all</a></h6>
		<?php } ?>
		<div class="flyout_box message_body_business_type" id="message_div_business_type" style="display:none; position:absolute; z-index:120; top:250px; left:70px;">
			<div class="fly_header">
				<div class="cell_01">
					<h1 style="border:none;">Restaurants Type</h1>
				</div>
				<div style="width: 250px;padding-top: 20px;float: left;">
					<input class="button_06" onclick="$('#frm_serach_ck').submit();" type="button" value="Update my search"/>
				</div>
				<div class="cell_03">
					<a style="cursor: pointer;" onclick="close_all_div();"><img src="<?=base_url()?>images/front/lightbox_close.png" alt="" /></a>
				</div>
				<br />
			</div>
			<div class="fly_content">
				<div class="inner_part">
					<input type="checkbox" name="allBusinessType" id="allBusinessType" value="ALL" onClick="checkAll('allBusinessType', 'ck_business_type')"> All<br/>
					<?php echo $business_type['type_in']?>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<!--End first part-->

		
		<?php if($business_category == 1) { ?>


		<h3>Avg. Entrée Price</h3>
		<ul>
			<?php echo $price_range['type_out']?>
		</ul>
		<?php
		if(isset($search_session_value['price_range_id']) && empty($search_session_value['price_range_id']))
		{  
		?>
		<h6 class="message_head_price_range"><a href="#" onclick="close_all_div();">+ View all</a></h6>
		<?php } ?>
		<div class="flyout_box message_body_price_range" id="message_div_price_range" style="display:none; position:absolute; z-index:120; top:350px; left:70px;">
			<div class="fly_header">
				<div class="cell_01">
					<h1 style="border:none">Avg. Entrée Price</h1>
				</div>
				<div style="width: 250px;padding-top: 20px;float: left;">
					<input class="button_06" onclick="$('#frm_serach_ck').submit();" type="button" value="Update my search" />
				</div>
				<div class="cell_03">
					<a style="cursor: pointer;" onclick="close_all_div();"><img src="<?=base_url()?>images/front/lightbox_close.png" alt="" /></a>
				</div>
				<br />
			</div>
			<div class="fly_content">
				<div class="inner_part">
					<input type="checkbox" name="allPriceRange" id="allPriceRange" value="ALL" onClick="checkAll('allPriceRange', 'ck_price_range')"> All<br/>
					<?php echo $price_range['type_in']?>
					<div class="clear"></div>
				</div>
			</div>
		</div>

		
		<?php } // End of "if($business_category == 1)" ?>
		<!--End Second part-->




		
		<h3>Area / locality</h3>
		<ul>
			<?php echo $business_location['type_out']?>
		</ul>
		<?php
		if(isset($search_session_value['zipcode']) && empty($search_session_value['zipcode']))
		{  
		?>
		<h6 class="message_head_area_list"><a href="#" onclick="close_all_div();">+ View all</a></h6>
		<?php } ?>
		<div class="flyout_box message_body_area_list" id="message_div_area_list" style="display:none; position:absolute; z-index:120; top:550px; left:70px;">
			<div class="fly_header">
				<div class="cell_01">
					<h1 style="border:none">Area / locality</h1>
				</div>
				<div style="width: 250px;padding-top: 20px;float: left;">
					<input class="button_06" onclick="$('#frm_serach_ck').submit();" type="button" value="Update my search" />
				</div>
				<div class="cell_03">
					<a style="cursor: pointer;" onclick="close_all_div();"><img src="<?=base_url()?>images/front/lightbox_close.png" alt="" /></a>
				</div>
				<br />
			</div>
			<div class="fly_content">
				<div class="inner_part" style="height: 500px;overflow: auto;">
					<input type="checkbox" name="allLocation" id="allLocation" value="ALL" onClick="checkAll('allLocation', 'ck_area_list')"> All<br/>
					<?php echo $business_location['type_in']?>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<!--End Location-->
		
		<?php if (!$general_search_factor) { ?>

		<h3>Features</h3>
		
		<ul>
		<?php
			if(isset($search_session_value['credit_card']) && !empty($search_session_value['credit_card']))
			{
		?>	
			<li>Credit Cards
			<a style='cursor:pointer;' rel="imgtip[2]" onclick="business_search_remove_session(<?=$search_session_value['credit_card']?> , 'credit_card');">
			<img src='<?=base_url()?>images/front/small_close.png'	 alt='Remove filter' ></a>
			</li>	
		<?php
			}
			else {
		?>
			<li><a style='cursor:pointer;' onclick="autoload_ajax_no_jsn('<?=base_url()?>search/search_business_list_ajax','div_search_business_list','credit_card=1');">Credit cards</a>
</li>
		<?php }
			if(isset($search_session_value['air_conditioned']) && $search_session_value['air_conditioned']!='')
			{
		?>
			<li>AC
			<a style='cursor:pointer;' rel="imgtip[2]" onclick="business_search_remove_session(<?=$search_session_value['air_conditioned']?> , 'air_conditioned');">
			<img src='<?=base_url()?>images/front/small_close.png' alt='Remove filter' ></a></li>
			<?php } else {?>
		
			<li><a style='cursor:pointer;' onclick="autoload_ajax_no_jsn('<?=base_url()?>search/search_business_list_ajax','div_search_business_list','air_conditioned=1');">AC</a></li>
			
		<?php } 
		 if ($business_category == 1) { 
			if(isset($search_session_value['vegetarian']) && $search_session_value['vegetarian']!='')
			{
		?>
			<li>Veg Served
			<a style='cursor:pointer;' rel="imgtip[2]" onclick="business_search_remove_session(<?=$search_session_value['vegetarian']?> , 'vegetarian');">
			<img src='<?=base_url()?>images/front/small_close.png' alt='Remove filter' ></a></li>
		<?php } else { ?>
			<a style='cursor:pointer;' onclick="autoload_ajax_no_jsn('<?=base_url()?>search/search_business_list_ajax','div_search_business_list','vegetarian=1');"><li>Veg Served</li></a>	
		<?php } 
			if(isset($search_session_value['take_reservation']) && $search_session_value['take_reservation']!='')
			{
		?>
			<li>Reservations
			<a style='cursor:pointer;' rel="imgtip[2]" onclick="business_search_remove_session(<?=$search_session_value['take_reservation']?> , 'take_reservation');">
			<img src='<?=base_url()?>images/front/small_close.png' alt='Remove filter' ></a>
			</li>
		<?php } else { ?>
			<li><a style='cursor:pointer;' onclick="autoload_ajax_no_jsn('<?=base_url()?>search/search_business_list_ajax','div_search_business_list','take_reservation=1');">Reservations</a></li>
		<?php
			}	
		}
			if(isset($search_session_value['parking']) && $search_session_value['parking']!='')
			{
			?>	
			<li>Parking available
		<a style='cursor:pointer;' rel="imgtip[2]" onclick="business_search_remove_session(<?=$search_session_value['parking']?> , 'parking');">
			<img src='<?=base_url()?>images/front/small_close.png'  alt='Remove filter' ></a>
			</li>
			<?php } else { ?>
			<li><a style='cursor:pointer;' onclick="autoload_ajax_no_jsn('<?=base_url()?>search/search_business_list_ajax','div_search_business_list','parking=1');">Parking available</a></li>
			<?php } 
			if($business_category == 1) { 
			if(isset($search_session_value['alcohol']) && $search_session_value['alcohol']!='')
			{
			?>
				<li>Alcohol Served
				<a style='cursor:pointer;' rel="imgtip[2]" onclick="business_search_remove_session(<?=$search_session_value['alcohol']?> , 'alcohol');">
			<img src='<?=base_url()?>images/front/small_close.png'  alt='Remove filter' ></a>
				</li>
			<?php } else {?>	
				
				<li><a style='cursor:pointer;' onclick="autoload_ajax_no_jsn('<?=base_url()?>search/search_business_list_ajax','div_search_business_list','alcohol=1');">Alcohol Served</a></li>
			
			<?php }
			} ?>
		</ul>
		<?php } ?>
	
	</form>
</div>
