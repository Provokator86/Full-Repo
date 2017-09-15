<div class="sign_up">
    <h1>Hello <?=$this->session->userdata('user_username')?>
        <div class="back_btn"><a href="<?=base_url().'profile'?>">Back</a></div></h1>
    <div class="margin15"></div>
    <h2><?=$edit_user_text[0]['title']?></h2>
    <div class="margin15"></div>
    <?=html_entity_decode($edit_user_text[0]['description'])?>
    <div class="margin15"></div>
    <?
    $this->load->view('admin/common/message_page.tpl.php');
    ?>
    <form action="<?=base_url().'profile/edit_profile_save'?>" method="post" name="frm_edit" id="frm_edit" enctype="multipart/form-data">
    <table class="upload_picture" style="border-top:1px dotted #ccc; border-bottom:0px;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr><td colspan="2">&nbsp;</td></tr>
      <tr>
            <td width="140"><h3>Personal Profile</h3></td>
         <td align="right"><h6>* marked fileds are mandatory</h6></td>
      </tr>
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
        <td align="right">Country</td>
        <td>
            <select id="country_id" name="country_id" onchange="fun_country(this.value);">
                <?=$country_option?>
            </select>
        </td>
      </tr>
      <tr>
        <td align="right">State</td>
        <td>
            <div id="div_state">
                <select id="state_id" name="state_id" onchange="fun_state(this.value);">
                    <option value="">Select a state</option>
                    <?=$state_option?>
                </select>
            </div>
        </td>
      </tr>
      <tr>
        <td  align="right">City</td>
        <td>
            <div id="div_city">
                <select id="city_id" name="city_id" onchange="fun_city(this.value);">
                    <option value="">Select a city</option>
                    <?=$city_option?>
                </select>
            </div>
        </td>
      </tr>
      <tr>
        <td align="right">Pincode  </td>
        <td>
            <div id="div_zipcode">
                <select id="zipcode" name="zipcode">
                    <option value="">Select a pincode</option>
                    <?=$zipcode_option?>
                </select>
            </div>
        </td>
      </tr>
      <tr>
        <td height="40" align="right">Gender</td>
        <td><input id="gender" name="gender" type="radio" value="M" <?=($data['gender']=='M')?'checked':''?> /> Male &nbsp; &nbsp;
            <input id="gender" name="gender" type="radio" value="F" <?=($data['gender']=='F')?'checked':''?>/>&nbsp; Female</td>
      </tr>
      <tr>
        <td align="right">Birthday</td>
        <td>
            <?php echo $dob;?>
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
               <div style="display: block; margin-top: 5px;" id="pic_view_image_container_<?php echo $user_id; ?>"> <img src="<?php echo $this->config->item('view_image_folder_user').$this->config->item('image_folder_thumb').$data['img_name']; ?>" alt="" />
                <input type="hidden" name="img_name" id="img_name" value="<?=$data['img_name']?>"/>
				<img title ="delete profile picture"onclick="delete_image('pic', '<?php echo $user_id; ?>', 'pic_view_image_container_<?php echo $user_id; ?>');" src="<?php echo base_url().'images/admin/trash.gif'; ?>" alt="Delete" style="cursor:pointer;" />
			  </div>
			   </td>
      </tr>
      <?



      }
	  if($data['face_book_connect']=='N') {
      ?>
      <tr>
        <td><h3>Change password</h3></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td  align="right">Old Password <strong>*</strong></td>
        <td><input id="o_password" name="o_password"  type="password" /></td>
      </tr>
      <tr>
        <td  align="right">New Password <strong>*</strong></td>
        <td><input id="password" name="password"  type="password" /></td>
      </tr>
      <tr>
        <td  align="right">Confirm New Password <strong>*</strong></td>
        <td><input id="c_password" name="c_password" type="password" /></td>
      </tr>
	  <?php } ?>
      <tr>
        <td>&nbsp;</td>
        <td height="40"><input class="button_02" type="submit" value="Save >>" />&nbsp;&nbsp; <input class="button_02" type="submit" value="Reset >>" /></td>
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

			function delete_image(target, id, container_name)
			{
				//alert(container_name);exit;
				get_ajax_option_common('<?php echo base_url().'profile/delete_user_image/';?>' + target, id, container_name);
				$("#" + container_name).children().remove();
			}
        </script>
        </form>
    <div class="clear"></div>
    </div>