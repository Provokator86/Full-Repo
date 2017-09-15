<table id="tbl_content_area" width="100%" border="0" cellspacing="0" cellpadding="5">

	<tr><td height="1px"></td></tr>
	<tr>
      <td align="left" valign="middle" bgcolor="#FFFFFF" style="border:1px dotted #999999;" height="100%">
	  	 <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
		  <tr>
		  	<td style="border-right:1px dotted #999999; width:25%; background:#F3F3F3;" valign="top" align="left">
			   <?php $this->load->view('admin/common/menu_cms.tpl.php');	?>
			</td>
			<td style="width:75%;" valign="top" align="center">
				<?php
				$this->load->view('admin/common/message_page.tpl.php'); 
				?>
				<table width="90%" border="0" cellspacing="0" cellpadding="0" style="margin-top:40px;">
					  <tr>
						<td width="110" class="td_tab_main" align="center" valign="middle"><?=$table_title?></td>
						<td>&nbsp;</td>
					  </tr>
				</table>
			    <table width="90%" border="0" cellspacing="0" cellpadding="10" style="border:1px solid #999999;">
					  <tr>
						<td align="center" valign="middle">
                            <form id="frm_article" name="frm_article" method="post" action="<?=base_url().'admin/article/update_article'?>" enctype="multipart/form-data">
							<table width="100%" border="0" cellspacing="0" cellpadding="7">
                                <tr>
								<td width="140" align="right" valign="middle" class="field_title"><span style="color:#8B0000;">*</span>&nbsp;<strong>Category : </strong></td>
								<td align="left" valign="middle">
                                    <select id="category_id" name="category_id">
                                        <option value="">Select a category</option>
                                        <?=$article_category_option?>
                                    </select>
                                    </td>
							  </tr>
                              <tr>
								<td width="140" align="right" valign="middle" class="field_title"><strong>Title : </strong></td>
								<td align="left" valign="middle"><input id="title" name="title" type="text" class="textfield" style="width:200px;" value="<?=$article[0]['title']?>" /></td>
							  </tr>
                            <tr>
								<td width="140" align="right" valign="top" class="field_title"><strong>Description : </strong></td>
								<td align="left" valign="middle">
                                    <textarea id="description" name="description" cols="10" rows="10"><?=$article[0]['description']?></textarea>
                                </td>
							  </tr>
							 
							<!--  <tr>
							    <td align="right" valign="middle" class="field_title">&nbsp;</td>
							    <td align="left" valign="middle">
							    	<div id="delImg">
							    	<img src="<?=$img_thumb_path?>">&nbsp;
							    	<img src="<?=base_url().'images/admin/icon_error.gif'?>" onclick="call_ajax_del_image('<?=base_url().'admin/article/delete_image'?>','<?=$article[0]['id']?>','delImg','avail_no')" />
							    	</div>
						    	</td>
							    	
						      </tr>	
							  <tr>
							    <td align="right" valign="middle" class="field_title"><strong>Picture :</strong></td>
							    <td align="left" valign="middle">
									<input type="file" name="img" id="img">&nbsp;&nbsp;&nbsp;(Allowed file type .gif, .jpg, .png, .jpeg)
								</td>
						      </tr>-->
							  <tr>
							    <td align="right" valign="middle" class="field_title"><strong>Change Image: </strong></td>
							    <td align="left" valign="middle">
								<input type="radio" name="change_image" id="change_image" value="1">Yes
								<input type="radio" name="change_image" id="change_image" value="0" checked="checked">No								
								
								</td>
						      </tr>
							  </table>
							<table width="100%" border="0" cellspacing="0" cellpadding="7">
							  <tr>
								<td width="140" align="right" valign="middle">&nbsp;</td>
								<td width="80" align="left" valign="middle">
                                    <input type="hidden" id="id" name="id" value="<?=$article[0]['id']?>">
                                    <input name="change_id" type="button" class="button" value="Submit" onclick="ck_page()" /></td>
                                <td align="left" valign="middle"><input name="reset1" type="reset" class="button" value="Back" onclick="window.location.href='<?=$redirect_url?>';" /></td>
							  </tr>
							</table>
                            <script type="text/javascript">
                                function ck_page()
                                {
                                    var cntrlArr    = new Array('category_id');
                                    var cntrlMsg    = new Array('Please select a category');
                                    if(ck_blank(cntrlArr,cntrlMsg)==true)
                                        document.frm_article.submit();
                                }
                             </script>
						  </form>
									</td>
					  </tr>
					</table>
			</td>
		  </tr>
		 </table>
	  </td>
    </tr>
	<tr><td height="1px;"></td></tr>
  </table>