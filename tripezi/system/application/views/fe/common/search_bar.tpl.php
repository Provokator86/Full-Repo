 <script language="javascript" type="text/javascript" src="js/jquery/ui/jquery-ui-1.8.4.custom.js"></script>
<script type="text/javascript">
<!-- 
	jQuery(function($){
		$(document).ready(function(){
		
			$( "#i_check_in" ).datepicker({
            dateFormat: 'dd-mm-yy',
            
            minDate : 0,
            changeYear: true,
            changeMonth: true,
			 onSelect: function( selectedDate ) {
                $( "#i_check_out" ).datepicker( "option", "minDate", selectedDate );
               
            }
        });

		$( "#i_check_out" ).datepicker({
					dateFormat: 'dd-mm-yy',
					
					minDate : 0,
					changeYear: true,
					changeMonth: true,
					onSelect: function( selectedDate ) {
                $( "#i_check_in" ).datepicker( "option", "maxDate", selectedDate );
                
              
            }
				});
				
		$('#ui-datepicker-div').hide();   // to hide the ui-datepicker-div 			
		
		
			$("#btn_search_bar").click(function(){
					$("#frm_src_properties").submit();
			});
			
			
			   $("#search02").autocomplete2('<?php echo base_url().'auto-suggest/search' ?>', 
                                        {
                                        width: 250,
                                        multiple: false,
                                        matchContains: true,
                                        mustMatch: false,
                                        formatItem: function(data, i, n, value) {
                                            return value ;
                                        },
                                        formatResult: formatResult
                                        
                                    });
                                    
                                    function formatResult(row) {
                                        return row[0].replace(/(<.+?>)/gi, '');
                                    }
                                    
                                    $('input[type=text]').attr('autocomplete', 'off');
                                    $('form').attr('autocomplete', 'off');
                                    
                                    
                                    /************ When list box click *********/ 
                                    $(".ac_input").change(function(){
                                        //alert('hi');    
                                    });
				
				/* keep search values selected */
				<?php if($posted["txt_address_src"]) { ?>
				$("#search02").val('<?php echo $posted["txt_address_src"]; ?>');
				<?php } if($posted["src_i_check_in"]) { ?>		
				$("#i_check_in").val('<?php echo date("d-m-Y",$posted["src_i_check_in"]); ?>');						
				<?php } if($posted["src_i_check_out"]) { ?>
				$("#i_check_out").val('<?php echo date("d-m-Y",$posted["src_i_check_out"]); ?>');<?php } ?>
				/* keep search values selected */
				
				// room type checked  and amenity checked
			
				// when any check box of room type is selected
				$(".box02 .checkbox-select").click(
					function() { 
						$(this).prev().attr("checked","checked");
						var str = return_selected('room_type');						
						$("#h_str_room").val(str);						
						$("#frm_src_properties").submit();	
						
					}
				);
				// when any check box of room type is de-selected
				$(".box02 .checkbox-deselect").click(
					function() { 
						$(this).prev().attr("checked","");
						var str = return_selected('room_type');											
						$("#h_str_room").val(str);						
						$("#frm_src_properties").submit();	
						
					}
				);
				
				// when any check box of amenity is selected
				$(".box03 .checkbox-select").click(
					function() { 
						$(this).prev().attr("checked","checked");
						var str = return_selected('prop_amenity');
						$("#h_str_amenity").val(str);						
						$("#frm_src_properties").submit();	
						
					}
				);
				// when any check box of amenity is de-selected
				$(".box03 .checkbox-deselect").click(
					function() {
						$(this).prev().prev().attr("checked","");
						var str = return_selected('prop_amenity');
						$("#h_str_amenity").val(str);						
						$("#frm_src_properties").submit();	
						
					}
				);
				
				// function that return the string
				var return_selected = function(class_name){
				var str = '';
									$("."+class_name+":checked").each(function(i){									
												str+=$(this).val()+',';					
											});
											return str;
										};
										
				
				
				// more link click
				$(".more_link").click(function(){
					$("#[id^=amenity_boxes_]").css({'display':'block'});
				});			
				
			
		});
		
	});	
	
	
	
-->
</script>	
<style>
.dd .ddTitle{ line-height:18px;}
</style>						
<!--search bar-->
<style>
	#demo-frame > div.demo { padding: 10px !important; };
	
