<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="container-box">
	<!--search bar-->	
	<?php include_once(APPPATH."views/fe/common/search_bar.tpl.php"); ?>
	<!--type-box-->
	<div class="left-part">
		  <h2>Map</h2>
		  <div class="map-box">
				<!--<iframe width="247" height="246" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.in/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=28+dixon+lane&amp;aq=&amp;sll=21.125498,81.914063&amp;sspn=20.360191,39.506836&amp;ie=UTF8&amp;hq=&amp;hnear=Dixon+Ln,+Bow+Bazaar,+Kolkata,+West+Bengal&amp;t=m&amp;z=14&amp;ll=22.564835,88.367613&amp;output=embed"></iframe>-->
		  </div>
	</div>
	<div class="right-part">
		  <div class="results">
				<div class="inner-box02">
					  <div class="lable05">1000 results</div>
					  <div class="sort-div">
							<div class="lable06">Sort by</div>
							<select id="property" name="property" style="width:258px;">
								  <option>Property space listings recommendation </option>
							</select>
					  </div>
				</div>
		  </div>
		  <!-- property list -->
		  <div id="property_list">
		  	<?php echo $property ?>
		  </div>
		  <!-- property list end -->
		  
	</div>
	<br class="spacer" />
</div>