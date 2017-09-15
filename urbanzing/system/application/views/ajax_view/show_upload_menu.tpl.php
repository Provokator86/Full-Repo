<script type="text/javascript">
$(document).ready(function() {
	$('form#ajax_upload_business_menu').ajaxForm({
		dataType:  'script',
		beforeSubmit: ajax_upload_business_menu_before_ajaxform,
		success:      ajax_upload_business_menu_after_ajaxform
	});

	$('form#ajax_upload_business_menu').submit(function() {
		// inside event callbacks 'this' is the DOM element so we first
		// wrap it in a jQuery object and then invoke ajaxSubmit
		//$(this).ajaxSubmit();

		// !!! Important !!!
		// always return false to prevent standard browser submit and page navigation
		return false;
	});
});

function ajax_upload_business_menu_before_ajaxform()
{
	document.getElementById('tbl_msg').style.display = 'none';
}

function ajax_upload_business_menu_after_ajaxform(responseText)
{
	if(responseText != '' && responseText != 'ok')
	{
		document.getElementById('tbl_msg').style.display    = 'block';
		document.getElementById('td_message').innerHTML     = responseText;
	}
	else
	{
		window.location.reload();
	}
}


/**
 * Start of Upload Menu Section
 */
var tb_counterUpload = 1;
var tb_markerUpload = 1;
var tb_maxUpload = parseInt(<?=$no_of_menu?>) + 1;
var tb_fileFieldHeight = 26;
var tb_boxMarginDynamic = Number(tb_fileFieldHeight / 2);
var tb_boxHeight = '';
var tb_boxMarginTop = '';

function showUploadDiv() {
	if (tb_markerUpload < tb_maxUpload) {
		tb_counterUpload++;
		tb_markerUpload++;
		jQuery('<div style="margin-top:5px; margin-bottom:5px;" id="menu_image_container_'+ tb_counterUpload +'"><input id="menu_image_name' + tb_counterUpload + '" name="menu_image_name' + tb_counterUpload + '" type="file" style="width: auto;" />&nbsp;<img src="' + base_url + 'images/admin/trash.gif" onclick="hideUploadDiv(\'menu_image_container_'+ tb_counterUpload +'\')" alt="Delete" style="cursor:pointer;" /></div>').appendTo("#more_menu_image_container");

		if (tb_markerUpload > 3) {
			tb_boxHeight = jQuery("#TB_ajaxContent").css("height");
			tb_boxHeight = Number(tb_boxHeight.substring(0, tb_boxHeight.lastIndexOf("px")));
			jQuery("#TB_ajaxContent").css("height", (tb_boxHeight + tb_fileFieldHeight));

			if (tb_markerUpload % 2) {
				tb_boxMarginTop = jQuery("#TB_window").css("margin-top");
				tb_boxMarginTop = Number(tb_boxMarginTop.substring(0, tb_boxMarginTop.lastIndexOf("px")));
				jQuery("#TB_window").css("margin-top", (tb_boxMarginTop - tb_fileFieldHeight));
			}
		}

		if (tb_markerUpload == (tb_maxUpload - 1)) {
			jQuery("#more_upload_menu_image_option").css("display", "none");
		}

		jQuery("#counter_menu_image").val(tb_counterUpload);
	}
}

function hideUploadDiv(id) {
	jQuery("#" + id).remove();
	tb_markerUpload--;

	if (tb_markerUpload > 3) {
		tb_boxHeight = jQuery("#TB_ajaxContent").css("height");
		tb_boxHeight = Number(tb_boxHeight.substring(0, tb_boxHeight.lastIndexOf("px")));
		jQuery("#TB_ajaxContent").css("height", (tb_boxHeight - tb_fileFieldHeight));

		if (tb_markerUpload % 2) {
			tb_boxMarginTop = jQuery("#TB_window").css("margin-top");
			tb_boxMarginTop = Number(tb_boxMarginTop.substring(0, tb_boxMarginTop.lastIndexOf("px")));
			jQuery("#TB_window").css("margin-top", (tb_boxMarginTop + tb_fileFieldHeight));
		}
	}

	jQuery("#more_upload_menu_image_option").css("display", "");
	jQuery("#counter_menu_image").val(tb_counterUpload);
}
/**
 * End of Upload Menu Section
 */
</script>
<div class="sign_up" style="width: 375px;">
	<div class="margin15"></div>
	
	<div class="signup_left" style="border: 0px;">
		<form name="ajax_upload_business_menu" id="ajax_upload_business_menu" class="ajax_upload_business_menu" action="<?=base_url().'ajax_controller/ajax_upload_business_menu'?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="is_posted" value="1" />
			<input type="hidden" name="item_type" value="<?=$item_type?>" />
			<input type="hidden" name="item_id" value="<?=$item_id?>" />
			<input type="hidden" name="counter_menu_image" id="counter_menu_image" value="1" />

			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan="2">
						<h5>Please upload the menu on this business.</h5>
						<span>
							Only JPG files supported.<br/>
							File size should be less than <?php echo $max_file_size ?> KB.
						</span>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table id="tbl_msg" style="display: none;" width="97%" cellspacing="0" cellpadding="5" border="0" class="msg_error">
							<tr>
								<td id="td_message" style="padding-left: 25px;"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="right">Picture: </td>
					<td>
						<input type="file" id="menu_image_name1" name="menu_image_name1" />
						<div id="more_menu_image_container" style="display:inline;"></div>
						<br/>
						<span id="more_upload_menu_image_option">
							<a href="javascript:void(0);" onclick="showUploadDiv();">Click here to add more pages to the Menu</a>
						</span>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td height="40"><input class="button_02" type="button" value="Submit >>" onclick="$('#ajax_upload_business_menu').submit();" /></td>
				</tr>
			</table>
		</form>
	</div>
</div>