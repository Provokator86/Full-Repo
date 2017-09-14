<script language="javascript">
$(document).ready(function(){
	
$('input[id^="btn_radar"]').each(function(i){
   $(this).click(function(){
      //$.blockUI({ message: 'Just a moment please...' });
       $("#frm_radar_set").submit();
   }); 
});    


///////////Submitting the form/////////
$("#frm_radar_set").submit(function(){
    var b_valid=true;
	var s_err="";
    $("#div_err").hide("slow");   
	
	if($.trim($("#opt_category_id option:selected").val())=="") 
	{
	  	$("#err_opt_category_id").text('<?php echo addslashes(t('Please select categories'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else
    {
        $("#err_opt_category_id").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	if($.trim($("#opt_city option:selected").val())=="") 
	{
	  	$("#err_city").text('<?php echo addslashes(t('Please select city'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else
    {
        $("#err_city").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }	
	if($.trim($("#opt_state option:selected").val())=="") 
	{
	  	$("#err_opt_state").text('<?php echo addslashes(t('Please select province'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else
    {
        $("#err_opt_state").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
    
    /////////validating//////
    if(!b_valid)
    {
      $("#div_err").html(s_err).show("slow");
    }
    
    return b_valid;
});    
///////////end Submitting the form/////////   

})

// Ajax call to populate province options
function call_ajax_get_province(ajaxURL,item_id,cngDv)
{
		document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
		$.ajax({
				type: "POST",
				url: base_url+'ajax_fe/'+ajaxURL,
				data: "city_id="+item_id,
				success: function(msg){
				   if(msg!='')
				   {
					   document.getElementById(cngDv).innerHTML = msg;
					   $("#opt_state").msDropDown();
					   $("#opt_state").hide();
					   $('#opt_state_msdd').css("background-image", "url(images/fe/select03.png)");
					   $('#opt_state_msdd').css("background-repeat", "no-repeat");
					   $('#opt_state_msdd').css("width", "269px");
					   $('#opt_state_msdd').css("margin-top", "0px");
					   $('#opt_state_msdd').css("padding", "0px");
					   $('#opt_state_msdd').css("height", "38px");
					   

				   }   
				}
			});
		
}
</script>
<style>
.err{ margin-left:230px;}
</style>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
	<div class="top_part"></div>
	<div class="midd_part height02">
	  <div class="username_box">
	<div class="right_box03">
			<?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
					<div id="div_err">							
					</div>	
					
		  <h4><?php echo addslashes(t('Radar Settings'))?></h4>
		  <h5><?php echo addslashes(t('You dont want to miss out business within your reach'))?>.</h5>
		 <div class="div01"> 
		
		 <div class="required"><span>*</span> <?php echo addslashes(t('Required field'))?></div>
		  <div class="spacer"></div>
		 </div>
		 
		 <!-- start form -->
		  <form name="frm_radar_set" id="frm_radar_set" action="<?php echo base_url().'tradesman/radar-setting' ?>" method="post">
		<div class="div02">
				
				
 	<div class="lable06 margin06"><?php echo addslashes(t('City'))?> <span>*</span></div>
 		<div class="textfell11 width02 height05">
		<select id="opt_city" name="opt_city" style="width:269px;" onchange='call_ajax_get_province("ajax_change_province_option_auto_complete",this.value,"parent_province");'>
			<option value=""><?php echo addslashes(t('Select city'))?></option>
			<?php echo makeOptionCity('',$posted['opt_city']); ?>
	  </select>
	  <script type="text/javascript">
	$(document).ready(function() {
	  $("#opt_city").msDropDown();
	   $("#opt_city").hide();
	   $('#opt_city_msdd').css("background-image", "url(images/fe/select.png)");
	   $('#opt_city_msdd').css("background-repeat", "no-repeat");
	   $('#opt_city_msdd').css("width", "269px");
	   $('#opt_city_msdd').css("margin-top", "0px");
	   $('#opt_city_msdd').css("padding", "0px");
		$('#opt_city_msdd').css("height", "38px");
	});

</script>
					  
		</div> 
		<div class="spacer"></div>
		<div id="err_city" class="err"><?php echo form_error('city'); ?></div>
		
		<div class="spacer"></div>
				
				
				<div class="lable06 margin06"><?php echo addslashes(t('Province'))?>  <span>*</span></div>
				<div class="textfell11 width02 height05">
					<div id="parent_province">
						<select id="opt_state" name="opt_state" style="width:269px;">
							<option value=""><?php echo addslashes(t('Select province'))?></option>
							<?php echo makeOptionProvince(' i_city_id ="'.decrypt($posted['opt_city']).'" ',$posted['opt_state']); ?>
						  </select>
					</div>	  
		<script type="text/javascript">
	$(document).ready(function() {
	  $("#opt_state").msDropDown();
	   $("#opt_state").hide();
	   $('#opt_state_msdd').css("background-image", "url(images/fe/select.png)");
	   $('#opt_state_msdd').css("background-repeat", "no-repeat");
	   $('#opt_state_msdd').css("width", "269px");
	   $('#opt_state_msdd').css("margin-top", "0px");
	   $('#opt_state_msdd').css("padding", "0px");
		$('#opt_state_msdd').css("height", "38px");
	});

</script>
					  
	</div>
	<div class="spacer"></div>
		<div id="err_opt_state" class="err"><?php echo form_error('opt_state'); ?></div>
		
	<div class="spacer"></div>
	<div class="lable06 margin06"><?php echo addslashes(t('Categories'))?>   <span>*</span></div>
	<div class="textfell11 ">
	<select id="opt_category_id" name="opt_category_id[]" multiple="multiple" style="width:269px; height:150px; border:1px solid #ccc;">
		<?php echo makeOptionCategoryList(" c.i_status = 1 ", $posted['opt_category_id']);?>
	</select>
			 
	</div>
	<div class="spacer"></div>
	<div id="err_opt_category_id" class="err"><?php echo form_error('opt_category_id'); ?></div>
		
	<div class="spacer"></div>
	
	 
	<div class="lable06"> </div>
	<div class="textfell11">
	<input type="hidden" name="h_id" value="<?php echo $posted['h_id'];?>" />
	<input type="button" name="btn_radar" id="btn_radar" value="<?php echo addslashes(t('Save'))?>" class="small_button margintop0 fist" />
	</div>
		<div class="spacer"></div>
  </div>  	
		  </form> 
		 <!-- end form  -->	  
		</div>
			<?php include_once(APPPATH."views/fe/common/tradesman_left_menu.tpl.php"); ?>
			
			<div class="spacer"></div>
	  </div>
                  <div class="spacer"></div>
            </div>
            <div class="spacer"></div>
            <div class="bottom_part"></div>
      </div>