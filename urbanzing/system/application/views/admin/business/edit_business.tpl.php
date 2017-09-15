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
						<div class="edit_details">
                            <form action="<?=base_url().'admin/business/save_business_edit'?>" method="post" name="frm_business" id="frm_business" enctype="multipart/form-data">
								<input type="hidden" name="counter_menu_image" id="counter_menu_image" value="1"/>
								<input type="hidden" name="counter_img" id="counter_img" value="1"/>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="right" width="180">Bussiness Name <span>*</span></td>
                <td><input id="name" name="name" type="text" value="<?=$data['name']?>" /></td>
            </tr>
            <tr>
                <td align="right">Business Category <span>*</span></td>
                <td>
                    <select id="business_category" name="business_category" onchange="fun_business_category(this.value);">
                        <option value="">Select a business category</option>
                        <?=$business_category?>
                    </select>                </td>
            </tr>
            <tr>
                <td align="right">Business Type <span>*</span></td>
                <td>
                    <div id="div_business_type">
                        <select id="business_type_id" name="business_type_id">
                            <option value="">Select a business type</option>
                            <?=$business_type?>
                        </select>
                    </div>                </td>
            </tr>
            <tr>
                <td align="right" >Street Address <span>*</span></td>
                <td><input id="address" name="address" type="text" value="<?=$data['address']?>"/></td>
            </tr>
            <tr>
                <td align="right" >Country <span>*</span></td>
                <td>
                    <select id="country_id" name="country_id" onchange="fun_country(this.value);">
                        <?=$country_option?>
                    </select>                </td>
            </tr>
            <tr>
                <td align="right" >State <span>*</span></td>
                <td>
                    <div id="div_state">
                        <select id="state_id" name="state_id" onchange="fun_state(this.value);">
                            <option value="">Select a state</option>
                            <?=$state_option?>
                        </select>
                    </div>                </td>
            </tr>
            <tr>
                <td align="right">City <span>*</span></td>
                <td>
                    <div id="div_city">
                        <select id="city_id" name="city_id" onchange="fun_city(this.value);">
                            <option value="">Select a city</option>
                            <?=$city_option?>
                        </select>
                    </div>                </td>
            </tr>
            <tr>
                <td align="right">Pincode <span>*</span></td>
                <td>
                    <div id="div_zipcode">
                        <select id="zipcode" name="zipcode">
                            <option value="">Select a pincode</option>
                            <?=$zipcode_option?>
                        </select>
                    </div>                </td>
            </tr>
            <tr>
                <td align="right" >Land Mark</td>
                <td><input id="land_mark" name="land_mark" type="text" value="<?=$data['land_mark']?>"/></td>
            </tr>
            <tr>
                <td align="right">Phone Number <span>*</span></td>
                <td><input id="phone_number" name="phone_number" type="text" value="<?=$data['phone_number']?>"/></td>
            </tr>
            <tr>
                <td align="right">Website URL</td>
                <td><input id="website" name="website" type="text" value="<?=$data['website']?>"/></td>
            </tr>
            <tr>
                <td align="right">Contact Person</td>
                <td><input id="contact_person" name="contact_person" type="text" value="<?=$data['contact_person']?>"/></td>
            </tr>
            <tr>
                <td align="right">Contact Email</td>
                <td><input id="contact_email" name="contact_email" type="text" value="<?=$data['contact_email']?>"/></td>
            </tr>
            <tr class="open_area"  style="display: <?=($data['business_category']==1)?'':'none'?>;">
                <td align="right">Average Prices </td>
                <td>
                    <div id="div_price">
                        <select id="price_range_id" name="price_range_id">
                            <?=$price_option?>
                        </select>
                    </div>                </td>
            </tr>
            <tr>
                <td align="left" valign="top" width="100%" colspan="2">
                    <div id="div_cuisine"  class="open_area"  style="display: <?=($data['business_category']==1)?'':'none'?>;">
                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                            <tr>
                                <td align="right" valign="top" width="200">Cuisine</td>
                                <td><select id="cuisine_id" name="cuisine_id[]" style="height:80px;" multiple="multiple" size="10">
                                    <?=$cuisine_option?>
                                </select></td>
                            </tr>
                        </table>
                    </div>                </td>
            </tr>
            <tr>
                <td align="left" valign="top" width="100%" colspan="2">
                   <div id="div_other_cuisine" class="open_area"  style="display: <?=($data['business_category']==1)?'':'none'?>;">
                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                            <tr>
                                <td align="right" width="200">Other Cuisine</td>
                                <td>
                                    <input id="other_cuisine" name="other_cuisine" type="text" value="<?=$data['other_cuisine']?>"/>                                </td>
                            </tr>
                        </table>
                    </div>                </td>
            </tr>
            <tr>
                <td align="right" valign="top">Hours of operation</td>
                <td>
                    <?=$hour_option?>
				</td>
            </tr>
            <tr>
                <td align="right">Additional Information</td>
                <td>
                    <span style="font-size: 10px;">e.g. Closed on Sunday, Closed from 2:30pm to 5:30pm everyday</span><br/>
                    <input id="hour_comment" name="hour_comment" type="text" value="<?=$data['hour_comment']?>"/>
                </td>
            </tr>
            <tr>
                <td align="right" >Tags </td>
                <td><input type="text" id="tags" name="tags" value="<?=$data['tags']?>" /></td>
            </tr>
            <tr>
                <td  height="30" align="right">Do you accept Credit Cards? </td>
                <td>
                    <input type="radio" id="credit_card" name="credit_card" <?=($data['credit_card']==1)?' checked ':''?> value="1" /> Yes
                    <input type="radio" id="credit_card" name="credit_card" <?=($data['credit_card']==0)?' checked ':''?> value="0"/> No                </td>
            </tr>
            <tr  class="open_area"  style="display: <?=($data['business_category']==1)?'':'none'?>;">
                <td  height="30" align="right">Do you deliver: yes/no? </td>
                <td>
                    <input type="radio" id="delivery" name="delivery" <?=($data['delivery']==1)?' checked ':''?> value="1" /> Yes
                    <input type="radio" id="delivery" name="delivery" <?=($data['delivery']==0)?' checked ':''?> value="0"/> No </td>
            </tr>
            <tr  class="open_area"  style="display: <?=($data['business_category']==1)?'':'none'?>;">
                <td  height="30" align="right">Do you serve Vegetarian?  </td>
                <td>
                    <input type="radio" id="vegetarian" name="vegetarian" <?=($data['vegetarian']==1)?' checked ':''?> value="1" /> Yes
                    <input type="radio" id="vegetarian" name="vegetarian" <?=($data['vegetarian']==0)?' checked ':''?> value="0"  /> No </td>
            </tr>
            <tr>
                <td  height="30" align="right">Parking available?  </td>
                <td><input type="radio" id="parking" name="parking" <?=($data['parking']==1)?' checked ':''?> value="1" /> Yes
                    <input type="radio" id="parking" name="parking" <?=($data['parking']==0)?' checked ':''?> value="0"/> No </td>
            </tr>
            <tr class="open_area"  style="display: <?=($data['business_category']==1)?'':'none'?>;">
                <td  height="30" align="right">Do you take reservations?  </td>
                <td><input type="radio" id="take_reservation" name="take_reservation" <?=($data['take_reservation']==1)?' checked ':''?> value="1" /> Yes
                    <input id="take_reservation" name="take_reservation" value="0" <?=($data['take_reservation']==0)?' checked ':''?> type="radio" /> No </td>
            </tr>
            <tr>
                <td  height="30" align="right">Air Conditioned?   </td>
                <td><input type="radio" id="air_conditioned" name="air_conditioned" <?=($data['air_conditioned']==1)?' checked ':''?> value="1" /> Yes
                    <input id="air_conditioned" name="air_conditioned" <?=($data['air_conditioned']==0)?' checked ':''?> value="0" type="radio" /> No </td>
            </tr>
            <tr class="open_area"  style="display: <?=($data['business_category']==1)?'':'none'?>;">
                <td  height="30" align="right">Do you serve alcohol?</td>
                <td><input type="radio" id="serving_alcohol" name="serving_alcohol" <?=($data['serving_alcohol']==1)?' checked ':''?> value="1" /> Yes
                    <input id="serving_alcohol" name="serving_alcohol" value="0" <?=($data['serving_alcohol']==0)?' checked ':''?> type="radio" /> No </td>
            </tr>
			 <tr>
              <td  height="30" align="right">Status</td>
              <td>
			  <select name="status" id="status">
			  <?=$business_status?>
			  </select>
			  </td>
            </tr>

			<?php
				if($data['is_featured']=='Y'){
			?>
            <tr>
              <td  height="30" align="right">Editorial Comment </td>
              <td><textarea name="editorial_comments"><?=$data['editorial_comments']?></textarea></td>
            </tr>
			<?php } ?>
            <tr>
                <td align="left" valign="top" width="100%" colspan="2">
                    <div id="div_menu" class="open_area"  style="display: <?=($data['business_category']==1)?'':'none'?>;">
                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                            <tr>
                                <td  align="right" width="200">Upload Menu</td>
                                <td>
									<input type="file" id="menu_image_name1" name="menu_image_name1" style=" width:auto;" />
									<br/>
									<span>
										Only JPG files supported.
										File size should be less than <?php echo $max_file_size ?> KB.
					 				</span>
									<div id="more_menu_image_container" style="display:inline;"></div>
									<br/>
									<span id="more_upload_menu_image_option">
										<a href="javascript:void(0);" onclick="showUploadDiv();">Click here to add more pages to the Menu</a>
									</span>
								</td>
                            </tr>
                            <?php
							if (isset($arr_menu_list) && !empty($arr_menu_list)) {
							?>
							<tr>
								<td>&nbsp;</td>
								<td align="left" valign="middle">
							<?php
								foreach ((array) $arr_menu_list as $key => $val) {
							?>
									<div style="display: block; margin-top: 5px;" id="menu_view_image_container_<?php echo $val['id']; ?>">
										<img src="<?php echo base_url().'images/uploaded/business/thumb/'.$val['img_name']; ?>" alt="" />
										<img onclick="delete_image('menu', '<?php echo $val['id']; ?>', 'menu_view_image_container_<?php echo $val['id']; ?>');" src="<?php echo base_url().'images/admin/trash.gif'; ?>" alt="Delete" style="cursor:pointer;" />
										
									</div>
							<?php } ?>
 								</td>
							</tr>
							<?php } ?>
                       </table>
                    </div>
				</td>
            </tr>
            <tr>
                <td align="right">Upload pictures</td>
                <td>
					<input type="file" id="img1" name="img1" style=" width:auto;" />
					<br/>
						<span>
							Only JPG files supported.
							File size should be less than <?php echo $max_file_size ?>KB.
					 	</span>
					<div id="more_image_container" style="display:inline;"></div>
					<br/>
					<span id="more_upload_option">
						<a href="javascript:void(0);" onclick="showUploadPicsDiv();">Click here to add more Pictures</a>
					</span>
				</td>
            </tr>

			<?php if (isset($arr_biz_pics) && !empty($arr_biz_pics)) { ?>
			<tr>
				<td>&nbsp;</td>
				<td align="left" valign="middle">
			<?php
				foreach ((array) $arr_biz_pics as $key => $val) {
			?>
					<div style="display: block; margin-top: 5px;" id="pic_view_image_container_<?php echo $val['id']; ?>">
						<img src="<?php echo base_url().'images/uploaded/business/thumb/'.$val['img_name']; ?>" alt="" />
						<img onclick="delete_image('pic', '<?php echo $val['id']; ?>', 'pic_view_image_container_<?php echo $val['id']; ?>');" src="<?php echo base_url().'images/admin/trash.gif'; ?>" alt="Delete" style="cursor:pointer;" />
					</div>
			<?php } ?>
				</td>
			</tr>
			<?php } ?>
			
            <tr>
                <td>&nbsp;</td>
                <td style="padding-top:10px;">
                    <input type="hidden" id="id" name="id" value="<?=$data['id']?>" />
                    <input class="button_02" type="submit" value="Submit >>" /> &nbsp;&nbsp;
                    <input class="button_02" type="button" value="<< Back" onclick="window.location.href='<?=$redirect_url?>'" />
				</td>
            </tr>
        </table>
        <script type="text/javascript">
            function fn_hour_from(value,key)
            {
                document.getElementById('hour_to'+key).style.display   = 'none';
                if(value!='' && value!='closed')
                    document.getElementById('hour_to'+key).style.display   = 'block';
            }

            function fun_business_category(cat)
            {
                get_ajax_option_common('<?=base_url().'business/get_business_type_ajax'?>',cat,'div_business_type');
/*                document.getElementById('div_other_cuisine').style.display   = 'none';
                document.getElementById('div_cuisine').style.display   = 'none';
                document.getElementById('div_menu').style.display   = 'none';*/ 
				$('.open_area').hide();
				if((cat*1)==1)
                {
                    $('.open_area').show();
                }
            }
            
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
				get_ajax_option_common('<?php echo base_url().'business/delete_biz_image/';?>' + target, id, container_name);
				$("#" + container_name).children().remove();
			}


			/**
			 * Start of Upload Menu Section
			 */
			var counterUpload = 1;
			var markerUpload = 1;
			var maxUpload = parseInt(<?=$no_of_menu?>) + 1;

			function showUploadDiv() {
				if (markerUpload < maxUpload) {
					counterUpload++;
					markerUpload++;
					jQuery('<div style="margin-top:5px; margin-bottom:5px;" id="menu_image_container_'+ counterUpload +'"><input id="menu_image_name' + counterUpload + '" name="menu_image_name' + counterUpload + '" type="file" style="width: auto;" />&nbsp;<img src="' + base_url + 'images/admin/trash.gif" onclick="hideUploadDiv(\'menu_image_container_'+ counterUpload +'\')" alt="Delete" style="cursor:pointer;" /></div>').appendTo("#more_menu_image_container");

					if (markerUpload == (maxUpload - 1)) {
						jQuery("#more_upload_menu_image_option").css("display", "none");
					}

					jQuery("#counter_menu_image").val(counterUpload);
				}
			}

			function hideUploadDiv(id) {
				jQuery("#" + id).remove();
				markerUpload--;
				jQuery("#more_upload_menu_image_option").css("display", "");
				jQuery("#counter_menu_image").val(counterUpload);
			}
			/**
			 * End of Upload Menu Section
			 */


			/**
			 * Start of Upload Pictures Section
			 */
			var counterUploadPics = 1;
			var markerUploadPics = 1;
			var maxUploadPics = parseInt(<?=$no_of_menu?>) + 1;

			function showUploadPicsDiv() {
				if (markerUploadPics < maxUploadPics) {
					counterUploadPics++;
					markerUploadPics++;
					jQuery('<div style="margin-top:5px; margin-bottom:5px;" id="img_container_'+ counterUploadPics +'"><input id="img' + counterUploadPics + '" name="img' + counterUploadPics + '" type="file" style="width: auto;" />&nbsp;<img src="' + base_url + 'images/admin/trash.gif" onclick="hideUploadPicsDiv(\'img_container_'+ counterUploadPics +'\')" alt="Delete" style="cursor:pointer;" /></div>').appendTo("#more_image_container");

					if (markerUploadPics == (maxUploadPics - 1)) {
						jQuery("#more_upload_option").css("display", "none");
					}

					jQuery("#counter_img").val(counterUploadPics);
				}
			}

			function hideUploadPicsDiv(id) {
				jQuery("#" + id).remove();
				markerUploadPics--;
				jQuery("#more_upload_option").css("display", "");
				jQuery("#counter_img").val(counterUploadPics);
			}
			/**
			 * End of Upload Pictures Section
			 */
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