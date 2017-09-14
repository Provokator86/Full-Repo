<script>

	$(document).ready(function(){
			/* search on filter values */
		$('input[id^="btn_all_job"]').each(function(i){
		   $(this).click(function(){
			   $("#srch_all_jobs").submit();
		   }); 
		});  
	
		///////////Submitting the form/////////
		$("#srch_all_jobs").submit(function(){
			var b_valid=true;
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
    * This function use to show the history of job.
    */
    function show_history(job_id)
    {
         $.ajax({
                        type: "POST",
                        async: false,
                        url: base_url+'buyer/ajax_fetch_job_history',
                        data: "job_id="+job_id,
                        success: function(msg){
                            if(msg!='error')
                            {
                                $("#history").html($.trim(msg));
                                show_dialog('photo_zoom02');   
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
			
			  <h4><?php echo addslashes(t('All Jobs'))?></h4>
			  <div class="div01">
					<p><?php echo addslashes(t('This section consists of all jobs and their history posted by you'))?></p>
				   
					<div class="spacer"></div>
					<form name="srch_all_jobs" id="srch_all_jobs" action="" method="post">
				<div class="filter_option_box">
				    <h3><?php echo addslashes(t('Filter option'))?></h3>
					<div class="lable04"><?php echo addslashes(t('Status'))?></div>
					<div class="textfell nobg02">
				<select id="opt_status" name="opt_status" style="width:179px;" >
			<option value=""><?php echo addslashes(t('Select status'))?></option>
			<?php echo makeOptionJobStatus('',encrypt($posted['opt_status'])); ?>
	  </select>
	  <script type="text/javascript">
	$(document).ready(function() {
	  $("#opt_status").msDropDown();
	   $("#opt_status").hide();
	   $('#opt_status_msdd').css("background-image", "url(images/fe/select04.png)");
	   $('#opt_status_msdd').css("background-repeat", "no-repeat");
	   $('#opt_status_msdd').css("width", "179px");
	   $('#opt_status_msdd').css("margin-top", "0px");
	   $('#opt_status_msdd').css("padding", "0px");
		$('#opt_status_msdd').css("height", "38px");
	});

</script>
				</div>
				
				
				
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
				<input class="small_button" id="btn_all_job" type="button" value="<?php echo addslashes(t('Search'))?>" />
				
				</div>
				<div class="spacer"></div>
				
				
				
		  </div>
		  		</form>
					
			  </div>
			  <!-- job contents -->
			  <div id="job_list">
			  <?php echo $job_contents ?>
			  </div>
			  <!-- job contents -->
			  
			  <div class="spacer"></div>
			  
			  <div class="icon_bar">
			  <ul>
			  <li><img src="images/fe/edit.png" alt="" /> <?php echo addslashes(t('Edit'))?></li>
              <li>|</li>
			  <li><img src="images/fe/view.png" alt="" /> <?php echo addslashes(t('View'))?></li>
			   <li>|</li>
			   <li><img src="images/fe/history.png" alt="" /><?php echo addslashes(t('History'))?></li>
			   <li>|</li>
			  <li class="last"><img src="images/fe/mass.png" alt="" /><?php echo addslashes(t('Messages'))?></li>
			  </ul>
			   <div class="spacer"></div>
			  </div>
			   <div class="spacer"></div>
			   
	    </div>
			<?php include_once(APPPATH."views/fe/common/buyer_left_menu.tpl.php"); ?>
			<div class="spacer"></div>
	  </div>
       <div class="spacer"></div>
            </div>
	<div class="spacer"></div>
	<div class="bottom_part"></div>
</div>