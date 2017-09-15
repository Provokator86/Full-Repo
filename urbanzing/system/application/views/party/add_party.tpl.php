
<form name="frm_party_add" action="<?=base_url().'party/save_party/'?>" method="post" enctype="multipart/form-data">
<div class="plan_party">
                                   	<h1>Hello <?=$this->session->userdata('user_username')?> <div class="back_btn"><a href="<?=base_url().'business/'.$business_id?>">Back</a></div>
                                            <br><span style="scolor:#2A4B48; font-family:Helvetica 45 Light; font-size: 20px; font-weight: normal; line-height:40px;"><?=$party_page_upper_text[0]['title']?></span>
                                        </h1>
                                        
                                        <div class="margin15"></div>
                                         <?=html_entity_decode($party_page_upper_text[0]['description'])?>
                                        <div class="margin15"></div>
										  <?
   											 $this->load->view('admin/common/message_page.tpl.php');
   										  ?>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td  colspan="3"><h3>take some time and fill out the form below </h3></td>
                                          </tr>
                                          <tr><td colspan="3">&nbsp;</td></tr>
                                          <tr>
                                            <td align="right" width="100"><h3>Event Title:*</h3></td>
                                            <td><input type="text" name="event_title" id="event_title" value="<?=$old_values['event_title']?>" /></td>
                                            <td align="right"><h6>* marked fileds are mandatory</h6></td>
                                          </tr>
                                        </table>
                                        <div class="margin15"></div>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="205" align="right">Choose an Occasion <span>*</span></td>
                                            <td>
											<select name="occasion_id" id="occasion_id" style="width:370px;">
												<?=$occasion_option?>
											</select>											</td>
                                          </tr>
                                           <!--<tr>
                                            <td align="right">Choose Background Color</td>
                                            <td>
                                            		<a href="#"><img src="images/color_01.png" alt="" /></a>
                                                  <a href="#"><img src="images/color_02.png" alt="" /></a>
                                                  <a href="#"><img src="images/color_03.png" alt="" /></a>
                                                  <a href="#"><img src="images/color_04.png" alt="" /></a>
                                                  <a href="#"><img src="images/color_01.png" alt="" /></a>
                                                  <a href="#"><img src="images/color_02.png" alt="" /></a>
                                                  <a href="#"><img src="images/color_03.png" alt="" /></a>
                                                  <a href="#"><img src="images/color_04.png" alt="" /></a>
                                            </td>
                                          </tr>-->
                                          <tr>
                                            <td align="right">Upload Picture
												
											
											</td>
                                            <td><input style="width:370px;" type="file" name="img" />
											<br/>
											<span>	Only JPG files supported.
														File size should be less than <?php echo $max_file_size ?> KB.
												</span></td>
                                          </tr>
                                          <tr>
                                            <td align="right">Host Name <span>*</span></td>
                                            <td><input style="width:370px;" type="text" name="host_name" id="host_name" value="<?=$old_values['host_name']?>" /></td>
                                          </tr>
                                          <tr>
                                            <td align="right">Phone number <span>*</span></td>
                                            <td>
											<input style="width:370px;" type="text" name="phone_no" id="phone_no" value="<?=$phone_no?>"  />											</td>
                                          </tr>
                                          <tr>
                                            <td align="right">Locations <span>*</span></td>
                                            <td>
											<select name="business_type_id" id="business_type_id" style="width:370px;" onchange="clear_location()">
											<option value="">Select location</option>
											<?=$business_category?>
											<option value="-1">Others</option>
											</select></td>
                                          </tr>
                                          <tr>
                                            <td align="right">Location Name <span>*</span></td>
                                            <td>
											<input style="width:370px;" type="text" name="location_name" id="location_name"  value="<?=$location_name?>" onkeyup="get_location_details(this.value)"  />
											<div class="suggestionsBox" id="suggestions" style="display: none; position:absolute; width:368px;">
											<img src="<?=base_url()?>images/front/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
											<div class="suggestionList" id="autoSuggestionsList">
