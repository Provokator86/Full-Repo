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
			                    <form name="frm" action="<?=base_url().'admin/newsletter/newsletter_create5b/'.$nid?>" method="post" enctype="multipart/form-data">
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
			                </tr>
			                <tr>
			                    <td  colspan="2"align="left" valign="top">
			                        <table width="100%" cellpadding="0"  cellspacing="0">
			                            <tr  >
			                                <td colspan="2" align="left" class="text1" style="color:#000000;"><strong>Newsletter successfully imported.</strong></td>
			                            </tr>
			                            <tr>
			                                <td width="4%" align="right" class="text1">&nbsp;</td>
			                                <td width="96%" class="text1" style="padding-left:20px;">
			                                    <a href="javascript:MM_openWindow('<?=base_url()?>admin/newsletter/newletter_campaign_preview','newsletter','scrollbars=yes,width=770,height=700,resizable=yes,toolbar=no');"><img src="<?=base_url()?>images/admin/previewMyCampaign.gif" border="0" /></a>
			                                </td>
			                            </tr>
			                            <tr>
			                                <td colspan="2" align="left" class="text1" style="color:#000000;">1. The majority of web-based email clients such as Gmail, Hotmail   and Yahoo! as well as Outlook Express 6.0, Outlook 2000-2003 and updated   versions of Outlook 98 will strip out your JavaScript content automatically and   disable any active scripting contained in the newsletter. A security warning may   also be displayed, potentially damaging your relationship with the   recipient.<br />
			                                    <br />		      <br /></td>
			                            </tr>
			                            <tr>
			                                <td colspan="2" align="left" class="text1" style="color:#000000;">2. The use of Flash content
			By default, AOL, Outlook Express 6.0, Outlook 2002/2003 and updated versions of Outlook 98 and 2000 will not display Flash movies in a HTML email because the security settings prohibit ActiveX controls like Flash from running. Also, the majority of web-based email clients such as Hotmail and Yahoo! will also strip out your Flash content automatically.
			              <br /></td>
			                            </tr>
			                            <tr align="left">
			                                <td colspan="2">&nbsp;</td>
			                            </tr>
			                            <tr>
			                                <td colspan="2" height="100%" align="center" valign="top">&nbsp;</td>
			                            </tr>
			                            <tr>
			                                <td  height="30" colspan="2" align="center" valign="middle">
			                                    <table width="100%" border="0" cellspacing="20" cellpadding="0">
			                                        <tr>
			                                            <td align="right">&nbsp;</td>
			                                            <td align="left" width="50%">
			                                                <input type="submit" name="Btnnext" value="Next"  class="button"/></td>
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