
<table id="tbl_content_area" width="100%" border="0" cellspacing="0" cellpadding="5">
	<tr><td height="1px"></td></tr>
	<tr>
      <td align="center" valign="middle" bgcolor="#FFFFFF" style="border:1px dotted #999999;" height="100%">
	  	 <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
		  <tr>
		  	<td style="border-right:1px dotted #999999; width:25%; background:#F3F3F3;" valign="top" align="left">
			  
			  <?php
                    $this->load->view('admin/common/menu_cms.tpl.php');
                ?>
			</td>
            <td style="width:75%;" valign="top" align="left">
							<table>
							    <tr>
									<td align="right" style="padding-right:50px;">
									   <input type="button" onclick="javascript:window.location='<?=base_url()?>admin/archieve/save_to_archieve'" value="Save  to archieve">
										
									</td>
									<td>
							<div class="sorting_box"><span style="font-size:14px;color:#FA8818;">Sort Results By </span>:
							<select id="short_by" name="short_by" onchange="submit_short_archieve_page(this.value);">
							<option value="cr_date"<?php echo ($order_name == 'cr_date') ? ' selected' : ''?>>Date</option>
							<option value="title"<?php echo ($order_name == 'title') ? ' selected' : ''?>>Page Title</option>
							</select>
		</div>
									</td>
								</tr>
							</table>
			
			
                <div class="sub_heading">
                    <?php
                        $this->load->view('admin/common/message_page.tpl.php');
						
                        //$this->load->view('admin/common/admin_filter.tpl.php');
                        
						if($archieve_list)
                        {
                            ?>
						
                    <table width="100%">
                        <tr>
                            <td align="left" style="padding-top:10px;">
                                <table width="30%" cellpadding="3" cellspacing="0" border="0">
                                    <tr>
                                        <td class="td_tab_main">
                                            Archieve List
                                        </td>
                                    </tr>
                                </table>
                                <table width="98%" style="border: 1px solid rgb(153, 153, 153);" cellpadding="3" cellspacing="0" >
                                    <tr>
                                       <td  class="td_tab_main" align="center" style="padding-left:0px;">Date</td>  
										<td class="td_tab_main" align="center" style="padding-left:0px;">Home text title</td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">url</td>
										<td class="td_tab_main" align="center" style="padding-left:0px;">show</td>
										 <td class="td_tab_main" align="center" style="padding-left:0px;">Delete</td>
									</tr>


                           <?
						   /*echo "<pre>";
						   print_r($archieve_list);
						   echo "</pre>";*/
                            foreach($archieve_list as $key=>$value)
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
                                       <td align="center" class="columnDataGrey"> <?=date('d-m-Y',$value['cr_date'])?></td>
                                       <td align="center" class="columnDataGrey"> <?=$value['title']?></td>
                                        <td align="center" class="columnDataGrey"><?=$value['url']?></td>
										<td align="center" class="columnDataGrey"><a href="<?=base_url()?>archieve/show/<?=$value['id']?>/<?=$value['url']?>" target="_blank"> show</a></td>
										<td align="center" class="columnDataGrey"><a href="<?=base_url()?>admin/archieve/delete_archieve/<?=$value['id']?>"> delete</a></td>
									
                               
                                    </tr>
                                <?

                            }
                            ?>
                                </table>
                            </td>
                    </tr>
                    <tr>
                        <td align="right" style="padding-right:50px;">
                            <?php echo $pagination_link;?>
							
                        </td>
  
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
  	<script type="text/javascript">
			function submit_short_archieve_page(val)
			{
			 	window.location=base_url + 'admin/archieve/index/' + val;
			
			
			}
			</script>