<div class="edit_details">
    <script type="text/javascript">
        function show_red(id)
        {
            for(var i=1;i<=id;i++)
                document.getElementById('img'+i).src = '<?=base_url()?>images/front/rating_star.png';
        }

        function hied_red(id)
        {
            var select_now  = document.getElementById('star_rating').value;
            if((select_now*1)>0)
                id  = select_now;
            for(var i=5;i>id;i--)
                document.getElementById('img'+i).src = '<?=base_url()?>images/front/rating_star03.png';
    //        if(id==1)
    //            document.getElementById('img1').src='rating_star03.png';
        }

        function fix_pointer(id)
        {
            document.getElementById('star_rating').value    = id;
        }
    </script>
    <h1>Write review for business
        <div class="back_btn"><a href="<?=base_url().'profile'?>">Back</a></div></h1>
    <div class="margin15"></div>
    <h2><?=$content_text[0]['title']?></h2>
    <div class="margin15"></div>
    <?=html_entity_decode($content_text[0]['description'])?>
    <div class="margin15"></div>
    <h5>take some time and fill out the form below </h5>
    <div class="margin15"></div>
    <?
    $this->load->view('admin/common/message_page.tpl.php');
    ?>
    <form action="<?=base_url().'profile/save_review'?>" method="post" name="frm_review" id="frm_review" enctype="multipart/form-data" >
		<input type="hidden" id="business_id" name="business_id" value="<?=$old_values['business_id']?>" />
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
           
            <tr>
                <td valign="top" align="right">Business Name <span style="color:#EB1018;">*</span>
					
				</td>
                <td valign="top">
                   <input type="text" name="business_name" id="business_name" value="<?=$old_values['business_name']?>" onkeyup="return get_business_name(this.value);" />
				   
					<div class="suggestionsBox" id="suggestions" style="display: none;">
						<img src="<?php echo base_url(); ?>images/front/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="up" />
						<div class="suggestionList" id="autoSuggestionsList"></div>
					</div>
                </td>

            </tr>
            <tr>
                <td align="right" width="180">Review Title</td>
                <td><input type="text" id="review_title" name="review_title" value="<?=$old_values['review_title']?>" /></td>
            </tr>
            <tr>
                <td align="right" width="180">Rating </td>
                <td height="30">
                    <img style="cursor: pointer;" onclick="fix_pointer('1');" onmouseover="show_red('1');" onmouseout="hied_red('1');" src="<?=base_url()?>images/front/rating_star03.png" id="img1" alt=""/>
                    <img style="cursor: pointer;" onclick="fix_pointer('2');" onmouseover="show_red('2');" onmouseout="hied_red('2');" src="<?=base_url()?>images/front/rating_star03.png" id="img2" alt=""/>
                    <img style="cursor: pointer;" onclick="fix_pointer('3');" onmouseover="show_red('3');" onmouseout="hied_red('3');" src="<?=base_url()?>images/front/rating_star03.png" id="img3" alt=""/>
                    <img style="cursor: pointer;" onclick="fix_pointer('4');" onmouseover="show_red('4');" onmouseout="hied_red('4');" src="<?=base_url()?>images/front/rating_star03.png" id="img4" alt=""/>
                    <img style="cursor: pointer;" onclick="fix_pointer('5');" onmouseover="show_red('5');" onmouseout="hied_red('5');" src="<?=base_url()?>images/front/rating_star03.png" id="img5" alt=""/>
                    <input type="hidden" name="star_rating" id="star_rating" value="0"/>
                </td>
            </tr>
            <tr>
                <td valign="top" align="right">Review</td>
                <td><textarea id="comment" name="comment" ><?=$old_values['comment']?></textarea></td>
            </tr>
            <!--<tr>
                <td height="40" align="right">Upload pictures</td>
                <td><input type="file" id="img" name="img" /></td>
            </tr>-->
            <!--<tr>
                <td height="40">&nbsp;</td>
                <td><input id="ck_tearms" name="ck_tearms" type="checkbox" /> <strong>I Agree to <a href="#">Terms & Conditions</a></strong></td>
            </tr>-->
            <tr>
                <td>&nbsp;</td>
                <td style="padding-top:10px;"><input class="button_02" type="submit" value="Submit >>" />&nbsp;
                    <input onclick="window.location.href='<?=base_url().'profile'?>'" class="button_02" type="button" value="Cancel >>" />
                </td>
            </tr>
        </table>
        <script type="text/javascript">
            function fun_business_category(cat)
            {
                get_ajax_option_common('<?=base_url().'profile/get_business_type_ajax'?>',cat,'div_business_type');
            }

            function fun_business_id()
            {
                var cat_id  = document.getElementById('business_category').value;
                var type_id  = document.getElementById('business_type_id').value;
                get_ajax_option_common("<?=base_url().'profile/get_business_ajax'?>",type_id+'-'+cat_id,'div_business');
            }

			/*input string is given input by user*/
			function get_business_name(inputString)
			{
				if(inputString.length < 1) {
					// Hide the suggestion box.
					jQuery('#suggestions').hide();
				} else {
					jQuery.post("<?=base_url()?>ajax_controller/auto_complete_business_name/" + inputString + "/address", function(data){
						if(data.length > 0) {
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
			
			function fill(thisValue, id)
			{
				jQuery('#business_name').val(thisValue);
				jQuery('#business_id').val(id);
				setTimeout("jQuery('#suggestions').hide();", 200);
			}
        </script>
    </form>
    <div class="margin15"></div>
    <div class="margin15"></div>
</div>