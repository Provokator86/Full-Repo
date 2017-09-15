<table id="tbl_content_area" width="100%" border="0" cellspacing="0" cellpadding="5">
    
	<tr><td height="1px"></td></tr>
	<tr>
      <td align="left" valign="middle" bgcolor="#FFFFFF" style="border:1px dotted #999999;" height="100%">
	  	 <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
		  <tr>
		  	<td style="border-right:1px dotted #999999; width:25%; background:#F3F3F3;" valign="top" align="left">
			   <?php $this->load->view('admin/common/menu_master.tpl.php');	?>
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
                            <form id="frm_admin_occupation" name="frm_admin_occupation" method="post" action="<?=base_url().'admin/occupation/insert_occupation'?>">
							<table width="100%" border="0" cellspacing="0" cellpadding="7">
                            <tr>
                              <td width="140" align="right" valign="middle" class="field_title"><span style="color:#8B0000;">*</span>&nbsp;<strong>Occupation  : </strong></td>
                              <td align="left" valign="middle"><input id="occupation" name="occupation" type="text" class="textfield" style="width:200px;" value="" /></td>
                            </tr>
							  <tr>
							    <td align="right" valign="middle" class="field_title"><strong>Status :</strong></td>
							    <td align="left" valign="middle">
								<input type="radio" name="status" id="status" value="1" checked="checked" />Active
								<input type="radio" name="status" id="status" value="0" />Inactive								</td>
						      </tr>
							</table>
							<table width="100%" border="0" cellspacing="0" cellpadding="7">
							  <tr>
								<td width="140" align="right" valign="middle">&nbsp;</td>
								<td width="80" align="left" valign="middle">
                                    <input name="change_id" type="button" class="button" value="Submit" onclick="ck_page()" /></td>
                                <td align="left" valign="middle"><input name="reset1" type="reset" class="button" value="Back" onclick="window.location.href='<?=base_url().'admin/occupation'?>';" /></td>
							  </tr>
							</table>
		<script type="text/javascript">
			function ck_page()
			{
				var cntrlArr    = new Array('occupation');
				var cntrlMsg    = new Array('Enter occupation');
				if(ck_blank(cntrlArr,cntrlMsg)==true)
				    document.frm_admin_occupation.submit();
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