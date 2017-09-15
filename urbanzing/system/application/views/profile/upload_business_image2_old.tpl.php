
	<?php if($old_values['business_category'] ==1 ):?>
		<script type="text/javascript">
			$(function()
			{
			  $('#upload_type_container').show();
			});
		</script>
	<?php endif;?>
		<script type="text/javascript">
			$(function()
			{
			  $("#upload_menu").show();
			  $("#upload_picture").hide();
			});
		</script>
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
         <input type="hidden" id="business_id" name="business_id" value="<?=$old_values['business_id']?>" />
		 <input type="hidden" id="business_category" name="business_category" value="<?=$old_values['business_category']?>" />
		 <table class="upload_picture" width="100%" border="0" cellspacing="0" cellpadding="0">
            
            <tr>
                <td align="right">Business Name <span style="color:#EB1018;">*</span></td>
                <td valign="top">
                   <input  type="text" name="business_name" id="business_name" value="<?=$old_values['business_name']?>" onkeyup="get_business_name(this.value);"/>
					<div class="suggestionsBox" id="suggestions" style="display: none;">
						<img src="<?php echo base_url(); ?>images/front/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="up" />
						<div class="suggestionList" id="autoSuggestionsList"></div>
					</div>
                </td>
            </tr>
			<tr>
				<td colspan="2" align="left">
					<div id="upload_type_container" style="display: none;">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="30%" height="30" align="right">What to upload ?<span style="color:#EB1018;">*</span></td>
								<td align="left">
									<input type="radio" name="upload_type" value="menu"  onclick="showOption(1);"/> Menu
									<input type="radio" name="upload_type" value="pic"   onclick="showOption(2);"/> Picture
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
			
            <tr>
               <td>&nbsp; </td>
                <td>
				      <div id="upload_menu" ><input id="img" name="img" type="file" /> </div></td>
            </tr>
			<tr>
                <td align="right"></td>
                <td >
				
					<div id = "upload_picture" >
						<span style="font-size: 10px;"></span><br />
						<input style="width:250px;" type="file" id="img1" name="img1" />
						<br/>
						<span style="color:#FF0000"> Only JPG files supported.
						 File size should be less than <?php echo $max_file_size ?> KB.</span>
						<div id="more_image_container" style="display:inline;"></div>
						<br/>
						<div id="more_upload_option">
							<a href="javascript:void(0);" onclick="showUploadPicsDiv();"><b>Click here to add more Pictures</b></a>
						</div>
					</div>	
				</td>
					
		<!--	</tr>
                <td height="40">&nbsp;</td>
                <td><input id="ck_tearms" name="ck_tearms" type="checkbox" /> <span>I Agree to <a href="#">Terms & Conditions</a></span></td>
            </tr>-->
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
            function showOption(option)
			{
				if( option == 1)
				{
					$("#upload_menu").show();
					$("#upload_picture").hide();
				}
				
				if( option == 2)
				{
					$("#upload_menu").hide();
					$("#upload_picture").show();
				}	
			}
			
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
			/*input string is given input by user*/
			function get_business_name(inputString)
			{
				
				if(inputString.length < 1) {
					// Hide the suggestion box.
					jQuery('#suggestions').hide();
				} else {
					jQuery.post("<?=base_url()?>ajax_controller/auto_complete_business_name/" + inputString + '/address' + '/biz_cat_id', {queryString: "" + inputString + ""}, function(data){
						if(data.length >0) {
							jQuery('#suggestions').show();
							jQuery('#autoSuggestionsList').html(data);
						}
						else
						{
							jQuery('#suggestions').hide();
						}
					});
				}
			}
			
			function fill(thisValue, id, category)
			{
				
				
				jQuery('#business_name').val(thisValue);
				jQuery('#business_id').val(id);
				jQuery('#business_category').val(category);
				if(category == 1 )
				{
					jQuery('#upload_type_container').show();
				}
				else
				{
					jQuery('#upload_type_container').hide();
					$("#upload_menu").hide();
					$("#upload_picture").show();
				}
				setTimeout("$('#suggestions').hide();", 200);
			}
			
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
    <div class="clear"></div>
    <div class="margin15"></div>
    <div class="margin15"></div>
</div>