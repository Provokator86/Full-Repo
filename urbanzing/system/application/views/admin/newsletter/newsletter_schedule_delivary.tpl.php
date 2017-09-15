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
			                    <form name="frm" action="<?=base_url().'admin/newsletter/newsletter_schedule_delivary/'.$nid?>" method="post" enctype="multipart/form-data">
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
			                        <td class="text1" height="30" bgcolor="#cccccc" align="left" style="color:#000000;">Schedule Newsletter Delivary
			                        </td>
			                        <td align="right">
			                        </td>
			                    </tr>
			                    <tr>
			                        <td  colspan="2"align="left" valign="top">
			                            <table width="100%" cellpadding="0"  cellspacing="0">
			                                <tr>
			                                    <td width="8%" height="30" align="right" class="text1" valign="top" style="padding-right:5px;">
			                                        <span class="text1">
			                                            <input id="red1" name="send_type" type="radio" value="1" checked="checked"  />
			                                        </span>
			                                    </td>
			                                    <td width="92%" height="30" align="left" class="text1" style="color:#000000;"><strong>Deliver the newsletter immediately</strong><br />
						Your newsletter will be sent to the newsletter delivery system and sent to your recipients immediately.
			                                    </td>
			                                </tr>
			                                <tr>
			                                    <td colspan="2" align="right" class="text1">
			                                        <table border="0" cellpadding="0" cellspacing="0" width="90%" align="center">
			                                            <tr align="left"  bgcolor="#cccccc">
			                                                <td width="35%" align="left" class="text1" style="padding-left:10px;color:#000000;">Send confirmation to</td>
			                                                <td width="65%" height="45" valign="middle">
			                                                    <input style="width:200px;" class="textbox" type="text" name="send_confermation_email" size="50" value="<?=$newsletter_session['send_confermation_email']?>" /></td>
			                                            </tr>
			                                        </table>
			                                    </td>
			                                </tr>
			                                <!--<tr>
			                                    <td width="8%" height="25" align="right" valign="top" class="text1" style="padding-right:5px;">
			                                        <span class="text1">
			                                            <input id="red1" name="send_type" type="radio" value="2" <?=($newsletter_session["send_type"]==2)?'checked':''?> />
			                                        </span>
			                                    </td>
			                                    <td width="92%" align="left" class="text1" style="color:#000000;"><strong>Newsletter and sender</strong><br />
					      You can always change the scheduled delivery time before the newsletter is sent.
			                                    </td>
			                                </tr>
			                                <tr>
			                                    <td colspan="2" align="left" class="text1">
			                                        <table border="0" cellpadding="0" cellspacing="0" width="90%" align="center">
			                                            <tr align="left"  bgcolor="#cccccc">
			                                                <td width="35%" align="left" class="text1" style="padding-left:10px;color:#000000;">Date (mm/dd/yy)</td>
			                                                <td width="65%" height="25" valign="middle">
			                                                    <select name='month' class="textbox" style="width:75px;" >
			                                                        <option value="">Month</option>
			                                    <?php
												 $sr_no=1;
												 while($sr_no!=13)
												 {
													 if($newsletter_session["month"]==$sr_no)
			                                            print "<option value='$sr_no' selected>$sr_no</option>";
													 else
			                                            print "<option value='$sr_no'>$sr_no</option>";
													 $sr_no=$sr_no+1;
												 }
											?>
			                                                    </select>
			                          &nbsp;&nbsp;
			                                                    <select name='day' class="textbox" style="width:75px;">
			                                                            <option value="">Day</option>
											<?php
												 $sr_no=1;
												 while($sr_no!=32)
												 {
													 if($newsletter_session["day"]==$sr_no)
			    										  print "<option value='$sr_no' selected>$sr_no</option>";
													 else
			    										  print "<option value='$sr_no'>$sr_no</option>";
													 $sr_no=$sr_no+1;
												 }
											?>
			                                                    </select>
			                           &nbsp;&nbsp;
			                                                    <select name='year' class="textbox" style="width:75px;">
			                                                        <option value="">Year</option>
											<?php
												 $sr_no=date("Y");
												 while($sr_no<2100)
												 {
													 if($newsletter_session["year"]==$sr_no)
			    										  print "<option value='$sr_no' selected>$sr_no</option>";
													 else
			    										  print "<option value='$sr_no'>$sr_no</option>";
													 $sr_no=$sr_no+1;
												 }
											?>
			                                                    </select>
			                                                </td>
			                                            </tr>
			                                            <tr align="left"  bgcolor="#cccccc">
			                                                <td align="left" class="text1" style="padding-left:10px;color:#000000;">Time</td>
			                                                <td height="25" valign="middle">
			                                                    <select name='hour' class="textbox" style="width:75px;">
			                                                        <option value="00">00</option>
			                            <?php
												 $sr_no=1;
												 while($sr_no!=13)
												 {
													 if($newsletter_session["hour"]==$sr_no)
													 {
													 	if($sr_no>=1 && $sr_no<=9)
															$sr_no='0'.$sr_no;
													  	print "<option value='$sr_no' selected>$sr_no</option>";
													 }
													 else
													 {
													 	if($sr_no>=1 && $sr_no<=9)
															$sr_no='0'.$sr_no;
													    print "<option value='$sr_no'>$sr_no</option>";
													 }
													 $sr_no=$sr_no+1;
												 }
											?>
			                                                    </select>
			                          &nbsp;&nbsp;
			                                                    <select name='min' class="textbox" style="width:75px;">
			                                                        <option value="00">00</option>
											<?php
												 $sr_no=1;
												 while($sr_no!=61)
												 {
													 if($newsletter_session["min"]==$sr_no)
													 {
													 	if($sr_no>=1 && $sr_no<=9)
															$sr_no='0'.$sr_no;
													  print "<option value='$sr_no' selected>$sr_no</option>";
													 }
													 else
													 {
													 	if($sr_no>=1 && $sr_no<=9)
															$sr_no='0'.$sr_no;
													  print "<option value='$sr_no'>$sr_no</option>";
													 }
													 $sr_no=$sr_no+1;
												 }
											?>
			                                                    </select>
			                          &nbsp;&nbsp;
			                                                    <select  name='timestatus' class="textbox" style="width:75px;">
			                                                        <option value="AM" <? if($newsletter_session['timestatus']=="AM") echo "selected";?>>AM</option>
			                                                        <option value="PM" <? if($newsletter_session['timestatus']=="PM") echo "selected";?>>PM</option>
			                                                    </select>
			                                                </td>
			                                            </tr>
			                                            <tr align="left"  bgcolor="#cccccc">
			                                                <td align="left" class="text1" style="padding-left:10px;color:#000000;">Send confirmation to</td>
			                                                <td height="25" valign="middle">
			                                                    <input class="textbox" style="width:200px;" type="text" name="send_confermation_email2" size="50" value="<?=$newsletter_session['send_confermation_email2']?>" /></td>
			                                            </tr>
			                                        </table>
			                                    </td>
			                                </tr>-->
			                                <tr>
			                                    <td colspan="2" align="left"></td>
			                                </tr>
			                                <tr align="left">
			                                    <td colspan="2">&nbsp;</td>
			                                </tr>
			                                <tr>
			                                    <td height="100%" colspan="2" align="center" valign="top">&nbsp;</td>
			                                </tr>
			                                <tr>
			                                    <td  height="30" colspan="2" align="center" valign="middle">
			                                        <table width="100%" border="0" cellspacing="20" cellpadding="0">
			                                            <tr>
			                                                <td align="right">
			                                                    <input type="submit" name="prev" value="Previous" class="button" /></td>
			                                                <td align="left" width="50%">
			                                                    <input type="submit" name="Btnnext" value="Submit"  class="button" onclick="return CheckRedio();"/></td>
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
			                            var n=document.getElementsByName("send_type").length;
			                            for(var i=0;i<n;i++)
			                            {
			                                var obj=document.getElementsByName("send_type");
			                                if(obj[i].checked)
			                                    flag=true;
			                    //            alert(obj[i].value);
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