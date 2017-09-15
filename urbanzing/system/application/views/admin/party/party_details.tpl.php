<table id="tbl_content_area" width="100%" border="0" cellspacing="0" cellpadding="5">
    
	<tr><td height="1px"></td></tr>
	<tr>
      <td align="left" valign="middle" bgcolor="#FFFFFF" style="border:1px dotted #999999;" height="100%">
	  	 <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
		  <tr>
		  	<td style="border-right:1px dotted #999999; width:25%; background:#F3F3F3;" valign="top" align="left">
			   <?php $this->load->view('admin/common/menu_general.tpl.php');	?>
			</td>
			<td style="width:75%;" valign="top" align="center">
				<table width="90%" border="0" cellspacing="0" cellpadding="0" style="margin-top:40px;">
					  <tr>
						<td width="110" class="td_tab_main" align="center" valign="middle" style="padding:5px;"><?=$table_title?></td>
						<td>&nbsp;</td>
					  </tr>
				</table>
			    <table width="90%" border="0" cellspacing="0" cellpadding="10" style="border:1px solid #999999;">
					  <tr>
						<td align="center" valign="middle">
                            
							<table width="100%" border="0" cellspacing="0" cellpadding="7">
                            <tr>
                              <td width="140" align="right" valign="middle" class="field_title"><strong>Party Name  : </strong></td>
                              <td align="left" valign="middle">
                              <?=$party_details[0]['event_title']?>
                              </td>
                            </tr>
                            <tr>
                              <td width="140" align="right" valign="middle" class="field_title"><strong>Host  : </strong></td>
                              <td align="left" valign="middle">
                              <?=$party_details[0]['host_name']?>
                              </td>
                            </tr>
                            <tr>
                              <td align="right" valign="top" class="field_title"><strong>Location  : </strong></td>
                              <td align="left" valign="middle">
                              <?=($party_details[0]['street_address']!='')?$party_details[0]['street_address'].'<br />':''?>
                                            <?=$party_details[0]['location_name']?><br />
                                            <?=$party_details[0]['city']?><br />
                                            <?=$party_details[0]['state']?>, <?=$party_details[0]['india']?>  <?=$party_details[0]['zipcode']?>  
                              </td>
                            </tr>
                            <tr>
                              <td align="right" valign="middle" class="field_title">
							  <strong>When  :</strong></td>
                              <td align="left" valign="middle">
							  <?=date("l, F d, h:iA", $party_details[0]['start_date'])?>
							  </td>
                            </tr>
							  <tr>
							    <td align="right" valign="middle" class="field_title"><strong>Phone :</strong></td>
							    <td align="left" valign="middle">
								<?=$party_details[0]['phone_no']?>
                                </td>
						      </tr>
                              <tr>
							    <td align="right" valign="middle" class="field_title"></td>
							    <td align="left" valign="middle">
								<input class="button" type="button" value="Back" onclick="javascript:window.location.href='<?=base_url()?>admin/party'"/>
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