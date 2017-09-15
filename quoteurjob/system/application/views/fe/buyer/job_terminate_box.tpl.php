<script type="text/javascript">
    $(document).ready(function() {
	
		$('form#ajax_frm_job_confirm').ajaxForm({
			//		dataType:  'script'
			beforeSubmit: ajax_login_before_ajaxform,
			success:      ajax_login_after_ajaxform
		});

		$('form#ajax_frm_job_confirm').submit(function() {
			// inside event callbacks 'this' is the DOM element so we first
			// wrap it in a jQuery object and then invoke ajaxSubmit
			//$(this).ajaxSubmit();

			// !!! Important !!!
			// always return false to prevent standard browser submit and page navigation
			return false;
		});
	});

	function ajax_login_before_ajaxform()
	{
		if($.trim($("#s_terminate_reason").val())=='')
		{
			$('#div_err1').html('<div class="error"><span class="left"><?php echo addslashes(t('Provide terminate reason'));?></span><div>');
				
				return false;
		}
		if($.trim($("#s_comments").val())=='')
		{
			$('#div_err1').html('<div class="error"><span class="left"><?php echo addslashes(t('Provide feedback'));?></span><div>');
				
				return false;
		}
		if($("#i_rating option:selected").val()>2)
		{
			$('#div_err1').html('<div class="error"><span class="left"><?php echo addslashes(t('Rating must be given under 3'));?></span><div>');
			
			return false;
		}
		
	}

	function ajax_login_after_ajaxform(responseText)
	{
		
		if(responseText!='')
		{			
/*			responseText = responseText.split('|');
			//alert(responseText[1]);
			var s_msg = responseText[1];
			
			$('#div_err1').html('<div class="error"><span class="left">'+s_msg+'</span><div>');*/
			responseText = responseText.split('|');
			//alert(responseText[1]);
			var s_msg = responseText[1];
			//$('#div_err1').html('<div class="error"><span class="left">'+s_msg+'</span><div>');
			if(responseText[0]==1)
			{
				$('#div_err1').html('<div class="success"><span class="left">'+s_msg+'</span><div>');
			}	
			else
				$('#div_err1').html('<div class="error"><span class="left">'+s_msg+'</span><div>');
			
			
			
			
		}	
		window.location.reload();

	}
</script>


<form name="ajax_frm_job_confirm" id="ajax_frm_job_confirm" method="post" action="<?php echo base_url().'buyer/save_job_terminate'?>">

<div>
  <div id="deny_div" class="lightbox">
  		<div id="div_err1">
		</div>
		<h1><?php echo t('Why do you want to terminate')?>?</h1>
		<!-- <div class="lable01"></div>-->
			<div class="fld01"><?php echo t('Reason')?>  :
				  <input type="hidden" name="h_job_id" id="h_job_id" value="<?php echo $i_job_id?>" />
				  <textarea name="s_terminate_reason" id="s_terminate_reason"  cols="45" rows="5" style="width:290px; height:100px;"></textarea>
			</div>
		
			<div class="fld01"><?php echo t('Feedback')?>  :
				  <textarea name="s_comments" id="s_comments"  cols="45" rows="5" style="width:290px; height:100px;"></textarea>
			</div>
			<div class="spacer"></div>
			 
			<div class="fld01"><?php echo t('Rating')?> :
				  <select name="i_rating" id="i_rating" style="width:100px;">
					  <option value="1">1 </option>
					  <option value="2">2 </option>
					 <!-- <option value="3">3 </option>
					  <option value="4">4 </option>
					  <option value="5">5 </option>-->
                 </select>
			</div>
						
  			<div class="spacer"></div>
			<div class="lable01"></div>
			<div class="fld01">
				 <input  class="button" name="btn_sub" type="submit" value="<?php echo t('Submit')?>" />
				  
			</div>
			<div class="spacer"></div>
  </div>
</div>
</form>