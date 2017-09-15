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
			                    <form name="frm" action="<?=base_url().'admin/newsletter/newsletter_create3/'.$nid?>" method="post" enctype="multipart/form-data">
			                    <table width="100%" cellpadding="3" cellspacing="0" border="0">
			                        <tr>
			                            <td align="center" style="padding-bottom:20px;">
			                                Newsletter
			                            </td>
			                        </tr>
			                    </table>
			                    <input type="hidden" name="opeid" value="<?=$nid?>">
			                    <table width="90%" border="1" cellpadding="0" cellspacing="0" bordercolor="#666666" style="border-collapse :collapse" align="center">
			                    <tr>
			                        <td class="text1" height="30" bgcolor="#cccccc" align="left" style="color:#000000;">Manage Newsletter
			                        </td>
			                    </tr>
			                    <tr>
			                        <td  colspan="2"align="left" valign="top">
			                            <table width="100%" cellpadding="0"  cellspacing="0">
			                                <tr>
			                                    <td colspan="2" align="left" class="text1" style="padding-top:10px;padding-left:10px;color:#000000;">Please select how you would like to import the content for this newsletter.</td>
			                                </tr>
			                                <!--<tr  >
			                                    <td align="right" class="text1">
			                                        <input id="red1" name="htmltype" type="radio" value="1" <?=($newsletter_session["htmltype"]==1)?'checked':''?> /></td>
			                                    <td class="text1" style="padding-left:20px;color:#000000;"><strong>Enter the location of the newsletter on the web</strong></td>
			                                </tr>
			                                <tr  >
			                                    <td align="right" class="text1">&nbsp;</td>
			                                    <td class="text1" style="color:#000000;">Select this option if your newsletter is accessible somewhere on the web. You will be required to enter the address (URL) of your campaign in the next step.
			                                    </td>
			                                </tr>-->
			                                <tr>
			                                    <td width="17%" align="right" class="text1">
			                                        <input id="red1" name="htmltype" type="radio" value="2" <?=($newsletter_session["htmltype"]==2)?'checked':''?> /></td>
			                                    <td width="90%" class="text1" style="padding-left:20px;color:#000000;"><strong>Import the newsletter from my computer or network</strong></td>
			                                </tr>
			                                <tr  >
			                                    <td align="right" class="text1">&nbsp;</td>
			                                    <td class="text1" style="color:#000000;">Select this option if you would like to import the newsletter from your own computer or network.
			                                    </td>
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
			                                                <td align="right">
			                                                    <input type="submit" name="prev" value="Previous" class="button"/></td>
			                                                <td align="left">
			                                                    <input type="submit" name="Btnnext" value="Next"  class="button" onclick="return CheckRedio();"/></td>
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
			                        function CheckRedio()
								    {
								        var flag=false;
								        var n=document.getElementsByName("htmltype").length;
								        for(var i=0;i<n;i++)
								        {
								            var obj=document.getElementsByName("htmltype");
								            if(obj[i].checked)
								            {
								                flag=true;
								            }
								        }
								        if(!flag)
								        {
								            alert("Please select atleast one option");
								            return false;
								        }
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