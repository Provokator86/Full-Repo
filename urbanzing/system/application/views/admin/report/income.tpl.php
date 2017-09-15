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
                    <?php
                        $this->load->view('admin/common/message_page.tpl.php');
                        $this->load->view('admin/common/admin_filter.tpl.php');
                        if($income)
                        {
                            ?>
                    <table width="100%">
                        <tr>
                            <td align="left" style="padding-top:10px;">
                                <table width="30%" cellpadding="3" cellspacing="0" border="0">
                                    <tr>
                                        <td class="td_tab_main">
                                            Income report
                                        </td>
                                    </tr>
                                </table>
                                <table width="98%" style="border: 1px solid rgb(153, 153, 153);" cellpadding="3" cellspacing="0" >
                                    <tr>
                                        <td  class="td_tab_main" align="center" style="padding-left:0px;">
                                            Name
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            Date
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            Perticuliar
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            Amount
                                        </td>
                                    </tr>
                           <?
                           $tot = 0;
                            foreach($income as $key=>$value)
                            {
                                ?>
                                    <tr>
                                        <td align="center" class="columnDataGrey"> <?=$value['username']?></td>
                                        <td align="center" class="columnDataGrey"> <?=date("d-m-Y",$value['p_date'])?></td>
                                        <td align="center" class="columnDataGrey"> <?=$value['pay_type']?></td>
                                        <td align="center" class="columnDataGrey"> <?=$value['amount']?></td>
                                    </tr>
                                <?
                                $tot    +=$value['amount'];
                            }
                            ?>
                                    <tr>
                                        <td colspan="3" align="right" style="padding-right: 10px;font-weight: bold;">Total</td>
                                        <td align="center"><?=$tot?></td>
                                    </tr>
                                </table>
                            </td>
                    </tr>
                    <tr>
                        <td align="right" style="padding-right:50px;">
                            <?=$this->pagination->create_links()?>
                        </td>
                    </tr>
                </table>
                            <?
                        }
                        else
                        {
                        ?>
                <table width="100%">
                    <tr>
                        <td align="center" style="padding-top:100px;">
                            No data found in database
                        </td>
                    </tr>
                </table>
                        <?
                        }
                    ?>
                </div>
            </td>
		  </tr>
		 </table>
	  </td>
    </tr>
	<tr><td height="1px;"></td></tr>
  </table>