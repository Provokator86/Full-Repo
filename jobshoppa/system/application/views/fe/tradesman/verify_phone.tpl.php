<script type="text/javascript">
    $(document).ready(function() {	
		$("#btn_no").click(function(){
			$("#fancybox-close").click();
		});
	
	
		$('form#ajax_frm_invite_job_del').ajaxForm({
			//		dataType:  'script'
			beforeSubmit: ajax_login_before_ajaxform,
			success:      ajax_login_after_ajaxform
		});

		$('form#ajax_frm_invite_job_del').submit(function() {
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
			if(responseText[0]==1)
				$('#div_err1').html('<div class="success_massage">'+responseText[1]+'<div>');
			else
				$('#div_err1').html('<div class="error_massage">'+responseText[1]+'<div>');
		}	
		setTimeout('window.location.reload()',2000);

	}
</script>
<div id="div_err1">
</div>


<form name="ajax_frm_invite_job_del" id="ajax_frm_invite_job_del" method="post" action="<?php echo base_url().'tradesman/do_phone_verification'?>">

<div class="lightbox03" style="display:block;">
    <div class="close"><!--<a href="javascript:void(0)" onclick="hide_dialog()"><img src="../images/close.png" alt="" /></a>--></div>
    <div class="top">&nbsp;</div>
    <div class="mid">
        <div class="title">
            <h3><span>Phone</span> verification</h3>
        </div>
      <div class="clr"></div>
		<h2>Would you like us to verify your phone number?</h2>
		<div class="button" align="center">
		<input type="submit" value="Ok" />
		</div>

    </div>
    <div class="bot">&nbsp;</div>
</div>
</form>