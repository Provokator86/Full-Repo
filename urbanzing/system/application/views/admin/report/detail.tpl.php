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
            <td style="width:100%;" valign="top" align="left">
                <div class="sub_heading">
                    <?php
                        $this->load->view('admin/common/message_page.tpl.php');
                            ?>
                    <table width="100%">
                        <tr>
                            <td align="left" style="padding-top:10px;">
                                <table width="30%" cellpadding="3" cellspacing="0" border="0">
                                    <tr>
                                        <td class="td_tab_main">
                                            User detail
                                        </td>
                                    </tr>
                                </table>
                                <?
                                if(isset($user_detail))
                                {
                                ?>
                                <table width="100%" style="border: 1px solid rgb(153, 153, 153);" cellpadding="3" cellspacing="0" >
                                    <tr>
                                        <td align="left" width="15%" style="color:#000000;font-weight: normal;">Name:</td>
                                        <td align="left" width="35%" style="color:#000000;"><b><?=$user_detail[0]['name']?></b></td>
                                        <td align="left" width="15%" style="border-left: 1px solid gray;padding-left: 5px;color:#000000;font-weight: normal;">User Id:</td>
                                        <td align="left"  style="color:#000000;"><b><?=$user_detail[0]['user_code']?></b></td>
                                    </tr>
                                    <tr>
                                        <td align="left"  style="color:#000000;font-weight: normal;">Email:</td>
                                        <td align="left"  style="color:#000000;"><b><?=$user_detail[0]['email']?></b></td>
                                        <td align="left"  style="border-left: 1px solid gray;padding-left: 5px;color:#000000;font-weight: normal;">Join date:</td>
                                        <td align="left"  style="color:#000000;"><b><?=date("d-m-Y",$user_detail[0]['join_date'])?></b></td>
                                    </tr>
                                    <tr>
                                        <td align="left"  style="color:#000000;font-weight: normal;">Total Income:</td>
                                        <td align="left"  style="color:#000000;"><b><?=$user_detail[0]['total_income']?></b></td>
                                        <td align="left"  style="border-left: 1px solid gray;padding-left: 5px;color:#000000;font-weight: normal;">&nbsp;</td>
                                        <td align="left"  style="color:#000000;"><b>&nbsp;</b></td>
                                    </tr>
                                    <tr>
                                        <td align="left"  style="color:#000000;font-weight: normal;">Total left child:</td>
                                        <td align="left"  style="color:#000000;"><b><?=$user_detail[0]['left_total']?></b></td>
                                        <td align="left"  style="border-left: 1px solid gray;padding-left: 5px;color:#000000;font-weight: normal;">Total right child</td>
                                        <td align="left"  style="color:#000000;"><b><?=$user_detail[0]['right_total']?></b></td>
                                    </tr>
                                    
                                </table>
                                <?
                                }
                                ?>
                            </td>
                    </tr>
                </table>


                    <?php
                        if($pay)
                        {
                            ?>
                    <table width="100%">
                        <tr>
                            <td align="left" style="padding-top:10px;">
                                <table width="30%" cellpadding="3" cellspacing="0" border="0">
                                    <tr>
                                        <td class="td_tab_main">
                                            User payout
                                        </td>
                                    </tr>
                                </table>
                                <table width="98%" style="border: 1px solid rgb(153, 153, 153);" cellpadding="3" cellspacing="0" >
                                    <tr>
                                        <td  class="td_tab_main" align="center" style="padding-left:0px;">
                                            Payout date
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            Payout number
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            Status
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            Payment date
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            Amount
                                        </td>
                                    </tr>
                           <?
                            foreach($pay as $key=>$value)
                            {
                                ?>
                                    <tr>
                                        <td align="center" class="columnDataGrey"> <?=date("d-m-Y",$value['payout_date'])?></td>
                                        <td align="center" class="columnDataGrey"> <?=$value['level_for']?></td>
                                        <td align="center" class="columnDataGrey"> <?=$value['user_code']?></td>
                                        <td align="center" class="columnDataGrey"> 
                                        <?
                                        if($value['status']==0)
                                        {
                                        ?>
                                            <a href="<?=base_url().'admin/report/pay/'.$user_detail[0]['user_code'].'/'.$value['id']?>">Pay</a>
                                        <?
                                        }
                                        elseif($value['status']==2)
                                        {
                                            ?>
                                            Canceled
                                            <?
                                        }
                                        else
                                        {
                                            ?>
                                            Paid
                                            <?
                                        }
                                        ?>
                                        </td>
                                        <td align="center" class="columnDataGrey"> <?=$value['pay_amount']?></td>
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