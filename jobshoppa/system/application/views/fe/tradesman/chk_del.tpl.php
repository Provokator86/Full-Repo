<script type="text/javascript">
    $(document).ready(function() {
		$("#btn_no").click(function(){
			$("#fancybox-close").click();
		});
		$('form#ajax_frm_img_del').ajaxForm({
			//		dataType:  'script'
			beforeSubmit: ajax_login_before_ajaxform,
			success:      ajax_login_after_ajaxform
		});

		$('form#ajax_frm_img_del').submit(function() {
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
			var s_msg = responseText[1];			
			
			if(responseText[0]==1)
			{			
				$('#div_err_del').html('<div class="success_massage">'+s_msg+'</div>');
			}	
			else
				$('#div_err_del').html('<div class="error_massage">'+s_msg+'</div>');
		}	
		//window.location.reload();
		setTimeout('window.location.reload()',2000);

	}
</script>
<div id="div_err_del">
</div>
<form name="ajax_frm_img_del" id="ajax_frm_img_del" method="post" action="<?php echo base_url().'tradesman/delete_photo'?>">
<div class="cancel_box lightbox_all" style="display:block;">

    <!--<div class="close"><a href="javascript:void(0)" onclick="hide_dialog()"><img src="../images/close.png" alt="" /></a></div>-->
    <div class="top">&nbsp;</div>
	
    <div class="mid">
	
        <div class="title">
            <h3><span>Are you sure </span>you want to delete the photo?</h3>
        </div>
        <div class="clr"></div>
        <div class="label01">&nbsp;</div>
        <div class="field01">
		<input type="hidden" name="h_img_id" id="h_img_id" value="<?php echo $i_image_id?>" />
        <input type="submit" name="btn_sub" value="Yes" /> 
		<input type="button" value="No"  name="btn_sub" id="btn_no" />
        </div>
        <div class="clr"></div>
    </div>
    <div class="bot">&nbsp;</div>
</div>
</form>