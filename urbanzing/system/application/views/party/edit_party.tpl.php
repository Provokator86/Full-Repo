<style type="text/css">
	.suggestionsBox {
		position: relative;
		left: 30px;
		margin: 10px 0px 0px 0px;
		width: 325px;
		background-color: #212427;
		-moz-border-radius: 7px;
		-webkit-border-radius: 7px;
		border: 2px solid #000;
		color: #fff;
	}

	.suggestionList {
		margin: 0px;
		padding: 0px;
	}

	.suggestionList li {
		margin: 0px 0px 3px 0px;
		padding: 3px;
		cursor: pointer;
	}

	.suggestionList li:hover {
		background-color: #659CD8;
	}
</style>

<form name="frm_party_edit" action="<?php echo base_url().'party/save_party/'; ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="shakalaka" id="shakalaka" value="1" />
	<input type="hidden" name="status" id="status" />
	<input type="hidden" name="id" id="id" value="<?php echo $data['id']; ?>" />
	
	<div class="plan_party">
		<h1>Hello <?php echo $this->session->userdata('user_username'); ?>, 
			<div class="back_btn">
				<a href="<?php echo base_url().'business/'.$business_id; ?>">Back</a>
			</div>
			 <br><span style="scolor:#2A4B48; font-family:Helvetica 45 Light; font-size: 20px; font-weight: normal; line-height:40px;"><?=$party_page_upper_text[0]['title']?></span>
		</h1>

		<div class="margin15"></div>
			<?=html_entity_decode($party_page_upper_text[0]['description'])?>
		<div class="margin15"></div>
		<?php echo $this->load->view('admin/common/message_page.tpl.php'); ?>

		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td align="left" colspan="3"><h3>Take some time and fill out the form below</h3></td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr>
				<td align="right" width="100"><h3>Event Title: <span>*</span></h3></td>
				<td align="left"><input type="text" name="event_title" id="event_title" value="<?php echo $data['event_title']; ?>" /></td>
				<td align="right"><h6>* marked fields are mandatory</h6></td>
			</tr>
		</table>

		<div class="margin15"></div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td width="205" align="right">Choose an Occasion <span>*</span></td>
				<td align="left"><select name="occasion_id" id="occasion_id" style="<?php echo $style_width_box_gen; ?>">
					<?php echo $occasion_option; ?>
				</select></td>
			</tr>
			<tr>
				<td align="right">Upload Picture</td>
				<td align="left">
					<input style="<?php echo $style_width_box_gen; ?>" type="file" name="img" />
					<br/>
						<span> 	
							Only JPG files supported.
							File size should be less than <?php echo $max_file_size ?> KB.
						</span>
				</td>
			</tr>
			<tr>
				<td align="right">Host Name <span>*</span></td>
				<td align="left"><input style="<?php echo $style_width_box_gen; ?>" type="text" name="host_name" id="host_name" value="<?php echo $data['host_name']; ?>" /></td>
			</tr>
			<tr>
				<td align="right">Phone Number <span>*</span></td>
				<td align="left"><input style="<?php echo $style_width_box_gen; ?>" type="text" name="phone_no" id="phone_no" value="<?php echo $data['phone_no']; ?>" /></td>
			</tr>

			<tr>
				<td align="right">Locations <span>*</span></td>
				<td align="left"><select name="business_type_id" id="business_type_id" style=" <?php echo $style_width_box_gen; ?>" onchange="clear_location()">
					<option value="">Select location</option>
					<?php echo $business_category; ?>
					<option value="-1" <?php echo ($data['business_type_id'] == -1) ? ' selected' : ''; ?>>Others</option>
				</select></td>
			</tr>

			<tr>
				<td align="right">Location Name <span>*</span></td>
				<td align="left">
					<input style="<?php echo $style_width_box_gen; ?>" type="text" name="location_name" id="location_name" value="<?php echo $data['location_name']; ?>" onkeyup="get_location_details(this.value);"/>
					<div class="suggestionsBox" id="suggestions" style="display: none;">
						<img src="<?php echo base_url(); ?>images/front/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="up" />
						<div class="suggestionList" id="autoSuggestionsList"></div>
					</div>
				</td>
			</tr>

			<tr>
				<td align="right">Street Address</td>
				<td align="left"><div id="div_street_address">
                                                <input type="text" name="street_address" id="street_address" style="<?php echo $style_width_box_gen; ?>" value="<?php echo $data['street_address']; ?>"/></div>
				</td>
			</tr>

			<tr>
				<td align="right">Country <span>*</span></td>
				<td align="left">
					<select name="country_id" id="country_id" onchange="fun_country(this.value);">
						<?php echo $country_option; ?>
					</select>
				</td>
			</tr>

			<tr>
				<td align="right">State <span>*</span></td>
				<td align="left">
					<div id="div_state">
						<select name="state_id" id="state_id" onchange="fun_state(this.value);">
							<option value="">Select State</option>
							<?php echo $state_option; ?>
						</select>
					</div>
				</td>
			</tr>

			<tr>
				<td align="right">City <span>*</span></td>
				<td align="left">
					<div id="div_city">
						<select name="city_id" id="city_id">
							<option value="">Select City</option>
							<?php echo $city_option; ?>
						</select>
					</div>
				</td>
			</tr>

			<tr>
				<td align="right">Zipcode <span>*</span></td>
				<td align="left">
					<div id="div_zipcode">
						<input type="text" name="zipcode" id="zipcode" value="<?php echo $zip_code; ?>" style="<?php echo $style_width_box_gen; ?>" />
					</div>

				</td>
			</tr>
			<tr>
			<td> &nbsp;</td>
			<td> <span style="font-size:12px;"> Please enter correct pincode to make sure that your party location is properly displayed in the map in the invitation.</span></td>
			</tr>

			<tr>
				<td align="right">Date</td>
				<td align="left" class="rm_sel" style="padding:0px;">
					<div style="width:100px;"><?php echo $dob; ?></div>
				</td>
			</tr>

			<tr>
				<td align="right">Time</td>
				<td align="left">
					<span class="rm_sel" style="padding:0px;">
						<select name="hour" style="width:50px;">
							<?php echo $hour_option; ?>
						</select> <span>Hr</span> &nbsp;&nbsp;
						<select name="min" style="width:50px;">
							<?php echo $min_option; ?>
						</select> Min
					</span>
				</td>
			</tr>

			<tr>
				<td height="40" align="right">Can invitees see each other?</td>
				<td align="left">
					<input type="radio" name="guest_cansee_each_other" value="Y"<?php echo ($data['guest_cansee_each_other'] == 'Y') ? ' checked' : ''; ?> /> Yes
					<input type="radio" name="guest_cansee_each_other" value="N"<?php echo ($data['guest_cansee_each_other'] == 'N') ? ' checked' : ''; ?> /> No
				</td>
			</tr>

			<tr>
				<td height="40" align="right">RSVP required?</td>
				<td align="left">
					<input type="radio" name="rsvp_required" value="Y"<?php echo ($data['rsvp_required'] == 'Y') ? ' checked' : ''?> /> Yes
					<input type="radio" name="rsvp_required" value="N"<?php echo ($data['rsvp_required'] == 'N') ? ' checked' : ''?> /> No
				</td>
			</tr>

			<tr>
				<td height="40" align="right">Do you want to receive a copy?</td>
				<td align="left">
					<input type="radio" name="notify_guest_reply" value="Y"<?php echo ($data['notify_guest_reply'] == 'Y') ? ' checked' : ''?> /> Yes
					<input type="radio" name="notify_guest_reply" value="N"<?php echo ($data['notify_guest_reply'] == 'N') ? ' checked' : ''?> /> No
				</td>
			</tr>

			<tr>
				<td align="right" valign="top">Message to Guests</td>
				<td align="left"><textarea style="<?php echo $style_width_box_gen; ?>" name="message" id="message"><?php echo $data['message']; ?></textarea></td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td align="left" height="40">
					<input class="button_03" type="submit" value="save draft >>" onclick="post_frm(2);" />
					<input class="button_03" type="button" value="Preview >>" onclick="post_frm(3);" />
					<input onclick="Open('1'); window.location = '#a1';" class="button_03" type="button" value="Add Guest >>" />
				</td>
			</tr>
		</table>

		<div class="clear"></div>
		<div id="1" style="display:none;">
			<h4>Guest List</h4>
			<p>Enter email addresses separated by commas.</p>
			<div class="margin5"></div>

			<?php if (!empty($data['selected_invitees'])) { ?>
			<p><strong>Invited Guests List:-</strong></p>
			<div style="font-size:12px;"><?php echo $data['selected_invitees']; ?></div>
			<div class="margin10"></div>
			<?php } ?>

			<a href="#" onclick="get_invites_users()"><img src="<?php echo base_url()?>images/front/import_cont.png" alt="" /></a>
			<div class="margin10"></div>

			<textarea style="width:680px;" name="invites" id="invites"><?php echo $data['invites']; ?></textarea><br/>
			<div class="margin10"></div>

			<input class="button_04" type="submit" value="Send invitations >>"  onclick="post_frm(1);" />
			<a name="a1"></a>
		</div>
	</div>
