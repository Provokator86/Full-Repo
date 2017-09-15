<script type="text/javascript">
var show_recaptcha = false;
<?php if ($this->session->userdata('user_id') == '') { ?>
show_recaptcha = true;
<?php } ?>

$(document).ready(function() {
	if (show_recaptcha) {
		var RecaptchaOptions = {
			theme: 'white',
			lang: 'en',
			custom_theme_widget: 'div_recaptcha'
		};
		setTimeout('Recaptcha.create("<?php echo $this->config->item('recaptcha_public_key'); ?>", "div_recaptcha", RecaptchaOptions)', 5);
	}

	$('form#frm_send_to_phone').ajaxForm({
		beforeSubmit: send_2_phone_request,
		success: send_2_phone_response
	});
});

$('form#frm_send_to_phone').submit(function() {
	// always return false to prevent standard browser submit and page navigation
	return false;
});

function send_2_phone_request() {
	jQuery('.signup_left div.msg_error').remove();
	jQuery(".signup_left div.ajax_loader_container").css("display", "block");
}

function send_2_phone_response(responseText, statusText) {
	var sub = responseText.substring(0, 3);
	var org_msg = responseText.substring(3);
	var class_name = '';
	jQuery(".signup_left div.ajax_loader_container").css("display", "none");
	
	if (sub == 'ERR') {
		class_name = 'msg_error';
		jQuery("form#frm_send_to_phone table").css('display', 'block');

		if (show_recaptcha) {
			setTimeout('Recaptcha.create("<?php echo $this->config->item('recaptcha_public_key'); ?>", "div_recaptcha", RecaptchaOptions)', 5);
		}
	}
	else {
		class_name = 'msg_success';
		setTimeout("tb_remove()", 5000);
		jQuery("form#frm_send_to_phone table").css('display', 'none');
	}
	jQuery('form#frm_send_to_phone').prepend('<div class="' + class_name + '" style="padding: 10px 25px;">' + org_msg + '</div>');
}
</script>

<div class="sign_up" style="width: 450px;">
	<div class="margin15"></div>
	
	<div class="signup_left" style="border: 0px; width: 450px;">
		<div id="ajax_loader_container" style="width: 100%; text-align: center; display: none;">
			<img src="<?php echo base_url(); ?>images/front/ajax-loader.gif" border="0" />
			<div class="margin15"></div>
		</div>

		<form method="post" name="frm_send_to_phone" id="frm_send_to_phone" action="<?php echo base_url()?>business/get_send_2_phone/<?php echo $biz_id; ?>">
			<table width="100%" border="0" cellspacing="0" cellpadding="4">
				<tr>
					<td width="30%" align="left"><strong>Mobile Number:</strong></td>
					<td align="left"><input type="text" name="mobile_num" id="mobile_num" value="" style="width: 200px;" /></td>
				</tr>

				<?php if ($this->session->userdata('user_id') == '') { ?>
				<tr>
					<td>&nbsp;</td>
					<td align="left"><div id="div_recaptcha" style="display:block;">
						<div id="recaptcha_image" style="width: 220px;"></div>
						<input name="recaptcha_response_field" id="recaptcha_response_field" type="text" style="width: 200px;" />
					</div></td>
				</tr>
				<?php } ?>

				<tr>
					<td>&nbsp;</td>
					<td align="left"><input class="button_02" type="submit" value="Submit >>"  /></td>
				</tr>
			</table>
		</form>
	</div>
</div>