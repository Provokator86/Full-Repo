<script type="text/javascript" language="javascript">

function delete_static_page()
{
	var sure_to_delete = false;
	sure_to_delete = confirm("Are you sure to delete this?");
	return sure_to_delete;
}

</script>
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
                        //$this->load->view('admin/common/admin_filter.tpl.php');
                        if($static_page_list)
                        {
                            ?>
		<table width="100%">
			<tr>
				<td align="left" style="padding-top:10px;">
					<table width="30%" cellpadding="3" cellspacing="0" border="0">
						<tr>
							<td class="td_tab_main">
								List of static Pages:
							</td>
						</tr>
					</table>
					<table width="98%" style="border: 1px solid rgb(153, 153, 153);" cellpadding="3" cellspacing="0" >
						<tr>
							<td  class="td_tab_main" align="left" style="padding-left:0px;">Page Title</td>
							<td  class="td_tab_main" align="left" style="padding-left:0px;">Title</td>		
							<td class="td_tab_main" align="left" style="padding-left:0px;">url</td>
							<!--<td class="td_tab_main" align="center" style="padding-left:0px;">Meta Key Words</td>
							<td class="td_tab_main" align="center" style="padding-left:0px;">Meta Description</td>
							<td class="td_tab_main" align="center" style="padding-left:0px;">Content</td>-->
							<td class="td_tab_main" align="left" style="padding-left:0px;">Edit</td>
							<td class="td_tab_main" align="left" style="padding-left:0px;">Delete</td>
						</tr>


					   <?
					   /*echo "<pre>";
					   print_r($admin_user);
					   echo "</pre>";*/
						foreach($static_page_list as $key=>$value)
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
						<td align="center" class="columnDataGrey" > <?=$value['page_title']?> </td>
						<td align="center" class="columnDataGrey"> <?=$value['title']?></td>
						<td align="center" class="columnDataGrey"><?=$value['url']?></td>
						<!--<td align="center" class="columnDataGrey">--><?php //$value['meta_keywords']?><!--</td>-->
						<!--<td align="center" class="columnDataGrey">--><?php //$value['meta_description']?><!--</td>-->
				   	    <!--<td align="center" class="columnDataGrey">--> <?php //substr(html_entity_decode($value['page_content']),0,50)?><!--..</td>-->		                <td align="center" class="columnDataGrey"><a href="<?=base_url()?>admin/static_page/edit_static_page/<?=$value['id']?>">Edit </a></td>
						
						<td align="center" class="columnDataGrey"><a onclick="return delete_static_page();" href="<?=base_url()?>admin/static_page/delete_static_page/<?=$value['id']?>">Delete </a></td>
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