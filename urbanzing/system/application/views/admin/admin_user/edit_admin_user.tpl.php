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
                                    <form id="frm_admin_user" name="frm_admin_user" method="post" action="<?=base_url().'admin/admin_user/update_admin_user'?>" onsubmit="return change_admin_id_validate()">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="7">
                                            <tr>
                                                <td width="140" align="right" valign="middle" class="field_title"><span style="color:#8B0000;">*</span>&nbsp;<strong>User name : </strong></td>
						<td align="left" valign="middle"><input id="username" name="username" type="text" class="textfield" style="width:200px;" value="<?=$admin_user[0]['username']?>" /></td>
                                            </tr>
                                            <tr>
                                                <td width="140" align="right" valign="middle" class="field_title"><span style="color:#8B0000;">*</span>&nbsp;<strong>Name : </strong></td>
						<td align="left" valign="middle"><input id="name" name="name" type="text" class="textfield" style="width:200px;" value="<?=$admin_user[0]['name']?>" /></td>
                                            </tr>
                                            <tr>
                                                <td width="140" align="right" valign="middle" class="field_title"><span style="color:#8B0000;">*</span>&nbsp;<strong>Email : </strong></td>
						<td align="left" valign="middle"><input id="email" name="email" type="text" class="textfield" style="width:200px;" value="<?=$admin_user[0]['email']?>" /></td>
                                            </tr>
                                        </table>
					<table width="100%" border="0" cellspacing="0" cellpadding="7">
                                            <tr>
                                                <td width="140" align="right" valign="middle">&nbsp;</td>
						<td width="80" align="left" valign="middle">
                                                    <input type="hidden" id="id" name="id" value="<?=$admin_user[0]['id']?>">
                                                    <input name="change_id" type="button" class="button" value="Submit" onclick="ck_page()" /></td>
                                                <td align="left" valign="middle"><input name="reset1" type="reset" class="button" value="Back" onclick="window.location.href='<?=$redirect_url?>';" /></td>
                                            </tr>
					</table>
                            <script type="text/javascript">
                                function ck_page()
                                {
                                    var cntrlArr    = new Array('username','name','email');
                                    var cntrlMsg    = new Array('Please give the admin user ID','Please give the admin name','Please give admin email address');
                                    if(ck_blank(cntrlArr,cntrlMsg)==true)
                                    {
                                        cntrlArr    = new Array('email');
                                        cntrlMsg    = new Array('Please give a proper admin email ID');
                                        if(validateEmail(cntrlArr,cntrlMsg)==true)
                                        {
                                            var valuArr = new Object;
                                            valuArr.username=document.getElementById('username').value;
                                            valuArr.email=document.getElementById('email').value;
                                            valuArr.id=document.getElementById('id').value;
                                            var url= "<?=base_url()?>admin/admin_user/add_new_user_check";
                                            call_ajax_ck_field_duplicate_submit(url,valuArr,document.frm_admin_user);//it will submit the form if responce true
                                        }
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