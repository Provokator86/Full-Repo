<script type="text/javascript">
$(document).ready(function() {
	var job_id = '';
	$(".login_button02").click(function() {
		job_id = $(this).attr('rel');				
		$("#h_job_id").val(job_id);
		show_dialog('photo_zoom02');
		
		});
		
	/* place quote button click */
	$("#confirm_quote").click(function() { 
		var b_valid = true;
		var quote_val = /^[0-9]+$/;
		if($.trim($("#txt_quote").val())=="") //// For  name 
		{
			$("#err_txt_quote").text('<?php echo addslashes(t('Please provide your bid'))?>').slideDown('slow');
			b_valid  =  false;
		}
		else if(quote_val.test($.trim($("#txt_quote").val()))==false)
		{
			$("#err_txt_quote").text('<?php echo addslashes(t('Please provide numeric value with no decimal point'))?>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#err_txt_quote").slideUp('slow').text('<?php echo addslashes(t(''))?>');
		}
		if($.trim($("#ta_message").val())=="") //// For  name 
		{
			$("#err_ta_message").text('<?php echo addslashes(t('Please provide message'))?>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#err_ta_message").slideUp('slow').text('<?php echo addslashes(t(''))?>');
		}
		 if(!b_valid)
		{
		   // $.unblockUI();  
			$("#div_err").html(s_err).show("slow");
		}
		
		else
		{
		//$("#ajax_frm_job_confirm").submit();
		var quote 	= $("#txt_quote").val();
		var comment = $("#ta_message").val();
		var job_id = $("#h_job_id").val();
		 		$.ajax({
                        type: "POST",
                        async: false,
                        url: base_url+'job/save_quote_job',
                        data: "txt_quote="+quote+"&ta_message="+comment+"&h_job_id="+job_id,
                        success: function(msg){
                            if(msg)
                            {
								msg = msg.split('|');
								var s_msg = msg[1];		
													
								if(msg[0]==1)
								{
									$('#div_err3').html('<div class="success_massage">'+s_msg+'<div>');
								}
								else
									$('#div_err3').html('<div class="error_massage">'+s_msg+'<div>');
							}
                        }
                    });
			setTimeout('window.location.reload()',2000);		
		}
		return false;
	});	
	/* end place quote button click */
	
	/* search on filter values */
	$('input[id^="btn_search"]').each(function(i){
	   $(this).click(function(){
		   $("#radar_srch").submit();
	   }); 
	});  

	///////////Submitting the form/////////
	$("#radar_srch").submit(function(){
		var b_valid=true;
		var pattern = /^[a-zA-Z]+/;
		var s_err="";
		$("#div_err").hide(); 
		
		/////////validating//////
		if(!b_valid)
		{
			//$.unblockUI();  
			$("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show();
		}
		
		return b_valid;
	}); 	
	
});
// end document.ready

function show_all()
{
	$("#frm_sh_all").submit();
}

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
					   $('#opt_state_msdd').css("background-image", "url(images/fe/select04.png)");
					   $('#opt_state_msdd').css("background-repeat", "no-repeat");
					   $('#opt_state_msdd').css("width", "179px");
					   $('#opt_state_msdd').css("margin-top", "0px");
					   $('#opt_state_msdd').css("padding", "0px");
					   $('#opt_state_msdd').css("height", "38px");
					   

				   }   
				}
			});
		
}
</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
            <div class="top_part"></div>
	<div class="midd_part height02">
	  <div class="username_box">
		<div class="right_box03">
		
		<div id="div_err">
		</div>
		
		  <h4><?php echo addslashes(t('Radar Job'))?></h4>
		  <form name="radar_srch" id="radar_srch" action="" method="post">
		  <div class="filter_option_box">
		  <h3><?php echo addslashes(t('Filter option'))?></h3>
				<div class="lable04"><?php echo addslashes(t('City'))?></div>
				<div class="textfell nobg02">
				<select id="opt_city" name="opt_city" style="width:179px;" onchange='call_ajax_get_province("ajax_change_province_option_auto_complete",this.value,"parent_province");'>
			<option value=""><?php echo addslashes(t('Select city'))?></option>
			<?php echo makeOptionCity('',encrypt($posted['opt_city'])); ?>
	  </select>
	  <script type="text/javascript">
	$(document).ready(function() {
	  $("#opt_city").msDropDown();
	   $("#opt_city").hide();
	   $('#opt_city_msdd').css("background-image", "url(images/fe/select04.png)");
	   $('#opt_city_msdd').css("background-repeat", "no-repeat");
	   $('#opt_city_msdd').css("width", "179px");
	   $('#opt_city_msdd').css("margin-top", "0px");
	   $('#opt_city_msdd').css("padding", "0px");
		$('#opt_city_msdd').css("height", "38px");
	});

