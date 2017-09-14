<script type="text/javascript">
jQuery(function($){
$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>";//controller Path 

$('input[id^="btn_cancel"]').each(function(i){
   $(this).click(function(){
       //$.blockUI({ message: 'Just a moment please...' });
       window.location.href=g_controller;
   }); 
});      
    

///////////Submitting the form/////////
$("#btn_save").click(function(){	
    var b_valid=true;
    var s_err="";
	var reg_email     = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/; 
	var email_address = $.trim($("#txt_email").val());	
	var file_type 	  = $("#f_image").val();
	
	
	if($.trim($("#txt_name").val())=="")
	{
		$("#err_txt_name").text('<?php echo addslashes(t('Please provide your name'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else
    {
        $("#err_txt_name").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	if(email_address=="") //// For  email 
	{
		$("#err_txt_email").text('<?php echo addslashes(t('Please provide your email'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else if(reg_email.test(email_address) == false)
	{
		$("#err_txt_email").text('<?php echo addslashes(t('Please provide proper email'))?>').slideDown('slow');
		b_valid  =  false;
	}
    else
    {
        $("#err_txt_email").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	
	if($.trim($("#txt_address").val())=="")
	{
		$("#err_txt_address").text('<?php echo addslashes(t('Please provide your address'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else
    {
        $("#err_txt_address").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	if($.trim($("#opt_city").val())=="") //// For  name opt_city
	{
		$("#err_opt_city").text('<?php echo addslashes(t('Please provide your city'))?>').slideDown('slow');
		b_valid  =  false;
	}
    else
    {
        $("#err_opt_city").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	if($.trim($("#opt_state").val())=="") //// For  name opt_city
	{
		$("#err_opt_state").text('<?php echo addslashes(t('Please provide your province'))?>').slideDown('slow');
		b_valid  =  false;
	}
    else
    {
        $("#err_opt_state").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	if($.trim($("#opt_zip").val())=="") //// For  name opt_city
	{
		$("#err_opt_zip").text('<?php echo addslashes(t('Please provide your zip code'))?>').slideDown('slow');
		b_valid  =  false;
	}
    else
    {
        $("#err_opt_zip").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }	
	
	
	if($.trim($("#f_image").val())!="" && (!file_type.match(/(?:jpg|png|jpeg|gif)$/)))
	{
		$("#err_f_image").text('<?php echo addslashes(t('Please upload proper image file'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else
	{
		$("#err_f_image").slideUp('slow').text('<?php echo addslashes(t(''))?>');
	}	
	
    /////////validating//////
    if(!b_valid)
    {
       // $.unblockUI();  
        $("#div_err").html(s_err).show("slow");
    }
    
	else
	{
	$("#frm_profile").submit();
	}
	return b_valid;
    
}); 


///////////end Submitting the form///////// 

		// Making city drop down
		$("#opt_city").msDropDown();
	   $("#opt_city").hide();
	   $('#opt_city_msdd').css("background-image", "url(images/fe/select03.png)");
	   $('#opt_city_msdd').css("background-repeat", "no-repeat");
	   $('#opt_city_msdd').css("width", "269px");
	   $('#opt_city_msdd').css("height", "38px");
	   $('#opt_city_msdd').css("margin-top", "10px");
	   $('#opt_city_msdd').css("padding", "0px");
	  
	  // Making state drop down 
		$("#opt_state").msDropDown();
	   $("#opt_state").hide();
	   $('#opt_state_msdd').css("background-image", "url(images/fe/select03.png)");
	   $('#opt_state_msdd').css("background-repeat", "no-repeat");
	   $('#opt_state_msdd').css("width", "269px");
	   $('#opt_state_msdd').css("height", "38px");
	   $('#opt_state_msdd').css("margin-top", "10px");
	   $('#opt_state_msdd').css("padding", "0px");


});
});

// Ajax call to populate province options
function call_ajax_get_province(ajaxURL,item_id,cngDv)
{
		jQuery.noConflict();///$ can be used by other prototype which is not jquery
		jQuery(function($) {
		document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
		$.ajax({
				type: "POST",
				url: base_url+'ajax_fe/'+ajaxURL,
				data: "city_id="+item_id,
				success: function(msg){
				   if(msg!='')
				   {
					   document.getElementById(cngDv).innerHTML = msg;
					   $("#txt_zip").val('');
					   $("#opt_state").msDropDown();
					   $("#opt_state").hide();
					   $('#opt_state_msdd').css("background-image", "url(images/fe/select.png)");
					   $('#opt_state_msdd').css("background-repeat", "no-repeat");
					   $('#opt_state_msdd').css("width", "269px");
					   $('#opt_state_msdd').css("margin-top", "0px");
					   $('#opt_state_msdd').css("padding", "0px");
					   $('#opt_state_msdd').css("height", "38px");
					   

				   }   
				}
			});
			
	});		
		
}

function call_ajax_get_zipcode(ajaxURL,item_id,city_id,cngDv)
{
	jQuery.noConflict();///$ can be used by other prototype which is not jquery
	jQuery(function($) {
		document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
		$.ajax({
				type: "POST",
				url: base_url+'ajax_fe/'+ajaxURL,
				data: "state_id="+item_id+"&city_id="+city_id,
				success: function(msg){
				   if(msg!='')
					   document.getElementById(cngDv).innerHTML = msg;
                       $("#opt_zip").msDropDown();
                       $("#opt_zip").hide();
                       $('#opt_zip_msdd').css("background-image", "url(images/fe/select.png)");
                       $('#opt_zip_msdd').css("background-repeat", "no-repeat");
                       $('#opt_zip_msdd').css("width", "269px");
                       $('#opt_zip_msdd').css("margin-top", "0px");
                       $('#opt_zip_msdd').css("padding", "0px");
                       $('#opt_zip_msdd').css("height", "38px");
				}
			});
	});	
}


</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>    
<div class="job_categories">
     <div class="top_part"></div>
	<div class="midd_part height02">
	  <div class="username_box">
	  <form name="frm_profile" id="frm_profile" action="<?php echo base_url().'buyer/edit-profile' ?>" method="post" enctype="multipart/form-data">
		<div class="right_box03">
			<?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
			<div id="div_err">
					
			</div>
			  <h4><?php echo addslashes(t('Edit Profile'))?></h4>
			  <div class="div01">
				   
					<div class="required"><span>*</span> <?php echo addslashes(t('Required field'))?></div>
					<div class="spacer"></div>
				  
			  </div>
			  <div class="div02">				 
					
					<div class="lable06"><?php echo addslashes(t('Name'))?> <span>*</span> </div>
					<div class="textfell10">
					<input name="txt_name" id="txt_name" type="text" value="<?php echo $posted['txt_name'];?>" />
					</div>
					  <div class="lable06"></div>
					  <div id="err_txt_name" class="err"><?php echo form_error('txt_name') ?></div>
					<div class="spacer"></div>
					
					
					 <div class="lable06"><?php echo addslashes(t('Email'))?> <span>*</span> </div>
					<div class="textfell10">
					<input name="txt_email" id="txt_email" type="text" value="<?php echo $posted['txt_email'];?>" />
					</div>
					<div class="lable06"></div>
					  <div id="err_txt_email" class="err"><?php echo form_error('txt_email') ?></div>
					<div class="spacer"></div>
			  </div>
			  
			  
			  <div class="div02">
					<h5><?php echo addslashes(t('Address'))?></h5>
					
					<div class="lable06"><?php echo addslashes(t('Address'))?> <span>*</span> </div>
					<div class="textfell10">
					<input name="txt_address" id="txt_address" type="text" value="<?php echo $posted['txt_address'];?>" />
					</div>
					<div class="lable06"></div>
					  <div id="err_txt_address" class="err"><?php echo form_error('txt_address') ?></div>
					<div class="spacer"></div>
					<div class="lable06"><?php echo addslashes(t('City'))?> <span>*</span> </div>
					<select name="opt_city" id="opt_city"  onchange='call_ajax_get_province("ajax_change_province_option_auto_complete",this.value,"parent_state");'>
					  <option value=""><?php echo addslashes(t('Select city'));?> </option>
					  <?php echo makeOptionCity('',$posted['opt_city']) ?>
					</select>
			  		<div class="lable06"></div>
					  <div id="err_opt_city" class="err"><?php echo form_error('opt_city') ?></div>

			  <div class="spacer"></div>
					
					
					 <div class="lable06"><?php echo addslashes(t('Province'))?> <span>*</span> </div>
					 <div id="parent_state">
					 <select id="opt_state" name="opt_state" style="width:269px;" onchange='call_ajax_get_zipcode("ajax_change_zipcode_option",this.value,"<?php echo $posted['opt_city'] ?>","parent_zip");'>
						  <option value=""><?php echo addslashes(t('Select province'));?> </option>
						  <?php echo makeOption($arr_province,$posted['opt_province']) ?>
					 </select>
					 <div class="lable06"></div>
					  <div id="err_opt_state" class="err"><?php echo form_error('opt_state') ?></div>
					 </div>

					<div class="lable06"></div>
					<div class="spacer"></div>	
					<div class="spacer"></div>		
					
					<div class="lable06"><?php echo addslashes(t('Zip code'))?><span>*</span> </div>
				   <!-- zip code drop down -->
				   <div id="parent_zip">
				  <select id="opt_zip" name="opt_zip" style="width:269px;" >
					  <option value=""><?php echo addslashes(t('Select zipcode'));?> </option>
					  <?php echo makeOption($arr_zipcode,$posted['opt_zip']) ?>
				 </select>
			   </div>
			   <script type="text/javascript">
				$(document).ready(function() {
				  $("#opt_zip").msDropDown();
				   $("#opt_zip").hide();
				   $('#opt_zip_msdd').css("background-image", "url(images/fe/select03.png)");
				   $('#opt_zip_msdd').css("background-repeat", "no-repeat");
				   $('#opt_zip_msdd').css("width", "269px");
				   $('#opt_zip_msdd').css("height", "38px");
				   $('#opt_zip_msdd').css("margin-top", "10px");
				   $('#opt_zip_msdd').css("padding", "0px");
				  
				});
			
			</script>
				   <!-- -->
			  		<div class="lable06"></div>
					  <div id="err_opt_zip" class="err"><?php echo form_error('opt_zip') ?></div>
					<div class="spacer"></div>
			  </div>
			  
			  
			  <div class="div02">
					<h5><?php echo addslashes(t('Buyer Profile'))?></h5>
					
					<div class="lable06"><?php echo addslashes(t('Profile Photo'))?><span></span> </div>
					<div class="textfell11">
					 <?php 
					 if($posted['s_user_image']) 
				    { 
				    $src_img = 	$thumbPath.'thumb_'.$posted['s_user_image'];						
					echo '<input type="hidden" name="h_image" id="h_image" value="'.$posted['s_user_image'].'" />';
					} 
					else
					{
					$src_img = 	"images/fe/no_image.jpg";
					}
					?>
					<img src="<?php echo $src_img;?>" alt="" height="100px" width="100px" class="photo" />
					<div class="spacer"></div>
					<input type="file" name="f_image" id="f_image" class="width05 fist" /> </div>
					<div class="lable06"></div>
					  <div id="err_f_image" class="err"><?php echo form_error('f_image') ?></div>
					<div class="spacer"></div>
					 <div class="lable06"></div>
					  
					<div class="textfell11">
						  <input name="chk_newletter" id="chk_newsletter" type="checkbox" value="1"  class="fist" <?php echo ($posted['chk_newsletter']==1)?'checked':''; ?>/> 
					<?php echo addslashes(t('I would like to receive Newsletter'))?> </div>
					<div class="spacer"></div>
					
					<div class="lable06"></div>
					<div class="textfell11">
					<input class="small_button fist" type="button" name="btn_save" id="btn_save" value="<?php echo addslashes(t('Save'))?>" /> 
					<input class="small_button" type="button" name="btn_cancel" id="btn_cancel" value="<?php echo addslashes(t('Cancel'))?>" /></div>
					<div class="spacer"></div>
			  </div>
			  
			  </div>
	  </form>		  
	  <?php include_once(APPPATH."views/fe/common/buyer_left_menu.tpl.php"); ?>
	<div class="spacer"></div>
	  </div>
		  <div class="spacer"></div>
	</div>
	<div class="spacer"></div>
	<div class="bottom_part"></div>
</div>