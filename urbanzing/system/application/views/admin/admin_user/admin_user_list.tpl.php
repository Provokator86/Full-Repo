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
                                            List of admin user
                                        </td>
                                    </tr>
                                </table>
                                <table width="98%" style="border: 1px solid rgb(153, 153, 153);" cellpadding="3" cellspacing="0" >
                                    <tr>
                                        <td  class="td_tab_main" align="center" style="padding-left:0px;">&nbsp;</td>
                                        <td  class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='name')?'bold':'normal'?>;" href="<?=base_url().'admin/admin_user/index/name/'.(($order_name=='name' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Name</a>
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='username')?'bold':'normal'?>;" href="<?=base_url().'admin/admin_user/index/username/'.(($order_name=='username' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            User Id</a>
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='email')?'bold':'normal'?>;" href="<?=base_url().'admin/admin_user/index/email/'.(($order_name=='email' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Email Id</a>
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='lastlogin')?'bold':'normal'?>;" href="<?=base_url().'admin/admin_user/index/lastlogin/'.(($order_name=='lastlogin' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Last Login</a>
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='restricted')?'bold':'normal'?>;" href="<?=base_url().'admin/admin_user/index/restricted/'.(($order_name=='restricted' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Status</a>
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;font-weight:normal;">
                                            Action
                                        </td>
                                    </tr>


                           <?
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
                                        <td align="center" class="columnDataGrey"> <?=$value['name']?></td>
                                        <td align="center" class="columnDataGrey"> <?=$value['username']?></td>
                                        <td align="center" class="columnDataGrey"> <?=$value['email']?></td>
                                        <td align="center" class="columnDataGrey"> <?=($value['lastlogin']>0)?date("d-m-Y",$value['lastlogin']):'--'?></td>
                                        <td align="center" class="columnDataGrey">
                                        <?php
                                        if($value['id']==1)
                                        {
                                        ?>
                                        	<span   style="<?=$style?>">Super user</span>
                                        <?php 
                                        } 
                                        else
                                        {
                                        ?>
                                            <div id="status<?=$value['id']?>">
                                                <a onclick='call_ajax_status_change("<?=base_url().'admin/admin_user/ajax_change_status'?>",<?=$jsnArr?>,"<?='status'.$value['id']?>");'  style="cursor:pointer; <?=$style?>"><?=$txt?></a>
                                            </div>
                                        <?php
                                        } 
                                        ?>
                                        </td>

                                        <td align="center" class="columnDataGrey">
                                        	<?php
                                        if($value['id']>1)
                                        {
                                        ?>
                                        	<a href="<?=base_url().'admin/admin_user/delete_user/'.$value['id']?>">
                                                <img onclick="return confirm('Are you sure want to delete this user?')" border="0" style="margin:4px;" src="images/admin/icon_delete.png" title="Delete admin user" alt="" style="cursor:pointer;" />
                                            </a>
                                        <?php 
                                        } 
                                            ?>
                                            <a href="<?=base_url().'admin/admin_user/edit_admin_user/'.$value['id']?>">
                                                <img border="0" style="margin:4px;" src="images/admin/icon_edit.gif" title="Edit admin user" style="cursor:pointer;" />
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