</script>
				</div>
				<!--<div class="lable04"><?php //echo addslashes(t('Postal Code'))?></div>
				<div class="textfell"><input name="" type="text" /></div>
				<div class="spacer"></div>-->
				<div class="lable04"><?php echo addslashes(t('Province'))?></div>
				<div class="textfell nobg02">
				<div id="parent_province">
					<select id="opt_state" name="opt_state" style="width:179px;">
						<option value=""><?php echo addslashes(t('Select province'))?></option>
						<?php echo makeOptionProvince(' i_city_id ="'.$posted['opt_city'].'" ',encrypt($posted['opt_state'])); ?>
					  </select>
				</div>	  
		<script type="text/javascript">
	$(document).ready(function() {
	  $("#opt_state").msDropDown();
	   $("#opt_state").hide();
	   $('#opt_state_msdd').css("background-image", "url(images/fe/select04.png)");
	   $('#opt_state_msdd').css("background-repeat", "no-repeat");
	   $('#opt_state_msdd').css("width", "179px");
	   $('#opt_state_msdd').css("margin-top", "0px");
	   $('#opt_state_msdd').css("padding", "0px");
		$('#opt_state_msdd').css("height", "38px");
	});

</script>
				</div>
				<div class="spacer"></div>
				
				 <div class="lable04"><?php echo addslashes(t('Category'))?></div>
				<div class="textfell nobg02">
				<select id="category" name="category" style=" width:179px;"> 
				<option value=""><?php echo addslashes(t('All'))?></option>
				<?php echo makeOptionCategory(" c.i_status = 1 ", encrypt($posted['i_category_id']));?>
				</select>
				<script type="text/javascript">
	$(document).ready(function() {
	  $("#category").msDropDown();
	   $("#category").hide();
	   $('#category_msdd').css("background-image", "url(images/fe/select04.png)");
	   $('#category_msdd').css("background-repeat", "no-repeat");
	   $('#category_msdd').css("width", "179px");
	   $('#category_msdd').css("margin-top", "0px");
	   $('#category_msdd').css("padding", "0px");
		$('#category_msdd').css("height", "38px");
	});

</script>
				</div>
				<div class="spacer"></div>
				<div class="lable04"></div>
				<div class="textfell nobg02 width05">
				<input class="small_button" id="btn_search" type="button" value="<?php echo addslashes(t('Search'))?>" />
				<?php /*?><input class="small_button" id="btn_show_all" type="button" onclick="javascript:show_all();" value="<?php echo addslashes(t('Show All'))?>" /><?php */?>
				</div>
				<div class="spacer"></div>
				
				
				
		  </div>
		  </form>
		  	<!-- job list -->
		  	<div id="job_list">
			  <?php echo $job_contents ?>	
			 </div> 	
			<!-- job list -->
			 	  
			  <div class="spacer"></div>
			  
			  <!--<div class="icon_bar">
			  <ul>
			  <li><img src="images/fe/edit.png" alt="" /> Edit</li>
			  <li>|</li>
			  <li class="last"><img src="images/fe/view.png" alt="" /> View</li>
			  </ul>
			   <div class="spacer"></div>
			  </div>-->
			   <div class="spacer"></div>
		</div>
			<?php include_once(APPPATH."views/fe/common/tradesman_left_menu.tpl.php"); ?>
			<div class="spacer"></div>
	  </div>
		  <div class="spacer"></div>
	</div>
            <div class="spacer"></div>
            <div class="bottom_part"></div>
      </div>
	
	<form id="frm_sh_all" name="frm_sh_all" method="post" action="">
<input type="hidden" name="opt_radius" id="opt_radius" value="" />
<input type="hidden" name="opt_category_id" id="opt_category_id" value="" />
<input type="hidden" name="txt_postal_code" id="txt_postal_code" value="" />
<input type="submit" style="visibility:hidden;" />
</form>
	
	<!--lightbox-->
<div class="lightbox02 photo_zoom02 width04">
	  <div id="div_err3">
	  </div>		
      <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
	  
      <h3><?php echo addslashes(t('Place Quote'))?></h3>
      <div class="lable04"><?php echo addslashes(t('Your bid'))?> :</div>
      <div class="textfell">
            <input type="hidden" name="h_job_id" id="h_job_id" value="" />
            <input name="txt_quote" id="txt_quote" type="text" />
      </div>  <div class="lable03">TL</div>
	  <div class="spacer"></div>
	  <div id="err_txt_quote" class="err" style="margin-left:130px;"><?php echo form_error('txt_quote') ?></div>
      <div class="spacer"></div>
       <div class=" lable04"><?php echo addslashes(t('Message'))?> :</div>
      <div class="textfell06">
          <textarea name="ta_message" id="ta_message"></textarea>
      </div>
	  <div class="spacer"></div>
	  <div id="err_ta_message" class="err" style="margin-left:130px;"><?php echo form_error('ta_message') ?></div>
      <div class="spacer"></div>
      <div class="lable04"></div>
      <input class="small_button" type="button" id="confirm_quote" value="<?php echo addslashes(t('Submit'))?>" />
</div>
<!--lightbox-->  