<script type="text/javascript">
    $(document).ready(function() {
	$('form#ajax_import_contact').ajaxForm({
//		dataType:  'script'
		beforeSubmit: import_contact_before_ajaxform,
		success:      import_contact_after_ajaxform
	});

	$('form#ajax_import_contact').submit(function() {
		// inside event callbacks 'this' is the DOM element so we first
		// wrap it in a jQuery object and then invoke ajaxSubmit
		//$(this).ajaxSubmit();

		// !!! Important !!!
		// always return false to prevent standard browser submit and page navigation
		return false;
	});
});

function import_contact_before_ajaxform()
{
    document.getElementById('tbl_msg').style.display    = 'none';
    document.getElementById('tbl_loading').style.display    = 'block';
    document.getElementById('td_loading').innerHTML     = "<img src='<?=base_url()?>images/front/ajax-loader.gif'/>"
}

function import_contact_after_ajaxform(responseText)
{
    document.getElementById('tbl_loading').style.display    = 'none';
//    alert(responseText);
    if(responseText!='' && responseText=='err')
    {
        document.getElementById('tbl_msg').style.display    = 'block';
        document.getElementById('td_message').innerHTML     = 'Unable to get contact detail. Please give proper information.';
    }
    else if(responseText!='')
    {
        //document.getElementById('tbl_msg').style.display    = 'block';
        
        document.getElementById('contact_select').innerHTML     = responseText;
    }
    else
    {
        window.location.reload();
    }

}
</script>
<div class="sign_up" style="width: 450px;">
        <div class="margin15"></div>
        <div class="signup_left" style="border: 0px;width: 450px;">
        <form name="ajax_import_contact" id="ajax_import_contact" class="ajax_import_contact" action="<?=base_url().'ajax_controller/ajax_import_contact'?>" method="post">
            <div id="contact_select">
        <table width="100%" border="0" cellspacing="5" cellpadding="5">
          <tr>
             <td colspan="2"><h5>Please select a mail type and give your username and password. </h5></td>
             </tr>
             <tr>
                 <td colspan="2" align="center">
                    <table id="tbl_msg" style="display: none;"  width="97%" cellspacing="0" cellpadding="5" border="0" class="msg_error">
                        <tr>
                            <td id="td_message" style="padding-left: 25px;"></td>
                        </tr>
                    </table>
                    <table id="tbl_loading" style="display: none;"  width="97%" cellspacing="0" cellpadding="5" border="0" >
                        <tr>
                            <td id="td_loading" align="center"></td>
                        </tr>
                    </table>

                </td>
            </tr>
            <tr>
                <td align="right" valign="top">E-mail: </td>
                <td>
                    <input type="text" id="email" name="email"/>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top">Password: </td>
                <td>
                    <input type="password" id="password" name="password"/>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top">Account type: </td>
                <td>
                    <input type="radio" tabindex="3" id="gmail" value="gmail" name="type">
                    <img alt="Gmail" onclick="document.getElementById('gmail').checked = true" src="<?=base_url()?>images/front/gmail_logo.gif">
                    <input type="radio" tabindex="4" id="hotmail" value="hotmail" name="type">
                    <img alt="Hotmail" onclick="document.getElementById('hotmail').checked = true" src="<?=base_url()?>images/front/hotmail_logo.gif">
                    <input type="radio" tabindex="5" id="yahoo" value="yahoo" name="type">
                    <img alt="Yahoo" onclick="document.getElementById('yahoo').checked = true" src="<?=base_url()?>images/front/yahoo_logo.gif">
                </td>
            </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td height="40">
                <input type="hidden" name="is_posted" value="1" />
                <input type="hidden" name="from_type" value="1st" />
                <input class="button_02" type="button" value="Submit >>" onclick="$('#ajax_import_contact').submit();" /></td>
          </tr>
        </table>
            </div>
        </form>
        </div>
   </div>