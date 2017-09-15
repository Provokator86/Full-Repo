<script type="text/javascript">
    $(document).ready(function() {
	$('form#ajax_incorrect_business').ajaxForm({
//		dataType:  'script'
		beforeSubmit: incorrect_business_before_ajaxform,
		success:      incorrect_business_after_ajaxform
	});

	$('form#ajax_incorrect_business').submit(function() {
		// inside event callbacks 'this' is the DOM element so we first
		// wrap it in a jQuery object and then invoke ajaxSubmit
		//$(this).ajaxSubmit();

		// !!! Important !!!
		// always return false to prevent standard browser submit and page navigation
		return false;
	});
});

function incorrect_business_before_ajaxform()
{
    document.getElementById('tbl_msg').style.display    = 'none';
}

function incorrect_business_after_ajaxform(responseText)
{
    if(responseText!='')
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
        <form name="ajax_incorrect_business" id="ajax_incorrect_business" class="ajax_incorrect_business" action="<?=base_url().'ajax_controller/ajax_incorrect_business'?>" method="post">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
             <td colspan="2"><h5>Please give correct information on this business. </h5></td>
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
            <td align="right" valign="top">Type: </td>
            <td>
                <!--<select id="status" name="status">
                    <option value="D">Duplicate</option>
                    <option value="I">Inaccurate</option>
                    <option value="C">Closed</option>
                    <option value="O">Other</option>
                </select>-->
				<input type="radio" id="status" name="status" value="D" /> Duplicate<br />
				<input type="radio" id="status" name="status" value="I" /> Inaccurate<br />
				<input type="radio" id="status" name="status" value="C" /> Closed<br />
				<input type="radio" id="status" name="status" value="O" /> Other
            </td>
          </tr>
          <tr>
              <td align="right" valign="top">Comment: </td>
            <td>
                <textarea rows="5" cols="30" name="comment" id="comment"></textarea>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="40">
                <input type="hidden" name="is_posted" value="1" />
                <input type="hidden" name="item_type" value="<?=$item_type?>" />
                <input type="hidden" name="item_id" value="<?=$item_id?>" />
                <input class="button_02" type="button" value="Submit >>" onclick="$('#ajax_incorrect_business').submit();" /></td>
          </tr>
        </table>
        </form>
        </div>
   </div>