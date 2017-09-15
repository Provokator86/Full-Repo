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
                        <table width="90%" border="0" cellspacing="0" cellpadding="0" style="margin-top:40px;">
                            <tr>
                                <td width="110" class="td_tab_main" align="center" valign="middle"><?=$table_title?></td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                        <table width="90%" border="0" cellspacing="0" cellpadding="10" style="border:1px solid #999999;">
                            <tr>
                                <td align="center" valign="middle">
<div class="sign_up">						
		 <?
			$this->load->view('admin/common/message_page.tpl.php');
		?>
 <form action="<?=base_url().'admin/user/update_user'?>" method="post" name="frm_edit" id="frm_edit" enctype="multipart/form-data">
    <table class="upload_picture" style="border-bottom:0px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td  align="right">First Name<strong>*</strong></td>
        <td><input id="f_name" name="f_name"  type="text" value="<?=$data['f_name']?>"/></td>
      </tr>
      <tr>
        <td  align="right">Last Name<strong>*</strong></td>
        <td><input id="l_name" name="l_name"  type="text" value="<?=$data['l_name']?>" /></td>
      </tr>
      <tr>
        <td  align="right">Screen name</td>
        <td><input id="screen_name" name="screen_name"  type="text" value="<?=$data['screen_name']?>"/></td>
      </tr>
      <tr>
        <td  align="right">Email<strong>*</strong></td>
        <td><input id="email" name="email"  type="text" value="<?=$data['email']?>"/></td>
      </tr>
      <tr>
        <td  align="right">Phone</td>
        <td><input id="phone" name="phone" type="text" value="<?=$data['phone']?>"/></td>
      </tr>
      <tr>
        <td align="right">Country<strong>*</strong></td>
        <td>
            <select id="country_id" name="country_id" onchange="fun_country(this.value);">
                <?=$country_option?>
            </select>        </td>
      </tr>
      <tr>
        <td align="right">State<strong>*</strong></td>
        <td>
            <div id="div_state">
                <select id="state_id" name="state_id" onchange="fun_state(this.value);">
                    <option value="">Select a state</option>
                    <?=$state_option?>
                </select>
            </div>        </td>
      </tr>
      <tr>
        <td  align="right">City<strong>*</strong></td>
        <td>
            <div id="div_city">
                <select id="city_id" name="city_id" onchange="fun_city(this.value);">
                    <option value="">Select a city</option>
                    <?=$city_option?>
                </select>
            </div>        </td>
      </tr>
      <tr>
        <td align="right">Pincode  <strong>*</strong></td>
        <td>
            <div id="div_zipcode">
                <select id="zipcode" name="zipcode">
                    <option value="">Select a pincode</option>
                    <?=$zipcode_option?>
                </select>
            </div>        </td>
      </tr>
      <tr>
        <td align="right">User type</td>
        <td><select name="user_type_id" id="user_type_id" style="width:290px;">
			<option value="">Select User Type</option>
			<?=$user_type_option?>
			</select></td>
      </tr>
      <tr>
        <td height="40" align="right">Gender</td>
        <td><input id="gender" name="gender" type="radio" value="M" <?=($data['gender']=='M')?'checked':''?> /> Male &nbsp; &nbsp;
            <input id="gender" name="gender" type="radio" value="F" <?=($data['gender']=='F')?'checked':''?>/>&nbsp; Femmale</td>
      </tr>
      <tr>
        <td align="right">Birthday</td>
        <td>
            <?=$dob?>        
        </td>
      </tr>
      <tr>
        <td align="right">Occupation</td>
        <td>
            <select id="occupation_id" name="occupation_id" style="width:290px;">
                <option value="">Select an occupation</option>
                <?=$occupation_option?>
            </select></td>
      </tr>
      <tr>
        <td align="right" valign="top">About yourself</td>
        <td><textarea id="about_yourself" name="about_yourself"><?=$data['about_yourself']?></textarea></td>
      </tr>
      <tr>
        <td align="right">Photo</td>
        <td><input name="img" id="img" type="file" /></td>
      </tr>
      <?
      if(isset($data['img_name']) && $data['img_name']!='')
      {
      ?>
      <tr>
            <td>&nbsp;</td>
            <td>
                <img src="<?=base_url()?>images/uploaded/user/thumb/<?=$data['img_name']?>" alt="" />
                <input type="hidden" name="img_name" id="img_name" value="<?=$data['img_name']?>"/>            </td>
      </tr>
      <?
      }
      ?>
      <tr>
        <td>&nbsp;</td>
        <td height="40">
		<input type="hidden" name="user_id" id="user_id" value="<?=$cur_user_id?>" />
		<input class="button" type="submit" value="Save" />&nbsp;&nbsp; 
		<input class="button" type="button" value="Back" onclick="window.location='<?=$redirect_url?>'" /></td>
      </tr>
      <tr>
            <td colspan="2">&nbsp;</td>
      </tr>
    </table>
        <script type="text/javascript">
            function fun_country(cat)
            {
                get_ajax_option_common('<?=base_url().'business/get_state_ajax'?>',cat,'div_state');
                get_ajax_option_common('<?=base_url().'business/get_city_ajax'?>',-1,'div_city');
                get_ajax_option_common('<?=base_url().'business/get_zipcode_ajax'?>',-1,'div_zipcode');
                get_ajax_option_common('<?=base_url().'business/get_price_ajax'?>',cat,'div_price');

            }

            function fun_state(cat)
            {
                get_ajax_option_common('<?=base_url().'business/get_city_ajax'?>',cat,'div_city');
                get_ajax_option_common('<?=base_url().'business/get_zipcode_ajax'?>',-1,'div_zipcode');
            }

            function fun_city(cat)
            {
                get_ajax_option_common('<?=base_url().'business/get_zipcode_ajax'?>',cat,'div_zipcode');
            }
        </script>
        </form>
		</div>							
									
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