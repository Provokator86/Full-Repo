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
                            <form id="frm_admin_price_range" name="frm_admin_price_range" method="post" action="<?=base_url().'admin/price_range/update_price_range'?>">
							<table width="100%" border="0" cellspacing="0" cellpadding="7">
                            <tr>
                              <td width="140" align="right" valign="middle" class="field_title"><span style="color:#8B0000;">*</span>&nbsp;<strong>Price From  : </strong></td>
                              <td align="left" valign="middle">
							  <input id="price_from" name="price_from" type="text" class="textfield" style="width:200px;" value="<?=$price_range[0]['price_from']?>"  onKeyPress="return isNumberKey(event)"/></td>
                            </tr>
                            <tr>
                              <td align="right" valign="middle" class="field_title"><span style="color:#8B0000;">*</span>&nbsp;<strong>Price To  :</strong></td>
                              <td align="left" valign="middle"><input id="price_to" name="price_to" type="text" class="textfield" style="width:200px;" value="<?=$price_range[0]['price_to']?>" onKeyPress="return isNumberKey(event)"/></td>
                            </tr>
                            <tr>
                              <td align="right" valign="middle" class="field_title"><span style="color:#8B0000;">*</span>&nbsp;<strong>Country  :</strong></td>
                              <td align="left" valign="middle">
							  <select name="country_id" id="country_id">
							  <?=$country?>
							  </select></td>
                            </tr>
							  <tr>
							    <td align="right" valign="middle" class="field_title"><strong>Status :</strong></td>
							    <td align="left" valign="middle">
								<input type="radio" name="status" id="status" value="1" <?=($price_range[0]['status']==1)?'checked':''?> />Active
								<input type="radio" name="status" id="status" value="0" <?=($price_range[0]['status']==0)?'checked':''?>/>Inactive								</td>
						      </tr>
							</table>
							<table width="100%" border="0" cellspacing="0" cellpadding="7">
							  <tr>
								<td width="140" align="right" valign="middle">&nbsp;</td>
								<td width="80" align="left" valign="middle">
									<input type="hidden" name="id" value="<?=$price_range[0]['id']?>">
                                    <input name="change_id" type="button" class="button" value="Submit" onclick="ck_page()" /></td>
                                <td align="left" valign="middle"><input name="reset1" type="reset" class="button" value="Back" onclick="window.location.href='<?=base_url().'admin/price_range'?>';" /></td>
							  </tr>
							</table>
<script type="text/javascript">

			function ck_page()
			{
				var cntrlArr    = new Array('price_from','price_to','country_id');
				var cntrlMsg    = new Array('Enter price From','Enter price To','Select country');
				if(ck_blank(cntrlArr,cntrlMsg)==true)
				{
				 	if(parseFloat($('#price_to').val()) > parseFloat($('#price_from').val()) )
				    	document.frm_admin_price_range.submit();
					else
					{
						alert('Price to value should be greater than price from');
						return false;
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