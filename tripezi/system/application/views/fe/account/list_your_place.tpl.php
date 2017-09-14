<script  src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=AIzaSyBHPlLfaZVo_j-5yVsSlEdSz3UA-jHecR8"    
    type="text/javascript"></script>
<script type="text/javascript">
jQuery(function($) {
	$(document).ready(function() {
        
        
     <?php if($posted)
        {
            ?>
            $(".err").show();
        <?php
        } 
            ?>    
	
	var s_phone_alert = '';
	<?php if($i_phone_verified==0) { ?>
	s_phone_alert = 'Your phone number verification is must for showcasing your property in lisiting. Please call site admin.';
	<?php } ?>
	
	// fetch cancellation policy details on hovering upon tooltips
	$(".ddChild a[id^=opt_policy_]").click(function(){ 
		var policy_id = $("#opt_policy").val();
		
			$.ajax({
                            type: "POST",
                            async: false,
                            url: base_url+'account/ajax_fetch_cancellation_policy',
                            data: "policy_id="+policy_id,
                            success: function(msg){
                               var s_msg = msg.split('^');
							   	if(s_msg[0]=='ok')
								{							
									$("#cancel_policy_tool").attr('title',s_msg[1]);
								}
								else if(s_msg[0]=='error')
								{
									$("#cancel_policy_tool").attr('title','Cancellation Policy');
								}
							   
                            }                
            });
		
	});
	// fetch cancellation policy details on hovering upon tooltips
	
	$(".numeric_valid").keydown(function(e){
		if(e.keyCode==8 || e.keyCode==9 || e.keyCode==46)
		{
			return true; 
		}    
		if($(this).val().length>9) // check for more than 7 digit
		{
			return false;
		}
		 
		 return (e.keyCode>=48 && e.keyCode<=57 || e.keyCode>=96 && e.keyCode<=105) //Only 0-9 digits are allowed

	})  ;
	
	// add new property
	
	$("#btn_add_property").click(function(){
		var b_valid =   true ;
		var price	=	/^\d+(?:\.\d+)?$/;
		
		
		if(!$("input[name='i_accomodation']:checked").val())
		{
		$("#i_entire_home").parent().parent().next(".err").html('<strong>Please select accommodation type.</strong>').slideDown('slow');       
			b_valid  =  false;
		}
		else
		{
			$("#i_entire_home").parent().parent().next(".err").slideUp('slow').html('');
		}
		if($.trim($("#opt_property_type").val())=="") 
		{               
			$("#opt_property_type").parent().next().next(".err").html('<strong>Please select property type.</strong>').slideDown('slow');        
			b_valid  =  false;
		}
		else
		{
			$("#opt_property_type").parent().next().next(".err").slideUp('slow').html('');
		}
		
		if($.trim($("#opt_bedtype").val())=="") 
		{               
			$("#opt_bedtype").parent().next().next(".err").html('<strong>Please select bed type.</strong>').slideDown('slow');  			    		b_valid  =  false;
		}
		else
		{
			$("#opt_bedtype").parent().next().next(".err").slideUp('slow').html('');
		}
		
		if($.trim($("#i_total_bathroom").val())=="") 
		{            
			$("#i_total_bathroom").parent().next().next(".err").html('<strong>provide total bathroom.</strong>').slideDown('slow');			 			b_valid  =  false;
		}
		else
		{
			$("#i_total_bathroom").parent().next().next(".err").slideUp('slow').html('');
		}
		if($.trim($("#i_total_bedrooms").val())=="") 
		{               
			$("#i_total_bedrooms").parent().next().next(".err").html('<strong>provide total bedrooms.</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#i_total_bedrooms").parent().next().next(".err").slideUp('slow').html('');
		}
		if($.trim($("#i_total_guest").val())=="") 
		{               
			$("#i_total_guest").parent().next().next(".err").html('<strong>provide total guests.</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#i_total_guest").parent().next().next(".err").slideUp('slow').html('');
		}
		/*prices*/
		if($.trim($("#d_standard_price").val())=="") 
		{               
			$("#d_standard_price").parent().next().next(".err").html('<strong>provide standard price.</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else if(price.test($.trim($("#d_standard_price").val()))==false)
		{
			$("#d_standard_price").parent().next().next(".err").html('<strong>provide proper standard price.</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#d_standard_price").parent().next().next(".err").slideUp('slow').html('');
		}
		if($.trim($("#d_monthly_price").val())=="") 
		{               
			$("#d_monthly_price").parent().next().next(".err").html('<strong>provide monthly price.</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else if(price.test($.trim($("#d_monthly_price").val()))==false)
		{
			$("#d_monthly_price").parent().next().next(".err").html('<strong>provide proper monthly price.</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#d_monthly_price").parent().next().next(".err").slideUp('slow').html('');
		}
		if($.trim($("#d_weekly_price").val())=="") 
		{               
			$("#d_weekly_price").parent().next().next(".err").html('<strong>provide weekly price.</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else if(price.test($.trim($("#d_weekly_price").val()))==false)
		{
			$("#d_weekly_price").parent().next().next(".err").html('<strong>provide proper weekly price.</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#d_weekly_price").parent().next().next(".err").slideUp('slow').html('');
		}
		/*if($.trim($("#d_cleaning_price").val())=="") 
		{               
			$("#d_cleaning_price").parent().next().next(".err").html('<strong>provide cleaning price.</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else if(price.test($.trim($("#d_cleaning_price").val()))==false)
		{
			$("#d_cleaning_price").parent().next().next(".err").html('<strong>provide proper cleaning price.</strong>').slideDown('slow');
			b_valid  =  false;
		}*/
		if($.trim($("#d_cleaning_price").val())!="" && price.test($.trim($("#d_cleaning_price").val()))==false)
		{
			$("#d_cleaning_price").parent().next().next(".err").html('<strong>provide proper cleaning price.</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#d_cleaning_price").parent().next().next(".err").slideUp('slow').html('');
		}
		/*if($.trim($("#d_additional_price").val())=="") 
		{               
			$("#d_additional_price").parent().next().next(".err").html('<strong>provide additional price.</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else if(price.test($.trim($("#d_additional_price").val()))==false)
		{
			$("#d_additional_price").parent().next().next(".err").html('<strong>provide proper additional price.</strong>').slideDown('slow');
			b_valid  =  false;
		}*/
		if($.trim($("#d_additional_price").val())!="" && price.test($.trim($("#d_additional_price").val()))==false)
		{
			$("#d_additional_price").parent().next().next(".err").html('<strong>provide proper cleaning price.</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#d_additional_price").parent().next().next(".err").slideUp('slow').html('');
		}
		/*prices*/
		
		/* conditions*/
		if($.trim($("#opt_check_after").val())=="") 
		{               
			$("#opt_check_after").parent().next().next(".err").html('<strong>Please select check in after.</strong>').slideDown('slow');  			    		b_valid  =  false;
		}
		else
		{
			$("#opt_check_after").parent().next().next(".err").slideUp('slow').html('');
		}
		if($.trim($("#opt_check_before").val())=="") 
		{               
			$("#opt_check_before").parent().next().next(".err").html('<strong>Please select check in after.</strong>').slideDown('slow');  			    		
			b_valid  =  false;
		}
		else
		{
			$("#opt_check_before").parent().next().next(".err").slideUp('slow').html('');
		}
		if($.trim($("#opt_policy").val())=="") 
		{               
			$("#opt_policy").parent().next().next(".err").html('<strong>Please select cancellation policy.</strong>').slideDown('slow');  			    		
			b_valid  =  false;
		}
		else
		{
			$("#opt_policy").parent().next().next(".err").slideUp('slow').html('');
		}
		if($.trim($("#opt_max_night").val())=="") 
		{            
			$("#opt_max_night").parent().next().next(".err").html('<strong>Please select maximum night stay.</strong>').slideDown('slow');  			    		
			b_valid  =  false;
		}
		else
		{
			$("#opt_max_night").parent().next().next(".err").slideUp('slow').html('');
		}
		if($.trim($("#opt_min_night").val())=="") 
		{               
			$("#opt_min_night").parent().next().next(".err").html('<strong>Please select minimum night stay.</strong>').slideDown('slow');  			    		
			b_valid  =  false;
		}
		else
		{
			$("#opt_min_night").parent().next().next(".err").slideUp('slow').html('');
		}
		if(parseInt($.trim($("#opt_max_night").val()))<= parseInt($.trim($("#opt_min_night").val()))) 
		{               
			$("#opt_max_night").parent().next().next(".err").html('<strong>Please select maximum night stay greater than minimum stay night.</strong>').slideDown('slow');  			    		
			b_valid  =  false;
		}
		else
		{
			$("#opt_max_night").parent().next().next(".err").slideUp('slow').html('');
		}
		/* end conditions*/
		
		/*Location*/
		if($.trim($("#opt_country").val())=="") 
		{               
			$("#opt_country").parent().next().next(".err").html('<strong>Please select country.</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#opt_country").parent().next().next(".err").slideUp('slow').html('');
		}
		if($.trim($("#opt_state").val())=="") 
		{           
			$("#opt_state").parent().next().next(".err").html('<strong>Please select state.</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#opt_state").parent().next().next(".err").slideUp('slow').html('');
		}
		if($.trim($("#opt_city").val())=="") 
		{               
			$("#opt_city").parent().next().next(".err").html('<strong>Please select city.</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#opt_city").parent().next().next(".err").slideUp('slow').html('');
		}
		if($.trim($("#ta_address").val())=="") 
		{               
			$("#ta_address").next(".err").html('<strong>Please provide address of your property.</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#ta_address").next(".err").slideUp('slow').html('');
		}
		/* END Location */
		
		if($.trim($("#s_name").val())=="") 
		{               
			$("#s_name").parent().next().next(".err").html('<strong>provide property title .</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#s_name").parent().next().next(".err").slideUp('slow').html('');
		}   
		if($.trim($("#s_description").val())=="") 
		{               
			$("#s_description").next(".err").html('<strong>provide property description .</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#s_description").next(".err").slideUp('slow').html('');
		}  
		if($.trim($("#s_house_rules").val())=="") 
		{               
			$("#s_house_rules").next(".err").html('<strong>provide property house rules .</strong>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#s_house_rules").next(".err").slideUp('slow').html('');
		}
		
		/* image upload */
         var count_image =  '<?php echo count($info_image) ?>';
         var photo_empty =   true;
         var photo_type  =   false;      
        $(".fileHidden").each(function(index){
            
            if($(this).val()!='')
            {
                
                var file    =   $(this).val() ;
                var ext     =   file.split('.').pop().toLowerCase();
                
                switch(ext)
                {
                    case 'jpg'  :
                    case 'jpeg' :
                    case 'png'  :
                    case 'gif'  :
                                break;
                    default     :
                               
                               photo_type   =   true ;               
                }
                photo_empty = false ;
            }

        });
        if(photo_empty && count_image==0)
        {
            $("#photo_error").html('<strong>Please provide a property image</strong>').slideDown('slow'); 
            b_valid =   false ;
        }
        else if(photo_type)
        {
            $("#photo_error").html('<strong>Please provide image proper file format</strong>').slideDown('slow');
            b_valid =   false ; 
        }
        else
        {
            $("#photo_error").slideUp('slow').html('');  
        }
        
		
		if(b_valid)
		{
			if(s_phone_alert!='')
			{
				jConfirm(s_phone_alert,'Confirm Dialog',function(r) {  
				
						$("#form_property_add").submit();
					});
				
			}
			else
			{
				$("#form_property_add").submit();
			}
		   
		}
	
	});
    
    $(".fileHidden").change(function(){
       var index    =   $(".fileHidden").index($(this));
       $(".fileVisible").filter(':eq(' + index + ')').find("input").val($(this).val());
    });

	});	
});	

function delete_image(image_id,image_name)
{
        jQuery.noConflict();///$ can be used by other prototype which is not jquery
        jQuery(function($) {
           $.ajax({
                            type: "POST",
                            async: false,
                            url: base_url+'ajax_common/ajax_property_delete_image',
                            data: "image_id="+image_id+'&image_name='+image_name,
                            success: function(msg){
                               // alert(msg);
                               window.location.reload();
                            }                
            });
        });
}


function ajax_change_state_option(ajaxURL,item_id,cngDv)
{
    //alert('i m here');
    jQuery.noConflict();///$ can be used by other prototype which is not jquery
    jQuery(function($) {
        document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
        $.ajax({
                type: "POST",
                url: base_url+'ajax_common/'+ajaxURL,
                data: "country_id="+item_id,
                success: function(msg){
                   if(msg!='')
                   {
                       document.getElementById(cngDv).innerHTML = msg;
                       $("#opt_state").msDropDown();
                       $("#opt_state").hide();
                       $('#opt_state_msdd').css("background-image", "url(images/fe/select-box.png)");
                       $('#opt_state_msdd').css("background-repeat", "no-repeat");
                       $('#opt_state').css("width", "273px"); 
                       $('#opt_state_msdd').css("margin-top", "12px");
                       

                   }   
                }
            });
    });
}

function ajax_change_city_option(ajaxURL,item_id,country_id,cngDv)
{
    //alert('i m here');
    jQuery.noConflict();///$ can be used by other prototype which is not jquery
    jQuery(function($) {
        document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
        $.ajax({
                type: "POST",
                url: base_url+'ajax_common/'+ajaxURL,
                data: "state_id="+item_id+"&country_id="+country_id,
                success: function(msg){
                   if(msg!='')
                   {
                       document.getElementById(cngDv).innerHTML = msg;
                       $("#opt_city").msDropDown();
                       $("#opt_city").hide();
                       $('#opt_city_msdd').css("background-image", "url(images/fe/select-box.png)");
                       $('#opt_city_msdd').css("background-repeat", "no-repeat");
                       $('#opt_city').css("width", "273px"); 
                       $('#opt_city_msdd').css("margin-top", "12px");
                       

                   }   
                }
            });
    });
}
</script>

<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="container-box">
<?php include_once(APPPATH."views/fe/common/message.tpl.php"); ?>
<?php include_once(APPPATH."views/fe/common/account_left_menu.tpl.php"); ?>
	<div class="right-part02">
	  <div class="text-container">
		<div class="inner-box03">
		  <div class="page-name02">Manage View My Property</div>
		  <div class="spacer">&nbsp;</div>
		  	
			  <div class="quick-overview-box">
			  <!-- START FORM -->
			  	<form name="form_property_add" id="form_property_add" action="" method="post" enctype="multipart/form-data">
                <input name="h_id" id="h_id" type="hidden" value="<?php echo $posted['h_id'];?>"/> 
                <input name="h_mode" id="h_mode" type="hidden" value="<?php echo $posted['h_mode'];?>"/> 
				<input name="h_currency_id" id="h_currency_id" type="hidden" value="<?php echo $posted['h_currency_id'];?>"/> 
                
					<h2>Quick Overview</h2>
					<div class="green-bar">The Place </div>
					<h3>Type of Accommodation</h3>
					<ul>
						  <li>
								<input name="i_accomodation" id="i_private_room" type="radio" value="1" <?php if($posted['i_accommodation']=='Private room') { echo 'checked="checked"'; } ?> />
								<p>Private room</p>
								<div class="pop-up margintop02"> 
								<a href="#" title="Private room" class="masterTooltip"></a> 
								<img src="images/fe/pop-up.png" class="masterTooltip" title="Private room" alt="pop-up" />
								</div>								
						  </li>
						  <li>
								<input name="i_accomodation" id="i_shared_room" type="radio" value="2" <?php if($posted['i_accommodation']=='Shared room') { echo 'checked="checked"'; } ?> />
								<p>Shared room</p>
								<div class="pop-up margintop02"> 
								<a href="#" title="Shared room" class="masterTooltip"></a> 
								<img src="images/fe/pop-up.png" class="masterTooltip" title="Shared room" alt="pop-up" />
								</div>
						  </li>
						  <li>
								<input name="i_accomodation" id="i_entire_home" type="radio" value="3" <?php if($posted['i_accommodation']=='Entire home/appartment') { echo 'checked="checked"'; } ?>/>
								<p>Entire home/apartment</p>								 
								<div class="pop-up margintop02"> 
								<a href="#" title="Entire Home/Apartment" class="masterTooltip"></a> 
								<img src="images/fe/pop-up.png" class="masterTooltip" title="Entire home/apartment" alt="pop-up" />
								</div>
								
						  </li>						  
					</ul>
					<div class="err"><?php echo form_error('i_accomodation'); ?></div>
					<br class="spacer" />
					
					<div class="form-left-box">
						  <label class="text">Property Type</label>
						   <br class="spacer" />
						  <select id="opt_property_type" name="opt_property_type" style="width:273px;">
								<option value="">Select</option>
								<?php echo makeOptionPropertyType($arr_property_type,$posted['opt_property_type']); ?>
						  </select>
						  <div class="err"><?php echo form_error('opt_property_type'); ?></div> 
						  <br class="spacer" />
						  <div class="error"></div>
						  <br class="spacer" />
						  
						  <label class="text">Bed Type</label>
						  <select id="opt_bedtype" name="opt_bedtype" style="width:273px;">
								<option value="">Select</option>
								<?php echo makeOptionBedType($arr_bed_type,$posted['opt_bedtype']) ?>
						  </select>
						  <div class="err"><?php echo form_error('opt_bedtype'); ?></div> 
						  <br class="spacer" />
						  <div class="error"></div>
						  <label class="text">Number of Bathrooms:</label>
						  <div class="text-box02">
							<input name="i_total_bathroom" id="i_total_bathroom" class="numeric_valid" type="text" value="<?php echo $posted['i_total_bathroom'] ?>" />							
						  </div>
						  <br class="spacer" />
						  <div class="err"><?php echo form_error('i_total_bathroom'); ?></div> 
					</div>
					<div class="form-right-box">
						  <label class="text">Number of Guests</label>
						  <div class="text-box02">
								<input name="i_total_guest" id="i_total_guest" class="numeric_valid"  type="text" value="<?php echo $posted['i_total_guest'] ?>" />
								
						  </div>
						  <br class="spacer" />
						  <div class="err"><?php echo form_error('i_total_guest'); ?></div>
						  <label class="text">Number of Bedrooms</label>
						  <div class="text-box02">
								<input name="i_total_bedrooms" id="i_total_bedrooms" class="numeric_valid" type="text" value="<?php echo $posted['i_total_bedrooms'] ?>"/>
								
						  </div>
						  <br class="spacer" />
						  <div class="err"><?php echo form_error('i_total_bedrooms'); ?></div>
					</div>
					<div class="spacer">&nbsp;</div>
					<div class="green-bar">Prices</div>
					<div class="form-left-box">
						  <label class="text">Nightly Price</label>
						  <div class="text-box02">
								<input name="d_standard_price" type="text" id="d_standard_price" value="<?php echo $posted['d_standard_price'] ?>"/>
						  </div><span class="price-icon"><?php echo $currency_symbol ?></span> 
						  <div class="err"><?php echo form_error('d_standard_price'); ?></div>
						  
						  <br class="spacer" />
						  <label class="text">Monthly Rate</label>
						  <div class="text-box02">
								<input name="d_monthly_price" type="text" id="d_monthly_price" value="<?php echo $posted['d_monthly_price'] ?>"/>
						  </div>
						  <span class="price-icon"><?php echo $currency_symbol ?></span> 
						  <div class="err"><?php echo form_error('d_monthly_price'); ?></div>
						  <br class="spacer" />
						  
						  
						  <label class="text">Cleaning Fee( Optional)</label>
						  <div class="text-box02">
								<input name="d_cleaning_price" type="text" id="d_cleaning_price" value="<?php echo $posted['d_cleaning_price'] ?>"/>
						  </div>
						  <span class="price-icon"><?php echo $currency_symbol ?></span> 
						  <div class="err"><?php echo form_error('d_cleaning_price'); ?></div>
						  <br class="spacer" />
						  
					</div>
					<div class="form-right-box">
						  <label class="text">Weekly Rate</label>
						  <div class="text-box02">
								<input name="d_weekly_price" type="text" id="d_weekly_price" value="<?php echo $posted['d_weekly_price'] ?>"/>
						  </div>
						  <span class="price-icon"><?php echo $currency_symbol ?></span>
						  <div class="err"><?php echo form_error('d_weekly_price'); ?></div> 
						  <br class="spacer" />
						  
						  <label class="text">Additional Guests (>1) (Optional)</label>
						  <div class="text-box02">
								<input name="d_additional_price" type="text" id="d_additional_price" value="<?php echo $posted['d_additional_price'] ?>"/>
						  </div>
						  <span class="price-icon"><?php echo $currency_symbol ?></span>
						  <div class="err"><?php echo form_error('d_additional_price'); ?></div>
						   <br class="spacer" />
					</div>
					<div class="spacer">&nbsp;</div>
					<div class="green-bar">Conditions </div>
					<div class="form-left-box">
						  <label class="text">Check-In After</label>
						   <br class="spacer" />
                           
						  <select id="opt_check_after" name="opt_check_after" style="width:273px;">
								<option value="">Select</option>
								<?php echo makeOptionTimetable($posted["opt_check_after"]) ?>
						  </select>
						  <div class="err"><?php echo form_error('opt_check_after'); ?></div>
						  <div class="spacer">&nbsp;</div>
						  <div class="error"></div>
						  <label class="text03"> Cancellation Policy </label>
						  <div class="pop-up margintop"> 
							  <!--<a href="#" title="Entire Home/Apartment" class="masterTooltip"></a> -->
							  <img src="images/fe/pop-up.png" id="cancel_policy_tool" class="masterTooltip" title="Cancellation Policy" alt="pop-up" />
						  </div>
						   <br class="spacer" />
						  <select id="opt_policy" name="opt_policy" style="width:273px;">
								<option value="">Select</option>
								<?php echo makeOptionCancellationPolicy($arr_cancellation_policy,$posted["opt_policy"]) ?>
						  </select>
						  <div class="err"><?php echo form_error('opt_policy'); ?></div>
						  <div class="spacer">&nbsp;</div>
						  <div class="error"></div>
						  <label class="text">Maximum-Night Stay</label>
						   <br class="spacer" />
						  <select id="opt_max_night" name="opt_max_night" style="width:273px;">
								<option value="">Select</option>
								<?php echo makeOption($arr_number,$posted["opt_max_night"]) ?>
						  </select>
						  <?php /*?><div class="err"><?php echo form_error('opt_max_night'); ?></div><?php */?>
						  <div class="err">hi</div>
						  <div class="spacer">&nbsp;</div>
						  <div class="error"></div>
					</div>
					<div class="form-right-box">
						  <label class="text">Check-Out Before</label>
						   <br class="spacer" />
						  <select id="opt_check_before" name="opt_check_before" style="width:273px;">
								<option value="">Select</option>
								<?php echo makeOptionTimetable($posted["opt_check_before"]) ?>
						  </select>
						  <div class="err"><?php echo form_error('opt_check_before'); ?></div>
						  <div class="spacer">&nbsp;</div>
						  <div class="error"></div>
						  <label class="text">Minimum-Night Stay</label>
						   <br class="spacer" />
						  <select id="opt_min_night" name="opt_min_night" style="width:273px;">
								<option value="">Select</option>
								<?php echo makeOption($arr_number,$posted["opt_min_night"]) ?>
						  </select>
						  <div class="err"><?php echo form_error('opt_min_night'); ?></div>
						  <div class="spacer">&nbsp;</div>
						  <div class="error"></div>
					</div>
					<div class="spacer">&nbsp;</div>
					<div class="green-bar">Location </div>
					
					<div class="form-left-box">
						  <label class="text">County</label>
						   <br class="spacer" />
						  <select id="opt_country" name="opt_country" style="width:273px;" onchange='ajax_change_state_option("ajax_change_country_with_change_state_option",this.value,"parent_state");'>
								<option value="">Select</option>
								<?php echo makeOptionCountry('',$posted["opt_country"]) ?>
						  </select>
						  <div class="err"><?php echo form_error('opt_country'); ?></div>
						  <div class="spacer">&nbsp;</div>
						  <div class="error"></div>
						  <label class="text">City</label>
						   <br class="spacer" />
						  <div class="text-fell07" id="parent_city" >
                              <select id="opt_city" name="opt_city" style="width:273px;">
								<option value="">Select City</option>
								<?php 
								if($posted['opt_state'])
								{
									
								 echo makeOptionCity(" WHERE i_country_id=".decrypt($posted['opt_country'])." AND i_state_id=".decrypt($posted['opt_state'])." ",$posted['opt_city']); 

								}
									?>
                              </select>
							  <div class="err"><?php echo form_error('opt_city'); ?></div>
                        </div>
						  <div class="spacer">&nbsp;</div>
						  <div class="error"></div>
						  <label class="text">Google Map</label>
						   <br class="spacer" />
                           <div class="text-box02">
                                <input type="text" id="location_on_map" name="location_on_map" value="<?php echo $posted["location_on_map"] ?>" readonly="readonly">
                                <input type="hidden" id="lat" name="lat" value="<?php echo $posted["lat"] ?>">
                                <input type="hidden" id="lng" name="lng" value="<?php echo $posted["lng"] ?>">
                          </div>
                          <a href="javascript:void(0)" class="inline"><span class="price-icon"><img src="images/fe/upload02.gif" alt="gmap" title="gmap"></span></a>
						  <!--<div id="FileUpload13">
								<input type="file" size="84" id="BrowserHidden13" onchange="getElementById('FileField').value = getElementById('BrowserHidden').value;" />
								<div id="BrowserVisible13">
									  <input type="text" id="FileField13" />
								</div>
						  </div>-->
						  <div class="spacer">&nbsp;</div>
					</div>
					
					<div class="form-right-box">
						  <label class="text">State</label>
						   <br class="spacer" />
						  <div class="text-fell07" id="parent_state" >
                              <select id="opt_state" name="opt_state" style="width:273px;">
                                    <option value="">Select State</option>
                                     <?php 
                                    if(decrypt($posted['opt_country']))
                                    {
                                        
                                     echo makeOptionState(" WHERE i_country_id=".decrypt($posted['opt_country']),$posted['opt_state']); 

                                    }
                                        ?>
                              </select>
							  <div class="err"><?php echo form_error('opt_state'); ?></div>
                        </div>
						  <div class="spacer">&nbsp;</div>
						  <div class="error"></div>
						  <label class="text">Zipcode </label>
						  <div class="text-box02">
								<input type="text" id="s_zipcode" name="s_zipcode" value="<?php echo $posted["s_zipcode"] ?>" />
						  </div>
						  <div class="spacer">&nbsp;</div>
						  <div class="error"></div>
						  
					</div>
					
						<div class="spacer">&nbsp;</div>
						  <div class="error"></div>
					 		<label class="text">Address </label>
						  <br class="spacer">
								<textarea id="ta_address" name="ta_address"><?php echo $posted["ta_address"] ?></textarea>
								<div class="err"><?php echo form_error('ta_address'); ?></div>
						  <div class="spacer">&nbsp;</div>
						  <div class="error"></div>
					
					
					<div class="spacer">&nbsp;</div>
					<div class="green-bar">Amenities </div>
					<?php if($amenity) {
						
						foreach($amenity as $value)
						{
					
					 ?>
						<div class="checklist">
							  <div class="checkbox_list <?php echo (in_array($value["s_name"],$arr_amenity))?"selected":""; ?>">
									<input name="i_amenity[]" value="<?php echo $value["id"];?>" type="checkbox" id="choice_contact_0<?php echo $value["id"];?>"/>
									<a class="checkbox-select" href="javascript:void(0);">Select</a> 
									<a class="checkbox-deselect" href="javascript:void(0);">Cancel</a>
									<div class="checkbox_txt"><?php echo $value["s_name"] ?></div>
									<div class="spacer"></div>
							  </div>
						</div>
						<br class="spacer" />
					<?php } } ?>
				
					
					<div class="spacer"></div>
					<div class="green-bar">Photos &amp; Video</div>
					<label class="text">Photos </label>
                    <div class="spacer"></div>
                    <?php if($posted['h_mode'])
                    {
                        ?>
                    <div style="border: 1px solid #454545; width: 560px; height: <?php echo (count($info_image)<6)?"112px":"224px";?>;">
                            <?php 
                                if(!empty($info_image))
                                {
                                    foreach($info_image as $val)
                                    {
                                      
                                        ?>
                                        <div class="photo">
                                            <?php  echo showThumbImageDefault('property_image',$val['s_property_image'],'thumb',100,100); ?> 
                                            <div  class="close_img" ><a href="javascript:void(0);" onclick="delete_image('<?php echo  encrypt($val['id']);?>','<?php echo  $val['s_property_image'];?>');"><img src="images/fe/close_small.png"></a></div>
                                        </div>
                                        <?php                       
                                    }
                                }
                            ?>
                                
                            </div>
                    <?php
                    }
                    ?>
                    <div class="spacer"></div>
                    <div class="err" id="photo_error" ></div>
                    <?php 
                    for($i=0;$i<10-count($info_image);$i++)
                    {
                        ?>
                        <div class="divFileUpload">
                          <input type="file" size="84"  class="fileHidden" name="f_image[]"/>
                          <div class="fileVisible">
                                <input type="text" class="fieldVisible"  />
                          </div>
                    </div>
                    <?php
                    }
                        ?>
                   
				<!--	
					<div class="divFileUpload">
						  <input type="file" size="84"  class="fileHidden"  name="f_image[]"/>
						  <div class="fileVisible">
								<input type="text" class="fieldVisible"  />
						  </div>
					</div>
					<div class="divFileUpload">
						  <input type="file" size="84"  class="fileHidden" name="f_image[]"/>
						  <div class="fileVisible">
								<input type="text" class="fieldVisible"  />
						  </div>
					</div>
					<div class="divFileUpload">
						  <input type="file" size="84"  class="fileHidden" name="f_image[]"/>
						  <div class="fileVisible">
								<input type="text" class="fieldVisible"  />
						  </div>
					</div>
					<div class="divFileUpload">
						  <input type="file" size="84"  class="fileHidden" name="f_image[]"/>
						  <div class="fileVisible">
								<input type="text" class="fieldVisible"  />
						  </div>
					</div>
					<div class="divFileUpload">
						  <input type="file" size="84"  class="fileHidden" name="f_image[]"/>
						  <div class="fileVisible">
								<input type="text" class="fieldVisible"  />
						  </div>
					</div>
					<div class="divFileUpload">
						  <input type="file" size="84"  class="fileHidden" name="f_image[]"/>
						  <div class="fileVisible">
								<input type="text" class="fieldVisible" />
						  </div>
					</div>
					<div class="divFileUpload">
						  <input type="file" size="84"  class="fileHidden" name="f_image[]"/>
						  <div class="fileVisible">
								<input type="text" class="fieldVisible"  />
						  </div>
					</div>
					<div class="divFileUpload">
						  <input type="file" size="84"  class="fileHidden" name="f_image[]"/>
						  <div class="fileVisible">
								<input type="text" class="fieldVisible" />
						  </div>
					</div>
					<div class="divFileUpload">
						  <input type="file" size="84"  class="fileHidden" name="f_image[]"/>
						  <div class="fileVisible">
								<input type="text"  class="fieldVisible" />
						  </div>
					</div>-->
					<div class="spacer"></div>
					<br class="spacer" />
					<label class="text02">Youtube Snipet</label>
					<br class="spacer" />
					<textarea name="s_youtube_snippet" id="s_youtube_snippet" cols="20" rows="5"><?php echo $posted["s_youtube_snippet"] ?></textarea>
					
					<?php /*?><div id="FileUpload12">
						  <input type="file" size="84" id="BrowserHidden12" onchange="getElementById('FileField12').value = getElementById('BrowserHidden').value;" />
						  <div id="BrowserVisible12">
								<input type="text" id="FileField12" name="s_youtube_snippet"/>
						  </div>
					</div><?php */?>
					
					<div class="spacer">&nbsp;</div>
					<div class="green-bar">Describe Your Place</div>
					
					<label class="text">Title</label>
					<br class="spacer" />
					  <div class="text-box02">
							<input name="s_name" type="text" id="s_name" value="<?php echo $posted['s_name'] ?>"/>
					  </div>
					  <br class="spacer" />
						  <div class="err"><?php echo form_error('s_name'); ?></div>
					<div class="spacer"></div>	
					<label class="text">Description</label>
					<br class="spacer" />
					<textarea name="s_description" id="s_description" cols="" rows=""><?php echo $posted["s_description"] ?></textarea>
					
					<div class="err"><?php echo form_error('s_description'); ?></div>
					<div class="spacer"></div>
					<span>(you can not mention emails, website or any contact details in property description, each ad is checked before it goes live and any violation of our policy may result your account being blocked.)</span>
					<div class="spacer"></div>
					<label class="text">House Rules</label>
					 <br class="spacer" />
					<textarea name="s_house_rules" id="s_house_rules" cols="" rows=""><?php echo $posted["s_house_rules"] ?></textarea>
					
					<div class="err"><?php echo form_error('s_house_rules'); ?></div>
					<div class="spacer"></div>
					<input  class="button-blu" type="button" value="Save" id="btn_add_property"/>
					<div class="spacer">&nbsp;</div>
					
					</form>
			  <!-- END FORM -->
			  </div>
		   
			  <div class="spacer">&nbsp;</div>
		</div>
	  </div>
	</div>
	<br class="spacer" />
</div>


    <div id="gmap_shadowbox" style="visibility:hidden; position: absolute; z-index: 10000; top:1400px; left:100px;">
            <div align="left" style="width:760px;color:white; background-color: blue; font-weight: bold;">
                Choose Map Location
                <span style="float: right; padding-right: 5px; cursor: pointer;" id="gmap_shadowbox_close">[X]</span>
            </div>
            <div align="center" id="map" style="width:760px;height:350px;"><br/></div>
    </div>
    
    
<!--    End Internal content for google map-->



    <script>
    jQuery(function($){
        
    
        $(document).ready(function(){
           
            $(".inline").click(function(){
                populate_address();
                $("#gmap_shadowbox").css({visibility:'visible'});
            });
            $("#gmap_shadowbox_close").click(function(){
                $("#gmap_shadowbox").css({visibility:'hidden'});
            });
        });
    });
    </script>
    
    
    <script type="text/javascript">

    $(document).ready(function(){
        load();
        //setTimeout("$('#gmap_shadowbox').css({display:'none'});",1000);
    });
    
    function populate_address()
    {
        jQuery(function($){
            
            var country = $("#opt_country option[value='"+$('#opt_country').val()+"']").text();
            /*var state = $("#opt_state option[value='"+$('#opt_state').val()+"']").text();
            var city = $("#opt_city option[value='"+$('#opt_city').val()+"']").text();
            var zipcode = $("#s_zipcode").val();*/
            var state = $("#opt_state option[value='"+$('#opt_state').val()+"']").text();
            if(state=='Select State' || state=='')
                state   =   '';
            else
                state   += ', '; 
            var city = $("#opt_city option[value='"+$('#opt_city').val()+"']").text();
            if(city=='Select City' || city=='')
                city   =   '';
            else
                city   += ', ';
            var zipcode = $("#s_zipcode").val();
             if(zipcode=='')
                zipcode   =   '';
            else
                zipcode   += ', ';
            
            var location_on_map = $("#location_on_map").val();
            
            if(location_on_map!='')
                showAddress(location_on_map);
            else
            {
                //showAddress(zipcode+', '+city+', '+state+', '+country);
                showAddress(zipcode+city+state+country);
            }
        });
    }
    
    
    function load() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map"));
        //map.addControl(new GSmallMapControl());
        //map.addControl(new GMapTypeControl());
        //var center = new GLatLng(48.89364, 2.33739);
        var lat_ = '';//'<?php echo $posted['location_latttude']?>';
        var lng_ = '';//'<?php echo $posted['location_longitude']?>';
        if(lat_ != '' || lng_ != '')
        {
            var center = new GLatLng(lat_,    lng_);
            map.setCenter(center, 14);
        }
        else
        {
            var center = new GLatLng(22.57265, 88.36389 ); // For Kolkata
            map.setCenter(center, 5);
        }
        //var center = new GLatLng(23.63450,    -102.55278); // For Mex
        
        //map.setCenter(center, 14);
        
        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
        
        
        geocoder = new GClientGeocoder();
        var marker = new GMarker(center, {draggable: true});  
        map.addOverlay(marker);
        //document.getElementById("lat").value = center.lat().toFixed(5);
        //document.getElementById("lng").value = center.lng().toFixed(5);
        //document.getElementById("location_on_map").value = center.lat().toFixed(5)+', '+center.lng().toFixed(5);
        
        GEvent.addListener(marker, "dragend", function() {
            var point = marker.getPoint();
            map.panTo(point);
            document.getElementById("lat").value = point.lat().toFixed(5);
            document.getElementById("lng").value = point.lng().toFixed(5);
        
        });


        GEvent.addListener(map, "moveend", function() {
            map.clearOverlays();
            var center = map.getCenter();
            var marker = new GMarker(center, {draggable: true});
            map.addOverlay(marker);
            document.getElementById("lat").value = center.lat().toFixed(5);
            document.getElementById("lng").value = center.lng().toFixed(5);
            
            GEvent.addListener(marker, "dragend", function() {
                var point =marker.getPoint();
                map.panTo(point);
                document.getElementById("lat").value = point.lat().toFixed(5);
                document.getElementById("lng").value = point.lng().toFixed(5);
                document.getElementById("location_on_map").value = point.lat().toFixed(5)+', '+point.lng().toFixed(5);
            });
        
        });

      }
    }

    function showAddress(address) {
        var map = new GMap2(document.getElementById("map"));
        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
        if (geocoder) {
            geocoder.getLatLng(
            address,
            function(point) {
                if (!point) {
                    alert(address + " not found");
                } else {
                    document.getElementById("lat").value = point.lat().toFixed(5);
                    document.getElementById("lng").value = point.lng().toFixed(5);
                    document.getElementById("location_on_map").value = point.lat().toFixed(5)+', '+point.lng().toFixed(5);
                    map.clearOverlays()
                    map.setCenter(point, 14);
                    var marker = new GMarker(point, {draggable: true});  
                    map.addOverlay(marker);
                    
                    GEvent.addListener(marker, "dragend", function() {
                        var pt = marker.getPoint();
                        map.panTo(pt);
                        document.getElementById("lat").value = pt.lat().toFixed(5);
                        document.getElementById("lng").value = pt.lng().toFixed(5);
                    });
                    
                    
                    GEvent.addListener(map, "moveend", function() {
                        map.clearOverlays();
                        var center = map.getCenter();
                        var marker = new GMarker(center, {draggable: true});
                        map.addOverlay(marker);
                        document.getElementById("lat").value = center.lat().toFixed(5);
                        document.getElementById("lng").value = center.lng().toFixed(5);
                        document.getElementById("location_on_map").value = center.lat().toFixed(5)+', '+center.lng().toFixed(5);
                        GEvent.addListener(marker, "dragend", function() {
                            var pt = marker.getPoint();
                            map.panTo(pt);
                            document.getElementById("lat").value = pt.lat().toFixed(5);
                            document.getElementById("lng").value = pt.lng().toFixed(5);
                            document.getElementById("location_on_map").value = point.lat().toFixed(5)+', '+point.lng().toFixed(5);
                        });
                    
                    });
                }
            });
        }
    }

</script>