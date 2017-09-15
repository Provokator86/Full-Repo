<table id="tbl_content_area" width="100%" border="0" cellspacing="0" cellpadding="5">
    <tr>
      <td align="center" valign="middle" bgcolor="#FFFFFF">
		<div class="tblContainer">
		 <table width="400" border="0" cellspacing="0" cellpadding="10" style="border:1px solid #999999;" class="tbl_contain">
          <tr>
            <td align="center" valign="middle">

			  <?php
                $this->load->view('admin/common/message_page.tpl.php');
                ?>
			  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="td_tab_main">
                <tr>
                  <td>Enter your username and password to log in</td>
                </tr>
              </table>
              <form id="frm_login" name="frm_login" method="post" action="">
                <table width="90%" border="0" cellspacing="0" cellpadding="7">
                  <tr>
                    <td width="80" align="right" valign="middle" class="field_title_login"><strong>Admin ID : </strong></td>
                    <td align="left" valign="middle">
                        <input type="text" id="uid" name="uid" class="textfield_login" style="width:200px;" tabindex="1"/>
                    </td>
                  </tr>
                  <tr>
                    <td width="80" align="right" valign="middle" class="field_title_login"><strong>Password : </strong></td>
                    <td align="left" valign="middle"><input id="pwd" name="pwd" type="password" class="textfield_login_pass" style="width:200px;" /></td>
                  </tr>
                  <tr>
                    <td width="80" align="right" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle"><input name="login" type="submit" class="button" value="Login" /><input type="hidden" name="submit_button" value="1" /></td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle"><img src="images/admin/icon_bulb.png" alt="" width="8" height="14" align="absbottom" style="margin-right:5px;" /> <a href="<?=base_url()?>admin/home/forget_password" class="generalLink">Forgot Password ?</a> </td>
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