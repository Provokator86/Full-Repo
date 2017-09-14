<?php if($property_list) {
		$i = 1;
		$map_address=array();
		
		foreach($property_list as $value)
		{
			
			 $property_image = $value["s_property_image"][0]["s_property_image"];
			 
			  $map_address[]=array(	'address_or_latlng'=>	$value["s_lattitude"].', '.$value["s_longitude"],
													'title'=>				$value["s_property_name"],
													'link_or_html'=>		base_url()."property/details/".encrypt($value["id"]),
													'icon'=>				base_url()."no_imaged/index/".$i);
 
 
 	$owner_url =  encrypt($value['i_owner_user_id']).'/'.make_my_url($value['owner_first_name'].' '.$value['owner_last_name']) ;
	
	$property_url	=	encrypt($value['id']).'/'.make_my_url($value['s_accommodation']).'/'.make_my_url($value['s_property_name']) ;
 
 
 ?>
	<script type="text/javascript">
		var arr_marker = <?=json_encode($map_address)?>;
		LIB_GMAP_MARKER_DEL_ALL("test_id");
		LIB_GMAP_MARKER_ADD_ARR("test_id",arr_marker);
	</script>
<div class="propaty-box">
				<div class="propaty-photo">
				<?php echo showThumbImageDefault('property_image',$property_image,'small',225,150); ?>
					  <div class="number-bg"><?php echo $i ?></div>
				</div>
				<div class="propaty-text">
					  <?php /*?><h3><a href="<?php echo base_url()."property/details/".encrypt($value["id"]) ?>"><?php echo $value["s_property_name"] ?></a></h3><?php */?>
					  <h3><a href="<?php echo base_url()."property/details/".$property_url ?>"><?php echo $value["s_property_name"] ?></a></h3>
					  <div class="price"><?php echo showAmountCurrency(getAmountByCurrency($value["d_standard_price"],$value["i_currency_id"])) ?><br />
							/night</div>
					  <br class="spacer" />
					  <p><?php echo $value["s_accommodation"] ?> (Guests <?php echo $value["i_total_guests"] ?>) </p>
					  <p><?php echo show_star($value["review_rate"]["avg_rating"]) ?><?php echo $value["review_rate"]["i_total"] ?> reviews </p>
					  <!--<p>164 people have booked with Martina </p>-->
					  <div class="favorites-box">
							<div class="booking">
							<a href="<?php echo base_url().'profile/'.$owner_url ?>"><?php echo showThumbImageDefault('user_image',$value["s_image"],'min',75,'auto'); ?></a>
							</div>
							<div class="favorites">								
								  <input class="green-button" type="button" value="See Offer" onclick="window.location.href='<?php echo base_url()."property/details/".encrypt($value["id"]) ?>'" />
							</div>
					  </div>
					  <br class="spacer" />
				</div>
				<div class="spacer"></div>
		  </div>

<?php $i++; } } else { ?>	
<p>No place found</p>
<?php } ?>	  
		  
<!--<div class="propaty-box bg">-->
 <div class="page-number">
 	<?php echo $page_links; ?>
 </div>
