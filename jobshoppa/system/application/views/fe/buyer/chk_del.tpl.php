<script type="text/javascript">
    $(document).ready(function() {
		$("#btn_no").click(function(){
			$("#fancybox-close").click();
		});
	
		$('form#ajax_frm_job_del').ajaxForm({
			//		dataType:  'script'
			beforeSubmit: ajax_login_before_ajaxform,
			success:      ajax_login_after_ajaxform
		});

		$('form#ajax_frm_job_del').submit(function() {
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
			//responseText = responseText.split('|');
			//$('#div_err').html('<div class="error"><span class="left">'+responseText[1]+'</span><div>');
			
						
			responseText = responseText.split('|');
			//alert(responseText[1]);
			var s_msg = responseText[1];
			//$('#div_err1').html('<div class="error"><span class="left">'+s_msg+'</span><div>');
			if(responseText[0]==1)
			{
				$('#div_err1').html('<div class="success_massage"><strong>'+s_msg+'</strong><div>');
			}	
			else
				$('#div_err1').html('<div class="error_massage"><strong>'+s_msg+'</strong><div>');
			
		
			
		}	
		//window.location.reload();
		setTimeout('window.location.reload()',2000);

	}
</script>
<div id="div_err1">
</div>
<form name="ajax_frm_job_del" id="ajax_frm_job_del" method="post" action="<?php echo base_url().'buyer/delete_job'?>">
<div class="cancel_box lightbox_all" style="display:block;">
    <!--<div class="close"><a href="javascript:void(0)" onclick="hide_dialog()"><img src="../images/close.png" alt="" /></a></div>-->
    <div class="top">&nbsp;</div>
    <div class="mid">
        <div class="title">
            <h3><span>Are you sure that you wants to </span>delete the job?</h3>
        </div>
        <div class="clr"></div>
        <div class="label01">&nbsp;</div>
        <div class="field01">
		<input type="hidden" name="h_job_id" id="h_job_id" value="<?php echo $i_job_id?>" />
        <input type="submit" name="btn_sub" value="Yes" /> 
		<input type="submit" value="No"  name="btn_sub" id="btn_no" />
        </div>
        <div class="clr"></div>
    </div>
    <div class="bot">&nbsp;</div>
</div>
</form>