</form>

<script type="text/javascript">
function clear_location() {
	//var b_id = $("#business_type_id").val();
	$('#location_name').val('');
	//if(b_id == -1)  // initially we tried to hide these only for other
	//{
		$('#street_address').val('');
		$('#zipcode').val('');
		$('#state_id').val('');
		$('#city_id').val('');
	//}
}

function get_location_details(inputString) {
	var b_id = $("#business_type_id").val();
	// b.id = -1 means 'location:other' so no need to autocomplete, user will give input manually.
	if(inputString.length == 0  || b_id == -1) {
		// Hide the suggestion box.
		$('#suggestions').hide();
	} else {
		$.post("<?php echo base_url(); ?>party/auto_complete_location_name/" + b_id + "/address", {queryString: "" + inputString + ""}, function(data){
			if(data.length > 0) {
				$('#suggestions').show();
				$('#autoSuggestionsList').html(data);
			}
			else
			{
				$('#suggestions').hide();
			}
		});
	}
}

function fill(thisValue) {
	$('#location_name').val(thisValue);
	setTimeout("$('#suggestions').hide();", 200);
	get_ajax_location_details();
}

function get_ajax_location_details() {
	var business_type_id =  $("#business_type_id").val();
	var location_name = $("#location_name").val();
	get_ajax_option_party('<?=base_url().'party/get_street_address_ajax'?>',business_type_id,location_name,'div_street_address');
	get_ajax_option_party('<?php echo base_url().'party/get_state_ajax'?>', business_type_id, location_name, 'div_state');
	get_ajax_option_party('<?php echo base_url().'party/get_city_ajax'?>', business_type_id, location_name, 'div_city');
	get_ajax_option_party('<?php echo base_url().'party/get_zipcode_ajax'?>', business_type_id, location_name, 'div_zipcode');
}

function fun_country(cat) {
	get_ajax_option_common('<?php echo base_url().'business/get_state_ajax'?>', cat, 'div_state');
	get_ajax_option_common('<?php echo base_url().'business/get_city_ajax'?>', -1, 'div_city');
}

function fun_state(cat) {
	get_ajax_option_common('<?php echo base_url().'business/get_city_ajax'?>', cat, 'div_city');
}

function post_frm(val) {
	$('#status').val(val);
	document.frm_party_edit.submit();
}

function Open(id) {
	var style = document.getElementById(id).style;
	if (style.display == "none")
		style.display = "block";
	else
		style.display = "none";
}

function get_invites_users() {
	tb_show('Select emails', base_url + '/party/address_book_ajax/?height=480&width=620');
}

var status = '<?php echo $data['status']; ?>';
if (status == '1')
	$('#1').show();
else
	$('#1').hide();
</script>