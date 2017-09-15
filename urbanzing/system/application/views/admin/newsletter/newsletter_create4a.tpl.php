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
                    <table width="100%">
			            <tr>
			                <td align="left" style="padding-top:10px;">
			                    <form name="frm" action="<?=base_url().'admin/newsletter/newsletter_create4a'.$nid?>" method="post" enctype="multipart/form-data">
			                        <?php $this->load->view('admin/common/message_page.tpl.php'); ?>
			                    <table width="100%" cellpadding="3" cellspacing="0" border="0">
			                        <tr>
			                            <td align="center" style="padding-bottom:20px;">
			                                Newsletter
			                            </td>
			                        </tr>
			                    </table>
			                    <input type="hidden" name="opeid" value="<?=$nid?>">
			                     <input type="hidden" name="mode" value="save">
			                    <table width="90%" border="1" cellpadding="0" cellspacing="0" bordercolor="#666666" style="border-collapse :collapse" align="center">
			                    <tr>
			                        <td class="text1" height="30" bgcolor="#cccccc" align="left" style="color:#000000;">Manage Newsletter
			                        </td>
			                        <td align="right" class="text1">
			                        </td>
			                    </tr>
			                    <tr>
			                        <td  colspan="2"align="left" valign="top">
			                            <table width="100%" cellpadding="0"  cellspacing="0">
			                                <tr>
			                                    <td align="left" class="text1" style="padding-left:24px;color:#000000;"><strong>Enter the web address of your newsletter</strong></td>
			                                </tr>
			                                <tr>
			                                    <td align="left" class="text1" style="color:#000000;">This is the current address of your newsletter on the web. Newsletter will browse to your page, scan it for any potential issues and if successful, import it into your account.</td>
			                                </tr>
			                                <tr>
			                                    <td align="left" class="text1">
			                                        <table border="0" cellpadding="0" cellspacing="0" width="90%" align="center">
			                                            <tr  bgcolor="#cccccc">
			                                                <td width="15%" align="left" class="text1" style="color:#000000;">HTML page</td>
			                                                <td width="85%">
			                                                <? 
			                                                if(!isset($html_file) && $html_file=="")
			                                                {
			                                                ?>
			                                                	<input class="textbox2" type="file" name="import_file" size="30"  />
		                                                	<? 
			                                                } 
			                                                else 
			                                                {
			                                                ?>
			                                                <a href="javascript:MM_openWindow('htmlfile_preview.php','newsletter','scrollbars=yes,width=770,height=700,resizable=yes,toolbar=no');" class="text2">View a preview</a> 
			                                                | 
			                                                <a href="<?=base_url()?>admin/newsletter/delete_htmlfile/<?=$nid?>" class="text2">Delete</a>
			                                                <? 
			                                                } 
			                                                ?></td>
			                                            </tr>
			                                        </table>
			                                    </td>
			                                </tr>
			                                <tr align="left">
			                                    <td>&nbsp;</td>
			                                </tr>
			                                <tr>
			                                    <td height="100%" align="center" valign="top">&nbsp;</td>
			                                </tr>
			                                <tr>
			                                    <td  height="30" align="center" valign="middle">
			                                        <table width="100%" border="0" cellspacing="20" cellpadding="0">
			                                            <tr>
			                                                <td align="right" width="50%">
			                                                    <input type="submit" name="prev" value="Previous"  class="button"/></td>
			                                                <td align="left">
			                                                    <input type="submit" name="Btnnext" value="Import"  class="button"></td>
			                                            </tr>
			                                        </table>
			                                    </td>
			                                </tr>
			                            </table>
			                        </td>
							  </tr>
							</table>
			                    <script type="text/javascript">
			                        <!--
			                          function MM_openWindow(theURL,winName,features)
			   {
			      features=features + ",left=" + (screen.width - 540)/2;
			      features=features + ",top=" + (screen.height - 480)/2;
			      window.open(theURL,winName,features);
			    }
			     //-->
			                     </script>
			                    </form>
			                </td>
			        </tr>
			    </table>
                </div>
            </td>
		  </tr>
		 </table>
	  </td>
    </tr>
	<tr><td height="1px;"></td></tr>
  </table>