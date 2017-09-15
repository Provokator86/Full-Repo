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
                        if($admin_user)
                        {
                            ?>
                    <table width="100%">
                        <tr>
                            <td align="left" style="padding-top:10px;">
                                <table width="30%" cellpadding="3" cellspacing="0" border="0">
                                    <tr>
                                        <td class="td_tab_main">
                                            List of user
                                        </td>
                                    </tr>
                                </table>
                                <table width="98%" style="border: 1px solid rgb(153, 153, 153);" cellpadding="3" cellspacing="0" >
                                    <tr>
                                        <td  class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='name')?'bold':'normal'?>;" href="<?=base_url().'admin/report/index/name/'.(($order_name=='name' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Name</a>
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='username')?'bold':'normal'?>;" href="<?=base_url().'admin/report/index/username/'.(($order_name=='username' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            User Id</a>
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='date')?'bold':'normal'?>;" href="<?=base_url().'admin/report/index/date/'.(($order_name=='date' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Date of creation</a>
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='level')?'bold':'normal'?>;" href="<?=base_url().'admin/report/index/level/'.(($order_name=='level' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Level</a>
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='p_id')?'bold':'normal'?>;" href="<?=base_url().'admin/report/index/p_id/'.(($order_name=='p_id' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Introducer ID</a>
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            Introducer Name
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            Total Left child
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            Total Right child
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='total_income')?'bold':'normal'?>;" href="<?=base_url().'admin/report/index/total_income/'.(($order_name=='total_income' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Total Payout</a>
                                        </td>
                                    </tr>
                           <?
                            foreach($admin_user as $key=>$value)
                            {
                                ?>
                                    <tr>
                                        <td align="center" class="columnDataGrey"> <a href="<?=base_url().'admin/report/detail/'.$value['user_code']?>"><?=$value['name']?></a></td>
                                        <td align="center" class="columnDataGrey"> <?=$value['username']?></td>
                                        <td align="center" class="columnDataGrey"> <?=date("d-m-Y",$value['join_date'])?></td>
                                        <td align="center" class="columnDataGrey"> <?=$value['level']?></td>
                                        <td align="center" class="columnDataGrey"> <?=$value['p_id']?></td>
                                        <td align="center" class="columnDataGrey"> <?=$value['p_name']?></td>
                                        <td align="center" class="columnDataGrey"> <?=($value['left_total']>0)?$value['left_total']:0?></td>
                                        <td align="center" class="columnDataGrey"> <?=($value['right_total']>0)?$value['right_total']:0?></td>
                                        <td align="center" class="columnDataGrey"> <?=$value['total_income']?></td>
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