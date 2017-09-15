<table id="tbl_content_area" width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr><td height="1px"></td></tr>
	<tr>
      <td align="center" valign="middle" bgcolor="#FFFFFF" style="border:1px dotted #999999;" height="100%">
	  	 <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
		  <tr>
		  	<td style="border-right:1px dotted #999999; width:25%; background:#F3F3F3;" valign="top" align="left">
			  <?php
                    $this->load->view('admin/common/menu_cms.tpl.php');
                ?>
			</td>
            <td style="width:75%;" valign="top" align="left">
                <div class="sub_heading">
                    <table width="100%">
			            <tr>
			                <td align="left" style="padding-top:10px;">
			                    <form name="frm" action="<?=base_url().'admin/newsletter/newsletter_snapshot/'.$nid?>" method="post" enctype="multipart/form-data">
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
			<td class="text1" height="30" bgcolor="#cccccc" align="left" style="color:#000000;">Newsletter Snapshot
			</td>
		</tr>
		<tr>
			<td  colspan="2"align="left" valign="top">
				<table width="100%" cellpadding="0"  cellspacing="0">
					<tr>
						<td align="left" height="25" class="text1" style="padding-left:65px;color:#000000;"><strong>Newsletter and sender</strong></td>
					</tr>
					<tr  >
						<td align="right" class="text1">
							<table border="0" cellpadding="0" cellspacing="0" width="90%" align="center">
								<tr align="left"  bgcolor="#cccccc">
									<td width="35%" align="left" class="text1" style="padding-left:10px;color:#000000;">Newsletter Name </td>
									<td width="65%" height="25" valign="middle" class="text1"><?=$newsletter_session["txtcampaign_name"]?></td>
								</tr>
								<tr align="left"  bgcolor="#cccccc">
									<td align="left" class="text1" style="padding-left:10px;color:#000000;">Subject</td>
									<td height="25" valign="middle" class="text1"><?=$newsletter_session["txtSubject"]?></td>
								</tr>
								<tr align="left"  bgcolor="#cccccc">
									<td align="left" class="text1" style="padding-left:10px;color:#000000;">From Name </td>
									<td height="25" valign="middle" class="text1"><?=$newsletter_session["txtcampaign_fromname"]?></td>
								</tr>
								<tr align="left"  bgcolor="#cccccc">
									<td align="left" class="text1" style="padding-left:10px;color:#000000;">From Email </td>
									<td height="25" valign="middle" class="text1"><?=$newsletter_session["txtEmail"]?></td>
								</tr>
								<tr align="left"  bgcolor="#cccccc">
									<td align="left" class="text1" style="padding-left:10px;color:#000000;">Reply to Address </td>
									<td height="25" valign="middle" class="text1"><?=$newsletter_session["txtreplyEmail"]?></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
				<td align="left" height="25" class="text1" style="padding-left:65px;color:#000000;"><strong>Content</strong></td>
					</tr>
					<tr>
						<td align="left" class="text1">
							<table border="0" cellpadding="0" cellspacing="0" width="90%" align="center">
								<tr align="left"  bgcolor="#cccccc">
									<td width="35%" align="left" class="text1" style="padding-left:10px;color:#000000;">Text (<a href="javascript:MM_openWindow('<?=base_url()?>admin/newsletter/newletter_campaign_preview','newsletter','scrollbars=yes,width=770,height=700,resizable=yes,toolbar=no');" class="text2">View a preview</a>) </td>
									<td width="65%" height="40" valign="middle">&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td align="left" class="text1" style="padding-left:65px;color:#000000;" height="25"><strong>Recipients</strong></td>
					</tr>
					<tr >
						<td align="left" class="text1">
							<table border="0" cellpadding="0" cellspacing="0" width="90%" align="center">
								<tr align="left"  bgcolor="#cccccc">
									<td width="35%" align="left" class="text1" style="padding-left:10px;color:#000000;">Total recipient </td>
									<td width="65%" height="45" valign="middle" class="text1"><?=$totalmember?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr align="left">
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td height="100%" align="center" valign="top">&nbsp;</td>
					</tr>
					<tr>
						<td  height="30" align="center" valign="middle">
							<table width="100%" border="0" cellspacing="20" cellpadding="0">
								<tr>
									<td align="right">&nbsp;</td>
									<td align="left" width="50%">
										<input type="submit" name="Btnnext" value="Next" class="button" /></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
	  </tr>
	</table>
			                    <script type="text/javascript">
			                        <!--
			                       function MM_openWindow(theURL,winName,features)
			                        {
			                            features=features + ",left=" + (screen.width - 540)/2;
			                          features=features + ",top=" + (screen.height - 480)/2;
			                          window.open(theURL,winName,features);
			                        }
			                         //-->
			                     </script>
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