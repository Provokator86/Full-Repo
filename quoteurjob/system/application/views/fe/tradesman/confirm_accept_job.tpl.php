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
		//document.getElementById('tbl_msg').style.display    = 'none';
	}

	function ajax_login_after_ajaxform(responseText)
	{
		
		if(responseText!='')
		{			
/*			responseText = responseText.split('|');
			//alert(responseText[1]);
			var s_msg = responseText[1];
			
			$('#div_err1').html('<div class="error"><span class="left">'+s_msg+'</span><div>');
*/		
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
<div id="div_err1">
</div>

<form name="ajax_frm_job_confirm" id="ajax_frm_job_confirm" method="post" action="<?php echo base_url().'tradesman/pay_job'?>">
<div>
	<div class="lightbox">
		  <h1><?php echo t('do you want to accept this Job')?> ?</h1>
		 <div style="text-align:center;">
		  		<input type="hidden" name="h_job_id" id="h_job_id" value="<?php echo $i_job_id?>" />
				<?php /*?><input type="text" name="h_tradesman_id" id="h_tradesman_id" value="<?php echo $i_tradesman_id?>" /><?php */?>
				<input name="btn_sub"  class="pink_button01" type="submit" value="<?php echo t('Yes')?>" />
				&nbsp;
				<input name="btn_sub"  class="pink_button01" type="submit" value="<?php echo t('No')?>" />
		</div>
	</div>
</div>
</form>