<script type="text/javascript">
    $(document).ready(function() {
		$('form#ajax_frm_msg_del').ajaxForm({
			//		dataType:  'script'
			beforeSubmit: ajax_login_before_ajaxform,
			success:      ajax_login_after_ajaxform
		});

		$('form#ajax_frm_msg_del').submit(function() {
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
			responseText = responseText.split('|');
			$('#div_err').html('<div class="error"><span class="left">'+responseText[1]+'</span><div>');
		}	
		window.location.reload();

	}
</script>
<div id="div_err">
</div>

<form name="ajax_frm_msg_del" id="ajax_frm_msg_del" method="post" action="<?php echo base_url().'private_message/delete_message'?>">
<div>
	<div id="delete_div" class="lightbox">
		  <h1><?php echo t('Are you sure you want to delete the message?')?></h1>
		  <div style="text-align:center">
		  		<input type="hidden" name="h_msg_id" id="h_msg_id" value="<?php echo $i_msg_id?>" />
				<input name="btn_sub"  class="pink_button01" type="submit" value="Yes" />
				&nbsp;
				<input name="btn_sub"  class="pink_button01" type="submit" value="No" />
		  </div>
	</div>
</div>
</form>