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
		setTimeout('window.location.reload()',2000);

	}
</script>
<div id="div_err1">
</div>


<form name="ajax_frm_job_confirm" id="ajax_frm_job_confirm" method="post" action="<?php echo base_url().'job/save_quote_job'?>">
<!--lightbox-->
<div class="lightbox02 photo_zoom02 width04">
      <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
      <h3><?php echo addslashes(t('Place Quote'))?></h3>
      <div class=" lable04"><?php echo addslashes(t('Your bid'))?> :</div>
      <div class="textfell">
            <input name="" type="text" />
      </div>  <div class="lable03">TL</div>
      <div class="spacer"></div>
       <div class=" lable04"><?php echo addslashes(t('Message'))?> :</div>
      <div class="textfell06">
          <textarea name="" cols="" rows=""></textarea>
      </div>
      <div class="spacer"></div>
      <div class=" lable04"></div>
      <input class="small_button" type="button" value="<?php echo addslashes(t('Submit'))?>" />
</div>
<!--lightbox-->
</form>