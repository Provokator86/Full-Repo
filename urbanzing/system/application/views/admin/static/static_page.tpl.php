<style type="text/css">
.error{color:#FF0000;font-size:10px;}
</style>

<table id="tbl_content_area" width="100%" border="0" cellspacing="0" cellpadding="5">
    
	<tr><td height="1px"></td></tr>
	<tr>
      <td align="left" valign="middle" bgcolor="#FFFFFF" style="border:1px dotted #999999;" height="100%">
	  	 <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
		  <tr>
		  	<td style="border-right:1px dotted #999999; width:25%; background:#F3F3F3;" valign="top" align="left">
			   <?php $this->load->view('admin/common/menu_general.tpl.php');	?>
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
                            <form id="frm_article" name="frm_article" method="post" action="<?=base_url().'admin/static_page'?>" enctype="multipart/form-data">
							<table width="100%" border="0" cellspacing="0" cellpadding="7">
                           
                              <tr>
								<td width="140" align="right" valign="middle" class="field_title"><strong> Page Title : </strong></td>
								<td align="left" valign="middle"><input id="page_title" name="page_title" type="text" class="textfield" style="width:250px;" value="<?php echo set_value('page_title'); ?>" />
								<br /><?php echo form_error('page_title'); ?></td>
							  </tr>
							  
                              <tr>
								<td width="140" align="right" valign="middle" class="field_title"><strong>  Title : </strong></td>
								<td align="left" valign="middle"><input id="title" name="title" type="text" class="textfield" style="width:250px;" value="<?php echo set_value('title'); ?>" /><br /><?php echo form_error('title'); ?></td></td>
							  </tr>
							  <tr>
								<td width="140" align="right" valign="middle" class="field_title"><strong>  url : </strong></td>
								<td align="left" valign="middle">
								<input id="url" name="url" type="text" class="textfield" style="width:250px;" value="<?php echo set_value('url'); ?>" />
									<br/><span style="color:#FF0000;font-size:10px;"> 
									No special Characters allowed, only '_' and '-' are allowed
									</span>
									<br /><?php echo form_error('url'); ?></td>
								</td>
							  </tr>
							    <tr>
								<td width="140" align="right" valign="middle" class="field_title"><strong>  Meta Key Word : </strong></td>
								<td align="left" valign="middle"><input id="meta_keywords" name="meta_keywords" type="text" class="textfield" style="width:250px;" value="<?php echo set_value('meta_keywords'); ?>" /><br /><?php echo form_error('meta_keywords'); ?></td></td>
							  </tr>
							     <tr>
								<td width="140" align="right" valign="middle" class="field_title"><strong>  Meta Descriptions : </strong></td>
								<td align="left" valign="middle"><input id="meta_description" name="meta_description" type="text" class="textfield" style="width:250px;" value="<?php echo set_value('meta_description'); ?>"/><br /><?php echo form_error('meta_description'); ?></td></td>
							  </tr>
                            <tr>
								<td width="140" align="right" valign="top" class="field_title"><strong>Page Content : </strong></td>
								<td align="left" valign="middle">
                                    <textarea id="page_content" name="page_content" cols="10" rows="10" value="5"><?php echo set_value('page_content'); ?></textarea>
                                <?php echo form_error('page_content'); ?></td>
								</td>
							  </tr>
							  <!--<tr>
							    <td align="right" valign="middle" class="field_title"><strong>Picture :</strong></td>
							    <td align="left" valign="middle">
								<input type="file" name="img" id="img">&nbsp;&nbsp;&nbsp;(Allowed file type .gif, .jpg, .png, .jpeg)
								</td>
						      </tr>-->
							</table>
							<table width="100%" border="0" cellspacing="0" cellpadding="7">
							  <tr>
								<td width="140" align="right" valign="middle">&nbsp;</td>
								<td width="80" align="left" valign="middle">
                                    <input name="change_id" type="submit" class="button" value="Submit" /></td>
                                <td align="left" valign="middle"><input name="reset1" type="reset" class="button" value="Back" onclick="window.location.href='<?=base_url().'admin/home/display'?>';" /></td>
							  </tr>
							</table>
                       
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