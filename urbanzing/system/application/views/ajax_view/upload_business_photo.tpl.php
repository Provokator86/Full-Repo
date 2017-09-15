<script type="text/javascript">
    $(document).ready(function() {
	$('form#ajax_upload_business_photo').ajaxForm({
		dataType:  'script',
		beforeSubmit: ajax_upload_business_photo_before_ajaxform,
		success:      ajax_upload_business_photo_after_ajaxform
	});

	$('form#ajax_upload_business_photo').submit(function() {
		// inside event callbacks 'this' is the DOM element so we first
		// wrap it in a jQuery object and then invoke ajaxSubmit
		//$(this).ajaxSubmit();

		// !!! Important !!!
		// always return false to prevent standard browser submit and page navigation
		return false;
	});
});

function ajax_upload_business_photo_before_ajaxform()
{
    document.getElementById('tbl_msg').style.display    = 'none';
}

function ajax_upload_business_photo_after_ajaxform(responseText)
{
    if(responseText!='' && responseText!='ok')
    {
        document.getElementById('tbl_msg').style.display    = 'block';
        document.getElementById('td_message').innerHTML     = responseText;
    }
    else
    {
        window.location.reload();
    }

}
</script>
<div class="sign_up" style="width: 375px;">
        <div class="margin15"></div>
        <div class="signup_left" style="border: 0px;">
        <form name="ajax_upload_business_photo" id="ajax_upload_business_photo" class="ajax_upload_business_photo" action="<?=base_url().'ajax_controller/ajax_upload_business_photo'?>" method="post" enctype="multipart/form-data">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
             <td colspan="2">
				 <h5>Please upload a picture for this business.</h5>
				 <span>
					 Only JPG files supported.<br/>
					 File size should be less than <?php echo $max_file_size ?> KB.
				 </span>
			 </td>
             </tr>
             <tr>
                <td colspan="2">
                    <table id="tbl_msg" style="display: none;"  width="97%" cellspacing="0" cellpadding="5" border="0" class="msg_error">
                        <tr>
                            <td id="td_message" style="padding-left: 25px;"></td>
                        </tr>
                    </table>
                </td>
            </tr>
          <tr>
            <td align="right">Picture: </td>
            <td>
                <input type="file" id="img" name="img" />
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="40">
                <input type="hidden" name="is_posted" value="1" />
                <input type="hidden" name="item_type" value="<?=$item_type?>" />
                <input type="hidden" name="item_id" value="<?=$item_id?>" />
                <input class="button_02" type="button" value="Submit >>" onclick="$('#ajax_upload_business_photo').submit();" /></td>
          </tr>
        </table>
        </form>
        </div>
   </div>