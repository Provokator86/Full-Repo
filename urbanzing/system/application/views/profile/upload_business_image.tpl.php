<div class="sign_up">
    <h1>Upload Picture/menu
        <div class="back_btn"><a href="<?=base_url().'profile'?>">Back</a></div>
    </h1>
    <div class="margin15"></div>
    <h2><?=$content_text[0]['title']?></h2>
    <div class="margin15"></div>
    <?=html_entity_decode($content_text[0]['description'])?>
    <div class="margin15"></div>
    <?
    $this->load->view('admin/common/message_page.tpl.php');
    ?>
    <h6 style="color:#EB1018;">* marked fileds are mandatory</h6>
    <div class="margin15"></div>
    <form action="<?=base_url().'profile/upload_business_image_save'?>" method="post" name="frm_business" id="frm_business" enctype="multipart/form-data">
        <table class="upload_picture" width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="right">Business Category <span style="color:#EB1018;">*</span></td>
                <td>
                    <select id="business_category" name="business_category" onchange="fun_business_category(this.value);">
                        <option value="">Select a business category</option>
                        <?=$business_category?>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="right">Business Type <span style="color:#EB1018;">*</span></td>
                <td>
                    <div id="div_business_type">
                        <select id="business_type_id" name="business_type_id">
                            <option value="">Select a business type</option>
                            <?=$business_type?>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right">Business Name <span style="color:#EB1018;">*</span></td>
                <td>
                    <div id="div_business">
                        <select id="business_id" name="business_id">
                            <option value="">Select a business</option>
                            <?=$business_option?>
                        </select>
                    </div>
                </td>
            </tr>
			<tr>
				<td colspan="2" align="left">
					<div id="upload_type_container" style="display: none;">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="30%" height="30" align="right">What to upload ?</td>
								<td align="left">
									<input type="radio" name="upload_type" value="pic" /> Picture
									<input type="radio" name="upload_type" value="menu" checked="checked" /> Menu
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
			
            <tr>
                <td align="right">Picture <span style="color:#EB1018;">*</span></td>
                <td><input id="img" name="img" type="file" /></td>
            </tr>
            <tr>
                <td height="40">&nbsp;</td>
                <td><input id="ck_tearms" name="ck_tearms" type="checkbox" /> <span>I Agree to <a href="#">Terms & Conditions</a></span></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td height="30"><input class="button_02" type="submit" value="Submit >>" /> &nbsp;&nbsp;
                    <input class="button_02" type="reset" value="Reset >>" onclick="window.location.href='<?=base_url().'profile'?>'" /></td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
        </table>
        <script type="text/javascript">
            function fun_business_category(cat)
            {
                get_ajax_option_common('<?=base_url().'profile/get_business_type_ajax'?>',cat,'div_business_type');

				if (cat == 1) {
					jQuery("div#upload_type_container").show();
				}
				else {
					jQuery("div#upload_type_container").hide();
				}
            }

            function fun_business_id()
            {
                var cat_id  = document.getElementById('business_category').value;
                var type_id  = document.getElementById('business_type_id').value;
                get_ajax_option_common('<?=base_url().'profile/get_business_ajax'?>',type_id+'-'+cat_id,'div_business');
            }
        </script>
    </form>
    <div class="clear"></div>
    <div class="margin15"></div>
    <div class="margin15"></div>
</div>