<table id="tbl_content_area" width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr><td height="1px"></td></tr>
	<tr>
      <td align="center" valign="middle" bgcolor="#FFFFFF" style="border:1px dotted #999999;" height="100%">
	  	 <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
		  <tr>
		  	<td style="border-right:1px dotted #999999; width:25%; background:#F3F3F3;" valign="top" align="left">
			  <?php
                    $this->load->view('admin/common/menu_cms.tpl.php');
                ?>
			</td>
            <td style="width:75%;" valign="top" align="left">
                <div class="sub_heading">
                    <table width="98%" height="90%" border="1" cellpadding="0" cellspacing="0" bordercolor="#666666" style="border-collapse :collapse" align="center">
				        <tr>
				            <td class="text1" height="30" bgcolor="#cccccc" align="left">Newsletter View
							</td>
							<td align="right" >
						    </td>
				        </tr>
						<tr>
				            <td  colspan="2"align="left" valign="top">
				                <table width="100%" border="0" cellspacing="0" cellpadding="0">
				          <tr>
				            <td width="7%">&nbsp;</td>
				            <td width="93%" height="200" valign="top" class="view-tbl-data2">
							<?=$body?></td>
				          </tr>
				        </table></td>
								  </tr>
				                  <tr>
				        <td height="20" align="center" bgcolor="#cccccc">
						<input type="button" class="button" onclick="window.location='<?=base_url().'admin/newsletter'?>'" value="Back" />
						</td>
				      </tr>
								</table>
                </div>
            </td>
		  </tr>
		 </table>
	  </td>
    </tr>
	<tr><td height="1px;"></td></tr>
  </table>