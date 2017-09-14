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
		if($.trim($("#crd_file_0").val())=='')
		{
			$('#div_err1').html('<div class="error_massage">Please select Credential 1.<div>');
				
				return false;
		}
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

<form name="ajax_frm_invite_job_del" id="ajax_frm_invite_job_del" method="post" action="<?php echo base_url().'tradesman/do_credentials_verification'?>" enctype="multipart/form-data">

<div class="lightbox2" style="display:block">
  <div class="close"><!--<a href="javascript:void(0)" onclick="hide_dialog()"><img src="../images/close.png" alt="" /></a>--></div>
    <div class="top">&nbsp;</div>
    <div class="mid">
        <div class="title">
            <h3><span>Credentials </span>Verify</h3>
        </div>
        <div class="clr"></div>
        <div class="label01">Credential 1:<span style="color:#FF0000;">*</span></div>
        <div class="field01">
          <input name="crd_file_0" id="crd_file_0" type="file"  size="25"/>
        </div>
        <div class="clr"></div>
          <div class="label01">Credential 2:</div>
        <div class="field01">
		<!--<input type="text" name="crd_file_0" id="crd_file_0" value="aa" />-->
          <input name="crd_file_1" type="file"  size="25"/>
        </div>
        <div class="clr"></div>
          <div class="label01">Credential 3:</div>
        <div class="field01">
          <input name="crd_file_2" type="file"  size="25"/>
        </div>
        <div class="clr"></div>
        <div class="label01">&nbsp;</div>
        <div class="field01">
            <span>the file types will be either, pdf or doc or docx and file size would be 25 MB maximum.<br />
           </span> </div>
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