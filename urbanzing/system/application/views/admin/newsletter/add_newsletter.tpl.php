<table id="tbl_content_area" width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td height="1px"></td>
	</tr>
	<tr>
		<td align="center" valign="middle" bgcolor="#FFFFFF" style="border:1px dotted #999999;" height="100%">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
				<tr>
					<td style="border-right:1px dotted #999999; width:25%; background:#F3F3F3;" valign="top" align="left">
						<?php $this->load->view('admin/common/menu_cms.tpl.php'); ?>
					</td>
					<td style="width:75%;" valign="top" align="left">
						<div class="sub_heading">
							<table width="100%">
								<tr>
									<td align="left" style="padding-top:10px;">
										<form name="frm" action="<?=base_url().'admin/newsletter/newsletter_create2/'.$nid?>" method="post" enctype="multipart/form-data">
											<table width="100%" cellpadding="3" cellspacing="0" border="0">
												<tr>
													<td align="center" style="padding-bottom:20px;">Newsletter</td>
												</tr>
											</table>
											<table width="90%" border="1" cellpadding="0" cellspacing="0" bordercolor="#666666" style="border-collapse :collapse" align="center">
												<tr>
													<td class="border1" height="30" bgcolor="#CCCCCC" align="left" style="color:#000000;">
														Manage Newsletter
													</td>
												</tr>
												<tr>
													<td colspan="2"align="left" valign="top" style="padding-left:10px;">
														<table width="100%" cellpadding="0" cellspacing="0">
															<tr align="left" >
																<td align="right" valign="top" class="text1" style="height:7px;"></td>
																<td style="height:7px;"></td>
															</tr>
															<tr>
																<td colspan="2" align="left" class="text1"><span style="color:#000000;" class="auto_email_heading">1. Name the newsletter</span><br />
																	<div style="text-align:left; padding-left:16px; color:#000000;">Give your newsletter an easily identifiable name. The name you choose will appear when you or clients view the reports for this newsletter.</div>
																</td>
															</tr>
															<tr align="left">
																<td height="25" colspan="2">
																	<table border="0" cellpadding="0" cellspacing="0" width="90%" align="center">
																		<tr>
																			<td width="30%" align="left" class="text2" style="padding-left:10px;color:#000000;"><strong>Newsletter Name</strong></td>
																			<td width="70%">
																				<input class="textbox" type="text" name="txtcampaign_name" value="<?=$campaign_name?>" style="width:300px;" />
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr align="left">
																<td align="right" valign="top" class="text1" style="height:7px;"></td>
																<td style="height:7px;"></td>
															</tr>
															<tr>
																<td colspan="2" align="left" class="text1">
																	<span class="auto_email_heading" style="color:#000000;">2. Enter the email subject line for this newsletter</span>
																</td>
															</tr>
															<tr align="left">
																<td height="25" colspan="2">
																	<table border="0" cellpadding="0" cellspacing="0" width="90%" align="center">
																		<tr>
																			<td width="30%" align="left" class="text2" style="padding-left:10px;color:#000000;"><strong>Subject</strong></td>
																			<td><input class="textbox" type="text" name="txtSubject" value="<?=$subject?>" style="width:300px;" /></td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr align="left">
																<td align="right" valign="top" class="text1" style="height:7px;"></td>
																<td style="height:7px;"></td>
															</tr>
															<tr>
																<td colspan="2" align="left" class="text1">
																	<span class="auto_email_heading" style="color:#000000;">3. Give the newsletter a From Name</span><br />
																	<div style="text-align:left; padding-left:16px;color:#000000;"> This is what will appear in the From field of your recipients email client when they receive this newsletter.</div>
																</td>
															</tr>
															<tr align="left">
																<td height="25" colspan="2">
																	<table border="0" cellpadding="0" cellspacing="0" width="90%" align="center">
																		<tr>
																			<td width="30%" align="left" class="text2" style="padding-left:10px;color:#000000;"><strong>From Name</strong></td>
																			<td ><input class="textbox" type="text" name="txtcampaign_fromname" value="<?=$from_name?>" style="width:300px;" /></td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr align="left">
																<td align="right" valign="top" class="text1" style="height:7px;"></td>
																<td style="height:7px;"></td>
															</tr>
															<tr>
																<td colspan="2" align="left" class="text1"><span class="auto_email_heading" style="color:#000000;">4. Give the newsletter a From Email address</span><br />
																	<div style="text-align:left; padding-left:16px;color:#000000;"> This is the email address your newsletter will come from.</div></td>
															</tr>
															<tr align="left">
																<td height="25" colspan="2">
																	<table border="0" cellpadding="0" cellspacing="0" width="90%" align="center">
																		<tr>
																			<td width="30%" align="left" class="text2" style="padding-left:10px;color:#000000;"><strong>Email</strong></td>
																			<td>
																				<input class="textbox" readonly type="text" name="txtEmail" value="<?=$email?>" style="width:300px;"/>
																				<input type="hidden" name="txtreplyEmail" value="<?=$replies_email?>" />
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr align="left">
																<td align="right" valign="top" class="text1" style="height:7px;"></td>
																<td style="height:7px;"></td>
															</tr>
															<tr align="left">
																<td colspan="2">&nbsp;</td>
															</tr>
															<tr>
																<td height="30" colspan="2" align="center" valign="middle">
																	<table width="100%" border="0" cellspacing="20" cellpadding="0">
																		<tr>
																			<td align="right" width="50%">
																				&nbsp;</td>
																			<td align="left">
																				<input type="submit" name="next" value="Next" class="button" onclick="return validation();"/>
																				<input type="hidden" name="opeid" value="<?=$nid?>">
																				<input type="hidden" name="mode" value="save">
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</form>
									</td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td height="1px;"></td></tr>
</table>
<script type="text/javascript">
	<!--
	function validation()
	{
		if(document.frm.txtcampaign_name.value=="")
		{
			alert("Please enter the newsletter name!");
			return false;
		}
		else if(document.frm.txtSubject.value=="")
		{
			alert("Please enter the subject of the newsletter!");
			return false;
		}
		else if(document.frm.txtcampaign_fromname.value=="")
		{
			alert("Please enter the From Name of the newsletter!");
			return false;
		}
		else if(document.frm.txtEmail.value=="")
		{
			alert("Please enter the From Email address of the newsletter!");
			return false;
		}
		else if (document.frm.txtEmail.value!="" && checkMessenger(document.frm.txtEmail.value)==false){
			document.frm.txtEmail.focus();
			return false;
		}
		return true;
	}

	function checkMessenger(themail)
	{
		var tomatch = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!tomatch.test(themail))
		{
			window.alert('Invalid email address');
			return false;
		}
		return true;
	}
	//-->
</script>