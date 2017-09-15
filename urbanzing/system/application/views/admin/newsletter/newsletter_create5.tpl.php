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
			                    <form id="frm_news" name="frm_news" action="<?=base_url().'admin/newsletter/newsletter_create5b/'.$nid?>" method="post" enctype="multipart/form-data">
			                    <table width="100%" cellpadding="3" cellspacing="0" border="0">
			                        <tr>
			                            <td align="center" style="padding-bottom:20px;">
			                                Newsletter
			                            </td>
			                        </tr>
			                    </table>
			                    <input type="hidden" name="opeid" value="<?=$nid?>">
			                     <input type="hidden" name="mode" value="save">
			                     <input type="hidden" name="htmcontent" >
			                    <table width="90%" border="1" cellpadding="0" cellspacing="0" bordercolor="#666666" style="border-collapse :collapse" align="center">
			                    <tr>
			                        <td class="text1" height="30" bgcolor="#cccccc" align="left" style="color:#000000;">Manage Newsletter
			                        </td>
			                    </tr>
			                    <tr>
			                        <td  colspan="2"align="left" valign="top">
			                            <table width="100%" cellpadding="0"  cellspacing="0">
			                                <tr >
			                                    <td colspan="2" align="left"  class="text1" style="color:#000000;"><strong>Processing for Newsletter  imported.</strong></td>
			                                </tr>
			                                <tr >
			                                    <td width="4%" align="right" class="text1">&nbsp;</td>
			                                    <td width="96%" class="auto_email_heading" style="padding-left:20px;">&nbsp;</td>
			                                </tr>
			                                <tr  >
			                                    <td colspan="2" align="center" class="text1" style="color:#000000;"><h2>Downloading & Scanning</h2>
			                                        Newsletter is downloading your content<br />
			                                        and scanning for any potential problem.<br />
			                                        <img src="<?=base_url()?>images/admin/genbrug02.gif" border="0" />
			                                        <br />
			                                  </td>
			                            </tr>
			                            <tr align="left"  >
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
			                                            <td align="left" width="50%"></td>
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
			                         function AddUrlContent(website)
								    {
								        var url=website;
								         http_request = false;
								            b='';
								            if (window.XMLHttpRequest) { // Mozilla, Safari,...
								                http_request = new XMLHttpRequest();
								                b='FF';
								
								                if (http_request.overrideMimeType) {
								                    http_request.overrideMimeType('text/xml');
								                    // See note below about this line
								                }
								            } else if (window.ActiveXObject) { // IE
								                try {
								                    b='IE';
								                    http_request = new ActiveXObject("Msxml2.XMLHTTP");
								                } catch (e) {
								                    try {
								                        b='IE';
								                        http_request = new ActiveXObject("Microsoft.XMLHTTP");
								                    } catch (e) {}
								                }
								            }
								
								            if (!http_request) {
								                alert('Giving up :(Cannot create an XMLHTTP instance');
								                return false;
								            }
								            http_request.onreadystatechange = alertContentsRate;
								
								            http_request.open('GET','<?=base_url()?>admin/newsletter/testnewsletter/'+website+'', true);
								            http_request.send(null);
								    }
								
								    function alertContentsRate()
								    {
									   //alert(http_request.readyState);
								        if (http_request.readyState == 4)
								        {
								        //	 alert(http_request.readyState);
								            var xmldoc=http_request.responseText;
								            document.frm_news.htmcontent.value=http_request.responseText;
								            document.frm_news.action="<?=base_url()?>admin/newsletter/newsletter_create5b/"+'<?=$nid?>';
								            //alert(document.frm_news.htmcontent.value);
								            document.frm_news.submit();
								    	}
								    }
								
								    AddUrlContent('<?=str_replace('=','',base64_encode($newsletter_session['txturl']))?>');
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