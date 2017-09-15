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
			                    <form name="frm" action="<?=base_url()?>admin/newsletter/newsletter_snapshot/<?=$nid?>" method="post" enctype="multipart/form-data" onsubmit="return newsletter_submit()">
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
			                        <td class="text1" height="30" bgcolor="#cccccc" align="left" style="color:#000000;">Newsletter Select user
			                        </td>
			                    </tr>
			                    <tr>
			                        <td  colspan="2"align="left" valign="top">
			                            <table width="100%" cellpadding="0"  cellspacing="0">
			                                <tr>
			                                    <td align="left" height="25" class="text1" style="padding-left:65px;color:#000000;"><strong>Newsletter and sender</strong></td>
			                                </tr>
			                                <tr  >
			                                    <td align="right" class="text1">
			                                        <table border="0" cellpadding="0" cellspacing="0" width="90%" align="center">
			                                            <tr align="left"  bgcolor="#cccccc">
			                                                <td width="35%" align="left" class="text1" style="padding-left:10px;color:#000000;">Select receiver </td>
			                                                <td width="65%" height="25" valign="middle" class="text1" style="color:#000000;">
<!--			                                                    <input onclick="show_div(1);" type="radio" name="recevier_type" id="recevier_type" checked value="1">All&nbsp;&nbsp;&nbsp;
			                                                    <input onclick="show_div(2);" type="radio" name="recevier_type" id="recevier_type" value="2">Selective&nbsp;&nbsp;&nbsp;
			-->
			                         <select name="sel_invite_users" id="sel_invite_users" onchange="get_invites_users(this.value)">
									 	<option value="-1">Select User Type</option>
										<!--<option value="0">All</option>-->
										<option value="0">Invited Users</option>
									 	<?=$user_type_list?>
									 </select>                       
															
															
															</td>
			                                            </tr>
			                                            <tr align="left"  bgcolor="#cccccc">
			                                                <td align="left" class="text1" style="padding-left:10px;padding-top:10px;" colspan="2">
			                                                    <div id="user_lst">
			                                                        
			                                                    </div>
			
			                                                </td>
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
			                                                <td align="right">&nbsp;</td>
			                                                <td align="left" width="50%">
			                                                    <input type="submit" name="bttnUser" value="Next" class="button" /></td>
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
					function show_div(tag)
					{
						var dvusr  = document.getElementById('user_lst');
						dvusr.style.display    = 'none';
						if(tag==2)
							dvusr.style.display    = 'block';
				
					}
					
					function get_invites_users(id)
					{
						
						tb_show('Select invite users',base_url+'/admin/newsletter/show_invites_users/'+id+'?height=480&width=620');
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
  
  <script>
function newsletter_submit()
{

	if($('#sel_invite_users').val() == -1)
	{
		alert('Please Select receiver');
		return false;
	}
	document.frm.submit();
	return false;

}

function before_ajaxform_addimage_modify(){
	//UiBlock();
}

function after_ajaxform_addimage_modify(responseText, statusText, xhr, $form) {
	//var result_obj = null;
//	try {
//		var result_obj = JSON.parse(responseText);
//	}
//	
//	catch (e) {
//		$.blockUI({
//			message: "Some error occurred. Please try again.",
//			css: {
//				border: 'none',
//				padding: '15px',
//				backgroundColor: '#000000',
//				'-webkit-border-radius': '10px',
//				'-moz-border-radius': '10px',
//				opacity: '1',
//				color: '#ffffff'
//			},
//			overlayCSS: { backgroundColor: '#000000' }
//		});
//		
//		//setTimeout(unblockUI, 2000);
//		return 1;
//	}

	//if(result_obj.result=='success') {
		//alert(base64_decode(result_obj.events_html));
		$('#user_lst').html(responseText);
		//$.unblockUI();
		tb_remove();
	//}
/*	else {
		for ( var id in result_obj.error ){
			if( document.getElementById('msg_'+id) != null ) {
				document.getElementById('msg_'+id).innerHTML = result_obj.error[id];
				document.getElementById('msg_'+id).style.display = '';
			}
		}

		$.unblockUI();
	}*/
}

</script>