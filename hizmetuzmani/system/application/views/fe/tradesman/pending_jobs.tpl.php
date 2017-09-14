<script type="text/javascript">
$(document).ready(function() {
	var job_id = '';
	$(".login_button02").click(function() {
		job_id = $(this).attr('rel');
		$("#h_job_id").val(job_id);
		show_dialog('photo_zoom08');
		});
	// end opening the light box	
	/* after clicking on the submit button */
	$("#btn_complete").click(function() { 
		
		var b_valid = true;
		var s_err	= '';
		var radio_val = $("input:radio[name=radio_comp]:checked").val();
		
		if(radio_val==2)
		{
			hide_dialog('photo_zoom08');
		}
		else if(b_valid)
		{
			var i_job_id = $("#h_job_id").val();	
			
			$.ajax({
                        type: "POST",
                        async: false,
                        url: base_url+'tradesman/confirm_job_complete',
                        data: "i_job_id="+i_job_id,
                        success: function(msg){
                            if(msg)
                            {
								msg = msg.split('|');
								var s_msg = msg[1];								
								if(msg[0]==1)
								{
									$('#div_err2').html('<div class="success_massage">'+s_msg+'<div>');
								}
								else
									$('#div_err2').html('<div class="error_massage">'+s_msg+'<div>');
							}
                        }
                    });
					
			setTimeout('window.location.reload()',2000);		
		}			
		return false;	
	
	});
	
});
</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
            <div class="top_part"></div>
	<div class="midd_part height02">
	  <div class="username_box">
		<div class="right_box03">
			 <h4><?php echo addslashes(t('Pending Jobs'))?></h4>                              
			  <div class="div01">			
			  <p><?php echo addslashes(t('This section consists of the jobs that has been declared as incomplete by the Buyer'))?></p>
			  <div class="spacer"></div>
			  </div>
			  <div id="job_list">
			  <?php echo $job_contents; ?>
			  </div>
			  
			  <div class="spacer"></div>
			  
			  <div class="icon_bar">
			  <ul>
			  <li><img src="images/fe/view.png" alt="" /> <?php echo addslashes(t('View'))?></li>
			   <li>|</li>
			  <li class="last"><img src="images/fe/mass.png" alt="" /><?php echo addslashes(t('Messages'))?></li>
			  </ul>
			   <div class="spacer"></div>
			  </div>
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

<!--lightbox complete job-->
<div class="lightbox04 photo_zoom08">
<div id="div_err2">
</div>
  <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
  <h4><?php echo addslashes(t('Job Completed'))?></h4>
  <div class="redio_div">
  <input type="hidden" id="h_job_id" name="h_job_id" value="" />
  <input name="radio_comp" type="radio" value="1" checked="checked" /> <?php echo addslashes(t('Yes'))?> 
  <input name="radio_comp" type="radio" value="2" /> <?php echo addslashes(t('No'))?>
  <input class="small_button" id="btn_complete" type="button" value="<?php echo addslashes(t('Submit'))?>" />
  </div>
 
</div>
<!--lightbox complete job-->
<!--Buyer details -->
<div class="lightbox04 photo_zoom09">
      <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/Close.png" alt="" /></a></div>
      <h3>Buyer details </h3>
      <div class="lable02">Buyer </div>
      <div class="textfell"><img src="images/img.png" alt="" /></div>
      <div class="spacer"></div>
      
      
           <div class="lable02"></div>
      <div class="textfell"><strong>John</strong></div>
      <div class="spacer"></div>
      
      
      
           <div class="lable02">Member since </div>
      <div class="textfell">25.02.2010</div>
      <div class="spacer"></div>
      
      
           <div class="lable02">Total no of job posted </div>
      <div class="textfell">2</div>
      <div class="spacer"></div>
      
      
      
           <div class="lable02">Total number of job awarded </div>
      <div class="textfell">5</div>
      <div class="spacer"></div>
      
</div>
<!--Buyer details -->