&nbsp;												</div>
											</div>											</td>
                                          </tr>
                                          <tr>
                                            <td align="right">Street Address</td>
                                            <td>
											<div id="div_street_address">
                                                <input type="text" name="street_address" id="street_address" style="width:370px;" value="<?=$street_address?>"/></div>
											</td>
                                          </tr>
                                          <tr>
										<td align="right">Country <span>*</span></td>
                                            <td>
											<select name="country_id" id="country_id"  onchange="fun_country(this.value);">
												<?=$country_option?>
											</select>											</td>
                                          </tr>
                                          <tr>
                                            <td align="right">State <span>*</span></td>
                                            <td>
											 <div id="div_state">
											<select name="state_id" id="state_id"  onchange="fun_state(this.value);">
											<option value="">Select State</option>
											<?=$state_option?>
											</select>	
											</div>											</td>
                                          </tr>
                                          <tr>
                                            <td align="right">City <span>*</span></td>
                                            <td>
											<div id="div_city">
											<select name="city_id" id="city_id">
											<option value="">Select City</option>
											<?=$city_option?>
                                            </select>
											</div>											</td>
                                          </tr>
                                          <tr>
                                            <td align="right">Pincode <span>*</span></td>
                                            <td><div id="div_zipcode">
											<input type="text" name="zipcode" id="zipcode" value="<?=$zip_code?>" style="width:370px;" />
											</div></td>
                                          </tr>
										  <tr>
											<td>&nbsp; </td>
													<td> <span style="font-size:12px;"> Please enter correct pincode to make sure 
													that your party location is properly displayed in the map in the invitation.
													</span>
											</td>
											</tr>
                                          
                                           <!--<tr>
                                            <td align="right">State</td>
                                            <td><input style="width:87px;" type="text" /> Zip Code <input style="width:87px;" type="text" /> Country <input style="width:87px;" type="text" /></td>
                                          </tr>-->
                                           <tr>
                                            <td align="right">Date</td>
                                            <td class="rm_sel" style="padding:0px;">
											<div style="width:100px;">
                                            <?=$dob?>
                                            </div>
                                            <!--&nbsp;&nbsp;&nbsp; Time &nbsp;<input style="width:160px;" type="text" /> -->
                                            </td>
                                          </tr>
                                           <tr>
                                             <td align="right">Time</td>
                                             <td><span class="rm_sel" style="padding:0px;">
                                               <select name="hour" style="width:50px;">
                                                 <?=$hour_option?>
                                               </select>  <span>Hr</span> &nbsp;&nbsp;
											   <select name="min" style="width:50px;">
											   	<?=$min_option?>
											   </select>  Min
                                             </span></td>
                                           </tr>
                                           <tr>
                                            <td height="40" align="right">Can invitees see each other?</td>
                                            <td><input type="radio" name="guest_cansee_each_other" value="Y" <?=($old_values['guest_cansee_each_other']=='Y')?'checked':''?>/> Yes 
											<input type="radio" name="guest_cansee_each_other" value="N" <?=($old_values['guest_cansee_each_other']=='N')?'checked':''?> /> No </td>
                                          </tr>
                                           <tr>
                                            <td height="40" align="right">RSVP required?</td>
                                            <td><input type="radio" name="rsvp_required" value="Y" <?=($old_values['rsvp_required']=='Y')?'checked':''?>/> Yes 
											<input type="radio" name="rsvp_required" value="N" <?=($old_values['rsvp_required']=='N')?'checked':''?> /> No </td>
                                          </tr>
                                          <tr>
                                            <td height="40" align="right">Do you want to receive a copy?</td>
                                            <td><input type="radio" name="notify_guest_reply" value="Y" <?=($old_values['notify_guest_reply']=='Y')?'checked':''?>/> Yes 
											<input type="radio" name="notify_guest_reply" value="N" <?=($old_values['notify_guest_reply']=='N')?'checked':''?> /> No </td>
                                          </tr>
                                          <tr>
                                            <td align="right" valign="top">Message to Guests</td>
                                            <td>
								<textarea style="width:370px;" name="message"><?=$old_values['message']?></textarea>											</td>
                                          </tr>
                                           <tr>
                                            <td align="right" valign="top">&nbsp;</td>
                                            <td height="40">
											<input class="button_03" type="submit" value="save draft >>" onclick="post_frm(2)" /> 
											<input class="button_03" type="button" value="Preview >>" onclick="post_frm(3)" /> <input onclick="Open('1');window.location='#a1'" class="button_03" type="button" value="Add Guest >>" /></td>
                                          </tr>
                                        </table>
                                        <div class="clear"></div>
                                        <div id="1" style="display:none">
                                        <h4>Guest List</h4>
                                        <p>Enter email addresses separated by commas.</p>
                                        <div class="margin5"></div>
                                        <a href="#" onclick="get_invites_users()"><img src="<?=base_url()?>images/front/import_cont.png" alt="" /></a> 
                                       <!-- <div class="invite_friend"><img src="images/face_book_icon.png" alt="" /> <a href="#">Invite Facebook Friends</a></div>-->
                                       	<div class="margin10"></div>
             					<textarea style="width:680px;" name="invites" id="invites"><?=$old_values['invites']?></textarea>
                                        <br />

                                        <div class="margin10"></div>
                                        <input class="button_04" type="submit" value="Send invitations >>"  onclick="post_frm(1)" />
                                        <a name="a1" id="a1"></a>
                                        </div>
  </div>
  		<input type="hidden" name="business_id" id="business_id" value="<?=$business_id?>">
  		<input type="hidden" name="status" id="status" /> 
		</form>
        <script type="text/javascript">
            function fun_country(cat)
            {
                get_ajax_option_common('<?=base_url().'business/get_state_ajax'?>',cat,'div_state');
                get_ajax_option_common('<?=base_url().'business/get_city_ajax'?>',-1,'div_city');
/*              get_ajax_option_common('<?=base_url().'business/get_zipcode_ajax'?>',-1,'div_zipcode');
                get_ajax_option_common('<?=base_url().'business/get_price_ajax'?>',cat,'div_price');
*/                
            }

            function fun_state(cat)
            {
                get_ajax_option_common('<?=base_url().'business/get_city_ajax'?>',cat,'div_city');
               // get_ajax_option_common('<?=base_url().'business/get_zipcode_ajax'?>',-1,'div_zipcode');
            }
            
