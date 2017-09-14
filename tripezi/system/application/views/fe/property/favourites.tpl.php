<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="container-box">
	<!--search bar-->	
	<?php //include_once(APPPATH."views/fe/common/search_bar.tpl.php"); ?>
	<!--type-box-->
	<div class="left-part">
		  <h2>Map</h2>
		  <div class="map-box">
				<!--<iframe width="247" height="246" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.in/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=28+dixon+lane&amp;aq=&amp;sll=21.125498,81.914063&amp;sspn=20.360191,39.506836&amp;ie=UTF8&amp;hq=&amp;hnear=Dixon+Ln,+Bow+Bazaar,+Kolkata,+West+Bengal&amp;t=m&amp;z=14&amp;ll=22.564835,88.367613&amp;output=embed"></iframe>-->
				
				
				<?
				
				global 
					$LIB_GMAP_KEY,
					$LIB_GMAP_SENSOR
				;
				
				//$LIB_GMAP_KEY = "AIzaSyAb9wmG1-VnHRJ-IDj4DTjFflSHsgfbadA"; // gmap3 key for local host
				$LIB_GMAP_KEY = "".$s_gmap3_key.""; // gmap3 key fetch in My_controller
				$LIB_GMAP_SENSOR = true;
				
				include APPPATH."helpers/gmap3/libgmap3/libgmap3.php";
				
				$arr_param = array();
				$arr_param['id'] = 'test_id';
				$arr_param['width']='247px';
				$arr_param['height']='246px';
				$arr_param['map_type_id']='ROADMAP'; // 'ROADMAP', 'HYBRID'
				$arr_param['map_type_control']=true; // true, false
				$arr_param['zoom_control']='SMALL'; // 'SMALL', 'LARGE', ''
				
				$arr_param['map_address']=array();		
			
									
				$arr_param['create_canvas_on_init']=true;
				LIB_GMAP_INIT($arr_param);
				
				
				?>
				<script type="text/javascript">
				function gmap_marker_clicked($link,$id,$add_ref_index)
				{
					//alert($link + ', ' + $id + ', ' + $add_ref_index);
					
					location = $link;
					
					// make synchronous ajax call to fetch data from server and then - 
					//return {title:'',html:''};
				}
				function gmap_all_marker_loaded($id)
				{
					LIB_GMAP_MARKER_SHOW_ALL_RESOLVED_IN_VIEW($id);
					//LIB_GMAP_DIRECTION_ADD($id,0,'*');
				}
				function gmap_marker_address_resolved($lat,$lng,$id,$add_ref_index)
				{
					//alert($lat + ', ' + $lng + ', ' + $id + ', ' + $add_ref_index);
				}
				
				
				function gmap_direction_clicked($add_ref_index,$marker_src_add_ref_index,$marker_dst_add_ref_index,$directions_description)
				{
					//alert($add_ref_index + ', ' + $marker_src_add_ref_index + ', ' + $marker_dst_add_ref_index + ', ' + $directions_description);
					//document.getElementById('directions_description').innerHTML = $directions_description;
				}
				
				</script>
				
				
		  </div>
	</div>
	<div class="right-part">
		  <?php /*?><div class="results">
				<div class="inner-box02">
					  <div class="lable05">1000 results</div>
					  <div class="sort-div">
							<div class="lable06">Sort by</div>
							<select id="property" name="property" style="width:258px;">
								  <option>Property space listings recommendation </option>
							</select>
					  </div>
				</div>
		  </div><?php */?>
		  <!-- property list -->
		  <div id="property_list">
		  	<?php echo $property ?>
		  </div>
		  <!-- property list end -->
		  
	</div>
	<br class="spacer" />
</div>