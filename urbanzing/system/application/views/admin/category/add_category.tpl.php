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
                            <form id="frm_category" name="frm_category" method="post" action="<?=base_url().'admin/category/insert_category'?>" >
							<table width="100%" border="0" cellspacing="0" cellpadding="7">
<!--							  <tr>
								<td width="140" align="right" valign="middle" class="field_title"><span style="color:#8B0000;">*</span>&nbsp;<strong>Item type : </strong></td>
								<td align="left" valign="middle">
                                    <select id="item_type" name="item_type" style="width:200px;" onchange='call_ajax_combo_change("<?=base_url().'admin/category/ajax_change_parent_event'?>",this.value,"div_parent");'>
                                    <option value="">Select Item type</option>
                                    <?=$item_type?>
                                    </select>
                                </td>
							  </tr>-->
							  <tr>
								<td width="140" align="right" valign="middle" class="field_title">
                                    <span style="color:#8B0000;">*</span>&nbsp;<strong>Name : </strong>
                                </td>
								<td align="left" valign="middle"><input id="name" name="name" type="text" class="textfield" style="width:200px;" value="" /></td>
							  </tr>
							  <tr>
                                <td align="right"  class="field_title"> Parent:</td>
                                <td align="left" >
                                    <div id="div_parent">
                                        <select id="parent_id" name="parent_id" style="width:200px;">
                                        <option value="0">---None---</option>
										<?=$parent_id?>
                                   </select>
                                    </div>
                                </td>
                            </tr>
							</table>
							<table width="100%" border="0" cellspacing="0" cellpadding="7">
							  <tr>
								<td width="140" align="right" valign="middle">&nbsp;</td>
								<td width="80" align="left" valign="middle">
                                    <input name="change_id" type="button" class="button" value="Submit" onclick="ck_page()" /></td>
                                <td align="left" valign="middle"><input name="reset1" type="reset" class="button" value="Back" onclick="window.location.href='<?=base_url().'admin/category'?>';" /></td>
							  </tr>
							</table>
                            <script type="text/javascript">
                                function ck_page()
                                {
                                    var cntrlArr    = new Array('name');
                                    var cntrlMsg    = new Array('Please give business type name');
                                    if(ck_blank(cntrlArr,cntrlMsg)==true)
                                        document.frm_category.submit();
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