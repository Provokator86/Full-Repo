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
		var flag = true;
		if($.trim($("#s_terminate_reason").val())=='')
		{
			$('#div_err1').html('<div class="error_massage">Provide terminate reason<div>');
				flag = false;
				return false;
		}
		if($.trim($("#s_comments").val())=='')
		{
			$('#div_err1').html('<div class="error_massage">Provide review<div>');
				flag = false;
				return false;
		}
/*		if($("#i_rating option:selected").val()>2)
		{
			$('#div_err1').html('<div class="error_massage">Rating must be given under 3<div>');
			flag = false;
			return false;
		}*/
		if(flag==true)
			 $('#btn_sub').attr('disabled','disabled');		
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
		//window.location.reload();
		setTimeout('window.location.reload()',2000);

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

<div class="terminate_box lightbox_all" style="display:block;">
    <div class="close"><!--<a href="javascript:void(0)" onclick="hide_dialog()"><img src="../images/close.png" alt="" /></a>--></div>
    <div class="top">&nbsp;</div>
<form name="ajax_frm_job_confirm" id="ajax_frm_job_confirm" method="post" action="<?php echo base_url().'buyer/save_job_terminate'?>">
    <div class="mid">
        <div class="title">
            <h3><span>Why do you want to </span> terminate this Job?</h3>
        </div>
        <div class="clr"></div>
        <div class="label01">Reason :</div>
        <div class="field01">
		 <input type="hidden" name="h_job_id" id="h_job_id" value="<?php echo $i_job_id?>" />
		  <textarea  name="s_terminate_reason" id="s_terminate_reason" style="width:300px; height:50px;"></textarea>
        </div>
        <div class="clr"></div>
        <div class="label01">Review :</div>
        <div class="field01">
            <textarea name="s_comments" id="s_comments" style="width:300px; height:50px;"></textarea>
        </div>
        <div class="clr"></div>
		<div class="label01">Feedback</div>
		<div class="field01">
		 <input type="radio" name="i_positive" class="i_positive" id="i_positive"  value="1" onclick="chk_rate(0)"/>Positive &nbsp; 
         <input type="radio" name="i_positive" class="i_positive" id="i_negative"  value="0" checked onclick="chk_rate(1)" />Negative
		</div> 		
		<div class="clr"></div>
         <div class="label01">Review ratings:</div>
        <div class="field01">
            <select name="i_rating" id="i_rating" style="width:100px;">
					  <option value="1">1 </option>
					  <option value="2">2 </option>
                 </select>
        </div>
        <div class="clr"></div>
       
        <div class="label01">&nbsp;</div>
        <div class="field01">
            <input type="submit" value="Submit"  name="btn_sub" id="btn_sub"/>
        </div>
        <div class="clr"></div>
    </div>
	</form>
	
    <div class="bot">&nbsp;</div>
</div>
