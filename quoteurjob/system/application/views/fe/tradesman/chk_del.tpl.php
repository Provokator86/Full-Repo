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
			if(responseText[0]==1)
				$('#div_err_del').html('<div class="success"><span class="left">'+responseText[1]+'</span><div>');
			else
				$('#div_err_del').html('<div class="error"><span class="left">'+responseText[1]+'</span><div>');
		}	
		window.location.reload();

	}
</script>


<form name="ajax_frm_img_del" id="ajax_frm_img_del" method="post" action="<?php echo base_url().'tradesman/delete_photo'?>">
<div>
	<div id="delete_div" class="lightbox">
	<div id="div_err_del">
	</div>
		  <h1><?php echo t('Are you sure you want to delete the photo?')?></h1>
		  <div style="text-align:center">
		  		<input type="hidden" name="h_img_id" id="h_img_id" value="<?php echo $i_image_id?>" />
				<input name="btn_sub"  class="pink_button01" type="submit" value="<?php echo t('Yes')?>" />
				&nbsp;
				<input name="btn_sub" id="btn_no"  class="pink_button01" type="submit" value="<?php echo t('No')?>" />
		  </div>
	</div>
</div>
</form>