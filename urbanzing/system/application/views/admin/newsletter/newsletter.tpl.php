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
                <div class="sub_heading">
                    <?php
                        $this->load->view('admin/common/message_page.tpl.php');
                        $this->load->view('admin/common/admin_filter.tpl.php');
                        if($newsletter)
                        {
                            ?>
                    <table width="100%">
                        <tr>
                            <td align="left" style="padding-top:10px;">
                                <table width="30%" cellpadding="3" cellspacing="0" border="0">
                                    <tr>
                                        <td class="td_tab_main">
                                            List of newsletter
                                        </td>
                                    </tr>
                                </table>
                                <table width="98%" style="border: 1px solid rgb(153, 153, 153);" cellpadding="3" cellspacing="0" >
                                    <tr>
                                        <td  class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='campaign_name')?'bold':'normal'?>;" href="<?=base_url().'admin/newsletter/index/campaign_name/'.(($order_name=='campaign_name' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Name</a>
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='add_date')?'bold':'normal'?>;" href="<?=base_url().'admin/newsletter/index/add_date/'.(($order_name=='add_date' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Creation Date</a>
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='subject')?'bold':'normal'?>;" href="<?=base_url().'admin/newsletter/index/subject/'.(($order_name=='subject' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Subject</a>
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='status')?'bold':'normal'?>;" href="<?=base_url().'admin/newsletter/index/status/'.(($order_name=='status' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Status</a>
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;font-weight:normal;">
                                            Action
                                        </td>
                                    </tr>


                           <?
                            foreach($newsletter as $key=>$value)
                            {
                           ?>
                                    <tr>
                                        <td align="center" class="columnDataGrey"> <?=$value['campaign_name']?></td>
                                        <td align="center" class="columnDataGrey"> <?=date("d-m-Y",$value['add_date'])?></td>
                                        <td align="center" class="columnDataGrey"><?=$value['subject']?></td>
                                        <td align="center" class="columnDataGrey">  <?=($value["status"]==0)?"Opened":"Sent"; ?></td>
                                        <td align="center" class="columnDataGrey">
                           	<?
        						if($value["status"]==0)
        						{
							?>
                                    		<a href="<?=base_url().'admin/newsletter/add_newsletter/'.$value["id"]?>" class="text2">Edit</a>&nbsp;|&nbsp;
							<?
        						}
        						else
        						{
							?>
                                    		<a href="<?=base_url().'admin/newsletter/resend_newsletter/'.$value["id"]?>" class="text2">Resend</a>&nbsp;|&nbsp;
                                    		<a href="<?=base_url().'admin/newsletter/view_pending_newsletter/'.$value["id"]?>" class="text2">View</a>&nbsp;|&nbsp;
							<?
        						}
							?>
		                                    <!--<a href="<?=base_url().'admin/newsletter/newletter_publiched/'.$value["id"]?>"  class="text2"><?=($value["published"]==0)?'Publish':'Unpublish'?></a>&nbsp;|&nbsp;-->
		                                    <a style="cursor: pointer;" onclick="delconfirm('<?=$value["id"]?>')" class="text2">Delete</a>
                                        </td>
                                    </tr>
                                <?

                            }
                            ?>
                                </table>
                                <script type="text/javascript">
								    <!--
								    
								    function delconfirm(id)
								    {
								       var no=confirm("Are you sure to delete this record?");
								        if(no)
								            location.href="<?=base_url()?>admin/newsletter/newletter_delete/" + id;
								     }
								      //-->
								</script>
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