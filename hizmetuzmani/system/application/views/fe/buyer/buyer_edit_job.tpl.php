<script language="javascript">
$(document).ready(function(){

///////////Submitting the form/////////
	$("#btn_edit").click(function(){
		var b_valid=true;
		var s_err="";
		$("#div_err").hide("slow"); 
		
		if($.trim($("#quote").val())=="")
		{
			$("#err_quote").text('<?php echo addslashes(t('Please select quote period'))?>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#err_quote").slideUp('slow').text('<?php echo addslashes(t(''))?>');
		}	
		
		/////////validating//////
		if(!b_valid)
		{
		   // $.unblockUI();  
			$("#div_err").html(s_err).show("slow");
		}
		else
		{
		$("#frm_job_edit").submit();
		}
		
		return b_valid;
	});  
	
///////////end Submitting the form/////////  
$("#btn_cancel").click(function() {
	window.location.reload();
	}); 

})
//});
</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?> 
<div class="job_categories">
<div class="top_part"></div>
<div class="midd_part height02">
	  <div class="username_box">
	  <form name="frm_job_edit" id="frm_job_edit" action="<?php echo base_url().'buyer/edit-job/'.$posted['job_id'] ?>" method="post">
	<div class="right_box03">
	<?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
			<div id="div_err">
					
			</div>
			
		  <h4><?php echo addslashes(t('Edit Job'))?></h4>
		  <div class="div02">
			 
				
				<div class="lable06"><?php echo addslashes(t('Quote Period'))?>  <span>*</span> </div>
				<select id="quote" name="quote" style="width:269px;">
				<option value=""><?php echo addslashes(t('Select'))?></option>
				<?php echo makeOptionQuotingPeriod('',encrypt($posted['quote_period'])); ?>
				</select>
				
				 <script type="text/javascript">
					$(document).ready(function() {
					  $("#quote").msDropDown();
					   $("#quote").hide();
					   $('#quote_msdd').css("background-image", "url(images/fe/select.png)");
					   $('#quote_msdd').css("background-repeat", "no-repeat");
					   $('#quote_msdd').css("width", "269px");
					   $('#quote_msdd').css("margin-top", "0px");
					   $('#quote_msdd').css("padding", "0px");
						$('#quote_msdd').css("height", "38px");
					});
		
				</script>

		<div style="padding:10px;font-size:12px; color:#666666;font-family:Arial, Helvetica, sans-serif;">
		&nbsp;&nbsp;<?php echo addslashes(t('Week(s)'))?>
		</div>
		<div class="spacer"></div>
		<div class="lable06"> </div>
		<div id="err_quote" class="err"><?php echo form_error('quote'); ?></div>
		 <div class="spacer"></div>
				 
		<div class="lable06"> </div>
		<div class="textfell11">
		<input class="small_button margintop0 fist" id="btn_edit" type="button" value="<?php echo addslashes(t('Save'))?>" />
		<input class="small_button margintop0 fist" id="btn_cancel" type="button" value="<?php echo addslashes(t('Cancel'))?>" />
		</div>
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