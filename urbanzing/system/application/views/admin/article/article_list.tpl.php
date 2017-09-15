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
                        if($article)
                        {
                            ?>
                    <table width="100%">
                        <tr>
                            <td align="left" style="padding-top:10px;">
                                <table width="30%" cellpadding="3" cellspacing="0" border="0">
                                    <tr>
                                        <td class="td_tab_main">
                                            List of article
                                        </td>
                                    </tr>
                                </table>
                                <table width="98%" style="border: 1px solid rgb(153, 153, 153);" cellpadding="3" cellspacing="0" >
                                    <tr>
                                        <td  class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='title')?'bold':'normal'?>;" href="<?=base_url().'admin/article/index/title/'.(($order_name=='title' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Title</a>
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='creation_dt')?'bold':'normal'?>;" href="<?=base_url().'admin/article/index/creation_dt/'.(($order_name=='creation_dt' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Date of creation</a>
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='category_id')?'bold':'normal'?>;" href="<?=base_url().'admin/article/index/category_id/'.(($order_name=='category_id' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Category</a>
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='status')?'bold':'normal'?>;" href="<?=base_url().'admin/article/index/status/'.(($order_name=='status' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Status</a>
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;font-weight: normal;">
                                            Action
                                        </td>
                                    </tr>


                           <?
                            foreach($article as $key=>$value)
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
                                        <td align="center" class="columnDataGrey"> <?=$value['title']?></td>
                                        <td align="center" class="columnDataGrey"> <?=date("d-m-Y",$value['creation_dt'])?></td>
                                        <td align="center" class="columnDataGrey"> <?=$article_category[$value['category_id']]?></td>
                                        <td align="center" class="columnDataGrey">
                                            <div id="status<?=$value['id']?>">
                                                <a onclick='call_ajax_status_change("<?=base_url().'admin/article/ajax_change_status'?>",<?=$jsnArr?>,"<?='status'.$value['id']?>");'  style="cursor:pointer; <?=$style?>"><?=$txt?></a>
                                            </div>
                                        </td>
                                        <td align="center" class="columnDataGrey">
                                            <a href="<?=base_url().'admin/article/delete_article/'.$value['id']?>">
                                                <img onclick="return confirm('Are you sure want to delete this article?')" border="0" style="margin:4px;" src="images/admin/icon_delete.png" title="Delete article" style="cursor:pointer;" />
                                            </a>
                                            <a href="<?=base_url().'admin/article/edit_article/'.$value['id']?>">
                                                <img border="0" style="margin:4px;" src="images/admin/icon_edit.gif" title="Edit article" style="cursor:pointer;" />
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