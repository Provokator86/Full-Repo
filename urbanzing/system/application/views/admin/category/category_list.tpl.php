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
                        $this->load->view('admin/common/admin_filter.tpl.php');
                        if($category)
                        {
                            ?>
                    <table width="100%">
                        <tr>
                            <td align="left" style="padding-top:10px;">
                                <table width="30%" cellpadding="3" cellspacing="0" border="0">
                                    <tr>
                                        <td class="td_tab_main">
                                            List of Business Type
                                        </td>
                                    </tr>
                                </table>
                                <table width="98%" style="border: 1px solid rgb(153, 153, 153);" cellpadding="3" cellspacing="0" >
                                    <tr>
                                        <td  class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='name')?'bold':'normal'?>;" href="<?=base_url().'admin/category/index/name/'.(($order_name=='name' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Name</a>
                                        </td>
                                        <!--<td class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='item_type')?'bold':'normal'?>;" href="<?=base_url().'admin/category/index/item_type/'.(($order_name=='item_type' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Item type</a>
                                        </td>-->
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='creation_dt')?'bold':'normal'?>;" href="<?=base_url().'admin/category/index/cr_date/'.(($order_name=='cr_date' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Creation date</a>
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;">
                                            <a style="color:#FFFFFF;font-weight:<?=($order_name=='parent_id')?'bold':'normal'?>;" href="<?=base_url().'admin/category/index/parent_id/'.(($order_name=='parent_id' && $order_type=='asc')?'desc':'asc').'/'.$page ?> ">
                                            Parent</a>
                                        </td>
                                        <td class="td_tab_main" align="center" style="padding-left:0px;font-weight: normal;">
                                            Action
                                        </td>
                                    </tr>


                           <?
                            foreach($category as $key=>$value)
                            {
                                ?>
                                    <tr>
                                        <td align="center" class="columnDataGrey"> <?=$value['name']?></td>
                                       <!-- <td align="center" class="columnDataGrey"> <?=$value['item_type']?></td>-->
                                        <td align="center" class="columnDataGrey"> <?=date("d-m-Y",$value['cr_date'])?></td>
                                        <td align="center" class="columnDataGrey"> <?=(!is_null($value['pname']))?$value['pname']:"-"?></td>
                                        <td align="center" class="columnDataGrey">
                                           <!-- <a href="<?=base_url().'admin/category/delete_category/'.$value['id']?>">
                                                <img onclick="return confirm('Are you sure want to delete this category?')" border="0" style="margin:4px;" src="images/admin/icon_delete.png" title="Delete category" alt="" style="cursor:pointer;" />
                                            </a>-->
                                            <a href="<?=base_url().'admin/category/edit_category/'.$value['id']?>">
                                                <img border="0" style="margin:4px;" src="images/admin/icon_edit.gif" title="Edit category" style="cursor:pointer;" />
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