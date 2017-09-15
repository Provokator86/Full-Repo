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
										<form name="frm" action="<?=base_url().'admin/newsletter/newsletter_create3a/'.$nid?>" method="post" enctype="multipart/form-data">
											<table width="100%" cellpadding="3" cellspacing="0" border="0">
												<tr>
													<td align="center" style="padding-bottom:20px;">
														Newsletter
													</td>
												</tr>
											</table>
											<input type="hidden" name="opeid" value="<?=$nid?>">
											<input type="hidden" name="mode" value="save">
											<table width="90%" border="1" cellpadding="0" cellspacing="0" bordercolor="#666666" style="border-collapse :collapse" align="center">
												<tr>
													<td class="text1" height="30" bgcolor="#cccccc" align="left" style="color:#000000;">
														Manage Newsletter
													</td>
													<td align="right" class="text1"></td>
												</tr>
												<tr>
													<td colspan="2"align="left" valign="top">
														<table width="100%" cellpadding="0" cellspacing="0">
															<tr>
																<td colspan="2" align="left" class="text1" style="color:#000000;"><strong>Type in or copy and paste the text for your email below.</strong></td>
															</tr>
															<tr>
																<td width="10%" align="right">&nbsp;</td>
																<td width="90%" class="text1">
																	<textarea name="emailbody_plain" rows="14" cols="85" class="textbox2">
																		<div id="global" style="margin: 0pt auto; width: 700px;">
																			<div class="heading" style="margin-bottom:4px; margin-top:10px;">
																				<img src="<?php echo base_url(); ?>images/front/header.png" alt="" />
																			</div>
																			<div class="content" style=" background:url(http://www.urbanzing.com/images/front/logo_water_mark.png) center no-repeat; margin-top:10px; min-height:600px; border:1px solid #fa8e23; padding:10px;">
																				<h2> Write here</h2>
																			</div>
																		</div>
																		<?php /*?><?=(isset($bd))?$bd:""?><?=(isset($newsletter_session['emailbody_plain']))?$newsletter_session['emailbody_plain']:""?><?php */?>
																	</textarea>
																</td>
															</tr>
															<tr align="left">
																<td colspan="2">&nbsp;</td>
															</tr>
															<tr>
																<td colspan="2" height="100%" align="center" valign="top">&nbsp;</td>
															</tr>
															<tr>
																<td height="30" colspan="2" align="center" valign="middle">
																	<table width="100%" border="0" cellspacing="20" cellpadding="0">
																		<tr>
																			<td align="right"><input type="submit" name="prev" value="Previous" class="button"/></td>
																			<td align="left"><input type="submit" name="Btnnext" value="Next" class="button"/></td>
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