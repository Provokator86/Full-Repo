<table id="tbl_content_area" width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr><td height="1px"></td></tr>
	<tr>
      <td align="center" valign="middle" bgcolor="#FFFFFF" style="border:1px dotted #999999;" height="100%">
	  	 <table width="90%" border="0" cellspacing="0" cellpadding="0" height="100%">
		  <tr>
		  	<td style="border-right:1px dotted #999999; width:25%;" valign="top" align="left">
			  <?php
                    $this->load->view('admin/common/menu_general.tpl.php');
              ?>
			</td>
			<td style="border-right:1px dotted #999999; width:25%;" valign="top" align="left">
			  <?php
                    $this->load->view('admin/common/menu_master.tpl.php');
                ?>
			</td>
			<td style="border-right:1px dotted #999999; width:25%;" valign="top" align="left">
			  <?php
                    $this->load->view('admin/common/menu_cms.tpl.php');
                ?>
			</td>
			<td style="width:25%;" valign="top" align="left">
			   <?php
                    $this->load->view('admin/common/menu_deals.tpl.php');
                ?>
               <?php
                 //   $this->load->view('admin/common/menu_report.tpl.php');
                ?>
			</td>
		  </tr>
		 </table>
	  </td>
    </tr>
	<tr><td height="1px;"></td></tr>
  </table>