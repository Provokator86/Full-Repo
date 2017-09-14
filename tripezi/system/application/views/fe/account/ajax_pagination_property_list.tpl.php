 <?php if($property_list) {
 		$i =1;
		foreach($property_list as $value)
			{ 		
				$class = ($i==count($property_list))?'class="manage-property-box no-border"':'class="manage-property-box"';
				$image = $value["s_property_image"][0]["s_property_image"];
				
				$property_url	=	encrypt($value['id']).'/'.make_my_url($value['s_accommodation']).'/'.make_my_url($value['s_property_name']) ;
				
  ?>
 <div <?php echo $class ?>>
	 <?php echo showThumbImageDefault('property_image',$image,'small',226,150); ?>
	 <?php /*?><h3><a href="<?php echo base_url().'property/details/'.encrypt($value["id"]) ?>"><?php echo $value["s_property_name"] ?></a></h3><?php */?>
	 <h3><a href="<?php echo base_url().'property/details/'.$property_url ?>"><?php echo $value["s_property_name"] ?></a></h3>
	 <ul>
	 <li>Property Type :  <span><?php echo $value["s_property_type"] ?></span></li>
	 <li>Type of Accommodation:  <span><?php echo $value["s_accommodation"] ?></span></li>
	 <li>Bedrooms:  <span><?php echo $value["i_total_bedrooms"] ?></span></li>
	 <li>Price: <span><?php echo showAmountCurrency(getAmountByCurrency($value["d_standard_price"],$value["i_currency_id"])) ?></span></li>
	 <li>Zip: <span><?php echo $value["s_zipcode"] ?></span></li>
	 </ul>
	 <br class="spacer" />
				 <p><strong>Description:</strong> <?php echo $value["s_description"] ?></p>

	<div class="icon-box05">
		<a href="<?php echo base_url().'property-calender/'.encrypt($value["id"]) ?>"><img src="images/fe/calendar.png" alt="calendar" title="calendar" /></a>
		<a href="<?php echo base_url().'list-your-place/'.encrypt($value["id"]) ?>"><img src="images/fe/edit.png" alt="edit"  title="edit"/></a>
		<a href="javascript:void(0);" class="delete_property" rel="<?php echo $value["id"] ?>"><img src="images/fe/del01.png" alt="del01" title="delete" /></a>
	</div>
</div>
<?php $i++; } } else { ?>
<p>No property found.</p>
<?php } ?>
				 
<!-- <div class="manage-property-box no-border">-->
 <input type="hidden" id="h_total_rows" value="<?php echo $total_rows; ?>" />
 <div class="page-number">
 	<?php echo $page_links; ?>
 </div>