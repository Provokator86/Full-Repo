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
                            <form id="frm_admin_occasion" name="frm_admin_occasion" method="post" action="<?=base_url().'admin/occasion/update_occasion'?>" enctype="multipart/form-data">
							<table width="100%" border="0" cellspacing="0" cellpadding="7">
                            <tr>
                              <td width="140" align="right" valign="middle" class="field_title"><span style="color:#8B0000;">*</span>&nbsp;<strong>Occasion  : </strong></td>
                              <td align="left" valign="middle"><input id="occasion" name="occasion" type="text" class="textfield" style="width:200px;" value="<?=$occasion[0]['occasion']?>" /></td>
                            </tr>
                            <tr>
                              <td align="right" valign="middle" class="field_title"><strong>Image</strong>:</td>
                              <td align="left" valign="middle">
							  <input type="file" name="img_name">							  </td>
                            </tr>
							<?php
							if($occasion[0]['img_name']){
							?>
                            <tr>
                              <td align="right" valign="middle" class="field_title">&nbsp;</td>
                              <td align="left" valign="middle"><img src="<?=base_url().'images/uploaded/occasion/thumb/'.$occasion[0]['img_name']?>"></td>
                            </tr>
							<?php } ?>
							  <tr>
							    <td align="right" valign="middle" class="field_title"><strong>Status :</strong></td>
							    <td align="left" valign="middle">
								
								<input type="radio" name="status" id="status" value="1" <?=($occasion[0]['status']==1)?'checked':''?> />Active
								<input type="radio" name="status" id="status" value="0" <?=($occasion[0]['status']==0)?'checked':''?>/>Inactive								</td>
						      </tr>
							</table>
							<table width="100%" border="0" cellspacing="0" cellpadding="7">
							  <tr>
								<td width="140" align="right" valign="middle">&nbsp;</td>
								<td width="80" align="left" valign="middle">
								<input type="hidden" name="id" value="<?=$occasion[0]['id']?>">
                                    <input name="change_id" type="button" class="button" value="Submit" onClick="ck_page()" /></td>
                                <td align="left" valign="middle"><input name="reset1" type="reset" class="button" value="Back" onClick="window.location.href='<?=$redirect_url?>';" /></td>
							  </tr>
							</table>
		<script type="text/javascript">
			function ck_page()
			{
				var cntrlArr    = new Array('occasion');
				var cntrlMsg    = new Array('Enter occasion');
				if(ck_blank(cntrlArr,cntrlMsg)==true)
				    document.frm_admin_occasion.submit();
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