</style>
<script>
$(window).load(function() {
/*ui-slider-handle ui-state-default ui-corner-all*/
$(".ui-corner-all a").css({"width":"10px"});

});
	$(function() {
		$( "#slider-range" ).slider({
			range: true,
			min: 0,
			max: 500,
			step:10,
			values: [ 0, 500 ],
			slide: function( event, ui ) {
				
				$("#min_range").text(ui.values[ 0 ]);
				$("#max_range").text(ui.values[ 1 ]);
				
			} ,
            stop: function(event, ui) {
				var price_start = ui.values[ 0 ];
				var price_end	= ui.values[ 1 ];
				/*alert(price_start) ;
				alert(price_end) ;*/
					$.ajax({
							type: "POST",
							async: false,
							url: base_url+'search/ajax_property_list',
							data: "price_start="+price_start+"&price_end="+price_end,
							success: function(msg){
								if(msg)
								{
									//alert(msg);
									$("#property_list").html(msg);
								}
							}
						});  // end ajax
           
            }
		});
		
		
          $("#min_range").text($( "#slider-range" ).slider( "values", 0 ));
          $("#max_range").text($( "#slider-range" ).slider( "values", 1 ));   
			
	});
</script>
<?php //pr($posted["src_room_type"]) ?>
<div class="search-bg">
	  <form name="frm_src_properties" id="frm_src_properties" action="<?php echo base_url().'search' ?>" method="post" >
			<div class="search-box-bg">
				  <input name="txt_search" type="text" id="search02"/>
				  <input class="search" type="button" value=""/>
			</div>
			<div class="label-box">Check-in</div>
			<div class="small-textfell02">
				  <input name="i_check_in" type="text" id="i_check_in" readonly="readonly" value="<?php echo ($i_check_in)?$i_check_in:"dd-mm-yyyy" ; ?>" />
			</div>
			<div class="label-box">Check-Out</div>
			<div class="small-textfell02">
				  <input name="i_check_out" type="text" id="i_check_out"  readonly="readonly" value="<?php echo ($i_check_out)?$i_check_out:"dd-mm-yyyy" ; ?>" />
			</div>
			<div class="label-box">Guests</div>
			<div class="textfell03">
				  <select id="guests" name="guests" style=" width:99px; line-height:20px;">
					 <?php for($i=1;$i<=10;$i++) { ?>
					   <option <?php echo ($posted["src_total_guests"]==$i)?"selected='selected'":""; ?> value="<?php echo $i ?>"><?php echo $i ?></option>
					  <?php } ?>
				  </select>
			</div>
			<input type="hidden" name="h_str_room" id="h_str_room" value="<?php echo $posted["src_room_type"] ?>" />
			<input type="hidden" name="h_str_amenity" id="h_str_amenity" value="<?php echo $posted["src_amenity"] ?>" />
			<input type="button" value="" class="search-button" id="btn_search_bar" />
			<br class="spacer" />
	  </form>
