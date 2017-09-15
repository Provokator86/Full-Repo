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
                                <td width="110" class="td_tab_main" align="center" valign="middle"><?=$table_title?></td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                        <table width="90%" border="0" cellspacing="0" cellpadding="10" style="border:1px solid #999999;">
                            <tr>
                                <td align="center" valign="middle">
<div class="sign_up">	
<div class="signup_left">					
<?
	$this->load->view('admin/common/message_page.tpl.php');
?>
  <form action="<?=base_url().'admin/user/insert_user'?>" method="post" name="frm_reg" id="frm_reg" enctype="multipart/form-data">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">First Name <span>*</span></td>
        <td><input id="f_name" name="f_name" type="text" value="<?=$old_values['f_name']?>" /></td>
      </tr>
       <tr>
        <td align="right">Last Name <span>*</span></td>
        <td><input id="l_name" name="l_name" type="text" value="<?=$old_values['l_name']?>" /></td>
      </tr>
       <tr>
         <td align="right">User Type <span>*</span></td>
         <td>
		 	<select name="user_type" id="user_type" style="width:290px;">
			<option value="">Select User Type</option>
			<?=$user_type_option?>
			</select>
		 </td>
       </tr>
      <tr>
        <td align="right">Screen name </td>
        <td><input id="screen_name" name="screen_name" type="text" value="<?=$old_values['screen_name']?>"/></td>
      </tr>
      <tr>
        <td align="right">Email  <span>*</span></td>
        <td><input id="email" name="email" type="text" value="<?=$old_values['email']?>"/></td>
      </tr>
      <tr>
        <td align="right">Password  <span>*</span></td>
        <td><input id="password" name="password" type="password" value="<?=$old_values['password']?>"/></td>
      </tr>
      <tr>
        <td align="right">Confirm Password  <span>*</span></td>
        <td><input id="c_password" name="c_password" type="password" value="<?=$old_values['c_password']?>"/></td>
      </tr>
      <tr>
        <td align="right">Pincode  <span>*</span></td>
        <td><input id="zip_id" name="zip_id" type="text" value="<?=$old_values['zip_id']?>"/></td>
      </tr>
      <tr>
        <td align="right" valign="top">About yourself</td>
        <td><textarea id="about_yourself" name="about_yourself"><?=$old_values['about_yourself']?></textarea></td>
      </tr>
       <tr>
        <td align="right">Photo</td>
        <td><input id="img_name" name="img_name" type="file" /></td>
      </tr>
       
      <tr>
        <td>&nbsp;</td>
        <td height="40">
            <input type="hidden" id="user_type_id" name="user_type_id" value="2"/>
            <input class="button" type="submit" value="Submit" />&nbsp;&nbsp;
            <input class="button"  type="reset" value="Back" onclick="window.location='<?=base_url()?>admin/user'" />		</td>
      </tr>
    </table>
       
    </form>
	</div>	
	</div>						
								    
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