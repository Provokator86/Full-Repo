<script type="text/javascript">

	$(document).ready(function() {
			/* search on filter values */
		$('input[id^="btn_search"]').each(function(i){
		   $(this).click(function(){
			   $("#srch_quotes").submit();
		   }); 
		});  
	
		///////////Submitting the form/////////
		$("#srch_quotes").submit(function(){
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
	/**
    * This function use to show the quote of job.
    */
    function edit_quote(quote_id)
    {
      
         $.ajax({
                        type: "POST",
                        async: false,
                        url: base_url+'tradesman/ajax_fetch_quote',
                        data: "quote_id="+quote_id,
                        success: function(ret_){
                            
                                $("#quote_list").html($.trim(ret_));
								$("#h_quote_id").val(quote_id);
                                show_dialog('photo_zoom02');   
                            
                        }
         });
    }
	
	/* save edit quote */
	function edit_my_quote()
	{
		var b_valid = true;
		var s_err = '';
		var quote_val = /^[0-9]+$/;
		var quote_id = $("#h_quote_id").val();
		
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
			$("#div_err3").html(s_err).show("slow");
		}
		else
		{
		
			$.ajax({
				type: "POST",
			    url: base_url + "tradesman/edit_my_quote",
			   data: {
			   			s_quote_id:quote_id,
						d_quote_amt:$("#txt_quote").val(),
						s_comment:$("#ta_message").val()
			   		},
			   dataType: 'JSON',
			   success: function(res){
			 				
							if(res.flag)
                            {
								$('#div_err3').html('<div class="success_massage">'+res.msg+'<div>');								
							}
							else
							{
								$('#div_err3').html('<div class="error_massage">'+res.msg+'<div>');
							}	
				
			   				}  // end success

			});   // end ajax
		
		setTimeout('window.location.reload()',2000);
		
		} // end else 
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
			
		   <h4><?php echo addslashes(t('Quotes'))?> </h4>
		  <div class="div01">
				<p><?php echo addslashes(t('This section consists of all the bids you have placed in respect to all the jobs that are relevant to you'))?></p>
				<div class="spacer"></div>
				<form name="srch_quotes" id="srch_quotes" action="" method="post">
				<div class="filter_option_box">
				    <h3><?php echo addslashes(t('Filter option'))?></h3>
					<div class="lable04"><?php echo addslashes(t('City'))?></div>
					<div class="textfell nobg02">
				<select id="opt_city" name="opt_city" style="width:179px;" onchange='call_ajax_get_province("ajax_change_province_option",this.value,"parent_province");'>
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
		  
				<div class="spacer"></div>
			  
		  </div>
		  <!-- quote list -->
		  <div id="job_quotes">
		  <?php echo $job_quotes ?>
		  </div>
		  <!-- quote list -->
			  
		  <div class="spacer"></div>
			  
			<!--- icon bar -->  
		  <div class="icon_bar">
			  <ul>
				  <li><img src="images/fe/edit.png" alt="" /> <?php echo addslashes(t('Edit'))?></li>
				  <li>|</li>
				  <li><img src="images/fe/view.png" alt="" /> <?php echo addslashes(t('View'))?></li>
				   <li>|</li>				  
				  <li class="last"><img src="images/fe/mass.png" alt="" /><?php echo addslashes(t('Messages'))?></li>
			  </ul>
		   <div class="spacer"></div>
		  </div>
		  <!--- icon bar --> 
		  
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

<!--lightbox quote and comment-->
<div class="lightbox02 photo_zoom02 width04">
<div id="div_err3">
</div>
      <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
      <h3><?php echo addslashes(t('Edit your quote'))?></h3>
	  <input type="hidden" id="h_quote_id" name="h_quote_id" value="" />
        <div id="quote_list">
		</div>
      
</div>
<!--lightbox feedback-->