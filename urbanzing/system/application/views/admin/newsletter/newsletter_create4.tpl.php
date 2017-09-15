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
			                    <form name="frm" action="<?=base_url()?>admin/newsletter/newsletter_create4/<?=$nid?>" method="post" enctype="multipart/form-data">
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
			                                    <td align="left" class="text1" style="padding-left:24px;color:#000000;"><strong>Enter the web address of your newsletter</strong></td>
			                                </tr>
			                                <tr>
			                                    <td align="left" class="text1" style="color:#000000;">This is the current address of your newsletter on the web. newsletter Monitor will browse to your page, scan it for any potential issues and if successful, import it into your account.</td>
			                                </tr>
			                                <tr>
			                                    <td align="left" class="text1">
			                                        <table border="0" cellpadding="0" cellspacing="0" width="90%" align="center">
			                                            <tr bgcolor="#cccccc">
			                                                <td width="10%" align="left"  class="text1" style="padding-left:10px;color:#000000;"><strong>http://</strong></td>
			                                                <td width="90%"><input class="textbox" type="text" name="txturl" value="<?=$newsletter_session["txturl"]?>" style="width:400px;" /></td>
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
			                                                    <input type="submit" name="prev" value="Previous" class="button"/></td>
			                                                <td align="left">
			                                                    <input type="submit" name="Btnnext" value="Next"  class="button" onclick="return Validation();"></td>
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
			                         function Validation()
							    {
							        if(document.frm.txturl.value=="")
							        {
							            alert("Please enter website url");
							            return false;
							        }
							        return true;
							    }
							
							    function PageName(Obj)
							    {
							        var page=Obj.split('.');
							        var pos=Obj.indexOf(page[3]);
							        if(pos!=-1)
							         var ext=Obj.substring(pos,Obj.length);
							        if(ext!="htm" && ext!="html")
							        {
							            window.alert("please enter page name to complete the url format. It must be in .htm and .html format.");
							             return false;
							        }
							        return true;
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