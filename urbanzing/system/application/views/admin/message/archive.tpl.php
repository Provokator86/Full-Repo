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
                        if($message)
                        {
                            ?>
                    <table width="100%">
                        <tr>
                            <td align="left" style="padding-top:10px;">
                                <table width="30%" cellpadding="3" cellspacing="0" border="0">
                                    <tr>
                                        <td class="td_tab_main">
                                            Archive message
                                        </td>
                                    </tr>
                                </table>
                                <table width="98%" style="border: 1px solid rgb(153, 153, 153);" cellpadding="3" cellspacing="0" >
                                    <tr>
                                        <td  class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='m_name')?'bold':'normal'?>;" href="<?=base_url().'admin/message/archive/m_name/'.(($order_name=='m_name' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Name</a>
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='m_item_type')?'bold':'normal'?>;" href="<?=base_url().'admin/message/archive/m_item_type/'.(($order_name=='m_item_type' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Type</a>
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='m_date')?'bold':'normal'?>;" href="<?=base_url().'admin/message/archive/m_date/'.(($order_name=='m_date' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Date</a>
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;font-weight:normal;">
                                            Action
                                        </td>
                                    </tr>


                           <?
                            foreach($message as $key=>$value)
                            {
                                if($value['m_read_status']=='unread')
                                    $style  = 'style="font-weight: bold;color:#000000;"';
                                else
                                	$style  = 'style="font-weight: normal;color:#000000;"';
                                ?>
                                    <tr>
                                        <td align="center" class="columnDataGrey"  <?=$style?>> <a  <?=$style?> href="<?=base_url().'admin/message/view_message/'.$value['m_id']?>"><?=$value['m_name']?></a></td>
                                        <td align="center" class="columnDataGrey" <?=$style?>> <?=ucfirst(str_replace('_',' ',$value['m_item_type']))?></td>
                                        <td align="center" class="columnDataGrey" <?=$style?>> <?=date("d-m-Y",$value['m_date'])?></td>
                                        <td align="center" class="columnDataGrey" <?=$style?>>
                                            <a href="<?=base_url().'admin/message/delete/'.$value['m_id']?>">
                                                <img onclick="return confirm('Are you sure want to delete this message?')" border="0" style="margin:4px;" src="images/admin/icon_delete.png" title="Delete message" alt="" style="cursor:pointer;" />
                                            </a>
                                        </td>
                                    </tr>
                                <?

                            }
                            ?>

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