<table id="tbl_content_area" width="100%" border="0" cellspacing="0" cellpadding="5">

	<tr><td height="1px"></td></tr>
	<tr>
      <td align="left" valign="middle" bgcolor="#FFFFFF" style="border:1px dotted #999999;" height="100%">
	  	 <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
		  <tr>
		  	<td style="border-right:1px dotted #999999; width:25%; background:#F3F3F3;" valign="top" align="left">
			   <?php $this->load->view('admin/common/menu_cms.tpl.php');	?>
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
                            <form id="frm_automail" name="frm_automail" method="post" action="<?=base_url().'admin/automail/update_automail'?>">
							<table width="100%" border="0" cellspacing="0" cellpadding="7">
                                <tr>
								<td width="140" align="right" valign="top" class="field_title"><span style="color:#8B0000;">*</span>&nbsp;<strong>Automail type : </strong></td>
								<td align="left" valign="middle">
                                    <select id="item_type" name="item_type" onchange="redirect_url('<?=base_url().'admin/automail/index/'?>')">
                                        <option value="">Select a type</option>
                                        <?=$automail_type_option?>
                                    </select>
                                    <br/><br/>
                                    <select id="item_field" name="item_field" onChange='return copyText("item_field");'>
                                    	<option value="">Select dynamic field for copy</option>
                                        <?=$automail_field_option?>
                                    </select>&nbsp;&nbsp;<input style='width:200px' class="textfield"  type="text" id="hdn_field" name="hdn_field" value="">
                                </td>
							  </tr>
							  <tr>
								<td width="140" align="right" valign="top" class="field_title"><span style="color:#8B0000;">*</span>&nbsp;<strong>Subject : </strong></td>
								<td align="left" valign="middle"><input id="subject" name="subject" type="text" class="textfield" style="width:500px;" value="<?=(isset($automail[0]['subject']))?$automail[0]['subject']:''?>" /></td>
							  </tr>
							  <tr>
								<td width="140" align="right" valign="top" class="field_title"><span style="color:#8B0000;">*</span>&nbsp;<strong>Mail body : </strong></td>
								<td align="left" valign="middle">
									<textarea id="description" name="description" cols="10" rows="10"><?=(isset($automail[0]['description']))?base64_decode($automail[0]['description']):''?></textarea>	
								</td>
							  </tr>
							  </table>
							<table width="100%" border="0" cellspacing="0" cellpadding="7">
							  <tr>
								<td width="140" align="right" valign="middle">&nbsp;</td>
								<td width="80" align="left" valign="middle">
									<input type="hidden" id="id" name="id" value="<?=(isset($automail[0]['id']))?$automail[0]['id']:'-1'?>">
                                    <input name="change_id" type="button" class="button" value="Submit" onclick="ck_page()" /></td>
                                <td align="left" valign="middle"></td>
							  </tr>
							</table>
                            <script type="text/javascript">
                                function ck_page()
                                {
                                    var cntrlArr    = new Array('item_type','subject');
                                    var cntrlMsg    = new Array('You have to select an Item Type','Please give mail subject');
                                    if(ck_blank(cntrlArr,cntrlMsg)==true)
                                    	document.frm_automail.submit();
                                }

                                function copyText(tag)
                                {
                                    var s = document.getElementById(tag).value;
                                    document.getElementById('hdn_field').value = s;
                                }

                                function redirect_url(url)
                                {
                                    var val	= document.getElementById('item_type').value;
                                	window.location.href=url + val;
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