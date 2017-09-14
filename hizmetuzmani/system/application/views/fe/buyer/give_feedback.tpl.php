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
		//alert($("#i_rating option:selected").val());
		//alert($("input[@name='i_positive']:checked","#ajax_frm_job_confirm").val());
		if($.trim($("#s_comments").val())=='')
		{
			$('#div_err1').html('<div class="error"><span class="left"><?php echo addslashes(t('Provide comments'));?></span><div>');
				
				return false;
		}
	
		
	if($("input[@name='i_positive']:checked","#ajax_frm_job_confirm").val()==1)
		{
			if($("#i_rating option:selected").val()<=2)
			{
				//alert($("#i_rating option:selected").val());
				$('#div_err1').html('<div class="error"><span class="left"><?php echo addslashes(t('Rating must be given above 2'));?></span><div>');
				
				return false;
			}
		}
	else 	
		{
			if($("#i_rating option:selected").val()>2)
				{
					$('#div_err1').html('<div class="error"><span class="left"><?php echo addslashes(t('Rating must be given below 3'));?></span><div>');
					
					return false;
				}
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
	
function chk_rate(arg)
{
	if(arg)
	{
		var myOptions = {
			1 : 1,
			2 : 2
		};
	}
	else
	{
		var myOptions = {
			3 : 3,
			4 : 4,
			5 : 5
		};
	}	
	
	$('#i_rating').empty();
	$.each(myOptions, function(val, text) {
		$('#i_rating').append(
			$('<option></option>').val(val).html(text)
		);
	});
	

}	
</script>
<div id="div_err1">
</div>

<form name="ajax_frm_job_confirm" id="ajax_frm_job_confirm" method="post" action="<?php echo base_url().'buyer/save_give_feedback'?>">

<div>
  <div id="deny_div" class="lightbox">
		<h1><?php echo t('Why do you want to accept this Job')?>?</h1>
		<!-- <div class="lable01"></div>-->
			<div class="fld01"><?php echo t('Comments')?> :
				  <input type="hidden" name="h_job_id" id="h_job_id" value="<?php echo $i_job_id?>" />
				  <textarea name="s_comments" id="s_comments"  cols="45" rows="5" style="width:290px; height:100px;"></textarea>
			</div>
			<div class="spacer"></div>
			 
			<div class="fld01"><?php echo t('Rating')?> :
				  <select name="i_rating" id="i_rating" style="width:100px;">
					  <option value="3">3 </option>
					  <option value="4">4 </option>
					  <option value="5">5 </option>
                 </select>
			</div>
			<div class="spacer"></div>
			<div class="fld01"><?php echo t('Positive')?> :
				  <input type="radio" name="i_positive" class="i_positive" id="i_positive"  value="1" checked onclick="chk_rate(0)"/><?php echo t('Yes')?> &nbsp; 
                  <input type="radio" name="i_positive" class="i_positive" id="i_negative"  value="0" onclick="chk_rate(1)" /><?php echo t('No')?>
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