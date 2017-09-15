<table id="tbl_content_area" width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr><td height="1px"></td></tr>
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
													<td align="center" style="padding-bottom:20px;">
														Newsletter
													</td>
												</tr>
											</table>
											<input type="hidden" name="opeid" value="<?=$nid?>">
											<input type="hidden" name="mode" value="save">
											<input type="hidden" name="txtSubject" value="<?=$newsletter_session['txtSubject']?>">
											<input type="hidden" name="txtcampaign_name" value="<?=$newsletter_session['txtcampaign_name']?>">
											<input type="hidden" name="txtcampaign_fromname" value="<?=$newsletter_session['txtcampaign_fromname']?>">
											<input type="hidden" name="txtEmail" value="<?=$newsletter_session['txtEmail']?>">
											<input type="hidden" name="txtreplyEmail" value="<?=$newsletter_session['txtreplyEmail']?>">
											<input type="hidden" name="newsletter_image" value="<?=$newsletter_session['newsletter_image']?>">
											<table width="90%" border="1" cellpadding="0" cellspacing="0" bordercolor="#666666" style="border-collapse :collapse" align="center">
												<tr>
													<td class="border1" height="30" bgcolor="#cccccc" align="left" style="color:#000000;">
														Manage Newsletter
													</td>
												</tr>
												<tr>
													<td colspan="2"align="left" valign="top">
														<table width="100%" cellpadding="0" cellspacing="0">
															<tr>
																<td align="right" class="text1">
																	<input id="red1" name="mailtype" type="radio" value="0"<?=($newsletter_session["mailtype"] == 0) ? ' checked' : ''?> />
																</td>
																<td width="90%" class="text1" style="padding-left:20px;color:#000000;"><label for="red1"><strong>HTML and plain text</strong></label></td>
															</tr>
															<tr>
																<td align="right" class="text1">&nbsp;</td>
																<td class="text1" style="color:#000000;">
																	By providing both a HTML and plain text version, Newsletter can automatically detect what your recipient's email client supports and display the correct version. Provides detailed reporting on open rates and link clicks for those that see the HTML version.
																</td>
															</tr>
															<tr>
																<td colspan="2">&nbsp;</td>
															</tr>
															<tr>
																<td align="right" class="text1">
																	<input id="red2" name="mailtype" type="radio" value="1"<?=($newsletter_session["mailtype"] == 1) ? ' checked' : ''?> />
																</td>
																<td class="text1" style="padding-left:20px;color:#000000;"><label for="red2"><strong>Plain text only</strong></label></td>
															</tr>
															<tr>
																<td align="right" class="text1">&nbsp;</td>
																<td class="text1" style="color:#000000;">
																	Plain text ensures that your message will be viewable by all recipients and also reduces the chance of your newsletter being accidentally identified as spam. No reporting on open rates or link clicks will be available.
																</td>
															</tr>
															<tr>
																<td colspan="2">&nbsp;</td>
															</tr>
															<tr>
																<td colspan="2">&nbsp;</td>
															</tr>
															<tr>
																<td height="30" colspan="2" align="center" valign="middle">
																	<table width="100%" border="0" cellspacing="20" cellpadding="0">
																		<tr>
																			<td align="right">
																				<input type="submit" name="prev" value="Previous" class="button" />
																			</td>
																			<td align="left">
																				<input type="submit" name="Btnnext" value="Next" class="button" onclick="return RediobuttonCheck();"/>
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
	function RediobuttonCheck()
	{
		var flag=false;
		var n=document.getElementsByName("mailtype").length;
		for(var i=0;i<n;i++)
		{
			var obj=document.getElementsByName("mailtype");
			if(obj[i].checked)
			{
				flag=true;
			}
		}
		if(!flag)
		{
			alert("Please select atleast one option");
			return false;
		}
	}
	//-->
</script>