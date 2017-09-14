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
		var quote_val = /^[0-9]+$/;
		if($.trim($("#txt_quote").val())=='')
		{
			$('#div_err1').html('<div class="error_massage">Provide quote<div>');
				
				return false;
		}
		else if(quote_val.test($.trim($("#txt_quote").val()))==false)
		{
			$('#div_err1').html('<div class="error_massage">Please enter numeric value with no decimal point<div>');
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
				$('#div_err1').html('<div class="success_massage">'+s_msg+'<div>');
			}	
			else
				$('#div_err1').html('<div class="error_massage">'+s_msg+'<div>');
			
			
		}	
		window.location.reload();

	}
</script>
<div id="div_err1">
</div>





<form name="ajax_frm_job_confirm" id="ajax_frm_job_confirm" method="post" action="<?php echo base_url().'tradesman/do_quote_update'?>">



<div class="lightbox2" style="display:block;">
    <div class="close"><!--<a href="javascript:void(0)" onclick="hide_dialog()"><img src="images/close.png" alt="" /></a>--></div>
    <div class="top">&nbsp;</div>
    <div class="mid">
        <div class="label01">Quote Price : <span style="padding-left:10px;">£</span></div>
        <div class="field01">
			<input type="hidden" name="h_quote_id" id="h_quote_id" value="<?php echo $i_quote_id?>" />
            <input name="txt_quote" id="txt_quote" type="text" />
        </div>
        <div class="clr"></div>
        <div class="label01">&nbsp;</div>
        <div class="field01">
            <input type="submit" value="Submit" />
        </div>
        <div class="clr"></div>
    </div>
    <div class="bot">&nbsp;</div>
</div>
</form>