/*            function fun_city(cat)
            {
                get_ajax_option_common('<?=base_url().'business/get_zipcode_ajax'?>',cat,'div_zipcode');
            }*/
			
			function post_frm(val)
			{
				$('#status').val(val);
				document.frm_party_add.submit();
			}
			
			function clear_location()
			{
				//var b_id = $("#business_type_id").val();
				$('#location_name').val('');
				//if(b_id == -1) // initially we tried to hide these only for other
				//{
					$('#street_address').val('');
					$('#zipcode').val('');
					$('#state_id').val('');
					$('#city_id').val('');
				//}
			}
			 
			function get_location_details(inputString) {
				var p = $("#location_name");
				var offset = p.offset();
				
				var b_id = $("#business_type_id").val();
				// b.id = -1 means 'location:other' so no need to autocomplete, user will give input manually.
				if(inputString.length == 0 ||  b_id == -1) {
					// Hide the suggestion box.
					$('#suggestions').hide();
				} else {
				
				$.post("<?=base_url()?>party/auto_complete_location_name/" + b_id + "/address", {queryString: "" + inputString + ""}, function(data){
						if(data.length >0) {
							$('#suggestions').show();
							$('#autoSuggestionsList').html(data);
							$('#suggestions').css('left',offset.left);
						}
						else
						{
							$('#suggestions').hide();
						}
					});
				}
			} // lookup
			
			function fill(thisValue, id) {
				$('#location_name').val(thisValue);
				setTimeout("$('#suggestions').hide();", 200);
				get_ajax_location_details();
				
			}
					 
			 
			 
			 function get_ajax_location_details()
			 {	
			 	var business_type_id =  $("#business_type_id").val();
			 	var location_name = $("#location_name").val();
				get_ajax_option_party('<?=base_url().'party/get_street_address_ajax'?>',business_type_id,location_name,'div_street_address');
				get_ajax_option_party('<?=base_url().'party/get_state_ajax'?>',business_type_id,location_name,'div_state');
                get_ajax_option_party('<?=base_url().'party/get_city_ajax'?>',business_type_id,location_name,'div_city');
                get_ajax_option_party('<?=base_url().'party/get_zipcode_ajax'?>',business_type_id,location_name,'div_zipcode');

			 }
		function Open(id)
		{		
			var style = document.getElementById(id).style;
			if(style.display == "none")
				style.display = "block";
			else
				style.display = "none";
		}
		var status = '<?=$old_values['status']?>';	
		if(status == '1')
			$('#1').show();
		else
			$('#1').hide();	
		
		function get_invites_users()
		{
		  tb_show('Select emails',base_url+'/party/address_book_ajax/?height=480&width=620');
		}	

  </script>
								   
								   