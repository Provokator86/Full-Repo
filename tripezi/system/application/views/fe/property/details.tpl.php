<script type="text/JavaScript" src="js/fe/tab.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery/ui/jquery-ui-1.8.4.custom.js"></script>
<script type="text/javascript">

    
$(document).ready(function(){
    
    ////////datePicker/////////
/*
$("input[name^='txt_check_']").datepicker({dateFormat: 'dd-mm-yy',
                                               changeYear: true,
                                               changeMonth:true,
                                               useThisTheme: 'redmond'

                                              }); */

    $( "#txt_check_in" ).datepicker({
            dateFormat: 'dd-mm-yy',
            
            minDate : 0,
            changeYear: true,
            changeMonth: true,
            onSelect: function( selectedDate ) {
                $( "#txt_check_out" ).datepicker( "option", "minDate", selectedDate );
                request_for_book();
            }
        });
        $( "#txt_check_out" ).datepicker({
            dateFormat: 'dd-mm-yy',
           
            minDate : 0,
            changeYear: true,
            changeMonth: true,
            onSelect: function( selectedDate ) {
                $( "#txt_check_in" ).datepicker( "option", "maxDate", selectedDate );
                request_for_book();
              
            }
            
        });
		
		$('#ui-datepicker-div').hide();   // to hide the ui-datepicker-div 	
        
        
            var request_for_book    =   function(){
            
            var dt_check_in     =   $("#txt_check_in").val() ;
            var dt_check_out    =   $("#txt_check_out").val() ;
          
            if(dt_check_in!='' && dt_check_out!='' && dt_check_in!='dd-mm-yy' && dt_check_out!='dd-mm-yy')
            {
                if(compair_date(dt_check_in,dt_check_out,'-'))
                {
                    $('#frm_request').submit();
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
           
            
        };

    
var index = 2;
	$('.tab-content ul li a').removeClass();
	$('.tab-content ul li a').filter(':eq(' + index + ')').addClass('select');
	
	$('.tab-details > div.details').hide();
	$('.tab-details > div.details').filter(':eq(' + index + ')').fadeIn('slow');
	<?php if($index=='availability')
    {
        ?>
	setTimeout('my_custom(1)',0);
    <?php
    } else {
	?>
	setTimeout('my_custom(0)',0);	
	<?php
	}
?>
    
    $(".ddChild a[id^=selectmonth_]").click(function(){
        $("#frm_month").submit();
        });
   
   var enable_request_btn   =   '<?php echo $enable_request_btn ; ?>'     ;
        
    $("#btn_booking").click(function(){
        
        if(enable_request_btn==1)
        {
            show_dialog('photo_zoom11');
            //
        }
        else
        {
            return false ;
        }
        
    });
    
   $("#btn_confirm_booking").click(function(){
       
       $("#h_message").val($("#ta_message").val());
       $("#frm_booking").submit();    
       
   })  ;
	
	// when click on button check availability select availabilty tab
	$("#btn_available, #btn_available_1").click(function(){
	
		var index = 1;
		$('.tab-content ul li a').removeClass();
		$('.tab-content ul li a').filter(':eq(' + index + ')').addClass('select');
		
		$('.tab-details > div.details').hide();
		$('.tab-details > div.details').filter(':eq(' + index + ')').fadeIn('slow');
        
    	});
	// when click on button check availability	
        
	});
	
	function my_custom(indx)
	 { 
	 	$('.tab-content ul li a').removeClass();
		$('.tab-content ul li a').filter(':eq(' + indx + ')').addClass('select');
	
		$('.tab-details > div.details').hide();
		$('.tab-details > div.details').filter(':eq('+indx+')').fadeIn('slow');
	 }
     
     function compair_date(dt_from,dt_to,split_param)
     {
         
         var arr_dt_from    =   dt_from.split(split_param);
         var arr_dt_to      =   dt_to.split(split_param);
         
         if(arr_dt_to[2]>arr_dt_from[2])
         {
              return true;
         }
         else if(arr_dt_to[2]==arr_dt_from[2])
         {
             if(arr_dt_to[1]>arr_dt_from[1])
             {
                 return true;
             }
             else if(arr_dt_to[1]==arr_dt_from[1])
             {
                 if(arr_dt_to[0]>arr_dt_from[0])
                 {
                     return true ;
                 }
             }
             
                 
         }
         
         return false;

     }
	 
	 /**
	* This function is to show the shadow box cancellation policy of booking 
	*/
	function show_policy(policy_id)
	{
	   
		jQuery(function($){
			$.ajax({
								type: "POST",
								async: false,
								url: base_url+'property/ajax_fetch_policy',
								data: "policy_id="+policy_id,
								success: function(msg){
									if(msg)
									{
									$("#policy_show").html(msg)   ;                                                        
									 show_dialog('photo_zoom05');
									}
								}
							});
		});
		
	}
	
	/**
	* This function is to add favourites a property
	*/
	function addToFavourite(property_id,cur_obj)
	{
		jQuery(function($){
			$("#err_msg").removeClass('success_massage error_massage');
			$.ajax({
						type: "POST",
						async: false,
						url: base_url+'property/ajax_add_favourite',
						data: "property_id="+property_id,
						success: function(msg){
							if(msg)
							{                                                        
								if(msg=='ok')
								{
									$('#div_err_').html('<div id="err_msg" class="success_massage">Property has been added to favourite succesfully</div>').show('slow').delay(2000).hide(500);
									$(cur_obj).parent().html('<a href="javascript:void(0);" onclick="removeFavourite('+property_id+',this)">Remove Favourites</a>');
								  
								}
								else if(msg=='login_error')
								{
									$('#div_err_').html('<div id="err_msg" class="error_massage">Please login to add favourite.</div>').show('slow').delay(2000).hide(500);
								}
								else if(msg=='owner_error')
								{
									$('#div_err_').html('<div id="err_msg" class="error_massage">You can not add your own property to favourite.</div>').show('slow').delay(2000).hide(500);
								}
								else if(msg=='exist')
								{
									$('#div_err_').html('<div id="err_msg" class="error_massage">You have already been added this property to favourite.</div>').show('slow').delay(2000).hide(500);
								}
								
							}
						}
					});
		});
		
	}
	
	/**
	* This function is to remove favourites a property
	*/
	function removeFavourite(property_id,cur_obj)
	{
	
		jQuery(function($){
			$("#err_msg").removeClass('success_massage error_massage');
			$.ajax({
								type: "POST",
								async: false,
								url: base_url+'property/ajax_remove_favourite',
								data: "property_id="+property_id,
								success: function(msg){
									if(msg)
									{                                                           
										if(msg=='ok')
										{
											$('#div_err_').html('<div id="err_msg" class="success_massage">Removed from favourite succesfully</div>').show('slow').delay(2000).hide(500);											
											$(cur_obj).parent().html('<a href="javascript:void(0);" onclick="addToFavourite('+property_id+',this)">Add to Favourites</a>');
										  
										}
										else if(msg=='error')
										{
											$('#div_err_').html('<div id="err_msg" class="error_massage">Failed to remove from  favourite.</div>').show('slow').delay(2000).hide(500);
										}
										
									}
								}
							});
		});
		
	}


</script>
<!--photo-gallery-->
<script type="text/javascript" src="js/fe/jquery.ad-gallery.js"></script>
<link href="css/fe/photo-gallery.css" rel="stylesheet" type="text/css" />
<!--photo-gallery-->
<!--Tooltip-->
<script type="text/javascript" src="js/fe/tooltip.js"></script>
<!--Tooltip-->
                
<script type="text/javascript">
			function gmap_marker_clicked($link,$id,$add_ref_index)
			{
				//alert($link + ', ' + $id + ', ' + $add_ref_index);                    
			   // location = $link;                    
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

<style>
#table_calender th { width: 80px;}
</style>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>

<div class="container-box">
	<!--search bar-->
<div id="div_err_">
</div>
    <?php include_once(APPPATH."views/fe/common/message.tpl.php"); ?>
	<?php include_once(APPPATH."views/fe/common/search_details_bar.tpl.php"); ?>
	<!--search bar-->
	<!-- right panel -->
	<?php include_once(APPPATH."views/fe/common/search_details_right_panel.tpl.php"); ?>
	<!-- right panel -->
	
	
	<div class="search-details-left">
 
		  <div class="property-headline"><?php echo $info["s_property_name"] ?> <!--<br />
				(Prenzlauer Berg)--></div>
		  <div class="favorites02">
				<h6>		
				<?php if($i_favourite==0) { ?>
				<a href="javascript:void(0);" onclick="addToFavourite('<?php echo $info["id"] ?>',this)">Add to Favourites </a>
				<?php } else { ?>
				<a href="javascript:void(0);" onclick="removeFavourite('<?php echo $info["id"] ?>',this)">Remove Favourites </a>
				<?php } ?>
				
				</h6>
				<div class="favorites-icon">
				<a href="javascript:void(0);"><img src="images/fe/favorites.png" alt="favorites" /></a>
				</div>
		  </div>
		  <br class="spacer" />
		  <div class="property-sub-headline"><?php echo $info["e_accommodation_type"] ?> - <?php echo $info["s_city"].', '.$info["s_zipcode"].' ',$info["s_state"].', '.$info["s_country"] ?> </div>
		  <p><?php echo show_star($info["review_rate"]["avg_rating"]) ?> <?php echo $info["review_rate"]["i_total"] ?> reviews </p>
		  <div class="tab-box">
				<div class="tab-content">
					  <ul>
							<li><a  class="select" href="javascript:void(0);"><span>Photos</span></a></li>
							<li><a  href="javascript:void(0);"><span>Availability</span></a></li>
							<li onclick="map_tab_clicked()"><a  href="javascript:void(0);"><span>Map</span></a></li>
							<li><a href="javascript:void(0);"><span>Video</span></a></li>
					  </ul>
				</div>
				<!--tab_details-->
				<div class="tab-details tab-details02">
					  <!--1st tab-->
				  <div class="details">
					<div id="container">
					  <div id="gallery" class="ad-gallery">
						<div class="ad-image-wrapper"> </div>
						<div class="ad-nav">
						  <div class="ad-thumbs">
							<ul class="ad-thumb-list">
							 <?php  
								if($arr_image)
								{
									foreach($arr_image as $val)
									{ ?>
									   <li> <a href="<?php echo base_url()."uploaded/property/large/".$val["large"] ?>"><img src="<?php echo base_url()."uploaded/property/min/".$val["min"] ?>" alt=""  title="" /></a> </li> 
						  
							 <?php                
									}
						   
									
								} 
							?>
							</ul>
								<div class="spacer"></div>
						  </div>
						</div>
							<div class="spacer"></div>
					  </div>
					</div>
						<div class="spacer">&nbsp;</div>
						
				  </div>
					  <!--1st tab-->
					  <!--2nd tab-->
					  <div class="details">
							<div class="select-month-box">
                            <form action="" method="post" name="frm_month" id="frm_month">
								  <div class="lable08">Select Month</div>
								  <select id="selectmonth" name="selectmonth" style="width:146px;">								  		
										<?php echo makeOptionMonthYear($selected_month); ?>
								  </select>
                            </form>
								  <br class="spacer" />
							</div>
                           
							<div class="calendar">
								  <table id="table_calender" width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr>
											  <th align="center" valign="middle">Mon</th>
											  <th align="center" valign="middle" class="white-bg">&nbsp;</th>
											  <th align="center" valign="middle">Tue</th>
											  <th align="center" valign="middle" class="white-bg">&nbsp;</th>
											  <th align="center" valign="middle">Wed</th>
											  <th align="center" valign="middle" class="white-bg">&nbsp;</th>
											  <th align="center" valign="middle">Thu</th>
											  <th align="center" valign="middle" class="white-bg">&nbsp;</th>
											  <th align="center" valign="middle">Fri</th>
											  <th align="center" valign="middle" class="white-bg">&nbsp;</th>
											  <th align="center" valign="middle">Sat</th>
											  <th align="center" valign="middle" class="white-bg">&nbsp;</th>
											  <th align="center" valign="middle">Sun</th>
										</tr>
                                        <?php
                                        $start_date =   $start_day ;
                                        $start_date =   ($start_date==0)?7:$start_date ;
                                        $end_date   =   $total_days ;
                                        $tmp      =     ($start_date+$end_date)%7 ;  
                                        
                                        $loop_end   =   $start_date+$end_date+(7-$tmp);
                                        
                                        //for($i=1;$i<=35;$i++)
                                        $i  = 1;
                                    
                                        while($i<=$loop_end)
                                        {

                                            if($i==$start_date)
                                            {
                                                $date   =   1;
                                              
                                            }
                                            else if($i<$start_date )
                                            {
                                                 $date   =   "&nbsp;";
                                            }
                                            else 
                                            {
                                                $date   += 1;
                                               
                                            }
                                            $show_date  =  ($date<=$end_date)?$date:"&nbsp;"; 
                                            
                                            if(in_array($show_date,$array_request))
                                            {
                                                $class  =   'request' ;
                                            }
                                            else if(in_array($show_date,$info_blocked)) 
                                            {
                                                 $class  =   'booked' ;
                                            }
                                            else
                                            {
                                                $class  =   '';
                                            }
                                          
                                            ?> 
                                            
                                                 <td align="center" class="<?php echo $class; ?>"  valign="middle"><?php echo $show_date ?></td>
                                                 <th align="center" valign="middle" class="white-bg">&nbsp;</th>
                                           <?php     
                                           if($i%7==0)
                                            { ?>
                                                </tr>
                                            <?php
                                            }
                                            $i++;
                                            ?>
                                            
                                        <?php
                                        }
                                        ?>
										<!--<tr>
											  <td align="center" valign="middle">&nbsp;</td>
											  <th align="center" valign="middle" class="white-bg">&nbsp;</th>
											  <td align="center" valign="middle">2</td>
											  <th align="center" valign="middle" class="white-bg">&nbsp;</th>
											  <td align="center" valign="middle">3</td>
											  <th align="center" valign="middle" class="white-bg">&nbsp;</th>
											  <td align="center" valign="middle">4</td>
											  <th align="center" valign="middle" class="white-bg">&nbsp;</th>
											  <td align="center" valign="middle">5</td>
											  <th align="center" valign="middle" class="white-bg">&nbsp;</th>
											  <td align="center" valign="middle">6</td>
											  <th align="center" valign="middle" class="white-bg">&nbsp;</th>
											  <td align="center" valign="middle">7</td>
										</tr>-->
										
								  </table>
							</div>
							
							<div class="calendar-info">
								  <ul>
										<li><img src="images/fe/available-icon.png" alt="" /> Available </li>
										<li><img src="images/fe/booked-icon.png" alt="" />Booked </li>
								  </ul>
								  <p>Prices shown in the calendar do not include the service charge, potential cleaning fees or fees for additional guests.</p>
							</div>
							<div class="spacer"></div>
                             <form action="" method="post" name="frm_booking" id="frm_booking">
                             <input type="hidden" value="1" name="h_form">
                             <input type="hidden" value="" name="h_message" id="h_message">  
							<input class="green-button-big float-right" name="btn_booking" id="btn_booking" type="button" value="Request Booking" />
                            </form>
                            <form action="" method="post" name="frm_request" id="frm_request">
                              <div class="date-box">
                                        <div class="text-box">Check-In</div>
                                        <div class="select-box">
                                        <input name="txt_check_in" type="text" value="<?php echo ($txt_check_in)?$txt_check_in:"dd-mm-yyyy" ; ?>" id="txt_check_in" readonly="readonly"/></div>
                                        
                                         <div class="text-box">Check-Out</div>
                                        <div class="select-box">
                                        <input name="txt_check_out" type="text" value="<?php echo ($txt_check_out)?$txt_check_out:"dd-mm-yyyy" ; ?>" id="txt_check_out" readonly="readonly"/></div>
                              </div>
                              </form>
							<br class="spacer" />
					  </div>
					  <!--2nd tab-->
					  
					  <!-- SHOW MAP HERE -->
					  <div class="details">
							
                             <?php
                
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
                $arr_param['width']='593px';
                $arr_param['height']='342px';
                $arr_param['map_type_id']='ROADMAP'; // 'ROADMAP', 'HYBRID'
                $arr_param['map_type_control']=true; // true, false
                $arr_param['zoom_control']='LARGE'; // 'SMALL', 'LARGE', ''
                
                $arr_param['map_address']=array();
                
                $arr_param['map_address'][]=array(    'address_or_latlng'=>   $info['s_lattitude'].','.$info['s_longitude'],
                                                    'title'=>                $info['s_property_name'],
                                                    'link_or_html'=>        base_url().'property/details/'.encrypt($info[id]),
                                                    'icon'=>                base_url()."no_imaged/index/1");                                                    
                
            
                                    
                $arr_param['create_canvas_on_init']=false;
                LIB_GMAP_INIT($arr_param);
                
                
                ?>
							<div class="tab-map-box" id="map">	  
							</div>
                            <script type="text/javascript">
                                var map_created = false;
                                function map_tab_clicked()
                                {
                                    if(!map_created)
                                    {
                                        map_created = true;
                                        LIB_GMAP_INIT_JS('map','test_id','593px','342px','ROADMAP',true,'LARGE');
                                        var arr_marker = <?=json_encode($arr_param['map_address'])?>;
                                        LIB_GMAP_MARKER_ADD_ARR("test_id",arr_marker);
                                    }
                                }
                            </script>
					  </div>
					  <!-- SHOW MAP HERE -->
					  <!--4th tab-->
					  <div class="details">
							<div class="tab-map-box"><?php echo $info["s_youtube_snippet"] ?></div>
					  </div>
					  <!--4th tab-->
				</div>
				<!--tab_details-->
				<div class="spacer">&nbsp;</div>
				<!--details part-->
				<div class="details-part">
					  <div class="left-part02">
							<div class="left-part03">
								  <h2 class="text-bold">Quick Overview</h2>
								  <div class="overview-box">
										<div class="tagline">The Place </div>
										<ul>
											  <li><span class="text01">Property Type:</span> <span class="text02"><?php echo $info["s_property_type_name"] ?></span></li>
											  <li><span class="text01">Accommodation:</span> <span class="text02"><?php echo $info["e_accommodation_type"] ?></span>
												<div class="pop-up margintop"> 
													<a href="javascript:void(0);" title="<?php echo $info["e_accommodation_type"] ?>" class="masterTooltip"></a> 
													<img src="images/fe/pop-up.png" class="masterTooltip" title="<?php echo $info["e_accommodation_type"] ?>" alt="pop-up" />
												</div>
											  </li>
											  <li><span class="text01">Bedrooms:</span><span class="text02"><?php echo $info["i_total_bedrooms"] ?></span></li>
										</ul>
										<br class="spacer" />
								  </div>
								  <div class="overview-box">
										<div class="tagline">Prices</div>
										<ul>
											  <li><span class="text01"> Standard Price:</span> <span class="text02"><?php echo showAmountCurrency(getAmountByCurrency($info["d_standard_price"],$info["i_currency_id"])) ?> </span></li>
											  <li><span class="text01">Weekly Rate:</span> <span class="text02"><?php echo showAmountCurrency(getAmountByCurrency($info["d_weekly_price"],$info["i_currency_id"])) ?> </span></li>
											  <li><span class="text01">Monthly Rate:</span><span class="text02"><?php echo showAmountCurrency(getAmountByCurrency($info["d_monthly_price"],$info["i_currency_id"])) ?> </span></li>
											  <li><span class="text01">Additional Guests ( > 1):</span><span class="text02"><?php echo showAmountCurrency(getAmountByCurrency($info["d_additional_price"],$info["i_currency_id"])) ?> </span></li>
											  <li><span class="text01">Cleaning Fee:</span><span class="text02"><?php echo showAmountCurrency(getAmountByCurrency($info["d_cleaning_fee"],$info["i_currency_id"])) ?></span></li>
										</ul>
										<br class="spacer" />
								  </div>
								  <div class="overview-box last-box">
										<div class="tagline">Conditions </div>
										<ul>
											  <li><span class="text01">Check-in After:</span> <span class="text02"><?php echo $info["i_checkin_after"]<12?$info["i_checkin_after"].' AM':($info["i_checkin_after"]-12).' PM' ?> </span></li>
											  <li><span class="text01">Check-out Before:</span> <span class="text02"><?php echo $info["i_checkout_before"]<12?$info["i_checkout_before"].' AM':($info["i_checkin_after"]-12).' PM' ?> </span></li>
											  <li>
											  <span class="text01">Cancellation Policy:</span><span class="text02">
											  <a onclick="show_policy('<?php echo $info["i_cancellation_policy_id"] ?>')" href="javascript:void(0);"><?php echo $info["s_cancellation_policy_name"]?></a>
											 </span>
											  </li>
										</ul>
										<br class="spacer" />
								  </div>
							</div>
					  </div>
					  <div class="right-part04">
							<h2 class="text-bold">Description</h2>
							<p><?php echo $info["s_description"]?></p>
							<h2 class="text-bold">Amenities</h2>
							<div class="amenities">
								  <ul>
								  	<?php if($info_amenity) { 
											foreach($info_amenity as $val)
												{
									 ?>
										<li><?php echo $val["s_name"] ?> </li>
										
									<?php } } ?>	
								  </ul>
								  <br class="spacer" />
							</div>
							<h2>Location &amp; contact information </h2>
							<p class="width02"><?php echo $owner_info["s_address"] ?> <br />
								  City: <?php echo $owner_info["s_city"] ?>
								  County: <?php echo $owner_info["s_country"] ?>
								  State: <?php echo $owner_info["s_state"] ?></p>
								  <?php if(!empty($loggedin)) { ?>
							<?php /*?><p class="width03">Land Number: 01457 913573
								  Mobile Phone: <?php echo $owner_info["s_"] ?></p><?php */?>
								  <?php } ?>
					  </div>
					  <div class="spacer">&nbsp;</div>
				</div>
				<!--details part-->
				<div class="reviews-box">
					  <h2>Reviews</h2>
					  <?php if($reviews) {
					  		foreach($reviews as $val)
								{
					   ?>
					  <div class="reviews">
							<div class="left-photo"><?php echo showThumbImageDefault('user_image',$val["s_owner_image"],'min',75,53) ?></div>
							<div class="right-text-box">
								  <div class="reviews-bg-top">&nbsp;</div>
								  <div class="reviews-bg">
										<div class="pro-photo"><?php echo showThumbImageDefault('review_image',$val["s_review_image"],'thumb',74,64) ?></div>
										<div class="comm-box">
											  <div class="star"><?php echo show_star($val["i_rating"])?> <?php echo $val["dt_reviewed_on"] ?></div>
											  <p><?php echo $val["s_comment"] ?></p>
										</div>
										<br class="spacer" />
								  </div>
								  <div class="reviews-bg-bottom">&nbsp;</div>
								  <div class="tick02">&nbsp;</div>
							</div>
							<br class="spacer" />
					  </div>
					  
					  <?php } } else { ?>
					  <div class="reviews"><p>No review found.</p></div>
					  <?php } ?>
					  
				</div>
				<br class=" spacer" />
				<div class="back02"><a href="<?php echo base_url().'search' ?>">Back to search results</a></div>
		  </div>
	</div>
	<br class="spacer" />
</div>

 <!-- lightbox for cancellation policy -->
<div class="light-box photo_zoom05">
      <div class="close"><a href="javascript:void(0)" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
      <h4>Cancellation Policy</h4>
	  <!-- review content div -->
	  <div id="policy_show">
      </div>   
	  <!-- review content div -->  
      <div class="spacer"></div>
      
      
</div>
<!--lightbox-->

<!--lightbox-->
<div class="light-box  photo_zoom11">

    <div class="close"><a href="javascript:void(0)" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
        <h4>Confirm Booking</h4>
        <div class="subscribe-nobg">
        <label>Put a message to owner (It is optional)</label>
        <div >
        <textarea name="ta_message" id="ta_message" cols="40" rows="7"></textarea>
        
        </div>
      
        
        
        <input  type="button" value="Confirm Booking" id="btn_confirm_booking" name="btn_confirm_booking" class="button-blu" style="margin-top:10px;"/>
    </div>
</div> 
<!--lightbox-->