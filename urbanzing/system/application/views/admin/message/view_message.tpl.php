<table id="tbl_content_area" width="100%" border="0" cellspacing="0" cellpadding="5">

	<tr><td height="1px"></td></tr>
	<tr>
      <td align="left" valign="middle" bgcolor="#FFFFFF" style="border:1px dotted #999999;" height="100%">
	  	 <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
		  <tr>
		  	<td style="border-right:1px dotted #999999; width:25%; background:#F3F3F3;" valign="top" align="left">
			   <?php $this->load->view('admin/common/menu_report.tpl.php');	?>
			</td>
			<td style="width:75%;" valign="top" align="center">
				<table width="90%" border="0" cellspacing="0" cellpadding="0" style="margin-top:40px;">
					  <tr>
						<td width="110" class="td_tab_main" align="center" valign="middle">View message</td>
						<td>&nbsp;</td>
					  </tr>
				</table>
			    <table width="90%" border="0" cellspacing="0" cellpadding="10" style="border:1px solid #999999;">
					  <tr>
						<td align="center" valign="middle">
							<table width="100%" border="0" cellspacing="0" cellpadding="7">
                                <tr>
									<td width="140" align="right" valign="middle" class="field_title">
										<strong>Sender name : </strong></td>
									<td align="left" valign="middle"><?=$message[0]['m_name']?></td>
							  	</tr>
							  	<tr>
									<td width="140" align="right" valign="middle" class="field_title">
										<strong>Sender email : </strong></td>
									<td align="left" valign="middle"><?=$message[0]['m_email']?></td>
							  	</tr>
							  	<tr>
									<td width="140" align="right" valign="middle" class="field_title">
										<strong>Message date : </strong></td>
									<td align="left" valign="middle"><?=date('d-m-Y',$message[0]['m_date'])?></td>
							  	</tr>
							  	<tr>
									<td width="140" align="right" valign="middle" class="field_title">
										<strong>Message type : </strong></td>
									<td align="left" valign="middle"><?=ucfirst(str_replace('_',' ',$message[0]['m_item_type']))?></td>
							  	</tr>
							  	<tr>
									<td width="140" align="right" valign="top" class="field_title">
										<strong>Message body : </strong></td>
									<td align="left" valign="middle"><?=stripslashes($message[0]['m_message'])?></td>
							  	</tr>
							  </table>
							<table width="100%" border="0" cellspacing="0" cellpadding="7">
							  <tr>
								<td width="140" align="right" valign="middle">&nbsp;</td>
								<td width="80" align="left" valign="middle" colspan="2">
                                    <input name="change_id" type="button" class="button" value="Reply" onclick="window.location.href='<?=base_url().'admin/message/compose/'.$message[0]['m_id']?>';" />
                                    <input name="reset1" type="button" class="button" value="Delete" onclick="window.location.href='<?=base_url().'admin/message/delete/'.$message[0]['m_id']?>';" />
                                    <input name="reset1" type="button" class="button" value="Back" onclick="window.location.href='<?=$redirect_url?>';" />
                                </td>
                                
							  </tr>
							</table>
									</td>
					  </tr>
					</table>
			</td>
		  </tr>
		 </table>
	  </td>
    </tr>
	<tr><td height="1px;"></td></tr>
  </table>