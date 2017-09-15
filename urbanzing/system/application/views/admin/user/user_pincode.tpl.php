<table id="tbl_content_area" width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr><td height="1px"></td></tr>
	<tr>
      <td align="center" valign="middle" bgcolor="#FFFFFF" style="border:1px dotted #999999;" height="100%">
	  	 <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
		  <tr>
		  	<td style="border-right:1px dotted #999999; width:25%; background:#F3F3F3;" valign="top" align="left">
			  <?php
                    $this->load->view('admin/common/menu_master.tpl.php');
                ?>
			</td>
            <td style="width:75%;" valign="top" align="left">
                <div class="sub_heading">
                    <?php
                        $this->load->view('admin/common/message_page.tpl.php');
                        if($user_pin )
                        {
                            ?>
                    <table width="100%">
                        <tr>
                            <td width="20%" align="left">User name:</td>
                            <td align="left"><?=$user_pin[0]['name']?></td>
                        </tr>
                        <tr>
                            <td width="20%" align="left">User Id:</td>
                            <td align="left"><?=$user_pin[0]['user_code']?></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left" style="padding-top: 20px;">
                                <a style="cursor:pointer;" onclick="document.getElementById('div_add_pin').style.display='block';">(+) Add new</a></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="left" >
                                <div id="div_add_pin" style="display:none;">
                                    <form id="frm_user_pin" name="frm_user_pin" method="post" action="<?=base_url().'admin/user/insert_user_pin'?>">
                                        <table width="100%">
                                            <tr>
                                                <td width="30%" align="left">Number of generated prepaid voucher:</td>
                                                <td align="left">
                                                    <select id="tot_pin" name="tot_pin">
                                                        <?
                                                        for($i=1;$i<=10;$i++)
                                                        {
                                                            ?>
                                                        <option value="<?=$i?>"><?=$i?></option>
                                                            <?
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="left" style="padding-top:10px;padding-left:50px;">
                                                    <input type="hidden" id="user_code" name="user_code" value="<?=$user_pin[0]['user_code']?>"/>
                                                    <input type="hidden" id="user_id" name="user_id" value="<?=$user_pin[0]['id']?>"/>
                                                    <input name="change_id" type="submit" class="button" value="Submit" />
                                                    <input name="change_id" type="button" class="button" value="Cancel" onclick="document.getElementById('div_add_pin').style.display='none';" />
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    </table>
                            <?
                            if(!is_null($user_pin[0]['pin_code']))
                            {
                            ?>
                    <table width="100%">
                        <tr>
                            <td align="left" style="padding-top:10px;">
                                <table width="30%" cellpadding="3" cellspacing="0" border="0">
                                    <tr>
                                        <td class="td_tab_main">
                                            List of user prepaid voucher
                                        </td>
                                    </tr>
                                </table>
                                <table width="98%" style="border: 1px solid rgb(153, 153, 153);" cellpadding="3" cellspacing="0" >
                                    <tr>
                                        <td  class="td_tab_main" align="center" style="padding-left:0px;">
                                            Prepaid voucher
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            Creation date
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            Used user Id
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;font-weight:normal;">
                                            Action
                                        </td>
                                    </tr>


                           <?
                            foreach($user_pin as $key=>$value)
                            {
                                ?>
                                    <tr>
                                        <td align="center" class="columnDataGrey"> <?=$value['pin_code']?></td>
                                        <td align="center" class="columnDataGrey"> <?=date("d-m-Y",$value['date_creation'])?></td>
                                        <td align="center" class="columnDataGrey"> <?=$value['used_code']?></td>

                                        <td align="center" class="columnDataGrey">
                                            <a href="<?=base_url().'admin/user/delete_user_pin_code/'.$value['pin_code'].'/'.$value['id']?>">
                                                <img onclick="return confirm('Are you sure want to delete this user prepaid voucher?')" border="0" style="margin:4px;" src="images/admin/icon_delete.png" title="Delete user prepaid voucher" style="cursor:pointer;" />
                                            </a>
                                        </td>
                                    </tr>
                                <?

                            }
                            ?>

                                </table>
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