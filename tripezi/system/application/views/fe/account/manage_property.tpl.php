<script type="text/javascript">
jQuery(function($){
	$(document).ready(function() {
		<!-- store current page and total rows -->
		var current_page =  $(".page_number .current").text();
		if(current_page=='')
		{
			current_page    =   1;
		}	
		var tot_rows	 =	$("#h_total_rows").val();
		<!-- store current page and total rows -->
	
		var param_id = '';
			$(".delete_property").click(function() {
			param_id = $(this).attr('rel');
			$("#h_proerty_id").val(param_id);
			show_dialog('photo_zoom02');
		});
		
		$("#btn_no").click(function() { 
			hide_dialog('photo_zoom02');
		});
		
		/* after clicking on the yes button */
		$("#btn_yes").click(function() { 
		
			var b_valid = true;
			var s_err = '';
			var property_id = $("#h_proerty_id").val();
			//alert(property_id);
			
			if(b_valid)
			{
				
				$.ajax({
							type: "POST",
							async: false,
							url: base_url+'account/ajax_delete_property',
							data: "property_id="+property_id+"&current_page="+current_page+"&total_rows="+tot_rows,
							success: function(msg){
								if(msg)
								{
								 														
									if(msg=='success')
									{
										var s_msg = 'successfully deleted.';
										$('#div_err2').html('<div class="success_massage">'+s_msg+'<div>');
									}
									else
									{
										var s_msg = 'you cannot delete this because this property have already been booked.';
										$('#div_err2').html('<div class="error_massage">'+s_msg+'<div>');
									}
								}
							}
						});
						
				setTimeout('window.location.reload()',3000);		
			}			
			return false;			
						
		
		});
		/* end after clicking on the accept button */
	
	});  // end document ready
	
});
</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="container-box">
	<?php include_once(APPPATH."views/fe/common/account_left_menu.tpl.php"); ?>
	<div class="right-part02">
	  <div class="text-container">
			<div class="inner-box03">
				  <div class="page-name02 margin00"><span>Manage Property</span> <a href="<?php echo base_url().'list-your-place' ?>">+ List Your Place</a> </div>
				 <div class="spacer">&nbsp;</div>
				<!--PROPERTY LIST -->
				<div id="property_list">
					<?php echo $property_list ?>
				</div>
				<!--PROPERTY LIST --> 
			   
				  <div class="spacer">&nbsp;</div>
			</div>
	  </div>
</div>
	<br class="spacer" />
</div>

<!--lightbox-->
<div class="light-box photo_zoom02" style="width:450px;">
<div id="div_err2">
</div>
<div class="close"><a href="javascript:void(0)" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
<h4>Are you sure to delete this property ?</h4>
<div class="subscribe-nobg">
<input type="hidden" name="h_proerty_id" id="h_proerty_id" value="" />
<span style="margin-top:5px;"></span>
<br  class="spacer"/>
<input class="button-blu" type="button" id="btn_yes" value="Yes" />
<span style="margin-left:20px;"></span>
<input class="button-blu" type="button" id="btn_no"  value="No" />
<br  class="spacer"/>
</div>
</div> 
      
<!--lightbox-->