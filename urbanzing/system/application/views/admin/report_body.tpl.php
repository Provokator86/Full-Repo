<table id="tbl_content_area" width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr><td height="1px"></td></tr>
	<tr>
      <td align="center" valign="middle" bgcolor="#FFFFFF" style="border:1px dotted #999999;" height="100%">
	  	 <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
		  <tr>
		  	<td style="border-right:1px dotted #999999; width:25%; background:#F3F3F3;" valign="top" align="left">
			  <?php
                    $this->load->view('admin/common/menu_report.tpl.php');
                ?>
			</td>
            <td style="width:75%;" valign="top" align="left">
                <div class="sub_heading">
                    <img src="images/admin/icon_paging_next.gif" border="0"  />&nbsp;<a href="<?=base_url()?>admin/message">Message</a><br/>
                    <img src="images/admin/icon_paging_next.gif" border="0"  />&nbsp;<a href="<?=base_url()?>admin/report">Payout</a><br/>
                    <img src="images/admin/icon_paging_next.gif" border="0"  />&nbsp;<a href="<?=base_url()?>admin/report/inncome">Income</a><br/>
                </div>
            </td>
		  </tr>
		 </table>
	  </td>
    </tr>
	<tr><td height="1px;"></td></tr>
  </table>