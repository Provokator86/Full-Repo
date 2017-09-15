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
				<?php $this->load->view('admin/common/message_page.tpl.php');?>
				<table width="90%" border="0" cellspacing="0" cellpadding="0" style="margin-top:40px;">
					  <tr>
						<td width="110" class="td_tab_main" align="center" valign="middle"><?=$table_title?></td>
						<td>&nbsp;</td>
					  </tr>
				</table>
			    <table width="90%" border="0" cellspacing="0" cellpadding="10" style="border:1px solid #999999;">
					  <tr>
						<td align="center" valign="middle">
                            <form id="frm_admin_user" name="frm_admin_user" method="post" action="" onsubmit="return ck_page()">
							<table width="100%" border="0" cellspacing="0" cellpadding="7">
							  <tr>
								<td width="140" align="right" valign="middle" class="field_title"><span style="color:#8B0000;">*</span>&nbsp;<strong>Old Password : </strong></td>
								<td align="left" valign="middle"><input id="old_password" name="old_password" type="password" class="textfield" style="width:200px;" value="" /></td>
							  </tr>
							  <tr>
								<td width="140" align="right" valign="middle" class="field_title"><span style="color:#8B0000;">*</span>&nbsp;<strong>New Password : </strong></td>
								<td align="left" valign="middle"><input id="password" name="password" type="password" class="textfield" style="width:200px;" value="" /></td>
							  </tr>
							  <tr>
								<td width="140" align="right" valign="middle" class="field_title"><span style="color:#8B0000;">*</span>&nbsp;<strong>Confirm Password : </strong></td>
								<td align="left" valign="middle"><input id="cpassword" name="cpassword" type="password" class="textfield" style="width:200px;" value="" /></td>
							  </tr>
							</table>
							<table width="100%" border="0" cellspacing="0" cellpadding="7">
							  <tr>
								<td width="140" align="right" valign="middle">&nbsp;</td>
								<td width="80" align="left" valign="middle">
									<input type="hidden" name="submit_button" value="1" />
                                    <input name="bttn" id="bttn" type="submit" class="button" value="Submit" /></td>
                                <td align="left" valign="middle"><input name="reset1" type="reset" class="button" value="Back" onclick="window.location.href='<?=base_url().'admin/admin_user'?>';" /></td>
							  </tr>
							</table>
                            <script type="text/javascript">
                                function ck_page()
                                {
                                    var cntrlArr    = new Array('old_password','password','cpassword');
                                    var cntrlMsg    = new Array('Please give the admin old password','Please give the admin new password','Please rewrite admin new password');
                                    if(ck_blank(cntrlArr,cntrlMsg)==true)
                                    {
                                    	cntrlArr    = new Array('password','cpassword');
                                        cntrlMsg    = new Array('Two new password does not match');
                                        if(compareValue(cntrlArr,cntrlMsg)==true)
                                        	return true;
                                    }
                                    return false;
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