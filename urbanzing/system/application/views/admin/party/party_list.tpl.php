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
                        if($party_list)
                        {
                    ?>
                    <table width="100%">
                        <tr>
                            <td align="left" style="padding-top:10px;">
                                <table width="30%" cellpadding="3" cellspacing="0" border="0">
                                    <tr>
                                        <td class="td_tab_main">
                                            List of Party
                                        </td>
                                    </tr>
                                </table>
                                <table width="100%" style="border: 1px solid rgb(153, 153, 153);" cellpadding="3" cellspacing="0" >
                                    <tr>
                                    <td class="td_tab_main" align="center" style="padding-left:0px;">
										 <a style="color:#FFFFFF;font-weight:<?=($order_name=='start_date')?'bold':'normal'?>;" href="<?=base_url().'admin/party/index/start_date/'.(($order_name=='start_date' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Party Date</a>										
                                            
                                            </td>
                                            
                                        <td class="td_tab_main" align="center" style="padding-left:0px;font-weight: normal;">
                                            Host Name</td>
                                        
                                        
                                        
                                        <td class="td_tab_main" align="center" style="padding-left:0px;font-weight: normal;">
                                        Party name    
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;font-weight: normal;">Location</td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;font-weight: normal;">
                                        View
                                        </td>
                                    </tr>


                           <?
                            foreach($party_list as $key=>$value)
                            {
                                $style  = '';
                                if($value['status']==1)
                                {
                                    $style  = 'color:green;';
                                    $txt     = 'Enable';
                                }
                                else
                                    $txt     = 'Disable';
                                $jsnArr = json_encode(array('id'=>$value['id'],'status'=>$value['status']));
                                ?>
                                    <tr>
                                    	<td align="center" class="columnDataGrey"><?=date('d-m-Y', $value['start_date'])?></td>
                                        <td align="center" class="columnDataGrey"><?=$value['host_name']?>
										</td>
                                       	<td align="center" class="columnDataGrey">
                                        <?=$value['event_title']?>
                                        </td>
                                        <td align="center" class="columnDataGrey"><?=$value['location_name']?></td>
                                         <td align="center" class="columnDataGrey">
                                         <a href="<?=base_url()?>admin/party/show_details/<?=$value['id']?>">Details</a>
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