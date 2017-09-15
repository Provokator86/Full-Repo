<table id="tbl_content_area" width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr><td height="1px"></td></tr>
	<tr>
      <td align="center" valign="middle" bgcolor="#FFFFFF" style="border:1px dotted #999999;" height="100%">
	  	 <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
		  <tr>
		  	<td style="border-right:1px dotted #999999; width:25%; background:#F3F3F3;" valign="top" align="left">
			  <?php
                    $this->load->view('admin/common/menu_general.tpl.php');
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
                                        <td  class="td_tab_main" align="center" style="padding-left:0px;">&nbsp;</td>
                                        <td  class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='name')?'bold':'normal'?>;" href="<?=base_url().'admin/user/index/f_name/'.(($order_name=='f_name' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Name</a>                                        </td>
                                        
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='email')?'bold':'normal'?>;" href="<?=base_url().'admin/user/index/email/'.(($order_name=='email' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Email Id</a>                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">User Type</td>
										<td class="td_tab_main" align="center" style="padding-left:0px;">User Source</td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='date_created')?'bold':'normal'?>;" href="<?=base_url().'admin/user/index/date_created/'.(($order_name=='date_created' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Date of creation</a>                                        </td>
                                        
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='restricted')?'bold':'normal'?>;" href="<?=base_url().'admin/user/index/restricted/'.(($order_name=='restricted' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Status</a>                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;font-weight:normal;">
                                            Action                                        </td>
                                    </tr>


                           <?
						   /*echo "<pre>";
						   print_r($admin_user);
						   echo "</pre>";*/
                            foreach($admin_user as $key=>$value)
                            {
                                $style  = '';
                                if($value['restricted']==1)
                                {
                                    $style  = 'color:green;';
                                    $txt     = 'Enable';
                                }
                                else
                                    $txt     = 'Disable';
                                $jsnArr = json_encode(array('id'=>$value['id'],'restricted'=>$value['restricted']));
                            ?>
                                    <tr>
                                        <td align="center" class="columnDataGrey"><img width="20" alt="" src="images/admin/<?=($value['online_status']==1)?'user_online.png':'user_offline.png'?>"/> </td>
                                        <td align="center" class="columnDataGrey"> <?=$value['f_name']?></td>
                                        
                                        <td align="center" class="columnDataGrey"> <?=$value['email']?></td>
                                        <td align="center" class="columnDataGrey"><?=$user_type[$value['user_type_id']]?></td>
										<td align="center" class="columnDataGrey"><?=$value['source']?></td>
                                        <td align="center" class="columnDataGrey"> <?=date("d-m-Y",$value['date_created'])?></td>
                                        
                                        <td align="center" class="columnDataGrey">
                                            <div id="status<?=$value['id']?>">
                                                <a onclick='call_ajax_status_change("<?=base_url().'admin/user/ajax_change_status'?>",<?=$jsnArr?>,"<?='status'.$value['id']?>");'  style="cursor:pointer; <?=$style?>"><?=$txt?></a>                                            </div>                                        </td>
                                        

                                        <td align="center" class="columnDataGrey">
                                            <!--<a href="<?=base_url().'admin/user/user_pin_code_detail/'.$value['id']?>">
                                                <img border="0" style="margin:4px;" src="images/admin/icon_setup.gif" title="User pincode" style="cursor:pointer;" />                                            </a>-->
                                            <a href="<?=base_url().'admin/user/edit_user/'.$value['id']?>">
                                                <img border="0" style="margin:4px;" src="images/admin/icon_edit.gif" title="Edit user" style="cursor:pointer;" />                                            </a>                                        </td>
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
						<table>
							    <tr>
									<td align="right" style="padding-right:50px;">
									   <input type="button" onclick="javascript:window.location='<?=base_url()?>admin/user/download_user_list'" value="download user list">
										
									</td>
								</tr>
							</table>
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