</div>
<!--search bar-->
<!--type-box-->
<div class="type-box">
	  <div class="inner-box">
			<!--Price per night-->
			<!--<div class="box01">
				  <h2 class="float02">Price Per Night</h2>
				  <div class="border02 spacer">&nbsp;</div>
				  <div class="price-bar">
						<div class="price-tag"><img src="images/fe/price-bar.png" alt="price-bar" /></div>
						<div class="price-tag02"><img src="images/fe/price-bar.png" alt="price-bar" /></div>
				  </div>
				  <span class="margin02">&#163; 0</span> <span>&#163; 400+</span> 
			</div>-->
					
				<!-- Start demo -->
				<div class="box01">
					<div class="demo">
					<p>
						<label for="amount" style="font-size:16px; color:#333333;">Price range (<?php echo $this->curSymbol ?>) :</label>
						<!--<input type="text" id="amount" style="border:0; color:#f6931f; font-weight:bold;" />-->
					</p>				
					<div id="slider-range" style="height:10px;"></div>	
					<span id="min_range" style="float:left; margin-top:5px;"></span>
					<span id="max_range" style="float:right; margin-top:5px;"></span>			
					</div>
				</div>	
				<!-- End demo -->
			<!--Price per night-->
			<!--Room Type -->
			<?php $str_room = explode(',',$posted["src_room_type"]); //pr($str_room); ?>
			<div class="box02">
				  <h2 class="float02">Room Type </h2>
				  <div class="border02 spacer">&nbsp;</div>
				  <div class="checklist" >
						<div class="checkbox_list <?php echo (in_array('3',$str_room))?"selected":""; ?>">
							  <input class="room_type" <?php echo (in_array('3',$str_room))?"checked":""; ?> name="room_type" value="3" type="checkbox" id="choice_contact_3"/>
							  <a class="checkbox-select" href="javascript:void(0);">Select</a> 
							  <a class="checkbox-deselect" href="javascript:void(0);">Cancel</a>
							  <div class="checkbox_txt">Entire Home/Apartment</div>
							  <div class="pop-up"> <a href="javascript:void(0);" title="Entire Home/Apartment" class="masterTooltip"></a> 
							  <img src="images/fe/pop-up.png" class="masterTooltip" title="Entire Home/Apartment" alt="pop-up" /></div>
							  <div class="spacer"></div>
						</div>
						
				  </div>
				  <br class="spacer" />
				  <div class="checklist">
						<div class="checkbox_list <?php echo (in_array('1',$str_room))?"selected":""; ?>">
							  <input class="room_type" <?php echo (in_array('1',$str_room))?"checked":""; ?> name="room_type" value="1" type="checkbox" id="choice_contact_1"/>
							  <a class="checkbox-select" href="javascript:void(0);">Select</a> 
							  <a class="checkbox-deselect" href="javascript:void(0);">Cancel</a>
							  <div class="checkbox_txt">Private Room</div>
							  <div class="pop-up"> <a href="javascript:void(0);" title="This will show up in the tooltip" class="masterTooltip"></a> 
							  <img src="images/fe/pop-up.png" class="masterTooltip" title="Private Room" alt="pop-up" /></div>
							  <div class="spacer"></div>
						</div>
				  </div>
				  <br class="spacer" />
				  <div class="checklist">
						<div class="checkbox_list <?php echo (in_array('2',$str_room))?"selected":""; ?>">
							  <input class="room_type" <?php echo (in_array('2',$str_room))?"checked":""; ?> name="room_type" value="2" type="checkbox" id="choice_contact_2"/>
							  <a class="checkbox-select" href="javascript:void(0);">Select</a> 
							  <a class="checkbox-deselect" href="javascript:void(0);">Cancel</a>
							  <div class="checkbox_txt">Shared Room</div>
							  <div class="pop-up"> <a href="javascript:void(0);" title="This will show up in the tooltip" class="masterTooltip"></a> 
							  <img src="images/fe/pop-up.png" class="masterTooltip" title="Shared Room" alt="pop-up"/></div>
							  <div class="spacer"></div>
						</div>
				  </div>
			</div>
			<!--Room Type -->
			<!--Amenities -->
			
			<?php $str_amenity = explode(',',$posted["src_amenity"]); //pr($str_room); ?>
			<div class="box03">
				  <h2 class="float02">Amenities</h2>
				  <?php if(count($amenity)>3) { ?>
				  <div class="more">
				  <a href="javascript:void(0);" class="more_link"><img src="images/fe/more-icon.png" alt="" /></a>
				  <a href="javascript:void(0);">more</a>
				  </div>
				  <?php } ?>
				  <div class="border02 spacer">&nbsp;</div>
				  <div id="old_amenity" style="display:block">
				  <?php if($amenity) {
				  		$i =1;
				  	
						foreach($amenity as $key => $value)
						{							
							$class = ($key>2)?"style=\"display:none\"":"";
					 ?>
						<div class="checklist" <?php echo $class ?> id="amenity_boxes_<?php echo $key?>">
							  <div class="checkbox_list <?php echo (in_array($value["id"],$str_amenity))?"selected":""; ?>">
									<input name="i_amenity[]" <?php echo (in_array($value["id"],$str_amenity))?"checked":""; ?> class="prop_amenity" value="<?php echo $value["id"];?>" type="checkbox" id="choice_contact_0<?php echo $value["id"];?>"/>
									<a class="checkbox-select" href="javascript:void(0);">Select</a> 
									<a class="checkbox-deselect" href="javascript:void(0);">Cancel</a>
									<div class="checkbox_txt"><?php echo $value["s_name"] ?></div>
									<div class="spacer"></div>
							  </div>
						</div>
						<br class="spacer" />
					<?php  $i++;
							} 
						} 
					?>
					</div>
				 
				  
			</div>
			<!--Amenities -->
			
			<br class="spacer" />
	  </div>
</div>
<!--type-box-->