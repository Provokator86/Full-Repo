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
                <?
                $this->load->view('admin/common/message_page.tpl.php');
                ?>
                        <table width="90%" border="0" cellspacing="0" cellpadding="0" style="margin-top:40px;">
                            <tr>
                                <td width="110" class="td_tab_main" align="center" valign="middle"><?=$table_title?></td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                        <table width="90%" border="0" cellspacing="0" cellpadding="10" style="border:1px solid #999999;">
                            <tr>
                                <td align="center" valign="middle">
                                    <form id="frm_admin_site_settings" name="frm_admin_site_settings" method="post" action="<?=base_url().'admin/site_settings/update_site_settings'?>" onsubmit="return change_admin_id_validate()">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="7">
                                            <tr>
                                                <td width="140" align="right" valign="middle" class="field_title"><strong>Max image file size : </strong></td>
                                                <td align="left" valign="middle"><input id="max_image_file_size" name="max_image_file_size" type="text" class="textfield" style="width:375px;" value="<?=(isset($site_settings[0]['max_image_file_size']))?$site_settings[0]['max_image_file_size']:''?>" />&nbsp;&nbsp;<span style="color:#8B0000;">In Kb</span></td>
                                            </tr>
                                            <tr>
                                                <td width="140" align="right" valign="middle" class="field_title"><strong>Site name : </strong></td>
                                                <td align="left" valign="middle"><input id="site_name" name="site_name" type="text" class="textfield" style="width:375px;" value="<?=(isset($site_settings[0]['site_name']))?$site_settings[0]['site_name']:''?>" /></td>
                                            </tr>
                                            <tr>
                                                <td width="140" align="right" valign="middle" class="field_title"><strong>Site moto : </strong></td>
                                                <td align="left" valign="middle"><input id="site_moto" name="site_moto" type="text" class="textfield" style="width:375px;" value="<?=(isset($site_settings[0]['site_moto']))?$site_settings[0]['site_moto']:''?>" /></td>
                                            </tr>
                                            <tr>
                                                <td width="140" align="right" valign="middle" class="field_title"><strong>Admin email : </strong></td>
                                                <td align="left" valign="middle"><input id="admin_email" name="admin_email" type="text" class="textfield" style="width:375px;" value="<?=(isset($site_settings[0]['admin_email']))?$site_settings[0]['admin_email']:''?>" /></td>
                                            </tr>
                                            <tr>
                                                <td width="140" align="right" valign="middle" class="field_title"><strong>Paypal email : </strong></td>
                                                <td align="left" valign="middle"><input id="paypal_email" name="paypal_email" type="text" class="textfield" style="width:375px;" value="<?=(isset($site_settings[0]['paypal_email']))?$site_settings[0]['paypal_email']:''?>" /></td>
                                            </tr>
                                            <tr>
                                              <td align="right" valign="middle" class="field_title"><strong>Google API key: </strong></td>
                                              <td align="left" valign="middle"><input id="google_api_key" name="google_api_key" type="text" class="textfield" style="width:375px;" value="<?=(isset($site_settings[0]['google_api_key']))?$site_settings[0]['google_api_key']:''?>" /></td>
                                            </tr>
                                            <!--<tr>
                                                <td width="140" align="right" valign="middle" class="field_title"><strong>Paypal Currency : </strong></td>
                                                <td align="left" valign="middle">
                                                    <select id="paypal_currency" name="paypal_currency">
                                                        <?=$paypal_currency?>
                                                    </select>                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="140" align="right" valign="middle" class="field_title"><strong>Default language : </strong></td>
                                                <td align="left" valign="middle">
                                                    <select id="default_language" name="default_language">
                                                        <?=$default_language_option?>
                                                    </select>                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="140" align="right" valign="middle" class="field_title"><strong>Admin page limit : </strong></td>
                                                <td align="left" valign="middle"><input id="admin_page_limit" name="admin_page_limit" type="text" class="textfield" style="width:375px;" value="<?=(isset($site_settings[0]['admin_page_limit']))?$site_settings[0]['admin_page_limit']:''?>" /></td>
                                            </tr>
                                            <tr>
                                                <td width="140" align="right" valign="top" class="field_title"><strong>Default Currency : </strong></td>
                                                <td align="left" valign="middle">
                                                    <select id="default_currency" name="default_currency">
                                                        <?=$default_currency_option ?>
                                                    </select>                                                </td>
                                            </tr>
                                             <tr>
                                                <td width="140" align="right" valign="top" class="field_title"><strong>Registration charge : </strong></td>
                                                <td align="left" valign="middle">
                                                    <input id="registration_charge" name="registration_charge" type="text" class="textfield" style="width:375px;" value="<?=(isset($site_settings[0]['registration_charge']))?$site_settings[0]['registration_charge']:''?>" />
                                                    <br/><span style="color:#8B0000;">This amount will be equal to the prepaid voucher</span>                                                </td>
                                            </tr>
                                             <tr>
                                                <td width="140" align="right" valign="top" class="field_title"><strong>Conversion rate : </strong></td>
                                                <td align="left" valign="middle">
                                                    <input id="conversion_rate" name="conversion_rate" type="text" class="textfield" style="width:375px;" value="<?=(isset($site_settings[0]['conversion_rate']))?$site_settings[0]['conversion_rate']:''?>" />
                                                    <br/><span style="color:#8B0000;">This amount will be multiply with the actual amount</span>                                                </td>
                                            </tr>
                                             <tr>
                                                <td width="140" align="right" valign="top" class="field_title"><strong>Paypal charge : </strong></td>
                                                <td align="left" valign="middle">
                                                    <input id="paypal_charge" name="paypal_charge" type="text" class="textfield" style="width:375px;" value="<?=(isset($site_settings[0]['paypal_charge']))?$site_settings[0]['paypal_charge']:''?>" />
                                                    <br/><span style="color:#8B0000;">This amount will be added with the actual amount at the time of paypal payment</span>                                                </td>
                                            </tr>-->
                                            <tr>
                                                <td width="140" align="right" valign="middle" class="field_title"><strong>Mail from name : </strong></td>
                                                <td align="left" valign="middle"><input id="mail_from_name" name="mail_from_name" type="text" class="textfield" style="width:375px;" value="<?=(isset($site_settings[0]['mail_from_name']))?$site_settings[0]['mail_from_name']:''?>" /></td>
                                            </tr>
                                            <tr>
                                                <td width="140" align="right" valign="middle" class="field_title"><strong>Mail from email : </strong></td>
                                                <td align="left" valign="middle"><input id="mail_from_email" name="mail_from_email" type="text" class="textfield" style="width:375px;" value="<?=(isset($site_settings[0]['mail_from_email']))?$site_settings[0]['mail_from_email']:''?>" /></td>
                                            </tr>
                                            <tr>
                                                <td width="140" align="right" valign="middle" class="field_title"><strong>Mail replay name : </strong></td>
                                                <td align="left" valign="middle"><input id="mail_replay_name" name="mail_replay_name" type="text" class="textfield" style="width:375px;" value="<?=(isset($site_settings[0]['mail_replay_name']))?$site_settings[0]['mail_replay_name']:''?>" /></td>
                                            </tr>
                                            <tr>
                                                <td width="140" align="right" valign="middle" class="field_title"><strong>Mail replay email : </strong></td>
                                                <td align="left" valign="middle"><input id="mail_replay_email" name="mail_replay_email" type="text" class="textfield" style="width:375px;" value="<?=(isset($site_settings[0]['mail_replay_email']))?$site_settings[0]['mail_replay_email']:''?>" /></td>
                                            </tr>
                                            <tr>
                                                <td width="140" align="right" valign="top" class="field_title"><strong>Mail Protocol : </strong></td>
                                                <td align="left" valign="middle">
                                                    <select id="mail_protocol" name="mail_protocol">
                                                        <?=$mail_protocol_option ?>
                                                    </select>                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="140" align="right" valign="middle" class="field_title"><strong>SMTP Host : </strong></td>
                                                <td align="left" valign="middle"><input id="smtp_host" name="smtp_host" type="text" class="textfield" style="width:375px;" value="<?=(isset($site_settings[0]['smtp_host']))?$site_settings[0]['smtp_host']:''?>" /></td>
                                            </tr>
                                            <tr>
                                                <td width="140" align="right" valign="middle" class="field_title"><strong>SMTP User : </strong></td>
                                                <td align="left" valign="middle"><input id="smtp_user" name="smtp_user" type="text" class="textfield" style="width:375px;" value="<?=(isset($site_settings[0]['smtp_user']))?$site_settings[0]['smtp_user']:''?>" /></td>
                                            </tr>
                                            <tr>
                                                <td width="140" align="right" valign="middle" class="field_title"><strong>SMTP Password : </strong></td>
                                                <td align="left" valign="middle"><input id="smtp_pass" name="smtp_pass" type="text" class="textfield" style="width:375px;" value="<?=(isset($site_settings[0]['smtp_pass']))?$site_settings[0]['smtp_pass']:''?>" /></td>
                                            </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="7">
                                            <tr>
                                                <td width="140" align="right" valign="middle">&nbsp;</td>
                                                <td width="80" align="left" valign="middle">
                                                    <input name="change_id" type="button" class="button" value="Submit" onclick="ck_page()" /></td>
                                                <td align="left" valign="middle"></td>
                                          </tr>
                                        </table>
                            <script type="text/javascript">
                                function ck_page()
                                {
                                    var cntrlArr    = new Array('max_image_file_size');
                                    var cntrlMsg    = new Array('Max image file size should be a number','Admin page limit should be a number');
                                    if(isInt(cntrlArr,cntrlMsg)==true)
                                    {
                                        cntrlArr    = new Array('admin_email','paypal_email');
                                        cntrlMsg    = new Array('Please give a proper admin email ID','Please givea proper paypal email ID');
                                        if(validateEmail(cntrlArr,cntrlMsg)==true)
                                            document.frm_admin_site_settings.submit();
                                    }
                                }
                             </script>
						  </form>
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